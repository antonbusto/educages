<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Conectar</title>
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
        include ('cabecera.php');
        include ('menu.php');
        ?>
  <div class="row" style="margin-top:40px;">
     <div class="col-sm-4">
     </div> 
    <div class="col-sm-4">
      <?php
                    echo '<h2 class="text-center">Acceso de usuarios</h2>';

//se comprueba si el usuario está conectado
                    if (isset($_SESSION['conectado']) && $_SESSION['conectado'] == true) {
                        echo '<h5 class="text-center text-success">Ya est&aacute;s conectado</h5>
						<p class="text-center"><a class="btn btn-warning" href="desconectar.php">Desconectar</a></p>';
                    } else { //si no está conectado
                        if (!$_POST) { //Si aún no se ha enviado el formulario 
                            echo "
					<form method='post' action='' class='needs-validation' novalidate>
						<div class='form-group'>
						  <label for='email_usuario'>Correo:</label>
						  <input type='text' class='form-control' id='email_usuario' placeholder='' name='email_usuario' required>
						  <div class='valid-feedback'>Ok.</div>
                          <div class='invalid-feedback'>Por favor, cubre este campo.</div>
						</div>
						<div class='form-group'>
						  <label for='contrasinal_usuario'>Contraseña:</label>
						  <input type='password' class='form-control' id='contrasinal_usuario' placeholder='' name='contrasinal_usuario' required>
						  <div class='valid-feedback'>Ok.</div>
                          <div class='invalid-feedback'>Por favor, cubre este campo.</div>
						</div>		  
						<button type='submit' class='btn btn-primary'>Enviar</button>
					<p class='text-center'>&nbsp;</p>
					<p class='text-center'><a href='recordar.php'>&iquest;Has olvidado tu contrase&ntilde;a?</a></p>
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
                        } else { //si el formulario se ha enviado

                            $erros = array(); // se crea el array para procesar los mensajes de error y comienza la validación de datos
                            //si el correo de usuario no está definido o está en blanco	
                            if (!isset($_POST['email_usuario']) or ($_POST['email_usuario'] == "")) {
                                $erros[] = 'El c&oacute;rreo electr&oacute;nico no debe estar vac&iacute;o.';
                            }

                            //Si no se ha definido la variable de contraseña o está vacía
                            if (!isset($_POST['contrasinal_usuario']) or $_POST['contrasinal_usuario'] == "") {
                                $erros[] = 'La contrase&ntilde;a no debe estar en blanco.';
                            }

                            if (!empty($erros)) {  // Si el array de errores no está vacio
                                echo '<h5 class="text-center">Los campos no se han rellenado correctamente</h5>';
                                foreach ($erros as $key => $valor) { // recorre el array para recoger todos los errores 
                                    echo '<p class="text-center text-danger">' . $valor . '</p>'; /* se presenta el error */
                                }
                                echo '<p class="text-center"><a class="btn btn-primary" href="conectar.php">Volver</a></p>'; /* se permite al usuario volver */
                            } else {
                                /* El formulario se envió y pasa la validación. Se arma la consulta
                                  usando en los campos del formulario mysqli_real_escape_string para evitar inyección de código */

                                $sql = "SELECT 
						usuarios.id_usuario,
						usuarios.nome_usuario,
						usuarios.nivel_usuario,
						usuarios.curso,
						cursos.nome_curso
					FROM
						usuarios
					LEFT JOIN
						cursos
					ON
						usuarios.curso = cursos.id_curso
					WHERE
						usuarios.email_usuario = '" . mysqli_real_escape_string($conexion, $_POST['email_usuario']) . "'
					AND
						usuarios.contrasinal_usuario = '" . mysqli_real_escape_string($conexion, $_POST['contrasinal_usuario']) . "'";

                                //se ejecuta la consulta
                                $resultado = mysqli_query($conexion, $sql);

                                //en el caso de que no haya resultado
                                if (!$resultado) {
                                    //se muestra el error personalizado al usuario
                                    echo '<h5 class="text-center">No se puede conectar</h5>
				      <p class="text-center text-danger"> Comprueba el correo o la contrase&ntilde;a e int&eacute;ntalo de nuevo.<br />
					  Si el problema persiste, contacta con el administrador <a href="contactar.php">Contactar</a></p>
					  <p class="text-center"><a class="btn btn-primary" href="conectar.php">Volver</a></p>';
                                    echo '<p class="text-center text-danger">Error: ' . mysqli_error($conexion) . '</p>';  // Informaría del error con fines de depuración
                                } else { //la consulta se ejecutó con éxito
                                    /* la consulta devuelve un conjunto de datos vacío, por lo tanto estaban mal los datos de acceso
                                      o bien el usuario no está registrado */
                                    if (mysqli_num_rows($resultado) == 0) {
                                        echo '<h5 class="text-center">Los datos no son correctos</h5>
					      <p class="text-center text-danger">Hay un error en el correo o en la contrase&ntilde;a.</p> 
						  <p class="text-center"><a class="btn btn-primary" href="conectar.php">Volver</a></p>';
                                    } else { //la consulta devuelve los datos del usuario, todo ha ido bien 
                                        //cuenta las filas de resultado, cada fila será un curso
                                        $total_cursos = mysqli_num_rows($resultado);

                                        //Se indica que está conectado en el array de sesión
                                        $_SESSION['conectado'] = true;
                                        $identificador = session_id();

                                        //presenta el titular de los cursos
                                        echo '<h5 class="text-center text-success">Tus cursos (' . $total_cursos . ')</h5>';

                                        /* Usando un bucle while se recorren los valores de la tabla y se clasifica atendiendo al nivel de usuario 
                                          Nivel 0: usuario pendiente de aprobación en el curso por el administrador. Aún no puede acceder a los contenidos y no tendrá vínculo
                                          Nivel 1: usuario aprobado para el curso por el administrador. Con vínculo/s que le llevará/n a la página del/os curso/s
                                          Nivel 2 un administrador. Entrará con ese nivel en la/s página/s del/os curso/s */
                                        while ($fila = mysqli_fetch_assoc($resultado)) {
                                            if ($fila['nivel_usuario'] == 1 or $fila['nivel_usuario'] == 2) {
                                                echo '<p class="text-center text-success"><strong>Curso con acceso: <a href="curso' . $fila['curso'] . '/1.php">Curso ' . $fila['nome_curso'] . '</a></strong></p>							</p>';
                                                $_SESSION['id_usuario'] = $fila['id_usuario'];
                                                $_SESSION['nome_usuario'] = $fila['nome_usuario'];
                                                $_SESSION['nivel_usuario'] = $fila['nivel_usuario'];
                                                $_SESSION['curso'] = $fila['curso'];
                                                $_SESSION['nome_curso'] = $fila['nome_curso'];
                                                $_SESSION['identificador'] = session_id();
                                            }
                                            if ($fila['nivel_usuario'] == 0) {
                                                echo '<p class="text-center text-warning">Pendiente de aprobaci&oacute;n: ' . $fila['nome_curso'] . '</p>';
                                            }
                                        }
                                        //se introducen los valores en el array de sesión para poder usarlos en otras páginas
                                        echo '<p class="text-center"><strong>' . $_SESSION['nome_usuario'] . '</strong>  <a class="btn btn-warning" href="desconectar.php">Desconectar</a></p>';
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
</body>
<?php include('pe.php'); ?>
?>