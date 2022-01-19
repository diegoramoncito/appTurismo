<?php

date_default_timezone_set('America/Guayaquil');
$date = date('Ymd', time());
require("toConn.php");
//Gather variables
$token = trimVar(trim($_REQUEST["token"]));
$radius = trimVar(trim($_REQUEST["radius"]));
$lat = trimVar(trim($_REQUEST["lat"]));
$long = trimVar(trim($_REQUEST["long"]));
$filters = trimVar(trim($_REQUEST["filters"]));
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
    $respuesta = "select st_distance(ST_GeomFromText('POINT($long $lat)', 4326),ubicacion) as distancia,ST_X(ubicacion::geometry) AS lon, ST_Y(ubicacion::geometry) AS lat,(select nombre from servicio where id = servicioId) as servicio, (select concat(nombres,' ', apellidos) from usuario where ruc = usuarioruc) as proveedor, servicioid, id from usuarioservicio where activo = true and servicioid in ($filters) and st_distance(ST_GeomFromText('POINT($long $lat)', 4326),ubicacion) < $radius and st_distance(ST_GeomFromText('POINT($long $lat)', 4326),ubicacion) < radius order by distancia asc fetch first 30 rows only";
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
    $returnValue["message"] = "No encontramos expertos en su zona, por favor intente más tarde";
} else {
    $returnValue["status"] = "success";
//    $respuesta = json_decode($respuesta);
//    $respuesta = $respuesta[0];
    $returnValue["message"] = $respuesta;
}
//Return results
echo json_encode($returnValue);
?>