<?php
    $pagina = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $titulo; ?> - Kachow Autopartes</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="estilos.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark barra">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <span class="logo">K</span> Kachow <span class="marca-sub">Autopartes</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuPrincipal">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php if(strpos($pagina, "cliente") === 0){ echo "active"; } ?>" href="clientes.php">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if(strpos($pagina, "producto") === 0){ echo "active"; } ?>" href="productos.php">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if(strpos($pagina, "cita") === 0){ echo "active"; } ?>" href="citas.php">Citas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if(strpos($pagina, "venta") === 0){ echo "active"; } ?>" href="ventas.php">Ventas</a>
                    </li>

                    <?php if($_SESSION['rol'] == "administrador"){ ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if(strpos($pagina, "proveedor") === 0){ echo "active"; } ?>" href="proveedores.php">Proveedores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if(strpos($pagina, "reporte") === 0){ echo "active"; } ?>" href="reportes.php">Reportes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if(strpos($pagina, "respaldo") === 0){ echo "active"; } ?>" href="respaldo.php">Respaldo</a>
                        </li>
                    <?php } ?>
                </ul>

                <span class="navbar-text usuario-menu me-3">
                    <span class="avatar" title="<?php echo $_SESSION['nombre']; ?>"><?php echo substr($_SESSION['nombre'], 0, 1); ?></span>
                    <span class="d-lg-none d-xl-inline">
                        <?php echo $_SESSION['nombre']; ?>
                        <span class="badge rol-<?php echo $_SESSION['rol']; ?>"><?php echo $_SESSION['rol']; ?></span>
                    </span>
                </span>

                <a class="btn btn-sm btn-outline-light my-2 my-lg-0" href="salir.php">Salir</a>
            </div>
        </div>
    </nav>

    <div class="container contenido mt-4">

        <?php if(isset($_SESSION['mensaje'])){ ?>
            <div class="alert alert-<?php echo $_SESSION['tipo']; ?> alert-dismissible fade show">
                <?php echo $_SESSION['mensaje']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php
                unset($_SESSION['mensaje']);
                unset($_SESSION['tipo']);
            ?>
        <?php } ?>
