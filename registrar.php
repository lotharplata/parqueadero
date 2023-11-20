<?php 
include("con_db.php");

if(isset($_POST["register"])){
    $cedula = isset($_POST['cedula']) ? trim($_POST['cedula']) : '';
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $clave = isset($_POST['clave']) ? trim($_POST['clave']) : '';

    // Validate input
    if(strlen($cedula) >= 1 && strlen($nombre) >= 1 && strlen($clave)) { 
        // Sanitize input to prevent SQL injection
        $cedula = mysqli_real_escape_string($conex, $cedula);
        $nombre = mysqli_real_escape_string($conex, $nombre);
        $clave = mysqli_real_escape_string($conex, $clave);

        $sql = "SELECT * FROM datos WHERE cedula='$cedula'";
        $resultado = mysqli_query($conex, $sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            ?> 
            <h3>¡Usuario ya existente!</h3>
            <?php
        } else {
            $consulta = "INSERT INTO datos(cedula, nombre, clave) VALUES ('$cedula','$nombre', '$clave')";
            $ejecutar_consulta = mysqli_query($conex, $consulta);

            if($ejecutar_consulta){
                ?>
                <h3>Se ha creado un Usuario</h3>
                <?php
            } else {
                ?>
                <h3>No se pudo crear el Usuario</h3>
                <?php 
            }
        }
    } else {
        ?> 
        <h3>¡Por favor complete los campos!</h3>
        <?php
    }
}
?>
