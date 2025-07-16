<?php
session_start();

// Verifica que sea un maestro
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'maestro') {
    die("⛔ Acceso denegado.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=AR+One+Sans:wght@400..700&display=swap" rel="stylesheet">
    <title>Área del docente | FisicLab</title>
</head>
<style>
    body {
        font-family: 'AR One Sans', sans-serif;
        background-color: #ffffff;
        color: #333;
        margin: 0;
        padding: 20px;
    }

    h1, h2 {
        text-align: center;
    }
    h2 {
        font-size: 1.2em;
    }

    p {
        text-align: center;
        max-width: 800px;
        margin: 0 auto 20px auto;
        font-size: 80%;
    }

    .parent > div {
        background-color: #ffa500;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .div1, .div2, .div3 {
        font-size: 1.2em;
    }
    .parent {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: repeat(1, 1fr);
        gap: 15px;
        text-align: center;
    }
    a {
        text-decoration: none;
        color: #333;
    }

    
</style>
<body>
    <div id="header-placeholder"></div>
    <div class="container">
        <h1>Área del docente</h1>
        <p>Bienvenido al área del docente de FisicLab. Aquí podrás gestionar las tareas de tus estudiantes, crear nuevas actividades y calificar el trabajo realizado.</p>
        <p>Utiliza las siguientes opciones para interactuar con las tareas:</p>

    
    <div class="parent">
        <div class="div1">
            <div><a href="Docente/crear.html"><h2>Crear Tarea</h2>
            <img src="imag/escritura.png" alt="" width="50" height="50">
            <p></p>
            <p>Utiliza esta opción para crear nuevas tareas y asignarlas a tus estudiantes.</p>  </a></div>
        </div>

        <div class="div2">
            <div><a href="Docente/ver_tareas.php"><h2>Tareas Creadas</h2>
            <img src="imag/lista-de-verificacion.png" alt="" width="50" height="50">
            <p></p>
            <p>Revisa las tareas que has creado y su estado.</p>  </a></div>
        </div>

        <div class="div3">
            <div><a href="Docente/tareas_recibidas.php"><h2>Tareas Recibidas</h2>
            <img src="imag/tarea-completada.png" alt="" width="50" height="50">
            <p>Califica las tareas que tus estudiantes han enviado.</p>
        </div>
    </div>

    </div>
    <div id="footer-placeholder"></div>
    


</body>
<script>
    fetch('header_docente.html')
      .then(res => res.text())
      .then(data => {
        document.getElementById('header-placeholder').innerHTML = data;
      });

      fetch('footer.html')
      .then(res => res.text())
      .then(data => {
        document.getElementById('footer-placeholder').innerHTML = data;
      });
    </script>
</html>