<?php
include_once './funciones.general.php';

$consulta_sesion = "SELECT nombre, usuario, inicio FROM session_view where fecha=curdate()";
$lista_sesion = bd_ejecutar_sql($consulta_sesion);
while ($fila_sesion = bd_obtener_fila($lista_sesion)) {
    $usuarionline[] = $fila_sesion;
}
		
?>

<table class="table table-hover">
    <?php
    if (!isset($usuarionline)) {
        echo 'NO HAY USUARIO CONECTADO';
    } else {
        echo"    
            <tr>
                <th>No.</th>
                <th>Asesor</th>
                <th>Usuario</th>
                <th>Hora Inicio</th>
            </tr>";
        $i=1;
        foreach ($usuarionline as $c) {
            echo"
                <tr>
                    <td><b>".$i."</b></td>
                    <td>" . $c['nombre'] . "</td>
                    <td>" . $c['usuario'] . "</td>
                    <td>" . $c['inicio'] . "</td>
                </tr>
            ";
            $i++;
        }
    }
    ?> 
</table>