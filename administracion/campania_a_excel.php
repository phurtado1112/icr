<?php
include_once './config.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$conn = mysqli_connect('localhost', 'incaeu', 'incaeu1', 'incaecrm', '3306');
//Se cambió para eliminar la campaña uno y
//$consulta_estado_campanias = "select campania,programa,nombre,fechainicio,fechafin,TOTAL,ATENDIDO,PENDIENTE,PROCENT from estado_campania_view where terminada='n' order by idasignar";
$consulta_estado_campanias = "select campania,programa,nombre,fechainicio,fechafin,TOTAL,ATENDIDO,PENDIENTE,CALIFICADO,NOINTERESADO,OTROPROGRAMA,FALLIDA,PROCENT from estado_campania_view where terminada='n' order by idasignar";

$lista_estado_campanias = mysqli_query($conn, $consulta_estado_campanias) or die(mysqli_error());
$registros = mysqli_num_rows($lista_estado_campanias);

//$lista_estado_campanias = bd_ejecutar_sql($consulta_estado_campanias);
//while ($fila_estado_campanias = bd_obtener_fila($lista_estado_campanias)) {
//    $estado_campanias[] = $fila_estado_campanias;
//}
if ($registros > 0) {
// require the PHPExcel file 
    require './Classes/PHPExcel.php';
    
    // Create a new PHPExcel object 
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getActiveSheet()->setTitle('Estado de Campañas');
// simple query 

    $headings = array('CAMPAÑA', 'PROGRAMA', 'ASESOR', 'INICIO', 'FIN', 'TOTAL', 'ATENDIDO', 'PENDIENTE', 'CALIFICADOS', 'NOINTERESADOS', 'OTROPROGRAMA', 'FALLIDAS', 'PROCENT');

    $rowNumberT = 1;
    $col = 'A';
    foreach ($headings as $heading) {
        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumberT, $heading);
        $col++;
    }

    // Loop through the result set 
    $rowNumber = 2;
    while ($fila_estado_campanias = mysqli_fetch_row($lista_estado_campanias)) {
        $col = 'A';
        foreach ($fila_estado_campanias as $cell) {
            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $cell);
            $col++;
        }
        $rowNumber++;
    }

    // Freeze pane so that the heading line won't scroll 
    $objPHPExcel->getActiveSheet()->freezePane('A2');

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="EstadoCampanias.xlsx"');
    header('Cache-Control: max-age=0');

    // Save as an Excel BIFF (xls) file 
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    
    $objWriter->save('php://output');
    exit();
    mysqli_close($conn);
}