

<?php
include("con_db.php");
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['cedula'])) {
    // Si no ha iniciado sesión, redirigir al formulario de inicio de sesión
    header('Location: reservas.php'); // Reemplaza con la ruta correcta
    exit();
}

// Obtener el nombre del usuario desde la base de datos
$cedula = $_SESSION['cedula'];
$sql = "SELECT nombre FROM datos WHERE cedula='$cedula'";
$resultado = mysqli_query($conex, $sql);

if ($resultado) {
    $fila = mysqli_fetch_assoc($resultado);
    $nombreUsuario = $fila['nombre'];
} else {
    // Manejar el error de la consulta
    $nombreUsuario = "Error al obtener el nombre";
}
?>
<!DOCTYPE html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de reserva</title>
</head>
<link rel="stylesheet" href="http://localhost/Parqueadero/assets/css/reservas.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<body>

<header>

        <div class="header-container">
            <nav class="header-nav-bar">
                <div class="header-nav-logo">
                    <a href=""><!-- direccionar a una pagina -->
                        <img width="85px" height="auto" src="img.reserva/Imagen1.jpeg" type="image/x-icon" alt="Hogar">
                    </a>
                </div>
                <ul class="header-nav-lists">
                    <li class="header-nav-list"><a class="header-nav-link" href="index.php">Inicio</a></li>
                    <h1>Bienvenid@ <?php echo  $nombreUsuario; ?> !</h1><br>
                    <li id="cerrarSesionBtn" class="header-nav-list"><a class="header-nav-link" href="login_register.php">Cerrar Sesion </a></li> 

                </ul>
                <div class="header-hamburger-icon">
                    <div class="header-hamburger-line-1"></div>
                    <div class="header-hamburger-line-2"></div>
                    <div class="header-hamburger-line-3"></div>
                </div>
            </nav>
        </div>
    </header>

    <form ="reservar-vehiculo" action="procesar_reserva.php" method="post">
    <section class="banner">
        <h2>RESERVA TU  VEHICULO</h2>
            <div class = "card-contenedor">
                <div class= "card-img">

                </div>
                <div class="card-contenido">
                    <h3>Reserva</h3>
                    <form id="reservar- vehiculo">
                        <div class="form-row">
                        <input type="text" id="nombreCompleto" name="nombreCompleto" placeholder="Nombre completo" required>
                        <input type="text" id="correo" name="correo" placeholder="Correo" required>
                        </div>
                        <div class="form-row">                          
                            <input type="date" id="fecha" name="fecha" placeholder="Fecha">
                            <input type="time" id="hora" name="hora"placeholder="Hora"
                             min="10:00" max="24:00" required>
                        </div>

                        <div class="form-row">
                        <label for="opciones"></label>
                            <select id="opciones" name="opciones">
                                <option value="opcion">Estacionamiento</option>
                                <option value="opcion2">Cupo 1</option>
                                <option value="opcion3">Cupo 2</option>
                                <option value="opcion4">Cupo 3</option>
                                <option value="opcion5">Cupo 4</option>
                                <option value="opcion6">Cupo 5</option>
                                <option value="opcion6">Cupo 6</option>
                                <option value="opcion7">Cupo 7</option>
                                <option value="opcion8">Cupo 8</option>
                                <option value="opcion9">Cupo 9</option>
                            </select>
                            <input type="text" placeholder="Placa" id="placa" name="placa">
                        </div>

                        <div class="form-row">
                            <input type="number" placeholder="Cantidad Vehiculos" id="cantida_vehiculo" name="cantidad_vehiculo" min="1">
                            <input type="submit" value="RESERVAR VEHICULO">
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <div class="contenedor-cuadros">
        <div class="cuadro" onclick="seleccionarCuadro(this)">
            <div class="capa-superior">
                <h2>Carro</h2>
                <p></p>
            </div>
            <img src="https://www.eltiempo.com/files/article_multimedia/uploads/2019/10/15/5da64f9a11291.jpeg" alt="Imagen 1">
        </div>
        <div class="cuadro" onclick="seleccionarCuadro(this)">
            <div class="capa-superior">
                <h2>Moto</h2>
                <p></p>
            </div>
            <img src="https://a5i4f6g5.stackpathcdn.com/images/cms/Head-Banner--630x630_CBR500R-06ae7.jpg" alt="Imagen 2">
        </div>
        <div class="cuadro" onclick="seleccionarCuadro(this)">
            <div class="capa-superior">
                <h2>Camion</h2>
                <p></p>
            </div>
            <img src="https://previews.123rf.com/images/roseov/roseov1606/roseov160600342/59121967-cami%C3%B3n-estacionado-en-una-autopista-cami%C3%B3n-estacionado-en-una-carretera.jpg" alt="Imagen 3">
        </div>
    </div>

    <script>
        function seleccionarCuadro(cuadro) {
            // Eliminar la clase 'cuadro-seleccionado' de todos los cuadros
            var cuadros = document.querySelectorAll('.cuadro');
            cuadros.forEach(function (elemento) {
                elemento.classList.remove('cuadro-seleccionado');
            });

            // Agregar la clase 'cuadro-seleccionado' al cuadro clicado
            cuadro.classList.add('cuadro-seleccionado');
        }
    </script>
    <script>
        // Manejar el clic en el botón
        $(document).ready(function () {
            $("#cerrarSesionBtn").click(function () {
                // Enviar una solicitud al servidor para cerrar la sesión
                $.ajax({
                    type: "POST",
                    url: "cerrar_sesion.php", // Nombre del archivo PHP que contiene el código para cerrar sesión
                    success: function () {
                        // Redirigir a la página de inicio de sesión u otra página después de cerrar sesión
                        window.location.href = "login_register.php";
                    }
                });
            });
        });
    </script>

</form>   
    
    
</body>
    </section>

</body>
</html>