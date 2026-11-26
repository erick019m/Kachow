<?php
    include("verificar.php");
    include("conexion.php");

    if(!$_POST){
        header("location: productos.php");
        exit;
    }

    $id = intval($_POST['id']);
    $codigo = mysqli_real_escape_string($conexion, trim($_POST['codigo']));
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $categoria = mysqli_real_escape_string($conexion, trim($_POST['categoria']));
    $marca = mysqli_real_escape_string($conexion, trim($_POST['marca']));
    $stock = intval($_POST['stock']);
    $stock_minimo = intval($_POST['stock_minimo']);
    $precio = $_POST['precio'];

    $error = "";

    if($codigo == "" || $nombre == "" || $categoria == ""){
        $error = "El codigo, el nombre y la categoria son obligatorios";
    }else if(strlen($codigo) > 20 || strlen($nombre) > 120 || strlen($categoria) > 50 || strlen($marca) > 50){
        $error = "Algun dato es demasiado largo";
    }else if(!is_numeric($precio) || $precio <= 0 || $precio > 1000000){
        $error = "El precio debe ser mayor a 0 y menor a 1000000";
    }else if($stock < 0 || $stock_minimo < 0 || $stock > 100000 || $stock_minimo > 100000){
        $error = "El stock debe estar entre 0 y 100000";
    }

    if($error == ""){
        $resultado = mysqli_query($conexion, "select * from productos where codigo='$codigo' and id<>$id");

        if(mysqli_num_rows($resultado) > 0){
            $error = "Ya existe otro producto con ese codigo";
        }
    }

    if($error != ""){
        $_SESSION['mensaje'] = $error;
        $_SESSION['tipo'] = "danger";
        header("location: productos_editar.php?id=$id");
        exit;
    }

    $consulta = "update productos set
                    codigo='$codigo',
                    nombre='$nombre',
                    categoria='$categoria',
                    marca='$marca',
                    stock=$stock,
                    stock_minimo=$stock_minimo,
                    precio=$precio
                 where id=$id";

    mysqli_query($conexion, $consulta);

    $_SESSION['mensaje'] = "Producto actualizado";
    $_SESSION['tipo'] = "success";
    header("location: productos.php");
?>
