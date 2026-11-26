<?php
    include("auth.php");
    include("conexion.php");

    if(!isset($_GET['tipo']) || !isset($_GET['desde']) || !isset($_GET['hasta'])){
        header("location: reportes.php");
        exit;
    }

    $tipo = $_GET['tipo'];
    $desde = mysqli_real_escape_string($conexion, $_GET['desde']);
    $hasta = mysqli_real_escape_string($conexion, $_GET['hasta']);

    if($tipo != "ventas" && $tipo != "detalle" && $tipo != "productos"){
        header("location: reportes.php");
        exit;
    }

    header("Content-Type: text/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename=kachow_" . $tipo . "_" . $desde . "_a_" . $hasta . ".csv");

    echo "\xEF\xBB\xBF";

    if($tipo == "ventas"){

        $consulta = "select ventas.*, clientes.nombre as cliente, clientes.documento
                     from ventas
                     inner join clientes on ventas.cliente_id = clientes.id
                     where ventas.fecha between '$desde' and '$hasta'
                     order by ventas.fecha";

        $resultado = mysqli_query($conexion, $consulta);

        echo "Numero;Fecha;Cliente;Documento;Metodo de pago;Total (Bs)\n";

        $suma = 0;

        while($fila = mysqli_fetch_assoc($resultado)){

            echo $fila['id'] . ";";
            echo $fila['fecha'] . ";";
            echo $fila['cliente'] . ";";
            echo $fila['documento'] . ";";
            echo $fila['metodo_pago'] . ";";
            echo number_format($fila['total'], 2, ",", "") . "\n";

            $suma = $suma + $fila['total'];
        }

        echo ";;;;TOTAL;" . number_format($suma, 2, ",", "") . "\n";
    }

    if($tipo == "detalle"){

        $consulta = "select ventas.id as venta, ventas.fecha, clientes.nombre as cliente,
                            productos.codigo, productos.nombre as producto,
                            venta_detalle.cantidad, venta_detalle.precio, venta_detalle.subtotal
                     from venta_detalle
                     inner join ventas on venta_detalle.venta_id = ventas.id
                     inner join clientes on ventas.cliente_id = clientes.id
                     inner join productos on venta_detalle.producto_id = productos.id
                     where ventas.fecha between '$desde' and '$hasta'
                     order by ventas.fecha, ventas.id";

        $resultado = mysqli_query($conexion, $consulta);

        echo "Venta;Fecha;Cliente;Codigo;Producto;Cantidad;Precio (Bs);Subtotal (Bs)\n";

        $suma = 0;

        while($fila = mysqli_fetch_assoc($resultado)){

            echo $fila['venta'] . ";";
            echo $fila['fecha'] . ";";
            echo $fila['cliente'] . ";";
            echo $fila['codigo'] . ";";
            echo $fila['producto'] . ";";
            echo $fila['cantidad'] . ";";
            echo number_format($fila['precio'], 2, ",", "") . ";";
            echo number_format($fila['subtotal'], 2, ",", "") . "\n";

            $suma = $suma + $fila['subtotal'];
        }

        echo ";;;;;;TOTAL;" . number_format($suma, 2, ",", "") . "\n";
    }

    if($tipo == "productos"){

        $consulta = "select productos.codigo, productos.nombre, productos.categoria,
                            sum(venta_detalle.cantidad) as unidades,
                            sum(venta_detalle.subtotal) as importe
                     from venta_detalle
                     inner join ventas on venta_detalle.venta_id = ventas.id
                     inner join productos on venta_detalle.producto_id = productos.id
                     where ventas.fecha between '$desde' and '$hasta'
                     group by productos.id, productos.codigo, productos.nombre, productos.categoria
                     order by unidades desc";

        $resultado = mysqli_query($conexion, $consulta);

        echo "Codigo;Producto;Categoria;Unidades;Importe (Bs)\n";

        $suma = 0;

        while($fila = mysqli_fetch_assoc($resultado)){

            echo $fila['codigo'] . ";";
            echo $fila['nombre'] . ";";
            echo $fila['categoria'] . ";";
            echo $fila['unidades'] . ";";
            echo number_format($fila['importe'], 2, ",", "") . "\n";

            $suma = $suma + $fila['importe'];
        }

        echo ";;;TOTAL;" . number_format($suma, 2, ",", "") . "\n";
    }
?>
