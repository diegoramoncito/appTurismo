<?php

date_default_timezone_set('America/Guayaquil');
$date = date('Ymd', time());
require("toConn.php");
//Gather variables
$email = trimVar(trim($_REQUEST["email"])); //htmlentities($_POST["email"]));
$password = trimVar(trim($_REQUEST["password"])); //htmlentities($_POST["password"]));
$returnValue = array();
//Validations
if ($email == "" || $password == "" ) { //empty($email) || empty($password) || 
    $returnValue["status"] = "failure";
    $returnValue["message"] = "Por favor llene los campos solicitados";
    echo json_encode($returnValue);
    return;
}

//Validate login
$secure_password = md5($password);
$respuesta = query("select token from usuario where email = '$email' and password = '$secure_password'");

//Evaluate results
if ($respuesta == "failure") {
    $returnValue["status"] = "failure";
    $returnValue["message"] = "Credenciales incorrectas";
} else {
    $returnValue["status"] = "success";
    $respuesta = json_decode($respuesta);
    $returnValue["message"] = $respuesta[0]->token;//$respuesta[0]["token"];
}
//Return results
echo json_encode($returnValue);
?>