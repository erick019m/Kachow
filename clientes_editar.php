<?php
    include("verificar.php");
    include("conexion.php");

    if(!isset($_GET["id"])){
        header("location: clientes.php");
        exit;
    }

    $titulo = "Editar cliente";

    $id = intval($_GET['id']);

    $consulta = "select * from clientes where id=$id";
    $resultado = mysqli_query($conexion, $consulta);

    if(mysqli_num_rows($resultado) == 0){
        $_SESSION['mensaje'] = "Ese cliente no existe";
        $_SESSION['tipo'] = "danger";
        header("location: clientes.php");
        exit;
    }

    $cliente = mysqli_fetch_assoc($resultado);

    include("menu.php");
?>

    <h2 class="mb-4">Editar cliente</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Datos del cliente</div>
        <div class="card-body">

            <form action="clientes_actualizar.php" method="POST">

                <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" maxlength="100"
                               value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Documento</label>
                        <input type="text" name="documento" class="form-control" maxlength="15"
                               pattern="[0-9]{5,15}" title="Solo numeros, entre 5 y 15"
                               value="<?php echo htmlspecialchars($cliente['documento']); ?>" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Telefono</label>
                        <input type="text" name="telefono" class="form-control" maxlength="8"
                               pattern="[0-9]{7,8}" title="7 u 8 numeros"
                               value="<?php echo htmlspecialchars($cliente['telefono']); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Correo</label>
                        <input type="email" name="correo" class="form-control" maxlength="100"
                               value="<?php echo htmlspecialchars($cliente['correo']); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Direccion</label>
                        <input type="text" name="direccion" class="form-control" maxlength="150"
                               value="<?php echo htmlspecialchars($cliente['direccion']); ?>">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="clientes.php" class="btn btn-secondary">Cancelar</a>

            </form>

        </div>
    </div>

<?php include("pie.php"); ?>
