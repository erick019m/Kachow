<?php
    include("verificar.php");
    include("conexion.php");

    if(!isset($_GET["id"])){
        header("location: clientes.php");
        exit;
    }

    $id = intval($_GET['id']);

    $resultado = mysqli_query($conexion, "select count(*) as total from citas where cliente_id=$id");
    $citas = mysqli_fetch_assoc($resultado)['total'];

    $resultado = mysqli_query($conexion, "select count(*) as total from ventas where cliente_id=$id");
    $ventas = mysqli_fetch_assoc($resultado)['total'];

    if($citas > 0 || $ventas > 0){
        $_SESSION['mensaje'] = "No se puede eliminar: el cliente tiene $citas cita(s) y $ventas venta(s)";
        $_SESSION['tipo'] = "danger";
        header("location: clientes.php");
        exit;
    }

    mysqli_query($conexion, "delete from clientes where id=$id");

    $_SESSION['mensaje'] = "Cliente eliminado";
    $_SESSION['tipo'] = "success";
    header("location: clientes.php");
?>
