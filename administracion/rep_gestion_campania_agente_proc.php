<?php
include_once './funciones.general.php';

$q = filter_input(INPUT_POST,'q');

$consulta_campanias_activas_x_agente = "select idusuario,a.idcampania, campania from asignar as a left join campanias as c on (a.idcampania=c.idcampania) where terminada='n' and idusuario=".$q;
$lista_camp_acti_x_agen = bd_ejecutar_sql($consulta_campanias_activas_x_agente);

?>

<select>

<?php 
    while($fila = bd_obtener_fila($lista_camp_acti_x_agen)){ 
?>
 <option value="<?php echo $fila['idcampania'];?>"><?php echo $fila['campania']; ?></option>
<?php } ?>

</select>

