<?php
include_once './funciones.general.php';

$idtipi = filter_input(INPUT_POST, 'q');

$consulta_tipif = "select * from subtipificacion where idtipificacion=" . $idtipi;
$lista_tipif = bd_ejecutar_sql($consulta_tipif);
?>
<?php
if($idtipi==9 || $idtipi==10){
?>
<p>
    <select id="subfinales">
        <option value="0">-----</option>    
        <?php while ($filat = bd_obtener_fila($lista_tipif)) { ?>
            <option value="<?php echo $filat['idsubtipificacion']; ?>"><?php echo $filat['subtipificacion']; ?></option>
        <?php } ?>
    </select>
</p>
<?php
    }