<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Admin CRM INCAE</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bootstrap-cerulean.min.css" rel="stylesheet" type="text/css">
        <link href="css/estilos.css" rel="stylesheet" type="text/css">
        <link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
        <link href="css/charisma-app.css" rel="stylesheet" type="text/css">
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
                    <div class="well span4 center login-box">
                        <div class="alert alert-info">
                            Ingrese su usuario y contraseña.
                        </div>
                        <form class="form-horizontal" action="acceso_usuario_proceso.php" method="post">
                            <fieldset>
                                <div class="input-prepend" title="Usuario" data-rel="tooltip">
                                    <label class="control-label">Usuario</label>
                                    <span class="add-on"><i class="icon-user"></i></span>
                                    <input autofocus class="input-large span6" name="usuario" id="Usuario" type="text"  />
                                </div>
                                <div class="clearfix"></div>                                
                                <div class="input-prepend" title="Contraseña" data-rel="tooltip">
                                    <label class="control-label">Contraseña</label>
                                    <span class="add-on"><i class="icon-lock"></i></span>
                                    <input class="input-large span6" name="pass" id="Contrasena" type="password"  />
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
    </body>
</html>
