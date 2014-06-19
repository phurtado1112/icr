<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "index.php"
</script>';
}
$idclien = filter_input(INPUT_GET, 'idclient');

$consulta_cliente = "SELECT * FROM transacciones_view WHERE idcliente='" . $idclien . "'";
$lista_cliente = bd_ejecutar_sql($consulta_cliente);
while ($filax = bd_obtener_fila($lista_cliente)) {
    $contactosx[] = $filax;
}

$idcampania = $_SESSION['idcampania'];

$consulta_clientes = "SELECT * FROM clientes WHERE idcampania='" . $idcampania . "'AND idcliente='" . $idclien . "' ";
$lista_clientes = bd_ejecutar_sql($consulta_clientes);
$fila = bd_obtener_fila($lista_clientes);
$idcliente = $fila['idcliente'];
$name = $fila['nombre'];
$Phone = $fila['telfijo'];
$Email = $fila['email'];
$Mobile = $fila['telmovil'];
$Work_Phone = $fila['teltrabajo'];
$Current_Employer_Title = $fila['cargo'];
$Current_Employer = $fila['empresa'];

$atendido = "SELECT count(*) as conteo FROM clientes WHERE idcampania='" . $idcampania . "'AND idestado='1'";
$lista_antendido = bd_ejecutar_sql($atendido);
$filaa = bd_obtener_fila($lista_antendido);
$var_atendido = $filaa['conteo'];

$noatendido = "SELECT count(*) as conteo1 FROM clientes WHERE idcampania='" . $idcampania . "'";
$lista_noatendidos = bd_ejecutar_sql($noatendido);
$filana = bd_obtener_fila($lista_noatendidos);
$var_no_atendido = $filana['conteo1'];

$consulta_campania = "SELECT * FROM campanias where idcampania=" . $_SESSION['idcampania'];
$lista_campanias = bd_ejecutar_sql($consulta_campania);
$filacamp = bd_obtener_fila($lista_campanias);
$var_camp_nombre = $filacamp['campania'];
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <title>INCAE</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="css/jquery-ui.css" rel="stylesheet" property="">
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
                            <li class="active"><a href="contactos.php">Contactos</a></li>
                            <li><a href="cliente_atendido.php">Atendidos</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div align="center"></div>    

        <div align="center" id="DIVcliente">
            <form action="cliente_procesar.php" method="post" name="Frmcliente">
                <fieldset>
                    <legend>Clientes atendidos: <?php echo $var_atendido ?> de <?php echo $var_no_atendido ?></legend>             
                    <div style="display:none">
                        <input type="text" id="idusuario" size="1" value="<?php echo $_SESSION['idusuario'] ?>"/>
                        <input type="text" name="idcliente" id="idcliente" size="1" value="<?php echo $idcliente ?>"  />                
                    </div>
                    <table width="1200">
                        <tr bgcolor="#0044cc">
                            <td><strong>Nombre:</strong></td> 
                            <td><strong>Telefono:</strong></td>
                            <td><strong>Email:</strong></td>
                            <td><strong>Celular:</strong></td>
                            <td><strong>Teléfono trabajo:</strong></td>
                            <td><strong>Puesto:</strong> </td>
                            <td><strong>Empresa:</strong> </td>
                        </tr>
                        <tr>
                            <td><?php echo $name ?></td>
                            <td><?php echo $Phone ?></td>
                            <td><?php echo $Email ?></td>
                            <td><?php echo $Mobile ?></td>
                            <td><?php echo $Work_Phone ?></td>
                            <td><?php echo $Current_Employer_Title ?></td>
                            <td><?php echo $Current_Employer ?></td>
                        </tr>
                    </table>
                    <p>&nbsp;</p>                    
                    <p>
                        Tipificacion:
                        <?php
                        $consulta_tipi = "select * from tipificacion";
                        $lista_tipi = bd_ejecutar_sql($consulta_tipi);
                        ?>
                        <select name="finales" id="finales" onChange="tipificacion(this.value)" >
                            <option value="0">Seleccione...</option>
                            <?php
                            while ($fila = bd_obtener_fila($lista_tipi)) {
                                ?>
                                <option  id="tipicacion" value="<?php echo $fila['idtipificacion']; ?>"><?php echo $fila['tipificacion']; ?></option>
                            <?php } ?>	    
                        </select>
                    </p>
                    <div id="Divtipnoionteresado"></div> 

                    <p>
                        Agendar
                        <input type="text" id="datepicker" value="0000-00-00"/>
                        <br>
                        <textarea name="observacion" id="OBSERVACION" style="width: 817px; height: 141px;" ></textarea>
                        <br>       
                        <input type="button" value="Guardar" onClick="SAVE()" class="btn btn-success" />
                    </p>
                    <p>&nbsp; </p>
                    <table class="table table-hover">
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>                    
                            <th>Tipificacion</th>                    
                            <th>Observacion</th>                                        
                        </tr>
                        <?php
                        if (!isset($contactosx)) {
                            echo '<table><tr><th><h1><center>Historial en Cero</center></h1></th></tr></table>';
                        } else {
                            echo '<h3><center>Historial de contacto</center></h3>';
                            foreach ($contactosx as $c) {
                                echo"
						<tr>
						<td>" . $c['fecha'] . "</td>
						<td>" . $c['hora'] . "</td>
						<td>" . ($c['tipificacion']) . "</td>																														
						<td>" . ($c['observaciones']) . "</td>																														
						</tr>";
                            }
                        }
                        ?>
                    </table>
                </fieldset>
            </form>
        </div>
        <hr>
        <footer> </footer>
        <script src="js/obj_ajax.js"></script>
        <script>
            function getsearch(evt) {
                var keyPressed = (evt.which) ? evt.which : event.keyCode;
                if (keyPressed === 13) {
                    var_numero = document.getElementById('cadena').value;
                    searchdata(var_numero);
                }
            }

            function SAVE() {
                if (document.getElementById('OBSERVACION').value === '' && document.getElementById('finales').value === '5') {
                    alert('ALERTA!.Falta la Observacion');
                } else {
                    if (document.getElementById('finales').value === '0') {
                        alert('ALERTA!.Falta la finales');
                    } else {

                        cliente = document.getElementById('idcliente').value;
                        finales = document.getElementById('finales').value;
                        observacion = document.getElementById('OBSERVACION').value;
                        usuario = document.getElementById('idusuario').value;
                        sub_finales = document.getElementById('subfinales').value;
                        agendar = document.getElementById('datepicker').value;
                        load(cliente, finales, observacion, usuario, sub_finales, agendar);
                    }
                }
            }
        </script>
        <script type="text/javascript" src="js/cronos.js"></script>        
        <script src="js/jquery-2.1.0.min.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script>
            $(function() {
                $("#datepicker").datepicker({ dateFormat: "yy-mm-dd" });
            });
        </script>
    </body>
</html>
