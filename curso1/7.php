<?php session_start();
if ($_SESSION['conectado'] == false)
{
   header ("Location: ../conectar.php");
   exit;
}
if ($_SESSION['identificador'] !== session_id())
{
   header ("Location: ../desconectar.php");
   exit; 
}
if ($_SESSION['nivel_usuario']==0)
{
	header ("Location: ../desconectar.php");
  	exit;
}
require('../funcions.php'); 
$nome="Enviar un ejercicio";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title><?php echo ucfirst($nome) . " de " . $_SESSION['nome_curso']; ?></title>
  <meta charset="utf-8">
  <link rel="icon" href="favicon.ico">
  <link rel="shortcut icon" href="favicon.ico">
  <meta name="author" content="Anton Busto - Antonio Jose Busto Fernandez">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../bootstrap4-glyphicons/css/bootstrap-glyphicons.min.css" rel="stylesheet" type="text/css" />
  <script src="../jquery/jquery.min.js"></script>
  <script src="../popper/popper.min.js"></script>
  <script src="../bootstrap/bootstrap.min.js"></script>
  <link href="../estilo.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
  $("footer a[href='#arriba']").on('click', function(event) {
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
include('cabeceira2.php'); 
include('menu2.php'); 
?>
  <div class="row" style="margin-top:40px;">
     <div class="col-sm-4">
     </div> 
    <div class="col-sm-4">

<?php
echo "<h4><strong>" . ucfirst($nome) . "</strong></h4>";
echo "<p><strong>Subir archivos a la aplicación</strong></p>";
?>
  <div class="custom-file">
<form name="miformulario" enctype="multipart/form-data" action="cargafichero.php" method="post" class="form-inline">
    <input type="file" class="custom-file-input" id="customFile" name="mifichero" >
    <label class="custom-file-label text-left" for="customFile">Selecciona el archivo...</label>
    <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
    <p><button type='submit' class='btn btn-dark text-center'>Enviar</button> </p>
</form>
<p><small>El archivo preferiblemente debe estar en formato PDF. <br />
<span class="text-danger">El tamaño máximo del archivo es de 2 Megas.</span></small></p>
</div>
<script>
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script> 

<!--<form name="miformulario" enctype="multipart/form-data" action="cargafichero.php" method="post" class="form-inline">
<div class='form-group'>
<input type="file" name="mifichero" class="btn btn-success mr-sm-3" />
<input type="hidden" name="MAX_FILE_SIZE" value="2097152" /> 
</div>
<button type='submit' class='btn btn-dark'>Enviar</button>
</form>
-->
     <div class="col-sm-4">
     </div>   
  </div>
</div>
<?php include('pe2.php'); ?>
</body>
</html>