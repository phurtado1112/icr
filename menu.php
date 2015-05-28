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
                <ul class="nav">
                    <li><a href="noticias.php">Noticias</a></li>
                    <li><a href="cambio_estado.php">Estado</a></li>
                    <li><a href="cliente_nuevo.php">Nuevo Contacto</a></li>
                    <li class="active"><a href="cliente_contacto_agendado.php">Agendados</a></li>
                    <li><a href="cliente_contacto.php">Contactos</a></li>
                    <li><a href="cliente_atendido.php">Atendidos</a></li>
                    <li>
                        <form class="navbar-form navbar-left" role="search">
                                <input type="text" class="form-control" id="cadena" onKeyPress="getsearch(event)" placeholder="buscar">
                                <select id="idopcion" class="form-control">
                                    <option value="2">Nombre de contacto</option>
                                    <option value="3">Cargo</option>
                                    <option value="4">Empresa</option>
                                    <option value="5">Correo</option>
                                    <option value="6">País</option>  
                                </select>
                            <button type="submit" class="btn" onClick="porclick()">Buscar</button>
                        </form>
                    </li>
                    <li><a></a></li>
                    <li><a></a></li>
                    <li><a></a></li>
                    <li><a></a></li>
                    <li><a></a></li>
                    <li><a href="salir.php">Salir</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
