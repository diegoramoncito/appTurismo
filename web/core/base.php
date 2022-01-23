<?php

$conn = pg_connect("host=10.0.1.50 port=5432 dbname=appturismo user=prefectura password=1234");

$result = pg_query($conn, "select id,texto,ST_AsGeoJSON(punto) ,ST_AsText(punto) from destinos;");

var_dump($result);
echo "<br><br><br><br><br>".json_encode($result)."<br><br><br>";
if (!$result) {
    echo "query did not execute";
}

echo pg_num_rows($result);

if (pg_num_rows($result) == 0) {
    echo "0 records";
} else {
    echo "si tiene records<br><br>";
    while ($row = pg_fetch_array($result)) {
        //do stuff with $row
        echo "<br>";
        var_dump($row);
        echo "<br>";
        echo json_encode($row);
        echo "<br>";
    }
}
?>
