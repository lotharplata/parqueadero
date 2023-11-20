<?php
include("con_db.php");

if (isset($_POST['iniciar'])) {
    if (strlen($_POST['nombre']) >= 1 && strlen($_POST['car']) >= 1 && strlen($_POST['placa']) >= 1 && strlen($_POST['categoria']) >= 1 && !empty($_POST['fecha_hora'])) {
        // Resto del código...
    
    
        $nombre = trim($_POST['nombre']);
        $car = trim($_POST['car']);
        $placa = trim($_POST['placa']);
        $categoria = trim($_POST['categoria']);
        $fecha_hora = trim($_POST['fecha_hora']);
        
     
        
        $consulta = "INSERT INTO dia(nombre, car, placa, categoria, fecha_hora) VALUES ('$nombre', '$car', '$placa', '$categoria', '$fecha_hora')";
        $resultado = mysqli_query($conex, $consulta);
        
        if ($resultado) {
            ?> 
            <h3 class="ok">¡Reserva creada con éxito!</h3>
           <?php
        } else {
            ?> 
            <h3 class="bad">¡Ups, ha ocurrido un error!</h3>
           <?php
        }
    } 
}
?>
