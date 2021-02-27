<?php (int)$pag=4;?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>PHP</title>
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
<?php  include('cabecera.php');?>
<?php  include('menu.php');?>
  <div class="row" style="margin-top:40px;">
     <div class="col-sm-2">
     </div> 
    <div class="col-sm-8">
       <?php $registros2 = mysqli_query($conexion, "select *
                        from paxinas where idpaxina=$pag") or
                die("Problemas en el select: " . mysqli_error($conexion));  	
$reg2 = mysqli_fetch_assoc($registros2);
echo "
<h2>" . ucfirst($reg2['nome']) . "</h2>
<h5>" . $reg2['axuda'] . "</h5>
<div><img src='imaxes/" . $reg2['foto'] . "' class='img-fluid mx-auto d-block' alt='" . $reg2['foto'] . "'></div>
<p>" . $reg2['texto'] . "</p>";
?>
      <br>
     <div class="col-sm-2">
     </div>   
  </div>
</div>
<?php include('pe.php'); ?>
</body>
</html>