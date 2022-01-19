<?php

date_default_timezone_set('America/Guayaquil');
$date = date('Ymd', time());
require("toConn.php");
//Gather variables
$token = trimVar(trim($_REQUEST["token"]));
$id = trimVar(trim($_REQUEST["id"]));
$fecha = trimVar(trim($_REQUEST["fecha"]));
$returnValue = array();
//Validations
if ($token == "") { //empty($email) || empty($password) || 
    $returnValue["status"] = "failure";
    $returnValue["message"] = "Por favor inicie sesión";
    echo json_encode($returnValue);
    return;
}

//Evaluate for valid session
$respuesta = query("select email from usuario where token = '$token'");
if ($respuesta != "failure") {
//Execute query
    $respuesta = "update transaccion set fechaHora = '$fecha' where id = $id;";
    $respuesta = crudQuery($respuesta);
} else {
    $returnValue["status"] = "failure";
    $returnValue["message"] = "Sesion inválida";
    echo json_encode($returnValue);
    return;
}
//Evaluate results
if ($respuesta == "failure") {
    $returnValue["status"] = "failure";
    $returnValue["message"] = "No tiene registros para mostrar.";
} else {
    $returnValue["status"] = "success";
    $returnValue["message"] = "Éxito, por favor continue en reservas";
}
//Return results
echo json_encode($returnValue);
?>
