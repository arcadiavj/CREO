$(function() {

    var TallerAvanzada = {};
    var idUsuario="";

    (function(app) {

        app.init = function() {
            $("#reporDetalle").hide();
            app.verificarSesion();
        };
          
        app.bindings = function() {
            //cambios
            
            //fin cambios
            $("#agregar").on('click', function(event) {
                event.preventDefault();
                app.borrarCampos();
                $("#id_art").val(0);
                $("#mHeader").removeClass();
                $("#mHeader").attr("class","modal-header bg-primary");
                $("#tituloModal").html("Agregar ART");
                $("#modalArt").modal({show: true});
                $("#guardar").attr("value","Agregar");
                $("#guardar").html("Agregar");
                $("#nombre").removeAttr("disabled");//elimino la propiedad "disabled" que usé para VER
                $("#direccion").removeAttr("disabled");
                $("#detalle").removeAttr("disabled");
                $("#guardar").show();
                $("#reporDetalle").hide();
                app.activarControles();
                
            });
            $('#modalArt').on('shown.bs.modal', function () {
                $('#nombre').focus();
            });                

            $("#reporteArt").on('click', function(event) {
                event.preventDefault();
                window.open('../reportes/reporteArt.php?idUsuario='+idUsuario, '_blank'); //de esta forma abre en una nueva ventana o pestaña
                
            });

            $("#reporDetalle").on('click', function(event) {
                event.preventDefault();
                var idArt = $("#id_art").val();
                window.open('../reportes/reporteDetalleArt.php?id=' + idArt+'&idUsuario='+idUsuario , '_blank'); //de esta forma abre en una nueva ventana o pestaña
            });
            
            $("#cuerpoTablaArts").on('click', '.editar', function(event) {
                $("#id_art").val($(this).attr("data-id_art"));
                $("#mHeader").removeClass();
                $("#mHeader").attr("class","modal-header bg-success");
                $("#nombre").val($(this).parent().parent().children().first().next().html());
                $("#direccion").val($(this).parent().parent().children().first().next().next().html());
                $("#detalle").val($(this).parent().parent().children().first().next().next().next().html());
                $("#guardar").html("Modificar");
                $("#guardar").attr("value","Modificar");
                $("#tituloModal").html("Editar ART");
                $("#modalArt").modal({show: true});
                $("#guardar").show();
                $("#reporDetalle").hide();
                app.activarControles();
            });
            
            $("#cuerpoTablaArts").on('click', '.seleccionar', function(event) {

                $("#id_art").val($(this).attr("data-id_art"));
                $("#mHeader").removeClass();
                $("#mHeader").attr("class","modal-header bg-info");
                $("#nombre").val($(this).parent().parent().children().first().next().html());
                $("#direccion").val($(this).parent().parent().children().first().next().next().html());
                $("#detalle").val($(this).parent().parent().children().first().next().next().next().html());
                $("#guardar").hide();
                $("#reporDetalle").show();
                $("#tituloModal").html("Detalles ART");
                $("#modalArt").modal({show: true});
                app.desactivarControles();
            });
            
            $("#cuerpoTablaArts").on('click', '.eliminar', function() {
                var id = $(this).attr("data-id_art");
                bootbox.confirm({ 
                    size: 'medium',
                    message: "Se va a eliminar el registro seleccionado. ¿Está seguro?", 
                    callback: function(result){
                    if(result){
                        app.eliminarArt(id);
                    }
                    }
                });
 
            });
            
            $("#cancelar").on("click", function(event) {
                event.preventDefault();
                app.borrarCampos();
                $("#modalArt").modal('hide');
            });
            
            $("#equis").on("click", function(event) {
                event.preventDefault();
                app.borrarCampos();
                $("#modalArt").modal('hide');
            });

            $("#guardar").on("click", function(event) {
                event.preventDefault();
                app.validarCampos();
            });
            $("#formArt").bootstrapValidator({
                excluded: []
            });
        };
        app.validarCampos = function(){
            var nom = $("#nombre").val();
            var rta = "";
            if (nom == "") {
                rta += "Debes completar el Nombre";
                //bootbox.alert(rta);
                bootbox.alert(rta);
                $("#nombre").focus();
            }else{
                app.guardarArt();
            }
        };
        app.desactivarControles = function (){
            $("#nombre").attr("disabled", true);
            $("#direccion").attr("disabled", true);
            $("#detalle").attr("disabled", true);
        }; 
        app.activarControles = function (){
            $("#nombre").removeAttr("disabled");
            $("#direccion").removeAttr("disabled");
            $("#detalle").removeAttr("disabled");
        }; 
        app.borrarCampos = function (){
            $("#nombre").val("").html();
            $("#direccion").val("").html();
            $("#detalle").val("").html();
            $("#formArt").bootstrapValidator('resetForm', true);
        }; 
        
        app.guardarArt = function() {
            var url = "../../controlador/ruteador/Ruteador.php"; //tanto para modif como para agregar
            var data = $("#formArt").serialize();
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: data,
                success: function(datos) {
                    $("#modalArt").modal('hide');
                    app.actualizarDataTable(datos, $("#id_art").val());
                },
                error: function(data) {
                    alert(data);
                }
            });
        };
        app.eliminarArt= function(id) {

            var url = "../../controlador/ruteador/Ruteador.php?accion=eliminar&nombreFormulario=Art&id=" + id; 

            $.ajax({
                url: url,
                method: "GET",
                dataType: 'json',
                success: function(data) {
                    app.borrarFilaDataTable(id);
                },
                error: function(data) {
                    alert('error');
                }
            });

        };

        app.borrarFilaDataTable = function(id) {
            var fila = $("#cuerpoTablaArts").find("a[data-id_art='" + id + "']").parent().parent().remove();

        };
        
        app.buscarArts = function() {
            var url = "../../controlador/ruteador/Ruteador.php?accion=buscar&nombreFormulario=Art";
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    app.rellenarDataTable(data);
                },
                error: function() {
                    alert('error');
                }

            });
        };

        
        app.actualizarDataTable = function(art, id) {
            if (id == 0) { //si entra acá es porque es agregar
                var html = '<tr class="text-warning">' +
                        '<td><a class="center-block seleccionar" data-id_art="' + art.id_art + '"><button class="btn btn-info btn-sm">'+
                        '<span class="glyphicon glyphicon-eye-open left"> Info</span></button></a></td>' +
                        '<td>' + art.nombre_art + '</td>' +
                        '<td>' + art.direccion_art + '</td>';
                        if (art.detalle_art == null) {
                            html += '<td></td>';
                        }else{
                            html += '<td>' + art.detalle_art + '</td>';
                        }
                        html += '<td>' +
                        '<a class="pull-left editar" data-id_art="' + art.id_art + '"><button class="btn btn-success btn-sm">'+
                        '<span class="glyphicon glyphicon-pencil"> Editar</span></button></a>' +
                        '<a class="pull-right eliminar" data-id_art="' + art.id_art + '"><button class="btn btn-danger btn-sm">'+
                        '<span class="glyphicon glyphicon-remove"> Eliminar</span></button></a>' +
                        '</td>' +
                        '</tr>';
                $("#cuerpoTablaArts").append(html);
                
            } else {
                //busco la fila
                var fila = $("#cuerpoTablaArts").find("a[data-id_art='" + id + "']").parent().parent();
                var html = '<td>' + 
                        '<a class="center-block seleccionar" data-id_art="' + art.id_art + '"><button class="btn btn-info btn-sm">'+
                        '<span class="glyphicon glyphicon-eye-open left"> Info</span></button></a></td>' +
                        '<td>' + art.nombre_art + '</td>' +
                        '<td>' + art.direccion_art + '</td>';
                        if (art.detalle_art == null) {
                            html += '<td></td>';
                        }else{
                            html += '<td>' + art.detalle_art + '</td>';
                        }
                        html += '<td>' +
                        '<a class="pull-left editar" data-id_art="' + art.id_art + '"><button class="btn btn-success btn-sm">'+
                        '<span class="glyphicon glyphicon-pencil"> Editar</span></button></a>' +
                        '<a class="pull-right eliminar" data-id_art="' + art.id_art + '"><button class="btn btn-danger btn-sm">'+
                        '<span class="glyphicon glyphicon-remove"> Eliminar</span></button></a>' +
                        '</td>';
                fila.html(html);
            }
        };
        
        app.rellenarDataTable = function(data) {
            var html = "";

            $.each(data, function(clave, art) {
                html += '<tr class="text-warning">' +
                        '<td><a class="center-block seleccionar" data-id_art="' + art.id_art + '"><button class="btn btn-info btn-sm">'+
                        '<span class="glyphicon glyphicon-eye-open left"> Info</span></button></a></td>' +
                        '<td>' + art.nombre_art + '</td>' +
                        '<td>' + art.direccion_art + '</td>';
                        if (art.detalle_art == null) {
                            html += '<td></td>';
                        }else{
                            html += '<td>' + art.detalle_art + '</td>';
                        }
                        html += '<td>' +
                        '<a class="pull-left editar" data-id_art="' + art.id_art + '"><button class="btn btn-success btn-sm">'+
                        '<span class="glyphicon glyphicon-pencil"> Editar</span></button></a>' +
                        '<a class="pull-right eliminar" data-id_art="' + art.id_art + '"><button class="btn btn-danger btn-sm">'+
                        '<span class="glyphicon glyphicon-remove"> Eliminar</span></button></a>' +
                        '</td>' +
                        '</tr>';
            });
            $("#cuerpoTablaArts").html(html);
            $("#tablaArts").dataTable({       //transforma la tabla en dataTable
                responsive: true,
                "sPagiationType":"full_numbers", //activa la paginación con números
                "language":{ //cambia el lenguaje de la dataTable
                    "url":"../js/dataTable-es.json" //este es el archivo json del lenguaje español
                }
            });
        };
        app.verificarSesion = function(){
            var url = "../../controlador/ruteador/Sesion.php"; 
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                success: function(datos) {
                    if (typeof datos['id_usuario'] != 'undefined') {
                        $("#id_user").val(datos.id_usuario);
                        $("#logedUser").html(datos.usuario_usuario);
                        idUsuario=datos.id_usuario;
                        app.buscarArts();  
                        app.bindings();
                    }else{
                        location.href = "../../index.html";
                    }
                },
                error: function(data) {
                    location.href = "../../index.html";
                } 
            });  
        };
        app.init();

    })(TallerAvanzada);


});
