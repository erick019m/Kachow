<?php
    include("verificar.php");
    include("conexion.php");

    if(!isset($_GET["id"])){
        header("location: citas.php");
        exit;
    }

    $id = intval($_GET['id']);

    mysqli_query($conexion, "delete from citas where id=$id");

    $_SESSION['mensaje'] = "Cita eliminada";
    $_SESSION['tipo'] = "success";
    header("location: citas.php");
?>
