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
    
    /* **** CARGA DE DATOS EN TABLA transaccion Y cliente_transaccion **** */
    
    $consulta_idpais="SELECT idpais from clientes where idcliente='".$idcliente."'";
    $lista_pais = bd_ejecutar_sql($consulta_idpais);
        $fila_idpais = bd_obtener_fila($lista_pais);
        $idpais = $fila_idpais['idpais'];
        
    $inserta_transaccion = "INSERT INTO transaccion (idcliente,idusuario,idtipificacion,
            idsubtipificacion,fecha,hora,observaciones,idcampania,idpais,idasignar)
			VALUES($idcliente, $idusuario, $idtipificacion, $idsubtipificacion, 
                            '" . date("Y-m-d") . "','" . date("H:i:s") . "',
                            '" . $observacion . "','" . $_SESSION['idcampania'] . "',
                                '".$idpais."',
                                '" . $_SESSION['idasignar'] . "'
			)";
    bd_ejecutar_sql($inserta_transaccion);

    $consulta_idtransaccion = "SELECT idtrasaccion FROM transaccion where idcliente='" . $idcliente . "'";
        $lista_idtransaccion = bd_ejecutar_sql($consulta_idtransaccion);
        $fila_idtransaccion = bd_obtener_fila($lista_idtransaccion);
        $idtransaccion = $fila_idtransaccion['idtrasaccion'];

        /* **** VERIFICACIÓN DEL idtipificación DE LA TRANSACCION **** */
    
    if ($idtipificacion == '5') {
        $inserta_agenda = "INSERT INTO agenda (idcliente,idtransaccion,fecha,observacion,gestionado)
			VALUES(
                            '" . $idcliente . "',
                            '" . $idtransaccion . "',
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

    /* **** VALIDACIÓN, VERIFICA SI EL CLIENTE YA TIENE OTRAS TRANSACCIONES 
     * Y LAS PROCESA PARA INDICAR CUAL ES LA ÚLTIMA TRANSACCION **** */
    
    $consulta_existe_otro_cliente = "select count(*) idtrasaccion from transaccion where idcliente=' " . $idcliente . "'";
    $lista_cantidad_cliente = bd_ejecutar_sql($consulta_existe_otro_cliente);
    $fila_cantidad_cliente = bd_obtener_fila($lista_cantidad_cliente);
    $cantidad_cliente = $fila_cantidad_cliente['idtrasaccion'];
    
    if ($cantidad_cliente <= 1) {
        $consulta_guarda_cliente_transaccion = "insert into cliente_transaccion (idcliente, idtransaccion) values('" . $idcliente . "' , '" . $idtransaccion . "')";
        bd_ejecutar_sql($consulta_guarda_cliente_transaccion);
    } else {
        $consulta_cliente_anterior = "select idtrasaccion as idtransaccion from transaccion where idcliente=' " . $idcliente . "'";
        $lista_transaccion_anterior = bd_ejecutar_sql($consulta_cliente_anterior);
        while ($fila_transaccion_anterior = bd_obtener_fila($lista_transaccion_anterior)) {
            $repetido[] = $fila_transaccion_anterior;
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

        /* **** SI EXISTEN MULTIPLES TRANSACCIONE PARA EL CONTACTO PROCESADO,
         *  SE ACTUALIZA LA TABLA DE cliente_transaccion CON EL ÚLTIMO idtransaccion **** */
        
        $consulta_idtransaccion_max = "select max(idtrasaccion) as idtransaccion from transaccion where idcliente = '" . $idcliente . "'";
        $lista_idtransaccion_max = bd_ejecutar_sql($consulta_idtransaccion_max);
        $fila_idtransaccion_max = bd_obtener_fila($lista_idtransaccion_max);
        $idtransaccion_max = $fila_idtransaccion_max['idtransaccion'];

        $consulta_actualiza_cliente_transaccion = "update cliente_transaccion set idtransaccion = '" . $idtransaccion_max . "' where idcliente = '" . $idcliente . "'";
        bd_ejecutar_sql($consulta_actualiza_cliente_transaccion);
    }

    header("Location: cliente_contacto.php");
}
