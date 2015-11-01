$(function () {

    var TallerAvanzada = {};

    (function (app) {

        app.init = function () {
            var fch_llegada=null;
            app.refrescar();
        };
        app.refrescar = function () {
            $.ajax({
            async: true,
            url: "../../controlador/ruteador/ruteador.php?nombreFormulario=SalidaTV&accion=actualizar",
            type: 'POST',
            dataType: 'json',
            //data: "&fch_llegada_turno="+fch_llegada,  
            success: function(data)
                {	
                    var rta = "";
                    var pepe=[];
                    $.each(data, function(clave, turno) {
                        pepe.id_turno = turno.id_turno;
                        pepe.id_usuario = turno.id_usuario;
                        pepe.id_consultorio = turno.id_consultorio;
                        pepe.historia_clinica_turno = turno.historia_clinica_turno;
                        pepe.fch_llegada_turno = turno.fch_llegada_turno;
                        rta += turno.fch_llegada_turno + '<br>';
                    });
                    $('#div1').html(rta);
                    setTimeout(app.refrescar(),1000000);
            },
            error: function(data) {
                alert('error en el primer ajax');
            } 
            
                });
        };
        app.init();

    })(TallerAvanzada);


});


