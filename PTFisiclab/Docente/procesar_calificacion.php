<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'maestro') {
    die("⛔ Acceso no autorizado.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $entrega_id = $_POST['entrega_id'];
    $calificacion = $_POST['calificacion'];

    $conexion = new mysqli("localhost", "root", "", "usuarios_fl");
    if ($conexion->connect_error) {
        die("❌ Error de conexión: " . $conexion->connect_error);
    }

    $stmt = $conexion->prepare("UPDATE Entregas SET calificacion = ? WHERE id = ?");
    $stmt->bind_param("di", $calificacion, $entrega_id);

    if ($stmt->execute()) {
        header("Location: ver_tareas.php?ok=1");
        exit;
    } else {
        echo "❌ Error al guardar la calificación.";
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "❌ Método no permitido.";
}
?>
