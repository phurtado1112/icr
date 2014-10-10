<?php
include_once './funciones.general.php';

$q = filter_input(INPUT_POST,'q');

$consulta_campanias_activas_x_agente = "select idusuario,a.idcampania, a.idasignar, campania from asignar as a left join campanias as c on (a.idcampania=c.idcampania) where terminada='n' and idusuario=".$q;
$lista_camp_acti_x_agen = bd_ejecutar_sql($consulta_campanias_activas_x_agente);

?>

<select id="idasignar" name="idasignar">

<?php 
    while($fila = bd_obtener_fila($lista_camp_acti_x_agen)){ 
?>
 <option value="<?php echo $fila['idasignar'];?>"><?php echo $fila['campania']; ?></option>
<?php } ?>

</select>

