<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "index.php"
</script>';
}

$consulta_contactos = "SELECT * FROM transacciones_view WHERE idusuario='" . $_SESSION['idusuario'] . "'AND idcampania='" . $_SESSION['idcampania'] . "'";
$lista_contactos = bd_ejecutar_sql($consulta_contactos);
while ($filacontactos = bd_obtener_fila($lista_contactos)){
    $contactos[] = $filacontactos;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <title>INCAE | CRM</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <body>
        <?php include ("menu.php"); ?>
        <!--        <div class="navbar navbar-inverse navbar-fixed-top">
                    <div class="navbar-inner">
                        <div class="container-fluid">
                            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="brand" href="#"><?php //echo $nombre_camp;   ?></a>
                            <div class="nav-collapse collapse">
                                <p class="navbar-text pull-right">
                                    <a href="desconectar_usuario.php" class="navbar-link">Salir</a>
                                </p>
                                <ul class="nav">
                                    <li><a href="main.php">Home</a></li>
                                    <li><a href="main.php">Nuevo Contacto</a></li>
                                    <li><a href="search.php">Busqueda</a></li>
                                    <li class="active"><a href="clientehoy.php">Atendidos</a></li>
                                </ul>
                            </div>/.nav-collapse 
                            <input type="text" class="input-medium search-query" id="cadena" onKeyPress="getsearch(event)">
                            <select id="idopcion">
                                <option value="0">ALL</option>
                                <option value="6">Full Name</option> 	
                                <option value="3">Current Employer Title</option>
                                <option value="4">Current Employer</option>        
                                <option value="5">Email</option>            
                            </select>
                            <button type="button" class="btn" onClick="porclick()">Buscar</button>
                        </div>
        
                    </div>
                </div>-->

        <!--</div>/span-->
        <!--</div>/row-->
<!--
        <hr>

        <footer>

        </footer>-->
        <div id="container" align="center">   
            <h1 style="alignment-adjust: central">Clientes Atendidos</h1>       
            <div id="resul_search">
                <table class="table">

                    <?php
                    if (!isset($contactos)) {
                        echo '<table><tr><th><h3><center>No exite registro alguno</center></h3><th><tr><table>';
                    } else {
                        ?>	

                        <tr>
                            <th>Nombre</th>
                            <th>Cargo</th>
                            <th>Empresa</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>hora</th>
                            <th>fecha</th>                    
                            <th>Final</th>                    
                            <th>Observacion</th>                    
                            <th>Accion</th>                                                            
                        </tr>                    					
                        <?php
                        foreach ($contactos as $c) {
                            $ids = $c['idcliente'];
                            echo"
				<tr>
				<td>" . $c['nombre'] . "</h1></td>
				<td>" . $c['cargo'] . "</h1></td>
				<td>" . $c['empresa'] . "</h1></td>
				<td>" . $c['email'] . "</h1></td>
				<td>" . $c['telfijo'] . "</td>
				<td>" . $c['hora'] . "</td>
				<td>" . $c['fecha'] . "</td>
				<td>" . $c['tipificacion'] . "</td>																														
				<td>" . $c['observaciones'] . "</td>																																				
				<td>" . '<a href="cliente.php?idclient=' . $ids . '">Gestionar</a>' . "</td>						
									</tr>";
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
        <!--</div>-->
        <!--/.fluid-container-->

        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="js/jquery.js"></script>
<!--                    <script src="bootstrap/js/bootstrap-transition.js"></script>;
        <script src="bootstrap/js/bootstrap-alert.js"></script>;
        <script src="bootstrap/js/bootstrap-modal.js"></script>;
        <script src="bootstrap/js/bootstrap-dropdown.js"></script>;
        <script src="bootstrap/js/bootstrap-scrollspy.js"></script>;
        <script src="bootstrap/js/bootstrap-tab.js"></script>;
        <script src="bootstrap/js/bootstrap-tooltip.js"></script>;
        <script src="bootstrap/js/bootstrap-popover.js"></script>;
        <script src="bootstrap/js/bootstrap-button.js"></script>;
        <script src="bootstrap/js/bootstrap-collapse.js"></script>;
        <script src="bootstrap/js/bootstrap-carousel.js"></script>;
        <script src="bootstrap/js/bootstrap-typeahead.js"></script>;
        -->                    <script src="js/obj_ajax.js"></script>
        <script>
            function porclick()
            {
                var_numero = document.getElementById('cadena').value;
                var_opcion = document.getElementById('idopcion').value;

                searchdataAtendidos(var_numero, var_opcion);

            }
            function getsearch(evt)
            {

                var keyPressed = (evt.which) ? evt.which : event.keyCode;
                if (keyPressed === 13) {

                    var_numero = document.getElementById('cadena').value;
                    var_opcion = document.getElementById('idopcion').value;

                    searchdataAtendidos(var_numero, var_opcion);
                }
            }
        </script>
    </body>
</html>
