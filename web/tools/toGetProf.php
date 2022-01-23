<?php

date_default_timezone_set('America/Guayaquil');
$date = date('Ymd', time());
require("toConn.php");
//Gather variables
$token = trimVar(trim($_REQUEST["token"])); //htmlentities($_POST["email"]));
$returnValue = array();
//Validations
if ($token == "" ) { //empty($email) || empty($password) || 
    $returnValue["status"] = "failure";
    $returnValue["message"] = "Por favor inicie sesión";
    echo json_encode($returnValue);
    return;
}

//Evaluate for duplicates
$respuesta = query("select ruc,email,nombres, apellidos, saldo from usuario where token = '$token'");

//Evaluate results
if ($respuesta == "failure") {
    $returnValue["status"] = "failure";
    $returnValue["message"] = "Usuario existente o no válido";
} else {
    $returnValue["status"] = "success";
    $respuesta = json_decode($respuesta);
    $respuesta = $respuesta[0];
    $returnValue["message"] = json_encode($respuesta);
}
//Return results
echo json_encode($returnValue);
?>