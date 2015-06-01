<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_programas = "select distinct idprograma, programa from campanias_x_programa_view";
$lista_programas = bd_ejecutar_sql($consulta_programas);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Reporte Actualización por Programa</title>
        <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="Admin/assets/styles.css" rel="stylesheet" media="screen">
        <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />        
    </head>
    <body>
        <div>
            <?php
            include 'menu_superior.php';
            ?>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12 well" id="content">
                    <div class="row-fluid">
                        <div class="row-fluid">
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Reporte de Actualización por Programa</div>
                                </div>
                                <div class="block-content collapse in">
                                </div>
                                <form class="form-horizontal" id="frmactualizacionprograma" name="formactualizacionprograma" method="post" action="rep_actualizacion_programa_procesar.php">
                                    <div class="control-group">
                                        <label class="control-label">Programa</label>
                                        <div class="controls">
                                            <select id="idprograma" name="idprograma" onchange="load(this.value)">
                                                <?php
                                                while ($fila_programa = bd_obtener_fila($lista_programas)) {
                                                    ?>
                                                    <option value="<?php echo $fila_programa['idprograma']; ?>"><?php echo $fila_programa['programa']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                                <label class="control-label">Fecha Inicio</label>
                                                <div class="controls">
                                                    <input type="text" id="datepicker" name="fechainicio" value="<?php echo date('Y-m-d');?>" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Fecha Final</label>
                                                <div class="controls">
                                                    <input type="text" id="datepicker1" name="fechafin" value="<?php echo date('Y-m-d');?>" />
                                                </div>
                                            </div>
                                    <div class="form-actions">
                                        <input type="submit" name="Submit" class="btn btn-primary" value="Presentar" onclick="document.formactualizacionprograma.target = '_blank'" >
                                        <button type="reset" class="btn" onclick="location.href = 'rep_actualizacion_programa_form.php'">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="Admin/vendors/jquery-1.9.1.min.js"></script>
        <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
        <!--<script src="Admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>-->
        <script>
            $(function() {
                $("#datepicker").datepicker({ dateFormat: "yy-mm-dd" });
                $("#datepicker1").datepicker({ dateFormat: "yy-mm-dd" });
            });
        </script>
    </body>
</html>
