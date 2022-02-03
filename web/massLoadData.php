<?php
date_default_timezone_set('America/Guayaquil');
$date = date('Ymd', time());
require_once("tools/toConn.php");
require_once("frameworks/xls/vendor/autoload.php");

$sampleDestino = json_decode('{"calificacion": 4, "titulo": "I", "subtitulo": "Q", "descripcion": "I", "temperatura": "1", "dificultad": "B", "presupuesto": "5$", "fotos": [ "https://appturismo.pichincha.gob.ec/img/1/1.jpg" ], "actividades": [ { "tipo": 1, "leyenda": "Arte" }], "servicios": [ { "tipo": 5, "leyenda": "Alojamiento" }], "links": [ { "tipo": 1, "url": "https://www.tripadvisor.com", "leyenda": "TripAdvisor" }], "telefono": "+59", "comentario": "R", "canton":"q", "parroquia":"S" }');
$sampleEvento = json_decode('{"calificacion": 4, "titulo": "I", "subtitulo": "Q", "descripcion": "I", "temperatura": "1", "dificultad": "B", "presupuesto": "5$", "fotos": [ "https://appturismo.pichincha.gob.ec/img/1/1.jpg" ], "actividades": [ { "tipo": 1, "leyenda": "Arte" }], "servicios": [ { "tipo": 5, "leyenda": "Alojamiento" }], "links": [ { "tipo": 1, "url": "https://www.tripadvisor.com", "leyenda": "TripAdvisor" }], "telefono": "+59", "comentario": "R", "canton":"q", "parroquia":"S","destinos":[]}');


$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($_FILES['customFile']['tmp_name']);
$xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
$nr = count($xls_data); //number of rows
for($i=2; $i<=$nr; $i++){
    echo "\n";
    $dato =$xls_data[$i];
    
    $id=$xls_data[$i]['A'];
    $tipo=$xls_data[$i]['B'];
    $relacionadas=$xls_data[$i]['C'];
    $calificacion=$xls_data[$i]['D'];
    $titulo=$xls_data[$i]['E'];
    $subtitulo=$xls_data[$i]['F'];
    $descripcion=$xls_data[$i]['G'];
    $temperatura=$xls_data[$i]['H'];
    $dificultad=$xls_data[$i]['I'];
    $presupuesto=$xls_data[$i]['J'];
    $telefono=$xls_data[$i]['K'];
    $comentario=$xls_data[$i]['L'];
    $lat=valNumber(str_replace("(", "", str_replace(")", "", $xls_data[$i]['M'])));
    $lon=valNumber(str_replace("(", "", str_replace(")", "", $xls_data[$i]['N'])));
    $canton=$xls_data[$i]['O'];
    $parroquia=$xls_data[$i]['P'];
    $actividades=$xls_data[$i]['Q'];
    $servicios=$xls_data[$i]['R'];
    $url1=$xls_data[$i]['S'];
    $url2=$xls_data[$i]['T'];
    $url3=$xls_data[$i]['U'];
    
    if(strtoupper($tipo)==strtoupper("Destino"))
        $elementDestino = $sampleDestino;
    else
        $elementoDestino = $sampleEvento;
    
    $elementDestino->tipo=$tipo;
    $elementDestino->calificacion=doubleval($calificacion);
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
    
    echo "1";
    $linkLista = array();
    $link->tipo=1;
    $link->url=$url1;
    echo "1";
    $link->leyenda=getUrlLeyenda($url1);
    echo "2";
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
    $titulo = strlen($titulo) > 50 ? substr($titulo,0,46)."..." : $titulo;
    
    if ($id!=""){
        $query = "update destino set tipo = '$tipo', calificacion = $calificacion, titulo = '$titulo', ubicacion = ST_GeomFromText('POINT($lon $lat)', 4326), info = '$info' where id = $id";
        crudQuery($query);
    }else{
        if($titulo!=""){
            $query = "insert into destino (tipo,calificacion,titulo,ubicacion,info) values('$tipo', $calificacion,'$titulo',ST_GeomFromText('POINT($lon $lat)', 4326), '$info')";
            crudQuery($query);
        }
    }
}


header("Location: datos.php");


?>
