<?php
    include("verificar.php");
    include("conexion.php");

    if(!isset($_GET["id"])){
        header("location: productos.php");
        exit;
    }

    $titulo = "Editar producto";

    $id = intval($_GET['id']);

    $resultado = mysqli_query($conexion, "select * from productos where id=$id");

    if(mysqli_num_rows($resultado) == 0){
        $_SESSION['mensaje'] = "Ese producto no existe";
        $_SESSION['tipo'] = "danger";
        header("location: productos.php");
        exit;
    }

    $producto = mysqli_fetch_assoc($resultado);

    include("menu.php");
?>

    <h2 class="mb-4">Editar producto</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Datos del producto</div>
        <div class="card-body">

            <form action="productos_actualizar.php" method="POST">

                <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Codigo</label>
                        <input type="text" name="codigo" class="form-control" maxlength="20"
                               value="<?php echo htmlspecialchars($producto['codigo']); ?>" required>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" maxlength="120"
                               value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Categoria</label>
                        <input type="text" name="categoria" class="form-control" maxlength="50"
                               value="<?php echo htmlspecialchars($producto['categoria']); ?>" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Marca</label>
                        <input type="text" name="marca" class="form-control" maxlength="50"
                               value="<?php echo htmlspecialchars($producto['marca']); ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" min="0" max="100000"
                               value="<?php echo $producto['stock']; ?>" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Stock minimo</label>
                        <input type="number" name="stock_minimo" class="form-control" min="0" max="100000"
                               value="<?php echo $producto['stock_minimo']; ?>" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Precio (Bs)</label>
                        <input type="number" name="precio" class="form-control" step="0.01" min="0.01" max="1000000"
                               value="<?php echo $producto['precio']; ?>" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="productos.php" class="btn btn-secondary">Cancelar</a>

            </form>

        </div>
    </div>

<?php include("pie.php"); ?>
