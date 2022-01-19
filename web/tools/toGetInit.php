<?php

date_default_timezone_set('America/Guayaquil');
$date = date('Ymd', time());
require_once("toConn.php");

$elementDestino = json_decode('{"calificacion": 4, "titulo": "Iglesia San Francisco", "subtitulo": "Quito", "descripcion": "Iglesia de La Iglesia de San Francisco es una basílica católica que se levanta en medio del centro histórico de Quito, frente a la plaza del mismo nombre. La estructura es el conjunto arquitectónico de mayor dimensión dentro de los centros históricos de toda América, y por ello es conocido como el Escorial del Nuevo Mundo", "temperatura": "14ºC", "dificultad": "Baja", "presupuesto": "5$", "fotos": [ "https://www.quito-turismo.gob.ec/wp-content/uploads/2021/04/02_04-EL-UNIVERSO-2-1-1024x378.jpg" ], "actividades": [ { "tipo": 1, "leyenda": "Arte y arquitectura" }, { "tipo": 2, "leyenda": "Gastronomía" }, { "tipo": 3, "leyenda": "Ciclismo" } ], "servicios": [ { "tipo": 5, "leyenda": "Alojamiento" }, { "tipo": 6, "leyenda": "Parqueo" } ], "links": [ { "tipo": 1, "url": "https://www.tripadvisor.com", "leyenda": "TripAdvisor" }, { "tipo": 1, "url": "https://www.booking.com", "leyenda": "TripAdvisor" }, { "tipo": 1, "url": "https://www.wikiloc.com", "leyenda": "TripAdvisor" } ], "telefono": "+5939000000001", "comentario": "Ruta 56km 49", "canton":"quito", "parroquia":"San antonio" }');

$eventos = json_decode(query("select * from destino where tipo = 'Ruta'"));
$recomendados = json_decode(query("select * from destino where tipo = 'Destino'"));
$busquedas = json_decode(query("select * from destino where tipo = 'Destino'"));

$resultado = json_decode('{"eventos":[],"recomendados":[],"buscados":[]}');

$ev = array();
foreach($eventos as $elem){
    $actual = json_decode($elem->info);
    $actual->id = $elem->id;
    array_push($ev,json_decode(json_encode($actual)));
//    unset($actual);
}

$resultado->eventos = $ev;

$re = array();
foreach($recomendados as $elem){
    $actual = json_decode($elem->info);
    $actual->id = $elem->id;
    array_push($re,json_decode(json_encode($actual)));
//    unset($actual);
}

$resultado->recomendados = $re;

$bu = array();
foreach($busquedas as $elem){
    $actual = json_decode($elem->info);
    $actual->id = $elem->id;
    array_push($bu,json_decode(json_encode($actual)));
//    unset($actual);
}

$resultado->buscados = $bu;

echo json_encode($resultado);

//$value = '{
//"eventos": [
//  {
//    "id": 1,
//    "titulo": "Ruta de las iglesias",
//    "imagenUrl": "https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.istockphoto.com%2Fes%2Ffotos%2Fquito&psig=AOvVaw3ujjkXmwixGg92KNGf3ZR-&ust=1641601749707000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCJi9uZuxnvUCFQAAAAAdAAAAABAD",
//    "destinos": [
//      {
//        "id": 2,
//        "calificacion": 4,
//        "titulo": "Iglesia San Francisco",
//        "subtitulo": "Quito",
//        "descripcion": "Iglesia de La Iglesia de San Francisco es una basílica católica que se levanta en medio del centro histórico de Quito, frente a la plaza del mismo nombre. La estructura es el conjunto arquitectónico de mayor dimensión dentro de los centros históricos de toda América, y por ello es conocido como el Escorial del Nuevo Mundo",
//        "temperatura": "14ºC",
//        "dificultad": "Baja",
//        "presupuesto": "5$",
//        "fotos": [
//          "https://www.quito-turismo.gob.ec/wp-content/uploads/2021/04/02_04-EL-UNIVERSO-2-1-1024x378.jpg"
//        ],
//        "actividades": [
//          {
//            "tipo": 1,
//            "leyenda": "Arte y arquitectura"
//          },
//          {
//            "tipo": 2,
//            "leyenda": "Gastronomía"
//          },
//          {
//            "tipo": 3,
//            "leyenda": "Ciclismo"
//          }
//        ],
//        "servicios": [
//          {
//            "tipo": 5,
//            "leyenda": "Alojamiento"
//          },
//          {
//            "tipo": 6,
//            "leyenda": "Parqueo"
//          }
//        ],
//        "links": [
//          "https://www.tripadvisor.com",
//          "https://www.booking.com",
//          "https://www.wikiloc.com"
//        ],
//        "telefono": "+5939000000001",
//        "comentario": "Ruta 56km 49"
//      }
//    ]
//  }
//],
//"recomendados": [
//  {
//    "id": 9,
//    "calificacion": 4,
//    "titulo": "Iglesia La compañia",
//    "subtitulo": "Quito",
//    "descripcion": "Iglesia de La Iglesia de San Francisco es una basílica católica que se levanta en medio del centro histórico de Quito, frente a la plaza del mismo nombre. La estructura es el conjunto arquitectónico de mayor dimensión dentro de los centros históricos de toda América, y por ello es conocido como el Escorial del Nuevo Mundo",
//    "temperatura": "14ºC",
//    "dificultad": "Baja",
//    "presupuesto": "5$",
//    "fotos": [
//      "https://www.quito-turismo.gob.ec/wp-content/uploads/2021/04/02_04-EL-UNIVERSO-2-1-1024x378.jpg"
//    ],
//    "actividades": [
//      {
//        "tipo": 1,
//        "leyenda": "Arte y arquitectura"
//      },
//      {
//        "tipo": 2,
//        "leyenda": "Gastronomía"
//      },
//      {
//        "tipo": 3,
//        "leyenda": "Ciclismo"
//      }
//    ],
//    "servicios": [
//      {
//        "tipo": 5,
//        "leyenda": "Alojamiento"
//      },
//      {
//        "tipo": 6,
//        "leyenda": "Parqueo"
//      }
//    ],
//    "links": [
//      "https://www.tripadvisor.com",
//      "https://www.booking.com",
//      "https://www.wikiloc.com"
//    ],
//    "telefono": "+5939000000001",
//    "comentario": "Ruta 56km 49"
//  },
//  {
//    "id": 10,
//    "calificacion": 4,
//    "titulo": "Iglesia Basilica",
//    "subtitulo": "Quito",
//    "descripcion": "Iglesia de La Iglesia de San Francisco es una basílica católica que se levanta en medio del centro histórico de Quito, frente a la plaza del mismo nombre. La estructura es el conjunto arquitectónico de mayor dimensión dentro de los centros históricos de toda América, y por ello es conocido como el Escorial del Nuevo Mundo",
//    "temperatura": "14ºC",
//    "dificultad": "Baja",
//    "presupuesto": "5$",
//    "fotos": [
//      "https://www.quito-turismo.gob.ec/wp-content/uploads/2021/04/02_04-EL-UNIVERSO-2-1-1024x378.jpg"
//    ],
//    "actividades": [
//      {
//        "tipo": 1,
//        "leyenda": "Arte y arquitectura"
//      },
//      {
//        "tipo": 2,
//        "leyenda": "Gastronomía"
//      },
//      {
//        "tipo": 3,
//        "leyenda": "Ciclismo"
//      }
//    ],
//    "servicios": [
//      {
//        "tipo": 5,
//        "leyenda": "Alojamiento"
//      },
//      {
//        "tipo": 6,
//        "leyenda": "Parqueo"
//      }
//    ],
//    "links": [
//      "https://www.tripadvisor.com",
//      "https://www.booking.com",
//      "https://www.wikiloc.com"
//    ],
//    "telefono": "+5939000000001",
//    "comentario": "Ruta 56km 49"
//  }
//],
//"buscados": [
//  {
//    "id": 2,
//    "calificacion": 4,
//    "titulo": "Iglesia San Francisco",
//    "subtitulo": "Quito",
//    "descripcion": "Iglesia de La Iglesia de San Francisco es una basílica católica que se levanta en medio del centro histórico de Quito, frente a la plaza del mismo nombre. La estructura es el conjunto arquitectónico de mayor dimensión dentro de los centros históricos de toda América, y por ello es conocido como el Escorial del Nuevo Mundo",
//    "temperatura": "14ºC",
//    "dificultad": "Baja",
//    "presupuesto": "5$",
//    "fotos": [
//      "https://www.quito-turismo.gob.ec/wp-content/uploads/2021/04/02_04-EL-UNIVERSO-2-1-1024x378.jpg"
//    ],
//    "actividades": [
//      {
//        "tipo": 1,
//        "leyenda": "Arte y arquitectura"
//      },
//      {
//        "tipo": 2,
//        "leyenda": "Gastronomía"
//      },
//      {
//        "tipo": 3,
//        "leyenda": "Ciclismo"
//      }
//    ],
//    "servicios": [
//      {
//        "tipo": 5,
//        "leyenda": "Alojamiento"
//      },
//      {
//        "tipo": 6,
//        "leyenda": "Parqueo"
//      }
//    ],
//    "links": [
//      "https://www.tripadvisor.com",
//      "https://www.booking.com",
//      "https://www.wikiloc.com"
//    ],
//    "telefono": "+5939000000001",
//    "comentario": "Ruta 56km 49"
//  },
//  {
//    "id": 7,
//    "calificacion": 5,
//    "titulo": "Iglesia San Francisco",
//    "subtitulo": "Quito",
//    "descripcion": "Iglesia de La Iglesia de San Francisco es una basílica católica que se levanta en medio del centro histórico de Quito, frente a la plaza del mismo nombre. La estructura es el conjunto arquitectónico de mayor dimensión dentro de los centros históricos de toda América, y por ello es conocido como el Escorial del Nuevo Mundo",
//    "temperatura": "14ºC",
//    "dificultad": "Baja",
//    "presupuesto": "5$",
//    "fotos": [
//      "https://www.quito-turismo.gob.ec/wp-content/uploads/2021/04/02_04-EL-UNIVERSO-2-1-1024x378.jpg"
//    ],
//    "actividades": [
//      {
//        "tipo": 1,
//        "leyenda": "Arte y arquitectura"
//      },
//      {
//        "tipo": 2,
//        "leyenda": "Gastronomía"
//      },
//      {
//        "tipo": 3,
//        "leyenda": "Ciclismo"
//      }
//    ],
//    "servicios": [
//      {
//        "tipo": 5,
//        "leyenda": "Alojamiento"
//      },
//      {
//        "tipo": 6,
//        "leyenda": "Parqueo"
//      }
//    ],
//    "links": [
//      "https://www.tripadvisor.com",
//      "https://www.booking.com",
//      "https://www.wikiloc.com"
//    ],
//    "telefono": "+5939000000001",
//    "comentario": "Ruta 56km 49"
//  }
//]
//}';
//
//$returnValue = json_decode($value);
//echo json_encode($returnValue);
?>



