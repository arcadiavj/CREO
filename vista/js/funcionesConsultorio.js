$(function() {

    var FAConsultorio = {};
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
                $("#id_consultorio").val(0);
                $("#mHeader").removeClass();
                $("#mHeader").attr("class","modal-header bg-primary");
                $("#tituloModal").html("Agregar Consultorio");
                $("#modalConsultorio").modal({show: true});
                $("#guardar").attr("value","Agregar");
                $("#guardar").html("Agregar");
                $("#descripcion").removeAttr("disabled");
                $("#guardar").show();
                $("#reporDetalle").hide();
                app.activarControles();
                
            });
            $('#modalConsultorio').on('shown.bs.modal', function () {
                $('#descripcion').focus();
            });                

            $("#reporteConsultorio").on('click', function(event) {
                event.preventDefault();
                window.open('../reportes/reporteConsultorio.php?idUsuario='+idUsuario, '_blank'); //de esta forma abre en una nueva ventana o pestaña
                
            });

            $("#reporDetalle").on('click', function(event) {
                event.preventDefault();
                var idCons = $("#id_consultorio").val();
                window.open('../reportes/reporteDetalleConsultorio.php?id=' + idCons +'&idUsuario='+idUsuario , '_blank'); //de esta forma abre en una nueva ventana o pestaña
            });
            
            $("#cuerpoTablaConsultorios").on('click', '.editar', function(event) {
                $("#id_consultorio").val($(this).attr("data-id_consultorio"));
                $("#mHeader").removeClass();
                $("#mHeader").attr("class","modal-header bg-success");
                $("#descripcion").val($(this).parent().parent().children().first().next().html());
                $("#guardar").html("Modificar");
                $("#guardar").attr("value","Modificar");
                $("#tituloModal").html("Editar Consultorio");
                $("#modalConsultorio").modal({show: true});
                $("#guardar").show();
                $("#reporDetalle").hide();
                app.activarControles();
            });
            
            $("#cuerpoTablaConsultorios").on('click', '.seleccionar', function(event) {

                $("#id_consultorio").val($(this).attr("data-id_consultorio"));
                $("#mHeader").removeClass();
                $("#mHeader").attr("class","modal-header bg-info");
                $("#descripcion").val($(this).parent().parent().children().first().next().html());
                $("#guardar").hide();
                $("#reporDetalle").show();
                $("#tituloModal").html("Detalles Consultorio");
                $("#modalConsultorio").modal({show: true});
                app.desactivarControles();
            });
            
            $("#cuerpoTablaConsultorios").on('click', '.eliminar', function() {
                var id = $(this).attr("data-id_consultorio");
                bootbox.confirm({ 
                    size: 'medium',
                    message: "Se va a eliminar el registro seleccionado. ¿Está seguro?", 
                    callback: function(result){
                    if(result){
                        app.eliminarConsultorio(id);
                    }
                    }
                });
 
            });
            
            $("#cancelar").on("click", function(event) {
                event.preventDefault();
                app.borrarCampos();
                $("#modalConsultorio").modal('hide');
            });
            
            $("#equis").on("click", function(event) {
                event.preventDefault();
                app.borrarCampos();
                $("#modalConsultorios").modal('hide');
            });

            $("#guardar").on("click", function(event) {
                event.preventDefault();
                app.validarCampos();
            });
            $("#formConsultorio").bootstrapValidator({
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
                app.guardarConsultorio();
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
            $("#formConsultorio").bootstrapValidator('resetForm', true);
        }; 
        
        app.guardarConsultorio = function() {
            var url = "../../controlador/ruteador/Ruteador.php"; //tanto para modif como para agregar
            var data = $("#formConsultorio").serialize();
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: data,
                success: function(datos) {
                    $("#modalConsultorio").modal('hide');
                    app.actualizarDataTable(datos, $("#id_consultorio").val());
                },
                error: function(data) {
                    alert(data);
                }
            });
        };
        app.eliminarConsultorio= function(id) {

            var url = "../../controlador/ruteador/Ruteador.php?accion=eliminar&nombreFormulario=Consultorio&id=" + id; 

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
            var fila = $("#cuerpoTablaConsultorios").find("a[data-id_consultorio='" + id + "']").parent().parent().remove();
        };
        
        app.buscarConsultorio = function() {
            var url = "../../controlador/ruteador/Ruteador.php?accion=buscar&nombreFormulario=Consultorio";
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

        
        app.actualizarDataTable = function(consultorio, id) {
            if (id == 0) { //si entra acá es porque es agregar
                var html = '<tr class="text-warning">' +
                        '<td><a class="center-block seleccionar" data-id_consultorio="' + consultorio.id_consultorio + '"><button class="btn btn-info btn-sm">'+
                        '<span class="glyphicon glyphicon-eye-open left"> Info</span></button></a></td>' +
                        '<td>' + consultorio.descripcion_consultorio + '</td>' +
                        '<td><a class="pull-left editar" data-id_consultorio="' + consultorio.id_consultorio + '"><button class="btn btn-success btn-sm">'+
                        '<span class="glyphicon glyphicon-pencil"> Editar</span></button></a>' +
                        '<a class="pull-right eliminar" data-id_consultorio="' + consultorio.id_consultorio + '"><button class="btn btn-danger btn-sm">'+
                        '<span class="glyphicon glyphicon-remove"> Eliminar</span></button></a>' +
                        '</td>' +
                        '</tr>';
                $("#cuerpoTablaConsultorios").append(html);
                
            } else {
                //busco la fila
                var fila = $("#cuerpoTablaConsultorios").find("a[data-id_consultorio='" + id + "']").parent().parent();
                var html = '<td>' + 
                        '<a class="center-block seleccionar" data-id_consultorio="' + consultorio.id_consultorio + '"><button class="btn btn-info btn-sm">'+
                        '<span class="glyphicon glyphicon-eye-open left"> Info</span></button></a></td>' +
                        '<td>' + consultorio.descripcion_consultorio + '</td>' +
                        '<td><a class="pull-left editar" data-id_consultorio="' + consultorio.id_consultorio + '"><button class="btn btn-success btn-sm">'+
                        '<span class="glyphicon glyphicon-pencil"> Editar</span></button></a>' +
                        '<a class="pull-right eliminar" data-id_consultorio="' + consultorio.id_consultorio + '"><button class="btn btn-danger btn-sm">'+
                        '<span class="glyphicon glyphicon-remove"> Eliminar</span></button></a>' +
                        '</td>';
                fila.html(html);
            }
        };
        
        app.rellenarDataTable = function(data) {
            var html = "";

            $.each(data, function(clave, consultorio) {
                html += '<tr class="text-warning">' +
                        '<td><a class="center-block seleccionar" data-id_consultorio="' + consultorio.id_consultorio + '"><button class="btn btn-info btn-sm">'+
                        '<span class="glyphicon glyphicon-eye-open left"> Info</span></button></a></td>' +
                        '<td>' + consultorio.descripcion_consultorio + '</td>' +
                        '<td><a class="pull-left editar" data-id_consultorio="' + consultorio.id_consultorio + '"><button class="btn btn-success btn-sm">'+
                        '<span class="glyphicon glyphicon-pencil"> Editar</span></button></a>' +
                        '<a class="pull-right eliminar" data-id_consultorio="' + consultorio.id_consultorio + '"><button class="btn btn-danger btn-sm">'+
                        '<span class="glyphicon glyphicon-remove"> Eliminar</span></button></a>' +
                        '</td>' +
                        '</tr>';
            });
            $("#cuerpoTablaConsultorios").html(html);
            $("#tablaConsultorios").dataTable({       //transforma la tabla en dataTable
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
                        $("#id_consultorio").val(datos.id_consultorio);
                        idUsuario=datos.id_usuario;
                        app.buscarConsultorio();  
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

    })(FAConsultorio);


});
