<?php
    include("auth.php");
    include("conexion.php");
    include("rubros.php");

    if(!isset($_GET["id"])){
        header("location: proveedores.php");
        exit;
    }

    $titulo = "Editar proveedor";

    $id = intval($_GET['id']);

    $resultado = mysqli_query($conexion, "select * from proveedores where id=$id");

    if(mysqli_num_rows($resultado) == 0){
        $_SESSION['mensaje'] = "Ese proveedor no existe";
        $_SESSION['tipo'] = "danger";
        header("location: proveedores.php");
        exit;
    }

    $proveedor = mysqli_fetch_assoc($resultado);

    include("menu.php");
?>

    <h2 class="mb-4">Editar proveedor</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Datos del proveedor</div>
        <div class="card-body">

            <form action="proveedores_actualizar.php" method="POST">

                <input type="hidden" name="id" value="<?php echo $proveedor['id']; ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre o razon social</label>
                        <input type="text" name="nombre" class="form-control" maxlength="120"
                               value="<?php echo htmlspecialchars($proveedor['nombre']); ?>" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">NIT</label>
                        <input type="text" name="nit" class="form-control" maxlength="15"
                               pattern="[0-9]{5,15}" title="Solo numeros, entre 5 y 15"
                               value="<?php echo htmlspecialchars($proveedor['nit']); ?>" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Rubro</label>
                        <select name="rubro" class="form-select" required>
                            <?php foreach($rubros as $r){ ?>
                                <option value="<?php echo $r; ?>"
                                    <?php if($r == $proveedor['rubro']){ echo "selected"; } ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Contacto</label>
                        <input type="text" name="contacto" class="form-control" maxlength="100"
                               value="<?php echo htmlspecialchars($proveedor['contacto']); ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Telefono</label>
                        <input type="text" name="telefono" class="form-control" maxlength="8"
                               pattern="[0-9]{7,8}" title="7 u 8 numeros"
                               value="<?php echo htmlspecialchars($proveedor['telefono']); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Correo</label>
                        <input type="email" name="correo" class="form-control" maxlength="100"
                               value="<?php echo htmlspecialchars($proveedor['correo']); ?>">
                    </div>
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Direccion</label>
                        <input type="text" name="direccion" class="form-control" maxlength="150"
                               value="<?php echo htmlspecialchars($proveedor['direccion']); ?>">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="proveedores.php" class="btn btn-secondary">Cancelar</a>

            </form>

        </div>
    </div>

<?php include("pie.php"); ?>
