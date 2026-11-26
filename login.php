<?php
    session_start();
    include("conexion.php");

    $error = "";

    if($_POST){

        $usuario = mysqli_real_escape_string($conexion, trim($_POST['usuario']));
        $clave = $_POST['clave'];

        $consulta = "select * from usuarios where usuario='$usuario' and activo=1";
        $resultado = mysqli_query($conexion, $consulta);

        if(mysqli_num_rows($resultado) > 0){

            $fila = mysqli_fetch_assoc($resultado);

            if(password_verify($clave, $fila['clave'])){

                $_SESSION['usuario'] = $fila['usuario'];
                $_SESSION['nombre'] = $fila['nombre'];
                $_SESSION['rol'] = $fila['rol'];

                header("location: index.php");
                exit;

            }else{
                $error = "Usuario o contrasena incorrectos";
            }

        }else{
            $error = "Usuario o contrasena incorrectos";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ingresar - Kachow Autopartes</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="estilos.css" rel="stylesheet">
</head>
<body class="fondo-login">

    <div class="caja-login">

        <div class="text-center mb-4">
            <span class="logo logo-grande">K</span>
            <h3 class="titulo-login">Kachow Autopartes</h3>
            <p class="subtitulo-login">Sistema de gestión</p>
        </div>

        <div class="card shadow">
            <div class="card-body p-4">

                <h5 class="mb-3">Iniciar sesión</h5>

                <?php if($error != ""){ ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Usuario</label>
                        <input type="text" name="usuario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="clave" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-rojo w-100">Ingresar</button>
                </form>

            </div>
        </div>

        <p class="pie-login">Kachow Autopartes S.A. &middot; <?php echo date("Y"); ?></p>

    </div>

</body>
</html>
