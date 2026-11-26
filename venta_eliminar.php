<?php
    include("verificar.php");
    include("conexion.php");

    if(!isset($_GET["id"])){
        header("location: ventas.php");
        exit;
    }

    $id = intval($_GET['id']);

    $resultado = mysqli_query($conexion, "select * from venta_detalle where venta_id=$id");

    while($linea = mysqli_fetch_assoc($resultado)){

        $producto_id = $linea['producto_id'];
        $cantidad = $linea['cantidad'];

        mysqli_query($conexion, "update productos set stock = stock + $cantidad where id=$producto_id");
    }

    mysqli_query($conexion, "delete from venta_detalle where venta_id=$id");
    mysqli_query($conexion, "delete from ventas where id=$id");

    $_SESSION['mensaje'] = "Venta eliminada y stock devuelto";
    $_SESSION['tipo'] = "success";
    header("location: ventas.php");
?>
