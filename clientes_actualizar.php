<?php
    include("verificar.php");
    include("conexion.php");

    if(!$_POST){
        header("location: clientes.php");
        exit;
    }

    $id = intval($_POST['id']);
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $documento = mysqli_real_escape_string($conexion, trim($_POST['documento']));
    $telefono = mysqli_real_escape_string($conexion, trim($_POST['telefono']));
    $correo = mysqli_real_escape_string($conexion, trim($_POST['correo']));
    $direccion = mysqli_real_escape_string($conexion, trim($_POST['direccion']));

    $error = "";

    if($nombre == "" || $documento == ""){
        $error = "El nombre y el documento son obligatorios";
    }else if(strlen($nombre) > 100 || strlen($correo) > 100 || strlen($direccion) > 150){
        $error = "Algun dato es demasiado largo";
    }else if(!ctype_digit($documento) || strlen($documento) < 5 || strlen($documento) > 15){
        $error = "El documento debe tener solo numeros, entre 5 y 15";
    }else if($telefono != "" && (!ctype_digit($telefono) || strlen($telefono) < 7 || strlen($telefono) > 8)){
        $error = "El telefono debe tener 7 u 8 numeros";
    }else if($correo != "" && !filter_var($correo, FILTER_VALIDATE_EMAIL)){
        $error = "El correo no es valido";
    }

    if($error == ""){
        $resultado = mysqli_query($conexion, "select * from clientes where documento='$documento' and id<>$id");

        if(mysqli_num_rows($resultado) > 0){
            $error = "Ya existe otro cliente con ese documento";
        }
    }

    if($error != ""){
        $_SESSION['mensaje'] = $error;
        $_SESSION['tipo'] = "danger";
        header("location: clientes_editar.php?id=$id");
        exit;
    }

    $consulta = "update clientes set
                    nombre='$nombre',
                    documento='$documento',
                    telefono='$telefono',
                    correo='$correo',
                    direccion='$direccion'
                 where id=$id";

    mysqli_query($conexion, $consulta);

    $_SESSION['mensaje'] = "Cliente actualizado";
    $_SESSION['tipo'] = "success";
    header("location: clientes.php");
?>
