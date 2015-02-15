<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$idcampania = $_SESSION['idcampania'];
$idasignar = $_SESSION['idasignar'];

$opcion = filter_input(INPUT_POST, 'ajxopcion');
$cadena = filter_input(INPUT_POST, 'ajxcadena');

error_reporting(0);

if (isset($opcion)) {
    switch ($opcion) {
        case 0:
            $busqueda = "SELECT * FROM transacciones_view WHERE idasignar=" . $idasignar;
            break;
        case 2:
            $busqueda = "SELECT * FROM transacciones_view WHERE nombre LIKE '%" . $cadena . "%' and idasignar=" . $idasignar;
            break;
        case 3:
            $busqueda = "SELECT * FROM transacciones_view WHERE cargo LIKE '%" . $cadena . "%' and idasignar=" . $idasignar;
            break;
        case 4:
            $busqueda = "SELECT * FROM transacciones_view WHERE empresa LIKE '%" . $cadena . "%' and idasignar=" . $idasignar;
            break;
        case 5:
            $busqueda = "SELECT * FROM transacciones_view WHERE email LIKE '%" . $cadena . "%' and idasignar=" . $idasignar;
            break;
    }

    $lista_contactos_atendidos = bd_ejecutar_sql($busqueda);
    while ($fila = bd_obtener_fila($lista_contactos_atendidos)) {
        $contactos[] = $fila;
    }
}
?>
<center>
    <table class="table table-hover">
        <?php
        if (!isset($contactos)) {
            echo '<table><tr><th><h3><center>Sin resultado</center></h3><th><tr><table>';
        } else {
            ?>
            <tr>
                <th>Nombre</th>
                <th>Cargo</th>
                <th>Empresa</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>hora</th>
                <th>fecha</th>                    
                <th>Final</th>                    
                <th>Observación</th>                    
                <th>Acción</th>                                                            
            </tr>                                                              
            <?php
            foreach ($contactos as $c) {

                $ids = $c['idcliente'];
                echo"
                    <tr>
                    <td>" . $c['nombre'] . "</h1></td>
                    <td>" . $c['cargo'] . "</h1></td>
                    <td>" . $c['empresa'] . "</h1></td>
                    <td>" . $c['email'] . "</h1></td>
                    <td>" . $c['telfijo'] . "</td>
                    <td>" . $c['hora'] . "</td>
                    <td>" . $c['fecha'] . "</td>
                    <td>" . $c['tipificacion'] . "</td>																														
                    <td>" . $c['observaciones'] . "</td>																																				
                    <td>" . '<a href="cliente.php?idcliente=' . $ids . '">Gestionar</a>' . "</td>						
                    </tr>";
            }
        }
        ?>
    </table>    
</center>

