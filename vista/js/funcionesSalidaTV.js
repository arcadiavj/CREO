$(function () {

    var TallerAvanzada = {};

    (function (app) {

        app.init = function () {
            var fch_llegada=null;
            app.refrescar(fch_llegada);
        };
        app.refrescar = function (fch_llegada) {
            $.ajax({
            async: true,
            url: "../../controlador/ruteador/ruteador.php?nombreFormulario=SalidaTV&accion=actualizar",
            type: 'POST',
            dataType: 'json',
            data: "&fch_llegada_turno="+fch_llegada,  
            success: function(data)
                {	
                    var pepe=[];
                    $.each(data, function(clave, turno) {
                        pepe.id_turno = turno.id_turno;
                        pepe.id_usuario = turno.id_usuario;
                        pepe.id_consultorio = turno.id_consultorio;
                        pepe.historia_clinica_turno = turno.historia_clinica_turno;
                        pepe.fch_llegada_turno = turno.fch_llegada_turno;
                    });
//                    alert('fecha llegada: ' + pepe.fch_llegada_turno + '\nidTurno: ' + pepe.id_turno +
//                            '\nidConsultorio: ' + pepe.id_consultorio + '\nidUsuario: ' + pepe.id_usuario +
//                            '\nhistoriaClinica: ' + pepe.historia_clinica_turno);
                            

                        if(pepe.fch_llegada_turno != null)
                        {
                            var pepe2 = "";
                            $.ajax({
                            async:	true, 
                            type: "POST",
                            url: "../../controlador/ruteador/mensajes.php",
                            //data: "",
                            dataType:"json",
                            success: function(data2)
                            {
                                pepe2 = "";
                                //$('#div1').append(data2.id_consultorio + ' - ' + data2.historia_clinica_turno);
                                $.each(data2, function(clave, turno2) {
                                    pepe2 += turno2.fch_llegada_turno + '<br>';
                                }); 
                                $('#div1').html(pepe2);
                            },
                            error: function(){
                                alert('error en el segundo ajax');
                            }
                            });	
                        }

                        setTimeout(app.refrescar(pepe2),1000000);

            },
            error: function(data) {
                alert('error en el primer ajax');
            } 
            
                });
        };
        app.init();

    })(TallerAvanzada);


});


