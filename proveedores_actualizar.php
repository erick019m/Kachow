<?php
    include("auth.php");
    include("conexion.php");
    include("rubros.php");

    if(!$_POST){
        header("location: proveedores.php");
        exit;
    }

    $id = intval($_POST['id']);
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $nit = mysqli_real_escape_string($conexion, trim($_POST['nit']));
    $rubro = trim($_POST['rubro']);
    $contacto = mysqli_real_escape_string($conexion, trim($_POST['contacto']));
    $telefono = mysqli_real_escape_string($conexion, trim($_POST['telefono']));
    $correo = mysqli_real_escape_string($conexion, trim($_POST['correo']));
    $direccion = mysqli_real_escape_string($conexion, trim($_POST['direccion']));

    $error = "";

    if($nombre == "" || $nit == ""){
        $error = "El nombre y el NIT son obligatorios";
    }else if(strlen($nombre) > 120 || strlen($contacto) > 100 || strlen($correo) > 100 || strlen($direccion) > 150){
        $error = "Algun dato es demasiado largo";
    }else if(!ctype_digit($nit) || strlen($nit) < 5 || strlen($nit) > 15){
        $error = "El NIT debe tener solo numeros, entre 5 y 15";
    }else if(!in_array($rubro, $rubros)){
        $error = "Elija un rubro de la lista";
    }else if($telefono != "" && (!ctype_digit($telefono) || strlen($telefono) < 7 || strlen($telefono) > 8)){
        $error = "El telefono debe tener 7 u 8 numeros";
    }else if($correo != "" && !filter_var($correo, FILTER_VALIDATE_EMAIL)){
        $error = "El correo no es valido";
    }

    if($error == ""){
        $resultado = mysqli_query($conexion, "select * from proveedores where nit='$nit' and id<>$id");

        if(mysqli_num_rows($resultado) > 0){
            $error = "Ya existe otro proveedor con ese NIT";
        }
    }

    if($error != ""){
        $_SESSION['mensaje'] = $error;
        $_SESSION['tipo'] = "danger";
        header("location: proveedores_editar.php?id=$id");
        exit;
    }

    $consulta = "update proveedores set
                    nombre='$nombre',
                    nit='$nit',
                    rubro='$rubro',
                    contacto='$contacto',
                    telefono='$telefono',
                    correo='$correo',
                    direccion='$direccion'
                 where id=$id";

    mysqli_query($conexion, $consulta);

    $_SESSION['mensaje'] = "Proveedor actualizado";
    $_SESSION['tipo'] = "success";
    header("location: proveedores.php");
?>
