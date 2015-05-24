<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

function cantidad_registros ($idcliente){
$consulta_existe_otro_registro = "SELECT count(*) idtrasaccion FROM transaccion WHERE idcliente=' " . $idcliente . "'";
    $lista_cantidad_registro = bd_ejecutar_sql($consulta_existe_otro_registro);
    $fila_cantidad_registro = bd_obtener_fila($lista_cantidad_registro);
    return $cantidad_registros = $fila_cantidad_registro['idtrasaccion'];
}