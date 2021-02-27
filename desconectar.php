<!DOCTYPE html>
<html lang="es">
<head>
<title>Desconectar</title>
<meta charset="utf-8">
<link rel="icon" href="favicon.ico">
<link rel="shortcut icon" href="favicon.ico">
<meta name="author" content="Anton Busto - Antonio Jose Busto Fernandez">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="bootstrap/bootstrap.min.css">
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
session_start(); 
extract($_SESSION); // se extraen los datos del array de sesiones y se asignan a sus respectivas variables 

include ('cabecera.php');
include ('menu.php'); //inclusión de la estructura de menús de navegación 
?>
  <div class="row" style="margin-top:40px;">
     <div class="col-sm-2">
     </div> 
    <div class="col-sm-8">
<?php
echo "<h2 class='text-center'>Desconexi&oacute;n</h2>";

//Comprobar si el usuario está conectado
if(isset($_SESSION['conectado']) &&($_SESSION['conectado'] == true))
{
	
/* borrar todas las variables de sesión individualmente, 
se podrían vaciar más rápido la variables con $_SESSION = array(); */
	unset($_SESSION['id_usuario']);
	unset($_SESSION['nome_usuario']);
	unset($_SESSION['nivel_usuario']);
	unset($_SESSION['curso']);
	unset($_SESSION['nome_curso']);
	unset($_SESSION['conectado']);
	
	session_destroy(); //se destruye la sesión

	echo "<p class='text-center text-info'>Te has desconectado</p>";
}
else
{
	echo "<p class='text-center text-info'>Est&aacute;s desconectado</p>";
}
?>
      <br>
     <div class="col-sm-2">
     </div>   
  </div>
</div>
<?php include('pe.php'); ?>
</body>
</html>