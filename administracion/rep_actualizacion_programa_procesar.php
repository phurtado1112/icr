<?php

include_once './funciones.general.php';
require './fpdf/fpdf.php';

switch (filter_input(INPUT_POST, 'Submit')) {
    case "Cancelar":

        header("Location: rep_actualizacion_programa_form.php");
        exit(0);

        break;

    case "Presentar":
        $idprograma = (filter_input(INPUT_POST, 'idprograma'));
        $fechainicio = (filter_input(INPUT_POST, 'fechainicio'));
        $fechafin = (filter_input(INPUT_POST, 'fechafin'));

        class PDF extends FPDF {

// Cabecera de página
            function Header() {
                // Logo
                $this->Image('images/incae_logo.png', 10, 8, 33);
                // Arial bold 15
                $this->SetFont('Arial', 'B', 15);
                // Movernos a la derecha
                $this->Ln(8);
                // Título
                $this->Cell(0, 10, utf8_decode('Reporte de Actualización por Programa'), 0, 1, 'C');
                // Salto de línea
                $this->Ln(2);
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

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(35, 6, 'Fecha y hora del reporte: ', 0, 1, 'L');
        $pdf->Cell(17, 6, date('d-m-Y') . " / ", 0, 0, 'L');
        $pdf->Cell(15, 6, date('H-i-s A'), 0, 1, 'L');

        //Consulta a DB
        $consulta0 = "SELECT programa FROM programas where idprograma=" . $idprograma;
        $res0 = bd_ejecutar_sql($consulta0);
        $pdf->SetFont('Arial', 'b', 14);
        while ($fila0 = bd_obtener_fila($res0)) {
            $pdf->Cell(0, 8, utf8_decode($fila0['programa']), 0, 1, 'C');
        }
        $pdf->Ln(1);

        $consulta00 = "SELECT distinct campania, idcampania FROM campanias where idprograma=" 
                . $idprograma;
        $res00 = bd_ejecutar_sql($consulta00);
        $pdf->SetFont('Arial', 'u', 12);
        $pdf->Cell(0, 8, utf8_decode('Campañas del programa'), 0, 1, 'L');
        $pdf->Ln(1);
        $pdf->SetFont('Arial', '', 12);

        while ($fila00 = bd_obtener_fila($res00)) {
            $pdf->Cell(0, 8, '- . ' . utf8_decode($fila00['campania']), 0, 1, 'L');
        }

        $pdf->Ln(5);

        $consulta = "SELECT count(idcliente) FROM incaecrm.transacciones_view where idprograma=" 
                . $idprograma . " and idtipificacion=14";
        $res = bd_ejecutar_sql($consulta);
        $pdf->SetFont('Arial', '', 12);
        while ($fila = bd_obtener_fila($res)) {
            $pdf->Cell(75, 6, utf8_decode('Total de Actualizados del Programa: '), 1, 0, 'L', true);
            $pdf->Cell(30, 6, $fila['count(idcliente)'], 1, 0, 'C');
        }
        $pdf->Ln(10);

        /* ------DETALLE DE ACTUALIZADO POR CAMPAÑA------- */
        
        $pdf->SetFont('Arial', 'b', 12);
        $pdf->Cell(0, 8, utf8_decode('1.- Actualizados del Programa por Campaña:'), 0, 1, 'L');

        $pdf->Ln(5);

        $pdf->SetFillColor(200, 200, 255);

        $pdf->Cell(65, 6, utf8_decode('Campaña'), 1, 0, 'L', true);
        $pdf->Cell(40, 6, utf8_decode('Actualizados'), 1, 1, 'C', true);

        $consulta000 = "SELECT distinct campania, idcampania FROM campanias where idprograma=" 
                . $idprograma;
        $res000 = bd_ejecutar_sql($consulta000);
        while ($fila000 = bd_obtener_fila($res000)) {
            $consulta2 = "SELECT count(idcliente) as cantidad FROM incaecrm.transacciones_view where idprograma=" . $idprograma . " and idtipificacion=14 and idcampania=" . $fila000['idcampania'];
            $res2 = bd_ejecutar_sql($consulta2);
            $pdf->SetFont('Arial', 'b', 10);

            while ($fila2 = bd_obtener_fila($res2)) {
                $pdf->Cell(65, 8, utf8_decode($fila000['campania']), 1, 0, 'L');
                $pdf->Cell(40, 8, $fila2['cantidad'], 1, 0, 'C');
                $pdf->Ln();
            }
        }

        /* ------DETALLE DE ACTUALIZADO------- */

        $pdf->Ln(7);

        $pdf->SetFillColor(100, 200, 255);

        $pdf->SetFont('Arial', 'b', 12);
        $pdf->Cell(0, 8, utf8_decode('2.- Detalle de Contactos Actualizados'), 0, 1, 'L');

        $pdf->Ln(5);

        $pdf->Cell(65, 6, 'NOMBRE', 1, 0, 'L', true);
        $pdf->Cell(65, 6, 'CORREO', 1, 0, 'C', true);
        $pdf->Cell(45, 6, utf8_decode('PAÍS'), 1, 0, 'C', true);

        $pdf->Ln();

        $consulta30 = "select nombre, email, pais
                    from transacciones_view tra
                    where idprograma=" . $idprograma . " and tra.idtipificacion=14  and (fecha >='" 
                . $fechainicio . "' and fecha <= '" . $fechafin . "')";
        $res30 = bd_ejecutar_sql($consulta30);
        $pdf->SetFont('Arial', 'b', 10);
        while ($fila30 = bd_obtener_fila($res30)) {
            $pdf->Cell(65, 8, utf8_decode($fila30['nombre']), 1, 0, 'L');
            $pdf->Cell(65, 8, $fila30['email'], 1, 0, 'C');
            $pdf->Cell(45, 8, utf8_decode($fila30['pais']), 1, 0, 'C');
            $pdf->Ln();
        }

        $pdf->Output();
}