<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_estado_campanias = "select * from estado_campania_view where terminada='n' order by idasignar";

$lista_estado_campanias = bd_ejecutar_sql($consulta_estado_campanias);
while ($fila_estado_campanias = bd_obtener_fila($lista_estado_campanias)) {
    $estado_campanias[] = $fila_estado_campanias;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Estado Campaña</title>
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
                <div class="span1"></div>
                <div class="span11" id="content">
                    <div class="row-fluid">
                        <div class="row-fluid">
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left" align="center"></div>
                                </div>
                                <div class="block-content collapse in">

                                    <form class="form-horizontal" action="campania_editar_procesar.php" name="formcampania" method="POST">
                                        <div style="display:none"><input type="text" value="<?php echo $id; ?>" name="idcampania" size="1"></div>
                                        <fieldset>
                                            <legend >Estado de Campañas Activas</legend>
                                            <div class="well">  

                                                <table class="table table-striped table-bordered table-hover">
                                                    <tr>
                                                        <td><strong>No.</strong></td>
                                                        <td><strong>Campaña</strong></td>
                                                        <td><strong>Programa</strong></td>
                                                        <td><strong>Asesor</strong></td>
                                                        <td><strong>Fecha Inicio</strong></td>
                                                        <td><strong>Fecha Fin</strong></td>
                                                        <td><strong>Total</strong></td>
                                                        <td><strong>Gestionados</strong></td>        
                                                        <td><strong>Pendientes</strong></td>
                                                        <td><strong>Calificados</strong></td>
                                                        <td><strong>No Interesados</strong></td>
                                                        <td><strong>Otro Programa</strong></td>
                                                        <td><strong>Fallidas</strong></td>
                                                        <td><strong>% Avance</strong></td>
                                                    </tr>
                                                    <?php
                                                    if (!isset($estado_campanias)) {
                                                        echo 'NO exite registro alguno';
                                                    } else {
                                                        $i = 1;
                                                        foreach ($estado_campanias as $c) {
                                                            $ids = $c['idcampania'];
                                                            echo"
						<tr>
                                                <td><b>" . $i . "</b></td>
						<td>" . $c['campania'] . "</td>
                                                <td>" . $c['programa'] . "</td>
                                                <td>" . $c['nombre'] . "</td>
                                                <td>" . $c['fechainicio'] . "</td>
                                                <td>" . $c['fechafin'] . "</td>
                                                <td>" . $c['TOTAL'] . "</td>    
						<td>" . $c['ATENDIDO'] . "</td>
						<td>" . $c['PENDIENTE'] . "</td>
                                                <td>" . $c['CALIFICADO'] . "</td>
                                                <td>" . $c['NOINTERESADO'] . "</td>
                                                <td>" . $c['OTROPROGRAMA'] . "</td>
                                                <td>" . $c['FALLIDA'] . "</td>
						<td>" . $c['PROCENT'] . "</td>
						</tr>";
                                                            $i = $i + 1;
                                                        }
                                                    }
                                                    ?> 
                                                </table>
                                            </div>
                                            <div class="form-actions">
                                                <a href="campania_a_excel.php" class="btn btn-primary">Exportar a Excel</a>
                                                <button type="reset" class="btn" onclick="location.href = 'campania_lista.php'">Cancelar</button>
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
        <div class="ac">
            <?php
            include './pie.php';
            ?>
        </div>
        <script src="Admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="Admin/vendors/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="js/cronos.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
        <script src="Admin/assets/scripts.js"></script>
        <script>
                                                    function validar() {
                                                        if (document.getElementById('campania').value === '') {
                                                            alert('FALTA CAMPAÑA');
                                                        } else {
                                                            document.formcampania.submit();
                                                        }
                                                    }
        </script>
        <script>
            $(function () {
                $("#datepicker").datepicker({dateFormat: "yy-mm-dd"});
                $("#datepicker1").datepicker({dateFormat: "yy-mm-dd"});
            });
        </script>
    </body>
</html>