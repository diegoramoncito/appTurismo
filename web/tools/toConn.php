<?php

function query($query) {
    $conn = pg_connect("host=10.0.1.50 port=5432 dbname=appturismo user=prefectura password=1234") or die('{"status":"failure","message":"Por favor contacte al administrador"}'); //' . str_replace(array("\r\n", "\n", "\r", '"'), '', pg_last_error()).'"}');
    pg_set_client_encoding($conn, "UNICODE");
    $result = pg_query($conn, $query) or die('{"status":"failure","message":"Por favor comuniquese con el administrador"}'); //' . str_replace(array("\r\n", "\n", "\r", '"'), '', pg_last_error()) .'"}');

    if (!$result) {
        $resultVar = "failure";
    } else {
        if (pg_num_rows($result) == 0) {
            $resultVar = "failure";
        } else {
            $resultVar = [];
            while ($row = pg_fetch_array($result)) {
                foreach ($row as $clave => $valor) {
                    if (!is_numeric($clave))
                        $resultRow[$clave] = $valor;
                }
                array_push($resultVar, $resultRow);
            }
            $resultVar = json_encode($resultVar);
        }
    }
    // Liberando el conjunto de resultados
    pg_free_result($result);
    // Cerrando la conexión
    pg_close($conn);
    return $resultVar;
}

function crudQuery($query) {
    $conn = pg_connect("host=10.0.1.50 port=5432 dbname=appturismo user=prefectura password=1234") or die('{"status":"failure","message":"Por favor contacte al administrador"}'); //' . str_replace(array("\r\n", "\n", "\r", '"'), '', pg_last_error()).'"}');
    pg_set_client_encoding($conn, "UNICODE");
    $result = pg_query($conn, $query) or die('{"status":"failure","message":"Por favor comuniquese con el administrador"}'); // . str_replace(array("\r\n", "\n", "\r", '"'), '', pg_last_error()) .'"}');

    if (!$result) {
        $resultVar = "failure";
    } else {
        $resultVar = "success";
    }
    // Liberando el conjunto de resultados
    pg_free_result($result);
    // Cerrando la conexión
    pg_close($conn);
    return $resultVar;
}

function trimVar($var) {
    return $var; //trim(substr($var, 10, strlen($var) - 12));
}


function getNavBar(){
    echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
    <a class="navbar-brand" href="#">Descubre Pichincha</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="datos.php">Inicio</a>
    </li>
    <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="detalle.php">Nuevo</a>
    </li>
    <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="reportes.php">Reportes</a>
    </li>

    </ul>
    <form class="d-flex">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success" type="submit">Filtrar</button>
    </form>
    </div>
    </div>
    </nav>';
}

function getTipo($nombre){
    if (strContains(strtoupper($nombre), strtoupper('arquitectura'))) return 1;
    return 1;
    
}

function getUrlLeyenda($url){
//    if (str_contains(strtoupper($url), strtoupper('tripadvisor'))) return "TripAdvisor";
    if (strContains(strtoupper($url), strtoupper('booking'))) return "Booking";
    if (strContains(strtoupper($url), strtoupper('wikiloc'))) return "Wikiloc";
    return "TripAdvisor";
}

function strContains($haystack, $needle){
    if (strpos($haystack, $needle) !== false) return true;
    else return false;
}

?>
