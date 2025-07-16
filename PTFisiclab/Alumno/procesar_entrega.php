<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>
    <?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'alumno') {
    die("⛔ Acceso no autorizado.");
}

$alumno_id = $_SESSION['id_usuario'];
$tarea_id = $_POST['tarea_id'];

$conexion = new mysqli("localhost", "root", "", "usuarios_fl");
if ($conexion->connect_error) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}

$archivo_nombre = $_FILES['archivo']['name'];
$archivo_tmp = $_FILES['archivo']['tmp_name'];
$destino = "../entregas/" . basename($archivo_nombre);

if (move_uploaded_file($archivo_tmp, $destino)) {
    $stmt = $conexion->prepare("INSERT INTO Entregas (tarea_id, alumno_id, archivo) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $tarea_id, $alumno_id, $destino);
    $stmt->execute();
    $stmt->close();

    echo "✅ Archivo subido exitosamente. <a href='ver_tareas_al.php'>Volver a tareas</a>";
} else {
    echo "❌ Error al subir el archivo.";
}

?>

    
</body>
</html>
