<?php
    include("auth.php");
    include("conexion.php");

    $tablas = array("usuarios", "clientes", "proveedores", "productos", "citas", "ventas", "venta_detalle");

    $texto = "set foreign_key_checks = 0;\n";

    foreach($tablas as $tabla){

        $texto = $texto . "drop table if exists $tabla;\n";

        $resultado = mysqli_query($conexion, "show create table $tabla");
        $fila = mysqli_fetch_array($resultado);

        $crear = str_replace("\n", " ", $fila[1]);
        $texto = $texto . $crear . ";\n";

        $datos = mysqli_query($conexion, "select * from $tabla");

        while($registro = mysqli_fetch_assoc($datos)){

            $valores = "";

            foreach($registro as $valor){

                if($valores != ""){
                    $valores = $valores . ", ";
                }

                if($valor === null){
                    $valores = $valores . "null";
                }else{
                    $valores = $valores . "'" . mysqli_real_escape_string($conexion, $valor) . "'";
                }
            }

            $texto = $texto . "insert into $tabla values ($valores);\n";
        }
    }

    $texto = $texto . "set foreign_key_checks = 1;\n";

    $nombre = "kachow_" . date("Ymd_His") . ".sql";

    file_put_contents("respaldos/" . $nombre, $texto);

    $_SESSION['mensaje'] = "Respaldo creado: $nombre";
    $_SESSION['tipo'] = "success";
    header("location: respaldo.php");
?>
