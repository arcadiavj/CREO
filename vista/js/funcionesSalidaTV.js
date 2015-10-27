$(function () {

    var TallerAvanzada = {};

    (function (app) {

        app.init = function () {
            app.refrescar();
        };
        app.refrescar = function () {
            $.ajax({
                url: "../../controlador/ruteador/Ruteador.php?nombreFormulario=SalidaTV&accion=actualizar", 
                method: "POST",
                dataType: 'json',
                success: function (data)
                {
                    $.ajax({
                        url: "../../controlador/ruteador/mensajes.php",
                        method: "POST",
                        dataType: 'json',
                        success: function (data2)
                        {
                           $("#div1").html(data2.historia_clinica_turno); 
                        }
                    });
                    setTimeout(app.refrescar(), 10000000);
                }
            });
        };
        app.init();

    })(TallerAvanzada);


});


