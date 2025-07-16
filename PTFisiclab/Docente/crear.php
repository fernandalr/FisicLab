<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'maestro') {
    die("⛔ Acceso no autorizado.");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=AR+One+Sans:wght@400..700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Tarea</title>
</head>
<body>
    <div id="header-placeholder"></div>
    <h1>Crear Tarea</h1>
    <form action="submit_tarea.php" enctype="multipart/form-data" method="post">
        <label for="tema">Seleccionar tema:</label>
        <select name="tema" id="tema">
            <option value="tema1">Caida Libre</option>
            <option value="tema2">Conductividad Eléctrica</option>
            <option value="tema3">Ley de Gravitación Universal</option>
            <option value="tema4">Segunda Ley de Newton</option>
            <option value="tema5">Principio de Arquímedes</option>
            <option value="tema6">Movimiento Rectilineo Uniforme</option>
        </select>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required>Escribe aquí la descripción de la tarea...</textarea>

        <input type="file" name="archivo" id="archivo">

        <label for="fechaini">Fecha de inicio:</label>
        <input type="date" id="fechaini" name="fechaini" required>

        <label for="fechafin">Fecha de entrega:</label>
        <input type="date" id="fechafin" name="fechafin" required>

        <button type="submit">Crear Tarea</button>
        <button type="reset">Cancelar</button>
    </form>
    
    <div id="footer-placeholder"></div>
</body>
<style>
    body {
        font-family: 'AR One Sans', sans-serif;
        background-color: #f0f0f0;
        color: #333;
        margin: 0;
        padding: 20px;
    }

    h1 {
        text-align: center;
    }

    form {
        max-width: 600px;
        margin: 3% auto;
        background-color: #f3f3f3;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
       
    }

    label {
        display: block;
        margin-bottom: 10px;
    }

    select, textarea, input[type="date"], input[type="file"] {
        width: 95%;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    button {
        background-color: #06A77D;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    
    }
    button[type="reset"] {
        background-color: #f44336;
    }
    button[type="reset"]:hover {
        background-color: #f35858;
    }

    button:hover {
        background-color: #61af9a;
    }
    option{
        background-color:#ffa500;
        color: #ffffff;
    } 
    textarea {
        height: 100px;
        resize: vertical;
        vertical-align: top;

    }
</style>
<script>
    function validateForm() {
        const descripcion = document.getElementById('descripcion').value;
        if (descripcion.trim() === '') {
            alert('Por favor, completa la descripción de la tarea.');
            return false;
        }
        return true;
    }


    document.querySelector('form').addEventListener('submit', function(event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });
    document.querySelector('form').addEventListener('reset', function() {
        if (confirm('¿Estás seguro de que quieres cancelar?')) {
            this.reset();
            alert('Formulario cancelado. Redirigiendo a la página anterior.');
            // Redirigir a la página anterior
            history.back();
        } else {
            event.preventDefault();
        }
    });


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