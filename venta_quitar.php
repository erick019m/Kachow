<?php
    include("verificar.php");
    include("conexion.php");

    if(!isset($_GET["id"])){
        header("location: ventas.php");
        exit;
    }

    $id = intval($_GET['id']);

    $resultado = mysqli_query($conexion, "select * from venta_detalle where id=$id");

    if(mysqli_num_rows($resultado) == 0){
        $_SESSION['mensaje'] = "Esa linea de la venta ya no existe";
        $_SESSION['tipo'] = "danger";
        header("location: ventas.php");
        exit;
    }

    $linea = mysqli_fetch_assoc($resultado);

    $venta_id = $linea['venta_id'];
    $producto_id = $linea['producto_id'];
    $cantidad = $linea['cantidad'];

    mysqli_query($conexion, "delete from venta_detalle where id=$id");

    mysqli_query($conexion, "update productos set stock = stock + $cantidad where id=$producto_id");

    $resultado = mysqli_query($conexion, "select sum(subtotal) as total from venta_detalle where venta_id=$venta_id");
    $total = mysqli_fetch_assoc($resultado)['total'];

    if($total == ""){
        $total = 0;
    }

    mysqli_query($conexion, "update ventas set total=$total where id=$venta_id");

    $_SESSION['mensaje'] = "Producto quitado de la venta";
    $_SESSION['tipo'] = "success";
    header("location: venta_detalle.php?id=$venta_id");
?>
