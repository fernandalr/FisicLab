
<?php
session_start();

// Verifica que sea un maestro
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'maestro') {
    die("⛔ Acceso denegado.");
}

$conexion = new mysqli("localhost", "root", "", "usuarios_fl");
if ($conexion->connect_error) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}

// Obtener todas las entregas
$sql = "SELECT 
            Entregas.id AS entrega_id,
            Entregas.archivo,
            Entregas.fecha_entrega,
            Entregas.calificacion,
            Tarea.descripcion AS descripcion_tarea,
            usuarios.email AS alumno_email
        FROM Entregas
        JOIN Tarea ON Entregas.tarea_id = Tarea.id
        JOIN usuarios ON Entregas.alumno_id = usuarios.id
        ORDER BY Entregas.fecha_entrega DESC";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calificar Entregas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=AR+One+Sans:wght@400..700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'AR One Sans', sans-serif;
            background-color:rgb(255, 255, 255);
            color: black;
            margin: 0;
            padding: 20px;
        }
        table { width: 90%; margin: auto; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: orange; color: white; }
        h1 { text-align: center; }
        form { display: inline-block; }
    </style>
</head>
<body>
<?php include '../header_docente.html'; ?>
<h1>📋 Calificación de Tareas</h1>

<?php if ($resultado->num_rows > 0): ?>
    <table>
        <tr>
            <th>Alumno</th>
            <th>Tarea</th>
            <th>Archivo</th>
            <th>Fecha de entrega</th>
            <th>Calificación</th>
            <th>Acción</th>
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($fila['alumno_email']) ?></td>
                <td><?= htmlspecialchars($fila['descripcion_tarea']) ?></td>
                <td><a href="<?= $fila['archivo'] ?>" target="_blank">📎 Ver</a></td>
                <td><?= $fila['fecha_entrega'] ?></td>
                <td>
                    <form method="POST" action="procesar_calificacion.php">
                        <input type="hidden" name="entrega_id" value="<?= $fila['entrega_id'] ?>">
                        <input type="number" name="calificacion" min="0" max="10" step="0.1"
                            value="<?= $fila['calificacion'] ?? '' ?>" required>
                </td>
                <td>
                        <button type="submit">Guardar</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p style="text-align:center;">No hay entregas registradas.</p>
<?php endif; ?>
<?php include '../footer.html'; ?>

<?php $conexion->close(); ?>
</body>
</html>

