<?php
date_default_timezone_set('America/Guayaquil');
$date = date('Ymd', time());
require_once("tools/toConn.php");

$destinos = json_decode(query("select * from destino"));

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
<div class="custom-file">
<form id="carga" action="massLoadData.php" method="post" enctype="multipart/form-data">
<input type="file" class="custom-file-input" id="customFile" name="customFile">
<label class="custom-file-label" for="customFile">Subir archivo excel</label>
<button class="btn btn-info" type="submit">Cargar</button>
</form>
<br />
</div>
</div></div>
<div class="section">
<div class="container">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Actiones</th>
<th scope="col">Tipo</th>
<th scope="col">Título</th>
              <th scope="col">Canton</th>
              <th scope="col">Parroquia</th>
            </tr>
          </thead>
          <tbody>
<?php

foreach ($destinos as $elemento) {
    $individual = json_decode($elemento->info);
?>
    
            <tr <?php if($elemento->activo == 0) echo ' class="table-danger"'; ?>>
              <th scope="row">
                  <a href="detalle.php?id=<?php echo $elemento->id; ?>" class="btn btn-default btn-info" style="text-shadow: none;!important">Editar</a>
                  <a href="desactivar.php?id=<?php echo $elemento->id; ?>" class="btn btn-default btn-danger" style="text-shadow: none;!important">Eliminar</a>
              </th>
                <td><?php echo $elemento->tipo; ?></td>
                <td><?php echo $individual->titulo; ?></td>
                <td><?php echo $individual->canton; ?></td>
                <td><?php echo $individual->parroquia; ?></td>
            </tr>
<?php } ?>
          </tbody>
        </table>
</div></div>
    </body>
    
</html>
