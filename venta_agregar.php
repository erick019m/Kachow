<?php
    include("verificar.php");
    include("conexion.php");

    if(!$_POST){
        header("location: ventas.php");
        exit;
    }

    $venta_id = intval($_POST['venta_id']);
    $producto_id = intval($_POST['producto_id']);
    $cantidad = intval($_POST['cantidad']);

    $venta = mysqli_query($conexion, "select * from ventas where id=$venta_id");

    $resultado = mysqli_query($conexion, "select * from productos where id=$producto_id");
    $producto = mysqli_fetch_assoc($resultado);

    $error = "";

    if(mysqli_num_rows($venta) == 0){
        $error = "Esa venta no existe";
    }else if($producto_id == 0 || $cantidad <= 0){
        $error = "Seleccione un producto y una cantidad valida";
    }else if(mysqli_num_rows($resultado) == 0){
        $error = "Ese producto no existe";
    }else if($cantidad > $producto['stock']){
        $error = "Solo hay " . $producto['stock'] . " unidades en stock";
    }

    if($error != ""){
        $_SESSION['mensaje'] = $error;
        $_SESSION['tipo'] = "danger";
        header("location: venta_detalle.php?id=$venta_id");
        exit;
    }

    $precio = $producto['precio'];

    $consulta = "select * from venta_detalle where venta_id=$venta_id and producto_id=$producto_id";
    $resultado = mysqli_query($conexion, $consulta);

    if(mysqli_num_rows($resultado) > 0){

        $linea = mysqli_fetch_assoc($resultado);

        $linea_id = $linea['id'];
        $nuevaCantidad = $linea['cantidad'] + $cantidad;
        $nuevoSubtotal = $nuevaCantidad * $linea['precio'];

        $consulta = "update venta_detalle set cantidad=$nuevaCantidad, subtotal=$nuevoSubtotal
                     where id=$linea_id";

        mysqli_query($conexion, $consulta);

    }else{

        $subtotal = $precio * $cantidad;

        $consulta = "insert into venta_detalle (venta_id, producto_id, cantidad, precio, subtotal)
                     values ($venta_id, $producto_id, $cantidad, $precio, $subtotal)";

        mysqli_query($conexion, $consulta);
    }

    mysqli_query($conexion, "update productos set stock = stock - $cantidad where id=$producto_id");

    $resultado = mysqli_query($conexion, "select sum(subtotal) as total from venta_detalle where venta_id=$venta_id");
    $total = mysqli_fetch_assoc($resultado)['total'];

    if($total == ""){
        $total = 0;
    }

    mysqli_query($conexion, "update ventas set total=$total where id=$venta_id");

    $_SESSION['mensaje'] = "Producto agregado";
    $_SESSION['tipo'] = "success";
    header("location: venta_detalle.php?id=$venta_id");
?>
