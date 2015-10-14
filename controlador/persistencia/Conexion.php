<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Conexion
 *
 * @author Flaco
 */
class Conexion {
    private $_conexion = null;
    private $_usuario = 'root';
    private $_clave = 'root';
    public function __construct() {
        try {
            //estoy probando este PDO con utf8
            $this->_conexion = new PDO("mysql:dbname=dbcreo;host=localhost", $this->_usuario, $this->_clave, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\'')); 
            //el anterior PDO era el que sigue
            //$this->_conexion = new PDO("mysql:dbname=pracprof;host=localhost", $this->_usuario, $this->_clave); 
            $this->_conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //ANTE ERROR, LANZA UNA EXCEPCION
        } catch (PDOException $e) {
            file_put_contents("log/dberror.log", "Date: " . date('M j Y - G:i:s') . " ---- Error: " . $e->getMessage().PHP_EOL, FILE_APPEND);
            die($e->getMessage()); // Log and display error in the event that there is an issue connecting
        }
        //$pdo = new PDO('mysql:host= servidor; dbname=bd', $usuario, $clave, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''))
    }
    /**
     * 
     * @return PDO
     */
    public function getConexion() { 
        return $this->_conexion;
    }
    
    public function __destruct() {
        try {
            $this->_conexion=null; //Closes connection
        } catch (PDOException $e) {
            file_put_contents("log/dberror.log", "Fecha: " . date('M j Y - G:i:s') . " ---- Error: " . $e->getMessage().PHP_EOL, FILE_APPEND);
            die($e->getMessage());
        }
        
        
    }
}
