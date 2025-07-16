<?php
session_start();

// Verifica que sea un maestro
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'maestro') {
    die("⛔ Acceso denegado.");
}
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "usuarios_fl");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Diccionario de temas
$temas = [
    "tema1" => "Caída Libre",
    "tema2" => "Conductividad Eléctrica",
    "tema3" => "Ley de Gravitación Universal",
    "tema4" => "Segunda Ley de Newton",
    "tema5" => "Principio de Arquímedes",
    "tema6" => "Movimiento Rectilíneo Uniforme"
];
?>

<!DOCTYPE html>
<html lang="es">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=AR+One+Sans:wght@400..700&display=swap" rel="stylesheet">
<head>
    <meta charset="UTF-8">
    <title>Tareas agrupadas por tema</title>
    <style>
        body {
            font-family: 'AR One Sans', sans-serif;
        }
        h2 {
            background-color: #f1f1f1;
            padding: 10px;
            margin-top: 40px;
        }
        table {
            width: 90%;
            border-collapse: collapse;
            margin: 10px auto 40px auto;
        }
        th, td {
            padding: 10px;
            border: 1px solid #999;
        }
        th {
            background-color: #eaeaea;
        }
        a {
            color: #007bff;
        }
    </style>
</head>
<body>

<div id="header-placeholder"></div>
<h1 style="text-align:center;">📚 Tareas</h1>

<?php foreach ($temas as $codigo => $nombre): ?>
    <h2><?= $nombre ?></h2>

    <?php
    $stmt = $conexion->prepare("SELECT * FROM Tarea WHERE tema = ? ORDER BY fecha_fin ASC");
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $resultado = $stmt->get_result();
    ?>

    <?php if ($resultado->num_rows > 0): ?>
        <table>
           <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Archivo</th>
                    <th>Fecha de inicio</th>
                    <th>Fecha de entrega</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
<?php while ($fila = $resultado->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($fila["descripcion"]) ?></td>
        <td>
            <?php if ($fila["archivo"]): ?>
                <a href="<?= $fila["archivo"] ?>" target="_blank">📎 Ver archivo</a>
            <?php else: ?>
                Sin archivo
            <?php endif; ?>
        </td>
        <td><?= $fila["fecha_inicio"] ?></td>
        <td><?= $fila["fecha_fin"] ?></td>
        <td>
            <a href="editar_tarea.php?id=<?= $fila['id'] ?>">
                <button style="background-color:#12355B; color:white; border:none; padding:5px 10px; border-radius:5px; cursor:pointer;">Editar</button>
            </a>
        </td>
    </tr>
<?php endwhile; ?>

            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No hay tareas registradas en este tema.</p>
    <?php endif; ?>

    <?php $stmt->close(); ?>
<?php endforeach; ?>

<?php $conexion->close(); ?>

<div id="footer-placeholder"></div>
</body>
<script>
    fetch('../header_docente.html')
      .then(res => res.text())
      .then(data => {
        document.getElementById('header-placeholder').innerHTML = data;
      });

      fetch('../footer.html')
      .then(res => res.text())
      .then(data => {
        document.getElementById('footer-placeholder').innerHTML = data;
      });
    </script>
</html>
