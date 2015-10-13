<?php
require_once 'ControladorGeneral.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorArt
 *
 * @author Flaco
 */
class ControladorArt extends ControladorGeneral{
    public function guardar($datosCampos) {
        session_start();
        $idUser = $_SESSION["id_usuario"];
        $fecha = time() - (5 * 60 * 60); // le resto 5 horas a la fecha para que me dé la hora argentina
        $fechaActual = date('Y-m-d H:i:s',$fecha);
        if($datosCampos['id_art'] == 0) { // si id=0 entonces es agregar
            try {
                $this->refControladorPersistencia->get_conexion()->beginTransaction();  //comienza la transacción
                $paramArt = ["nombre_art"=>$datosCampos["nombre"], "direccion_art"=>$datosCampos["direccion"],
                    "detalle_art"=>$datosCampos["detalle"],"id_usuario"=>$idUser,"fch_creacion"=>$fechaActual];
                $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::INSERTAR_ART, $paramArt);
                $idArt = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ULTIMA_ART);
                $id = $idArt->fetchColumn();
                $this->refControladorPersistencia->get_conexion()->commit();  //si todo salió bien hace el commit
            }catch (PDOException $excepcionPDO) {
                echo "<br>Error PDO: ".$excepcionPDO->getTraceAsString().'<br>';
                $this->refControladorPersistencia->get_conexion()->rollBack();//si salio mal hace un rollback
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
                $this->refControladorPersistencia->get_conexion()->rollBack();  //si hay algún error hace rollback
            }
        } else { //si entra acá es para modificar
            try {
                $this->refControladorPersistencia->get_conexion()->beginTransaction();  //comienza la transacción
                $paramArt = ["nombre_art"=>$datosCampos["nombre"], "direccion_art"=>$datosCampos["direccion"],
                    "detalle_art"=>$datosCampos["detalle"],"id_usuario"=>$idUser,"fch_modificacion"=>$fechaActual, "id_art"=>$datosCampos["id_art"]];
                $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ACTUALIZAR_ART, $paramArt);
                $id = $datosCampos["id_art"];
                $this->refControladorPersistencia->get_conexion()->commit();  //si todo salió bien hace el commit            
            }catch (PDOException $excepcionPDO) {
                echo "<br>Error PDO: ".$excepcionPDO->getTraceAsString().'<br>';
                $this->refControladorPersistencia->get_conexion()->rollBack();//si salio mal hace un rollback
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
                $this->refControladorPersistencia->get_conexion()->rollBack();  //si hay algún error hace rollback
            }
        }
        $respuesta = $this->getArt($id);
        return $respuesta;
    }

    public function buscar() {
        try {
            $this->refControladorPersistencia->get_conexion()->beginTransaction();  //comienza la transacción
            $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_ARTS);
            $arrayArts = $statement->fetchAll(PDO::FETCH_ASSOC);
            $this->refControladorPersistencia->get_conexion()->commit(); //si todo salió bien hace el commit
            return $arrayArts;
        }catch (PDOException $excepcionPDO) {
            echo "<br>Error PDO: ".$excepcionPDO->getTraceAsString().'<br>';
            $this->refControladorPersistencia->get_conexion()->rollBack();//si salio mal hace un rollback
        }catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->refControladorPersistencia->get_conexion()->rollBack();//si salio mal hace un rollback
        }
    }

    public function eliminar($id) {
        try {
            $this->refControladorPersistencia->get_conexion()->beginTransaction();  //comienza la transacción
            $fecha=time() - (5 * 60 * 60); // le resto 5 horas a la fecha para que me dé la hora argentina
            $fechaRestada=date('Y-m-d H:i:s',$fecha);
            $arrayArt = ["fch_baja"=>$fechaRestada, "id_art"=>$id];
            $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ELIMINAR_ART, $arrayArt);
            $this->refControladorPersistencia->get_conexion()->commit(); //si todo salió bien hace el commit
            return $arrayArt;
        }catch (PDOException $excepcionPDO) {
            echo "<br>Error PDO: ".$excepcionPDO->getTraceAsString().'<br>';
            $this->refControladorPersistencia->get_conexion()->rollBack();//si salio mal hace un rollback
        }catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->refControladorPersistencia->get_conexion()->rollBack();//si salio mal hace un rollback
        }
    }

    public function modificar($datosCampos) {
        
    }

    public function agregar($datosCampos) {
        
    }
    public function getArt($id) {
        try {
            $this->refControladorPersistencia->get_conexion()->beginTransaction();  //comienza la transacción
            $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UNA_ART,array($id));
            $art = $statement->fetch();
            $this->refControladorPersistencia->get_conexion()->commit();  //si todo salió bien hace el commit            
        }catch (PDOException $excepcionPDO) {
            echo "<br>Error PDO: ".$excepcionPDO->getTraceAsString().'<br>';
            $this->refControladorPersistencia->get_conexion()->rollBack();//si salio mal hace un rollback
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->refControladorPersistencia->get_conexion()->rollBack();  //si hay algún error hace rollback
        }
        return $art;
    }
}
