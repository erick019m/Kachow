<?php
    include("verificar.php");
    include("conexion.php");

    $titulo = "Productos";

    $texto = "";
    $buscar = "";

    if(isset($_GET['buscar'])){
        $texto = trim($_GET['buscar']);
        $buscar = mysqli_real_escape_string($conexion, $texto);
    }

    if($buscar != ""){
        $consulta = "select * from productos
                     where nombre like '%$buscar%' or codigo like '%$buscar%'
                        or categoria like '%$buscar%'
                     order by nombre";
    }else{
        $consulta = "select * from productos order by nombre";
    }

    $resultado = mysqli_query($conexion, $consulta);

    include("menu.php");
?>

    <h2 class="mb-4">Productos</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Registrar producto</div>
        <div class="card-body">

            <form action="productos_registrar.php" method="POST">
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Codigo</label>
                        <input type="text" name="codigo" class="form-control" maxlength="20" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" maxlength="120" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Categoria</label>
                        <input type="text" name="categoria" class="form-control" maxlength="50" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Marca</label>
                        <input type="text" name="marca" class="form-control" maxlength="50">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" min="0" max="100000" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Stock minimo</label>
                        <input type="number" name="stock_minimo" class="form-control" min="0" max="100000" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Precio (Bs)</label>
                        <input type="number" name="precio" class="form-control" step="0.01" min="0.01" max="1000000" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">
            Lista de productos (<?php echo mysqli_num_rows($resultado); ?>)
        </div>
        <div class="card-body">

            <form action="productos.php" method="GET" class="row g-2 mb-3">
                <div class="col-md-5">
                    <input type="text" name="buscar" class="form-control"
                           placeholder="Buscar por nombre, codigo o categoria"
                           value="<?php echo htmlspecialchars($texto); ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-secondary">Buscar</button>
                    <a href="productos.php" class="btn btn-outline-secondary">Ver todos</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Marca</th>
                            <th>Stock</th>
                            <th>Precio (Bs)</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(mysqli_num_rows($resultado) > 0){ ?>
                        <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>
                            <tr>
                                <td><?php echo $fila['codigo']; ?></td>
                                <td><?php echo $fila['nombre']; ?></td>
                                <td><?php echo $fila['categoria']; ?></td>
                                <td><?php echo $fila['marca']; ?></td>
                                <td>
                                    <?php if($fila['stock'] <= $fila['stock_minimo']){ ?>
                                        <span class="badge bg-danger"><?php echo $fila['stock']; ?></span>
                                    <?php }else{ ?>
                                        <?php echo $fila['stock']; ?>
                                    <?php } ?>
                                </td>
                                <td><?php echo number_format($fila['precio'], 2); ?></td>
                                <td class="text-nowrap">
                                    <a href="productos_editar.php?id=<?php echo $fila['id']; ?>"
                                       class="btn btn-sm btn-warning">Editar</a>
                                    <a href="productos_eliminar.php?id=<?php echo $fila['id']; ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Seguro que desea eliminar este producto?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php }else{ ?>
                        <tr>
                            <td colspan="7">No se encontraron productos</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

<?php include("pie.php"); ?>
