<?php
    include("verificar.php");
    include("conexion.php");
    include("horario.php");

    $titulo = "Citas";

    $hoy = date("Y-m-d");

    $clientes = mysqli_query($conexion, "select * from clientes order by nombre");

    $asesores = mysqli_query($conexion, "select id, nombre from usuarios
                                         where rol='vendedor' and activo=1 order by nombre");

    $consulta = "select citas.*, clientes.nombre as cliente, usuarios.nombre as asesor
                 from citas
                 inner join clientes on citas.cliente_id = clientes.id
                 inner join usuarios on citas.asesor_id = usuarios.id
                 order by citas.fecha, citas.hora";

    $resultado = mysqli_query($conexion, $consulta);

    include("menu.php");
?>

    <h2 class="mb-4">Citas de servicio</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Registrar cita</div>
        <div class="card-body">

            <form action="citas_registrar.php" method="POST">
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
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Vehiculo</label>
                        <input type="text" name="vehiculo" class="form-control" maxlength="100"
                               placeholder="Marca, modelo y ano" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-control"
                               min="<?php echo $hoy; ?>" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Hora</label>
                        <select name="hora" class="form-select" required>
                            <option value="">--:--</option>
                            <optgroup label="Manana">
                                <?php foreach($horas_manana as $h){ ?>
                                    <option value="<?php echo $h; ?>"><?php echo $h; ?></option>
                                <?php } ?>
                            </optgroup>
                            <optgroup label="Tarde (lunes a viernes)">
                                <?php foreach($horas_tarde as $h){ ?>
                                    <option value="<?php echo $h; ?>"><?php echo $h; ?></option>
                                <?php } ?>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Asesor</label>
                        <select name="asesor_id" class="form-select" required>
                            <option value="">Seleccione un asesor</option>
                            <?php while($asesor = mysqli_fetch_assoc($asesores)){ ?>
                                <option value="<?php echo $asesor['id']; ?>">
                                    <?php echo $asesor['nombre']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Motivo</label>
                        <input type="text" name="motivo" class="form-control" maxlength="255">
                    </div>
                </div>
                <p class="form-text">
                    Horario de atencion: lunes a viernes de 08:30 a 12:30 y de 14:30 a 18:30;
                    sabados de 08:30 a 12:30. Domingos cerrado.
                </p>
                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">
            Lista de citas (<?php echo mysqli_num_rows($resultado); ?>)
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado</th>
                            <th>Cliente</th>
                            <th>Vehiculo</th>
                            <th>Asesor</th>
                            <th>Motivo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(mysqli_num_rows($resultado) > 0){ ?>
                        <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>
                            <tr>
                                <td><?php echo date("d/m/Y", strtotime($fila['fecha'])); ?></td>
                                <td><?php echo substr($fila['hora'], 0, 5); ?></td>
                                <td>
                                    <?php if($fila['fecha'] == $hoy){ ?>
                                        <span class="badge bg-success">Hoy</span>
                                    <?php }else if($fila['fecha'] > $hoy){ ?>
                                        <span class="badge bg-primary">Proxima</span>
                                    <?php }else{ ?>
                                        <span class="badge bg-secondary">Pasada</span>
                                    <?php } ?>
                                </td>
                                <td><?php echo $fila['cliente']; ?></td>
                                <td><?php echo $fila['vehiculo']; ?></td>
                                <td><?php echo $fila['asesor']; ?></td>
                                <td><?php echo $fila['motivo']; ?></td>
                                <td class="text-nowrap">
                                    <a href="citas_editar.php?id=<?php echo $fila['id']; ?>"
                                       class="btn btn-sm btn-warning">Editar</a>
                                    <a href="citas_eliminar.php?id=<?php echo $fila['id']; ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Seguro que desea eliminar esta cita?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php }else{ ?>
                        <tr>
                            <td colspan="8">No existen citas registradas</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

<?php include("pie.php"); ?>
