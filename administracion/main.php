<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_campanias_vencidas = "SELECT nombre, campania, programa, fechafin, activo, terminada, atraso FROM incaecrm.campania_x_asesor_view where activo='Si' and terminada='No' and atraso > 0";
$lista_campanias_vencidas = bd_ejecutar_sql($consulta_campanias_vencidas);
while ($fila_campanias_vencidas = bd_obtener_fila($lista_campanias_vencidas)) {
    $campanias_vencidas[] = $fila_campanias_vencidas;
}

if (isset($campanias_vencidas)) {
    echo "<script language = javascript>";
    foreach ($campanias_vencidas as $cv) {
        echo "alert('La campaña" . $cv['campania'] . " tiene " . $cv['atraso'] . " días de atraso');";
    }
    echo "</script>";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Admin Inicio</title>
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
                <div class="span12" id="content">
                    <div class="row-fluid">
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="block">
                                    <div class="navbar navbar-inner block-header">
                                        <div class="muted pull-left"><h4>Usuarios conectados</h4></div>
                                    </div>
                                    <div class="block-content collapse in">
                                        <?php include 'usuarios_online.php' ?>	
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="block">
                                    <div class="navbar navbar-inner block-header">
                                        <div class="muted pull-left"><h3>Tipificaciones de hoy</h3></div>
                                        <div class="pull-right"></div>                                   
                                    </div>
                                    <div class="block-content collapse in">
                                        <?php include 'finales_encaliente.php' ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span10" id="content">
                    <div class="row-fluid">
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="block">
                                    <div class="navbar navbar-inner block-header">
                                        <div class="muted pull-left"><h3>Campaña por finalizar</h3></div>
                                    </div>
                                    <div class="block-content collapse in">
                                        <?php include 'campanias_x_finalizar.php' ?>	
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="ac">
            <?php
            include './pie.php';
            ?>
        </div>
        <script src="Admin/vendors/jquery-1.9.1.min.js"></script>
        <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>