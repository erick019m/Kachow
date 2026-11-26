<?php
    include("verificar.php");
    include("conexion.php");

    $titulo = "Ventas";

    $clientes = mysqli_query($conexion, "select * from clientes order by nombre");

    $consulta = "select ventas.*, clientes.nombre as cliente,
                        (select count(*) from venta_detalle where venta_id = ventas.id) as productos
                 from ventas
                 inner join clientes on ventas.cliente_id = clientes.id
                 order by ventas.fecha desc, ventas.id desc";

    $resultado = mysqli_query($conexion, $consulta);

    include("menu.php");
?>

    <h2 class="mb-4">Ventas</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Nueva venta</div>
        <div class="card-body">
            <p class="text-muted">Primero se crea la venta y despues se le agregan los productos.</p>

            <form action="venta_nueva.php" method="POST">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cliente</label>
                        <select name="cliente_id" class="form-select" required>
                            <option value="">Seleccione un cliente</option>
                            <?php while($cliente = mysqli_fetch_assoc($clientes)){ ?>
                                <option value="<?php echo $cliente['id']; ?>">
                                    <?php echo $cliente['nombre']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Metodo de pago</label>
                        <select name="metodo_pago" class="form-select" required>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="QR">QR</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-control"
                               value="<?php echo date("Y-m-d"); ?>" max="<?php echo date("Y-m-d"); ?>" required>
                        <div class="form-text">
                            Si se olvido registrar una venta, elija el dia en que se hizo.
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Crear venta</button>
            </form>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">
            Lista de ventas (<?php echo mysqli_num_rows($resultado); ?>)
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>N</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Metodo de pago</th>
                            <th>Productos</th>
                            <th>Total (Bs)</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(mysqli_num_rows($resultado) > 0){ ?>
                        <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>
                            <tr>
                                <td><?php echo $fila['id']; ?></td>
                                <td><?php echo date("d/m/Y", strtotime($fila['fecha'])); ?></td>
                                <td><?php echo $fila['cliente']; ?></td>
                                <td><?php echo $fila['metodo_pago']; ?></td>
                                <td>
                                    <?php if($fila['productos'] == 0){ ?>
                                        <span class="badge bg-warning text-dark">Sin productos</span>
                                    <?php }else{ ?>
                                        <?php echo $fila['productos']; ?>
                                    <?php } ?>
                                </td>
                                <td><?php echo number_format($fila['total'], 2); ?></td>
                                <td class="text-nowrap">
                                    <a href="venta_detalle.php?id=<?php echo $fila['id']; ?>"
                                       class="btn btn-sm btn-info">Ver detalle</a>
                                    <a href="venta_eliminar.php?id=<?php echo $fila['id']; ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Se eliminara la venta y se devolvera el stock. Continuar?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php }else{ ?>
                        <tr>
                            <td colspan="7">No existen ventas registradas</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

<?php include("pie.php"); ?>
