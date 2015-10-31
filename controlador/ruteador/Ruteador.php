<?php
if (isset($_GET['accion']) && isset($_GET['nombreFormulario'])) {
    $accion = $_GET['accion'];
    $nombreformulario = $_GET['nombreFormulario'];
}else if (isset ($_POST['accion'])){
    $accion = $_POST['accion'];
    $datosCampos = $_REQUEST;
    $nombreformulario = $datosCampos['nombreFormulario'];
}else if(isset ($_POST['user']) && isset($_POST['pass'])){
    $accion = "guardar";
    $nombreformulario = "Usuario";
    $datosCampos = ["user"=>$_POST['user'], "pass"=>$_POST['pass']];
}
if (isset($_POST['fch_llegada_turno'])) {
    $fecha_llegada = $_POST['fch_llegada_turno'];
}
if (isset($_GET['id'])) {
    $id=$_GET['id'];
}
//CAMBIOS EN EL RUTEADOR POR FLACO
if (isset($_GET['idCliente'])) {
    $idCliente=$_GET['idCliente'];
}
if (isset($_GET['idCaso'])) {
    $idCaso=$_GET['idCaso'];
}
if (isset($_GET['tipoLlamada'])) {
    $tipoLlamada=$_GET['tipoLlamada'];
}
//FIN DE CAMBIOS EN EL RUTEADOR POR FLACO
require_once '../controladoresEspecificos/Controlador'.$nombreformulario.'.php'; //hago el include del controlador corresp
$nombreControlador = "Controlador".$nombreformulario; //meto en una variable el nombre del controlador corresp
$objControlador = new $nombreControlador(); //instancio
switch ($accion) {
    case "actualizar":
        $resultado = $objControlador->$accion($fecha_llegada); //llamo a la acción
        echo json_encode($resultado);//arreglo json
        break;
    case "eliminar":
        $resultado = $objControlador->$accion($id); //llamo a la acción
        echo json_encode($resultado);//arreglo json
        break;
    //INICIO CAMBIOS EN RUTEADOR POR FLACO
    case "buscarLlamadas":
        $resultado = $objControlador->$accion($tipoLlamada); //llamo a la acción
        echo json_encode($resultado);//arreglo json
        break;
    //FINAL CAMBIOS EN RUTEADOR POR FLACO
    case "buscar":
        $resultado = $objControlador->$accion(); //llamo a la acción
        echo json_encode($resultado);//arreglo json
        break;
    case "guardar":
        $datosCampos=$_REQUEST;
        $resultado = $objControlador->$accion($datosCampos); //llamo a la acción
        echo json_encode($resultado);//arreglo json
        break;
    //CAMBIOS EN EL RUTEADOR POR FLACO 
    case "buscarUno":
        $resultado = $objControlador->$accion($idCaso); //llamo a la acción
        echo json_encode($resultado);//arreglo json
        break;
    case "buscarTelsDeUnCliente":
        $resultado = $objControlador->$accion($idCliente); //llamo a la acción
        echo json_encode($resultado);//arreglo json
        break;
    case "cambiarClave":
        $resultado = $objControlador->$accion($idCliente); //llamo a la acción
        echo json_encode($resultado);//arreglo json
        break;
    //FIN CAMBIOS EN EL RUTEADOR POR FLACO
    //comienzo cambios diego
    case "modificar":
        //$datosCampos = $_REQUEST;
        $resultado = $objControlador->$accion($datosCampos); //llamo a la acción
        echo json_encode($resultado);//arreglo json
        break; //final cambio diego
    case "buscarX":
        $datos = ["criterio"=>$criterio, "valor"=>$valor];
        $resultado = $objControlador->$accion($datos); //llamo a la acción
        echo json_encode($resultado);//arreglo json
        break;
    default:
        break;
}