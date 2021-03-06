<?php
include_once './funciones.general.php';

if (!isset($_SESSION)) {
    session_start();
}

$consultaCamp = "SELECT idasignar,Idcamp,campania FROM asignar_view WHERE terminada='n' and ID='" . $_SESSION['idusuario'] . "'";
$lista_campanias = bd_ejecutar_sql($consultaCamp);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>INCAE | Campaña</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    </head>
    <body>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <div id="login">
            <div id="logo">
                <a href="#" title="LOGO INCAE"><img alt="Logo" height="99" src="images/incae_logo.png" width="313"></a>
            </div>
            <div class="block center login small">
                <div class="block_head">
                    <div class="bheadl"></div>
                    <div class="bheadr"></div>
                    <h2>Campaña</h2>

                </div>
                <div class="block_content">
                    <div align="center">
                        <form action="campania_acceso_procesar.php" class="new_user" id="new_user" method="post">
                            <div class="control-group">
                            <select name="idasignar" >            
                                <option value="0">Campaña...</option>
                                <?php
                                    while ($fila = bd_obtener_fila($lista_campanias)) {
                                ?>
                                        <option  value="<?php echo $fila['idasignar']; ?>"><?php echo utf8_encode($fila['campania']); ?></option>
                                <?php                                 
                                    } 
                                ?>
                            </select>
                            </div>
                            <input class="btn btn-primary btn-large" name="commit" type="submit" value="Acceder">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="reset" class="btn btn-primary btn-large" onclick="location.href = 'index.php'">Cancelar</button>
                        </form>
                    </div>
                </div>
                <div class="bendl"></div>
                <div class="bendr"></div>
            </div>
        </div>
        <div class="ac">
            <?php include ("pie.php"); ?>
        </div>
        <script src="js/jquery-2.1.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>