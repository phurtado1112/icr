<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Usuarios Conectados</title>
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
                <div class="span12 well" id="content">
                    <div class="row-fluid">
                        <div class="row-fluid">
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Reporte de Usuarios Conectados</div>
                                </div>
                                <div class="block-content collapse in">
                                </div>
                                <form class="form-horizontal" id="formusuariosconectados" name="formusuariosconectados" method="post" action="rep_usuarios_conectados_procesar.php">
                                    <div class="form-actions">
                                        <input type="submit" name="Submit" class="btn btn-primary" value="Presentar" onclick="document.formusuariosconectados.target='_blank'" >
                                                <button type="reset" class="btn" onclick="location.href='rep_usuarios_conectados_form.php'">Cancelar</button>
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
        <script src="js/ajax_agentes.js"></script>
        <script src="js/ajax.js"></script>
    </body>
</html>
