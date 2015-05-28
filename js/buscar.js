function porclick() {
    var_numero = document.getElementById('cadena').value;
    var_opcion = document.getElementById('idopcion').value;
    searchagendados(var_numero, var_opcion);
}

function getsearch(even) {
    var keyPressed = (even.which) ? even.which : even.keyCode;
    if (keyPressed === 13) {
        var_numero = document.getElementById('cadena').value;
        var_opcion = document.getElementById('idopcion').value;
        searchagendados(var_numero, var_opcion);
    }
}

