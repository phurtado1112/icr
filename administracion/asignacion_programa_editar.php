<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}
$idcampania = filter_input(INPUT_GET,'idcampania');

$consulta_campania = "SELECT * FROM campanias where idcampania = ".$idcampania;
$lista_campania = bd_ejecutar_sql($consulta_campania);

$consulta_programa = "SELECT * FROM programas where activo=0 order by programa";
$lista_programa = bd_ejecutar_sql($consulta_programa);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Editar Asignación Campaña a Programa</title>
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

                                    <form class="form-horizontal" action="asignacion_programa_editar_procesar.php" name="formasignacionprog" method="POST">
                                        <div style="display:none"><input type="text" value="<?php echo $id; ?>" name="idasignar" size="1"></div>
                                        <fieldset>
                                            <legend >Editar Asignación Campaña a Programa</legend>
                                            <div class="control-group">
                                                <label class="control-label">Campaña</label>
                                                <div class="controls">
                                                    <select id="idcampania" name="idcampania">
                                                        <?php
                                                            while ($fila_campania = bd_obtener_fila($lista_campania)) {
                                                        ?>
                                                            <option value="<?php echo $fila_campania['idcampania'];?>"><?php echo $fila_campania['campania'];?></option>
                                                        <?php 
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Programa</label>
                                                <div class="controls">
                                                    <select id="idprograma" name="idprograma" autofocus>
                                                        <?php
                                                            while ($fila_programa = bd_obtener_fila($lista_programa)) {
                                                        ?>
                                                            <option value="<?php echo $fila_programa['idprograma'];?>"><?php echo $fila_programa['programa'];?></option>
                                                        <?php 
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <input type="button" class="btn btn-primary" onClick="validar()" value="Guardar">
                                                <button type="reset" class="btn" onclick="location.href = 'asignacion_programa_lista.php'">Cancelar</button>
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
                document.formasignacionprog.submit();
            }
        </script>
    </body>
</html>