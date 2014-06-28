<?php
//Iniciar Sesión
session_start();
if (!$_SESSION){
	echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

if (!@mysql_connect("localhost","root","1a2b3c")) {
	print 'Se produjo un error en la connecion a la bd';
} else {
	if(!@mysql_select_db("incae")) {
		print 'no existe la base de datos';
	}	
}
$query="SELECT * FROM session";
$resultado = mysql_query($query);
	while ($fila = mysql_fetch_array($resultado)){
	$contactos[]=$fila;

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
                        <li>
                            <a href="camp.php">Compaña</a>
                        </li>
                        <li class="active">
                            <a href="estados.php">Conectados</a>
                        </li>
                        <li>
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
                                <div class="muted pull-left">Usuarios Conectados</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span3">
          <table class="table table-hover">
				<tr>

					<th>user</th>
				</tr>
                    <?php
					if (!isset($contactos)){						
						echo 'NO exite registro alguno';
					}else{
					foreach($contactos as $c){
						echo"
						<tr>
						<td>".utf8_encode($c['username'])."</td>
						</tr>";
					
					}}				

				?> 
                
</table>

                                </div>

  
                                <div align="right"><a href="new_usuaro.php" class="btn btn-small btn-success">New+</a></div>
                                </div>
                            </div>
                        </div>
                        
              
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
    </body>

</html>
