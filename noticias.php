<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_noticias = "SELECT * FROM noticias ";
$lista_noticias = bd_ejecutar_sql($consulta_noticias);
while ($filanews = bd_obtener_fila($lista_noticias)) {
    $noticias[] = $filanews;
}

$consulta_campania = "SELECT * FROM campanias where idcampania=" . $_SESSION['idcampania'];
$lista_campanias = bd_ejecutar_sql($consulta_campania);
$filacamp = bd_obtener_fila($lista_campanias);
$var_camp_nombre = $filacamp['campania'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>INCAE | CRM</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet"> 
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="#"><?php echo $var_camp_nombre; ?></a>
                    <div class="nav-collapse collapse">
                        <p class="navbar-text pull-right">
                            <a href="salir.php" class="navbar-link">Salir</a>
                        </p>
                        <ul class="nav">
                            <li class="active"><a href="noticias.php">Noticias</a></li>
                            <li><a href="cambio_estado.php">Estado</a></li>
                            <li><a href="cliente_nuevo.php">Nuevo Contacto</a></li>
                            <li><a href="cliente_contacto_agendado.php">Agendados</a></li>
                            <li><a href="cliente_contacto.php">Contactos</a></li>
                            <li><a href="cliente_atendido.php">Atendidos</a></li>                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
<!--            <div class="row-fluid">
                <div class="span3" id="sidebar">
                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                    </ul>
                </div>
            </div>-->
            <table id="tblnoti" ><tr><h1><center>Noticias</center></h1></tr></table>
            <table class="table table-hover">
                <?php
                if (!isset($noticias)) {
                    echo '<table align="center"><tr><th><h3><center>No hay Noticias </center></h3><th><tr><table>';
                } else {
                    ?>
                    <tr>
                        <th>FECHA</th>
                        <th>TÍTULO</th>
                        <th>INFORMACIÓN</th>
                    </tr>
                    <?php
                    foreach ($noticias as $c) {
                        echo"<tr>
                                <th>" . $c['fechacreado'] . "</th>
				<td>" . $c['titulo'] . "</td>
				<td>" . $c['contenido'] . "</td>
                            </tr>";
                    }
                }
                ?>
            </table> 
        </div>
        <div class="ac">
            <?php include ("pie.php"); ?>
        </div>
    </body>
</html>
