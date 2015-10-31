<?php
require '../persistencia/ControladorPersistencia.php'; 

set_time_limit(0); //Establece el número de segundos que se permite la ejecución de un script.
$cp = new ControladorPersistencia();
$rta = $cp->ejecutarSentencia(DBSentencias::BUSCAR_TURNOS_ACTUALES);
$turnos = $rta->fetchAll(PDO::FETCH_BOTH);


$fecha_ac = isset($_GET['fch_llegada_turno']) ? $_GET['fch_llegada_turno']:0;

/*
$querytime =  mysql_query("SELECT MAX(timestamp) FROM mensajes ORDER BY timestamp DESC LIMIT 1");
$fecha_bd = $querytime;
 */
$fecha_bd = $_GET['fch_llegada_turno'];
//while( $fecha_bd <= $fecha_ac )
//	{	
//            $cp = new ControladorPersistencia();
//            $rta2 = $cp->ejecutarSentencia(DBSentencias::ULTIMO_TURNO2);
////            $fecha_lleg = $rta2->fetchColumn(5);
////            ECHO $fecha_lleg;           
//    echo 'llegue';
//            usleep(100000);//anteriormente 10000
//            //clearstatcache();
//            $fecha_bd  ="2020-01-01 10:00:00"; //strtotime($fecha_lleg);
//	}

$cp = new ControladorPersistencia();
$rta = $cp->ejecutarSentencia(DBSentencias::BUSCAR_TURNOS_ACTUALES);
$tur = $rta->fetchAll(PDO::FETCH_ASSOC);
$ar = [];
for ($index = 0; $index < count($tur); $index++) {
    foreach ($tur[$index] as $key => $value) {
        array_push($ar, $key,$value);
    }
}

$dato_json   = json_encode($ar);
echo $dato_json;





























//set_time_limit(0); //Establece el número de segundos que se permite la ejecución de un script.
//$fecha_ac = isset($_GET['fch_llegada_turno']) ? $_GET['fch_llegada_turno']:0;
//$fecha_bd = "";
//var_dump($turnos);
//for ($index = 0; $index < count($turnos); $index++) {
//    foreach ($turnos[$index] as $key => $value) {
//        if (strcmp($key, 'fch_llegada_turno')==0) {
//            $fecha_bd = $value;
//        }
//    }
//}
//echo $fecha_bd;
/*
$querytime =  mysql_query("SELECT MAX(timestamp) FROM mensajes ORDER BY timestamp DESC LIMIT 1");
$fecha_bd = $querytime;
 */
//$fecha_bd = $_GET['timestamp'];
//while( $fecha_bd <= $fecha_ac )
//	{	
//            
////		$query3    = "SELECT timestamp FROM mensajes ORDER BY timestamp DESC LIMIT 1";
////		$con       = mysql_query($query3 );
////		$ro        = mysql_fetch_array($con);
//		usleep(100000);//anteriormente 10000
//		clearstatcache();
//		$fecha_bd  = strtotime($ro['timestamp']);
//	}
//
//$query       = "SELECT * FROM mensajes ORDER BY timestamp DESC LIMIT 1";
//$datos_query = mysql_query($query);
//while($row = mysql_fetch_array($datos_query))
//{
//	$ar["timestamp"]          = strtotime($row['timestamp']);	
//	$ar["mensaje"] 	 		  = $row['mensaje'];	
//	$ar["id"] 		          = $row['id'];	
//	$ar["status"]           = $row['status'];	
//	$ar["tipo"]           = $row['tipo'];	
//}
//$dato_json   = json_encode($ar);
//echo $dato_json;
?>