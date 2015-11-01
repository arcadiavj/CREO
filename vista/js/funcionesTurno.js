$(function() {

    var FATurno = {};
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
                $("#id_turno").val(0);
                $("#mHeader").removeClass();
                $("#mHeader").attr("class","modal-header bg-primary");
                $("#tituloModal").html("Agregar Turno");
                $("#modalTurno").modal({show: true});
                $("#guardar").attr("value","Agregar");
                $("#guardar").html("Agregar");
                $("#guardar").show();
                $("#reporDetalle").hide();
                app.activarControles();
                
            });
            $('#modalTurno').on('shown.bs.modal', function () {
                $('#descripcion').focus();
            });                

            $("#reporteTurno").on('click', function(event) {
                event.preventDefault();
                window.open('../reportes/reporteTurno.php?idUsuario='+idUsuario, '_blank'); //de esta forma abre en una nueva ventana o pestaña
                
            });

            $("#reporDetalle").on('click', function(event) {
                event.preventDefault();
                var idCons = $("#id_turno").val();
                window.open('../reportes/reporteDetalleTurno.php?id=' + idCons +'&idUsuario='+idUsuario , '_blank'); //de esta forma abre en una nueva ventana o pestaña
            });
            
            $("#cuerpoTablaTurnos").on('click', '.editar', function(event) {
                $("#id_turno").val($(this).attr("data-id_turno"));
                $("#mHeader").removeClass();
                $("#mHeader").attr("class","modal-header bg-success");
                $("#descripcion").val($(this).parent().parent().children().first().next().html());
                //resto de los campos
                $("#guardar").html("Modificar");
                $("#guardar").attr("value","Modificar");
                $("#tituloModal").html("Editar Turno");
                $("#modalTurno").modal({show: true});
                $("#guardar").show();
                $("#reporDetalle").hide();
                app.activarControles();
            });
            
            $("#cuerpoTablaTurnos").on('click', '.seleccionar', function(event) {

                $("#id_turno").val($(this).attr("data-id_turno"));
                $("#mHeader").removeClass();
                $("#mHeader").attr("class","modal-header bg-info");
                $("#descripcion").val($(this).parent().parent().children().first().next().html());
                //resto de los campos
                $("#guardar").hide();
                $("#reporDetalle").show();
                $("#tituloModal").html("Detalles Turno");
                $("#modalTurno").modal({show: true});
                app.desactivarControles();
            });
            
            $("#cuerpoTablaTurnos").on('click', '.eliminar', function() {
                var id = $(this).attr("data-id_turno");
                bootbox.confirm({ 
                    size: 'medium',
                    message: "Se va a eliminar el registro seleccionado. ¿Está seguro?", 
                    callback: function(result){
                    if(result){
                        app.eliminarTurno(id);
                    }
                    }
                });
 
            });
            
            $("#cancelar").on("click", function(event) {
                event.preventDefault();
                app.borrarCampos();
                $("#modalTurno").modal('hide');
            });
            
            $("#equis").on("click", function(event) {
                event.preventDefault();
                app.borrarCampos();
                $("#modalTurno").modal('hide');
            });

            $("#guardar").on("click", function(event) {
                event.preventDefault();
                app.validarCampos();
            });
            $("#formTurno").bootstrapValidator({
                excluded: []
            });
        };
        app.validarCampos = function(){
            var desc = $("#descripcion").val(); //resto de los campos
            var rta = "";
            if (desc == "") {
                rta += "Debes completar la Descripción";
                //bootbox.alert(rta);
                bootbox.alert(rta);
                $("#descripcion").focus();
            }else{
                app.guardarTurno();
            }
        };
        app.desactivarControles = function (){
            $("#id_consultorio").attr("disabled", true);
            $("#consultorio").attr("disabled", true);
            $("#usuario").attr("disabled", true);
            $("#paciente").attr("disabled", true);
            $("#estado").attr("disabled", true);
            $("#fch_llegada").attr("disabled", true);
            $("#fch_inicio").attr("disabled", true);
            $("#fch_fin").attr("disabled", true);
        }; 
        app.activarControles = function (){
            $("#id_consultorio").removeAttr("disabled"); 
            $("#consultorio").removeAttr("disabled");
            $("#usuario").removeAttr("disabled");
            $("#paciente").removeAttr("disabled");
            $("#estado").removeAttr("disabled");
            $("#fch_llegada").removeAttr("disabled");
            $("#fch_inicio").removeAttr("disabled");
            $("#fch_fin").removeAttr("disabled");
        }; 
        app.borrarCampos = function (){
            $("#id_consultorio").val("").html();
            $("#consultorio").val("").html();
            $("#usuario").val("").html();
            $("#paciente").val("").html();
            $("#estado").val("").html();
            $("#fch_llegada").val("").html();
            $("#fch_inicio").val("").html();
            $("#fch_fin").val("").html();
            $("#formTurno").bootstrapValidator('resetForm', true);
        }; 
        
        app.guardarTurno = function() {
            var url = "../../controlador/ruteador/Ruteador.php"; //tanto para modif como para agregar
            var data = $("#formTurno").serialize();
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: data,
                success: function(datos) {
                    $("#modalTurno").modal('hide');
                    app.actualizarDataTable(datos, $("#id_turno").val());
                },
                error: function(data) {
                    alert(data);
                }
            });
        };
        app.eliminarTurno= function(id) {

            var url = "../../controlador/ruteador/Ruteador.php?accion=eliminar&nombreFormulario=Turno&id=" + id; 

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
            var fila = $("#cuerpoTablaTurnos").find("a[data-id_turno='" + id + "']").parent().parent().remove();
        };
        
        app.buscarTurno = function() {
            var url = "../../controlador/ruteador/Ruteador.php?accion=buscar&nombreFormulario=Turno";
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

        
        app.actualizarDataTable = function(turno, id) {
            if (id == 0) { //si entra acá es porque es agregar
                var html = '<tr class="text-warning">' +
                        '<td><a class="center-block seleccionar" data-id_turno="' + turno.id_turno + '"><button class="btn btn-info btn-sm">'+
                        '<span class="glyphicon glyphicon-eye-open left"> Info</span></button></a></td>' +
                        '<td>' + turno.id_consultorio + '</td>' +
                        '<td>' + turno.consultorio + '</td>' +
                        '<td>' + turno.id_usuario + '</td>' +
                        '<td>' + turno.usuario + '</td>' +
                        '<td>' + turno.historia_clinica_turno + '</td>' +
                        '<td>' + turno.estado_turno + '</td>' +
                        '<td>' + turno.fch_llegada_turno + '</td>' +
                        '<td>' + turno.fch_inicio_turno + '</td>' +
                        '<td>' + turno.fch_fin_turno + '</td>' +
                        '<td><a class="pull-left editar" data-id_turno="' + turno.id_turno + '"><button class="btn btn-success btn-sm">'+
                        '<span class="glyphicon glyphicon-pencil"> Editar</span></button></a>' +
                        '<a class="pull-right eliminar" data-id_turno="' + turno.id_turno + '"><button class="btn btn-danger btn-sm">'+
                        '<span class="glyphicon glyphicon-remove"> Eliminar</span></button></a>' +
                        '</td>' +
                        '</tr>';
                $("#cuerpoTablaTurnos").append(html);
                
            } else {
                //busco la fila
                var fila = $("#cuerpoTablaTurnos").find("a[data-id_turno='" + id + "']").parent().parent();
                var html = '<td>' + 
                        '<a class="center-block seleccionar" data-id_turno="' + turno.id_turno + '"><button class="btn btn-info btn-sm">'+
                        '<span class="glyphicon glyphicon-eye-open left"> Info</span></button></a></td>' +
                        '<td>' + turno.id_consultorio + '</td>' +
                        '<td>' + turno.consultorio + '</td>' +
                        '<td>' + turno.id_usuario + '</td>' +
                        '<td>' + turno.usuario + '</td>' +
                        '<td>' + turno.historia_clinica_turno + '</td>' +
                        '<td>' + turno.estado_turno + '</td>' +
                        '<td>' + turno.fch_llegada_turno + '</td>' +
                        '<td>' + turno.fch_inicio_turno + '</td>' +
                        '<td>' + turno.fch_fin_turno + '</td>' +
                        '<td><a class="pull-left editar" data-id_turno="' + turno.id_turno + '"><button class="btn btn-success btn-sm">'+
                        '<span class="glyphicon glyphicon-pencil"> Editar</span></button></a>' +
                        '<a class="pull-right eliminar" data-id_turno="' + turno.id_turno + '"><button class="btn btn-danger btn-sm">'+
                        '<span class="glyphicon glyphicon-remove"> Eliminar</span></button></a>' +
                        '</td>';
                fila.html(html);
            }
        };
        
        app.rellenarDataTable = function(data) {
            var html = "";

            $.each(data, function(clave, turno) {
                html += '<tr class="text-warning">' +
                        '<td><a class="center-block seleccionar" data-id_turno="' + turno.id_turno + '"><button class="btn btn-info btn-sm">'+
                        '<span class="glyphicon glyphicon-eye-open left"> Info</span></button></a></td>' +
                        '<td>' + turno.id_consultorio + '</td>' +
                        '<td>' + turno.descripcion_consultorio + '</td>' +
                        '<td>' + turno.id_usuario + '</td>' +
                        '<td>' + turno.usuario_usuario + '</td>' +
                        '<td>' + turno.historia_clinica_turno + '</td>' +
                        '<td>' + turno.estado_turno + '</td>' +
                        '<td>' + turno.fch_llegada_turno + '</td>' +
                        '<td>' + turno.fch_inicio_turno + '</td>' +
                        '<td>' + turno.fch_fin_turno + '</td>' +
                        '<td><a class="pull-left editar" data-id_turno="' + turno.id_turno + '"><button class="btn btn-success btn-sm">'+
                        '<span class="glyphicon glyphicon-pencil"> Editar</span></button></a>' +
                        '<a class="pull-right eliminar" data-id_turno="' + turno.id_turno + '"><button class="btn btn-danger btn-sm">'+
                        '<span class="glyphicon glyphicon-remove"> Eliminar</span></button></a>' +
                        '</td>' +
                        '</tr>';
            });
            $("#cuerpoTablaTurnos").html(html);
            $("#tablaTurnos").dataTable({       //transforma la tabla en dataTable
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
                        app.buscarTurno();  
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

    })(FATurno);


});
