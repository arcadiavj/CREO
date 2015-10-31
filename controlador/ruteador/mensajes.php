<?php
//debe devolver todos los turnos jsoneados
require_once '../persistencia/ControladorPersistencia.php'; 
$cp = new ControladorPersistencia();
$rta = $cp->ejecutarSentencia(DBSentencias::ULTIMOS_TURNOS);//BUSCAR_TURNOS_ACTUALES
$turnos = $rta->fetchAll(PDO::FETCH_ASSOC);
//var_dump($turnos);
//clearstatcache();
echo json_encode($turnos);

?>