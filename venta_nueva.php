<?php
    include("verificar.php");
    include("conexion.php");

    if(!$_POST){
        header("location: ventas.php");
        exit;
    }

    $cliente_id = intval($_POST['cliente_id']);
    $metodo_pago = mysqli_real_escape_string($conexion, $_POST['metodo_pago']);
    $fecha = mysqli_real_escape_string($conexion, $_POST['fecha']);

    $error = "";

    if($cliente_id == 0 || $fecha == ""){
        $error = "Faltan datos para crear la venta";
    }else if($metodo_pago != "Efectivo" && $metodo_pago != "Transferencia" && $metodo_pago != "Tarjeta" && $metodo_pago != "QR"){
        $error = "El metodo de pago no es valido";
    }else if(date("Y-m-d", strtotime($fecha)) != $fecha){
        $error = "La fecha no es valida";
    }else if($fecha > date("Y-m-d")){
        $error = "La fecha de la venta no puede ser futura";
    }

    if($error == ""){
        $resultado = mysqli_query($conexion, "select * from clientes where id=$cliente_id");

        if(mysqli_num_rows($resultado) == 0){
            $error = "El cliente elegido no existe";
        }
    }

    if($error != ""){
        $_SESSION['mensaje'] = $error;
        $_SESSION['tipo'] = "danger";
        header("location: ventas.php");
        exit;
    }

    $consulta = "insert into ventas (cliente_id, fecha, metodo_pago, total)
                 values ($cliente_id, '$fecha', '$metodo_pago', 0)";

    mysqli_query($conexion, $consulta);

    $venta_id = mysqli_insert_id($conexion);

    $_SESSION['mensaje'] = "Venta creada. Ahora agregue los productos";
    $_SESSION['tipo'] = "success";
    header("location: venta_detalle.php?id=$venta_id");
?>
