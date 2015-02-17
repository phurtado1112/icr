<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$idtipificaciontipo = filter_input(INPUT_GET, 'idtipificaciontipo');

$consulta_tipificaciontipo = "SELECT * FROM tipificaciontipo where idtipificaciontipo='".$idtipificaciontipo."'";
$lista_tipificaciontipo = bd_ejecutar_sql($consulta_tipificaciontipo);
$tipificaciontip = bd_obtener_fila($lista_tipificaciontipo);

$id = $tipificaciontip['idtipificaciontipo'];
$tipificacion_tipo = $tipificaciontip['tipificaciontipo'];
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>Editar Tipo Tipificación</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <!--<link href="Admin/assets/styles.css" rel="stylesheet" media="screen">-->
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

                                    <form class="form-horizontal" action="tipificacion_tipo_editar_procesar.php" name="formtipificaciontipo" method="POST">
                                        <div style="display:none"><input type="text" value="<?php echo $id; ?>" name="idtipificaciontipo" size="1"></div>
                                        <fieldset>
                                            <legend>Editar Tipo de Tipificación</legend>
                                            <div class="control-group">
                                                <label class="control-label">Tipo de Tipificación</label>
                                                <div class="controls">
                                                    <input type="text" class="span6 typeahead" id="tipificaciontipo" name="tipificaciontipo" value="<?php echo $tipificacion_tipo; ?>" autofocus>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <input type="button" class="btn btn-primary" onClick="validar()" value="Guardar">
                                                <button type="reset" class="btn" onclick="location.href='tipificacion_tipo_lista.php'">Cancelar</button>
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
        <!--<script src="Admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>-->
        <script src="Admin/vendors/jquery-1.9.1.min.js"></script>
        <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
        <!--<script src="Admin/assets/scripts.js"></script>-->
        <script>
            function validar() {
                if (document.getElementById('tipificaciontipo').value === '') {
                    alert('FALTA LEAD');
                } 
                    document.formtipificaciontipo.submit();
            }
        </script>
    </body>
</html>