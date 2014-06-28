<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$idestado = filter_input(INPUT_GET, 'idestado');

$consulta_estado = "SELECT * FROM estados WHERE idestado='" . $idestado . "' ";
$lista_estado = bd_ejecutar_sql($consulta_estado);
$estado_conectado = bd_obtener_fila($lista_estado);

$id = $estado_conectado['idestado'];
$estado = $estado_conectado['estado'];
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>Editar Estado de Agente</title>
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

                                    <form class="form-horizontal" action="estado_conectado_editar_procesar.php" name="formnnews" method="POST">
                                        <div style="display:none"><input type="text" value="<?php echo $id; ?>" name="idestado" size="1"></div>
                                        <fieldset>
                                            <legend >Editar Estado de Agente</legend>
                                            <div class="control-group">
                                                <label class="control-label">Estado de Agente</label>
                                                <div class="controls">
                                                    <input type="text" class="span6 typeahead" id="estado" name="estado" value="<?php echo $estado; ?>"  >
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <input type="button" class="btn btn-primary" onClick="validar()" value="Guardar">
                                                <button type="reset" class="btn" onclick="location.href='estado_conectado_lista.php'">Cancelar</button>
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
                if (document.getElementById('estado').value === '') {
                    alert('FALTA EL ESTADO');
                } 
                    document.formnnews.submit();
            }
        </script>
    </body>
</html>