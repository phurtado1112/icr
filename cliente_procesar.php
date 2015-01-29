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
                            '" . 0 . "'
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

    $consulta_existe_otro_cliente = "select count(*) idtrasaccion from transaccion where idcliente=' " . $idcliente . "'";
    $lista_cantidad_cliente = bd_ejecutar_sql($consulta_existe_otro_cliente);
    $fila_cantidad_cliente = bd_obtener_fila($lista_cantidad_cliente);
    $cantidad_cliente = $fila_cantidad_cliente['idtrasaccion'];

    if ($cantidad_cliente > 1) {
        $consulta_cliente_anterior = "select idtrasaccion as idtransaccion from transaccion where idcliente=' " . $idcliente . "'";
        $lista_transaccion_anterior = bd_ejecutar_sql($consulta_cliente_anterior);
        while ($fila_transaccion_anterior = bd_obtener_fila($lista_transaccion_anterior)){
            $repetido[]=$fila_transaccion_anterior;
        }

        switch ($cantidad_cliente) {
            case 2:    
                $transaccion_anterior = $repetido[0];
                break;
            case 3:    
                $transaccion_anterior = $repetido[1];
                break;
            case 4:    
                $transaccion_anterior = $repetido[2];
                break;
            case 5:    
                $transaccion_anterior = $repetido[3];
                break;
            case 6:    
                $transaccion_anterior = $repetido[4];
                break;
        }
        
        $consulta_actualiza_ultimo = "UPDATE transaccion SET ultimo = '0' WHERE idtrasaccion = '" 
                . $transaccion_anterior['idtransaccion'] . "'";
        bd_ejecutar_sql($consulta_actualiza_ultimo);
    }

    header("Location: cliente_contacto.php");
}
