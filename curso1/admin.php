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
$nome="administracion";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title><?php echo ucfirst($nome) . " de " . $_SESSION['nome_curso']; ?></title>
  <meta charset="utf-8">
  <link rel="icon" href="favicon.ico">
  <link rel="shortcut icon" href="favicon.ico">
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
if($_SESSION['nivel_usuario'] !=2 )
{
//en caso de no tener el nivel 2
echo "<p class='text-center text-danger'><strong>Acceso restringido</strong></p>";
echo "<p class='text-center'>No tienes el permiso de acceso necesario</p>";
}
else {
echo "<h4 class='text-center'><strong>Zona de Administración</strong></h4>";
echo "<p class='text-center text-info'>Acceso a datos. back-end (exclusivos para usuarios de nivel 2)</p>";
echo "<div class='table-responsive'>";
echo "<table class='table'>";
echo "<tr><td class='text-center'><strong><a href='admin-usuarios.php'>Administración de usuarios " . $_SESSION['nome_curso'] . "</a></strong><br/><span class='small'>Permite crear, modificar y borrar usuarios</span><br /><a class='btn btn-info' href='admin-usuarios.php'>Administrar usuarios</a></td></tr>";
echo "<tr><td class='text-center'><strong><a href='admin-paxinas-curso.php'>Administración de páginas " . $_SESSION['nome_curso'] . "</a></strong><br/><span class='small'>Permite decidir que p&aacute;ginas aparecen en el men&uacute;, y modificar los textos  de la p&aacute;gina de la página de ayuda</span><br /><a class='btn btn-info' href='admin-paxinas-curso.php'>Administrar páginas</a></td></tr>";
echo "<tr><td class='text-center'><strong><a href='admin-contidos-curso.php'>Administración de contenidos del curso " . $_SESSION['nome_curso'] . "</a></strong><br/><span class='small'>Permite crear, modificar y borrar los registros de contenidos del curso</span><br /><a class='btn btn-info' href='admin-contidos-curso.php'>Administrar contenidos</a></td></tr>";
echo "<tr><td class='text-center'><strong><a href='administrador.php'>Administración de archivos del curso " . $_SESSION['nome_curso'] . "</a></strong><br/><span class='small'>Permite administrar directorios y archivos del curso</span><br /><a class='btn btn-secondary' href='administrador.php'>Administrar archivos</a></td></tr>";
echo "<tr><td class='text-center'><strong><a href='ejercicios.php'>Subir ejercicios de " . $_SESSION['nome_curso'] . "</a></strong><br/><span class='small'>Permite subir archivos a la carpeta de descargas/ejercicios</span><br /><a class='btn btn-light' href='ejercicios.php'>Subir ejercicio para usuarios</a></td></tr>";
echo "<tr><td class='text-center'><strong><a href='recursos.php'>Subir recursos de " . $_SESSION['nome_curso'] . "</a></strong><br/><span class='small'>Permite subir archivos a la carpeta de descargas/recursos</span><br /><a class='btn btn-light' href='recursos.php'>Subir recurso para usuarios</a></td></tr>";
echo "<tr><td class='text-center'><strong><a href='consultarejercicios.php'>Consultar ejercicios de alumnos de " . $_SESSION['nome_curso'] . "</a></strong><br/><span class='small'>Permite consultar y descargar archivos de los alumnos de la carpeta de subidos</span><br /><a class='btn btn-success' href='consultarejercicios.php'>Ejercicios subidos por los usuarios</a></td></tr>";
echo "<tr><td class='text-center'><strong><a href='admin-categorias-foro.php'>Administración de categorías del foro " . $_SESSION['nome_curso'] . "</a></strong><br/><span class='small'>Permite crear, modificar y borrar categor&iacute;as del foro</span><br /><a class='btn btn-warning' href='admin-categorias-foro.php'>Administrar categorías del foro</a></td></tr>";
echo "<tr><td class='text-center'><strong><a href='admin-temas-foro.php'>Administración de temas del foro " . $_SESSION['nome_curso'] . "</a></strong><br/><span class='small'>Permite modificar y borrar temas del foro</span><br /><a class='btn btn-warning' href='admin-temas-foro.php'>Administrar temas del foro</a></td></tr>";
echo "<tr><td class='text-center'><strong><a href='admin-mensaxes-foro.php'>Administración de mensajes del foro " . $_SESSION['nome_curso'] . "</a></strong><br/><span class='small'>Permite modificar y borrar mensajes del foro</span><br /><a class='btn btn-warning' href='admin-mensaxes-foro.php'>Administrar mensajes del foro</a></td></tr>";
echo "<tr><td class='text-center'><strong><a href='admin-cursos.php'>ADMINISTRACIÓN DE CURSOS</a></strong><br/><span class='small'>Permite crear nuevos cursos, modificar y borrar cursos existentes</span><br /><a class='btn btn-dark' href='admin-cursos.php'>Administrar cursos</a></td></tr>";
echo "</table>";
echo "</div>";
}
?>
      <br>
     <div class="col-sm-2">
     </div>   
  </div>
</div>
<?php include('pe2.php'); ?>
</body>
</html>