<?php 
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'alumno') {
    die("⛔ Acceso no autorizado.");
}



$conexion = new mysqli("localhost", "root", "", "usuarios_fl");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$tarea_id = $_GET['id'] ?? null;
$usuario_id = $_SESSION['id_usuario'] ?? null;

if (!$tarea_id) {
    die("ID de tarea no proporcionado.");
}

$stmt = $conexion->prepare("SELECT * FROM Tarea WHERE id = ?");
$stmt->bind_param("i", $tarea_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("Tarea no encontrada.");
}

$tarea = $resultado->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    
    <title>Entregar tarea</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=AR+One+Sans:wght@400..700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'AR One Sans', sans-serif;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
            color: black;
        }
        p {
            text-align: center;
            color: #555;
        }
        table{
            font-family: 'AR One Sans', sans-serif;
            border: 1px solid #ddd;
            width: 90%;
            border-collapse: collapse;
            margin: 20px auto;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .formulario-entrega {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        button {
            background-color:#06A77D;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="header-placeholder"></div>
    
    <h1>📚 Entregar tarea</h1>
    
    
    <table>
        <tr>
            <th>Descripción</th>
            <th>Archivo</th>
            <th>Fecha de inicio</th>
            <th>Fecha de entrega</th>
        </tr>
        <tr>
            
            <td><?= htmlspecialchars($tarea['descripcion']) ?></td>
            <td>
                <?php if ($tarea['archivo']): ?>
                    <a href="<?= htmlspecialchars($tarea['archivo']) ?>" target="_blank">📎 Ver archivo</a>
                <?php else: ?>
                    Sin archivo
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($tarea['fecha_inicio']) ?></td>
            <td><?= htmlspecialchars($tarea['fecha_fin']) ?></td>
        </tr>   
    </table>
    <div class="formulario-entrega">
         <form action="procesar_entrega.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="tarea_id" value="<?= $tarea_id ?>">
        <label for="archivo">Selecciona tu archivo:</label><br>
        <input type="file" name="archivo" required><br><br>
        <button type="submit">Enviar tarea</button>
    </form>
    </div>

    <button style="background-color: #F19138; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; 
            display: block; margin: 20px auto;">
        <a href="ver_tareas_al.php" style="color: white; text-decoration: none;">Volver a mis tareas</a>
    </button>

<script>
    fetch('../header.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('header-placeholder').innerHTML = data;
            })
    fetch('../footer.html')
            .then(response => response.text())
            .then(data => {
                document.body.insertAdjacentHTML('beforeend', data);
            });
       
</script>
    
</body>
</html>
