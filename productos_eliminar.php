<?php
    include("verificar.php");
    include("conexion.php");

    if(!isset($_GET["id"])){
        header("location: productos.php");
        exit;
    }

    $id = intval($_GET['id']);

    $resultado = mysqli_query($conexion, "select count(*) as total from venta_detalle where producto_id=$id");
    $vendido = mysqli_fetch_assoc($resultado)['total'];

    if($vendido > 0){
        $_SESSION['mensaje'] = "No se puede eliminar: el producto aparece en $vendido venta(s)";
        $_SESSION['tipo'] = "danger";
        header("location: productos.php");
        exit;
    }

    mysqli_query($conexion, "delete from productos where id=$id");

    $_SESSION['mensaje'] = "Producto eliminado";
    $_SESSION['tipo'] = "success";
    header("location: productos.php");
?>
