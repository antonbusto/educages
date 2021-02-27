<!DOCTYPE html>
<html lang="es">
<head>
  <title>Cursos</title>
  <meta charset="utf-8">
  <link rel="icon" href="favicon.ico">
  <link rel="shortcut icon" href="favicon.ico">
  <meta name="author" content="Anton Busto - Antonio Jose Busto Fernandez">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
  <link href="bootstrap4-glyphicons/css/bootstrap-glyphicons.min.css" rel="stylesheet" type="text/css" />
  <script src="jquery/jquery.min.js"></script>
  <script src="popper/popper.min.js"></script>
  <script src="bootstrap/bootstrap.min.js"></script>
  <link href="estilo.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
  $(" footer a[href='#arriba']").on('click', function(event) {
  if (this.hash !== "") {
    event.preventDefault();
    var hash = this.hash;
    $('html, body').animate({
      scrollTop: $(hash).offset().top
    }, 500, function(){
      window.location.hash = hash;
      });
    }
  });
})
</script>
</head>
<body id="arriba">
<?php 
include('cabecera.php'); 
include('menu.php'); 
require_once('funcions.php'); 
?>
  <div class="row" style="margin-top:40px;">
     <div class="col-sm-4">
     </div> 
    <div class="col-sm-4">
<?php 
$sql = "SELECT * FROM cursos";
$resultado = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
$fila = mysqli_fetch_assoc($resultado);
$total_filas = mysqli_num_rows($resultado);
echo "<h2 class='text-center'>Cursos disponibles (" . $total_filas . ")</h2><p>&nbsp;</p>";
do { 
echo "<div class='card' style='width:100%'>
	  <img class='card-img-top' src='imaxes/" . $fila['foto'] . "' alt='" . $fila['nome_curso'] . "' style='width:100%'>
	  <div class='card-body'>
	  <h4 class='card-title'>" . $fila['nome_curso'] . "</h4>
	  <p class='card-text'>	  
	  <strong>Programa en PDF:</strong> <a href='pdf/" . $fila['programa_curso'] . "' target='_blank'>" . $fila['programa_curso'] . "</a>
      <br /><br />
	  <strong>Inicio:</strong> ". cambia($fila['inicio_curso']) . " | <strong>Fin: </strong>". cambia($fila['fin_curso']) . "<br />
	  <strong>Precio:</strong> " . $fila['prezo_curso'] . " euros | <strong>Horas:</strong> " . $fila['duracion_curso']. "<br /></p>";
echo "<a class='btn btn-primary' href='rexistro.php?curso=" . $fila['id_curso'] . "&amp;nome_curso=" . $fila['nome_curso'] . "  '>Preinscripci&oacute;n</a>
      </div></div><br/>";
} while ($fila = mysqli_fetch_assoc($resultado));
?>
      <br>
     <div class="col-sm-4">
     </div>   
  </div>
</div>
<?php include('pe.php'); ?>
</body>
</html>