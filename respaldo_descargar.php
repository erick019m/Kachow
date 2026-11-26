<?php
    include("auth.php");

    if(!isset($_GET['archivo'])){
        header("location: respaldo.php");
        exit;
    }

    $archivo = basename($_GET['archivo']);
    $ruta = "respaldos/" . $archivo;

    if(!file_exists($ruta) || substr($archivo, -4) != ".sql"){
        $_SESSION['mensaje'] = "Ese archivo de respaldo no existe";
        $_SESSION['tipo'] = "danger";
        header("location: respaldo.php");
        exit;
    }

    header("Content-Type: application/sql");
    header("Content-Disposition: attachment; filename=" . $archivo);

    readfile($ruta);
?>
