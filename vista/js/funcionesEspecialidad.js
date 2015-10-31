$(function() {

    var FAEspecialidad = {};
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
                $("#id_especialidad").val(0);
                $("#mHeader").removeClass();
                $("#mHeader").attr("class","modal-header bg-primary");
                $("#tituloModal").html("Agregar Especialidad");
                $("#modalEspecialidad").modal({show: true});
                $("#guardar").attr("value","Agregar");
                $("#guardar").html("Agregar");
                $("#descripcion").removeAttr("disabled");
                $("#guardar").show();
                $("#reporDetalle").hide();
                app.activarControles();
                
            });
            $('#modalEspecialidad').on('shown.bs.modal', function () {
                $('#descripcion').focus();
            });                

            $("#reporteEspecialidad").on('click', function(event) {
                event.preventDefault();
                window.open('../reportes/reporteEspecialidad.php?idUsuario='+idUsuario, '_blank'); //de esta forma abre en una nueva ventana o pestaña
                
            });

            $("#reporDetalle").on('click', function(event) {
                event.preventDefault();
                var idEspec = $("#id_especialidad").val();
                window.open('../reportes/reporteDetalleEspecialidad.php?id=' + idEspec +'&idUsuario='+idUsuario , '_blank'); //de esta forma abre en una nueva ventana o pestaña
            });
            
            $("#cuerpoTablaEspecialidades").on('click', '.editar', function(event) {
                $("#id_especialidad").val($(this).attr("data-id_especialidad"));
                $("#mHeader").removeClass();
                $("#mHeader").attr("class","modal-header bg-success");
                $("#descripcion").val($(this).parent().parent().children().first().next().html());
                $("#guardar").html("Modificar");
                $("#guardar").attr("value","Modificar");
                $("#tituloModal").html("Editar Especialidad");
                $("#modalEspecialidad").modal({show: true});
                $("#guardar").show();
                $("#reporDetalle").hide();
                app.activarControles();
            });
            
            $("#cuerpoTablaEspecialidades").on('click', '.seleccionar', function(event) {

                $("#id_especialidad").val($(this).attr("data-id_especialidad"));
                $("#mHeader").removeClass();
                $("#mHeader").attr("class","modal-header bg-info");
                $("#descripcion").val($(this).parent().parent().children().first().next().html());
                $("#guardar").hide();
                $("#reporDetalle").show();
                $("#tituloModal").html("Detalles Especialidad");
                $("#modalEspecialidad").modal({show: true});
                app.desactivarControles();
            });
            
            $("#cuerpoTablaEspecialidades").on('click', '.eliminar', function() {
                var id = $(this).attr("data-id_especialidad");
                bootbox.confirm({ 
                    size: 'medium',
                    message: "Se va a eliminar el registro seleccionado. ¿Está seguro?", 
                    callback: function(result){
                    if(result){
                        app.eliminarEspecialidad(id);
                    }
                    }
                });
 
            });
            
            $("#cancelar").on("click", function(event) {
                event.preventDefault();
                app.borrarCampos();
                $("#modalEspecialidad").modal('hide');
            });
            
            $("#equis").on("click", function(event) {
                event.preventDefault();
                app.borrarCampos();
                $("#modalEspecialidad").modal('hide');
            });

            $("#guardar").on("click", function(event) {
                event.preventDefault();
                app.validarCampos();
            });
            $("#formEspecialidad").bootstrapValidator({
                excluded: []
            });
        };
        app.validarCampos = function(){
            var desc = $("#descripcion").val();
            var rta = "";
            if (desc == "") {
                rta += "Debes completar la Descripción";
                //bootbox.alert(rta);
                bootbox.alert(rta);
                $("#descripcion").focus();
            }else{
                app.guardarEspecialidad();
            }
        };
        app.desactivarControles = function (){
            $("#descripcion").attr("disabled", true);
        }; 
        app.activarControles = function (){
            $("#descripcion").removeAttr("disabled");
        }; 
        app.borrarCampos = function (){
            $("#descripcion").val("").html();
            $("#formEspecialidad").bootstrapValidator('resetForm', true);
        }; 
        
        app.guardarEspecialidad = function() {
            var url = "../../controlador/ruteador/Ruteador.php"; //tanto para modif como para agregar
            var data = $("#formEspecialidad").serialize();
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: data,
                success: function(datos) {
                    $("#modalEspecialidad").modal('hide');
                    app.actualizarDataTable(datos, $("#id_especialidad").val());
                },
                error: function(data) {
                    alert(data);
                }
            });
        };
        app.eliminarEspecialidad= function(id) {

            var url = "../../controlador/ruteador/Ruteador.php?accion=eliminar&nombreFormulario=Especialidad&id=" + id; 

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
            var fila = $("#cuerpoTablaEspecialidades").find("a[data-id_especialidad='" + id + "']").parent().parent().remove();
        };
        
        app.buscarEspecialidades = function() {
            var url = "../../controlador/ruteador/Ruteador.php?accion=buscar&nombreFormulario=Especialidad";
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

        
        app.actualizarDataTable = function(especialidad, id) {
            if (id == 0) { //si entra acá es porque es agregar
                var html = '<tr class="text-warning">' +
                        '<td><a class="center-block seleccionar" data-id_especialidad="' + especialidad.id_especialidad + '"><button class="btn btn-info btn-sm">'+
                        '<span class="glyphicon glyphicon-eye-open left"> Info</span></button></a></td>' +
                        '<td>' + especialidad.descripcion_especialidad + '</td>' +
                        '<td><a class="pull-left editar" data-id_especialidad="' + especialidad.id_especialidad + '"><button class="btn btn-success btn-sm">'+
                        '<span class="glyphicon glyphicon-pencil"> Editar</span></button></a>' +
                        '<a class="pull-right eliminar" data-id_especialidad="' + especialidad.id_especialidad + '"><button class="btn btn-danger btn-sm">'+
                        '<span class="glyphicon glyphicon-remove"> Eliminar</span></button></a>' +
                        '</td>' +
                        '</tr>';
                $("#cuerpoTablaEspecialidades").append(html);
                
            } else {
                //busco la fila
                var fila = $("#cuerpoTablaEspecialidades").find("a[data-id_especialidad='" + id + "']").parent().parent();
                var html = '<td>' + 
                        '<a class="center-block seleccionar" data-id_especialidad="' + especialidad.id_especialidad + '"><button class="btn btn-info btn-sm">'+
                        '<span class="glyphicon glyphicon-eye-open left"> Info</span></button></a></td>' +
                        '<td>' + especialidad.descripcion_especialidad + '</td>' +
                        '<td><a class="pull-left editar" data-id_especialidad="' + especialidad.id_especialidad + '"><button class="btn btn-success btn-sm">'+
                        '<span class="glyphicon glyphicon-pencil"> Editar</span></button></a>' +
                        '<a class="pull-right eliminar" data-id_especialidad="' + especialidad.id_especialidad + '"><button class="btn btn-danger btn-sm">'+
                        '<span class="glyphicon glyphicon-remove"> Eliminar</span></button></a>' +
                        '</td>';
                fila.html(html);
            }
        };
        
        app.rellenarDataTable = function(data) {
            var html = "";

            $.each(data, function(clave, especialidad) {
                html += '<tr class="text-warning">' +
                        '<td><a class="center-block seleccionar" data-id_especialidad="' + especialidad.id_especialidad + '"><button class="btn btn-info btn-sm">'+
                        '<span class="glyphicon glyphicon-eye-open left"> Info</span></button></a></td>' +
                        '<td>' + especialidad.descripcion_especialidad + '</td>' +
                        '<td><a class="pull-left editar" data-id_especialidad="' + especialidad.id_especialidad + '"><button class="btn btn-success btn-sm">'+
                        '<span class="glyphicon glyphicon-pencil"> Editar</span></button></a>' +
                        '<a class="pull-right eliminar" data-id_especialidad="' + especialidad.id_especialidad + '"><button class="btn btn-danger btn-sm">'+
                        '<span class="glyphicon glyphicon-remove"> Eliminar</span></button></a>' +
                        '</td>' +
                        '</tr>';
            });
            $("#cuerpoTablaEspecialidades").html(html);
            $("#tablaEspecialidades").dataTable({       //transforma la tabla en dataTable
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
                        app.buscarEspecialidades();  
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

    })(FAEspecialidad);


});
