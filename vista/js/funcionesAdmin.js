$(function() {

    var TallerAvanzada = {};

    (function(app) {

        app.init = function() {
            app.verificarSesion();
        };
        app.bindings = function() {
            $("#cerrarSesion").on('click', function(event) {
                document.location.href="CerrarSesion.php";
                event.preventDefault();
            });
        };
        app.verificarSesion = function(){
            var url = "controlador/ruteador/Sesion.php"; 
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                success: function(datos) {
                    if (typeof datos['id_usuario'] != 'undefined') {
                        $("#logedUser").html(datos.usuario_usuario);
                        app.bindings();
                    }else{
                        location.href = "index.html";
                    }
                },
                error: function(data) {
                    location.href = "index.html";
                } 
            });  
        };
        app.init();

    })(TallerAvanzada);


});
