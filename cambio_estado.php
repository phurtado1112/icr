<!DOCTYPE html>
<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_estados = "SELECT * FROM estados";
$lista_estados = bd_ejecutar_sql($consulta_estados);
?>   
<html>
    <head>
        <meta charset="UTF-8">        
        <title>INCAE | CRM</title>

        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <!--<link href="css/reveal.css" rel="stylesheet">-->
        <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    </head>
    <body>
        <?php include ("menu.php"); ?>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3" id="sidebar">
                    <ul class="nav nav-list nav-collapse collapse">
                    </ul>                    
                </div>
            </div>
            <div class="block center login small">
                <div class="block_head">
                    <div class="bheadl"></div>
                    <div class="bheadr"></div>
                    <center><h2>Cambios de estados</h2></center> 
                </div>
                <div>
                    <div class="block_content" align="center">
                        <form>
                            <select onChange="estado()" id="idestados">            
                                <option value="0">-------</option>
                                <?php
                                    while ($filaestado = bd_obtener_fila($lista_estados)) {
                                ?>
                                    <option  value="<?php echo $filaestado['idestado']; ?>"><?php echo ($filaestado['estado']); ?></option>
                                <?php } ?>
                            </select>
                        </form>

                        <p>&nbsp; </p>
                        <div id="divhora" align="center"></div>             
                        <p>&nbsp; </p>

                        <div id="divbtn" align="center" style="display:none">
                            <input type="button" class="btn btn-primary btn-large" value="desbloquear" onClick="saveajx()">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ac">
            <?php include ("pie.php"); ?>
        </div>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/obj_ajax.js"></script>
        <script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
        <!--<script type="text/javascript" src="js/jquery.reveal.js"></script>-->
        <script type="text/javascript" src="js/cronos.js"></script>  
    </body>
</html>
