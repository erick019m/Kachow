<?php
    include("verificar.php");
    include("conexion.php");
    include("horario.php");

    if(!isset($_GET["id"])){
        header("location: citas.php");
        exit;
    }

    $titulo = "Editar cita";

    $id = intval($_GET['id']);

    $resultado = mysqli_query($conexion, "select * from citas where id=$id");

    if(mysqli_num_rows($resultado) == 0){
        $_SESSION['mensaje'] = "Esa cita no existe";
        $_SESSION['tipo'] = "danger";
        header("location: citas.php");
        exit;
    }

    $cita = mysqli_fetch_assoc($resultado);

    $clientes = mysqli_query($conexion, "select * from clientes order by nombre");

    $asesores = mysqli_query($conexion, "select id, nombre from usuarios
                                         where rol='vendedor' and activo=1 order by nombre");

    $hora_cita = substr($cita['hora'], 0, 5);

    include("menu.php");
?>

    <h2 class="mb-4">Editar cita</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Datos de la cita</div>
        <div class="card-body">

            <form action="citas_actualizar.php" method="POST">

                <input type="hidden" name="id" value="<?php echo $cita['id']; ?>">

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cliente</label>
                        <select name="cliente_id" class="form-select" required>
                            <?php while($cliente = mysqli_fetch_assoc($clientes)){ ?>
                                <option value="<?php echo $cliente['id']; ?>"
                                    <?php if($cliente['id'] == $cita['cliente_id']){ echo "selected"; } ?>>
                                    <?php echo $cliente['nombre']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Vehiculo</label>
                        <input type="text" name="vehiculo" class="form-control" maxlength="100"
                               value="<?php echo htmlspecialchars($cita['vehiculo']); ?>" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-control"
                               value="<?php echo $cita['fecha']; ?>" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Hora</label>
                        <select name="hora" class="form-select" required>
                            <option value="">--:--</option>
                            <optgroup label="Manana">
                                <?php foreach($horas_manana as $h){ ?>
                                    <option value="<?php echo $h; ?>"
                                        <?php if($h == $hora_cita){ echo "selected"; } ?>><?php echo $h; ?></option>
                                <?php } ?>
                            </optgroup>
                            <optgroup label="Tarde (lunes a viernes)">
                                <?php foreach($horas_tarde as $h){ ?>
                                    <option value="<?php echo $h; ?>"
                                        <?php if($h == $hora_cita){ echo "selected"; } ?>><?php echo $h; ?></option>
                                <?php } ?>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Asesor</label>
                        <select name="asesor_id" class="form-select" required>
                            <option value="">Seleccione un asesor</option>
                            <?php while($asesor = mysqli_fetch_assoc($asesores)){ ?>
                                <option value="<?php echo $asesor['id']; ?>"
                                    <?php if($asesor['id'] == $cita['asesor_id']){ echo "selected"; } ?>>
                                    <?php echo $asesor['nombre']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Motivo</label>
                        <input type="text" name="motivo" class="form-control" maxlength="255"
                               value="<?php echo htmlspecialchars($cita['motivo']); ?>">
                    </div>
                </div>

                <p class="form-text">
                    Horario de atencion: lunes a viernes de 08:30 a 12:30 y de 14:30 a 18:30;
                    sabados de 08:30 a 12:30. Domingos cerrado.
                </p>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="citas.php" class="btn btn-secondary">Cancelar</a>

            </form>

        </div>
    </div>

<?php include("pie.php"); ?>
