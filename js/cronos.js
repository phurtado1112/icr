// JavaScript Document
function estado() {
    document.getElementById("divbtn").style.display = 'block';
    document.getElementById("idestados").disabled = 'true';

    var estado = document.getElementById("idestados").value;
    if (estado === '0') {
        clearInterval(cronometro);
        document.getElementById("divhora").innerHTML = '0:0:00';
    } else {
        clearInterval(cronometro);
        document.getElementById("divhora").innerHTML = '0:0:00';
        carga();
    }
}

var cronometro;

function carga() {
    contador_s = 0;
    contador_m = 0;
    contador_h = 0;
//    var startTime = new Date();
//    var start = startTime.getSeconds();
    divh = document.getElementById("divhora");

    cronometro = setInterval(
            function() {
                if (contador_s === 60) {
                    contador_s = 0;
                    contador_m++;
                    if (contador_m < 60) {
                    } else {
                        contador_m = 0;
                        contador_h++;
                    }
                }
                
                contador_s++;

                if (contador_s < 10) {
                    divh.innerHTML = contador_h + ':' + contador_m + ':0' + contador_s;
                } else {
                    if (contador_m < 10) {
                        divh.innerHTML = contador_h + ':0' + contador_m + ':' + contador_s;
                    } else {
                        if (contador_h < 10) {
                            divh.innerHTML = '0' + contador_h + ':' + contador_m + ':' + contador_s;
                        } else {
                            divh.innerHTML = contador_h + ':' + contador_m + ':' + contador_s;
                        }
                    }
                }
            }
    , 1000);
}

function saveajx() {
    clearInterval(cronometro);
    stateactive = document.getElementById("idestados").value;
    time = document.getElementById("divhora").innerHTML;
    ajxSAVETIME(stateactive, time);
    setInterval("self.location = 'cliente_contacto.php'", 1000);
}	