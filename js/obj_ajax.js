/* **** ENVIO DE VARIABLES PARA GUARDAR TIEMPOS EN CAMBIO DE ESTADO **** */

function ajxSAVETIME(estado, time) {
    var xmlhttp;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("divhora").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("POST", "salvar_estado.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send('ajxtime=' + time + '&ajxestado=' + estado);
}

/* **** ENVIO DE INFORMACION PARA TIPIFICAR **** */

function tipificacion(str) {
    var xmlhttp;

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("Divtiponointeresado").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("POST", "nointeresado.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("q=" + str);
}

/* **** ENVIO DE VARIABLES PARA GUARDAR INFORMACION CONTACTO AGENDADO **** */

function load_agendado(cliente, finales, observacion, usuario, sub_finales, agendar, actual, proceso) {
    var xmlhttp;

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("DIVcliente").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("POST", "contacto_agendado_procesar.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send('ajxcliente=' + cliente + '&ajxfinales=' + finales + '&ajxobservacion=' + observacion + '&ajxuser='
            + usuario + '&ajxsubfinal=' + sub_finales + '&ajxagendar=' + agendar + '&ajxactual=' + actual
            + '&ajxproceso=' + proceso);
}

/* **** ENVIO DE VARIABLES PARA GUARDAR INFORMACION CONTACTO NUEVO **** */

function load_nuevo(cliente, finales, observacion, usuario, sub_finales, agendar, actual, proceso) {
    var xmlhttp;

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("DIVcliente").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("POST", "contacto_nuevo_procesar.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send('ajxcliente=' + cliente + '&ajxfinales=' + finales + '&ajxobservacion=' + observacion + '&ajxuser='
            + usuario + '&ajxsubfinal=' + sub_finales + '&ajxsagendar=' + agendar + '&ajxactual=' + actual
            + '&ajxproceso=' + proceso);
}

/* **** ENVIO DE VARIABLES PARA GUARDAR INFORMACION CONTACTO ATENDIDO **** */

function load_atendido(cliente, finales, observacion, usuario, sub_finales, agendar, actual, proceso) {
    var xmlhttp;

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("DIVcliente").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("POST", "contacto_atendido_procesar.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send('ajxcliente=' + cliente + '&ajxfinales=' + finales + '&ajxobservacion=' + observacion + '&ajxuser='
            + usuario + '&ajxsubfinal=' + sub_finales + '&ajxsagendar=' + agendar + '&ajxactual=' + actual
            + '&ajxproceso=' + proceso);
}

/* **** ENVIO DE INFORMACION PARA REALILZAR BUSQUEDAS DE CONTACTOS AGENDADOS **** */

function searchagendados(cadena, opcion) {
    var xmlhttp;

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("resul_search").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("POST", "cliente_contacto_agendado_busqueda.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("ajxcadena=" + cadena + "&ajxopcion=" + opcion);
}

/* **** ENVIO DE INFORMACION PARA REALILZAR BUSQUEDAS DE CONTACTOS ATENDIDOS **** */

function searchdataAtendidos(cadena, opcion) {
    var xmlhttp;

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("resul_search").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("POST", "cliente_atendido_busqueda.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("ajxcadena=" + cadena + "&ajxopcion=" + opcion);
}

/* **** ENVIO DE INFORMACION PARA REALILZAR BUSQUEDAS DE CONTACTOS NUEVOS **** */

function searchdata(cadena, opcion) {
    var xmlhttp;

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("resul_search").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("POST", "cliente_contacto_busqueda.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("ajxcadena=" + cadena + "&ajxopcion=" + opcion);
}

/* **** ENVIO DE INFORMACION PARA REALILZAR BUSQUEDAS DE CONTACTOS AGENDADOS TODOS **** */

function buscaragendadostodos(cadena, opcion) {
    var xmlhttp;

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("resul_search").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("POST", "contacto_agendado_todos_busqueda.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("ajxcadena=" + cadena + "&ajxopcion=" + opcion);
}