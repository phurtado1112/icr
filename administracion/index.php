<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Admin CRM INCAE</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="css/estilos.css" rel="stylesheet" type="text/css">
        <link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
        <link href="css/charisma-app.css" rel="stylesheet" type="text/css">
        <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    </head>

    <body oncontextmenu="return false" onkeydown="return false">
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
                            <br>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <span class="add-on icon-user"></span>
                                    <input class="form-control" name="usuario" id="Usuario" type="text" placeholder="Usuario" autofocus />
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <span class="add-on icon-lock"></span>
                                    <input class="form-control" name="pass" id="Contrasena" type="password" placeholder="Contraseña" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="center span5">
                                    <button type="submit" class="btn btn-primary">Acceder</button>
                                </div>
                            </div>
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
