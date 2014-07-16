<?php

include_once './funciones.general.php';
require './fpdf/fpdf.php';

switch (filter_input(INPUT_POST, 'Submit')) {
    case "Cancelar":

        header("Location: rep_usuarios_conectados_form.php");
        exit(0);

        break;

    case "Presentar":

//        $agente = (filter_input(INPUT_POST, 'idusuario'));
//        $campania = (filter_input(INPUT_POST, 'idcampania'));

        class PDF extends FPDF {

            var $widths;
            var $aligns;

            function SetWidths($w) {
                //Set the array of column widths
                $this->widths = $w;
            }

            function SetAligns($a) {
                //Set the array of column alignments
                $this->aligns = $a;
            }

            // Cabecera de página
            function Header() {
                // Logo
                $this->Image('images/incae_logo.png', 10, 8, 33);
                // Arial bold 15
                $this->SetFont('Arial', 'B', 15);
                // Título
                $this->Cell(0, 10, utf8_decode('Reporte de Usuarios Conectados'), 0, 1, 'C');
                // Salto de línea
                $this->Ln(5);
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

            function SetCol($col) {
                //Establecer la posición de una columna dada
                $this->col = $col;
                $x = 10 + $col * 75;
                $this->SetLeftMargin($x);
                $this->SetX($x);
            }

            function AcceptPageBreak() {
                //Método que acepta o no el salto automático de página
                if ($this->col < 2) {
                    //Ir a la siguiente columna
                    $this->SetCol($this->col + 1);
                    //Establecer la ordenada al principio
                    $this->SetY($this->y0);
                    //Seguir en esta página
                    return false;
                } else {
                    //Volver a la primera columna
                    $this->SetCol(0);
                    //Salto de página
                    return true;
                }
            }

            function Row($data) {
                //Calculate the height of the row
                $nb = 0;
                for ($i = 0; $i < count($data); $i++) {
                    $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
                    $h = 5 * $nb;
                }
                //Issue a page break first if needed
                $this->CheckPageBreak($h);
                //Draw the cells of the row
                for ($i = 0; $i < count($data); $i++) {
                    $w = $this->widths[$i];
                    $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                    //Save the current position
                    $x = $this->GetX();
                    $y = $this->GetY();
                    //Draw the border

                    $this->Rect($x, $y, $w, $h);

                    $this->MultiCell($w, 5, $data[$i], 0, $a, 'true');
                    //Put the position to the right of the cell
                    $this->SetXY($x + $w, $y);
                }
                //Go to the next line
                $this->Ln($h);
            }

            function CheckPageBreak($h) {
                //If the height h would cause an overflow, add a new page immediately
                if ($this->GetY() + $h > $this->PageBreakTrigger) {
                    $this->AddPage($this->CurOrientation);
                }
            }

            function NbLines($w, $txt) {
                //Computes the number of lines a MultiCell of width w will take
                $cw = &$this->CurrentFont['cw'];
                if ($w == 0) {
                    $w = $this->w - $this->rMargin - $this->x;
                }
                $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
                $s = str_replace("\r", '', $txt);
                $nb = strlen($s);
                if ($nb > 0 and $s[$nb - 1] == "\n") {
                    $nb--;
                }
                $sep = -1;
                $i = 0;
                $j = 0;
                $l = 0;
                $nl = 1;
                while ($i < $nb) {
                    $c = $s[$i];
                    if ($c == "\n") {
                        $i++;
                        $sep = -1;
                        $j = $i;
                        $l = 0;
                        $nl++;
                        continue;
                    }
                    if ($c == ' ') {
                        $sep = $i;
                    }
                    $l+=$cw[$c];
                    if ($l > $wmax) {
                        if ($sep == -1) {
                            if ($i == $j) {
                                $i++;
                            }
                        } else {
                            $i = $sep + 1;
                        }
                        $sep = -1;
                        $j = $i;
                        $l = 0;
                        $nl++;
                    } else {
                        $i++;
                    }
                }
                return $nl;
            }

        }

        $pdf = new PDF('P', 'mm', 'Letter');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetMargins(20, 20);
        $pdf->Ln(2);
        $pdf->SetFillColor(128, 128, 255);

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(35, 6, 'Fecha y hora del reporte: ', 0, 1, 'L');
        $pdf->Cell(17, 6, date('d-m-Y') . " / ", 0, 0, 'L');
        $pdf->Cell(15, 6, date('H-i-s A'), 0, 1, 'L');

        $pdf->Ln(10);

        $pdf->SetWidths(array(65, 60, 55, 50, 20));
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(0, 128, 255);
        $pdf->SetTextColor(255);

        for ($i = 0; $i < 1; $i++) {
            $pdf->Row(array('ID', 'NOMBRE', 'TIPO USUARIO'));
        }

        //Consulta a DB
        $consulta0 = "SELECT idusuario, nombre, tipo FROM usuarios_conectados_view";
        $res0 = bd_ejecutar_sql($consulta0);

        $numfilas = mysqli_num_rows($res0);
        for ($i = 0; $i < $numfilas; $i++) {
            $fila = bd_obtener_fila($res0);
            $pdf->SetFont('Arial', '', 10);

            if ($i % 2 == 1) {
                $pdf->SetFillColor(192, 192, 192);
                $pdf->SetTextColor(0);
                $pdf->Row(array($fila['idusuario'], $fila['nombre'], $fila['tipo']));
            } else {
                $pdf->SetFillColor(128, 128, 128);
                $pdf->SetTextColor(0);
                $pdf->Row(array($fila['idusuario'], $fila['nombre'], $fila['tipo']));
            }
        }

        $pdf->Output();
}