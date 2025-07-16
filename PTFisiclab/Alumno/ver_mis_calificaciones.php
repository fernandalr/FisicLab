<?php
session_start();

// Validar que sea un alumno
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'alumno') {
    die("⛔ Acceso denegado.");
}

$alumno_id = $_SESSION['id_usuario'];

$conexion = new mysqli("localhost", "root", "", "usuarios_fl");
if ($conexion->connect_error) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}

// Consultar entregas del alumno
$sql = "SELECT 
            Entregas.archivo,
            Entregas.fecha_entrega,
            Entregas.calificacion,
            Tarea.descripcion AS descripcion_tarea
        FROM Entregas
        JOIN Tarea ON Entregas.tarea_id = Tarea.id
        WHERE Entregas.alumno_id = ?
        ORDER BY Entregas.fecha_entrega DESC";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $alumno_id);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Calificaciones</title>
    <style>
        table { width: 90%; margin: auto; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #28a745; color: white; }
        h1 { text-align: center; margin-top: 40px; }
    </style>
</head>
<body>
<?php include '../header.html'; ?>
<h1>📘 Mis Calificaciones</h1>

<?php if ($resultado->num_rows > 0): ?>
    <table>
        <tr>
            <th>Tarea</th>
            <th>Archivo</th>
            <th>Fecha de entrega</th>
            <th>Calificación</th>
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($fila['descripcion_tarea']) ?></td>
                <td><a href="<?= $fila['archivo'] ?>" target="_blank">📎 Ver archivo</a></td>
                <td><?= $fila['fecha_entrega'] ?></td>
                <td>
                    <?= is_null($fila['calificacion']) ? "⏳ Pendiente" : number_format($fila['calificacion'], 1) ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p style="text-align:center;">Aún no has entregado ninguna tarea.</p>
<?php endif; ?>
<?php include '../footer.html'; ?>
<?php
$stmt->close();
$conexion->close();
?>
</body>
</html>
