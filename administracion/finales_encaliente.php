<?php
include_once './funciones.general.php';

//        if (!@mysql_connect("localhost", "root", "")) {
//            print 'Se produjo un error en la connecion a la bd';
//        } else {
//            if (!@mysql_select_db("incae")) {
//                print 'no existe la base de datos';
//            }
//        }
//        $con = conexion();
//$query="SELECT * FROM view_transacciones_hoy WHERE idfinales='".$_POST['ajxtipificacion']."' ";
$consulta_tipifi = "SELECT count(idtipificacion) as CONTEO, idtipificacion as IDTIPIFICACION,tipificacion as TIPIFICACION FROM transacciones_view where fecha='" . date("Y-m-d") . "'  group by idtipificacion";
$lista_tipifi = bd_ejecutar_sql($consulta_tipifi);
while ($fila_tipifi = bd_obtener_fila($lista_tipifi)) {
    $contactos[] = $fila_tipifi;
}
//        $resultado = mysql_query($query);
//        while ($fila = mysql_fetch_array($resultado)) {
//            $contactos[] = $fila;
//        }
?>       
<table class="table table-hover">
    <?php
    if (!isset($contactos)) {
        echo '<div align="center">Tipificaciones en cero</div>';
    } else {
        ?>
        <tr>
            <th>Incidencia</th>
            <th>Tipificación</th>
        </tr>
        <?php
        foreach ($contactos as $c) {
            echo"
                        <tr>
                        <td>" . $c['CONTEO'] . "</td>
                        <td>" . $c['FINAL'] . "</td>
                        </tr>";
        }
    }
    ?>
</table>