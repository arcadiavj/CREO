<?php
require_once 'ControladorGeneral.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorEspecialidad
 *
 * @author Flaco
 */
class ControladorEspecialidad extends ControladorGeneral{
    public function guardar($datosCampos) {
        session_start();
        $idUser = $_SESSION["id_usuario"];
        $fecha = time() - (5 * 60 * 60); // le resto 5 horas a la fecha para que me dé la hora argentina
        $fechaActual = date('Y-m-d',$fecha);
        if($datosCampos['id_especialidad'] == 0) { // si id=0 entonces es agregar
            try {
                $this->refControladorPersistencia->get_conexion()->beginTransaction();  //comienza la transacción
                $paramEspecialidad = ["descripcion_especialidad"=>$datosCampos["descripcion"],
                    "fch_creacion"=>$fechaActual];
                //var_dump($paramEspecialidad);
                $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::INSERTAR_ESPECIALIDAD, $paramEspecialidad);
                $idEspecialidad = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ULTIMA_ESPECIALIDAD);
                $id = $idEspecialidad->fetchColumn();
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
                $paramEspec = ["descripcion_especialidad"=>$datosCampos["descripcion"],
                    "fch_modificacion"=>$fechaActual, "id_especialidad"=>$datosCampos["id_especialidad"]];
                //var_dump($paramEspec);
                $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ACTUALIZAR_ESPECIALIDAD, $paramEspec);
                $id = $datosCampos["id_especialidad"];
                $this->refControladorPersistencia->get_conexion()->commit();  //si todo salió bien hace el commit            
            }catch (PDOException $excepcionPDO) {
                echo "<br>Error PDO: ".$excepcionPDO->getTraceAsString().'<br>';
                $this->refControladorPersistencia->get_conexion()->rollBack();//si salio mal hace un rollback
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
                $this->refControladorPersistencia->get_conexion()->rollBack();  //si hay algún error hace rollback
            }
        }
        $respuesta = $this->getEspecialidad($id);
        return $respuesta;
    }

    public function buscar() {
        try {
            $this->refControladorPersistencia->get_conexion()->beginTransaction();  //comienza la transacción
            $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_ESPECIALIDADES);
            $arrayEspecs = $statement->fetchAll(PDO::FETCH_ASSOC);
            $this->refControladorPersistencia->get_conexion()->commit(); //si todo salió bien hace el commit
            return $arrayEspecs;
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
            $fechaRestada=date('Y-m-d',$fecha);
            $arrayEspecialidad = ["fch_baja"=>$fechaRestada, "id_especialidad"=>$id];
            $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ELIMINAR_ESPECIALIDAD, $arrayEspecialidad);
            $this->refControladorPersistencia->get_conexion()->commit(); //si todo salió bien hace el commit
            return $arrayEspecialidad;
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
    public function getEspecialidad($id) {
        try {
            $this->refControladorPersistencia->get_conexion()->beginTransaction();  //comienza la transacción
            $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UNA_ESPECIALIDAD,array($id));
            $especialidad = $statement->fetch();
            $this->refControladorPersistencia->get_conexion()->commit();  //si todo salió bien hace el commit            
        }catch (PDOException $excepcionPDO) {
            echo "<br>Error PDO: ".$excepcionPDO->getTraceAsString().'<br>';
            $this->refControladorPersistencia->get_conexion()->rollBack();//si salio mal hace un rollback
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->refControladorPersistencia->get_conexion()->rollBack();  //si hay algún error hace rollback
        }
        return $especialidad;
    }
}
