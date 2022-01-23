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

//Evaluate for duplicates
$respuesta = query("select email from usuario where email = '$email'");
if ($respuesta == "failure") {
//Prepare and execute query
    $secure_password = md5($password);
    $token = md5($email + $date);
    $respuesta = crudQuery("insert into usuario(ruc,email,password,token,activo,rolid) values ('$email','$email','$secure_password','$token',true,6)");
} else {
    $respuesta = "failure";
}
//Evaluate results
if ($respuesta == "failure") {
    $returnValue["status"] = "failure";
    $returnValue["message"] = "Usuario existente o no válido";
} else {
    $returnValue["status"] = "success";
    $returnValue["message"] = "Registro correcto, por favor de click Ya tengo una cuenta";
}
//Return results
echo json_encode($returnValue);
?>