<?php

session_start();


// Configuración de la base de datos
$host = 'localhost';
$db = 'usuarios_fl';
$user = 'root';
$pass = '';

// Conexión a la base de datos
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para sanitizar
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// ¿Es un formulario de login o de registro?
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Formulario de login
    if (isset($_POST['loginEmail'])) {
        $email = clean_input($_POST['loginEmail']);
        $password = $_POST['loginPassword'];

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();

            if (password_verify($password, $usuario['password'])) {
                $_SESSION['id_usuario'] = $usuario['id'];
                $_SESSION['nombre_usuario'] = $usuario['nombre'];
                $_SESSION['rol'] = $usuario['rol'];

                if ($usuario['rol'] === 'maestro') {
                    header("Location: admin.php");
                } elseif ($usuario['rol'] === 'alumno') {
                    header("Location: Inicio.php");
                } else {
                    echo "Rol de usuario no reconocido.";
                }
                exit();
            } else {
                echo "⚠ Contraseña incorrecta.";
            }
        } else {
            echo "⚠ Usuario no encontrado.";
        }
    }

    // Formulario de registro
    elseif (isset($_POST['registroEmail'])) {
        $nombre = clean_input($_POST['registroNombre']);
        $apellidoP = clean_input($_POST['registroApellidoP']);
        $apellidoM = clean_input($_POST['registroApellidoM']);
        $email = clean_input($_POST['registroEmail']);
        $rol = clean_input($_POST['registroTipo']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password !== $confirm_password) {
            echo "⚠ Las contraseñas no coinciden.";
            exit();
        }

        // Verificar que no exista ya ese email
        $check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            echo "⚠ Ya existe un usuario con ese correo.";
            exit();
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellidoP, apellidoM, email, rol, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nombre, $apellidoP, $apellidoM, $email, $rol, $hashed_password);

        if ($stmt->execute()) {
            // Registro exitoso
            header("Location: login.html?registro=exitoso");
            exit();
        } else {
            echo "❌ Error al registrar: " . $stmt->error;
        }
    }

}

$conn->close();
?>
