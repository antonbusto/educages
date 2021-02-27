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
$nome="Carga de ejercicio para alumnos";
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
     <div class="col-sm-3">
     </div> 
    <div class="col-sm-6">

<?php 

 $destino= getcwd() . "/descargas/ejercicios/";
 
 /* si la función is_uploaded_files devuelve true , y move_uploaded_file
 si la transferencia es correcta se informa al usuario */
  if (is_uploaded_file($_FILES['mifichero']['tmp_name'])) {
  move_uploaded_file($_FILES['mifichero']['tmp_name'], $destino . $_FILES['mifichero']['name']); 
  echo "<p class='text-center text-success'><strong>Transferencia correcta</strong></p>";
  echo "<p class='text-center'>El archivo: <strong>" . $_FILES['mifichero']['name'] . " </strong><br />ha sido subido con &eacute;xito</p>";
   
  /* para identificar más fácil al alumno, se añade al principio del archivo el nombre guardado en la variable de sesión
  usando la función rename y dos variables para guardar las trayectorias de las rutas completas */
  $nome_actual= $destino . $_FILES['mifichero']['name'];
  $nome_novo= $destino . $_SESSION['nome_usuario'] . "_" . $_FILES['mifichero']['name'];
  
  //si no se puede cambiar el nombre del archivo
  if (!rename($nome_actual , $nome_novo)) {
  echo  "<p class='text-center text-danger'><small>Se ha producido un error al cambiar el nombre del archivo</small></p>";
  echo "<p class='text-center'><a href='ejercicios.php'>Volver</a></p>";
  }
  
  //se informa de la modificación en el nombre
  $ruta= pathinfo($nome_novo);
  echo "<p class='text-center'><small>El archivo ha sido renombrado a: <br />" . $ruta['filename'] . "." . $ruta['extension'] . "</small></p>";
  echo "<p class='text-center'><a class='btn btn-primary' href='ejercicios.php'>Subir otro archivo</a></p>";
  
  }
  
 else{
	 
 //si la función is_uploaded_files devuelve false, se informa de que ha ocurrido un problema
  echo "<p class='text-center'><strong>Ha sucedido un error al intentar subir el archivo</strong></p>";
  
  /* tratamiento de los posibles errores usando la matriz bidimensional $_FILES
  que contiene el nombre del fichero como índece de las filas, y las propiedades "name", "size", "type" y "tmp_name"
  como índice de las columnas. Se comprueba  */
  switch($_FILES['mifichero']['error']){
   case UPLOAD_ERR_OK: //no hay error, pero si no ha sido cargado puede ser un ataque
     echo "<p class='text-center text-danger'>Se ha producido algún problema con la carga</p>";
	 echo "<p class='text-center'><a class='btn btn-primary' href='ejercicios.php'>Volver</a></p>";
     break;
   case UPLOAD_ERR_INI_SIZE: //Tamaño del fichero mayor de lo indicado por upload_max_filesize
     echo "<p class='text-center text-danger'>Archivo demasiado grande: No se puede cargar</p>";
	 echo "<p class='text-center'><a class='btn btn-primary' href='ejercicios.php'>Volver</a></p>";
     break;
   case UPLOAD_ERR_FORM_SIZE: // Tamaño del fichero mayor que MAX_FILE_SIZE
     echo "<p class='text-center text-danger'>Archivo demasiado grande: No se puede cargar</p>";
	 echo "<p class='text-center'><a class='btn btn-primary' href='ejercicios.php'>Volver</a></p>";
     break;
   case UPLOAD_ERR_PARTIAL: //Solo se ha cargado parte del fichero
     echo "<p class='text-center text-danger'>Solo se ha cargado una parte del archivo</p>";
	 echo "<p class='text-center'><a class='btn btn-primary' href='ejercicios.php'>Volver</a></p>";
     break;
   case UPLOAD_ERR_NO_FILE: //no ha sido cargado ningún fichero
     echo "<p class='text-center text-danger'>Debes elegir un archivo para cargar</p>";
	 echo "<p class='text-center'><a class='btn btn-primary' href='ejercicios.php'>Volver</a></p>";
     break;
   case UPLOAD_ERR_NO_TMP_DIR: //No hay directorio temporal
     echo "<p class='text-center text-danger'>Problemas con el directorio temporal</p>";
	 echo "<p class='text-center'><a class='btn btn-primary' href='ejercicios.php'>Volver</a></p>";
     break;
   default: // Error por defecto
     echo "<p class='text-center text-danger'>Ha habido un error en la carga</p>";
	 echo "<p class='text-center'><a class='btn btn-primary' href='ejercicios.php'>Volver</a></p>";
     break;
   }
  } 
?>    
     <div class="col-sm-3">
     </div>   
  </div>
</div>
<?php include('pe2.php'); ?>
</body>
</html>