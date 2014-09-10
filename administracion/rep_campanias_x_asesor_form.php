<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

//$consulta_usuarios = "select idusuario, idcampania from asignar";
//$lista_usuarios = bd_ejecutar_sql($consulta_usuarios);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Campañas por Asesor</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="css/jquery-ui.css" rel="stylesheet" property="">
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
                <div class="span12 well" id="content">
                    <div class="row-fluid">
                        <div class="row-fluid">
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Reporte de Campañas por Asesor</div>
                                </div>
                                <div class="block-content collapse in">
                                </div>
                                <form class="form-horizontal" id="formcampaniasxasesor" name="formcampaniasxasesor" method="post" action="rep_campanias_x_asesor_procesar.php">
                                    <fieldset class="radio">
                                        <legend> &nbsp; Tipo de Reporte</legend>
                                        <div class="control-group radio">
                                            <div class="controls radio">
                                                <input type="radio" name="tipo" id="tipo0" value="0" checked>Todas las Campañas<br>
                                                <input type="radio" name="tipo" id="tipo1" value="1">Campañas Activas<br>
                                                <input type="radio" name="tipo" id="tipo2" value="2">Campañas Inactivas<br>
                                                <!--<input type="radio" name="tipo" id="tipo3" value="3">Por Rango de fechas-->
                                            </div>
                                        </div>
                                    </fieldset>
<!--                                    <fieldset>
                                        <legend> &nbsp; Rango de Fechas</legend>
                                        <div class="control-group">
                                            <label class="control-label">Fecha Inicial</label>
                                            <div class="controls">
                                                <input type="text" id="datepicker" value="0000-00-00"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Fecha Final</label>
                                            <div class="controls">
                                                <input type="text" id="datepicker1" value="0000-00-00"/>
                                            </div>
                                        </div>
                                    </fieldset>-->
                                    <div class="form-actions">
                                        <input type="submit" name="Submit" class="btn btn-primary" value="Presentar" onclick="document.formcampaniasxasesor.target = '_blank'" >
                                        <button type="reset" class="btn">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="js/cronos.js"></script>  
        <script src="Admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="Admin/vendors/jquery-1.9.1.min.js"></script>
        <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="js/ajax_agentes.js"></script>
        <script src="js/ajax.js"></script>        
        <script>
            $(function() {
                $("#datepicker").datepicker({ dateFormat: "yy-mm-dd" });
            });
            $(function() {
                $("#datepicker1").datepicker({ dateFormat: "yy-mm-dd" });
            });
        </script>
    </body>
</html>
