<?php

date_default_timezone_set('America/Guayaquil');
$date = date('Ymd', time());
require("toConn.php");
//Gather variables
$token = trimVar(trim($_REQUEST["token"]));
$nombres = trimVar(trim($_REQUEST["nombres"]));
$apellidos = trimVar(trim($_REQUEST["apellidos"]));
$email = trimVar(trim($_REQUEST["email"]));
$cedula = trimVar(trim($_REQUEST["cedula"]));
$returnValue = array();
//Validations
if ($email == "") { //empty($email) || empty($password) || 
    $returnValue["status"] = "failure";
    $returnValue["message"] = "Por favor llene los campos solicitados";
    echo json_encode($returnValue);
    return;
}

//Evaluate for duplicates
$respuesta = query("select email from usuario where email = '$email' and token <> '$token'");
if ($respuesta == "failure") {
//Prepare and execute query
    $respuesta = crudQuery("update usuario set ruc='$cedula',email='$email',nombres='$nombres',apellidos='$apellidos' where token='$token'");
//    $respuestaJson = json_decode($respuesta);
//    if($respuestaJson["status"]=="failure"){
//        $respuesta = "failure";
//    }
} else {
    $respuesta = "failure";
}
//Evaluate results
if ($respuesta == "failure") {
    $returnValue["status"] = "failure";
    $returnValue["message"] = "Datos incorrectos, email o cedula ya existe en otro usuario registrado";
} else {
    $returnValue["status"] = "success";
    $returnValue["message"] = "Datos actualizados" . $respuesta;
}
//Return results
echo json_encode($returnValue);
?>