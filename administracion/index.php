<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Admin CRM INCAE</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="css/charisma-app.css" rel="stylesheet">
        <link href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
        <!--<link href='css/fullcalendar.css' rel='stylesheet'>-->
        <!--<link href='css/fullcalendar.print.css' rel='stylesheet'  media='print'>-->
        <!--<link href='css/chosen.css' rel='stylesheet'>-->
        <!--<link href='css/uniform.default.css' rel='stylesheet'>-->
        <!--<link href='css/colorbox.css' rel='stylesheet'>-->
        <link href='css/jquery.cleditor.css' rel='stylesheet'>
        <!--<link href='css/jquery.noty.css' rel='stylesheet'>-->
        <!--<link href='css/noty_theme_default.css' rel='stylesheet'>-->
        <!--<link href='css/elfinder.min.css' rel='stylesheet'>-->
        <!--<link href='css/elfinder.theme.css' rel='stylesheet'>-->
        <!--<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>-->
        <link href='css/opa-icons.css' rel='stylesheet'>
        <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    </head>

    <body>
        <div class="container-fluid">
            <div class="row-fluid">

                <div class="row-fluid">
                    <div class="span12 center login-header">
                        <h2>Administrador de CRM INCAE</h2>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="well span5 center login-box">
                        <div class="alert alert-info">
                            Ingrese su usuario y contraseña.
                        </div>
                        <form class="form-horizontal" action="acceso_usuario_proceso.php" method="post">
                            <fieldset>
                                <div class="input-prepend" title="Usuario" data-rel="tooltip">
                                    <span class="add-on"><i class="icon-user"></i></span><input autofocus class="input-large span10" name="usuario" id="Usuario" type="text"  />
                                </div>
                                <div class="clearfix"></div>

                                <div class="input-prepend" title="Contraseña" data-rel="tooltip">
                                    <span class="add-on"><i class="icon-lock"></i></span><input class="input-large span10" name="pass" id="Contrasena" type="password"  />
                                </div>
                                <div class="clearfix"></div>

                                <div class="clearfix"></div>

                                <p class="center span5">
                                    <button type="submit" class="btn btn-primary">Acceder</button>
                                </p>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="ac">
            <?php include ("pie.php"); ?>
        </div>
        <script src="../js/jquery-2.1.0.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/application.js"></script>
        <script src="js/jquery-1.7.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!--<script src="js/jquery-ui-1.8.21.custom.min.js"></script>-->
        <script src="js/bootstrap-transition.js"></script>
        <script src="js/bootstrap-alert.js"></script>
        <script src="js/bootstrap-modal.js"></script>
        <script src="js/bootstrap-dropdown.js"></script>
        <script src="js/bootstrap-scrollspy.js"></script>
        <script src="js/bootstrap-tab.js"></script>
        <script src="js/bootstrap-tooltip.js"></script>
        <script src="js/bootstrap-popover.js"></script>
        <script src="js/bootstrap-button.js"></script>
        <script src="js/bootstrap-collapse.js"></script>
        <script src="js/bootstrap-carousel.js"></script>
        <script src="js/bootstrap-typeahead.js"></script>
        <script src="js/bootstrap-tour.js"></script>
        <script src="js/jquery.cookie.js"></script>
        <script src='js/fullcalendar.min.js'></script>
        <script src='js/jquery.dataTables.min.js'></script>
        <script src="js/excanvas.js"></script>
        <script src="js/jquery.flot.min.js"></script>
        <script src="js/jquery.flot.pie.min.js"></script>
        <script src="js/jquery.flot.stack.js"></script>
        <script src="js/jquery.flot.resize.min.js"></script>
        <script src="js/jquery.chosen.min.js"></script>
        <script src="js/jquery.uniform.min.js"></script>
        <script src="js/jquery.colorbox.min.js"></script>
        <script src="js/jquery.cleditor.min.js"></script>
        <script src="js/jquery.noty.js"></script>
        <script src="js/jquery.elfinder.min.js"></script>
        <script src="js/jquery.raty.min.js"></script>
        <!--<script src="js/jquery.iphone.toggle.js"></script>-->
        <!--<script src="js/jquery.autogrow-textarea.js"></script>-->
        <script src="js/jquery.uploadify-3.1.min.js"></script>
        <script src="js/jquery.history.js"></script>
        <script src="js/charisma.js"></script>
    </body>
</html>
