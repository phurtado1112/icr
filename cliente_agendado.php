<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "index.php"
</script>';
}

$idclient = filter_input(INPUT_GET, 'idclient');
$consulta_ctes = "SELECT * FROM transacciones_view WHERE idcliente=" . $idclient;
$lista_clientes = bd_ejecutar_sql($consulta_ctes);
while ($filax = bd_obtener_fila($lista_clientes)) {
    $contactosx[] = $filax;
}

$idcampania = $_SESSION['idcampania'];

$consulta_cte = "SELECT * FROM clientes WHERE idcampania='" . $idcampania . "'AND idcliente=" . $idclient;

$lista_clien = bd_ejecutar_sql($consulta_cte);
while ($filas = bd_obtener_fila($lista_clien)) {
    $idcliente = $filas['idcliente'];
    $nombre = $filas['nombre'];
    $telfijo = $filas['telfijo'];
    $email = $filas['email'];
    $celular = $filas['telmovil'];
    $telofi = $filas['teltrabajo'];
    $cargo = $filas['cargo'];
    $empresa = $filas['empresa'];
}

$atendido = "SELECT count(*) as conteo FROM clientes WHERE idcampania='" . $idcampania . "'AND idestado='1'";
$lista_atendidos = bd_ejecutar_sql($atendido);
while ($filaat = bd_obtener_fila($lista_atendidos)) {
    $var_atendido = $filaat['conteo'];
}

$noatendido = "SELECT count(*) as conteo FROM clientes WHERE idcampania='" . $idcampania . "'AND idestado='0'";
$lista_noatendidos = bd_ejecutar_sql($noatendido);
while ($filanoat = bd_obtener_fila($lista_noatendidos)) {
    $var_no_atendido = $filanoat['conteo'];
}

$consulta_camp = "SELECT * FROM campanias where idcampania=" . $_SESSION['idcampania'];
$lista_campania = bd_ejecutar_sql($consulta_camp);
while ($filacam = bd_obtener_fila($lista_campania)) {
    $var_camp_nombre = $filacam['campania'];
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>INCAE</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet">  
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link rel="stylesheet" href="css/jquery-ui.css" />
        <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    </head>
    <body>
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
                        <tr bgcolor="#00CC66">
                            <td><strong>Cliente:</strong></td>
                            <td><strong>Teléfono:</strong></td>
                            <td><strong>Email:</strong></td>
                            <td><strong>Celular:</strong></td>
                            <td><strong>Teléfono Oficina:</strong></td>
                            <td><strong>Cargo:</strong> </td>
                            <td><strong>Empresa:</strong> </td>
                        </tr>
                        <tr>
                            <td><?php echo $nombre ?></td>
                            <td><?php echo $telfijo ?></td>
                            <td><?php echo $email ?></td>
                            <td><?php echo $celular ?></td>
                            <td><?php echo $telofi ?></td>
                            <td><?php echo $cargo ?></td>
                            <td><?php echo $empresa ?></td>
                        </tr>
                    </table> 
                    <p>&nbsp;</p>
                    <p>
                        Tipificacion:
                        <?php
                        $consulta_tipos = "select * from tipificacion";
                        $lista_tipos = bd_ejecutar_sql($consulta_tipos);
                        ?>
                        <select name="finales" id="finales" onChange="tipificacion(this.value)" >
                            <option value="0">Seleccione...</option>
                            <?php
                            while ($fila = bd_obtener_fila($lista_tipos)) {
                                ?>
                                <option  id="tipicacion" value="<?php echo $fila['idtipificacion']; ?>"><?php echo $fila['tipificacion']; ?></option>
                            <?php } ?>	    
                        </select>
                    </p>
  
                    <div id="Divtipnoionteresado"></div> 

                    <p>
                        Agendar
                        <input type="text" id="datepicker" value="0000-00-00" />
                        <br>
                        <textarea name="observacion" id="OBSERVACION" style="width: 817px; height: 141px;"></textarea>
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
                            echo '<table><tr><th><h1><center>Historial en Cero</center></h1><th><tr><table>';
                        } else {
                            echo '<h3><center>Historial de contacto</center></h3>';
                            foreach ($contactosx as $c) {
                                echo"
						<tr>
						<td>" . $c['fecha'] . "</td>
						<td>" . $c['hora'] . "</td>
						<td>" . $c['tipificacion'] . "</td>
						<td>" . $c['observaciones'] . "</td>																														
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
                        load_agendados(cliente, finales, observacion, usuario, sub_finales, agendar);
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
