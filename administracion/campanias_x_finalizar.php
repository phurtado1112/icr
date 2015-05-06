<?php
include_once './funciones.general.php';

$consulta_campanias = "SELECT nombre, campania, programa, fechafin, activo, terminada, atraso 
    FROM incaecrm.campania_x_asesor_view 
    where activo='Si' and terminada='No' and (date_add(curdate(), interval 7 day)) < fechafin;;";
$lista_campanias = bd_ejecutar_sql($consulta_campanias);
while ($fila_campanias = bd_obtener_fila($lista_campanias)) {
    $campaniasfinal[] = $fila_campanias;
}

?>

<table class="table table-hover">
    <?php
    if (!isset($campaniasfinal)) {
        echo 'NO HAY CAMPAÑAS POR FINALIZAR';
    } else {
        echo"    
            <tr>
                <th>No.</th>
                <th>Campaña</th>
                <th>Programa</th>
                <th>Asesor</th>
                <th>Fecha Final</th>
                <th>Restan</th>
            </tr>";
        $i=1;
        foreach ($campaniasfinal as $c) {
            echo"
                <tr>
                    <td><b>".$i."</b></td>
                    <td>" . $c['campania'] . "</td>
                    <td>" . $c['programa'] . "</td>
                    <td>" . $c['nombre'] . "</td>
                    <td>" . $c['fechafin'] . "</td>
                    <td>" . $c['atraso'] . "</td>    
                </tr>
            ";
            $i++;
        }
    }
    ?> 
</table>