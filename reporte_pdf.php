<?php
    include("auth.php");
    include("conexion.php");
    require("fpdf/fpdf.php");

    if(!isset($_GET['desde']) || !isset($_GET['hasta'])){
        header("location: reportes.php");
        exit;
    }

    $desde = $_GET['desde'];
    $hasta = $_GET['hasta'];

    if(date("Y-m-d", strtotime($desde)) != $desde || date("Y-m-d", strtotime($hasta)) != $hasta || $desde > $hasta){
        $_SESSION['mensaje'] = "Revise las fechas: el rango no es valido";
        $_SESSION['tipo'] = "danger";
        header("location: reportes.php");
        exit;
    }

    $desde = mysqli_real_escape_string($conexion, $desde);
    $hasta = mysqli_real_escape_string($conexion, $hasta);

    $consulta = "select ventas.*, clientes.nombre as cliente, clientes.documento
                 from ventas
                 inner join clientes on ventas.cliente_id = clientes.id
                 where ventas.fecha between '$desde' and '$hasta'
                 order by ventas.fecha, ventas.id";

    $ventas = mysqli_query($conexion, $consulta);

    $consulta = "select metodo_pago, count(*) as cantidad, sum(total) as suma
                 from ventas
                 where fecha between '$desde' and '$hasta'
                 group by metodo_pago
                 order by metodo_pago";

    $porMetodo = mysqli_query($conexion, $consulta);

    $usuario = iconv("UTF-8", "windows-1252//TRANSLIT", $_SESSION['nombre']);

    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->SetFont("Arial", "B", 16);
    $pdf->Cell(0, 10, "KACHOW AUTOPARTES S.A.", 0, 1, "C");

    $pdf->SetFont("Arial", "", 13);
    $pdf->Cell(0, 7, "Reporte de ventas", 0, 1, "C");

    $pdf->SetFont("Arial", "", 10);
    $pdf->Cell(0, 6, "Periodo: del " . date("d/m/Y", strtotime($desde)) . " al " . date("d/m/Y", strtotime($hasta)), 0, 1, "C");
    $pdf->Cell(0, 6, "Generado el " . date("d/m/Y H:i") . " por " . $usuario, 0, 1, "C");

    $pdf->Ln(6);

    $pdf->SetFont("Arial", "B", 10);
    $pdf->SetFillColor(33, 37, 41);
    $pdf->SetTextColor(255, 255, 255);

    $pdf->Cell(15, 8, "Nro", 1, 0, "C", true);
    $pdf->Cell(25, 8, "Fecha", 1, 0, "C", true);
    $pdf->Cell(70, 8, "Cliente", 1, 0, "C", true);
    $pdf->Cell(25, 8, "CI / NIT", 1, 0, "C", true);
    $pdf->Cell(25, 8, "Pago", 1, 0, "C", true);
    $pdf->Cell(30, 8, "Total (Bs)", 1, 1, "C", true);

    $pdf->SetFont("Arial", "", 10);
    $pdf->SetTextColor(0, 0, 0);

    $cantidad = 0;
    $suma = 0;

    while($fila = mysqli_fetch_assoc($ventas)){

        if($pdf->GetY() > 265){
            $pdf->AddPage();

            $pdf->SetFont("Arial", "B", 10);
            $pdf->SetTextColor(255, 255, 255);

            $pdf->Cell(15, 8, "Nro", 1, 0, "C", true);
            $pdf->Cell(25, 8, "Fecha", 1, 0, "C", true);
            $pdf->Cell(70, 8, "Cliente", 1, 0, "C", true);
            $pdf->Cell(25, 8, "CI / NIT", 1, 0, "C", true);
            $pdf->Cell(25, 8, "Pago", 1, 0, "C", true);
            $pdf->Cell(30, 8, "Total (Bs)", 1, 1, "C", true);

            $pdf->SetFont("Arial", "", 10);
            $pdf->SetTextColor(0, 0, 0);
        }

        $cliente = iconv("UTF-8", "windows-1252//TRANSLIT", $fila['cliente']);
        $cliente = substr($cliente, 0, 36);

        $pdf->Cell(15, 7, $fila['id'], 1, 0, "C");
        $pdf->Cell(25, 7, date("d/m/Y", strtotime($fila['fecha'])), 1, 0, "C");
        $pdf->Cell(70, 7, $cliente, 1, 0, "L");
        $pdf->Cell(25, 7, $fila['documento'], 1, 0, "C");
        $pdf->Cell(25, 7, $fila['metodo_pago'], 1, 0, "C");
        $pdf->Cell(30, 7, number_format($fila['total'], 2), 1, 1, "R");

        $cantidad = $cantidad + 1;
        $suma = $suma + $fila['total'];
    }

    if($cantidad == 0){
        $pdf->Cell(190, 7, "No hay ventas registradas en este periodo", 1, 1, "C");
    }

    $pdf->SetFont("Arial", "B", 10);
    $pdf->Cell(160, 8, "TOTAL GENERAL (" . $cantidad . " ventas)", 1, 0, "R");
    $pdf->Cell(30, 8, number_format($suma, 2), 1, 1, "R");

    $pdf->Ln(8);

    if($pdf->GetY() > 210){
        $pdf->AddPage();
    }

    $pdf->SetFont("Arial", "B", 12);
    $pdf->Cell(0, 8, "Totales por metodo de pago", 0, 1);

    $pdf->SetFont("Arial", "B", 10);
    $pdf->SetTextColor(255, 255, 255);

    $pdf->Cell(60, 8, "Metodo de pago", 1, 0, "C", true);
    $pdf->Cell(30, 8, "Ventas", 1, 0, "C", true);
    $pdf->Cell(40, 8, "Total (Bs)", 1, 1, "C", true);

    $pdf->SetFont("Arial", "", 10);
    $pdf->SetTextColor(0, 0, 0);

    while($fila = mysqli_fetch_assoc($porMetodo)){
        $pdf->Cell(60, 7, $fila['metodo_pago'], 1, 0, "L");
        $pdf->Cell(30, 7, $fila['cantidad'], 1, 0, "C");
        $pdf->Cell(40, 7, number_format($fila['suma'], 2), 1, 1, "R");
    }

    $pdf->SetFont("Arial", "B", 10);
    $pdf->Cell(60, 8, "TOTAL", 1, 0, "L");
    $pdf->Cell(30, 8, $cantidad, 1, 0, "C");
    $pdf->Cell(40, 8, number_format($suma, 2), 1, 1, "R");

    $pdf->Output("D", "reporte_ventas_" . $desde . "_al_" . $hasta . ".pdf");
?>
