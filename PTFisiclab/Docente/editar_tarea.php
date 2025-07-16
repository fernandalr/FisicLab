<?php
$conexion = new mysqli("localhost", "root", "", "usuarios_fl");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Validar que venga el ID
if (!isset($_GET['id'])) {
    die("ID de tarea no especificado.");
}

$id = intval($_GET['id']);

// Obtener datos actuales de la tarea
$stmt = $conexion->prepare("SELECT * FROM Tarea WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("Tarea no encontrada.");
}

$tarea = $resultado->fetch_assoc();
$stmt->close();

// Actualizar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $descripcion = $_POST['descripcion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $tema = $_POST['tema']; // Si quieres permitir cambiar el tema

    // Manejo de archivo nuevo (opcional)
    $archivo_path = $tarea['archivo'];
    if (!empty($_FILES['archivo']['name'])) {
        $archivo_nombre = basename($_FILES["archivo"]["name"]);
        $archivo_path = "uploads/" . $archivo_nombre;
        move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo_path);
    }

    $stmt = $conexion->prepare("UPDATE Tarea SET descripcion = ?, fecha_inicio = ?, fecha_fin = ?, archivo = ?, tema = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $descripcion, $fecha_inicio, $fecha_fin, $archivo_path, $tema, $id);
    
    if ($stmt->execute()) {
       echo "<script>window.alert('🟢 Tarea actualizada correctamente.');</script>";
       echo "<script>window.location.href = 'ver_tareas.php';</script>";
       exit();

    } else {
        echo "<p style='color: red;'>❌ Error al actualizar tarea: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Manejo de eliminación de tarea
if (isset($_POST['eliminar'])) {
    // Obtener la ruta del archivo antes de eliminar la tarea
    $stmt_archivo = $conexion->prepare("SELECT archivo FROM Tarea WHERE id = ?");
    $stmt_archivo->bind_param("i", $id);
    $stmt_archivo->execute();
    $stmt_archivo->bind_result($archivo);
    $stmt_archivo->fetch();
    $stmt_archivo->close();

    // Eliminar archivo si existe
    if (!empty('/PTFisiclab/Docente/uploads/' . basename($archivo)) && file_exists('/PTFisiclab/Docente/uploads/' . basename($archivo))) {
        unlink('/PTFisiclab/Docente/uploads/' . basename($archivo)); // Esto elimina el archivo del servidor
    }

    // Ahora eliminamos la tarea
    $stmt = $conexion->prepare("DELETE FROM Tarea WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>window.alert('🟥 Tarea y archivo eliminados correctamente.');</script>";
        echo "<script>window.location.href = 'ver_tareas.php';</script>";
        exit();
    } else {
        echo "<p style='color: red;'>❌ Error al eliminar tarea: " . $stmt->error . "</p>";
    }
    $stmt->close();
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarea</title>
    <style>
        body {
            font-family: 'AR One Sans', sans-serif;
            padding: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 12px;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 20px;
            background-color: #12355B;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background-color: #FFA500;
            color: black;
        }
    </style>
</head>
<body>
    <h2>Editar Tarea</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" required><?= htmlspecialchars($tarea['descripcion']) ?></textarea>

        <label for="archivo">Archivo (dejar vacío si no cambia):</label>
        <input type="file" name="archivo">

        <label for="fecha_inicio">Fecha de inicio:</label>
        <input type="date" name="fecha_inicio" value="<?= $tarea['fecha_inicio'] ?>" required>

        <label for="fecha_fin">Fecha de entrega:</label>
        <input type="date" name="fecha_fin" value="<?= $tarea['fecha_fin'] ?>" required>

        <label for="tema">Tema:</label>
        <select name="tema" required>
            <option value="tema1" <?= $tarea['tema'] === 'tema1' ? 'selected' : '' ?>>Caída Libre</option>
            <option value="tema2" <?= $tarea['tema'] === 'tema2' ? 'selected' : '' ?>>Conductividad Eléctrica</option>
            <option value="tema3" <?= $tarea['tema'] === 'tema3' ? 'selected' : '' ?>>Ley de Gravitación Universal</option>
            <option value="tema4" <?= $tarea['tema'] === 'tema4' ? 'selected' : '' ?>>2da Ley de Newton</option>
            <option value="tema5" <?= $tarea['tema'] === 'tema5' ? 'selected' : '' ?>>Principio de Arquímedes</option>
            <option value="tema6" <?= $tarea['tema'] === 'tema6' ? 'selected' : '' ?>>Movimiento Rectilíneo Uniforme</option>
        </select>

        <button type="submit">Guardar Cambios</button>
        <button type="submit" name="eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea?');"
            style="background-color: crimson; color: white; margin-left: 10px;">
            Eliminar Tarea
        </button>


    </form>
</body>
</html>
