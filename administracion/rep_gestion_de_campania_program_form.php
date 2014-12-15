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
        <title>Reporte de Gestión Total de Campaña</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="css/jquery-ui.css" rel="stylesheet">
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
                                    <div class="muted pull-left">Reporte de Gestión Total por Programa</div>
                                </div>
                                <div class="block-content collapse in">
                                </div>
                                <form class="form-horizontal" id="frmgestionxprograma" name="formgestioncampania" method="post" action="rep_gestion_de_campania_programa_procesar.php">
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
                                        <input type="submit" name="Submit" class="btn btn-primary" value="Presentar" onclick="document.formgestioncampania.target = '_blank'" >
                                        <button type="reset" class="btn" onclick="location.href = 'rep_gestion_campania_form.php'">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="Admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="Admin/vendors/jquery-1.9.1.min.js"></script>
        <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/cronos.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="Admin/assets/scripts.js"></script>
        <script src="js/ajax_agentes.js"></script>
        <script src="js/ajax.js"></script>
        <script>
            $(function() {
                $("#datepicker").datepicker({ dateFormat: "yy-mm-dd" });
                $("#datepicker1").datepicker({ dateFormat: "yy-mm-dd" });
            });
        </script>
    </body>
</html>
