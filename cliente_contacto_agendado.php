<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_asignar = "Select idasignar from asignar where idcampania='". $_SESSION['idcampania']. "' and idusuario='".$_SESSION['idusuario']."'";
$lista_asignar = bd_ejecutar_sql($consulta_asignar);
$fila_idasignar = bd_obtener_fila($lista_asignar);
$idasignar = $fila_idasignar['idasignar'];
$_SESSION['idasignar'] = $idasignar;

$consulta_contactos = "SELECT * FROM agenda_view WHERE idasignar='" . $_SESSION['idasignar'] . "' AND gestionado='0'";
$lista_contactos_campaña = bd_ejecutar_sql($consulta_contactos);
while ($filax = bd_obtener_fila($lista_contactos_campaña)) {
    $contactosx[] = $filax;
}

$consulta_campania = "SELECT * FROM campanias where idcampania=" . $_SESSION['idcampania'];
$lista_campanias = bd_ejecutar_sql($consulta_campania);
$filacamp = bd_obtener_fila($lista_campanias);
$var_camp_nombre = $filacamp['campania'];
?>
<!DOCTYPE html>
<html lang="es">
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
                            <li class="active"><a href="cliente_contacto_agendado.php">Agendados</a></li>
                            <li><a href="cliente_contacto.php">Contactos</a></li>
                            <li><a href="cliente_atendido.php">Atendidos</a></li>
                            <li>		
                                <div align="center">
                                    <input type="text" class="input-medium search-query" id="cadena" onKeyPress="getsearch(event)">
                                    <select id="idopcion">
                                        <option value="2">Nombre de contacto</option> 	
                                        <option value="3">Cargo</option>
                                        <option value="4">Empresa</option>
                                        <!--<option value="5">Correo</option>-->
                                        <option value="6">País</option>
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
                <h1 style="alignment-adjust: central">Contactos Agendados</h1>
                <div id="resul_search">
                    <table class="table">
                        <tr>
                            <th>No</th>
                            <th>Nombre</th>
                            <th>Fecha Contacto</th>
                            <th>Observación</th>
                            <th>Teléfono fijo</th>
                            <th>Teléfono móvil</th>
                            <th>Teléfono oficina</th>
                            <th>Empresa</th>
                            <th>Cargo</th>
                            <th>País</th>
                            <th>Acción</th>
                        </tr>
                        <?php
                        if (!isset($contactosx)) {
                            echo '<table><tr><th><h3><center>No exiten registros</center></h3><th><tr><table>';
                        } else {
                            $i=1;
                            foreach ($contactosx as $c) {
                                $ids = $c['idcliente'];
                                switch ($c['prioridad']) {
                                    case 2:
                                        echo"
                                            <tr>
                                                <td id='td2'><b>" . $i . "</b></td>
                                                <td id='td2'>" . ($c['nombre']) . "</td>
                                                <td id='td2'>" . ($c['fecha']) . "</td>
                                                <td id='td2'>" . ($c['observacion']) . "</td>
                                                <td id='td2'>" . ($c['telfijo']) . "</td>
                                                <td id='td2'>" . ($c['telmovil']) . "</td>
                                                <td id='td2'>" . ($c['teltrabajo']) . "</td>
                                                <td id='td2'>" . ($c['empresa']) . "</td>						
                                                <td id='td2'>" . ($c['cargo']) . "</td>
                                                <td id='td2'>" . ($c['pais']) . "</td>
                                                <td><b>" . '<a href="cliente_agendado.php?idcliente=' . $ids . '">Gestionar</a>' . "</b></td>
                                            </tr>";
                                        break;
                                    case 1:
                                        echo"
                                            <tr>
                                                <td id='td1'><b>" . $i . "</b></td>
                                                <td id='td1'>" . ($c['nombre']) . "</td>
                                                <td id='td1'>" . ($c['fecha']) . "</td>
                                                <td id='td1'>" . ($c['observacion']) . "</td>
                                                <td id='td1'>" . ($c['telfijo']) . "</td>
                                                <td id='td1'>" . ($c['telmovil']) . "</td>
                                                <td id='td1'>" . ($c['teltrabajo']) . "</td>    
                                                <td id='td1'>" . ($c['empresa']) . "</td>					
                                                <td id='td1'>" . ($c['cargo']) . "</td>
                                                <td id='td1'>" . ($c['pais']) . "</td>
                                                <td><b>" . '<a href="cliente_agendado.php?idcliente=' . $ids . '">Gestionar</a>' . "</b></td>
                                            </tr>";
                                        break;
                                    case 0:
                                        echo"
                                            <tr>
                                                <td id='td0'><b>" . $i . "</b></td>
                                                <td id='td0'>" . $c['nombre'] . "</td>
                                                <td id='td0'>" . $c['fecha'] . "</td>
                                                <td id='td0'>" . $c['observacion'] . "</td>
                                                <td id='td0'>" . $c['telfijo'] . "</td>
                                                <td id='td0'>" . $c['telmovil'] . "</td>
                                                <td id='td0'>" . $c['teltrabajo'] . "</td>    
                                                <td id='td0'>" . $c['empresa'] . "</td>
                                                <td id='td0'>" . $c['cargo'] . "</td>
                                                <td id='td0'>" . ($c['pais']) . "</td>
                                                <td><b>" . '<a href="cliente_agendado.php?idcliente=' . $ids . '">Gestionar</a>' . "</b></td>
                                            </tr>";
                                        break;
                                }
                                $i = $i + 1;
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
            function porclick() {
                var_numero = document.getElementById('cadena').value;
                var_opcion = document.getElementById('idopcion').value;
                searchagendados(var_numero, var_opcion);
            }
            
            function getsearch(evt) {
                var keyPressed = (evt.which) ? evt.which : event.keyCode;
                if (keyPressed === 13) {
                    var_numero = document.getElementById('cadena').value;
                    var_opcion = document.getElementById('idopcion').value;
                    searchagendados(var_numero, var_opcion);
                }
            }
        </script>
    </body>
</html>
