<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_usuarios = "select idusuario, idcampania from asignar";
$lista_usuarios = bd_ejecutar_sql($consulta_usuarios);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Reporte de Gestión por Campaña</title>
        <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="Admin/vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
        <link href="Admin/assets/styles.css" rel="stylesheet" media="screen">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="Admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="js/ajax.js"></script>
    </head>
    <body>
        <div>
            <?php
            include './menu_superior.php';
            ?>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span9" id="content">
                    <div class="row-fluid">
                        <div class="row-fluid">
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Reporte por Campaña</div>
                                </div>
                                <div class="block-content collapse in">
                                </div>
                                <form class="form-horizontal" id="frmgestionxprograma" name="frmgestionxprograma" method="post" action="../ireport/repote_gestion_x_campana.php">
                                    <div class="control-group">
                                        <label class="control-label">Agente</label>
                                        <div class="controls">
                                            <select id="idusuario" name="idusuario">
                                                <?php 
                                                    gen_llenar_combo("usuarios","idusuario","nombre",$asignacion["idusuario"]);
                                                ?>
                                            </select>
                                        </div>
                                    </div>                                           
                                    <div class="control-group">
                                        <label class="control-label">Campaña</label>
                                        <div class="controls">
                                            <select id="idcampania" name="idcampania">
                                                <?php 
                                                    gen_llenar_combo("campanias_activas_view","idcampania","campania",$asignacion["idcampania"]);
                                                ?>
                                            </select>
                                        </div>
                                    </div>  
                                    <div align="center">
                                                <input type="submit" name="Submit" class="btn btn-primary" value="Presentar" >
                                                <button type="reset" class="btn" onclick="location.href='rep_gestion_campania_form.php'">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
