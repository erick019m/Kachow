<?php
    include("verificar.php");
    include("conexion.php");

    $titulo = "Clientes";

    $texto = "";
    $buscar = "";

    if(isset($_GET['buscar'])){
        $texto = trim($_GET['buscar']);
        $buscar = mysqli_real_escape_string($conexion, $texto);
    }

    if($buscar != ""){
        $consulta = "select * from clientes
                     where nombre like '%$buscar%' or documento like '%$buscar%'
                     order by nombre";
    }else{
        $consulta = "select * from clientes order by nombre";
    }

    $resultado = mysqli_query($conexion, $consulta);

    include("menu.php");
?>

    <h2 class="mb-4">Clientes</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Registrar cliente</div>
        <div class="card-body">

            <form action="clientes_registrar.php" method="POST">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" maxlength="100" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Documento (CI o NIT)</label>
                        <input type="text" name="documento" class="form-control" maxlength="15"
                               pattern="[0-9]{5,15}" title="Solo numeros, entre 5 y 15" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Telefono</label>
                        <input type="text" name="telefono" class="form-control" maxlength="8"
                               pattern="[0-9]{7,8}" title="7 u 8 numeros">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Correo</label>
                        <input type="email" name="correo" class="form-control" maxlength="100">
                    </div>
                    <div class="col-md-8 mb-3">
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
            Lista de clientes (<?php echo mysqli_num_rows($resultado); ?>)
        </div>
        <div class="card-body">

            <form action="clientes.php" method="GET" class="row g-2 mb-3">
                <div class="col-md-5">
                    <input type="text" name="buscar" class="form-control"
                           placeholder="Buscar por nombre o documento"
                           value="<?php echo htmlspecialchars($texto); ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-secondary">Buscar</button>
                    <a href="clientes.php" class="btn btn-outline-secondary">Ver todos</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Telefono</th>
                            <th>Correo</th>
                            <th>Direccion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(mysqli_num_rows($resultado) > 0){ ?>
                        <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>
                            <tr>
                                <td><?php echo $fila['nombre']; ?></td>
                                <td><?php echo $fila['documento']; ?></td>
                                <td><?php echo $fila['telefono']; ?></td>
                                <td><?php echo $fila['correo']; ?></td>
                                <td><?php echo $fila['direccion']; ?></td>
                                <td class="text-nowrap">
                                    <a href="clientes_editar.php?id=<?php echo $fila['id']; ?>"
                                       class="btn btn-sm btn-warning">Editar</a>
                                    <a href="clientes_eliminar.php?id=<?php echo $fila['id']; ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Seguro que desea eliminar este cliente?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php }else{ ?>
                        <tr>
                            <td colspan="6">No se encontraron clientes</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

<?php include("pie.php"); ?>
