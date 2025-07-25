<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FisicLab</title>
    <link rel="stylesheet" href="estilos_ini.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=AR+One+Sans:wght@400..700&display=swap" rel="stylesheet">
</head>

<body>
    
    <div id="header-placeholder"></div>
    <main>
        <section class="banner">
            <img src="imag/bannerextra.png" alt="Banner" class="imgbanner">
        </section>
&nbsp;
        <section class="intro_text">
            <p>FisicLab es una herramienta interactiva diseñada para apoyar el aprendizaje de la física a través de simulaciones virtuales accesibles desde cualquier dispositivo. Construido con tecnologías web como HTML, CSS y JavaScript, este laboratorio permite a estudiantes y docentes experimentar con conceptos clave de manera visual, dinámica y segura.
            </p>

            <p>Ya sea que estés explorando leyes del movimiento, principios de fluidos o circuitos eléctricos, FisicLab te brinda un espacio intuitivo para observar, manipular y comprender fenómenos físicos sin necesidad de materiales costosos ni instalaciones especiales.</p>

            <p>
            Actualmente, la adaptación hacia la época digital ha generado un cambio radical con la integración de tecnologías en el sector educativo, especialmente con los métodos de enseñanza y aprendizaje en áreas como las ciencias naturales. 
            </p>
            <p>
            Gracias a estas invenciones tecnológicas los estudiantes pueden disfrutar jugando, experimentando y practicando al mismo tiempo, conceptos relacionados a los temas que se encuentran estudiando. 
            </p>
        </section>
&nbsp;
&nbsp;
&nbsp;
        <section class="tarjetas">
            <div class="tarjeta">
                <section class="titulo_targetas">
                <h2>Teoría</h2>
                <a href="Teoria.html"><img class="img1"  src="imag/tarea.png" alt="" width="45%"></a>
                </section>
                
                <section class="text_info">
                     <p>En esta sección aprendes los conceptos abstractos que explican cómo funciona el mundo físico. Aquí se presentan las ideas, leyes y fórmulas que te ayudarán a entender por qué suceden ciertos fenómenos en el juego. Aunque no todo se ve a simple vista, estas explicaciones te darán las herramientas para resolver desafíos, experimentar y pensar como un verdadero científico.</p>
                </section>
        

            </div>
            <div class="tarjeta">
                <section class="titulo_targetas">
                    <h2>Laboratorio</h2>
                <a href="laboratorio"><img src="imag/matematicas.png" alt="" width="45%"></a>
                </section>
                <p>En esta sección puedes explorar diferentes simulaciones interactivas de física.
                Aquí podrás experimentar con conceptos como el movimiento, la presión o la fuerza, de forma visual y sencilla. Solo elige una simulación, ajusta los valores y observa cómo cambian los resultados.
                ¡Aprender física nunca fue tan fácil y divertido!</p>
            </div>
            <div class="tarjeta">
                <section class="titulo_targetas">
                    <h2>Tarea</h2>
               <a href="/PTFisiclab/Alumno/ver_tareas_al.php"><img src="imag/tarea.png" alt="" width="45%"></a>
                </section>
                <p>En este apartado encontrarás actividades para reforzar lo aprendido en las simulaciones del laboratorio.
                Cada tarea está pensada para ayudarte a analizar, reflexionar y aplicar los conceptos físicos de forma práctica.
                Resuelve los ejercicios, responde las preguntas y pon a prueba tu comprensión.</p>
            </div>
        </section>
        <div id="footer-placeholder"></div>
    </main>
 

    <script>

    fetch('header.html')
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
    
    


</body>

</html>