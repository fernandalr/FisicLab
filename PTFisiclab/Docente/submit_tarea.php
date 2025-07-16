<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "usuarios_fl");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener datos del formulario
$tema = $_POST['tema'];
$descripcion = $_POST['descripcion'];
$fecha_inicio = $_POST['fechaini'];
$fecha_fin = $_POST['fechafin'];

// Procesar archivo
$archivo_guardado = null; // valor por defecto

if (!empty($_FILES['archivo']['name'])) {
    $archivo_nombre = basename($_FILES['archivo']['name']);
    // Ruta relativa desde la raíz web (NO QUITAR /PTFisiclab/)
    $ruta_relativa = "/PTFisiclab/uploads/" . $archivo_nombre;
    // Ruta física en el servidor para guardar el archivo
    $ruta_fisica = __DIR__ . "/../uploads/" . $archivo_nombre;

    // Crear carpeta si no existe
    if (!is_dir(dirname($ruta_fisica))) {
        mkdir(dirname($ruta_fisica), 0777, true);
    }

    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_fisica)) {
        $archivo_guardado = $ruta_relativa; // Esta ruta se guarda en la BD
    }
}



// Insertar en la base de datos
$stmt = $conexion->prepare("INSERT INTO Tarea (tema, descripcion, archivo, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $tema, $descripcion, $archivo_guardado, $fecha_inicio, $fecha_fin);

if ($stmt->execute()) {
    // Tarea guardada correctamente
    echo "<script>
            window.alert('Tarea guardada correctamente.');
            window.location.href = '../admin.php';
          </script>";
} else {
    echo "<script>
            window.alert('Error al guardar la tarea: " . $stmt->error . "');
            window.location.href = '../admin.php';
          </script>";
}

$stmt->close();
$conexion->close();

?>
