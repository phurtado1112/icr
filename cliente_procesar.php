<?php

include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$idcliente = filter_input(INPUT_POST, 'ajxcliente');
$observacion = filter_input(INPUT_POST, 'ajxobservacion');
$fecha = filter_input(INPUT_POST, 'ajxsagendar');
$idtipificacion = filter_input(INPUT_POST, 'jaxfinales');
$idsubtipificacion = filter_input(INPUT_POST, 'ajxsubfinal');
$idusuario = filter_input(INPUT_POST, 'ajxuser');

error_reporting(0);

if (isset($idcliente)) {
    echo '<script language = javascript>
			alert("llego")"
			</script>';
    
    if ($idtipificacion == '5') {
        $inserta_agenda = "INSERT INTO agenda (idcliente,fecha,observacion,gestionado)
			VALUES(
                            '" . $idcliente . "',
                            '" . $fecha . "',
                            '" . $observacion . "',
                            '". 0 . "'
			)";
        bd_ejecutar_sql($inserta_agenda);
        $actualiza_cliente = "update clientes set agendado=1 where idcliente=" . $idcliente;
        bd_ejecutar_sql($actualiza_cliente);
    } else {
        $actualiza_cliente = "update clientes set idestado=1 where idcliente=" . $idcliente;
        bd_ejecutar_sql($actualiza_cliente);
    }

    if ($idsubtipificacion == '0') {
        $inserta_transaccion = "INSERT INTO transaccion (idcliente,idusuario,idtipificacion,
            idsubtipificacion,fecha,hora,observaciones,idcampania,idasignar)
			VALUES($idcliente, $idusuario, $idtipificacion, $idsubtipificacion, 
                            '" . date("Y-m-d") . "','" . date("H:i:s") . "',
                            '" . $observacion . "','" . $_SESSION['idcampania'] . "',
                                '" . $_SESSION['idasignar'] . "'
			)";
        bd_ejecutar_sql($inserta_transaccion);
    } else {
        $inserta_trans = "INSERT INTO transaccion (idcliente,idusuario,idtipificacion,idsubtipificacion,
            fecha,hora,observaciones,idcampania,idasignar)
			VALUES($idcliente ,$idusuario ,$idtipificacion,$idsubtipificacion,
                            '" . date("Y-m-d") . "','" . date("H:i:s") . "',
                            '" . $observacion . "','" . $_SESSION['idcampania'] . "',
                                '" . $_SESSION['idasignar'] . "'
                            )";
        bd_ejecutar_sql($inserta_trans);
    }
    header("Location: cliente_contacto.php");
}
