<!DOCTYPE html>
<html lang="es">
<head>
<title>Recordar contraseña</title>
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
        session_start();
        include ('cabecera.php');
        include ('menu.php');
		include ('funcions.php');
        ?>
  <div class="row" style="margin-top:40px;">
     <div class="col-sm-4">
     </div> 
    <div class="col-sm-4">
      <?php
echo "<h1 class='text-center'>Recuperar la contrase&ntilde;a</h1>";

  if(!$_POST) //Si aún no se ha enviado el formulario 
	{
		  echo "
		  <form method='post' action='' class='needs-validation' novalidate>
			<div class='form-group'>
			  <label for='nome_usuario'>Usuario:</label>
			  <input type='text' class='form-control' id='nome_usuario' placeholder='' name='nome_usuario' required>
			  <div class='valid-feedback'>Ok.</div>
			  <div class='invalid-feedback'>Por favor, cubre este campo.</div>
			</div>
			<div class='form-group'>
			  <label for='pwd'>Correo:</label>
			  <input type='text' class='form-control' id='email_usuario' placeholder='' name='email_usuario' required>
			  <div class='valid-feedback'>Ok.</div>
			  <div class='invalid-feedback'>Por favor, cubre este campo.</div>
			</div>
		  <p class='dereita'><button type='submit' class='btn btn-primary'>Siguiente</button></p>
		  <p class='text-center text-info'>Recibir&aacute;s la contrase&ntilde;a en tu correo electr&oacute;nico</p>
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
		</script>";
	}
	else //si el formulario se ha enviado
	{

     $erros = array(); // se crea el array para procesar los mensajes de error y comienza la validación de datos
		
        //si el nombre de usuario no está definido o está en blanco	
		if(!isset($_POST['nome_usuario']) or ($_POST['nome_usuario'] == "") )
		{
			$erros[] = "El nombre de usuario no debe estar vac&iacute;o.";
		}
		
	/*validación del correo electrónico, se comprueba que está definido y no está en blanco
	y se usa la función de usuario validacorreo() para comprobar que es una dirección correcta*/
	if(isset($_POST['email_usuario']) && $_POST['email_usuario'] != "")
	{
		//validación del nombre de usuario
		if(!validacorreo($_POST['email_usuario']))
		{
			$erros[] = "La direcci&oacute;n de correo no es v&aacute;lida";
		}
	}
	
		if(!empty($erros))  // Si el array de errores no está vacio
		{
			echo "<h5>Los campos no se han rellenado correctamente</h5>";
			foreach($erros as $key => $valor) // recorre el array para recoger todos los errores 
			{
				echo "<p class='text-center text-danger'>" . $valor . "</p>"; /* se presenta el error */
			}
		    echo "<p class='text-center'><a href='recordar.php'>Volver</a></p>"; /*se permite al usuario volver */
	}
		else
		{
			/* El formulario se envió y pasa la validación. Se arma la consulta
			usando en los campos del formulario mysqli_real_escape_string para evitar inyección de código */
			
			//mysqli_select_db( $database_cursos, $conexion);
			
			$sql = "SELECT 
						usuarios.id_usuario,
						usuarios.contrasinal_usuario,
						usuarios.email_usuario
					FROM
						usuarios
					WHERE
						usuarios.nome_usuario = '" . mysqli_real_escape_string($conexion, $_POST['nome_usuario']) . "'
					AND
						usuarios.email_usuario = '" . mysqli_real_escape_string($conexion, $_POST['email_usuario']) . "'";
							
			//se ejecuta la consulta
			$resultado = mysqli_query($conexion, $sql);
						
			//en el caso de que no haya resultado
			if(!$resultado)
			{
				//se muestra el error personalizado al usuario
				echo "<h5 >No se puede conectar</h5>
				      <p class='text-center text-danger'> Comprueba el nombre de usuario y la contrase&ntilde;a e int&eacute;ntalo de nuevo.<br />
					  Si el problema persiste, contacta con el administrador <a href='contactar.php'>Contactar</a></p>
					  <p class='text-center'><a href='conectar.php'>Volver</a></p>";
				echo "<p class='text-center'>Error: " . mysqli_error($conexion) . "</p>" ;  // Informaría del error con fines de depuración
			}
			
			else //la consulta se ejecutó con éxito
			
			{
				/*la consulta devuelve un conjunto de datos vacío, por lo tanto estaban mal los datos de acceso
				o bien el usuario no está registrado */
				if(mysqli_num_rows($resultado) == 0)
				{
					echo "<h5 >Los datos no son correctos</h5>
					      <p class='text-center text-danger'>Hay un error en el nombre de usuario o en la contrase&ntilde;a.</p> 
						  <p class='text-center'><a href='conectar.php'>Volver</a></p>";
				}
				
				else // todo ha ido bien 
				
				{			
					//se recupera la fila del resultado de la consulta y se almacena en las variables el nombre y el correo
					$fila = mysqli_fetch_assoc($resultado);
					$contrasinal =  $fila['contrasinal_usuario'];
					$destino = $fila['email_usuario'];
					
					//se definen el resto de los valores de las variables para usar con la función mail
					$asunto = "Su clave de acceso para la web de cursos";
					$mensaxe = "Su clave de acceso es: \n\n";
					$mensaxe .= "$contrasinal \n";
								
				//se comprueba si la función mail ha funcionado
				if (mail($destino, $asunto, $mensaxe)) {
				
				//se informa al usuario de que el correo se ha enviado
				echo "<h5 class='text-center'>Contrase&ntilde;a enviada con &eacute;xito</h5>
				<p class='text-center text-success'>La contrase&ntilde;a ha sido enviada a su correo electr&oacute;nico: " . $destino . "</p>\n";
				
				}else {
				
				//en caso contrario se informa de que no se ha podido enviar
				echo "<h5 >Error en el envio</h5>
				<p class='text-center text-danger'>Ha sucedido un error al enviar la contrase&ntilde;a. <br />Por favor, int&eacute;ntalo de nuevo m&aacute;s tarde";
				echo "Si contin&uacute;a el error, puede contactar con el administrador en el tel&eacute;fono 982000000</p>\n";
				}					
				
				}
			}
		}
	}
 ?>
   <div class="col-sm-4">
  </div> 
  </div>
</div>
<?php include('pe.php'); ?>
