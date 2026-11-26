<?php
    include("auth.php");
    include("conexion.php");

    if(!isset($_GET['archivo'])){
        header("location: respaldo.php");
        exit;
    }

    $archivo = basename($_GET['archivo']);
    $ruta = "respaldos/" . $archivo;

    if(!file_exists($ruta) || substr($archivo, -4) != ".sql"){
        $_SESSION['mensaje'] = "Ese archivo de respaldo no existe";
        $_SESSION['tipo'] = "danger";
        header("location: respaldo.php");
        exit;
    }

    $texto = file_get_contents($ruta);

    $lineas = explode("\n", $texto);

    $ejecutadas = 0;

    foreach($lineas as $linea){

        $linea = trim($linea);

        if($linea != ""){

            mysqli_query($conexion, $linea);
            $ejecutadas = $ejecutadas + 1;
        }
    }

    $_SESSION['mensaje'] = "Respaldo restaurado: se ejecutaron $ejecutadas instrucciones";
    $_SESSION['tipo'] = "success";
    header("location: respaldo.php");
?>
