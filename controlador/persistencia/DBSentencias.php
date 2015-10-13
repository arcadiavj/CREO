<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Flaco
 */
interface DBSentencias {
    

    
//EXPEDIENTES
  
    const BUSCAR_EXPEDIENTES="SELECT * FROM expediente INNER JOIN usuario ON expediente.id_usuario=usuario.id_usuario 
                                INNER JOIN caso ON expediente.id_caso=caso.id_caso 
                                WHERE expediente.fch_baja='0000-00-00 00:00:00' LOCK IN SHARE MODE";
     
    const ELIMINAR_EXPEDIENTE="UPDATE expediente SET fch_baja = ? WHERE id_expte=?";
    const BUSCAR_ULTIMO_EXPEDIENTE="SELECT MAX(id_expte) FROM expediente WHERE fch_baja = '0000-00-00 00:00:00' LOCK IN SHARE MODE"; 
    const INSERTAR_EXPEDIENTE="INSERT INTO expediente(numero_expte,ano_expte,caratula_expte,id_caso,id_usuario,fch_creacion,fch_modificacion,fch_baja) VALUES (?,?,?,?,?,?,?,?)";
    const MODIFICAR_EXPEDIENTE="UPDATE expediente SET numero_expte = ?,ano_expte = ?,caratula_expte = ?,id_caso = ?
            ,id_usuario = ?,fch_modificacion = ? WHERE id_expte = ?";
    const BUSCAR_UN_EXPEDIENTE="SELECT * FROM expediente INNER JOIN usuario ON expediente.id_usuario= usuario.id_usuario WHERE id_expte=? LOCK IN SHARE MODE";    
    
    
//SENTENCIAS PARA BLOQUEO Y DESBLOQUEO (CONCURRENCIA)
    const BLOQUEAR_TABLAS = "LOCK TABLES";
    const DESBLOQUEAR_TABLAS = "UNLOCK TABLES";
//SENTENCIAS ARTS
    const BUSCAR_ARTS = "SELECT * FROM art INNER JOIN usuario ON art.id_usuario=usuario.id_usuario WHERE art.fch_baja = '0000-00-00 00:00:00' LOCK IN SHARE MODE";
    const ELIMINAR_ART = "UPDATE art SET fch_baja = ? WHERE id_art = ?";
    const INSERTAR_ART = "INSERT INTO art(nombre_art, direccion_art, detalle_art, id_usuario, fch_creacion) VALUES(?,?,?,?,?)";
    const ACTUALIZAR_ART = "UPDATE art SET nombre_art = ?, direccion_art = ?, detalle_art = ?, id_usuario = ?,
            fch_modificacion = ? WHERE id_art = ?";
    const ULTIMA_ART = "SELECT MAX(id_art) FROM ART WHERE fch_baja = '0000-00-00 00:00:00' LOCK IN SHARE MODE";
    const BUSCAR_UNA_ART = "SELECT * FROM art INNER JOIN usuario ON art.id_usuario=usuario.id_usuario WHERE art.fch_baja = '0000-00-00 00:00:00' AND id_art = ? LOCK IN SHARE MODE";
    
    
//SENTENCIAS CASOS
    const ELIMINAR_CASO = "UPDATE caso SET fch_baja = ? WHERE id_caso = ?";
    const INSERTAR_CASO = "INSERT INTO caso(inItinere_caso, fechaAccidente_caso, salario_caso, fotocopiaDNI_caso,
             firmaPoder_caso, firmaPacto_caso, estado_caso, etapa_caso, descripcion_caso, id_cliente, id_art,
             id_profesional, id_asistente,id_usuario, fch_creacion) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    const ACTUALIZAR_CASO = "UPDATE caso SET inItinere_caso = ?, fechaAccidente_caso = ?, salario_caso = ?,
            fotocopiaDNI_caso = ?,firmaPoder_caso = ?, firmaPacto_caso = ?, estado_caso = ?, etapa_caso = ?, 
            descripcion_caso = ?, id_cliente = ?, id_art = ?,id_profesional = ?, id_asistente = ?,id_usuario = ?,
            fch_modificacion = ? WHERE id_caso = ?";
    const BUSCAR_CASOS = "SELECT * FROM caso INNER JOIN cliente ON caso.id_cliente = cliente.id_cliente INNER JOIN 
        profesional ON caso.id_profesional = profesional.id_profesional INNER JOIN asistente ON caso.id_asistente 
        = asistente.id_asistente INNER JOIN art ON caso.id_art = art.id_art WHERE caso.fch_baja = '0000-00-00 00:00:00'
        LOCK IN SHARE MODE";
    const BUSCAR_UN_CASO = "SELECT * FROM caso INNER JOIN cliente ON caso.id_cliente = cliente.id_cliente INNER JOIN 
        profesional ON caso.id_profesional = profesional.id_profesional INNER JOIN asistente ON caso.id_asistente 
        = asistente.id_asistente INNER JOIN art ON caso.id_art = art.id_art INNER JOIN usuario ON caso.id_usuario=usuario.id_usuario WHERE caso.fch_baja = '0000-00-00 00:00:00' 
        AND caso.id_caso = ? LOCK IN SHARE MODE";
    const ULTIMO_CASO="SELECT MAX(id_caso) FROM caso WHERE caso.fch_baja = '0000-00-00 00:00:00' LOCK IN SHARE MODE";
    
    
    
///SENTENCIAS LLAMADAS
    const ACTUALIZAR_UNA_LLAMADA = "UPDATE llamada SET detalle_llamada = ?, fechaProxima_llamada = ? 
        , estado_llamada = ?,tipo_llamada = ?, id_caso = ?, id_usuario = ?, fch_modificacion = ? WHERE llamada.fch_baja = '0000-00-00 00:00:00' 
        AND id_llamada = ?";
    const BUSCAR_UNA_LLAMADA = "SELECT * FROM llamada INNER JOIN caso ON llamada.id_caso = caso.id_caso INNER JOIN cliente ON caso.id_cliente = cliente.id_cliente INNER JOIN asistente ON caso.id_asistente = asistente.id_asistente INNER JOIN usuario ON llamada.id_usuario=usuario.id_usuario WHERE llamada.fch_baja = '0000-00-00 00:00:00' AND id_llamada = ? LOCK IN SHARE MODE";
    const BUSCAR_LLAMADAS_HOY = "SELECT * FROM llamada INNER JOIN caso ON llamada.id_caso = caso.id_caso INNER JOIN cliente ON caso.id_cliente = cliente.id_cliente INNER JOIN asistente ON caso.id_asistente = asistente.id_asistente WHERE llamada.fch_baja = '0000-00-00 00:00:00' AND fecha_llamada = ? LOCK IN SHARE MODE";
    const BUSCAR_LLAMADAS_PENDIENTES = "SELECT * FROM llamada INNER JOIN caso ON llamada.id_caso = caso.id_caso INNER JOIN cliente ON caso.id_cliente = cliente.id_cliente INNER JOIN asistente ON caso.id_asistente = asistente.id_asistente WHERE llamada.fch_baja = '0000-00-00 00:00:00' AND estado_llamada = 'P' LOCK IN SHARE MODE";
    const BUSCAR_LLAMADAS_REALIZADAS = "SELECT * FROM llamada INNER JOIN caso ON llamada.id_caso = caso.id_caso INNER JOIN cliente ON caso.id_cliente = cliente.id_cliente INNER JOIN asistente ON caso.id_asistente = asistente.id_asistente WHERE llamada.fch_baja = '0000-00-00 00:00:00' AND estado_llamada = 'R' LOCK IN SHARE MODE";
    const BUSCAR_TODAS_LAS_LLAMADAS ="SELECT * FROM llamada INNER JOIN caso ON llamada.id_caso = caso.id_caso INNER JOIN cliente ON caso.id_cliente = cliente.id_cliente INNER JOIN asistente ON caso.id_asistente = asistente.id_asistente WHERE llamada.fch_baja = '0000-00-00 00:00:00' LOCK IN SHARE MODE";
    const ELIMINAR_LLAMADA ="UPDATE llamada SET fch_baja = ? WHERE id_llamada = ?";
    const INSERTAR_LLAMADA ="INSERT INTO llamada(detalle_llamada, fecha_llamada, fechaProxima_llamada, 
        estado_llamada, tipo_llamada, id_caso, id_usuario, fch_creacion) VALUES(?,?,?,?,?,?,?,?)";
    const ULTIMA_LLAMADA="SELECT MAX(id_llamada) FROM llamada WHERE llamada.fch_baja = '0000-00-00 00:00:00' LOCK IN SHARE MODE";    
    const BUSCAR_LLAMADAS = "SELECT * FROM llamada INNER JOIN caso ON llamada.id_caso = caso.id_caso INNER JOIN cliente ON caso.id_cliente = cliente.id_cliente INNER JOIN asistente ON caso.id_asistente = asistente.id_asistente INNER JOIN usuario ON llamada.id_usuario=usuario.id_usuario WHERE llamada.fch_baja = '0000-00-00 00:00:00' LOCK IN SHARE MODE";
    
    
//SENTENCIAS CLIENTES
    const BUSCAR_CLIENTES = "SELECT * FROM cliente WHERE fch_baja = '0000-00-00 00:00:00' LOCK IN SHARE MODE";
    const ELIMINAR_CLIENTE = "UPDATE cliente SET fch_baja = ? WHERE id_cliente = ?";
    const INSERTAR_CLIENTE = "INSERT INTO cliente(nombre_cliente, apellido_cliente, dni_cliente, direccion_cliente, 
        fecha_nacimiento_cliente, id_usuario, fch_creacion) VALUES(?,?,?,?,?,?,?)";
    const BUSCAR_UN_CLIENTE = "SELECT * FROM cliente WHERE fch_baja = '0000-00-00 00:00:00' AND id_cliente = ? LOCK IN SHARE MODE"; 
    const BUSCAR_TELEFONOS_DE_UN_CLIENTE = "SELECT * FROM telefono WHERE fch_baja = '0000-00-00 00:00:00' AND id_cliente = ? LOCK IN SHARE MODE";
    const BUSCAR_TELEFONOS = "SELECT * FROM telefono INNER JOIN cliente ON telefono.id_cliente = cliente.id_cliente 
            WHERE telefono.fch_baja = '0000-00-00 00:00:00' LOCK IN SHARE MODE";
    const ULTIMO_CLIENTE = "SELECT MAX(id_cliente) FROM cliente WHERE cliente.fch_baja = '0000-00-00 00:00:00' LOCK IN SHARE MODE";
    const ACTUALIZAR_UN_CLIENTE = "UPDATE cliente SET nombre_cliente = ?, apellido_cliente = ?, dni_cliente = ?, direccion_cliente = ?, fecha_nacimiento_cliente = ?, id_usuario = ?, fch_modificacion = ? WHERE id_cliente = ?";
    //const ACTUALIZAR_TELEFONO = "UPDATE telefono SET numero_telefono = ?, propietario_telefono = ?, detalle_telefono = ?,id_cliente = ?, id_usuario = ?, fch_modificacion = ? WHERE id_telefono = ?";
    
    
    
//SENTENCIAS ADELANTOS:
        
    const BUSCAR_ADELANTOS = "SELECT * FROM adelanto INNER JOIN usuario ON adelanto.`id_usuario`=usuario.`id_usuario` INNER JOIN caso ON adelanto.`id_caso`=caso.`id_caso` INNER JOIN cliente ON caso.`id_cliente`=cliente.`id_cliente` WHERE adelanto.fch_baja = '0000-00-00 00:00:00' LOCK IN SHARE MODE";
    
    const ELIMINAR_ADELANTO = "UPDATE adelanto SET fch_baja = ? WHERE id_adelanto = ?";
    
    const INSERTAR_ADELANTO = "INSERT INTO adelanto(detalle_adelanto, fecha_adelanto, monto_adelanto, id_caso, id_usuario, fch_creacion, fch_modificacion, fch_baja) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    const BUSCAR_ULTIMO_ADELANTO = "SELECT MAX(id_adelanto) FROM adelanto LOCK IN SHARE MODE";
    
    const BUSCAR_ADELANTOS_ID = "SELECT * FROM adelanto INNER JOIN usuario ON adelanto.`id_usuario`=usuario.`id_usuario` INNER JOIN caso ON adelanto.`id_caso`=caso.`id_caso` INNER JOIN cliente ON caso.`id_cliente`=cliente.`id_cliente` WHERE id_adelanto = ? LOCK IN SHARE MODE";
    
    const MODIFICAR_ADELANTO = "UPDATE adelanto SET detalle_adelanto = ?, fecha_adelanto = ?, monto_adelanto = ?, id_caso = ?, fch_modificacion = ? WHERE id_adelanto = ?";
    
//SENTENCIAS COBROS:
    
    const BUSCAR_COBROS = "SELECT * FROM cobro INNER JOIN usuario ON cobro.`id_usuario`=usuario.`id_usuario` INNER JOIN caso ON cobro.`id_caso`=caso.`id_caso`INNER JOIN cliente ON caso.`id_cliente`=cliente.`id_cliente` WHERE cobro.fch_baja = '0000-00-00 00:00:00' LOCK IN SHARE MODE";
    
    const ELIMINAR_COBRO = "UPDATE cobro SET fch_baja = ? WHERE id_cobro = ?";
    
    const INSERTAR_COBRO = "INSERT INTO cobro(detalle_cobro, fecha_cobro, monto_cobro, id_caso, id_usuario, fch_creacion, fch_modificacion, fch_baja) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    const BUSCAR_ULTIMO_COBRO = "SELECT MAX(id_cobro) FROM cobro LOCK IN SHARE MODE";
    
    const BUSCAR_COBROS_ID = "SELECT * FROM cobro INNER JOIN usuario ON cobro.`id_usuario`=usuario.`id_usuario` INNER JOIN caso ON cobro.`id_caso`=caso.`id_caso` INNER JOIN cliente ON caso.`id_cliente`=cliente.`id_cliente` WHERE id_cobro = ? LOCK IN SHARE MODE";
    
    const MODIFICAR_COBRO = "UPDATE cobro SET detalle_cobro = ?, fecha_cobro = ?, monto_cobro = ?, id_caso = ?, fch_modificacion = ? WHERE id_cobro = ?";
    
    
    
// ASISTENTES
    const BUSCAR_ASISTENTES="SELECT asistente.id_asistente,asistente.nombre_asistente, asistente.apellido_asistente, asistente.fch_creacion, asistente.fch_modificacion, usuario.nombre_usuario, usuario.apellido_usuario 
                                FROM asistente 
                                INNER JOIN usuario  ON asistente.id_usuario=usuario.id_usuario 
                                WHERE asistente.fch_baja= '0000-00-00 00:00:00' LOCK IN SHARE MODE";
    const ELIMINAR_ASISTENTE="UPDATE asistente SET fch_baja = ? WHERE id_asistente=?";
    const INSERTAR_ASISTENTE="INSERT INTO asistente(nombre_asistente,apellido_asistente,id_usuario,fch_creacion,fch_modificacion,fch_baja) VALUES (?,?,?,?,?,?)";
    const BUSCAR_ULTIMO_ASISTENTE="SELECT MAX(id_asistente) FROM asistente LOCK IN SHARE MODE";
    const BUSCAR_ASISTENTES_ID="SELECT asistente.id_asistente,asistente.nombre_asistente, asistente.apellido_asistente, asistente.fch_creacion, asistente.fch_modificacion, usuario.nombre_usuario, usuario.apellido_usuario 
                                FROM asistente 
                                INNER JOIN usuario  ON asistente.id_usuario=usuario.id_usuario 
                                WHERE asistente.id_asistente= ? LOCK IN SHARE MODE";
    const MODIFICAR_ASISTENTE="UPDATE asistente SET nombre_asistente=?, apellido_asistente=?, id_usuario=?,fch_creacion=?, fch_modificacion=?,fch_baja=? WHERE id_asistente=?";
    
    
//USUARIOS
    const BUSCAR_NOMBRE_USUARIO = "SELECT * FROM usuario WHERE fch_baja = '0000-00-00 00:00:00' AND id_usuario = ? LOCK IN SHARE MODE";
    const CHECK_USER = "SELECT * FROM usuario WHERE usuario_usuario = ? LOCK IN SHARE MODE";
    const BUSCAR_USUARIOS="SELECT usuario.id_usuario,usuario.nombre_usuario, usuario.apellido_usuario,usuario.usuario_usuario,usuario.clave_usuario,usuario.tipoAcceso_usuario, usuario.fch_creacion, usuario.fch_modificacion, usuario.nombre_usuario, usuario.apellido_usuario FROM usuario WHERE usuario.fch_baja= '0000-00-00 00:00:00' LOCK IN SHARE MODE";
    const ELIMINAR_USUARIO="UPDATE usuario SET fch_baja = ? WHERE id_usuario=?";
    const INSERTAR_USUARIO="INSERT INTO usuario(nombre_usuario,apellido_usuario,usuario_usuario,clave_usuario,tipoAcceso_usuario,fch_creacion,fch_modificacion,fch_baja) VALUES (?,?,?,?,?,?,?,?)";
    const BUSCAR_USUARIO_ID="SELECT nombre_usuario,apellido_usuario, usuario_usuario,tipoAcceso_usuario,fch_creacion,fch_modificacion FROM usuario WHERE id_usuario=? LOCK IN SHARE MODE";
    const BUSCAR_ULTIMO_USUARIO="SELECT MAX(id_usuario) FROM usuario";
    const MODIFICAR_USUARIO="UPDATE usuario SET nombre_usuario=?, apellido_usuario=?, usuario_usuario=?,tipoAcceso_usuario=?, fch_modificacion=?,fch_baja=? WHERE id_usuario=?";
    const MODIFICAR_USUARIO_CLAVE="UPDATE usuario SET clave_usuario = ?, fch_modificacion = ? WHERE id_usuario=? ";
//PROFESIONALES
    
    const BUSCAR_PROFESIONALES="SELECT profesional.id_profesional,profesional.nombre_profesional, profesional.apellido_profesional,profesional.titulo_profesional,profesional.matricula_profesional, profesional.fch_creacion, profesional.fch_modificacion, usuario.nombre_usuario, usuario.apellido_usuario 
                                FROM profesional 
                                INNER JOIN usuario  ON profesional.id_usuario=usuario.id_usuario 
                                WHERE profesional.fch_baja= '0000-00-00 00:00:00' LOCK IN SHARE MODE";
    const INSERTAR_PROFESIONAL="INSERT INTO profesional(nombre_profesional,apellido_profesional,titulo_profesional,matricula_profesional,id_usuario,fch_creacion,fch_modificacion,fch_baja) VALUES (?,?,?,?,?,?,?,?)";
    const ELIMINAR_PROFESIONAL="UPDATE profesional SET fch_baja = ? WHERE id_profesional=?";
    const BUSCAR_PROFESIONALES_ID=" SELECT *
                                        FROM profesional 
                                        INNER JOIN usuario  ON profesional.id_usuario=usuario.id_usuario 
                                        WHERE profesional.id_profesional= ? LOCK IN SHARE MODE";
    const MODIFICAR_PROFESIONAL="UPDATE profesional SET nombre_profesional=?, apellido_profesional=?, titulo_profesional=?,matricula_profesional=?,id_usuario=?,fch_creacion=?, fch_modificacion=?,fch_baja=? WHERE id_profesional=?";
    CONST BUSCAR_ULTIMO_PROFESIONAL="SELECT MAX(id_profesional) FROM profesional WHERE fch_baja='0000-00-00 00:00:00'";
    
//TELEFONOS    
    
    const ELIMINAR_TELEFONO = "UPDATE telefono SET fch_baja = ? WHERE id_telefono = ?";
    const INSERTAR_TELEFONO = "INSERT INTO telefono(numero_telefono, propietario_telefono, detalle_telefono,
             id_cliente, id_usuario, fch_creacion) VALUES(?,?,?,?,?,?)";
    const ACTUALIZAR_TELEFONO = "UPDATE telefono SET numero_telefono = ?, propietario_telefono = ?, detalle_telefono = ?
        , id_cliente = ?, id_usuario = ?,fch_modificacion = ? WHERE id_telefono = ?";
    const ULTIMO_TELEFONO = "SELECT MAX(id_telefono) FROM telefono WHERE fch_baja = '0000-00-00 00:00:00' LOCK IN SHARE MODE";
    const BUSCAR_UN_TELEFONO = "SELECT * FROM telefono INNER JOIN cliente ON telefono.id_cliente = cliente.id_cliente WHERE telefono.fch_baja = '0000-00-00 00:00:00' AND id_telefono = ? LOCK IN SHARE MODE";
    const BUSCAR_TELEFONO_ID ="SELECT * FROM telefono WHERE id_telefono = ?"; 
    const BUSCAR_TELEFONOS_US = "SELECT * FROM telefono INNER JOIN cliente ON telefono.id_cliente = cliente.id_cliente 
            INNER JOIN usuario ON telefono.id_usuario = usuario.id_usuario WHERE telefono.fch_baja = '0000-00-00 00:00:00' LOCK IN SHARE MODE";
    
    
        //SENTENCIAS PAGOS:
    
    const BUSCAR_PAGOS = "SELECT * FROM pago INNER JOIN usuario ON pago.`id_usuario`=usuario.`id_usuario` INNER JOIN caso ON pago.`id_caso`=caso.`id_caso` INNER JOIN cliente ON caso.`id_cliente`=cliente.`id_cliente` INNER JOIN asistente ON caso.`id_asistente`=asistente.`id_asistente` WHERE pago.fch_baja = '0000-00-00 00:00:00' LOCK IN SHARE MODE";
    
    const ELIMINAR_PAGO = "UPDATE pago SET fch_baja = ? WHERE id_pago = ?";
    
    const INSERTAR_PAGO = "INSERT INTO pago(detalle_pago, fecha_pago, monto_pago, id_caso, id_usuario, fch_creacion, fch_modificacion, fch_baja) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    const BUSCAR_ULTIMO_PAGO = "SELECT MAX(id_pago) FROM pago LOCK IN SHARE MODE";
    
    const BUSCAR_PAGOS_ID = "SELECT * FROM pago INNER JOIN usuario ON pago.`id_usuario`=usuario.`id_usuario` 
            INNER JOIN caso ON pago.`id_caso`=caso.`id_caso` INNER JOIN asistente ON 
            caso.`id_asistente`=asistente.`id_asistente` INNER JOIN cliente ON caso.id_cliente = cliente.id_cliente
            WHERE id_pago = ? LOCK IN SHARE MODE";
    
    const MODIFICAR_PAGO = "UPDATE pago SET detalle_pago = ?, fecha_pago = ?, monto_pago = ?, id_caso = ?, fch_modificacion = ? WHERE id_pago = ?";
}
