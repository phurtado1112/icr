<?php
include_once './funciones.general.php';
//include 'Fconexion.php';
//session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_campania = "SELECT * FROM campanias where idcampania = 1";
$lista_campanias = bd_ejecutar_sql($consulta_campania);
$filacamp = bd_obtener_fila($lista_campanias);
$var_camp_nombre = $filacamp['campania'];

?>
<!DOCTYPE html>
<html class="no-js">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Admin Home Page</title>
        <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="Admin/vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
        <link href="Admin/assets/styles.css" rel="stylesheet" media="screen">
        <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <link rel="stylesheet" href="CALENDARIO/jquery-ui.css" />
    </head>
    <body>
        <div>
            <?php 
            include './menu_superior.php';
            ?>
        </div>        
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="main.php">Admin Panel</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i><?php echo $_SESSION['nombre_usuario'] ?><i class="caret"></i></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="#">Perfil</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a tabindex="-1" href="desconectar_usuario.php">Salir</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav">
                            <li class="active">
                                <a href="main.php">Inicio</a>
                            </li>
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Contenido <b class="caret"></b></a>
                                <ul class="dropdown-menu" id="menu1">
                                    <li>
                                        <a href="news.php">Noticias</a>
                                    </li>
                                    <li>
                                        <a href="asignar.php">Nueva Asignación</a>
                                    </li>                                    
                                    <li>
                                        <a href="new_usuaro.php">Nuevo Agente</a>
                                    </li>                                    
                                    <li>
                                        <a href="loadcamp.php">Nuevo Campaña</a>
                                    </li>                                    
                                </ul>
                            </li>                            
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Consultas <b class="caret"></b></a>
                                <ul class="dropdown-menu" id="menu2">
                                    <li>
                                        <a href="camp.php">Campaña</a>
                                    </li>
                                    <li>
                                        <a href="estados.php">Conectados</a>
                                    </li>
                                    <li>
                                        <a href="report_estados.php">Por estados</a>
                                    </li>
                                    <li>
                                        <a href="report_user.php">Usuarios</a>
                                    </li>                                    
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Reportes <b class="caret"></b></a>
                                <ul class="dropdown-menu" id="menu3">
                                    <li>
                                        <a href="gestionxprograma.php">Gestión por Programa</a>
                                    </li>
                                </ul>
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
                        <li>
                            <a href="main.php">Inicio</a>
                        </li>
                        <li  class="active">
                            <a href="camp.php">Compaña</a>
                        </li>
                        <li >
                            <a href="estados.php">Conectados</a>
                        </li>
                        <li>
                            <a href="report_user.php">Usuarios</a>
                        </li>
                    </ul>
                </div>

                <div class="span9" id="content">
                    <div class="row-fluid">
                        <div class="row-fluid">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Reporte por Campaña</div>
                                </div>
                                <div class="block-content collapse in">
                                </div>

                                <table align="center" >
                                    <tr>
                                        <td><strong> Desde: </strong><input type="text" id="D1" readonly name="Date1"  />  
                                            <strong> Hasta: </strong><input type="text" id="D2" readonly name="Date2" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Campañas</strong><br>
                                            <form>
                                                <select name="finales" id="finales" onChange="tipificacion(this.value)" >                                                    
                                                    <option value="0">Todas...</option>
                                                    <?php
                                                    while ($filacamp = bd_obtener_fila($lista_campanias)) {
                                                        ?>
                                                        <option  id="tipicacion1" value="<?php echo $filacamp['idcampania']; ?>"><?php echo $fila['campania']; ?></option>
                                                    <?php } ?>
                                                </select> 
                                                <select id="idfinal">
                                                    <option value="0">------</option>
                                                    <option value="9">No Interesado</option>                
                                                </select>
                                                <input type="button" class="btn btn-primary" value="Filtrar" onClick="filtrar()">
                                                </td>
                                                </tr>

                                                </table>     
                                                </div>
                                                <!-- /block -->
                                                </div>
                                                <div class="span9" id="content">
                                                    <div class="row-fluid">
                                                        <div class="row-fluid">
                                                            <!-- block -->
                                                            <div class="block">
                                                                <div class="navbar navbar-inner block-header">
                                                                    <div class="muted pull-left">Reporte por Campaña</div>
                                                                </div>
                                                                <div class="block-content collapse in">

                                                                </div>

                                                                <table align="center" >
                                                                    <tr>
                                                                        <td><strong> Desde: </strong><input type="text" id="Da1" readonly name="Dat1"  />  
                                                                            <strong> Hasta: </strong><input type="text" id="Da2" readonly name="Dat2" />
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                    <td>
                                                                        <p>
                                                                        </p>
                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                    <td><strong>Campañas</strong><br>
                                                                        <?php
//                                                                        $con = conexion();
//                                                                        $res = mysql_query("SELECT * FROM usuarios ", $con);
                                                                        ?>
                                                                        <form>
                                                                            <select name="finales" id="camp2" >
                                                                                <option value="0">Todas...</option>
                                                                                <?php
                                                                                while ($fila = mysql_fetch_array($res)) {
                                                                                    ?>
                                                                                    <option  id="tipicacion" value="<?php echo $fila['usuario']; ?>"><?php echo $fila['nombres']; ?></option>
                                                                                <?php } ?>
                                                                            </select> 

                                                                            <?php
//                                                                            $con = conexion();
//                                                                            $res = mysql_query("SELECT * FROM finales", $con);
                                                                            ?>
                                                                            <form>
                                                                                <select name="finales" id="finales2" onChange="tipificacion(this.value)" >

                                                                                    <option value="0">Todas...</option>

                                                                                    <?php
                                                                                    while ($fila = mysql_fetch_array($res)) {
                                                                                        ?>

                                                                                        <option   value="<?php echo $fila['idfinales']; ?>"><?php echo utf8_encode($fila['titulo']); ?></option>

                                                                                    <?php } ?>

                                                                                </select> 
                                                                                <input type="button" class="btn btn-primary" value="Filtrar" onClick="filtrar2()">
                                                                                </td>

                                                                                </table>     
                                                                                </div>
                                                                                <!-- /block -->
                                                                                </div>                    
                                                                                <div class="row-fluid">
                                                                                    <div class="span6">

                                                                                    </div>
                                                                                    <div class="span6">

                                                                                    </div>
                                                                                </div>


                                                                                </div>
                                                                                </div>
                                                                                <hr>

                                                                                </div>
                                                                                </div>

                                                                                <!--/.fluid-container-->
                                                                                <script src="Admin/vendors/jquery-1.9.1.min.js"></script>
                                                                                <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
                                                                                <script src="Admin/vendors/easypiechart/jquery.easy-pie-chart.js"></script>
                                                                                <script src="Admin/assets/scripts.js"></script>
                                                                                <script>
                                                                                    $(function() {
                                                                                        // Easy pie charts
                                                                                        $('.chart').easyPieChart({animate: 1000});
                                                                                    });
                                                                                </script>
                                                                                <script>
                                                                                    function filtrar() {
                                                                                        //FECHA
                                                                                        var D1 = document.getElementById('D1').value;
                                                                                        var D2 = document.getElementById('D2').value;


                                                                                        //TIPIFICACION
                                                                                        var tipificacion = document.getElementById('finales').value;
                                                                                        var final = document.getElementById('idfinal').value;


                                                                                        if (D1 == "") {
                                                                                            alert("Falta la primer Fecha");
                                                                                        } else {
                                                                                            if (D2 == "") {
                                                                                                alert("Falta la Segundo Fecha");
                                                                                            } else {
                                                                                                var opciones = "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=1, resizable=no";
                                                                                                window.open("viewreportfinales.php?D1=" + D1 + "&D2=" + D2 + "&tipificacion=" + tipificacion + "&final=" + final, "", opciones);
                                                                                                //		window.open("viewreportfinales.php?tipificacion="+tipificacion+"",opciones); 
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    function filtrar2() {
                                                                                        //FECHA
                                                                                        var D1 = document.getElementById('Da1').value;
                                                                                        var D2 = document.getElementById('Da2').value;

                                                                                        //TIPIFICACION
                                                                                        var camp = document.getElementById('camp2').value;
                                                                                        var tipificacion = document.getElementById('finales2').value;

                                                                                        if (D1 === "") {
                                                                                            alert("Falta la primer Fecha");
                                                                                        } else {
                                                                                            if (D2 === "") {
                                                                                                alert("Falta la Segundo Fecha");
                                                                                            } else {

                                                                                                var opciones = "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=1, resizable=no";
                                                                                                window.open("viewreportcamp.php?D1=" + D1 + "&D2=" + D2 + "&camp=" + camp + "&tipificacion=" + tipificacion, "", opciones);
                                                                                                //		window.open("viewreportfinales.php?tipificacion="+tipificacion+"",opciones); 
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                </script>		
                                                                                <script src="Admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
                                                                                <script src="CALENDARIO/jquery-1.9.1.js"></script>
                                                                                <script src="CALENDARIO/jquery-ui.js"></script>
                                                                                <script>
                                                                                    $(function() {
                                                                                        $("#D1").datepicker();
                                                                                    });
                                                                                    $(function() {
                                                                                        $("#D2").datepicker();
                                                                                    });
                                                                                    $(function() {
                                                                                        $("#Da1").datepicker();
                                                                                    });
                                                                                    $(function() {
                                                                                        $("#Da2").datepicker();
                                                                                    });
                                                                                </script>
                                                                                </body>
                                                                                </html>