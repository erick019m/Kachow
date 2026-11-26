<?php

    date_default_timezone_set("America/La_Paz");

    $servidor = "localhost";
    $usuario = "root";
    $password = "";
    $basededatos = "kachow";

    $conexion = mysqli_connect($servidor, $usuario, $password, $basededatos);

    if(!$conexion){
        die("Error de conexion con la base de datos");
    }

    mysqli_set_charset($conexion, "utf8mb4");
?>
