<!DOCTYPE html>
<html lang="es">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <meta name="robots" content="noindex, nofollow">
        <title>INCAE | CRM Login</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css" />        
        <link href="css/estilos.css" rel="stylesheet" type="text/css" />
        <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />        
    </head>

    <body>
        <p>&nbsp;</p>     
        <p>&nbsp;</p>
        <div id="login">
            <div id="logo" >
                <a href="#" title="LOGO INCAE"><img alt="Logo" src="images/incae_logo.png" height="100" width="280"></a>
            </div>
            <p>&nbsp;</p>
            <div class="container" id="titulologin"><h1 id="tituloexed">PROGRAMA ExEd</h1></div>
            <div class="block center login small">
                <div class="block_head">
                    <div class="bheadl"></div>
                    <div class="bheadr"></div>
                    <h2>Acceder</h2>

                </div>
                <div class="block_content">
                    <form accept-charset="UTF-8" action="acceso_usuario.php" class="new_user" id="new_user" method="post">
                        <input type="text" id="username" class="span4" name="usuario" placeholder="Usuario" size="30" autofocus>
                        <input type="password" id="password" class="span4" name="contrasena" placeholder="Contraseña" size="30">
                        <br><br><input class="btn btn-primary btn-large" name="commit" type="submit" value="Acceder">
                    </form>
                    <div class="bendl"></div>
                    <div class="bendr"></div>
                </div>
            </div>
            <div class="ac">
                <?php include ("pie.php"); ?>
            </div>
        </div>
        <script src="js/jquery-2.1.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
