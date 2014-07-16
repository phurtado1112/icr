<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$idasignar = filter_input(INPUT_GET, 'idasignar');

$consulta_asignacion = "SELECT * FROM asignacion_view WHERE idasignar='" . $idasignar . "' ";
$lista_asignacion = bd_ejecutar_sql($consulta_asignacion);
$asignacion = bd_obtener_fila($lista_asignacion);

$id = $asignacion['idasignar'];
$usuario = $asignacion['nombre'];
$campania = $asignacion['campania'];

?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>Editar Asignación</title>
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

                                    <form class="form-horizontal" action="asignacion_editar_procesar.php" name="formasignacion" method="POST">
                                        <div style="display:none"><input type="text" value="<?php echo $id; ?>" name="idasignar" size="1"></div>
                                        <fieldset>
                                            <legend >Editar Asignación</legend>
                                            <div class="control-group">
                                                <label class="control-label">Agente</label>
                                                <div class="controls">
                                                    <select id="idusuario" name="idusuario" autofocus>
                                                        <?php 
                                                            gen_llenar_combo("asignacion_view","idusuario","nombre",$asignacion["idusuario"]);
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Campaña</label>
                                                <div class="controls">
                                                   <select id="idcampania" name="idcampania">
                                                        <?php 
                                                            gen_llenar_combo("asignacion_view","idcampania","campania",$asignacion["idcampania"]);
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <input type="button" class="btn btn-primary" onClick="validar()" value="Guardar">
                                                <button type="reset" class="btn" onclick="location.href='asignacion_lista.php'">Cancelar</button>
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
                document.formasignacion.submit();
            }
        </script>
    </body>
</html>