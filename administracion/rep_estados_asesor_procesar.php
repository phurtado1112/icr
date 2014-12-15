<?php

include_once './funciones.general.php';
require './fpdf/fpdf.php';

switch (filter_input(INPUT_POST, 'Submit')) {
    case "Cancelar":

        header("Location: rep_estado_asesor_form.php");
        exit(0);

        break;

    case "Presentar":
        $idusuario = (filter_input(INPUT_POST, 'idusuario'));
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
                $this->Cell(0, 10, utf8_decode('Reporte de Actividad de Asesor'), 0, 1, 'C');
                // Salto de línea
//                $this->Ln(2);
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

        $pdf->SetFont('Arial', 'U', 11);
        $pdf->Cell(0, 10, 'Desde ' . $fechainicio . ' hasta ' . $fechafin, 0, 1, 'C');

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(35, 6, 'Fecha y hora del reporte: ', 0, 1, 'L');
        $pdf->Cell(17, 6, date('d-m-Y') . " / ", 0, 0, 'L');
        $pdf->Cell(15, 6, date('H-i-s A'), 0, 1, 'L');

        $pdf->Ln(5);

        if ($idusuario != 0) {
            $consulta = "select distinct nombre from cambio_estado_view where idusuario='" . $idusuario . "'";
            $res = bd_ejecutar_sql($consulta);
            $fila = bd_obtener_fila($res);
            $pdf->SetFont('Arial', 'b', 11);
            $pdf->Cell(20, 8, 'Asesor: ', 1, 0, 'L');
            $pdf->Cell(60, 8, utf8_decode($fila['nombre']), 1, 1, 'L', true);

            $pdf->Ln(7);

            $pdf->SetFillColor(200, 200, 255);

            $pdf->Cell(30, 6, utf8_decode('Estado'), 1, 0, 'L', true);
            $pdf->Cell(40, 6, utf8_decode('Minutos'), 1, 0, 'C', true);
            $pdf->Cell(40, 6, utf8_decode('Fecha'), 1, 1, 'C', true);

            $consulta1 = "select estado,time_to_sec(sum(tiempo))/60 as minutos,fecha from cambio_estado_view "
                    . "where idusuario=" . $idusuario . " and (fecha >='" . $fechainicio . "' and fecha <= '" . $fechafin . "') "
                    . "group by tiempo order by fecha;";
            $res1 = bd_ejecutar_sql($consulta1);
            $pdf->SetFont('Arial', 'b', 10);
            while ($fila1 = bd_obtener_fila($res1)) {
                $pdf->Cell(30, 8, utf8_decode($fila1['estado']), 1, 0, 'L');
                $pdf->Cell(40, 8, number_format(round($fila1['minutos'], 2), 2), 1, 0, 'C');
                $pdf->Cell(40, 8, $fila1['fecha'], 1, 0, 'C');
                $pdf->Ln();
            }
        } else {
            $consulta2 = "select distinct nombre, idusuario from cambio_estado_view where fecha >='" . $fechainicio . "' and fecha <= '" . $fechafin . "'";
            $res2 = bd_ejecutar_sql($consulta2);
            while ($fila2 = bd_obtener_fila($res2)) {
                $pdf->SetFont('Arial', 'b', 11);
                $pdf->Cell(20, 8, 'Asesor: ', 1, 0, 'L');
                $pdf->Cell(60, 8, utf8_decode($fila2['nombre']), 1, 1, 'L', true);

                $pdf->Ln(7);

                $pdf->SetFillColor(200, 200, 255);

                $pdf->Cell(30, 6, utf8_decode('Estado'), 1, 0, 'L', true);
                $pdf->Cell(40, 6, utf8_decode('Minutos'), 1, 0, 'C', true);
                $pdf->Cell(40, 6, utf8_decode('Fecha'), 1, 1, 'C', true);
                
                $idusuario=$fila2['idusuario'];

                $consulta1 = "select estado,time_to_sec(sum(tiempo))/60 as minutos,fecha from cambio_estado_view "
                        . "where idusuario=" . $idusuario . " and (fecha >='" . $fechainicio . "' and fecha <= '" . $fechafin . "') "
                        . "group by tiempo order by fecha;";
                $res1 = bd_ejecutar_sql($consulta1);
                $pdf->SetFont('Arial', 'b', 10);
                while ($fila1 = bd_obtener_fila($res1)) {
                    $pdf->Cell(30, 8, utf8_decode($fila1['estado']), 1, 0, 'L');
                    $pdf->Cell(40, 8, number_format(round($fila1['minutos'], 2), 2), 1, 0, 'C');
                    $pdf->Cell(40, 8, $fila1['fecha'], 1, 0, 'C');
                    $pdf->Ln();
                }
                $pdf->SetFont('Arial', 'b', 11);
                $pdf->addPage('P','Letter');
            }
        }

        $pdf->Output();
}