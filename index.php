<?php
    include("verificar.php");
    include("conexion.php");

    $titulo = "Panel principal";

    $hoy = date("Y-m-d");
    $inicioMes = date("Y-m-01");

    $resultado = mysqli_query($conexion, "select count(*) as total from clientes");
    $totalClientes = mysqli_fetch_assoc($resultado)['total'];

    $resultado = mysqli_query($conexion, "select count(*) as total from productos");
    $totalProductos = mysqli_fetch_assoc($resultado)['total'];

    $resultado = mysqli_query($conexion, "select count(*) as total from citas where fecha='$hoy'");
    $citasHoy = mysqli_fetch_assoc($resultado)['total'];

    $resultado = mysqli_query($conexion, "select count(*) as cantidad, sum(total) as suma from ventas where fecha='$hoy'");
    $ventasHoy = mysqli_fetch_assoc($resultado);

    if($ventasHoy['suma'] == ""){
        $ventasHoy['suma'] = 0;
    }

    $resultado = mysqli_query($conexion, "select count(*) as total from proveedores");
    $totalProveedores = mysqli_fetch_assoc($resultado)['total'];

    $consulta = "select count(*) as cantidad, sum(total) as suma from ventas
                 where fecha between '$inicioMes' and '$hoy'";
    $ventasMes = mysqli_fetch_assoc(mysqli_query($conexion, $consulta));

    if($ventasMes['suma'] == ""){
        $ventasMes['suma'] = 0;
    }

    $consulta = "select * from productos where stock <= stock_minimo order by stock asc";
    $bajos = mysqli_query($conexion, $consulta);

    include("menu.php");
?>

    <div class="d-flex justify-content-between align-items-start flex-wrap">
        <div>
            <h2 class="mb-1">Bienvenido, <?php echo $_SESSION['nombre']; ?></h2>
            <p class="text-muted mb-4">Hoy es <?php echo date("d/m/Y"); ?></p>
        </div>
        <a href="manual.php" class="btn btn-outline-primary mb-3">Manual de usuario</a>
    </div>

    <div class="row">
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm tarjeta tarjeta-azul">
                <div class="card-body">
                    <div class="tarjeta-titulo">Clientes</div>
                    <div class="numero-tarjeta"><?php echo $totalClientes; ?></div>
                    <a href="clientes.php" class="tarjeta-enlace">Ver clientes</a>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm tarjeta tarjeta-verde">
                <div class="card-body">
                    <div class="tarjeta-titulo">Productos</div>
                    <div class="numero-tarjeta"><?php echo $totalProductos; ?></div>
                    <a href="productos.php" class="tarjeta-enlace">Ver productos</a>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm tarjeta tarjeta-amarilla">
                <div class="card-body">
                    <div class="tarjeta-titulo">Citas de hoy</div>
                    <div class="numero-tarjeta"><?php echo $citasHoy; ?></div>
                    <a href="citas.php" class="tarjeta-enlace">Ver citas</a>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm tarjeta tarjeta-roja">
                <div class="card-body">
                    <div class="tarjeta-titulo">Ventas de hoy</div>
                    <div class="numero-tarjeta"><?php echo $ventasHoy['cantidad']; ?></div>
                    <div class="tarjeta-detalle">Bs <?php echo number_format($ventasHoy['suma'], 2); ?></div>
                    <a href="ventas.php" class="tarjeta-enlace">Ver ventas</a>
                </div>
            </div>
        </div>
    </div>

    <?php if($_SESSION['rol'] == "administrador"){ ?>
        <div class="card shadow-sm resumen">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                <div class="mb-2">
                    <div class="tarjeta-titulo">Ventas de este mes</div>
                    <div class="numero-resumen">Bs <?php echo number_format($ventasMes['suma'], 2); ?></div>
                    <div>
                        <?php echo $ventasMes['cantidad']; ?> ventas &middot;
                        <?php echo $totalProveedores; ?> proveedores registrados
                    </div>
                </div>
                <div>
                    <a href="reportes.php" class="btn btn-sm btn-outline-light">Reportes</a>
                    <a href="proveedores.php" class="btn btn-sm btn-outline-light">Proveedores</a>
                    <a href="respaldo.php" class="btn btn-sm btn-outline-light">Respaldo</a>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Productos con stock bajo</div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Stock</th>
                            <th>Stock mínimo</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(mysqli_num_rows($bajos) > 0){ ?>
                        <?php while($fila = mysqli_fetch_assoc($bajos)){ ?>
                            <tr>
                                <td><?php echo $fila['codigo']; ?></td>
                                <td><?php echo $fila['nombre']; ?></td>
                                <td><span class="badge bg-danger"><?php echo $fila['stock']; ?></span></td>
                                <td><?php echo $fila['stock_minimo']; ?></td>
                            </tr>
                        <?php } ?>
                    <?php }else{ ?>
                        <tr>
                            <td colspan="4">No hay productos con stock bajo</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

<?php include("pie.php"); ?>
