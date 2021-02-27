<?php (int)$pag=13;?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Usuarios</title>
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
     <div class="col-sm-4">
     </div> 
    <div class="col-sm-4">
       <?php $registros2 = mysqli_query($conexion, "select *
                        from paxinas where idpaxina=$pag") or
                die("Problemas en el select: " . mysqli_error($conexion));  	
$reg2 = mysqli_fetch_assoc($registros2);
echo "
<h2>" . ucfirst($reg2['nome']) . "</h2>
<h5>" . $reg2['axuda'] . "</h5>";
?>
  <form action='enviar.php' class='needs-validation' novalidate method='post'>
    <div class='form-group'>
      <label for='nombre'>Nombre:</label>
      <input type='text' class='form-control' id='nombre' placeholder='Nombre' name='nombre' required>
      <div class='valid-feedback'>Ok.</div>
      <div class='invalid-feedback'>Por favor, cubre este campo.</div>
    </div>
    <div class='form-group'>
      <label for='correo'>Correo:</label>
      <input type='text' class='form-control' id='correo' placeholder='Correo' name='correo' required>
      <div class='valid-feedback'>Ok.</div>
      <div class='invalid-feedback'>Por favor, cubre este campo.</div>
    </div>
     <div class='form-group'>
      <label for='comentarios'>Comentarios:</label>
      <textarea class="form-control" rows="5" id="comentarios" name="comentarios"  required></textarea>
      <div class='valid-feedback'>Ok.</div>
      <div class='invalid-feedback'>Por favor, cubre este campo.</div>
    </div>
<!--    <div class='form-group form-check'>
      <label class='form-check-label'>
        <input class='form-check-input' type='checkbox' name='recibir'> Deseo recibir información periódica sobre cursos.
        <div class='valid-feedback'>Ok.</div>
        <div class='invalid-feedback'>Acepto la política de privacidad</div>
      </label>
    </div>
-->
    <button type='submit' class='btn btn-primary'>Enviar</button>
  </form>
<script>
(function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>  
<p class='text-center text-info'><small>Teléfono servicio técnico: 982 88 88 88</small></p>


      <br>
     <div class="col-sm-4">
     </div>   
  </div>
</div>
<?php include('pe.php'); ?>
</body>
</html>