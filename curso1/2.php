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
$nome="etiquetas";
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
echo "<h4 class='text-center'><strong>" . ucfirst($nome) . "</strong></h4>";
$sql="SELECT COUNT(*) FROM curso" . $_SESSION['curso'] . " WHERE tipo ='" . $nome . "'";
$resultado = mysqli_query($conexion, $sql); 
//usar solo si se hace paginación
list($total) = mysqli_fetch_row($resultado);
if (!isset($pax) OR ($pax==0)) {
    $pax = 1; 
} else {
$pax=(int)$_GET['pax'];   
}
$doc=$_SERVER["PHP_SELF"];
$tampax = 10;
$reg1 = ($pax-1) * $tampax;
//fin de paginación 
$sql="SELECT * 	FROM curso" . $_SESSION['curso'] . "  WHERE tipo ='" . $nome . "' LIMIT " . $reg1 . "," . $tampax . "";
$resultado = mysqli_query($conexion,$sql); 
echo "	<div class='table-responsive'>
     	<table class='table table-striped'>
        <tr><th> Listado de " . ucfirst($nome) . "</th></tr>";
        while ($fila = mysqli_fetch_assoc($resultado)) { 
          echo "<tr><td><a href='curso-detalle.php?id=" . $fila['id'] . "'>" . htmlentities($fila['nome']) . "</a></td></tr>";
          } ; 
      echo "</table>";   
echo"</div>";
?>
      <br>
     <div class="col-sm-3">
     </div>   
  </div>
</div>
<?php include('pe2.php'); ?>
</body>
</html>