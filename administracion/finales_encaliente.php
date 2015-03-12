<?php
include_once './funciones.general.php';

$consulta_tipifi = "SELECT count(idtipificaciontipo) as CONTEO, idtipificaciontipo,tipificaciontipo FROM transacciones_tipos_view where fecha='" . date("Y-m-d") . "'  group by idtipificaciontipo";
$lista_tipifi = bd_ejecutar_sql($consulta_tipifi);
while ($fila_tipifi = bd_obtener_fila($lista_tipifi)) {
    $contactos[] = $fila_tipifi;
}
?>       
<table class="table table-hover">
    <?php
    if (!isset($contactos)) {
        echo '<div align="center"><h2>NO HAY GESTIÓN DE CONTACTOS</h2></div>';
    } else {
        ?>
        <tr>
            <th>Incidencias</th>
            <th>Tipificación</th>
        </tr>
        <?php
        foreach ($contactos as $c) {
            echo"
                <tr>
                    <td>" . $c['CONTEO'] . "</td>
                    <td>" . $c['tipificaciontipo'] . "</td>
                </tr>
                ";
        }
    }
    ?>
</table>
