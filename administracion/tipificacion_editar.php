<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$idtipificacion = filter_input(INPUT_GET, 'idtipificacion');

$consulta_tipificacion = "SELECT * FROM tipificacion WHERE idtipificacion='" . $idtipificacion . "' ";
$lista_tipificacion = bd_ejecutar_sql($consulta_tipificacion);
$tipificacion = bd_obtener_fila($lista_tipificacion);

$id = $tipificacion['idtipificacion'];
$tipificaci = $tipificacion['tipificacion'];
$idtipificaciontipo = $tipificacion['idtipificaciontipo'];
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>Editar Tipificación</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
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

                                    <form class="form-horizontal" action="tipificacion_editar_procesar.php" name="formnnews" method="POST">
                                        <div style="display:none"><input type="text" value="<?php echo $id; ?>" name="idtipificacion" size="1"></div>
                                        <fieldset>
                                            <legend >Editar Tipificación</legend>
                                            <div class="control-group">
                                                <label class="control-label">Tipificación</label>
                                                <div class="controls">
                                                    <input type="text" class="span6 typeahead" id="tipificacion" name="tipificacion" value="<?php echo $tipificaci; ?>" autofocus>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Tipificación</label>
                                                <div class="controls">
                                                    <select id="idtipificaciontipo" name="idtipificaciontipo">
                                                        <?php 
                                                            gen_llenar_combo("tipificaciontipo","idtipificaciontipo","tipificaciontipo",$idtipificaciontipo);
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <input type="button" class="btn btn-primary" onClick="validar()" value="Guardar">
                                                <button type="reset" class="btn" onclick="location.href='tipificacion_lista.php'">Cancelar</button>
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
        <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
        <script src="Admin/assets/scripts.js"></script>
        <script>
            function validar() {
                if (document.getElementById('tipificacion').value === '') {
                    alert('FALTA EL TIPIFICACIÓN');
                } else {
                    document.formnnews.submit();
                }
            }
        </script>
    </body>
</html>