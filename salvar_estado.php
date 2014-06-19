<?php
include_once './funciones.general.php';

if (!$_SESSION){
	echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$time = filter_input(INPUT_POST, 'ajxtime');
$idestado = filter_input(INPUT_POST, 'ajxestado');

error_reporting(0);

	$consulta_cambio_estado="INSERT INTO cambiarestado (idusuario,idestado,time,fecha)
			VALUES(
			'".$_SESSION['idusuario']."',
                        '".$idestado."',
			'".$time."',
			'".date("Y-m-d")."'
			)";
        bd_ejecutar_sql($consulta_cambio_estado);
