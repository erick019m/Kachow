<?php
    include("verificar.php");
    include("conexion.php");
    include("horario.php");

    if(!$_POST){
        header("location: citas.php");
        exit;
    }

    $id = intval($_POST['id']);
    $cliente_id = intval($_POST['cliente_id']);
    $asesor_id = intval($_POST['asesor_id']);
    $vehiculo = mysqli_real_escape_string($conexion, trim($_POST['vehiculo']));
    $fecha = mysqli_real_escape_string($conexion, $_POST['fecha']);
    $hora = mysqli_real_escape_string($conexion, $_POST['hora']);
    $motivo = mysqli_real_escape_string($conexion, trim($_POST['motivo']));

    $error = "";

    if($cliente_id == 0 || $asesor_id == 0 || $vehiculo == "" || $fecha == "" || $hora == ""){
        $error = "Faltan datos obligatorios";
    }else if(strlen($vehiculo) > 100 || strlen($motivo) > 255){
        $error = "Algun dato es demasiado largo";
    }else if(date("Y-m-d", strtotime($fecha)) != $fecha){
        $error = "La fecha no es valida";
    }else if(!in_array($hora, $horas_manana) && !in_array($hora, $horas_tarde)){
        $error = "La hora esta fuera del horario de atencion";
    }else if(date("N", strtotime($fecha)) == 7){
        $error = "Los domingos no se atiende";
    }else if(date("N", strtotime($fecha)) == 6 && !in_array($hora, $horas_manana)){
        $error = "Los sabados solo se atiende de 08:30 a 12:30";
    }

    if($error == ""){
        $resultado = mysqli_query($conexion, "select * from clientes where id=$cliente_id");

        if(mysqli_num_rows($resultado) == 0){
            $error = "El cliente elegido no existe";
        }
    }

    if($error == ""){
        $consulta = "select * from usuarios
                     where id=$asesor_id and rol='vendedor' and activo=1";

        $resultado = mysqli_query($conexion, $consulta);

        if(mysqli_num_rows($resultado) == 0){
            $error = "El asesor elegido no existe";
        }
    }

    if($error == ""){
        $consulta = "select * from citas
                     where fecha='$fecha' and hora='$hora' and asesor_id=$asesor_id and id<>$id";

        $resultado = mysqli_query($conexion, $consulta);

        if(mysqli_num_rows($resultado) > 0){
            $error = "El asesor ya tiene otra cita ese dia a esa hora";
        }
    }

    if($error != ""){
        $_SESSION['mensaje'] = $error;
        $_SESSION['tipo'] = "danger";
        header("location: citas_editar.php?id=$id");
        exit;
    }

    $consulta = "update citas set
                    cliente_id=$cliente_id,
                    vehiculo='$vehiculo',
                    fecha='$fecha',
                    hora='$hora',
                    asesor_id=$asesor_id,
                    motivo='$motivo'
                 where id=$id";

    mysqli_query($conexion, $consulta);

    $_SESSION['mensaje'] = "Cita actualizada";
    $_SESSION['tipo'] = "success";
    header("location: citas.php");
?>
