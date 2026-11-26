<?php
    include("auth.php");
    include("conexion.php");
    include("rubros.php");

    $titulo = "Proveedores";

    $texto = "";
    $buscar = "";
    $rubro = "";

    if(isset($_GET['buscar'])){
        $texto = trim($_GET['buscar']);
        $buscar = mysqli_real_escape_string($conexion, $texto);
    }

    if(isset($_GET['rubro']) && in_array($_GET['rubro'], $rubros)){
        $rubro = $_GET['rubro'];
    }

    $condicion = "";

    if($buscar != ""){
        $condicion = "where (nombre like '%$buscar%' or nit like '%$buscar%')";
    }

    if($rubro != ""){
        if($condicion == ""){
            $condicion = "where rubro='$rubro'";
        }else{
            $condicion = $condicion . " and rubro='$rubro'";
        }
    }

    $consulta = "select * from proveedores $condicion order by nombre";

    $resultado = mysqli_query($conexion, $consulta);

    $conteo = array();

    $resultado_rubros = mysqli_query($conexion, "select rubro, count(*) as total
                                                 from proveedores group by rubro");

    while($fila_rubro = mysqli_fetch_assoc($resultado_rubros)){
        $conteo[$fila_rubro['rubro']] = $fila_rubro['total'];
    }

    include("menu.php");
?>

    <h2 class="mb-4">Proveedores</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Registrar proveedor</div>
        <div class="card-body">

            <form action="proveedores_registrar.php" method="POST">
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Nombre o razon social</label>
                        <input type="text" name="nombre" class="form-control" maxlength="120" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">NIT</label>
                        <input type="text" name="nit" class="form-control" maxlength="15"
                               pattern="[0-9]{5,15}" title="Solo numeros, entre 5 y 15" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Rubro</label>
                        <select name="rubro" class="form-select" required>
                            <option value="">Seleccione un rubro</option>
                            <?php foreach($rubros as $r){ ?>
                                <option value="<?php echo $r; ?>"><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Persona de contacto</label>
                        <input type="text" name="contacto" class="form-control" maxlength="100">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Telefono</label>
                        <input type="text" name="telefono" class="form-control" maxlength="8"
                               pattern="[0-9]{7,8}" title="7 u 8 numeros">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Correo</label>
                        <input type="email" name="correo" class="form-control" maxlength="100">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Direccion</label>
                        <input type="text" name="direccion" class="form-control" maxlength="150">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">
            Lista de proveedores (<?php echo mysqli_num_rows($resultado); ?>)
        </div>
        <div class="card-body">

            <div class="mb-3">
                <a href="proveedores.php"
                   class="btn btn-sm <?php if($rubro == ""){ echo "btn-dark"; }else{ echo "btn-outline-dark"; } ?> mb-1">Todos</a>
                <?php foreach($rubros as $r){ ?>
                    <a href="proveedores.php?rubro=<?php echo $r; ?>"
                       class="btn btn-sm <?php if($rubro == $r){ echo "btn-dark"; }else{ echo "btn-outline-dark"; } ?> mb-1">
                        <?php echo $r; ?>
                        (<?php if(isset($conteo[$r])){ echo $conteo[$r]; }else{ echo 0; } ?>)
                    </a>
                <?php } ?>
            </div>

            <form action="proveedores.php" method="GET" class="row g-2 mb-3">
                <input type="hidden" name="rubro" value="<?php echo $rubro; ?>">
                <div class="col-md-5">
                    <input type="text" name="buscar" class="form-control"
                           placeholder="Buscar por nombre o NIT"
                           value="<?php echo htmlspecialchars($texto); ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-secondary">Buscar</button>
                    <a href="proveedores.php" class="btn btn-outline-secondary">Ver todos</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>NIT</th>
                            <th>Rubro</th>
                            <th>Contacto</th>
                            <th>Telefono</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(mysqli_num_rows($resultado) > 0){ ?>
                        <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>
                            <tr>
                                <td><?php echo $fila['nombre']; ?></td>
                                <td><?php echo $fila['nit']; ?></td>
                                <td><span class="badge bg-secondary"><?php echo $fila['rubro']; ?></span></td>
                                <td><?php echo $fila['contacto']; ?></td>
                                <td><?php echo $fila['telefono']; ?></td>
                                <td><?php echo $fila['correo']; ?></td>
                                <td class="text-nowrap">
                                    <a href="proveedores_editar.php?id=<?php echo $fila['id']; ?>"
                                       class="btn btn-sm btn-warning">Editar</a>
                                    <a href="proveedores_eliminar.php?id=<?php echo $fila['id']; ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Seguro que desea eliminar este proveedor?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php }else{ ?>
                        <tr>
                            <td colspan="7">No se encontraron proveedores</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

<?php include("pie.php"); ?>
