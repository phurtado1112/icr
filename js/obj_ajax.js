//////////////ENVIO DE VARIABLES PARA GUARDAR TIEMPOS EN CAMBIO DE ESTADO//////////////////////////////////
function ajxSAVETIME(estado,time)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState===4 && xmlhttp.status===200)
    {
    document.getElementById("divhora").innerHTML=xmlhttp.responseText;
    }
  };
xmlhttp.open("POST","salvar_estado.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send('ajxtime='+time+'&ajxestado='+estado);
}

//////////////ENVIO DE VARIABLES PARA GUARDAR INFORMACION CLIENTES AGENDADOS////////////////////
function load_agendados(cliente,finales,observacion,usuario,sub_finales,agendar)
{
var xmlhttp;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState===4 && xmlhttp.status===200)
    {
    document.getElementById("DIVcliente").innerHTML=xmlhttp.responseText;
    }
  };
xmlhttp.open("POST","cliente_agendado_procesar.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
//xmlhttp.send();
//xmlhttp.send("q="+user);
//xmlhttp.send("q= " + user + "&Date1 = " + D1);
xmlhttp.send('ajxcliente='+cliente+'&ajxfinales='+finales+'&ajxobservacion='+observacion+'&ajxuser='+usuario+'&ajxsubfinal='+sub_finales+'&ajxagendar='+agendar);
}

//////////////ENVIO DE VARIABLES PARA GUARDAR INFORMACION CLIENTE AGENDADOS PREVIAMENTE/////////
function load(cliente,finales,observacion,usuario,sub_finales,agendar)
{
var xmlhttp;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState===4 && xmlhttp.status===200)
    {
    document.getElementById("DIVcliente").innerHTML=xmlhttp.responseText;
    }
  };
xmlhttp.open("POST","cliente_procesar.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send('ajxcliente='+cliente+'&jaxfinales='+finales+'&ajxobservacion='+observacion+'&ajxuser='+usuario+'&ajxsubfinal='+sub_finales+'&ajxsagendar='+agendar);
}

//////////////////////ENVIO DE INFORMACION PARA REALILZAR BUSQUEDAS DE ¿¿??/////////////////
function searchdataAtendidos(cadena,opcion)
{
var xmlhttp;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState===4 && xmlhttp.status===200)
    {
    document.getElementById("resul_search").innerHTML=xmlhttp.responseText;
    }
  };
xmlhttp.open("POST","resulta_searchAtendidos.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
//xmlhttp.send();
//xmlhttp.send("ajxcadena="+cadena);
xmlhttp.send("ajxcadena="+cadena+"&ajxopcion="+opcion);
}

//////////////////////ENVIO DE INFORMACION PARA REALILZAR BUSQUEDAS DE CONTACTOS/////////////////
function searchdata(cadena,opcion)
{
var xmlhttp;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState===4 && xmlhttp.status===200)
    {
    document.getElementById("resul_search").innerHTML=xmlhttp.responseText;
    }
  };
xmlhttp.open("POST","contactos_busqueda.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
//xmlhttp.send();
//xmlhttp.send("ajxcadena="+cadena);
xmlhttp.send("ajxcadena="+cadena+"&ajxopcion="+opcion);
}

//////////////////////ENVIO DE INFORMACION PARA TIPIFICAR////////////////////////////////////////////
function tipificacion(str)
{
var xmlhttp;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState===4 && xmlhttp.status===200)
    {
       document.getElementById("Divtipnoionteresado").innerHTML=xmlhttp.responseText;
    }
  };
xmlhttp.open("POST","nointeresado.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+str);
}