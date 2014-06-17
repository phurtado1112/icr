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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>INCAE | CRM</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet"> 
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    </head>
    <body>
        <?php include ("menu.php"); ?>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3" id="sidebar">
                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                    </ul>
                </div>
            </div>
            <table id="tblnoti" ><tr><h3><center>Noticias</center></h3></tr></table>
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

    </body>
</html>
