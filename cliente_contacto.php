<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_contactos = "SELECT * FROM clientes WHERE idestado=0 and agendado=0 and idcampania=" . $_SESSION['idcampania'];
$lista_contactos_campaña = bd_ejecutar_sql($consulta_contactos);
while ($filax = bd_obtener_fila($lista_contactos_campaña)) {
    $contactos[] = $filax;
}

$consulta_campania = "SELECT * FROM campanias where idcampania=" . $_SESSION['idcampania'];
$lista_campanias = bd_ejecutar_sql($consulta_campania);
$filacamp = bd_obtener_fila($lista_campanias);
$var_camp_nombre = $filacamp['campania'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
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
                            <li><a href="noticias.php">Noticias</a></li>
                            <li><a href="cambio_estado.php">Estado</a></li>
                            <li><a href="cliente_nuevo.php">Nuevo Contacto</a></li>
                            <li><a href="cliente_contacto_agendado.php">Agendados</a></li>
                            <li class="active"><a href="cliente_contacto.php">Contactos</a></li>
                            <li><a href="cliente_atendido.php">Atendidos</a></li>
                            <li>		
                                <div align="center">
                                    <input type="text" class="input-medium search-query" id="cadena" onKeyPress="getsearch(event)">
                                    <select id="idopcion">
                                        <option value="2">Nombre de contacto</option> 	
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
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3" id="sidebar">
                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">

                    </ul>
                </div>
            </div>
            <div id="container" align="center">   
                <h1 style="alignment-adjust: central">Contactos</h1>       
                <div id="resul_search">
                    <table class="table">
                        <?php
                        if (!isset($contactos)) {
                            echo '<table><tr><th><h3><center>No exite registro alguno</center></h3><th><tr><table>';
                        } else {
                            ?>
                            <tr>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Celular</th>
                                <th>Tel. Oficina</th>
                                <th>Empresa</th>
                                <th>Cargo</th>
                                <th>Acción</th>
                            </tr>                    					
                            <?php
                            foreach ($contactos as $c) {
                                $ids = $c['idcliente'];
                                echo"
				<tr>
				<td>" . $c['nombre'] . "</td>
				<td>" . $c['telfijo'] . "</td>
                                <td>" . $c['telmovil'] . "</td>
				<td>" . $c['teltrabajo'] . "</td>
				<td>" . $c['empresa'] . "</td>
				<td>" . $c['cargo'] . "</td>
				<td>" . '<a href="cliente.php?idcliente=' . $ids . '">Gestionar</a>' . "</td>
									</tr>";
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="ac">
            <?php include ("pie.php"); ?>
        </div>
        <script src="js/obj_ajax.js"></script>
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
        </script>
    </body>
</html>
