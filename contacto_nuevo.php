<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_contactos = "SELECT * FROM clientes_contactos_view WHERE idestado=0 AND agendado=0 AND idasignar=" . $_SESSION['idasignar'];
$lista_contactos_campaña = bd_ejecutar_sql($consulta_contactos);
while ($filax = bd_obtener_fila($lista_contactos_campaña)) {
    $contactos[] = $filax;
}

$consulta_campania = "SELECT * FROM campanias where idcampania=" . $_SESSION['idcampania'];
$lista_campanias = bd_ejecutar_sql($consulta_campania);
$filacamp = bd_obtener_fila($lista_campanias);
$var_camp_nombre = $filacamp['campania'];

$consulta_cantidad_contactos = "SELECT count(*) as total FROM clientes WHERE idasignar='" . $_SESSION['idasignar'] . "'";
$lista_cantidad_contactos = bd_ejecutar_sql($consulta_cantidad_contactos);
$filas = bd_obtener_fila($lista_cantidad_contactos);
$total_contactos = $filas['total'];

$consulta_asesor = "SELECT nombre FROM usuarios WHERE idusuario='" . $_SESSION['idusuario'] . "'";
$lista_asesor = bd_ejecutar_sql($consulta_asesor);
$fila_asesor = bd_obtener_fila($lista_asesor);
$nombre_asesor = $fila_asesor['nombre'];
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
                        <ul class="nav">
                            <li><a href="noticias.php">Noticias</a></li>
                            <li><a href="cambio_estado.php">Estado</a></li>
                            <li><a href="contacto_nuevo_agregar.php">Nuevo Contacto</a></li>
                            <li><a href="contacto_agendado.php">Agendados</a></li>
                            <li class="active"><a href="contacto_nuevo.php">Contactos</a></li>
                            <li><a href="contacto_atendido.php">Atendidos</a></li> 
                            <li>		
                                <div>
                                    <input type="text" class="input-medium search-query" id="cadena" onKeyPress="getsearch(event)">
                                    <select id="idopcion">
                                        <option value="2">Nombre de contacto</option>
                                        <option value="3">Cargo</option>
                                        <option value="4">Empresa</option>
                                        <option value="5">Correo</option>
                                        <option value="6">País</option>
                                    </select>
                                    <button type="button" class="btn" onClick="porclick()">Buscar</button>
                                </div>      
                            </li>
                            <li><a></a></li>
                            <li><a href="contacto_agendado_todos.php">Todos los Agendados</a></li>
                            <li><a></a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><strong><?php echo $nombre_asesor; ?></strong><span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="salir.php">Salir</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3" id="sidebar">
                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">

                    </ul>
                </div>
            </div>
            <div id="container" align="center">   
                <h1 style="alignment-adjust: central">Contactos</h1>
                <h4 style="alignment-adjust: central">Total de Contactos de Campaña: <?php echo $total_contactos; ?> </h4>
                <div id="resul_search">
                    <table class="table">
                        <tr>
                            <th>No</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Celular</th>
                            <th>Tel. Oficina</th>
                            <th>Correo</th>
                            <th>Empresa</th>
                            <th>Cargo</th>
                            <th>País</th>
                            <th>Acción</th>
                        </tr>
                        <?php
                        if (!isset($contactos)) {
                            echo '<table><tr><th><h3><center>No exiten registros</center></h3><th><tr><table>';
                        } else {
                            $i = 1;
                            foreach ($contactos as $c) {
                                $ids = $c['idcliente'];
                                switch ($c['prioridad']) {
                                    case 2:
                                        echo"
                                            <tr>
                                                <td id='td2'><b>" . $i . "</b></td>
                                                <td id='td2'>" . ($c['nombre']) . "</td>
                                                <td id='td2'>" . ($c['telfijo']) . "</td>
                                                <td id='td2'>" . ($c['telmovil']) . "</td>
                                                <td id='td2'>" . ($c['teltrabajo']) . "</td>
                                                <td id='td2'>" . ($c['email']) . "</td>
                                                <td id='td2'>" . ($c['empresa']) . "</td>						
                                                <td id='td2'>" . ($c['cargo']) . "</td>
                                                <td id='td2'>" . ($c['pais']) . "</td>
                                                <td><strong>" . '<a href="contacto.php?idcliente=' . $ids . '&proceso=2">Gestionar</a>' . "</strong></td>
                                            </tr>";
                                        break;
                                    case 1:
                                        echo"
                                            <tr>
                                                <td id='td1'><b>" . $i . "</b></td>
                                                <td id='td1'>" . ($c['nombre']) . "</td>
                                                <td id='td1'>" . ($c['telfijo']) . "</td>
                                                <td id='td1'>" . ($c['telmovil']) . "</td>
                                                <td id='td1'>" . ($c['teltrabajo']) . "</td>
                                                <td id='td1'>" . ($c['email']) . "</td>    
                                                <td id='td1'>" . ($c['empresa']) . "</td>					
                                                <td id='td1'>" . ($c['cargo']) . "</td>
                                                <td id='td1'>" . ($c['pais']) . "</td>
                                                <td><strong>" . '<a href="contacto.php?idcliente=' . $ids . '&proceso=2">Gestionar</a>' . "</strong></td>
                                            </tr>";
                                        break;
                                    case 0:
                                        echo"
                                            <tr>
                                                <td id='td0'><b>" . $i . "</b></td>
                                                <td id='td0'>" . $c['nombre'] . "</td>
                                                <td id='td0'>" . $c['telfijo'] . "</td>
                                                <td id='td0'>" . $c['telmovil'] . "</td>
                                                <td id='td0'>" . $c['teltrabajo'] . "</td>
                                                <td id='td0'>" . $c['email'] . "</td>    
                                                <td id='td0'>" . $c['empresa'] . "</td>
                                                <td id='td0'>" . $c['cargo'] . "</td>
                                                <td id='td0'>" . ($c['pais']) . "</td>
                                                <td><strong>" . '<a href="contacto.php?idcliente=' . $ids . '&proceso=2">Gestionar</a>' . "</td>
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
        <script src="js/jquery-1.9.1.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/obj_ajax.js" type="text/javascript"></script>
        <script>
                                        function porclick()
                                        {
                                            var_numero = document.getElementById('cadena').value;
                                            var_opcion = document.getElementById('idopcion').value;
                                            buscarnuevos(var_numero, var_opcion);
                                        }
                                        function getsearch(even)
                                        {
                                            var keyPressed = (even.which) ? even.which : even.keyCode;
                                            if (keyPressed === 13) {
                                                var_numero = document.getElementById('cadena').value;
                                                var_opcion = document.getElementById('idopcion').value;
                                                buscarnuevos(var_numero, var_opcion);
                                            }
                                        }
        </script>
    </body>
</html>
