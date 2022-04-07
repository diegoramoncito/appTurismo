<?php

date_default_timezone_set('America/Guayaquil');
$date = date('Ymd', time());
require_once("toConn.php");

$headers = getallheaders();
$bTitulo = $headers["titulo"];
//$body = @file_get_contents('php://input');

$elementDestino = json_decode('{"calificacion": 4, "titulo": "Iglesia San Francisco", "subtitulo": "Quito", "descripcion": "Iglesia de La Iglesia de San Francisco es una basílica católica que se levanta en medio del centro histórico de Quito, frente a la plaza del mismo nombre. La estructura es el conjunto arquitectónico de mayor dimensión dentro de los centros históricos de toda América, y por ello es conocido como el Escorial del Nuevo Mundo", "temperatura": "14ºC", "dificultad": "Baja", "presupuesto": "5$", "fotos": [ "https://www.quito-turismo.gob.ec/wp-content/uploads/2021/04/02_04-EL-UNIVERSO-2-1-1024x378.jpg" ], "actividades": [ { "tipo": 1, "leyenda": "Arte y arquitectura" }, { "tipo": 2, "leyenda": "Gastronomía" }, { "tipo": 3, "leyenda": "Ciclismo" } ], "servicios": [ { "tipo": 5, "leyenda": "Alojamiento" }, { "tipo": 6, "leyenda": "Parqueo" } ], "links": [ { "tipo": 1, "url": "https://www.tripadvisor.com", "leyenda": "TripAdvisor" }, { "tipo": 1, "url": "https://www.booking.com", "leyenda": "TripAdvisor" }, { "tipo": 1, "url": "https://www.wikiloc.com", "leyenda": "TripAdvisor" } ], "telefono": "+5939000000001", "comentario": "Ruta 56km 49", "canton":"quito", "parroquia":"San antonio" }');

$eventos = json_decode(query("select * from destino where tipo = 'Ruta' and activo = 1"));
$recomendados = json_decode(query("select * from destino where tipo = 'Destino' and activo = 1"));
$busquedas = json_decode(query("select * from destino where titulo like '%cayamb%' and tipo = 'Destino' and activo = 1"));
$categoria = array();
$canton = array();
$parroquia = array();

$resultado = json_decode('{"eventos":[],"recomendados":[],"buscados":[],"categoria":[],"canton":[],"parroquia":[]}');

$ev = array();
foreach($eventos as $elem){
    $actual = json_decode($elem->info);
    $actual->id = intval($elem->id);
    array_push($ev,json_decode(json_encode($actual)));
}

$resultado->eventos = $ev;

$re = array();
foreach($recomendados as $elem){
    $actual = json_decode($elem->info);
    $actual->id = intval($elem->id);
    if(!in_array($actual->subtitulo, $categoria)){
        if(!empty(trim($actual->subtitulo)))
            array_push($categoria,$actual->subtitulo);
    }
    if(!in_array($actual->canton, $canton)){
        if(!empty(trim($actual->canton)))
            array_push($canton,$actual->canton);
    }
    if(!in_array($actual->parroquia, $parroquia)){
        if(!empty(trim($actual->parroquia)))
            array_push($parroquia,$actual->parroquia);
    }
    array_push($re,json_decode(json_encode($actual)));
}

$resultado->recomendados = $re;

$bu = array();
foreach($busquedas as $elem){
    $actual = json_decode($elem->info);
    $actual->id = intval($elem->id);
    array_push($bu,json_decode(json_encode($actual)));
}

$resultado->buscados = $bu;
$resultado->categoria = $categoria;
$resultado->canton = $canton;
$resultado->parroquia = $parroquia;
//$resultado->headers = json_encode($headers);
//$resultado->buscador = $bTitulo;

echo json_encode($resultado);

?>



