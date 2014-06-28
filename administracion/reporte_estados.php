<?php
include 'Fconexion.php';
	session_start();	
if (!$_SESSION){
	echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';

}

?>
<!DOCTYPE html>
<html class="no-js">
    
    <head>
        <title>Admin Home Page</title>
        <!-- Bootstrap -->
        <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="Admin/vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
        <link href="Admin/assets/styles.css" rel="stylesheet" media="screen">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="Admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        
    </head>
    
    <body>
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
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i><?php echo $_SESSION['nameuser']?><i class="caret"></i>

                                </a>
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
                                <a href="main.php">Home</a>
                            </li>
                                                        <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Contenido <b class="caret"></b>

                                </a>
                                <ul class="dropdown-menu" id="menu1">
                                    <li>
                                        <a href="news.php">Noticia</a>
                                    </li>
                                    <li>
                                        <a href="new_usuaro.php">Nuevo Agente</a>
                                    </li>                                       
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Reporteria <b class="caret"></b>

                                </a>
                                <ul class="dropdown-menu" id="menu1">
                                    <li>
                                        <a href="camp.php">Compaña</a>
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
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3" id="sidebar">
                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                        <li>
                            <a href="main.php">Home</a>
                        </li>
                        <li >
                            <a href="camp.php">Compaña</a>
                        </li>
                        <li>
                            <a href="estados.php">Conectados</a>
                        </li>
		       <li class="active">
                            <a href="report_user.php">Usuarios</a>
                        </li>
                    </ul>
                </div>
                
                <!--/span-->
                <div class="span9" id="content">
                    <div class="row-fluid">
                    <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Reporte por Usuarios</div>
                            </div>
                            <div class="block-content collapse in">
                        
                            </div>

<table align="center" >
  <tr>
<?php
            
            $con=conexion();
            $res=mysql_query("SELECT id_usuario,usuario FROM users",$con);
            
            ?>
            <form>
            <select name="finales" id="finales" onChange="tipificacion(this.value)" >
            
            <option value="0">Usuario...</option>
            
            <?php
            
            while($fila=mysql_fetch_array($res)){
            
            ?>
            
             <option  id="tipicacion" value="<?php echo $fila['id_usuario']; ?>"><?php echo utf8_encode($fila['usuario']); ?></option>
            
            <?php } ?>
            
            </select> 
    <strong> Desde: </strong><input type="text" id="D1" readonly name="Date1"  />  
	<strong> Hasta: </strong><input type="text" id="D2" readonly name="Date2" /><input type="button" class="btn btn-primary" value="Filtrar" onClick="filtrar()">
	<td>
    
</td>
  
  </tr>
	    <td>

          </td>
    </tr>
	  <td>
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
	function filtrar(){
		var D1 = document.getElementById('D1').value;
		var D2 = document.getElementById('D2').value;
		
		//TIPIFICACION
		var tipificacion = document.getElementById('finales').value;

		if(D1==""){
			alert("Falta la primer Fecha");		
		}else{
			if(D2==""){
				alert("Falta la Segundo Fecha");		
			}else{
	if(tipificacion=='0'){
				alert("Falta el usuario");		
			}else{
		var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=1, resizable=no";
		window.open("viewreportestados.php?D1="+D1+"&D2="+D2+"&tipificacion="+tipificacion,"",opciones); 
				
		}
				

			}
		}
		

		
			}
		
	
	</script>		
      <link rel="stylesheet" href="CALENDARIO/jquery-ui.css" />        
   <script src="CALENDARIO/jquery-1.9.1.js"></script>
  <script src="CALENDARIO/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#D1" ).datepicker();
  });
  $(function() {
    $( "#D2" ).datepicker();
  });
  </script>        
  
    </body>

</html>