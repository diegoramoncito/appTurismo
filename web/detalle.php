<?php
date_default_timezone_set('America/Guayaquil');
$date = date('Ymd', time());
require("tools/toConn.php");
if(isset($_GET['id'])){
$idDestino = $_GET['id'];
$destino = json_decode(query("select * from destino where id = $idDestino"));
$datos = json_decode($destino[0]->info);
    
    foreach($datos->actividades as $actividad){
        $actividades .= $actividad->leyenda.",";
    }
    
    foreach($datos->servicios as $servicio){
        $servicios .= $servicio->leyenda.",";
    }
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

<script src="frameworks/js/jquery.min.js"></script>
<link href="frameworks/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="frameworks/js/bootstrap.js"></script>


</head>
<body>
<?php getNavBar(); ?>
        <div class="section"><div class="container">
        <form id="cargaFacturas" action="detalleGuardar.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="tipo">Tipo</label>
                <select class="form-control" id="tipo">
                    <option>Destino</option>
                    <option>Ruta</option>
                </select>
            </div>
            <div class="form-group row">
                <label for="titulo" class="col-sm-2 col-form-label">Título</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="titulo" placeholder="Título" value="<?php echo $datos->titulo; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="subtitulo" class="col-sm-2 col-form-label">Subtítulo</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="subtitulo" placeholder="Subtítulo" value="<?php echo $datos->subtitulo; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="detalle" class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="detalle" rows="3"><?php echo $datos->descripcion; ?></textarea>
                </div>
            </div>
            
            
            <div class="form-group row">
                <label for="temperatura" class="col-sm-2 col-form-label">Temperatura</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="temperatura" placeholder="17ºC" value="<?php echo $datos->temperatura; ?>">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="dificultad" class="col-sm-2 col-form-label">Dificultad</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="dificultad" placeholder="Baja" value="<?php echo $datos->dificultad; ?>">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="presupuesto" class="col-sm-2 col-form-label">Presupuesto</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="presupuesto" placeholder="5USD" value="<?php echo $datos->presupuesto; ?>">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="telefono" class="col-sm-2 col-form-label">Teléfono</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="telefono" placeholder="1800-111-111" value="<?php echo $datos->telefono; ?>">
                </div>
            </div>
            
            
            <div class="form-group row">
                <label for="canton" class="col-sm-2 col-form-label">Cantón</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="canton" placeholder="Quito" value="<?php echo $datos->canton; ?>">
                </div>
            </div>
            
            
            <div class="form-group row">
                <label for="parroquia" class="col-sm-2 col-form-label">Parroquia</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="parroquia" placeholder="San Antonio" value="<?php echo $datos->parroquia; ?>">
                </div>
            </div>
            
            
            <div class="form-group row">
                <label for="actividades" class="col-sm-2 col-form-label">Actividades</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="actividades" placeholder="Caminata, Arquitectura, Senderismo" value="<?php echo $actividades; ?>">
                </div>
            </div>
            
            
            <div class="form-group row">
                <label for="servicios" class="col-sm-2 col-form-label">Servicios</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="servicios" placeholder="Alojamiento, Parqueo"  value="<?php echo $servicios; ?>">
                </div>
            </div>
            
            
            <div class="form-group row">
                <label for="url1" class="col-sm-2 col-form-label">URL</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="url1" placeholder="https://www.tripadvisor.com"  value="<?php echo $url1; ?>">
                </div>
            </div>
            
            
            <div class="form-group row">
                <label for="url2" class="col-sm-2 col-form-label">URL</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="url2" placeholder="http://www.booking.com"  value="<?php echo $url2; ?>">
                </div>
            </div>
            
            
            <div class="form-group row">
                <label for="url3" class="col-sm-2 col-form-label">URL</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="url3" placeholder="http://www.wikiloc.com"  value="<?php echo $url3; ?>">
                </div>
            </div>
<button class="btn btn-info" type="submit">Guardar</button>
        </form>
        </div></div>
        
    </body>
    
</html>
