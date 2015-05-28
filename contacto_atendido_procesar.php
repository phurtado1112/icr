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
$idtipificacion = filter_input(INPUT_POST, 'ajxfinales');
$idsubtipificacion = filter_input(INPUT_POST, 'ajxsubfinal');
$idusuario = filter_input(INPUT_POST, 'ajxuser');
$actualiza = filter_input(INPUT_POST, 'ajxactual');
$proceso = filter_input(INPUT_POST, 'ajxproceso');

error_reporting(0);

if (isset($idcliente)) {

    $consulta_idpais = "SELECT idpais FROM clientes WHERE idcliente='" . $idcliente . "'";
    $lista_pais = bd_ejecutar_sql($consulta_idpais);
    $fila_idpais = bd_obtener_fila($lista_pais);
    $idpais = $fila_idpais['idpais'];

    if ($actualiza == 'si') {
        $consulta_inserta = "INSERT INTO transaccion (idcliente,idusuario,idtipificacion,
            idsubtipificacion,fecha,hora,observaciones,idcampania,idpais,idasignar, ultimo)
			VALUES($idcliente, $idusuario, 14, 0, 
                            '" . date("Y-m-d") . "','" . date("H:i:s") . "',
                            '" . $observacion . "','" . $_SESSION['idcampania'] . "',
                                '" . $idpais . "','" . $_SESSION['idasignar'] . "', 0
			)";
        bd_ejecutar_sql($consulta_inserta);

        $consulta_existe_otro_registro = "SELECT count(*) idtrasaccion FROM transaccion WHERE idcliente=' " . $idcliente . "'";
        $lista_cantidad_registro = bd_ejecutar_sql($consulta_existe_otro_registro);
        $fila_cantidad_registro = bd_obtener_fila($lista_cantidad_registro);
        $cantidad_registros = $fila_cantidad_registro['idtrasaccion'];

        $consulta_cliente_anterior = "SELECT idtrasaccion FROM transaccion WHERE idcliente=' " . $idcliente . "'";
        $lista_transaccion_anterior = bd_ejecutar_sql($consulta_cliente_anterior);
        while ($fila_transaccion_anterior = bd_obtener_fila($lista_transaccion_anterior)) {
            $repetido[] = $fila_transaccion_anterior['idtrasaccion'];
        }

        switch ($cantidad_registros) {
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
            case 7:
                $transaccion_anterior = $repetido[5];
                break;
            case 8:
                $transaccion_anterior = $repetido[6];
                break;
            case 9:
                $transaccion_anterior = $repetido[7];
                break;
            case 10:
                $transaccion_anterior = $repetido[8];
                break;
        }

        $consulta_actualiza_ultimo = "UPDATE transaccion SET ultimo = 0 WHERE idtrasaccion = '" . $transaccion_anterior . "'";
        bd_ejecutar_sql($consulta_actualiza_ultimo);
    }

    /*     * *** CARGA DE DATOS EN TABLA transaccion Y cliente_transaccion **** */

    $inserta_transaccion = "INSERT INTO transaccion (idcliente,idusuario,idtipificacion,
            idsubtipificacion,fecha,hora,observaciones,idcampania,idpais,idasignar)
			VALUES($idcliente, $idusuario, $idtipificacion, $idsubtipificacion, 
                            '" . date("Y-m-d") . "','" . date("H:i:s") . "',
                            '" . $observacion . "','" . $_SESSION['idcampania'] . "',
                                '" . $idpais . "',
                                '" . $_SESSION['idasignar'] . "'
			)";
    bd_ejecutar_sql($inserta_transaccion);

    $consulta_idtransaccion = "SELECT idtrasaccion FROM transaccion WHERE idcliente='" . $idcliente . "' ORDER BY idtrasaccion DESC";
    $lista_idtransaccion = bd_ejecutar_sql($consulta_idtransaccion);
    $fila_idtransaccion = bd_obtener_fila($lista_idtransaccion);
    $idtransaccion = $fila_idtransaccion['idtrasaccion'];

    /*     * *** VERIFICACIÓN DEL idtipificación DE LA TRANSACCION **** */

    if ($idtipificacion == 5) {
        $inserta_agenda = "INSERT INTO agenda (idcliente,idtransaccion,fecha,observacion,gestionado)
			VALUES(
                            '" . $idcliente . "',
                            '" . $idtransaccion . "',
                            '" . $fecha . "',
                            '" . $observacion . "',
                            '" . 0 . "'
			)";
        bd_ejecutar_sql($inserta_agenda);

        $actualiza_cliente = "UPDATE clientes SET idestado=0, agendado=1 WHERE idcliente='" . $idcliente . "'";
        bd_ejecutar_sql($actualiza_cliente);
    } else {
        $actualiza_cliente = "UPDATE clientes SET idestado=1, agendado=0 WHERE idcliente='" . $idcliente . "'";
        bd_ejecutar_sql($actualiza_cliente);
    }

    /*     * *** VALIDACIÓN, VERIFICA SI EL CLIENTE YA TIENE OTRAS TRANSACCIONES 
     * Y LAS PROCESA PARA INDICAR CUAL ES LA ÚLTIMA TRANSACCION **** */

    $consulta_existe_otro_registro = "SELECT count(*) idtrasaccion FROM transaccion WHERE idcliente=' " . $idcliente . "'";
    $lista_cantidad_registro = bd_ejecutar_sql($consulta_existe_otro_registro);
    $fila_cantidad_registro = bd_obtener_fila($lista_cantidad_registro);
    $cantidad_registros = $fila_cantidad_registro['idtrasaccion'];

    $consulta_cliente_anterior = "SELECT idtrasaccion FROM transaccion WHERE idcliente=' " . $idcliente . "'";
    $lista_transaccion_anterior = bd_ejecutar_sql($consulta_cliente_anterior);
    while ($fila_transaccion_anterior = bd_obtener_fila($lista_transaccion_anterior)) {
        $repetido[] = $fila_transaccion_anterior['idtrasaccion'];
    }

    switch ($cantidad_registros) {
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
        case 7:
            $transaccion_anterior = $repetido[5];
            break;
        case 8:
            $transaccion_anterior = $repetido[6];
            break;
        case 9:
            $transaccion_anterior = $repetido[7];
            break;
        case 10:
            $transaccion_anterior = $repetido[8];
            break;
    }

    $consulta_actualiza_ultimo = "UPDATE transaccion SET ultimo = 0 WHERE idtrasaccion = '" . $transaccion_anterior . "'";
    bd_ejecutar_sql($consulta_actualiza_ultimo);

    /*     * *** SI EXISTEN MULTIPLES TRANSACCIONE PARA EL CONTACTO PROCESADO,
     *  SE ACTUALIZA LA TABLA DE cliente_transaccion CON EL ÚLTIMO idtransaccion **** */

    $consulta_idtransaccion_max = "SELECT max(idtrasaccion) as idtransaccion FROM transaccion WHERE idcliente = '" . $idcliente . "'";
    $lista_idtransaccion_max = bd_ejecutar_sql($consulta_idtransaccion_max);
    $fila_idtransaccion_max = bd_obtener_fila($lista_idtransaccion_max);
    $idtransaccion_max = $fila_idtransaccion_max['idtransaccion'];

    $consulta_actualiza_cliente_transaccion = "UPDATE cliente_transaccion set idtransaccion = '" . $idtransaccion_max . "' WHERE idcliente = '" . $idcliente . "'";
    bd_ejecutar_sql($consulta_actualiza_cliente_transaccion);

    header("Location: cliente_contacto.php");
}

