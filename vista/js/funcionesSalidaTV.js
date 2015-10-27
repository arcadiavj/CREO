$(function () {

    var TallerAvanzada = {};

    (function (app) {

        app.init = function () {
            var fch_llegada=null;
            app.refrescar(fch_llegada);
        };
        app.refrescar = function (fch_llegada) {
            $.ajax({
            async:	true, 
            type: "POST",
            url: "../../controlador/ruteador/Ruteador.php?nombreFormulario=SalidaTV&accion=actualizar",
            
                data: "&fch_llegada_turno="+fch_llegada,
                dataType:"json",
            success: function(data)
                {	
                    var pepe={};
                    $.each(data, function(clave, turno) {
                        pepe['id_turno']= turno.id_turno;
                        pepe['id_consulto'] = turno.id_consultorio;
                        pepe['historia_clinica_turno'] = turno.historia_clinica_turno;
                        alert(data.historia_clinica_turno);
                    });
                    alert(data.historia_clinica_turno);

//                        var turno    	   = eval("(" + data + ")");
//                        id_usuario     	   = turno.id_usuario;
//                        id_consultorio        		   = turno.id_consultorio;
//                        historia_clinica_turno      	   = turno.historia_clinica_turno;
//                        fch_llegada_turno        		   = turno.fch_llegada_turno;

                        if(pepe['historia_clinica_turno'] != null)
                        {
                                $.ajax({
                                async:	true, 
                                type: "POST",
                                url: "../../controlador/ruteador/mensajes.php",
                                data: "",
                                dataType:"json",
                                success: function(data2)
                                {
                                    $.each(data2, function(clave, turno) {
                                        $('#div1').html(data2.id_consultorio + ' ' + data2.historia_clinica_turno);
                                    });   
                                }
                                });	
                        }
                        //alert('pepito');
                        //setTimeout(app.refrescar(data.fch_llegada_turno),10000000);

            },
            error: function(data) {
                alert('error en el ajax');
            } 
            
                });
        };
        app.init();

    })(TallerAvanzada);


});


