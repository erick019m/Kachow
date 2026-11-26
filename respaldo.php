<?php
    include("auth.php");
    include("conexion.php");

    $titulo = "Respaldo";

    $archivos = scandir("respaldos");
    rsort($archivos);

    include("menu.php");
?>

    <h2 class="mb-4">Respaldo de la base de datos</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Crear un respaldo</div>
        <div class="card-body">
            <p class="text-muted">
                Se genera un archivo .sql con todas las tablas y todos los datos del sistema.
            </p>
            <a href="respaldo_crear.php" class="btn btn-primary">Crear respaldo ahora</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Respaldos guardados</div>
        <div class="card-body">

            <div class="alert alert-warning">
                Al restaurar un respaldo se borran los datos actuales y se cargan los del archivo.
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Archivo</th>
                            <th>Tamano</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $cuantos = 0;

                        foreach($archivos as $archivo){

                            if($archivo != "." && $archivo != ".." && strpos($archivo, ".sql") > 0){

                                $cuantos = $cuantos + 1;
                                $peso = round(filesize("respaldos/" . $archivo) / 1024, 1);
                    ?>
                            <tr>
                                <td><?php echo $archivo; ?></td>
                                <td><?php echo $peso; ?> KB</td>
                                <td class="text-nowrap">
                                    <a href="respaldo_descargar.php?archivo=<?php echo $archivo; ?>"
                                       class="btn btn-sm btn-success">Descargar</a>
                                    <a href="respaldo_restaurar.php?archivo=<?php echo $archivo; ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Se reemplazaran todos los datos actuales. Continuar?')">Restaurar</a>
                                </td>
                            </tr>
                    <?php
                            }
                        }

                        if($cuantos == 0){
                    ?>
                            <tr>
                                <td colspan="3">Todavia no hay respaldos guardados</td>
                            </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

<?php include("pie.php"); ?>
