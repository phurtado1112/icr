<!DOCTYPE html>
<!--
Este software es propiedad de DUQCISA y fue desarrollado por Pablo Hurtado
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Prueba</title>
        <script src="js/jquery-1.7.2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('input[type=radio]').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('div.selector').eq($('input[type=radio]').index(this)).show();
                    } else {
                        $('div.selector').eq($('input[type=radio]').index(this)).hide();
                    }
                }).change();
            });
        </script>
    </head>
    <body>
        <div>
            <form>
                <input id="id_radio1" type="radio" name="name_radio" value="value_radio1" checked="checked"/>Radio1
                <input id="id_radio2" type="radio" name="name_radio" value="value_radio2" />Radio2
                <input id="id_radio3" type="radio" name="name_radio" value="value_radio3" />Radio3
                <input id="id_radio4" type="radio" name="name_radio" value="value_radio4" />Radio4
                <input id="id_radio5" type="radio" name="name_radio" value="value_radio5" />Radio5
            </form>
        </div>
        <div>
            <div id="div1" style="display: none">One</div>
            <div id="div2" style="display: none">Two</div>
            <div id="div3" style="display: none">Three</div>
            <div id="div4" style="display: none">Four</div>
            <div id="div5" style="display: none">Five</div>
        </div>
    </body>
</html>




