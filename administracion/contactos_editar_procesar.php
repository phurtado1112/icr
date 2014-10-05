<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$campania = filter_input(INPUT_POST, 'idcampania');
$nombre = filter_input(INPUT_POST, 'nombre');
$telfijo = filter_input(INPUT_POST, 'telfijo');
$email = filter_input(INPUT_POST, 'email');
$telmovil = filter_input(INPUT_POST, 'telmovil');
$teltrabajo = filter_input(INPUT_POST, 'teltrabajo');
$cargo = filter_input(INPUT_POST, 'cargo');
$empresa = filter_input(INPUT_POST, 'empresa');
$prioridad = filter_input(INPUT_POST, 'prioridad');
$idpais = filter_input(INPUT_POST, 'idpais');
$id = filter_input(INPUT_POST, 'idcliente');

error_reporting(0);

if (isset($campania)) {

    $actualiza_cliente = "UPDATE  clientes set nombre='" . $nombre . "', email='" . $email . "', telfijo='" . $telfijo . "', telmovil='" . $telmovil . "', teltrabajo='" . $teltrabajo . "', cargo='" . $cargo . "', empresa='" . $empresa . "', prioridad='" . $prioridad . "', idpais='" . $idpais . "' where idcliente='" . $id . "'";
    bd_ejecutar_sql($actualiza_cliente);
    
    header("Location: contactos_lista.php");
}


