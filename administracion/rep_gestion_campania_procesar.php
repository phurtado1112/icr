<?php
include_once './funciones.general.php';
require './fpdf/fpdf.php';

switch (filter_input(INPUT_POST, 'Submit')) {
    case "Cancelar":

        header("Location: rep_gestion_campania_form.php");
        exit(0);

        break;

    case "Presentar":
        $agente = (filter_input(INPUT_POST, 'idusuario'));        
        $asignar = (filter_input(INPUT_POST, 'idasignar'));
//        $consul_camp="select ";
//        $campania = (filter_input(INPUT_POST, 'idasignar'));

        class PDF extends FPDF {

// Cabecera de página
            function Header() {
                // Logo
                $this->Image('images/incae_logo.png', 10, 8, 33);
                // Arial bold 15
                $this->SetFont('Arial', 'B', 15);
                // Movernos a la derecha
                //$this->Cell(55);
                // Título
                $this->Cell(0, 10, utf8_decode('Reporte de Gestión x Campaña'), 0, 1, 'C');
                // Salto de línea
                $this->Ln(5);
                // Nombre de agente
                //$this->Cell(0, 10, utf8_decode($fila00['nombres']), 0, 1, 'C');
            }

// Pie de página
            function Footer() {
                // Posición: a 1,5 cm del final
                $this->SetY(-15);
                // Arial italic 8
                $this->SetFont('Arial', 'I', 8);
                // Número de página
                $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
            }

        }

        $pdf = new PDF('P', 'mm', 'Letter');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetMargins(20, 20);
        $pdf->Ln(1);
        $pdf->SetFillColor(128, 128, 255);

        $pdf->SetFont('Arial','',8);
        $pdf->Cell(35, 6, 'Fecha y hora del reporte: ', 0, 1, 'L');
        $pdf->Cell(17, 6, date('d-m-Y')." / ", 0, 0, 'L');
        $pdf->Cell(15, 6, date('H-i-s A'), 0, 1, 'L');
        
        //Consulta a DB
        $consulta0 = "SELECT nombre FROM usuarios where idusuario=" . $agente;
        $res0 = bd_ejecutar_sql($consulta0);
        $pdf->SetFont('Arial', 'b', 14);
        while ($fila0 = bd_obtener_fila($res0)) {
            $pdf->Cell(0, 8, utf8_decode($fila0['nombre']), 0, 1, 'C');
        }
        $pdf->Ln(1);

        $consulta00 = "SELECT campania FROM campanias_reporte_view where idasignar=" . $asignar;
        $res00 = bd_ejecutar_sql($consulta00);
        $pdf->SetFont('Arial', 'u', 12);
        while ($fila00 = bd_obtener_fila($res00)) {
            $pdf->Cell(0, 8, utf8_decode($fila00['campania']), 0, 1, 'C');
        }

        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'b', 12);
        $pdf->Cell(0, 8, utf8_decode('1.- Detalle de Campaña:'), 0, 1, 'L');

        $pdf->Ln(5);

        $consulta = "select count(idcliente) from clientes where idasignar=" . $asignar;
        $res = bd_ejecutar_sql($consulta);
        $pdf->SetFont('Arial', '', 12);
        while ($fila = bd_obtener_fila($res)) {
            $pdf->Cell(60, 6, utf8_decode('No de contactos por campaña: '), 1, 0, 'L', true);
            $pdf->Cell(40, 6, $fila['count(idcliente)'], 1, 0, 'C');
        }
        $pdf->Ln(10);

        $pdf->SetFillColor(200, 200, 255);

        $consulta1 = "SELECT count(idcliente) FROM transaccion where idasignar=" . $asignar ." and idtipificacion <> 5";
        $res1 = bd_ejecutar_sql($consulta1);
        $pdf->SetFont('Arial', '', 12);
        while ($fila1 = bd_obtener_fila($res1)) {
            $pdf->Cell(65, 6, utf8_decode('Attendee: '), 1, 0, 'L', true);
            $pdf->Cell(45, 6, $fila1['count(idcliente)'], 1, 1, 'C');
        }

        $consulta2 = "SELECT count(tra.idtipificacion) as cantidad, tip.tipificacion as tipo
                    FROM transaccion as tra 
                    left join tipificacion tip on (tra.idtipificacion=tip.idtipificacion)
                    where idasignar=" . $asignar . " and tra.idtipificacion <> 5
                    group by tra.idtipificacion order by tip.tipificacion;";
        $res2 = bd_ejecutar_sql($consulta2);
        $pdf->SetFont('Arial', 'b', 10);
        while ($fila2 = bd_obtener_fila($res2)) {
            $pdf->Cell(65, 8, utf8_decode($fila2['tipo']), 1, 0, 'L');
            $pdf->Cell(45, 8, $fila2['cantidad'], 1, 0, 'C');
            $pdf->Ln();
        }

        $pdf->Ln(7);

        $pdf->SetFont('Arial', 'b', 12);
        $pdf->Cell(0, 8, utf8_decode('2.- Totales de Campaña:'), 0, 1, 'L');

        $pdf->Ln(5);

        //Encabezado de Totales de campaña
        $pdf->SetFont('Arial', 'b', 10);
        $pdf->SetFillColor(100, 100, 255);

        $pdf->Cell(45, 6, 'TOTAL CONTACTOS', 1, 0, 'C', true);
        $pdf->Cell(45, 6, 'TOTAL CONTACTADOS', 1, 0, 'C', true);
        $pdf->Cell(45, 6, 'TOTAL PENDIENTES', 1, 0, 'C', true);
        $pdf->Cell(45, 6, '% DE CONTACTO', 1, 0, 'C', true);

        $pdf->Ln();
        //Valore de la tabla Totales de campaña

        $consulta20 = "select count(idcliente) from clientes where idasignar=" . $asignar;
        $res20 = bd_ejecutar_sql($consulta20);
        $pdf->SetFont('Arial', '', 12);
        while ($fila20 = bd_obtener_fila($res20)) {
            $contacs = $fila20['count(idcliente)'];
        }
        $pdf->Cell(45, 8, $contacs, 1, 0, 'C');

        $consulta21 = "SELECT count(distinct idcliente) FROM transaccion where idasignar=" . $asignar ." and idtipificacion <> 5";
        $res21 = bd_ejecutar_sql($consulta21);
        while ($fila21 = bd_obtener_fila($res21)) {
            $contacted = $fila21['count(distinct idcliente)'];
        }
        $pdf->Cell(45, 8, $contacted, 1, 0, 'C');

        $diferencia = $contacs - $contacted;
        $pdf->Cell(45, 8, $diferencia, 1, 0, 'C');

        $porcentaje = round($contacted / $contacs * 100, 0);
        $pdf->Cell(45, 8, $porcentaje, 1, 1, 'C');

        $pdf->Ln(7);

        $pdf->SetFont('Arial', 'b', 10);
        $pdf->Cell(0, 8, utf8_decode('3.- Razones de no interés:'), 0, 1, 'L');

        $pdf->Ln(5);

        $pdf->Cell(65, 6, 'RAZONES', 1, 0, 'L', true);
        $pdf->Cell(45, 6, 'CANTIDAD', 1, 0, 'C', true);

        $pdf->Ln();

        $consulta30 = "select count(tra.idsubtipificacion) as cantidad, sub.subtipificacion as subtipo
                    from transaccion tra
                    inner join subtipificacion sub on(tra.idsubtipificacion=sub.idsubtipificacion)
                    where idasignar=" . $asignar . " and tra.idtipificacion=9
                    group by tra.idsubtipificacion";
        $res30 = bd_ejecutar_sql($consulta30);
        $pdf->SetFont('Arial', 'b', 10);
        while ($fila30 = bd_obtener_fila($res30)) {
            $pdf->Cell(65, 8, utf8_decode($fila30['subtipo']), 1, 0, 'L');
            $pdf->Cell(45, 8, $fila30['cantidad'], 1, 0, 'C');
            $pdf->Ln();
        }

        $pdf->Output();
}