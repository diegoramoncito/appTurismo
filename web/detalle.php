<?php
date_default_timezone_set('America/Guayaquil');
$date = date('Ymd', time());
require("tools/toConn.php");
$formDestination = "loadData.php";
if(isset($_GET['id']) && $_GET['id'] != ""){
    $formDestination .="?id=".$_GET['id'];
    $idDestino = $_GET['id'];
    $destino = json_decode(query("select *,ST_X(ubicacion::geometry) AS lon, st_y(ubicacion::geometry) as lat from destino where id = $idDestino"));
    $lon = $destino[0]->lon;
    $lat = $destino[0]->lat;
    $datos = json_decode($destino[0]->info);
    $actividades = "";
    foreach($datos->actividades as $actividad){
        $actividades .= $actividad->leyenda.",";
    }
    $servicios = "";
    foreach($datos->servicios as $servicio){
        $servicios .= $servicio->leyenda.",";
    }
    $fotos = $datos->fotos;
    $url1=$datos->links[0]->url;
    $url2=$datos->links[1]->url;
    $url3=$datos->links[2]->url;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Prefectura</title>

<link href="frameworks/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="frameworks/js/jquery.min.js"></script>
<script src="frameworks/js/bootstrap.js"></script>

</head>
<body>
<?php getNavBar(); ?>
<div class="section">
   <div class="container">
<form id="cargaFacturas" action="<?php echo $formDestination; ?>" method="post" enctype="multipart/form-data">
   <br /><br />
   <div class="form-group row">
      <div class="col-md-4">
         <label for="tipo">Tipo</label>
         <select class="form-control" id="tipo" name="tipo">
            <option value="Destino" <?php if(strtoupper($destino[0]->tipo)=="DESTINO")echo "Selected"; ?>>Destino</option>
            <option value="Ruta" <?php if(strtoupper($destino[0]->tipo)=="RUTA")echo "Selected"; ?>>Ruta</option>
         </select>
      </div>
      <div class="col-md-4">
         <label for="titulo" class="col-sm-2 col-form-label">Título</label>
         <div class="col-sm-10">
            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título" value="<?php echo $datos->titulo; ?>">
         </div>
      </div>
      <div class="col-md-4">
         <label for="subtitulo" class="col-sm-2 col-form-label">Subtítulo</label>
         <div class="col-sm-10">
            <input type="text" class="form-control" id="subtitulo" name="subtitulo" placeholder="Subtítulo" value="<?php echo $datos->subtitulo; ?>">
         </div>
      </div>
<div class="col-md-6">
   <label for="detalle" class="col-sm-2 col-form-label">Descripción</label>
   <div class="col-sm-11">
      <textarea class="form-control" id="detalle" name="detalle" rows="3"><?php echo $datos->descripcion; ?></textarea>
   </div>
</div>
<div class="col-md-6">
   <label for="comentario" class="col-sm-2 col-form-label">Comentario</label>
   <div class="col-sm-11">
      <textarea class="form-control" id="comentario" name="comentario" rows="3"><?php echo $datos->comentario; ?></textarea>
   </div>
</div>
<div class="col-md-4">
   <label for="calificacion" class="col-sm-2 col-form-label">Calificación</label>
   <div class="col-sm-10">
      <input type="text" class="form-control" id="calificacion" name="calificacion" placeholder="4.3" value="<?php echo $datos->calificacion; ?>">
   </div>
</div>
<div class="col-md-4">
   <label for="latitud" class="col-sm-2 col-form-label">Latitud</label>
   <div class="col-sm-10">
      <input type="text" class="form-control" id="latitud" name="latitud" placeholder="0.0012" value="<?php echo $lat; ?>">
   </div>
</div>
<div class="col-md-4">
   <label for="longitud" class="col-sm-2 col-form-label">Longitud</label>
   <div class="col-sm-10">
      <input type="text" class="form-control" id="longitud" name="longitud" placeholder="-73.5432" value="<?php echo $lon; ?>">
   </div>
</div>
      <div class="col-md-4">
         <label for="temperatura" class="col-sm-2 col-form-label">Temperatura</label>
         <div class="col-sm-10">
            <input type="text" class="form-control" id="temperatura" name="temperatura" placeholder="17ºC" value="<?php echo $datos->temperatura; ?>">
         </div>
      </div>
      <div class="col-md-4">
         <label for="dificultad" class="col-sm-2 col-form-label">Dificultad</label>
         <div class="col-sm-10">
            <input type="text" class="form-control" id="dificultad" name="dificultad" placeholder="Baja" value="<?php echo $datos->dificultad; ?>">
         </div>
      </div>
      <div class="col-md-4">
         <label for="presupuesto" class="col-sm-2 col-form-label">Presupuesto</label>
         <div class="col-sm-10">
            <input type="text" class="form-control" id="presupuesto" name="presupuesto" placeholder="5USD" value="<?php echo $datos->presupuesto; ?>">
         </div>
      </div>
      <div class="col-md-4">
         <label for="telefono" class="col-sm-2 col-form-label">Teléfono</label>
         <div class="col-sm-10">
            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="1800-111-111" value="<?php echo $datos->telefono; ?>">
         </div>
      </div>
      <div class="col-md-4">
         <label for="canton" class="col-sm-2 col-form-label">Cantón</label>
         <div class="col-sm-10">
            <input type="text" class="form-control" id="canton" name="canton" placeholder="Quito" value="<?php echo $datos->canton; ?>">
         </div>
      </div>
      <div class="col-md-4">
         <label for="parroquia" class="col-sm-2 col-form-label">Parroquia</label>
         <div class="col-sm-10">
            <input type="text" class="form-control" id="parroquia" name="parroquia" placeholder="San Antonio" value="<?php echo $datos->parroquia; ?>">
         </div>
      </div>
      <div class="col-md-4">
         <label for="actividades" class="col-sm-2 col-form-label">Actividades</label>
         <div class="col-sm-10">
            <input type="text" class="form-control" id="actividades" name="actividades" placeholder="Caminata, Arquitectura, Senderismo" value="<?php echo $actividades; ?>">
         </div>
      </div>
      <div class="col-md-4">
         <label for="servicios" class="col-sm-2 col-form-label">Servicios</label>
         <div class="col-sm-10">
            <input type="text" class="form-control" id="servicios" name="servicios" placeholder="Alojamiento, Parqueo"  value="<?php echo $servicios; ?>">
         </div>
      </div>
      <div class="col-md-4">
         <label for="url1" class="col-sm-2 col-form-label">URL</label>
         <div class="col-sm-10">
            <input type="text" class="form-control" id="url1" name="url1" placeholder="https://www.tripadvisor.com"  value="<?php echo $url1; ?>">
         </div>
      </div>
      <div class="col-md-4">
         <label for="url2" class="col-sm-2 col-form-label">URL</label>
         <div class="col-sm-10">
            <input type="text" class="form-control" id="url2" name="url2" placeholder="http://www.booking.com"  value="<?php echo $url2; ?>">
         </div>
      </div>
      <div class="col-md-4">
         <label for="url3" class="col-sm-2 col-form-label">URL</label>
         <div class="col-sm-10">
            <input type="text" class="form-control" id="url3" name="url3" placeholder="http://www.wikiloc.com"  value="<?php echo $url3; ?>">
         </div>
      </div>
      <div class="col-md-4">
         <div class="mb-3">
            <label for="formFileMultiple">Seleccione las fotografías (máximo 5)</label>
            <input type="file" id="formFileMultiple" name="files[]" multiple>
         </div>
      </div>
   </div>
   <div class="form-group row">
      <button class="btn btn-info" type="submit">Guardar</button>
   </div>
</form>
   </div>
</div>
<div class="section">
<div class="container">
<div class="row">
<?php $el=0; foreach($fotos as $element){?>
<div class="col-md-4">
<div class="thumbnail">
<a href="<?php echo $element; ?>" target="_blank">
<img src="<?php echo $element; ?>" alt="Nature" style="width:100%">
</a>
</div>
</div>
<?php } ?>
</div>

      </div></div><br /><br /><br />
    </body>
    
</html>
