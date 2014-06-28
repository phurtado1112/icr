<?php
include_once './funciones.general.php';
//if (!@mysql_connect("localhost","root","")) {
//	print 'Se produjo un error en la connecion a la bd';
//} else {
//	if(!@mysql_select_db("incae")) {
//		print 'no existe la base de datos';
//	}	
//}

$consulta_sesion = "SELECT * FROM session";
$lista_sesion = bd_ejecutar_sql($consulta_sesion);
while ($fila_sesion = bd_obtener_fila($lista_sesion)) {
    $usuarionline[] = $fila_sesion;
}

//$resultado = mysql_query($consulta_sesion);
//while ($fila = mysql_fetch_array($resultado)){
//    $usuarionline[]=$fila;
//}		
?>

<table class="table table-hover">
    <?php
    if (!isset($usuarionline)) {
        echo 'NO HAY USUARIO CONECTADO';
    } else {
        foreach ($usuarionline as $c) {
            echo"
						<tr>
						<td>" . $c['usuario'] . "</td>
						</tr>";
        }
    }
    ?> 
</table>