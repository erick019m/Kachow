<?php
    include("auth.php");
    include("conexion.php");

    $titulo = "Reportes";

    $desde = date("Y-m-01");
    $hasta = date("Y-m-d");

    if(isset($_GET['desde']) && $_GET['desde'] != ""){
        $desde = $_GET['desde'];
    }

    if(isset($_GET['hasta']) && $_GET['hasta'] != ""){
        $hasta = $_GET['hasta'];
    }

    $errorFechas = "";

    if(date("Y-m-d", strtotime($desde)) != $desde || date("Y-m-d", strtotime($hasta)) != $hasta){
        $errorFechas = "Alguna de las fechas no es valida. Se muestra el mes actual.";
        $desde = date("Y-m-01");
        $hasta = date("Y-m-d");
    }else if($desde > $hasta){
        $errorFechas = "La fecha Desde no puede ser mayor que la fecha Hasta.";
    }

    $desde = mysqli_real_escape_string($conexion, $desde);
    $hasta = mysqli_real_escape_string($conexion, $hasta);

    $consulta = "select ventas.*, clientes.nombre as cliente
                 from ventas
                 inner join clientes on ventas.cliente_id = clientes.id
                 where ventas.fecha between '$desde' and '$hasta'
                 order by ventas.fecha";

    $ventas = mysqli_query($conexion, $consulta);

    $consulta = "select count(*) as cantidad, sum(total) as suma
                 from ventas
                 where fecha between '$desde' and '$hasta'";

    $resumen = mysqli_fetch_assoc(mysqli_query($conexion, $consulta));

    if($resumen['suma'] == ""){
        $resumen['suma'] = 0;
    }

    $consulta = "select productos.codigo, productos.nombre,
                        sum(venta_detalle.cantidad) as unidades,
                        sum(venta_detalle.subtotal) as importe
                 from venta_detalle
                 inner join ventas on venta_detalle.venta_id = ventas.id
                 inner join productos on venta_detalle.producto_id = productos.id
                 where ventas.fecha between '$desde' and '$hasta'
                 group by productos.id, productos.codigo, productos.nombre
                 order by unidades desc";

    $masVendidos = mysqli_query($conexion, $consulta);

    include("menu.php");
?>

    <h2 class="mb-4">Reportes</h2>

    <?php if($errorFechas != ""){ ?>
        <div class="alert alert-warning"><?php echo $errorFechas; ?></div>
    <?php } ?>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Periodo del reporte</div>
        <div class="card-body">

            <form action="reportes.php" method="GET" class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Desde</label>
                    <input type="date" name="desde" class="form-control" value="<?php echo $desde; ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Hasta</label>
                    <input type="date" name="hasta" class="form-control" value="<?php echo $hasta; ?>">
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Ver reporte</button>
                </div>
            </form>

            <p class="mb-0">
                En este periodo se registraron
                <b><?php echo $resumen['cantidad']; ?></b> venta(s)
                por un total de
                <b>Bs <?php echo number_format($resumen['suma'], 2); ?></b>
            </p>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Reporte en PDF</div>
        <div class="card-body">
            <p class="text-muted">
                Descarga un PDF con las ventas, el total general y el total por metodo de pago.
                Si cambia las fechas, primero presione Ver reporte.
            </p>

            <p>
                Periodo del PDF: <b><?php echo date("d/m/Y", strtotime($desde)); ?></b>
                al <b><?php echo date("d/m/Y", strtotime($hasta)); ?></b>
            </p>

            <a class="btn btn-success"
               href="reporte_pdf.php?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>">
               Descargar PDF de ventas</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Descargar en Excel</div>
        <div class="card-body">
            <p class="text-muted">Los archivos se descargan en formato CSV y se abren con Excel.</p>

            <a class="btn btn-success"
               href="exportar.php?tipo=ventas&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>">
               Ventas</a>

            <a class="btn btn-success"
               href="exportar.php?tipo=detalle&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>">
               Detalle de ventas</a>

            <a class="btn btn-success"
               href="exportar.php?tipo=productos&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>">
               Productos mas vendidos</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Ventas del periodo</div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>N</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Metodo de pago</th>
                            <th>Total (Bs)</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(mysqli_num_rows($ventas) > 0){ ?>
                        <?php while($fila = mysqli_fetch_assoc($ventas)){ ?>
                            <tr>
                                <td><?php echo $fila['id']; ?></td>
                                <td><?php echo date("d/m/Y", strtotime($fila['fecha'])); ?></td>
                                <td><?php echo $fila['cliente']; ?></td>
                                <td><?php echo $fila['metodo_pago']; ?></td>
                                <td><?php echo number_format($fila['total'], 2); ?></td>
                            </tr>
                        <?php } ?>
                    <?php }else{ ?>
                        <tr>
                            <td colspan="5">No hay ventas en este periodo</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Productos mas vendidos</div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Codigo</th>
                            <th>Producto</th>
                            <th>Unidades</th>
                            <th>Importe (Bs)</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(mysqli_num_rows($masVendidos) > 0){ ?>
                        <?php while($fila = mysqli_fetch_assoc($masVendidos)){ ?>
                            <tr>
                                <td><?php echo $fila['codigo']; ?></td>
                                <td><?php echo $fila['nombre']; ?></td>
                                <td><?php echo $fila['unidades']; ?></td>
                                <td><?php echo number_format($fila['importe'], 2); ?></td>
                            </tr>
                        <?php } ?>
                    <?php }else{ ?>
                        <tr>
                            <td colspan="4">No hay productos vendidos en este periodo</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

<?php include("pie.php"); ?>
