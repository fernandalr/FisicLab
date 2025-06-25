<?php
// Configuración de base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "usuarios_fl";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Conexión fallida: " . $conn->connect_error);
}

// Si es solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // REGISTRO
   if (isset($_POST['registroEmail'])) {
    $email = $_POST['registroEmail'];
    $pass = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $rol = "alumno"; // Asignación automática

    if (empty($email) || empty($pass) || empty($confirm)) {
        echo "❌ Todos los campos son obligatorios.";
        exit;
    }

    if ($pass !== $confirm) {
        echo "❌ Las contraseñas no coinciden.";
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "❌ Este correo ya está registrado.";
        exit;
    }

    $password_hash = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO usuarios (email, password, rol) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $password_hash, $rol);

    if ($stmt->execute()) {
        header("Location: Inicio.html");
        exit;
    } else {
        echo "❌ Error al registrar.";
    }
}


    // LOGIN
if (isset($_POST['loginEmail'])) {
    $email = $_POST['loginEmail'];
    $pass = $_POST['loginPassword'];

    if (empty($email) || empty($pass)) {
        echo "❌ Por favor, llena todos los campos.";
        exit;
    }

    $stmt = $conn->prepare("SELECT id, password, rol FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($usuario_id, $hashed_password, $usuario_rol);
        $stmt->fetch();

        if (password_verify($pass, $hashed_password)) {
            // ✅ Contraseña correcta → guardar sesión y redirigir
            session_start();
            $_SESSION['id_usuario'] = $usuario_id;
            $_SESSION['rol'] = $usuario_rol;

            if ($usuario_rol === 'alumno') {
                header("Location: Inicio.html");
            } else {
                header("Location: admin.html");
            }
            exit;
        } else {
            echo "❌ Contraseña incorrecta.";
        }
    } else {
        echo "❌ El correo no está registrado.";
    }

    $stmt->close();
}


} else {
    echo "❌ Método de solicitud no válido.";
}

$conn->close();
?>
