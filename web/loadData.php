<?php
date_default_timezone_set('America/Guayaquil');
$date = date('Ymd', time());
require_once("tools/toConn.php");
require_once("frameworks/xls/vendor/autoload.php");



$idDestino = $_GET['id'];
if($idDestino!=""){
    $destino = json_decode(query("select * from destino where id = $idDestino"));
    $elementDestino = json_decode($destino[0]->info);
}else{
    $elementDestino = json_decode('{"calificacion": 4, "titulo": "Iglesia", "subtitulo": "Quito", "descripcion": "Iglesia ", "temperatura": "14ºC", "dificultad": "Baja", "presupuesto": "5$", "fotos": [ "https://www.quito-turismo.gob.ec/wp-content/uploads/2021/04/02_04-EL-UNIVERSO-2-1-1024x378.jpg" ], "actividades": [ { "tipo": 1, "leyenda": "Arte y arquitectura" }], "servicios": [ { "tipo": 5, "leyenda": "Alojamiento" }], "links": [ { "tipo": 1, "url": "https://www.tripadvisor.com", "leyenda": "TripAdvisor" }], "telefono": "+593", "comentario": "Rut", "canton":"quito", "parroquia":"San antonio" }');
}


$targetDirectory = "img/".$idDestino."/";
$allowTypes = array('jpg','png','jpeg');
$statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
$fileNames = array_filter($_FILES['files']['name']);

if(!empty($fileNames)){
    foreach($_FILES['files']['name'] as $key=>$val){
        // File upload path
        $fileName = basename($_FILES['files']['name'][$key]);
        $targetFilePath = $targetDirectory . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        if(in_array($fileType, $allowTypes)){
            uploadFile($targetDirectory,$_FILES["files"]["tmp_name"][$key],$fileType);
        }
    }
}
if(valNumber($idDestino)>0)
$elementDestino->fotos = getFilesArray($targetDirectory);


$id=$idDestino;
$tipo=$_POST['tipo'];
//    $relacionadas=$_POST['relacionadas'];
$calificacion=doubleval($_POST['calificacion']);
$titulo=$_POST['titulo'];
$subtitulo=$_POST['subtitulo'];
$descripcion=$_POST['detalle'];
$temperatura=$_POST['temperatura'];
$dificultad=$_POST['dificultad'];
$presupuesto=$_POST['presupuesto'];
$telefono=$_POST['telefono'];
$comentario=$_POST['comentario'];
$lat=valNumber(str_replace("(", "", str_replace(")", "", $_POST['latitud'])));
$lon=valNumber(str_replace("(", "", str_replace(")", "", $_POST['longitud'])));
$canton=$_POST['canton'];
$parroquia=$_POST['parroquia'];
$actividades=$_POST['actividades'];
$servicios=$_POST['servicios'];
$url1=$_POST['url1'];
$url2=$_POST['url2'];
$url3=$_POST['url3'];
error_log($tipo);
$elementDestino->tipo=$tipo;
$elementDestino->calificacion=$calificacion;
$elementDestino->titulo=$titulo;
$elementDestino->subtitulo=$subtitulo;
$elementDestino->descripcion=$descripcion;
$elementDestino->temperatura=$temperatura;
$elementDestino->dificultad=$dificultad;
$elementDestino->presupuesto=$presupuesto;
$elementDestino->telefono=$telefono;
$elementDestino->comentario=$comentario;
$elementDestino->canton=$canton;
$elementDestino->parroquia=$parroquia;

$actividad = $elementDestino->actividades[0];
$servicio = $elementDestino->servicios[0];
$link = $elementDestino->links[0];

$actividadesList = array();
foreach(explode(",", $actividades) as $act){
    if($act!=""){
        $actividad->tipo = 1;
        $actividad->leyenda = $act;
        array_push($actividadesList, json_decode(json_encode($actividad)));
    }
}
$elementDestino->actividades = $actividadesList;
$serviciosList = array();
foreach(explode(",", $servicios) as $act){
    if($act!=""){
        echo "1";
        $servicio->tipo = getTipo($act);
        $servicio->leyenda = $act;
        array_push($serviciosList, json_decode(json_encode($servicio)));
    }
}
$elementDestino->servicios = $serviciosList;

$linkLista = array();
$link->tipo=1;
$link->url=$url1;
$link->leyenda=getUrlLeyenda($url1);
array_push($linkLista,json_decode(json_encode($link)));
$link->tipo=1;
$link->url=$url2;
$link->leyenda=getUrlLeyenda($url2);
array_push($linkLista,json_decode(json_encode($link)));
$link->tipo=1;
$link->url=$url3;
$link->leyenda=getUrlLeyenda($url3);
array_push($linkLista,json_decode(json_encode($link)));
$elementDestino->links = $linkLista;

$info = json_encode($elementDestino);
if ($idDestino!=""){
    $query = "update destino set tipo = '$tipo', calificacion = $calificacion, titulo = '$titulo', ubicacion = ST_GeomFromText('POINT($lon $lat)', 4326), info = '$info' where id = $id";
    crudQuery($query);
    $header = "Location: detalle.php?id=$idDestino";
}else{
    if($titulo!=""){
        $query = "insert into destino (tipo,calificacion,titulo,ubicacion,info) values('$tipo', $calificacion,'$titulo',ST_GeomFromText('POINT($lon $lat)', 4326), '$info')";
        crudQuery($query);
        $header = "Location: datos.php";
    }
}
//$query = "update destino set tipo = '$tipo', calificacion = $calificacion, titulo = '$titulo', ubicacion = ST_GeomFromText('POINT($lon $lat)', 4326), info = '$info' where id = $idDestino";
//crudQuery($query);

header($header);


?>
