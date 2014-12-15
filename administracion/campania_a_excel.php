<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_estado_campanias = "select campania,nombre,TOTAL,ATENDIDO,PENDIENTE,PROCENT from estado_campania_view where terminada='n' order by idasignar";

$lista_estado_campanias = bd_ejecutar_sql($consulta_estado_campanias);
//while ($fila_estado_campanias = bd_obtener_fila($lista_estado_campanias)) {
//    $estado_campanias[] = $fila_estado_campanias;
//}

// require the PHPExcel file 
require './Classes/PHPExcel.php'; 

// simple query 

$headings = array('CAMPAÑA','ASESOR','TOTAL','ATENDIDO','PENDIENTE','PROCENT'); 

if ($lista_estado_campanias) { 
    // Create a new PHPExcel object 
    $objPHPExcel = new PHPExcel(); 
    $objPHPExcel->getActiveSheet()->setTitle('Lista de Campañas'); 

    $rowNumberT = 1; 
    $col = 'A'; 
    foreach($headings as $heading) { 
       $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumberT,$heading); 
       $col++; 
    } 

    // Loop through the result set 
    $rowNumber = 2; 
    while ($fila_estado_campanias = mysqli_fetch_row($lista_estado_campanias)) {
        $col = 'A'; 
       foreach($fila_estado_campanias as $cell) {
          $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$cell); 
          $col++; 
       } 
       $rowNumber++; 
    } 

    // Freeze pane so that the heading line won't scroll 
    $objPHPExcel->getActiveSheet()->freezePane('A2'); 

    // Save as an Excel BIFF (xls) file 
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 

   header('Content-Type: application/vnd.ms-excel'); 
   header('Content-Disposition: attachment;filename="EstadoCampanias.xls"'); 
   header('Cache-Control: max-age=0'); 

   $objWriter->save('php://output'); 
   exit(); 
} 
echo 'Ha producido un problema ... no hay datos recuperados de la base de datos'; 
