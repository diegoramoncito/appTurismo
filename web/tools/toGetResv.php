<?php

date_default_timezone_set('America/Guayaquil');
$date = date('Ymd', time());
require("toConn.php");
//Gather variables
$token = trimVar(trim($_REQUEST["token"]));
$case = trimVar(trim($_REQUEST["case"]));
$returnValue = array();
//Validations
if ($token == "") { //empty($email) || empty($password) || 
    $returnValue["status"] = "failure";
    $returnValue["message"] = "Por favor inicie sesión";
    echo json_encode($returnValue);
    return;
}

$filter = "and horadesde is not null";
if($case == "new"){
    $filter = "and horadesde is null";
}
//Evaluate for valid session
$respuesta = query("select email from usuario where token = '$token'");
if ($respuesta != "failure") {
//Execute query
    $respuesta = "select id,fechahora,calificacionCliente,calificacionFreelancer,horaDesde,horaHasta,unidadesFacturadas,montoFacturado,(select calificacioncomofreelancer from usuario where ruc = (select usuarioruc from usuarioservicio where id = usuarioservicioid)) as calificacion,(select nombre from servicio where id = (select servicioid from usuarioservicio where id = usuarioservicioid)) as servicio, (select fotoperfil from usuario  where ruc = (select usuarioruc from usuarioservicio where id = usuarioservicioid)) as foto from transaccion where usuarioruc=(select ruc from usuario where token = '$token') $filter and activo = true";
    $respuesta = query($respuesta);
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
//    $respuesta = json_decode($respuesta);
//    $respuesta = $respuesta[0];
    $returnValue["message"] = $respuesta;
}
//Return results
echo json_encode($returnValue);
?>
