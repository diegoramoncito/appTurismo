<?php
date_default_timezone_set('America/Guayaquil');
$date = date('Ymd', time());
require_once("tools/toConn.php");

$idDestino = $_GET['id'];
if($idDestino!=""){
    $query = "update destino set activo = 0 where id = $idDestino";
    crudQuery($query);
}

$header = "Location: datos.php";

header($header);


?>
