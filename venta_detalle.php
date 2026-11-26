<?php
    include("verificar.php");
    include("conexion.php");

    if(!isset($_GET["id"])){
        header("location: ventas.php");
        exit;
    }

    $titulo = "Detalle de venta";

    $id = intval($_GET['id']);

    $consulta = "select ventas.*, clientes.nombre as cliente, clientes.documento
                 from ventas
                 inner join clientes on ventas.cliente_id = clientes.id
                 where ventas.id = $id";

    $resultado = mysqli_query($conexion, $consulta);

    if(mysqli_num_rows($resultado) == 0){
        $_SESSION['mensaje'] = "Esa venta no existe";
        $_SESSION['tipo'] = "danger";
        header("location: ventas.php");
        exit;
    }

    $venta = mysqli_fetch_assoc($resultado);

    $productos = mysqli_query($conexion, "select * from productos where stock > 0 order by nombre");

    $consulta = "select venta_detalle.*, productos.codigo, productos.nombre
                 from venta_detalle
                 inner join productos on venta_detalle.producto_id = productos.id
                 where venta_detalle.venta_id = $id";

    $detalle = mysqli_query($conexion, $consulta);

    include("menu.php");
?>

    <h2 class="mb-4">Venta N <?php echo $venta['id']; ?></h2>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Datos de la venta</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <b>Cliente:</b> <?php echo $venta['cliente']; ?> (<?php echo $venta['documento']; ?>)
                </div>
                <div class="col-md-3 mb-2">
                    <b>Fecha:</b> <?php echo date("d/m/Y", strtotime($venta['fecha'])); ?>
                </div>
                <div class="col-md-3 mb-2">
                    <b>Metodo de pago:</b> <?php echo $venta['metodo_pago']; ?>
                </div>
                <div class="col-md-2 mb-2">
                    <b>Total:</b> Bs <?php echo number_format($venta['total'], 2); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Agregar producto a la venta</div>
        <div class="card-body">

            <form action="venta_agregar.php" method="POST">

                <input type="hidden" name="venta_id" value="<?php echo $venta['id']; ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Producto</label>
                        <select name="producto_id" class="form-select" required>
                            <option value="">Seleccione un producto</option>
                            <?php while($producto = mysqli_fetch_assoc($productos)){ ?>
                                <option value="<?php echo $producto['id']; ?>">
                                    <?php echo $producto['codigo']; ?> -
                                    <?php echo $producto['nombre']; ?>
                                    (Bs <?php echo number_format($producto['precio'], 2); ?>,
                                    stock <?php echo $producto['stock']; ?>)
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="number" name="cantidad" class="form-control" min="1" value="1" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Agregar</button>
                <a href="ventas.php" class="btn btn-secondary">Volver a ventas</a>

            </form>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Productos de esta venta</div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Codigo</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio (Bs)</th>
                            <th>Subtotal (Bs)</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(mysqli_num_rows($detalle) > 0){ ?>
                        <?php while($fila = mysqli_fetch_assoc($detalle)){ ?>
                            <tr>
                                <td><?php echo $fila['codigo']; ?></td>
                                <td><?php echo $fila['nombre']; ?></td>
                                <td><?php echo $fila['cantidad']; ?></td>
                                <td><?php echo number_format($fila['precio'], 2); ?></td>
                                <td><?php echo number_format($fila['subtotal'], 2); ?></td>
                                <td>
                                    <a href="venta_quitar.php?id=<?php echo $fila['id']; ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Quitar este producto de la venta?')">Quitar</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php }else{ ?>
                        <tr>
                            <td colspan="6">Esta venta todavia no tiene productos</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">TOTAL</th>
                            <th colspan="2">Bs <?php echo number_format($venta['total'], 2); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>

<?php include("pie.php"); ?>
