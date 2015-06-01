<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_estado_campanias = "select * from estado_campania_view where terminada='n' and tipo=1 and activo=0 and ultimo=1 order by idusuario,idprograma,idcampania";

$lista_estado_campanias = bd_ejecutar_sql($consulta_estado_campanias);
while ($fila_estado_campanias = bd_obtener_fila($lista_estado_campanias)) {
    $estado_campanias[] = $fila_estado_campanias;
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Estado Campañas Seminarios</title>
        <link href="css/fio.css" rel="stylesheet" type="text/css">
        <link href="css/bs.css" rel="stylesheet" type="text/css">
        <link href="css/jquery-ui.css" rel="stylesheet">
        <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet">
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
                <div class="span12"></div>
                <div class="span12" id="content">
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
                                            <legend>  Estado de Campañas Seminarios Activas</legend>
                                            <div class="well">  

                                                <table class="table table-striped table-bordered table-hover">
                                                    <tr>
                                                        <td id='alinea_vertical_centrado'><strong>No.</strong></td>
                                                        <td id='alinea_vertical'><strong>Asesor</strong></td>
                                                        <td id='alinea_vertical'><strong>Programa</strong></td>
                                                        <td id='alinea_vertical'><strong>Campaña</strong></td>                                                  
                                                        <td id='alinea_vertical_centrado'><strong>Fecha Inicio</strong></td>
                                                        <td id='alinea_vertical_centrado'><strong>Fecha Fin</strong></td>
                                                        <td id='alinea_vertical_centrado'><strong>Total</strong></td>
                                                        <td id='alinea_vertical_centrado'><strong>Gestionados</strong></td>        
                                                        <td id='alinea_vertical_centrado'><strong>Pendientes</strong></td>
                                                        <td id='alinea_vertical_centrado'><strong>Calificados</strong></td>
                                                        <td id='alinea_vertical_centrado'><strong>No Interesados</strong></td>
                                                        <td id='alinea_vertical_centrado'><strong>Otro Programa</strong></td>
                                                        <td id='alinea_vertical_centrado'><strong>Fallidas</strong></td>
                                                        <td id='alinea_vertical_centrado'><strong>Otras</strong></td>
                                                        <td id='alinea_vertical_centrado'><strong>% Avance</strong></td>
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
                                                <td id='alinea_vertical_centrado'><b>" . $i . "</b></td>
                                                <td id='alinea_vertical'>" . $c['nombre'] . "</td>
                                                <td id='alinea_vertical'>" . $c['programa'] . "</td>
						<td id='alinea_vertical'>" . $c['campania'] . "</td>
                                                <td id='alinea_vertical_centrado'>" . $c['fechainicio'] . "</td>
                                                <td id='alinea_vertical_centrado'>" . $c['fechafin'] . "</td>
                                                <td id='alinea_vertical_centrado'><b>" . $c['TOTAL'] . "</b></td>    
						<td id='alinea_vertical_centrado'>" . $c['ATENDIDO'] . "</td>
						<td id='alinea_vertical_centrado'>" . $c['PENDIENTE'] . "</td>
                                                <td id='alinea_vertical_centrado'>" . $c['CALIFICADO'] . "</td>
                                                <td id='alinea_vertical_centrado'>" . $c['NOINTERESADO'] . "</td>
                                                <td id='alinea_vertical_centrado'>" . $c['OTROPROGRAMA'] . "</td>
                                                <td id='alinea_vertical_centrado'>" . $c['FALLIDA'] . "</td>
                                                <td id='alinea_vertical_centrado'>" . $c['Otras'] . "</td>
						<td id='alinea_derecha'><b>" . number_format($c['PROCENT'],2) . "</b></td>
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
        <!--<script type="text/javascript" src="js/cronos.js"></script>-->
        <script src="js/jquery-ui.js"></script>
        <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
        <!--<script src="Admin/assets/scripts.js"></script>-->
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