<?php
require_once 'ControladorGeneral.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorSalidaTV
 *
 * @author Flaco
 */
class ControladorSalidaTV extends ControladorGeneral{
    public function actualizar($fecha_llegada) {
        session_start();
        $fecha = time(); 
        $fechaActual = date('Y-m-d H:i:s',$fecha);
        try {
            $this->refControladorPersistencia->get_conexion()->beginTransaction();  //comienza la transacción
            $turnos = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ULTIMO_TURNO);
            $turnosArray = $turnos->fetchAll(PDO::FETCH_ASSOC);
            $this->refControladorPersistencia->get_conexion()->commit();  //si todo salió bien hace el commit
            //var_dump($turnosArray);
//            echo $turnosArray[0]["fch_llegada_turno"].' ACAAAAA<br>';
//            while ($turnosArray[0]["fch_llegada_turno"]<=$fecha_llegada) {
//                $this->refControladorPersistencia->get_conexion()->beginTransaction();  //comienza la transacción
//                $turnos2 = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ULTIMO_TURNO);
//                $turnosArray2 = $turnos2->fetchAll(PDO::FETCH_ASSOC);
//                $this->refControladorPersistencia->get_conexion()->commit();
//                usleep(100000);//anteriormente 10000
//                clearstatcache();
//                $fecha_bd  = strtotime($turnosArray2[0]["fch_llegada_turno"]);
//            }
            usleep(10000000);
            clearstatcache();
            return $turnosArray;
        }catch (PDOException $excepcionPDO) {
            echo "<br>Error PDO: ".$excepcionPDO->getTraceAsString().'<br>';
            $this->refControladorPersistencia->get_conexion()->rollBack();//si salio mal hace un rollback
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->refControladorPersistencia->get_conexion()->rollBack();  //si hay algún error hace rollback
        }
    }
    public function guardar($datosCampos) {
//        session_start();
//        $idUser = $_SESSION["id_usuario"];
//        $fecha = time() - (5 * 60 * 60); // le resto 5 horas a la fecha para que me dé la hora argentina
//        $fechaActual = date('Y-m-d',$fecha);
//        if($datosCampos['id_consultorio'] == 0) { // si id=0 entonces es agregar
//            try {
//                $this->refControladorPersistencia->get_conexion()->beginTransaction();  //comienza la transacción
//                $paramConsultorio = ["descripcion_consultorio"=>$datosCampos["descripcion"],
//                    "fch_creacion"=>$fechaActual];
//                //var_dump($paramEspecialidad);
//                $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::INSERTAR_CONSULTORIO, $paramConsultorio);
//                $idConsultorio = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ULTIMO_CONSULTORIO);
//                $id = $idConsultorio->fetchColumn();
//                $this->refControladorPersistencia->get_conexion()->commit();  //si todo salió bien hace el commit
//            }catch (PDOException $excepcionPDO) {
//                echo "<br>Error PDO: ".$excepcionPDO->getTraceAsString().'<br>';
//                $this->refControladorPersistencia->get_conexion()->rollBack();//si salio mal hace un rollback
//            } catch (Exception $exc) {
//                echo $exc->getTraceAsString();
//                $this->refControladorPersistencia->get_conexion()->rollBack();  //si hay algún error hace rollback
//            }
//        } else { //si entra acá es para modificar
//            try {
//                $this->refControladorPersistencia->get_conexion()->beginTransaction();  //comienza la transacción
//                $paramConsul = ["descripcion_consultorio"=>$datosCampos["descripcion"],
//                    "fch_modificacion"=>$fechaActual, "id_consultorio"=>$datosCampos["id_consultorio"]];
//                //var_dump($paramConsul);
//                $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ACTUALIZAR_CONSULTORIO, $paramConsul);
//                $id = $datosCampos["id_consultorio"];
//                $this->refControladorPersistencia->get_conexion()->commit();  //si todo salió bien hace el commit            
//            }catch (PDOException $excepcionPDO) {
//                echo "<br>Error PDO: ".$excepcionPDO->getTraceAsString().'<br>';
//                $this->refControladorPersistencia->get_conexion()->rollBack();//si salio mal hace un rollback
//            } catch (Exception $exc) {
//                echo $exc->getTraceAsString();
//                $this->refControladorPersistencia->get_conexion()->rollBack();  //si hay algún error hace rollback
//            }
//        }
//        $respuesta = $this->getConsultorio($id);
//        return $respuesta;
    }

    public function buscar() {
//        try {
//            $this->refControladorPersistencia->get_conexion()->beginTransaction();  //comienza la transacción
//            $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_TURNOS);
//            $arrayTurno = $statement->fetchAll(PDO::FETCH_ASSOC);
//            $this->refControladorPersistencia->get_conexion()->commit(); //si todo salió bien hace el commit
//            return $arrayTurno;
//        }catch (PDOException $excepcionPDO) {
//            echo "<br>Error PDO: ".$excepcionPDO->getTraceAsString().'<br>';
//            $this->refControladorPersistencia->get_conexion()->rollBack();//si salio mal hace un rollback
//        }catch (Exception $exc) {
//            echo $exc->getTraceAsString();
//            $this->refControladorPersistencia->get_conexion()->rollBack();//si salio mal hace un rollback
//        }
    }

    public function eliminar($id) {
//        try {
//            $this->refControladorPersistencia->get_conexion()->beginTransaction();  //comienza la transacción
//            $fecha=time() - (5 * 60 * 60); // le resto 5 horas a la fecha para que me dé la hora argentina
//            $fechaRestada=date('Y-m-d',$fecha);
//            $arrayConsultorios = ["fch_baja"=>$fechaRestada, "id_consultorio"=>$id];
//            $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::ELIMINAR_CONSULTORIO, $arrayConsultorios);
//            $this->refControladorPersistencia->get_conexion()->commit(); //si todo salió bien hace el commit
//            return $arrayConsultorios;
//        }catch (PDOException $excepcionPDO) {
//            echo "<br>Error PDO: ".$excepcionPDO->getTraceAsString().'<br>';
//            $this->refControladorPersistencia->get_conexion()->rollBack();//si salio mal hace un rollback
//        }catch (Exception $exc) {
//            echo $exc->getTraceAsString();
//            $this->refControladorPersistencia->get_conexion()->rollBack();//si salio mal hace un rollback
//        }
    }

    public function modificar($datosCampos) {
        
    }

    public function agregar($datosCampos) {
        
    }
    public function getConsultorio($id) {
//        try {
//            $this->refControladorPersistencia->get_conexion()->beginTransaction();  //comienza la transacción
//            $statement = $this->refControladorPersistencia->ejecutarSentencia(DBSentencias::BUSCAR_UN_CONSULTORIO,array($id));
//            $consultorio = $statement->fetch();
//            $this->refControladorPersistencia->get_conexion()->commit();  //si todo salió bien hace el commit            
//        }catch (PDOException $excepcionPDO) {
//            echo "<br>Error PDO: ".$excepcionPDO->getTraceAsString().'<br>';
//            $this->refControladorPersistencia->get_conexion()->rollBack();//si salio mal hace un rollback
//        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
//            $this->refControladorPersistencia->get_conexion()->rollBack();  //si hay algún error hace rollback
//        }
//        return $consultorio;
    }
}
