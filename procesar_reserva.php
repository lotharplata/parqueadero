<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Página</title>
    <style>
         a {
            text-decoration: none;
        }

        button {
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            font-size: 14px;
            background: black;
            font-weight: 600;
            cursor: pointer;
            color: white;
            outline: none;
            display: inline-block;
        }

        button:hover {
            background: blue; /* Cambia el color de fondo al pasar el mouse si lo deseas */
        }
        .mensaje-exito {
            background-color: #4CAF50; /* Fondo verde */
            color: greenyellow; /* Texto blanco */
            padding: 10px;
            margin-bottom: 10px;
        }

        .mensaje-error {
            background-color: #f44336; /* Fondo rojo */
            color: #fff; /* Texto blanco */
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>';
<?php
session_start();

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "parker");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Recibir datos del formulario
$nombreCompleto = $_POST['nombreCompleto'];
$correo = $_POST['correo'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$opciones = $_POST['opciones'];
$placa = $_POST['placa'];
$cantidad_vehiculo = $_POST['cantidad_vehiculo'];

// Verificar si la placa ya existe en la base de datos
$consulta_existencia_placa = "SELECT COUNT(*) AS total FROM reservas WHERE placa = ?";
$statement_placa = $conexion->prepare($consulta_existencia_placa);
$statement_placa->bind_param("s", $placa);
$statement_placa->execute();
$statement_placa->bind_result($total_placa);
$statement_placa->fetch();
$statement_placa->close();

// Verificar si la opción ya existe en la base de datos
$consulta_existencia_opcion = "SELECT COUNT(*) AS total FROM reservas WHERE opciones = ?";
$statement_opcion = $conexion->prepare($consulta_existencia_opcion);
$statement_opcion->bind_param("s", $opciones);
$statement_opcion->execute();
$statement_opcion->bind_result($total_opcion);
$statement_opcion->fetch();
$statement_opcion->close();

if ($total_placa == 0 && $total_opcion == 0) {
    // La placa y la opción no existen, entonces podemos insertar la reserva
    $consulta = "INSERT INTO reservas (nombreCompleto, correo, fecha, hora, opciones, placa, cantidad_vehiculo) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";

    $statement_insert = $conexion->prepare($consulta);
    $statement_insert->bind_param("ssssssi", $nombreCompleto, $correo, $fecha, $hora, $opciones, $placa, $cantidad_vehiculo);

    if ($statement_insert->execute()) {
        echo '<div class="mensaje-exito">Reserva realizada correctamente.</div>';
        echo '<a href="reservas.php"><button>Volver Hacer una reserva</button></a>';
    } else {
        echo  '<div class="mensaje-error">Error al realizar la reserva: '. $conexion->error;
    }

    $statement_insert->close();
} else {
    if ($total_placa > 0) {
        echo '<div class="mensaje-error">La placa ya existe en la base de datos.</div>';
        echo '<a href="reservas.php"><button>Cambiar Placa </button></a>';
    }

    if ($total_opcion > 0) {
        echo '<div class="mensaje-error">La opción ya existe en la base de datos.</div>';
        echo '<a href="reservas.php"><button>Cambiar Cupo</button></a>';
    }
}

// Cerrar la conexión
$conexion->close();
?>
