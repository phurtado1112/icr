<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_campania = "SELECT * FROM campanias where idcampania=" . $_SESSION['idcampania'];
$lista_campanias = bd_ejecutar_sql($consulta_campania);
$filacamp = bd_obtener_fila($lista_campanias);
$var_camp_nombre = $filacamp['campania'];
?>
<!DOCTYPE html>
<html lang="es">
<!--    <head>
        <title></title>
        <meta charset="UTF-8">
        <title>INCAE | CRM</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

             
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet">        
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
    </head>-->
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
                            <li><a href="noticias.php">Noticias</a></li>
                            <li><a href="cambio_estado.php">Estado</a></li>
                            <li><a href="cliente_nuevo.php">Nuevo Contacto</a></li>
                            <li class="active"><a href="contactos.php">Busqueda</a></li>
                            <li><a href="cliente_atendido.php">Atendidos</a></li>
                            <li>		
                                <div align="center">
                                    <input type="text" class="input-medium search-query" id="cadena" onKeyPress="getsearch(event)">
                                    <select id="idopcion">
                                        <option value="1">Nombre de Contacto</option> 	
                                        <option value="0">Todos</option>
                                        <option value="3">Puesto de trabajo</option>
                                        <option value="4">Empresa</option>        
                                        <option value="5">Email</option>            
                                    </select>
                                    <button type="button" class="btn" onClick="porclick()">Buscar</button>
                                </div>        
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--        <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="span3" id="sidebar">
                            <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                                <li></li>
                                <li></li>
                            </ul>
                        </div>
                    </div>
                    <hr>-->        

<!--        <script src="js/jquery-2.1.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/obj_ajax.js"></script>-->
<!--        <script type="text/javascript">
                                        searchdata('0', '');
        </script>
        <script>
            function porclick()
            {
                var_numero = document.getElementById('cadena').value;
                var_opcion = document.getElementById('idopcion').value;
                searchdata(var_numero, var_opcion);

            }
            function getsearch(evt)
            {

                var keyPressed = (evt.which) ? evt.which : event.keyCode;
                if (keyPressed === 13) {

                    var_numero = document.getElementById('cadena').value;
                    var_opcion = document.getElementById('idopcion').value;

                    searchdata(var_numero, var_opcion);
                }
            }
        </script>-->
    </body>
</html>
