<?php
include_once './funciones.general.php';
//Iniciar Sesión
//session_start();
if (!$_SESSION){
	echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$time = filter_input(INPUT_POST, 'ajxtime');
$idestado = filter_input(INPUT_POST, 'ajxestado');

error_reporting(0);
	//include "conexion.php";
	$consulta_cambio_estado="INSERT INTO cambiarestado (idusuario,idestado,time,fecha)
			VALUES(
			'".$_SESSION['idusuario']."',
                        '".$idestado."',
			'".$time."',
			'".date("Y-m-d")."'
			)";
        bd_ejecutar_sql($consulta_cambio_estado);
        
//			$insert="INSERT INTO changestado (id_ser,time,estado,fecha)
//			VALUES(
//			'".$_SESSION['iduser']."',
//			'".$_POST['ajxtime']."',
//			'".$_POST['ajxestado']."',						
//			'".date("m/d/Y")."'
//			)";			
//			mysql_query($insert);	


