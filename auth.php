<?php
    include("verificar.php");

    if($_SESSION['rol'] != "administrador"){
        $_SESSION['mensaje'] = "No tiene permiso para entrar a esa seccion";
        $_SESSION['tipo'] = "danger";
        header("location: index.php");
        exit;
    }
?>
