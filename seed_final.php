<?php
    include("auth.php");
    include("conexion.php");
    include("horario.php");
    include("rubros.php");

    if($_POST){

        mysqli_query($conexion, "set foreign_key_checks = 0");
        mysqli_query($conexion, "truncate table venta_detalle");
        mysqli_query($conexion, "truncate table ventas");
        mysqli_query($conexion, "truncate table citas");
        mysqli_query($conexion, "truncate table productos");
        mysqli_query($conexion, "truncate table proveedores");
        mysqli_query($conexion, "truncate table clientes");
        mysqli_query($conexion, "set foreign_key_checks = 1");

        $clave = password_hash("kachow123", PASSWORD_DEFAULT);

        $vendedores = array(
            array("mostrador", "Rodrigo Mamani"),
            array("carla", "Carla Rojas"),
            array("luis", "Luis Fernandez")
        );

        foreach($vendedores as $vendedor){
            $usuario = $vendedor[0];
            $nombre = $vendedor[1];

            $resultado = mysqli_query($conexion, "select * from usuarios where usuario='$usuario'");

            if(mysqli_num_rows($resultado) == 0){
                mysqli_query($conexion, "insert into usuarios (usuario, nombre, clave, rol)
                                         values ('$usuario', '$nombre', '$clave', 'vendedor')");
            }else{
                mysqli_query($conexion, "update usuarios set rol='vendedor', activo=1
                                         where usuario='$usuario'");
            }
        }

        mysqli_query($conexion, "insert into clientes (nombre, documento, telefono, correo, direccion) values
            ('Juan Perez Rojas', '6543210', '70000012', 'juan.perez@correo.com', 'Av. America 345'),
            ('Talleres Rocha SRL', '1023456027', '44000021', 'contacto@rocha.bo', 'Av. Blanco Galindo km 5'),
            ('Maria Quispe Choque', '7891234', '70000034', 'maria.quispe@correo.com', 'Calle Jordan 820'),
            ('Carlos Gutierrez Vega', '5512378', '71234567', 'carlos.gv@correo.com', 'Av. Heroinas 1100'),
            ('Ana Lucia Torrico', '6678123', '72345678', 'ana.torrico@correo.com', 'Calle Lanza 230'),
            ('Transportes Illimani SRL', '2034567015', '44223310', 'flota@illimani.bo', 'Av. Petrolera km 6'),
            ('Roberto Mamani Flores', '4456789', '73456789', '', 'Calle Esteban Arce 55'),
            ('Lucia Fernandez Rios', '8812345', '74567890', 'lucia.fr@correo.com', 'Av. Ayacucho 410'),
            ('Jorge Antezana Paz', '3398765', '75678901', 'jorge.antezana@correo.com', 'Calle 25 de Mayo 312'),
            ('Mecanica El Rapido', '1098234011', '44556610', 'elrapido@correo.com', 'Av. Republica 980'),
            ('Sofia Claros Vargas', '9023456', '76789012', 'sofia.claros@correo.com', 'Calle Bolivar 77'),
            ('Miguel Angel Soria', '5678901', '77890123', '', 'Av. Oquendo 640'),
            ('Patricia Rojas Lima', '7345612', '78901234', 'patricia.rl@correo.com', 'Calle Junin 150'),
            ('Fernando Siles Arce', '6123987', '79012345', 'fsiles@correo.com', 'Av. Aroma 220'),
            ('Daniela Camacho Rey', '8456123', '60123456', 'daniela.cr@correo.com', 'Calle Sucre 905')");

        mysqli_query($conexion, "insert into proveedores (nombre, nit, rubro, contacto, telefono, correo, direccion) values
            ('Llantas del Valle', '3012456018', 'Llantas', 'Pedro Arce', '44223344', 'pedidos@llantasvalle.bo', 'Av. Republica 1520'),
            ('Neumaticos Andinos SRL', '3018845012', 'Llantas', 'Pedro Lopez', '44221199', 'ventas@neumandinos.bo', 'Av. Blanco Galindo km 3'),
            ('Motores Cochabamba SRL', '3125987014', 'Motores', 'Juan Torrico', '44667788', 'ventas@motorescbba.bo', 'Av. Villazon km 3'),
            ('Plasticos Automotrices', '3240561019', 'Plasticos', 'Dennis Rocha', '44889900', 'info@plasticosauto.bo', 'Calle Tumusla 455'),
            ('Repuestos del Sur Ltda', '2056789033', 'Frenos', 'Hugo Vargas', '44556677', 'contacto@delsur.bo', 'Av. Blanco Galindo km 2'),
            ('Suspensiones Bolivia', '3356120017', 'Suspension', 'Mario Zeballos', '44331122', 'ventas@suspbol.bo', 'Av. Siete de Septiembre 300'),
            ('ElectroAuto Import', '3412078015', 'Electricos', 'Ruth Medina', '44778899', 'pedidos@electroauto.bo', 'Calle Punata 610'),
            ('Importadora Andina SRL', '1098765021', 'Lubricantes', 'Rosa Claros', '44112233', 'ventas@andina.bo', 'Av. Petrolera km 4'),
            ('Accesorios Kronos', '3520994013', 'Accesorios', 'Luis Ugarte', '44995511', 'kronos@correo.com', 'Calle Esteban Arce 1200')");

        mysqli_query($conexion, "insert into productos (codigo, nombre, categoria, marca, stock, stock_minimo, precio) values
            ('FA-001', 'Filtro de aire', 'Filtros', 'Bosch', 40, 5, 85.00),
            ('FA-002', 'Filtro de aceite', 'Filtros', 'Mann', 45, 8, 65.50),
            ('FC-003', 'Filtro de combustible', 'Filtros', 'Bosch', 20, 5, 95.00),
            ('PF-010', 'Pastillas de freno delanteras', 'Frenos', 'Brembo', 25, 4, 320.00),
            ('PF-011', 'Pastillas de freno traseras', 'Frenos', 'Brembo', 14, 4, 290.00),
            ('DF-012', 'Disco de freno ventilado', 'Frenos', 'Fremax', 10, 3, 450.00),
            ('AM-020', 'Amortiguador delantero', 'Suspension', 'Monroe', 9, 3, 540.00),
            ('AM-021', 'Amortiguador trasero', 'Suspension', 'Monroe', 8, 3, 480.00),
            ('RT-022', 'Rotula de suspension', 'Suspension', 'Moog', 12, 4, 150.00),
            ('BU-030', 'Bujia de encendido', 'Motor', 'NGK', 80, 10, 28.00),
            ('CD-031', 'Correa de distribucion', 'Motor', 'Gates', 11, 4, 260.00),
            ('BA-032', 'Bomba de agua', 'Motor', 'Aisin', 6, 2, 390.00),
            ('BA-040', 'Bateria 12V 75Ah', 'Electrico', 'Toyo', 8, 2, 780.00),
            ('AL-041', 'Alternador 90A', 'Electrico', 'Valeo', 4, 2, 1450.00),
            ('FO-042', 'Foco halogeno H4', 'Electrico', 'Philips', 30, 6, 45.00),
            ('LL-050', 'Llanta 185/65 R15', 'Llantas', 'Bridgestone', 24, 8, 620.00),
            ('LL-051', 'Llanta 205/55 R16', 'Llantas', 'Michelin', 16, 8, 850.00),
            ('AC-060', 'Aceite de motor 20W50 (4 L)', 'Lubricantes', 'Castrol', 35, 10, 180.00),
            ('AC-061', 'Aceite sintetico 5W30 (4 L)', 'Lubricantes', 'Mobil', 15, 6, 320.00),
            ('PA-070', 'Parachoques delantero', 'Carroceria', 'Generico', 3, 1, 980.00)");

        $citas = array(
            array(6, "Nissan Sentra 2016", -12, "08:30", "mostrador", "Asesoria de lubricantes"),
            array(11, "Toyota Corolla 2015", -9, "09:00", "carla", "Revision de frenos"),
            array(14, "Toyota RAV4 2016", -7, "10:00", "luis", "Revision de frenos"),
            array(6, "Chevrolet Spark 2018", -5, "11:00", "mostrador", "Cambio de filtros"),
            array(15, "Toyota RAV4 2016", -3, "11:30", "carla", "Cotizacion de llantas"),
            array(1, "Suzuki Vitara 2018", -2, "14:30", "luis", "Asesoria de lubricantes"),
            array(7, "Suzuki Vitara 2018", -1, "15:30", "mostrador", "Cotizacion de llantas"),
            array(2, "Toyota RAV4 2016", 0, "15:30", "mostrador", "Asesoria de lubricantes"),
            array(1, "Chevrolet Spark 2018", 0, "16:30", "carla", "Revision de frenos"),
            array(4, "Chevrolet Spark 2018", 1, "09:30", "mostrador", "Cambio de filtros"),
            array(10, "Chevrolet Spark 2018", 2, "10:30", "carla", "Asesoria de lubricantes"),
            array(1, "Toyota Hilux 2020", 3, "15:00", "luis", "Cambio de filtros"),
            array(9, "Nissan Sentra 2016", 4, "08:30", "mostrador", "Revision de bateria"),
            array(7, "Nissan Sentra 2016", 6, "09:00", "carla", "Revision de frenos"),
            array(10, "Hyundai Accent 2014", 8, "10:00", "luis", "Asesoria para cambio de amortiguadores"),
            array(2, "Chevrolet Spark 2018", 10, "11:00", "mostrador", "Cotizacion de llantas")
        );

        foreach($citas as $cita){
            $cliente_id = $cita[0];
            $vehiculo = $cita[1];
            $fecha = date("Y-m-d", strtotime($cita[2] . " days"));
            $hora = $cita[3];
            $usuario = $cita[4];
            $motivo = $cita[5];

            if(date("N", strtotime($fecha)) == 7){
                $fecha = date("Y-m-d", strtotime($fecha . " +1 day"));
            }

            if(date("N", strtotime($fecha)) == 6 && !in_array($hora, $horas_manana)){
                $hora = "10:00";
            }

            $resultado = mysqli_query($conexion, "select id from usuarios where usuario='$usuario'");
            $asesor_id = mysqli_fetch_assoc($resultado)['id'];

            $resultado = mysqli_query($conexion, "select * from citas
                                                  where fecha='$fecha' and hora='$hora' and asesor_id=$asesor_id");

            if(mysqli_num_rows($resultado) == 0){
                mysqli_query($conexion, "insert into citas (cliente_id, vehiculo, fecha, hora, asesor_id, motivo)
                                         values ($cliente_id, '$vehiculo', '$fecha', '$hora', $asesor_id, '$motivo')");
            }
        }

        $ventas = array(
            array(6, 84, "Efectivo"),
            array(11, 80, "Tarjeta"),
            array(5, 77, "Efectivo"),
            array(10, 73, "Transferencia"),
            array(9, 70, "QR"),
            array(15, 66, "QR"),
            array(13, 62, "Transferencia"),
            array(13, 58, "QR"),
            array(8, 55, "Efectivo"),
            array(5, 51, "QR"),
            array(10, 48, "Efectivo"),
            array(12, 44, "Efectivo"),
            array(8, 41, "QR"),
            array(6, 37, "QR"),
            array(3, 34, "Efectivo"),
            array(8, 30, "Tarjeta"),
            array(1, 27, "Efectivo"),
            array(12, 23, "Tarjeta"),
            array(7, 20, "Efectivo"),
            array(2, 17, "Efectivo"),
            array(1, 15, "Efectivo"),
            array(9, 12, "Efectivo"),
            array(10, 10, "QR"),
            array(6, 8, "Tarjeta"),
            array(8, 6, "QR"),
            array(12, 5, "Transferencia"),
            array(9, 3, "Transferencia"),
            array(13, 2, "Tarjeta"),
            array(15, 1, "Efectivo"),
            array(11, 0, "Efectivo")
        );

        $id_venta = array();
        $numero = 1;

        foreach($ventas as $venta){
            $cliente_id = $venta[0];
            $fecha = date("Y-m-d", strtotime("-" . $venta[1] . " days"));
            $metodo_pago = $venta[2];

            mysqli_query($conexion, "insert into ventas (cliente_id, fecha, metodo_pago, total)
                                     values ($cliente_id, '$fecha', '$metodo_pago', 0)");

            $id_venta[$numero] = mysqli_insert_id($conexion);
            $numero++;
        }

        $detalles = array(
            array(1, "FA-002", 2),
            array(1, "AC-060", 1),
            array(1, "FA-001", 1),
            array(2, "BU-030", 4),
            array(2, "FO-042", 2),
            array(3, "AM-020", 1),
            array(4, "LL-050", 4),
            array(4, "BU-030", 1),
            array(4, "FO-042", 1),
            array(5, "BU-030", 1),
            array(6, "FA-001", 2),
            array(6, "FA-002", 2),
            array(7, "CD-031", 1),
            array(7, "AC-060", 2),
            array(8, "FA-002", 1),
            array(9, "BU-030", 4),
            array(10, "FA-001", 1),
            array(10, "FO-042", 1),
            array(11, "FA-001", 1),
            array(11, "PF-011", 1),
            array(12, "AL-041", 1),
            array(12, "LL-050", 1),
            array(13, "RT-022", 2),
            array(13, "FC-003", 1),
            array(13, "FO-042", 2),
            array(14, "PF-010", 1),
            array(15, "DF-012", 1),
            array(16, "AM-021", 1),
            array(17, "LL-051", 4),
            array(17, "BA-032", 1),
            array(18, "FA-001", 1),
            array(18, "FO-042", 2),
            array(18, "AC-060", 1),
            array(19, "PA-070", 1),
            array(19, "AL-041", 1),
            array(20, "PF-010", 1),
            array(20, "FA-002", 2),
            array(21, "AC-060", 1),
            array(22, "AC-061", 1),
            array(22, "FA-001", 1),
            array(23, "PA-070", 1),
            array(24, "LL-050", 1),
            array(24, "FA-002", 1),
            array(25, "BU-030", 1),
            array(25, "FA-002", 1),
            array(26, "LL-050", 1),
            array(26, "PF-010", 1),
            array(27, "LL-051", 1),
            array(28, "FA-002", 2),
            array(28, "AM-021", 1),
            array(29, "DF-012", 2),
            array(29, "LL-051", 4),
            array(30, "PF-010", 2),
            array(30, "AM-020", 1),
            array(30, "AL-041", 1)
        );

        foreach($detalles as $detalle){
            $venta_id = $id_venta[$detalle[0]];
            $codigo = $detalle[1];
            $cantidad = $detalle[2];

            $resultado = mysqli_query($conexion, "select * from productos where codigo='$codigo'");
            $producto = mysqli_fetch_assoc($resultado);

            if($producto['stock'] >= $cantidad){
                $producto_id = $producto['id'];
                $precio = $producto['precio'];
                $subtotal = $precio * $cantidad;

                mysqli_query($conexion, "insert into venta_detalle (venta_id, producto_id, cantidad, precio, subtotal)
                                         values ($venta_id, $producto_id, $cantidad, $precio, $subtotal)");

                mysqli_query($conexion, "update productos set stock = stock - $cantidad where id=$producto_id");
            }
        }

        mysqli_query($conexion, "update ventas set total = (select ifnull(sum(subtotal), 0)
                                                            from venta_detalle
                                                            where venta_detalle.venta_id = ventas.id)");

        $_SESSION['mensaje'] = "Datos de demostracion cargados";
        $_SESSION['tipo'] = "success";
        header("location: seed_final.php");
        exit;
    }

    $titulo = "Datos de demostracion";

    $lista_rubros = "'" . implode("', '", $rubros) . "'";

    $revisiones = array(
        "Citas sin cliente" =>
            "select count(*) as total from citas where cliente_id not in (select id from clientes)",
        "Citas con un asesor que no es vendedor" =>
            "select count(*) as total from citas
             where asesor_id not in (select id from usuarios where rol='vendedor')",
        "Citas fuera del horario de atencion" =>
            "select count(*) as total from citas
             where dayofweek(fecha) = 1
                or (dayofweek(fecha) = 7 and hora > '12:00')
                or hora < '08:30' or hora > '18:00'
                or (hora > '12:00' and hora < '14:30')
                or minute(hora) not in (0, 30)",
        "Proveedores con un rubro fuera de la lista" =>
            "select count(*) as total from proveedores where rubro not in ($lista_rubros)",
        "Ventas sin cliente" =>
            "select count(*) as total from ventas where cliente_id not in (select id from clientes)",
        "Ventas con fecha futura" =>
            "select count(*) as total from ventas where fecha > curdate()",
        "Detalles sin venta o sin producto" =>
            "select count(*) as total from venta_detalle
             where venta_id not in (select id from ventas)
                or producto_id not in (select id from productos)",
        "Detalles con subtotal mal calculado" =>
            "select count(*) as total from venta_detalle where subtotal <> cantidad * precio",
        "Ventas cuyo total no es la suma de su detalle" =>
            "select count(*) as total from ventas
             where total <> (select ifnull(sum(subtotal), 0) from venta_detalle
                             where venta_detalle.venta_id = ventas.id)",
        "Productos con stock negativo" =>
            "select count(*) as total from productos where stock < 0"
    );

    $tablas = array("clientes", "productos", "proveedores", "citas", "ventas", "venta_detalle", "usuarios");

    $inicioMes = date("Y-m-01");
    $hoy = date("Y-m-d");

    $consulta = "select count(*) as cantidad, sum(total) as suma from ventas
                 where fecha between '$inicioMes' and '$hoy'";
    $ventasMes = mysqli_fetch_assoc(mysqli_query($conexion, $consulta));

    if($ventasMes['suma'] == ""){
        $ventasMes['suma'] = 0;
    }

    include("menu.php");
?>

    <h2 class="mb-4">Datos de demostracion</h2>

    <div class="card shadow-sm border-danger">
        <div class="card-header bg-white fw-bold text-danger">Cargar datos de demostracion</div>
        <div class="card-body">
            <p>
                Este boton <strong>borra</strong> todos los clientes, productos, proveedores, citas y ventas,
                y carga datos de ejemplo con fechas cercanas a hoy. Los usuarios no se borran.
                Antes de usarlo, haga un respaldo desde la opcion Respaldo.
            </p>
            <form action="seed_final.php" method="POST"
                  onsubmit="return confirm('Se borraran todos los datos actuales. Desea continuar?')">
                <input type="hidden" name="cargar" value="1">
                <button type="submit" class="btn btn-danger">Borrar y cargar datos de demostracion</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">Verificacion de integridad</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Revision</th>
                                    <th>Problemas</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($revisiones as $descripcion => $consulta){ ?>
                                <?php
                                    $resultado = mysqli_query($conexion, $consulta);
                                    $problemas = mysqli_fetch_assoc($resultado)['total'];
                                ?>
                                <tr>
                                    <td><?php echo $descripcion; ?></td>
                                    <td><?php echo $problemas; ?></td>
                                    <td>
                                        <?php if($problemas == 0){ ?>
                                            <span class="badge bg-success">Correcto</span>
                                        <?php }else{ ?>
                                            <span class="badge bg-danger">Revisar</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">Registros por tabla</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <?php foreach($tablas as $tabla){ ?>
                            <?php
                                $resultado = mysqli_query($conexion, "select count(*) as total from $tabla");
                                $cantidad = mysqli_fetch_assoc($resultado)['total'];
                            ?>
                            <tr>
                                <td><?php echo $tabla; ?></td>
                                <td class="text-end"><?php echo $cantidad; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                    <p class="mb-0">
                        Ventas de este mes: <strong><?php echo $ventasMes['cantidad']; ?></strong>
                        por <strong>Bs <?php echo number_format($ventasMes['suma'], 2); ?></strong>.
                        Este numero debe coincidir con el panel principal y con Reportes.
                    </p>
                </div>
            </div>
        </div>
    </div>

<?php include("pie.php"); ?>
