<?php
include_once './funciones.general.php';

$archivo = filter_input(INPUT_POST, 'excel');
$action = filter_input(INPUT_POST, 'action');
$idcampania = filter_input(INPUT_POST, 'idcampania');
$registros = filter_input(INPUT_POST, 'registros');

if ($action == "upload") {
//cargamos el archivo al servidor con el mismo nombre
//solo le agregue el sufijo bak_     
    $archivo = $_FILES['excel']['name'];
    $tipo = $_FILES['excel']['type'];
    $destino = "bak_" . $archivo;
    if (copy($_FILES['excel']['tmp_name'], $destino)) {
        echo "Archivo Cargado Con Éxito<br>";
    } else {
        echo "Error Al Cargar el Archivo";
    }

    if (file_exists("bak_" . $archivo)) {
        require_once('Classes/PHPExcel.php');
        require_once('Classes/PHPExcel/Reader/Excel2007.php');

// Cargando la hoja de cálculo
        $objReader = new PHPExcel_Reader_Excel2007();
        $objPHPExcel = $objReader->load("bak_" . $archivo);
        $objFecha = new PHPExcel_Shared_Date();

// Asignar hoja de excel activa
        $objPHPExcel->setActiveSheetIndex(0);

// Llenamos el arreglo con los datos  del archivo xlsx
        for ($i = 1; $i <= $registros; $i++) {
            $_DATOS_EXCEL[$i]['idcampania'] = $idcampania;
            $_DATOS_EXCEL[$i]['nombre'] = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
            $_DATOS_EXCEL[$i]['telfijo'] = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
            $_DATOS_EXCEL[$i]['email'] = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
            $_DATOS_EXCEL[$i]['telmovil'] = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
            $_DATOS_EXCEL[$i]['teltrabajo'] = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
            $_DATOS_EXCEL[$i]['cargo'] = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();
            $_DATOS_EXCEL[$i]['empresa'] = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
            $_DATOS_EXCEL[$i]['idestado'] = 0;
            $_DATOS_EXCEL[$i]['prioridad'] = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
            $_DATOS_EXCEL[$i]['teltrabajo'] = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
        }
    }
//si por algo no cargo el archivo bak_ 
    else {
        echo "Necesitas primero importar el archivo";
    }
    $errores = 0;
//recorremos el arreglo multidimensional para ir recuperando los datos obtenidos del excel 
//e ir insertandolos en la BD
    foreach ($_DATOS_EXCEL as $campo => $valor) {
        $sql = "INSERT INTO clientes (idcampania,nombre,telfijo,email,telmovil,"
                . "teltrabajo,cargo,empresa,idestado,prioridad) VALUES ('";
        foreach ($valor as $campo2 => $valor2) {
            $campo2 == "prioridad" ? $sql.= $valor2 . "');" : $sql.= $valor2 . "','";
        }
        $result = bd_ejecutar_sql($sql);
        if (!$result) {
            echo    "<script language='JavaScript'>
                    alert('Error al insertar el registro'. $campo);
                    </script>";
            $errores+=1;
        }
    }
//echo "<strong><center>ARCHIVO IMPORTADO CON EXITO, EN TOTAL $campo REGISTROS Y $errores ERRORES</center></strong>";
//una vez terminado el proceso borramos el archivo que esta en el servidor el bak_
    unlink($destino);
    
    echo "<script language='JavaScript'>
          alert('Carga de datos de campaña completa');
          </script>";
    
    header("Location: importar_datos.php");
}

