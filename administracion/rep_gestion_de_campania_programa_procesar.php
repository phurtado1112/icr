<?php
include_once './funciones.general.php';
require './fpdf/fpdf.php';

switch (filter_input(INPUT_POST, 'Submit')) {
    case "Cancelar":

        header("Location: rep_gestion_de_campanias_form.php");
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
                $this->Cell(0, 10, utf8_decode('Reporte de Gestión de Campañas por Programa'), 0, 1, 'C');
                // Salto de línea
                $this->Ln(2);
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
        $consulta0 = "SELECT programa FROM programas where idprograma=" . $idprograma;
        $res0 = bd_ejecutar_sql($consulta0);
        $pdf->SetFont('Arial', 'b', 14);
        while ($fila0 = bd_obtener_fila($res0)) {
            $pdf->Cell(0, 8, utf8_decode($fila0['programa']), 0, 1, 'C');
        }
        $pdf->Ln(1);

        $consulta00 = "SELECT distinct campania, idcampania FROM campanias where idprograma=" . $idprograma;
        $res00 = bd_ejecutar_sql($consulta00);
        $pdf->SetFont('Arial', 'u', 12);
        $pdf->Cell(0, 8, utf8_decode('Campañas del programa'), 0, 1, 'L');
        $pdf->Ln(1);
        $pdf->SetFont('Arial', '', 12);
        while ($fila00 = bd_obtener_fila($res00)) {
            $pdf->Cell(0, 8, '- '. utf8_decode($fila00['campania']), 0, 1, 'L');
        }

        $pdf->Ln(5);

        $consulta = "SELECT count(idcliente) FROM incaecrm.clientes_x_programa_view where idprograma=" . $idprograma;
        $res = bd_ejecutar_sql($consulta);
        $pdf->SetFont('Arial', '', 12);
        while ($fila = bd_obtener_fila($res)) {
            $pdf->Cell(65, 6, utf8_decode('Total de Leads del Programa: '), 1, 0, 'L', true);
            $pdf->Cell(40, 6, $fila['count(idcliente)'], 1, 0, 'C');
        }
        $pdf->Ln(10);
        
        $pdf->SetFont('Arial', 'bu', 12);
        $pdf->Cell(0, 8, utf8_decode('Clasificación de Leads Atendidos'), 0, 1, 'L');
        $pdf->Ln(2);
        
        $pdf->SetFont('Arial', 'b', 12);
        $pdf->Cell(0, 8, utf8_decode('1.- Totales del Programa:'), 0, 1, 'L');

        $pdf->Ln(5);

        $pdf->SetFillColor(200, 200, 255);
        
        $pdf->Cell(65, 6, utf8_decode('Tipificación'), 1, 0, 'L', true);
        $pdf->Cell(40, 6, utf8_decode('No. Contactos'), 1, 1, 'C', true);

        $consulta2 = "SELECT count(tipificaciontipo) as cantidad, tipificaciontipo as tipo
                    FROM transacciones_tipos_view
                    where idprograma=" . $idprograma . " and idtipificacion <> 5 and idtipificacion <> 14
                    and ultimo=1 and (fecha >='".$fechainicio."' and fecha <= '".$fechafin.
                    "') group by idtipificaciontipo order by idtipificaciontipo;";
        $res2 = bd_ejecutar_sql($consulta2);
        $pdf->SetFont('Arial', 'b', 10);
        while ($fila2 = bd_obtener_fila($res2)) {
            $pdf->Cell(65, 8, utf8_decode($fila2['tipo']), 1, 0, 'L');
            $pdf->Cell(40, 8, $fila2['cantidad'], 1, 0, 'C');
            $pdf->Ln();
        }
        
        $consulta1 = "SELECT count(idcliente) FROM transacciones_tipos_view where idprograma=" . $idprograma ." "
                . "and idtipificaciontipo <> 6 and (fecha >='".$fechainicio."' "
                . "and fecha <= '".$fechafin."') and ultimo=1";
        $res1 = bd_ejecutar_sql($consulta1);
        $pdf->SetFont('Arial', '', 12);
        while ($fila1 = bd_obtener_fila($res1)) {
            $pdf->Cell(65, 6, utf8_decode('Total de Leads Atendidos'), 1, 0, 'L', true);
            $pdf->Cell(40, 6, $fila1['count(idcliente)'], 1, 1, 'C', true);
        }
        
        /*------NO INTERES-------*/
        
        $pdf->Ln(7);
        
        $pdf->SetFillColor(100, 200, 255);
        
        $pdf->SetFont('Arial', 'b', 12);
        $pdf->Cell(0, 8, utf8_decode('2.- Razones de no interés:'), 0, 1, 'L');

        $pdf->Ln(5);

        $pdf->Cell(65, 6, 'RAZONES', 1, 0, 'L', true);
        $pdf->Cell(45, 6, 'CANTIDAD', 1, 0, 'C', true);

        $pdf->Ln();

        $consulta30 = "select count(idsubtipificacion) as cantidad, subtipificacion as subtipo
                    from transacciones_tipos_view
                    where idprograma=" . $idprograma . " and idtipificaciontipo=3  "
                . "and (fecha >='".$fechainicio."' "
                . "and fecha <= '".$fechafin."')
                    group by idsubtipificacion";
        $res30 = bd_ejecutar_sql($consulta30);
        $pdf->SetFont('Arial', 'b', 10);
        while ($fila30 = bd_obtener_fila($res30)) {
            $pdf->Cell(65, 8, utf8_decode($fila30['subtipo']), 1, 0, 'L');
            $pdf->Cell(45, 8, $fila30['cantidad'], 1, 0, 'C');
            $pdf->Ln();
        }
        
        /*------CALIFICADO-------*/
        
        $pdf->Ln(7);

        $pdf->SetFont('Arial', 'b', 12);
        $pdf->Cell(0, 8, utf8_decode('3.- Subtipos de Calificado:'), 0, 1, 'L');

        $pdf->Ln(5);

        $pdf->Cell(65, 6, 'RAZONES', 1, 0, 'L', true);
        $pdf->Cell(45, 6, 'CANTIDAD', 1, 0, 'C', true);

        $pdf->Ln();

        $consulta40 = "select count(idsubtipificacion) as cantidad, subtipificacion as subtipo
                    from transacciones_tipos_view 
                    where idprograma=" . $idprograma . " and idtipificaciontipo=1  "
                . "and (fecha >='".$fechainicio."' and fecha <= '".$fechafin."') and ultimo=1
                    group by idsubtipificacion";
        $res40 = bd_ejecutar_sql($consulta40);
        $pdf->SetFont('Arial', 'b', 10);
        while ($fila40 = bd_obtener_fila($res40)) {
            $pdf->Cell(65, 8, utf8_decode($fila40['subtipo']), 1, 0, 'L');
            $pdf->Cell(45, 8, $fila40['cantidad'], 1, 0, 'C');
            $pdf->Ln();
        }
        
        /*------LLAMADA FALLIDA-------*/
        
        $pdf->Ln(7);

        $pdf->SetFont('Arial', 'b', 12);
        $pdf->Cell(0, 8, utf8_decode('4.- Subtipos de Llamadas Fallidas:'), 0, 1, 'L');

        $pdf->Ln(5);

        $pdf->Cell(65, 6, 'RAZONES', 1, 0, 'L', true);
        $pdf->Cell(45, 6, 'CANTIDAD', 1, 0, 'C', true);

        $pdf->Ln();

        $consulta50 = "select count(idsubtipificacion) as cantidad, subtipificacion as subtipo
                    from transacciones_tipos_view
                    where idprograma=" . $idprograma . " and idtipificaciontipo=5  "
                . "and (fecha >='".$fechainicio."' and fecha <= '".$fechafin."') and ultimo=1
                    group by idsubtipificacion";
        $res50 = bd_ejecutar_sql($consulta50);
        $pdf->SetFont('Arial', 'b', 10);
        while ($fila50 = bd_obtener_fila($res50)) {
            $pdf->Cell(65, 8, utf8_decode($fila50['subtipo']), 1, 0, 'L');
            $pdf->Cell(45, 8, $fila50['cantidad'], 1, 0, 'C');
            $pdf->Ln();
        }
        
        /*------OTRAS-------*/
        
        $pdf->Ln(7);

        $pdf->SetFont('Arial', 'b', 12);
        $pdf->Cell(0, 8, utf8_decode('5.- Subtipos de Otras:'), 0, 1, 'L');

        $pdf->Ln(5);

        $pdf->Cell(65, 6, 'RAZONES', 1, 0, 'L', true);
        $pdf->Cell(45, 6, 'CANTIDAD', 1, 0, 'C', true);

        $pdf->Ln();

        $consulta60 = "select count(idsubtipificacion) as cantidad, subtipificacion as subtipo
                    from transacciones_tipos_view
                    where idprograma=" . $idprograma . " and idtipificaciontipo=7  "
                . "and (fecha >='".$fechainicio."' and fecha <= '".$fechafin."') and ultimo=1
                    group by idsubtipificacion";
        $res60 = bd_ejecutar_sql($consulta60);
        $pdf->SetFont('Arial', 'b', 10);
        while ($fila60 = bd_obtener_fila($res60)) {
            $pdf->Cell(65, 8, utf8_decode($fila60['subtipo']), 1, 0, 'L');
            $pdf->Cell(45, 8, $fila60['cantidad'], 1, 0, 'C');
            $pdf->Ln();
        }
        
        /*------OTROS PROGRAMAS-------*/
        
        $pdf->Ln(7);

        $pdf->SetFont('Arial', 'b', 12);
        $pdf->Cell(0, 8, utf8_decode('6.- Subtipos de Otros Programas:'), 0, 1, 'L');

        $pdf->Ln(5);

        $pdf->Cell(65, 6, 'RAZONES', 1, 0, 'L', true);
        $pdf->Cell(45, 6, 'CANTIDAD', 1, 0, 'C', true);

        $pdf->Ln();

        $consulta70 = "select count(idsubtipificacion) as cantidad, subtipificacion as subtipo
                    from transacciones_tipos_view
                    where idprograma=" . $idprograma . " and idtipificaciontipo=4  "
                . "and (fecha >='".$fechainicio."' and fecha <= '".$fechafin."') and ultimo=1
                    group by idsubtipificacion";
        $res70 = bd_ejecutar_sql($consulta70);
        $pdf->SetFont('Arial', 'b', 10);
        while ($fila70 = bd_obtener_fila($res70)) {
            $pdf->Cell(65, 8, utf8_decode($fila70['subtipo']), 1, 0, 'L');
            $pdf->Cell(45, 8, $fila70['cantidad'], 1, 0, 'C');
            $pdf->Ln();
        }

        $pdf->Output();
}