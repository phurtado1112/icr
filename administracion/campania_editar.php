<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$idcampania = filter_input(INPUT_GET, 'idcampania');

$consulta_campania = "SELECT * FROM campanias WHERE idcampania='" . $idcampania . "' ";
$lista_campania = bd_ejecutar_sql($consulta_campania);
$campania = bd_obtener_fila($lista_campania);

$id = $campania['idcampania'];
$campani = $campania['campania'];
$terminada = $campania['terminada'];
$fechainicio = $campania['fechainicio'];
$fechafin = $campania ['fechafin'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Editar Campaña</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/jquery-ui.css" rel="stylesheet">
        <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="Admin/assets/styles.css" rel="stylesheet" media="screen">
        <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    </head>
    <body>
        <div>
            <?php
            include './menu_superior.php';
            ?>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12" id="content">
                    <div class="row-fluid">
                        <div class="row-fluid">
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left" align="center"></div>
                                </div>
                                <div class="block-content collapse in">

                                    <form class="form-horizontal" action="campania_editar_procesar.php" name="formcampania" method="POST">
                                        <div style="display:none"><input type="text" value="<?php echo $id; ?>" name="idcampania" size="1"></div>
                                        <fieldset>
                                            <legend >Editar Campaña</legend>
                                            <div class="control-group">
                                                <label class="control-label">Campaña</label>
                                                <div class="controls">
                                                    <input type="text" class="span6 typeahead" id="campania" name="campania" value="<?php echo $campani; ?>"  >
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Terminada</label>
                                                <div class="controls">
                                                    <select>
                                                        <?php
                                                            $elementos_combo_terminadas = array("n"=>"No","s"=>"Si");
                                                            gen_llenar_combo_arreglo($elementos_combo_terminadas ,$terminada); 
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Fecha de Inicio</label>
                                                <div class="controls">
                                                    <input type="text" id="datepicker" name="fechainicio" value="<?php gen_imprimir_html($fechainicio) ?>" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Fecha de Fin</label>
                                                <div class="controls">
                                                    <input type="text" id="datepicker1" name="fechafin" value="<?php gen_imprimir_html($fechafin) ?>" />
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <input type="button" class="btn btn-primary" onClick="validar()" value="Guardar">
                                                <button type="reset" class="btn" onclick="location.href='campania_lista.php'">Cancelar</button>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                 
            </div>
        </div>
        <div class="ac">
            <?php
            include './pie.php';
            ?>
        </div>
        <script src="Admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="Admin/vendors/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="js/cronos.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
        <script src="Admin/assets/scripts.js"></script>
        <script>
            function validar() {
                if (document.getElementById('campania').value === '') {
                    alert('FALTA CAMPAÑA');
                } else {
                    document.formcampania.submit();
                }
            }
        </script>
        <script>
            $(function() {
                $("#datepicker").datepicker({ dateFormat: "yy-mm-dd" });
                $("#datepicker1").datepicker({ dateFormat: "yy-mm-dd" });
            });
        </script>
    </body>
</html>