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
$nome="enlaces de interés";
(int)$pag=8;
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
     <div class="col-sm-2">
     </div> 
    <div class="col-sm-8">


<?php
echo "<h4 class='text-center'><strong>" . ucfirst($nome) . "</strong></h4>";
$sql = "SELECT * 
		FROM curso" . $_SESSION['curso'] . "_paxinas 
		WHERE idpaxina=$pag";

$resultado = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
$fila = mysqli_fetch_assoc($resultado);
echo  "<div><img src='imaxes/" . $fila['foto'] . "' alt='" . $fila['nome'] . "' title='" . $fila['nome'] . "' width='60' height='60' /></div>"; 
echo "<div class='text-left'>" . nl2br($fila['texto']) . "</div>";
?>
      <br>
     <div class="col-sm-2">
     </div>   
  </div>
</div>
<?php include('pe2.php'); ?>
</body>
</html>