<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

//$consulta_campania = "SELECT * FROM campanias WHERE terminada= 'no'";
//$lista_campania = bd_ejecutar_sql($consulta_campania);
//$campania = bd_obtener_fila($lista_campania);
//
//$campani = $campania['campania'];
?>
<!DOCTYPE html>
<head lang="en">
    <meta charset="utf-8" />
    <title>Importar Datos</title>
    <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
    <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
    <link href="css/jquery-ui.css" rel="stylesheet">
    <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="Admin/assets/styles.css" rel="stylesheet" media="screen">
    <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
</head>
<body>
    <div>
        <?php
            include './menu_superior.php';
        ?>
    </div>
    <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12" id="content">
                    <div class="row-fluid">
                        <div class="row-fluid">
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left" align="center"></div>
                                </div>
                                <div class="block-content collapse in">

                                    <form class="form-horizontal" action="importar_datos_procecesar.php" name="formimportar" method="POST" enctype="multipart/form-data">
                                        <fieldset>
                                            <legend>Selecciona el archivo de Excel</legend>
                                            <div class="control-group">
                                                <label class="control-label">Campaña</label>
                                                <div class="controls">
                                                    <select id="idcampania" name="idcampania">
                                                        <?php 
                                                            gen_llenar_combo("campanias_activas_view","idcampania","campania");
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Archivo de Excel</label>
                                                <div class="controls">
                                                    <input type="file" name="excel" >
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Archivo de Excel</label>
                                                <div class="controls">
                                                    <input type="text" class="span1 typeahead" id="registros" name="registros"   >
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <input type="button" class="btn btn-primary" onClick="validar()" name='enviar' value="Importar">
                                                <button type="reset" class="btn" onclick="location.href='importar_datos.php'">Cancelar</button>
                                                <input type="hidden" value="upload" name="action" />
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                 
            </div>
        </div>
    
<!--    <form name="importa" method="post" action="importar_datos_procecesar.php" enctype="multipart/form-data" >
        <input type="file" name="excel" />
        <input type='submit' name='enviar'  value="Importar"  />
        <input type="hidden" value="upload" name="action" />
    </form>-->
</body>
</html>