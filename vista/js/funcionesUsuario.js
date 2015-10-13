$(function() {

    var TallerAvanzada = {};
    var idUsuario="";
    (function(app) {

        app.init = function() {
            $("#reporDetalle").hide(); 
            $("#alertaA").hide();
            $("#alertaE").hide();
            $("#cerrarSesion").on('click', function(event) {
                document.location.href="../../CerrarSesion.php";
                event.preventDefault();
            });
            
            app.verificarSesion();
            
        };

        app.verificarSesion = function(){
            var url = "../../controlador/ruteador/Sesion.php"; 
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                success: function(datos) {
                    if (typeof datos['id_usuario'] != 'undefined' && typeof datos['tipoAcceso_usuario'] != 'undefined') {
                        $("#id_user").val(datos.id_usuario);
                        var tA = datos.tipoAcceso_usuario;
                        idUsuario=datos.id_usuario;
                        //alert("Tipo Acceso: "+tA);
                        if (parseInt(tA) == 1) {
                            $("#logedUser").html(datos.usuario_usuario);
                            app.buscarUsuarios();  
                            app.bindings();
                        }else{
                            location.href = "../../admin.html";
                        }
                    } else {
                        location.href = "../../index.html";
                    }
                },
                error: function(data) {
                    location.href = "../../index.html";
                } 
            });  
};
        app.bindings = function() {
            $('#txtModificacion').attr('disabled',true);
            $('#txtCreacion').attr('disabled',true);
            $('#pass').attr('disabled',true);
            $('#rPass').attr('disabled',true);
            $("#agregar").on('click', function(event) {
                event.preventDefault();
//                app.borrarCampos();
                app.activarControles();
                $('#fCrea').hide();
                $('#fModi').hide();                
                $("#id").val(0);
                $("#mHeader").removeClass();
                $("#mHeader").attr("class","modal-header bg-primary");
                $("#tituloModal").html("Nuevo Usuario");//Cambio el título del Modal
                $("#modalUsuario").modal({show: true});//lo muestro
                $("#accion").attr("value","guardar");//Cambio el nombre del boton
                $("#guardar").html("Agregar");
                $('#pass').val("123");
                $('#rPass').val("123");
                $('#accesoTotal').attr('checked',false);
                $('#accesoRestringido').attr('checked',false);
                $("#guardar").show();//muestro el boton guardar
                $("#reporDetalle").hide();//
            });
            $('#modalUsuario').on('shown.bs.modal', function () {
                $('#nombreUsuario').focus();
            });
            $("#reporteUsuario").on('click', function(event) {
                event.preventDefault();
                window.open('../reportes/reporteUsuarios.php?idUsuario='+idUsuario, '_blank'); //de esta forma abre en una nueva ventana o pestaña
            });

            $("#reporDetalle").on('click', function(event) {
                event.preventDefault();
                var idUs = $("#id").val();
                window.open('../reportes/reporteDetalleUsuario.php?id=' + idUs+'&idUsuario='+idUsuario , '_blank'); //de esta forma abre en una nueva ventana o pestaña
            });
            
            $("#exampleBody").on('click', '.editar', function(event) {
                event.preventDefault();
                $("#id").val($(this).attr("data-id_usuario"));
                
                $('#fCrea').show();
                $('#fModi').show();
                
                $("#mHeader").removeClass();
                $("#mHeader").attr("class","modal-header bg-success");
                $("#nombreUsuario").val($(this).parent().parent().children().first().next().html());
                $("#apellidoUsuario").val($(this).parent().parent().children().first().next().next().html());
                $("#usuario").val($(this).parent().parent().children().first().next().next().next().html());
                $("#pass").val($(this).parent().parent().children().first().next().next().next().next().html());
                $("#pass").attr('disabled', true);
                $("#rPass").val($(this).parent().parent().children().first().next().next().next().next().html());
                $("#rPass").attr('disabled', true);
                $('#usuario').removeAttr('disabled');
                
                var acceso=($(this).parent().parent().children().first().next().next().next().next().next()).html(); 
                if(acceso == "Total"){
                    $("#accesoRestringido").prop("checked", "");
                    $('#accesoTotal').prop('checked',true);
                }else{
                    $('#accesoTotal').prop("checked","");
                    $('#accesoRestringido').prop('checked',true);
                }
                
                $('#txtCreacion').val($(this).parent().parent().children().first().next().next().next().next().next().next().html());
                $('#txtModificacion').val($(this).parent().parent().children().first().next().next().next().next().next().next().next().html());
               
                app.activarControles();
                $("#guardar").html("Modificar");
                $("#accion").attr("value","modificar");
                $("#tituloModal").html("Editar Usuario");
                $("#modalUsuario").modal({show: true});                
                $("#guardar").show();
                $("#reporDetalle").hide();
                
            });
            
            $("#exampleBody").on('click', '.seleccionar', function(event) {
                event.preventDefault();
                $("#id").val($(this).attr("data-id_usuario"));
                $("#mHeader").removeClass();
                $("#mHeader").attr("class","modal-header bg-info");
                $('#fCrea').show();
                $('#fModi').show();
                
                
                $("#nombreUsuario").val($(this).parent().parent().children().first().next().html());
                $("#apellidoUsuario").val($(this).parent().parent().children().first().next().next().html());
                $("#usuario").val($(this).parent().parent().children().first().next().next().next().html());
                $("#pass").val($(this).parent().parent().children().first().next().next().next().next().html());
                $("#rPass").val($(this).parent().parent().children().first().next().next().next().next().html());
                var acceso=($(this).parent().parent().children().first().next().next().next().next().next()).text();
                
                if(acceso == "Total"){
                    $("#accesoRestringido").prop("checked", "");
                    $('#accesoTotal').prop('checked',true);
                }else{
                    $('#accesoTotal').prop("checked","");
                    $('#accesoRestringido').prop('checked',true);
                }
                
                $('#txtCreacion').val($(this).parent().parent().children().first().next().next().next().next().next().next().html());
                $('#txtModificacion').val($(this).parent().parent().children().first().next().next().next().next().next().next().next().html());
                app.desactivarControles();
                $("#guardar").hide();
                $("#reporDetalle").show();
                $("#guardar").html("Modificar");
                $("#guardar").attr("value","Modificar");
                $("#tituloModal").html("Detalles Usuario");
                $("#modalUsuario").modal({show: true});
            });
            
            $("#exampleBody").on('click', '.eliminar', function() {
                app.eliminarUsuario($(this).attr("data-id_usuario"));
            });
            
            $("#cancelar").on("click", function(event) {
                event.preventDefault();
                app.borrarCampos();
                $("#modalUsuario").modal('hide');
            });

            $("#guardar").on("click", function(event) {
                event.preventDefault();
                app.validarCampos();
            });
            
            $("#formUsuario").bootstrapValidator({
                excluded: []
            });
        };
        app.validarCampos = function(){
            var nom = $('#nombreUsuario').val();
            var ape = $('#apellidoUsuario').val();
            var user = $('#usuario').val();
            var pass = $('#pass').val();
            var rPass = $('#rPass').val();
            var acceso = 2;
            if (!($('#accesoTotal').is(':checked')) && !($('#accesoRestringido').is(':checked'))) {
                acceso = 2;
            }else if(($('#accesoTotal').is(':checked'))){
                acceso = 1;
            }else{
                acceso = 0;
            }
            if (nom == null || nom == "") {
                bootbox.alert("Debes completar el campo Nombre");
            }else if(ape == null || ape == ""){
                bootbox.alert("Debes completar el campo Apellido");
            }else if(user == null || user == ""){
                bootbox.alert("Debes completar el campo Usuario");
            }else if(pass == null || pass == ""){
                bootbox.alert("Debes completar el campo Contraseña");
            }else if(rPass == null || rPass == ""){
                bootbox.alert("Debes completar el campo Repetir Contraseña");
            }else if(pass != rPass){
                bootbox.alert("Las contraseñas ingresados con concuerdan");
            }else if(acceso == 2){  
                bootbox.alert("Debes seleccionar el Tipo de Acceso");
            }else{
                app.guardarUsuarios();
            }
        };
        app.desactivarControles = function(){
            $('#nombreUsuario').attr('disabled', true);
            $('#apellidoUsuario').attr('disabled', true);
            $('#usuario').attr('disabled', true);
            $('#pass').attr('disabled', true);
            $('#rPass').attr('disabled', true);
            $('#accesoRestringido').attr('disabled', true);
            $('#accesoTotal').attr('disabled', true);
            $('#txtCreacion').attr('disabled', true);
            $('#txtModificacion').attr('disabled', true);
        };
        app.activarControles = function(){
            $('#nombreUsuario').removeAttr('disabled');
            $('#apellidoUsuario').removeAttr('disabled');
            $('#usuario').removeAttr('disabled');
//            $('#pass').removeAttr('disabled');
//            $('#rPass').removeAttr('disabled');
            $('#accesoRestringido').removeAttr("disabled");
            $('#accesoTotal').removeAttr("disabled");
//            $('#txtCreacion').removeAttr('disabled');
//            $('#txtModificacion').removeAttr('disabled');
        };
        app.borrarCampos = function (){
            $('#nombreUsuario').val("").html();
            $('#apellidoUsuario').val("").html();
            $('#usuario').val("").html();
            //$('#pass').val("").html();
            //$('#rPass').val("").html();
            $('#accesoRestringido').removeAttr(':checked');
            $('#accesoTotal').removeAttr(':checked');
            $('#txtCreacion').val("").html();
            $('#txtModificacion').val("").html();
            $("#modalUsuario").bootstrapValidator('resetForm', true);
        }; 
        
        app.guardarUsuarios = function() {
            
            var url = "../../controlador/ruteador/Ruteador.php"; //voy al ruteador a guardar Usuario (tanto para modific como para agregar)
            //data del formulario persona
            //$('#txtCreacion').removeAttr('disabled');
            //$('#txtModificacion').removeAttr('disabled');
            var data = $("#formUsuario").serialize();//convierto los datos del alumno en un array para enviarlos al ruteados
            //data.push({clave:pass});
            $.ajax({
                url: url,//paso la url
                method: 'POST',//método que utilizo
                dataType: 'json',//tipo de datos
                data: data,//el formulario del usuario que estoy pasando
                success: function(datos) {//si todo salió bien 
                    $("#modalUsuario").modal('hide');//oculto el modal
                    app.borrarCampos();
                    app.actualizarDataTable(datos, $("#id").val());
                    app.buscarUsuarios();
                },
                error: function(data) {//si hay un error lo muestro por pantalla
                    alert(data);//mensaje de error
                }
            });
        };
        
        app.eliminarUsuario = function(id) {
            
            bootbox.confirm({ 
            size: 'medium',
            message: "Esta Seguro que desea Eliminar un Usuario?", 
            callback: function(result){
                if(result){
                var url = "../../controlador/ruteador/Ruteador.php?accion=eliminar&nombreFormulario=Usuario&id=" + id; //cambiar url
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
            }
            }
            });
        };


        app.borrarFilaDataTable = function(id) {
            var fila = $("#exampleBody").find("a[data-id_usuario='" + id + "']").parent().parent().remove();

        };
        
        app.buscarUsuarios = function() {//función que se encarga de realizar la busqueda de los usuarios
            var url = "../../controlador/ruteador/Ruteador.php?accion=buscar&nombreFormulario=Usuario";//paso la dirección del 
            //ruteador para obtener los datos de la BD
            $.ajax({//ajax para realizar la petición de los datos
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {//si todo sale bien llamo a la funcion correspondiente
                    app.rellenarDataTable(data);//esta es la función encargada de rellenar la tabla conlos datos de los usuarios del sistema
                },
                error: function() {//si algo sale mal muestra un mensaje de error
                    alert('error');
                }

            });
        };
        
        
         app.rellenarDataTable = function(data) {//función para rellenar la tabla
            var html = "";//variable que voy a utilizar para rellenar la tabla
            if ( $.fn.DataTable.isDataTable( '#example' ) ) {
                $('#example').DataTable().destroy();
            }
            $.each(data, function(clave, usuario) {//recorro todos los datos devueltos con el JSon
                html += '<tr class="text-warning">' +
                        '<td><a class="seleccionar" data-id_usuario="' + usuario.id_usuario + '"><button class="btn btn-info btn-sm">'+
                        '<span class="glyphicon glyphicon-eye-open left">  Info</span></button></a></td>'+ 
                        '<td>' + usuario.nombre_usuario + '</td>' +
                        '<td>' + usuario.apellido_usuario + '</td>' +
                        '<td>' + usuario.usuario_usuario + '</td>' +
                        '<td> '+ '°°°°°°°°°°°°'+'</td>' ;
                        if(usuario.tipoAcceso_usuario == 1){
                            html+="<td>Total</td>";
                        }else{
                            html+='<td>Restringido</td>';
                        }
                        html+='<td>' + usuario.fch_creacion+ '</td>' +
                        '<td>' + usuario.fch_modificacion + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_usuario="' + usuario.id_usuario + '"><button class="btn btn-success btn-sm">'+
                        '<span class="glyphicon glyphicon-pencil"> Editar</span></button></a>'+    
                        '<a class="pull-right eliminar" data-id_usuario="' + usuario.id_usuario + '"><button class="btn btn-danger btn-sm">'+
                        '<span class="glyphicon glyphicon-remove"> Eliminar</span></button></a>'+
                        '</td>' +
                        '</tr>';
            });
            $("#exampleBody").html(html);//meto los datos en la tabla que corresponde
            $("#example").dataTable({       //transforma la tabla en dataTable
                responsive: true,
                "sPagiationType":"full_numbers", //activa la paginación con números
                "language":{ //cambia el lenguaje de la dataTable
                    "url":"../js/dataTable-es.json" //este es el archivo json del lenguaje español
                }
            });
        };
        app.actualizarDataTable = function(usuario, id) {
            if (id == 0) { //si entra acá es porque es agregar
                html += '<tr class="text-warning">' +//agrego cada uno de los datos correspondientes además habilito dos columnas para poder
                        '<td><a class="seleccionar" data-id_usuario="' + usuario.id_usuario + '"><button class="btn btn-info btn-sm">'+
                        '<span class="glyphicon glyphicon-eye-open left">  Info</span></button></a></td>'+
                        '<td>' + usuario.nombre_usuario + '</td>' +
                        '<td>' + usuario.apellido_usuario + '</td>' +
                        '<td>' + usuario.usuario_usuario + '</td>' +
                        '<td> '+ '°°°°°°°°°°°°'+'</td>';
                         if(usuario.tipoAcceso_usuario == 1)
                        {
                            html +="<td>Total</td>";
                        }else
                        {
                            html +='<td>Restringido</td>';
                        }
                        html +='<td>' + usuario.fch_creacion+ '</td>' +
                        '<td>' + usuario.fch_modificacion + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_usuario="' + usuario.id_usuario + '">'+
                        '<button class="btn btn-success btn-sm">'+
                        '<span class="glyphicon glyphicon-pencil"> Editar</span></button></a>'+
                        '<a class="pull-right eliminar" data-id_usuario="' + usuario.id_usuario + '">'+
                        '<button class="btn btn-danger btn-sm">'+
                        '<span class="glyphicon glyphicon-remove"> Eliminar</span></button></a>'+
                        '</td>' +
                        '</tr>';
                $("#exampleBody").append(html);
                
            } else {
                var html="";
                var fila ="";
                fila = $("#exampleBody").find("a[data-id_usuario='" + id + "']").parent().parent();
                  html +='<td><a class="seleccionar" data-id_usuario="' + usuario.id_usuario + '"><button class="btn btn-info btn-sm">'+
                        '<span class="glyphicon glyphicon-eye-open left">  Info</span></button></a></td>'+
                        '<td>' + usuario.nombre_usuario + '</td>' +
                        '<td>' + usuario.apellido_usuario + '</td>' +
                        '<td>' + usuario.usuario_usuario + '</td>' +
                        '<td> '+ '°°°°°°°°°°°°'+'</td>' ;
                         if(usuario.tipoAcceso_usuario == 1)
                        {
                            html +="<td>Total</td>";
                        }else
                        {
                            html +='<td>Restringido</td>';
                        }
                        html +='<td>' + usuario.fch_creacion+ '</td>' +
                        '<td>' + usuario.fch_modificacion + '</td>' +
                        '<td>' +
                        '<a class="pull-left editar" data-id_usuario="' + usuario.id_usuario + '"><button class="btn btn-success btn-sm">'+
                        '<span class="glyphicon glyphicon-pencil"> Editar</span></button></a>'+
                        '<a class="pull-right eliminar" data-id_usuario="' + usuario.id_usuario + '"><button class="btn btn-danger btn-sm">'+
                        '<span class="glyphicon glyphicon-remove"> Eliminar</span></button></a>'+
                        '</td>';
                fila.html(html);
            }
        };
        app.init();
    })(TallerAvanzada);


});