<!DOCTYPE html>
<html lang="es">
<head>
  <title>Enviar correo</title>
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
<?php   require('funcions.php');?>
  <div class="row" style="margin-top:40px;">
     <div class="col-sm-4">
     </div> 
    <div class="col-sm-4">
<?php
  
	//se definen los valores de las variables para usar con la función mail
	$destinatario = "tabladeflandes@gmail.com"; //correo del administrador
	$asunto = "Comentarios Web";
	$mensaxe = "Enviado:\n\n";
	
	//usando foreach se recorren los valores del array $_POST y se almacenan en la variable mensaje
	foreach($_POST as $name => $valor) {
	$mensaxe .= "$name: $valor\n";
	}
	
	//compruebo que todos los campos han sido definidos y no están en blanco
	if (isset($_POST['nombre']) && $_POST['nombre'] != "" && isset($_POST['comentarios'])&& $_POST['comentarios'] != "" && isset($_POST['correo']) && $_POST['correo'] != ""  ){
		
			//usando la función para validar correo se comprueba que sea válido
			if (validacorreo($_POST['correo'])) {
			
				//se guarda la dirección de correo con la finalidad de usarla como remitente en la función mail
				$remite = $_POST['correo'];
				
				//se comprueba si la función mail ha funcionado
				if (mail($destinatario, $asunto, $mensaxe, "De: $remite")) {
				
				//se informa al usuario de que el correo se ha enviado
				echo "<h4 class='text-center text-info'>Enviado con &eacute;xito</h4>
				<p class='text-center text-sucess'>Su mensaje ha sido enviado. <br /> Muchas Gracias por contactar.</p>\n";
				
				}else {
				
				//en caso contrario se informa de que no se ha podido enviar
				echo "<p class='text-center text-danger'>Error en el envio</p>
				<p class='text-center'>Ha sucedido un error al enviar su mensaje. <br />Por favor, int&eacute;ntalo de nuevo m&aacute;s tarde";
				echo "Si contin&uacute;a el error, puede contactar con el administrador en el tel&eacute;fono 982888888</p>\n";
				}
	
	} else {
		
		//en el caso de que la función validacorreo devuelva false
		echo "<p class='text-center text-danger'>Error en la direcci&oacute;n de correo</p>
		<p class='text-center'>La direcci&oacute;n de correo no es v&aacute;lida <br />";
		echo "<a href='contactar.php'  class='btn btn-warning'>Volver</a></p>\n";
		}
			} else {
				
			//mensajes que aparecen en el caso de que alguna variable no se haya definido o estea vacía
			echo "<p class='text-center text-danger'>No has rellenado todos los datos</p>
			<p class='text-center'>Es obligatorio rellenar todos los campos <br />" . $mensaxe;
			echo "<a href='contactar.php'  class='btn btn-warning'>Volver</a></p>\n";
			}
?>
      <br>
     <div class="col-sm-4">
     </div>   
  </div>
</div>
<?php include('pe.php'); ?>
</body>
</html>