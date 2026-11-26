<?php
    include("auth.php");
    include("conexion.php");

    if(!isset($_GET["id"])){
        header("location: proveedores.php");
        exit;
    }

    $id = intval($_GET['id']);

    mysqli_query($conexion, "delete from proveedores where id=$id");

    $_SESSION['mensaje'] = "Proveedor eliminado";
    $_SESSION['tipo'] = "success";
    header("location: proveedores.php");
?>
