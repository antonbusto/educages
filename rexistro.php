<!DOCTYPE html>
<html lang="es">
<head>
  <title>Registro</title>
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
</head>
<body id="arriba">
<?php 
include('cabecera.php'); 
include('menu.php'); 
require_once('funcions.php'); 
?>
  <div class="row" style="margin-top:40px;">
     <div class="col-sm-3">
     </div> 
    <div class="col-sm-6">
<?php 
	/*la variable se usará para insertar automaticamente la fecha con el formato típico de mysql, 
	irá en un campo oculto del formulario */
	$date = date("Y-m-d"); 
	
	//se recoge el valor de la variable curso pasada por el método GET
	$curso=$_GET['curso']; 
	
	//se imprime el titular recogiendo el valor de la variable nombre de curso pasada por el método GET
	$nome_curso=$_GET['nome_curso']; 
	echo "<h2 class='text-center'><strong>Curso de " . $nome_curso . "</strong></h2>";

if(!$_POST)
{
    /*Aún no se ha enviado el formulario, se enviará en esta misma página al ser action="" 
	uso comillas dobles para poder procesar las variables insertadas en los campos ocultos*/
    echo "
	<div id='formulario'>
	<form method='post' action='' class='needs-validation' novalidate>
	<div class='form-group'>
    <label for='nome_usuario'>Nombre:</label>
    <input type='text' class='form-control' name='nome_usuario' id='nome_usuario' placeholder='' required>
	<div class='valid-feedback'>Ok.</div>
    <div class='invalid-feedback'>Por favor, cubre este campo.</div>
	</div>
	<div class='form-group'>
    <label for='contrasinal_usuario'>Contrase&ntilde;a (*):</label>
    <input type='password' class='form-control' name='contrasinal_usuario' id='contrasinal_usuario' placeholder='' required>
	<div class='valid-feedback'>Ok.</div>
    <div class='invalid-feedback'>Por favor, cubre este campo.</div>
	</div>
	<div class='form-group'>
    <label for='contrasinal_usuario_chequeo'>Repite contrase&ntilde;a:</label>
    <input type='password' class='form-control' name='contrasinal_usuario_chequeo' id='contrasinal_usuario_chequeo' placeholder='' required>
	<div class='valid-feedback'>Ok.</div>
    <div class='invalid-feedback'>Por favor, cubre este campo.</div>
	</div>
	<div class='form-group'>
	<label for='email_usuario'>Correo:</label>
	<input type='text' class='form-control' id='email_usuario' placeholder='' name='email_usuario' required>
	<div class='valid-feedback'>Ok.</div>
	<div class='invalid-feedback'>Por favor, cubre este campo.</div>
	</div> 
	<div class='form-group'>
	<label for='telefono_usuario'>Tel&eacute;fono:</label>
	<input type='text' class='form-control' id='telefono_usuario' placeholder='' name='telefono_usuario' required>
	<div class='valid-feedback'>Ok.</div>
	<div class='invalid-feedback'>Por favor, cubre este campo.</div>
	</div>
	<button type='submit' class='btn btn-primary'>Enviar</button>
    <input name='data_usuario' type='hidden' value='" . $date . "' />
    <input name='curso' type='hidden' value='" . $curso . "'/>
    <input name='nivel_usuario' type='hidden' value='0' />	
    </form>
    </div>
    <p class='text-left text-info'><small>(*) No est&aacute;n permitidos espacios en blanco ni s&iacute;mbolos especiales.</small></p>";
}
else
{
    /* El formulario se ha enviado, procesamos los pasos en cinco etapas:
		1.	Validación de los datos, con tratamiento de errores a través de un array
		2.	Informar y permitir al usuario rellenar los campos incorrectos (si es necesario)
		3.	Guardar los datos en la tabla usuarios de la base de datos (evitando inyección de código)
		4.  Tratamiento de los posibles errores en la conexión
		5.  Se informa al usuario si todo ha ido bien, y de cual es su estado en el curso
	*/
	$erros = array(); /* declarar el array de errores para su uso posterior */
	
	//si el nombre de usuario está definido y no está en blanco
	if(isset($_POST['nome_usuario'] ) && $_POST['nome_usuario'] != "")
	{
		//validación del nombre de usuario
		if(!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/",$_POST['nome_usuario']))
		{
			$erros[] = "El nombre de usuario s&oacute;lo puede contener letras y n&uacute;meros. <br />No pueden contener espacios en blanco ni caracteres especiales";
		}
		if(strlen($_POST['nome_usuario']) > 20)
		{
			$erros[] = "El nombre de usuario no puede ser superior a 20 caracteres.";
		}
	}
	else
	{
		$erros[] = "El campo nombre de usuario no debe estar vac&iacute;o.";
	}
	
	/*validación de la contraseña, se comprueba que está definida y no está en blanco 
	también se comprueba que las dos contraseñas sean iguales*/
	if(isset($_POST['contrasinal_usuario']) && $_POST['contrasinal_usuario'] != "")
	{
		if($_POST['contrasinal_usuario'] != $_POST['contrasinal_usuario_chequeo'])
		{
			$erros[] = "Las dos contrase&ntilde;as deben ser iguales";
		}
		if(strlen($_POST['contrasinal_usuario']) > 20)
		{
			$erros[] = "La contrase&ntilde;a no debe ser superior a 20 caracteres.";
		}

	}
	else
	{
		$erros[] = "Es necesario escribir la contrase&ntilde;a.";
	}
	
	/*validación del correo electrónico, se comprueba que está definido y no está en blanco
	y se usa la función de usuario validacorreo()para comprobar que es una dirección correcta*/
	if(isset($_POST['email_usuario']) && $_POST['email_usuario'] != "")
	{
		//validación del nombre de usuario
		if(!validacorreo($_POST['email_usuario']))
		{
			$erros[] = "La direcci&oacute;n de correo no es v&aacute;lida";
		}
	}
	else
	{
		$erros[] = "El campo correo no puede estar en blanco.";
	}

	/* Validación del teléfono. Se comprueba si está definido y si no está en blanco
	sólo se permite escribir números, no se compara con ningún patrón de expresión regular */
	if(isset($_POST['telefono_usuario'] ) && $_POST['telefono_usuario'] != "")
	{
		if(!is_numeric($_POST['telefono_usuario']))
		{
			$erros[] = "El campo tel&eacute;fono s&oacute;lo puede contener n&uacute;meros";
		}
	}
	else
	{
		$erros[] = "El campo tel&eacute;fono no debe estar vac&iacute;o.";
	}

	
	/*Comprobamos el array de errores*/
	if(!empty($erros)) 
	{
		echo "<p class='text-center'><strong>Han ocurrido los siguientes problemas:</strong></p>";
		foreach($erros as $key => $valor) /* se recorre el array para recoger todos los errores*/
		{
			echo "<p class='text-center text-danger'>" . $valor . "</p>"; /* se presenta el error */
		}
			echo "<p class='text-center'><a class='btn btn-primary' href='rexistro.php?curso=" . $curso . "&amp;nome_curso=" . $nome_curso . " '>Volver</a></p>"; /*se permite al usuario volver */
	}
	else
	{
			//El formulario se envió sin errores, se arma la consulta sql
			//se usa mysqli_real_escape_string, para evitar inyección de código
			//los campos data_usuario y curso se enviaron ocultos
			//el nivel 0 significa preinscrito, no podrá acceder a los cursos hasta tener el nivel 1 (se lo otorgará el adminisrador)
		$sql = "INSERT INTO
					usuarios(nome_usuario, contrasinal_usuario, email_usuario, data_usuario, telefono_usuario, curso, nivel_usuario)
				VALUES('" . mysqli_real_escape_string($conexion, $_POST['nome_usuario']) . "',
					   '" . mysqli_real_escape_string($conexion, $_POST['contrasinal_usuario']) . "',
					   '" . mysqli_real_escape_string($conexion, $_POST['email_usuario']) . "',
					   '" . $_POST['data_usuario'] . "',
					   '" . mysqli_real_escape_string($conexion, $_POST['telefono_usuario']) . "',
					   '" . $_POST['curso'] . "',
						0)";
		//se ejecuta la consulta				
		$resultado = mysqli_query($conexion, $sql ) or die(mysqli_error($conexion));
		
		if(!$resultado)
		{
			//En el caso de no poder realizarse la consulta se muestra el error
			echo "<p class='text-center text-danger'><strong>Ha ocurrido un problema t&eacute;cnico al hacer la preinscripci&oacute;n</strong>. 
			<br />Por favor, int&eacute;ntalo m&aacute;s tarde.<br />
			Si el problema persiste, contacta con el administrador <a href='contactar.php'>Contactar</a></p>
			<p class='text-center'><a class='btn btn-primary' href='rexistro.php?curso=" . $curso . "&amp;nome_curso=" . $curso . "  '>Volver</a></p>
			<p class='text-center'>Error: " . mysqli_error($conexion) . "</p>" ;  // Informaría del error con fines de depuración
		}
		else
		{
			echo "<p class='text-center text-success'><strong>Preinscripci&oacute;n Correcta</strong></p><p class='text-center'>Ahora debes esperar a que un administrador <br />
			confirme la inscripci&oacute;n para poder acceder al curso.</p>";
		}
	}
}
?>
      <br>
     <div class="col-sm-3">
     </div>   
  </div>
</div>
<?php include('pe.php'); ?>
</body>
</html>