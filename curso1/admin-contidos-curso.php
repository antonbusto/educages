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
$nome="administración";
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
     <div class="col-sm-1">
     </div> 
    <div class="col-sm-10">
<?php
if($_SESSION['nivel_usuario'] !=2 )
{
	//si un usuario con nivel 1 introduce directamente la dirección
echo "<h3 class='text-center text-danger'>Acceso restringido</h3>";
echo "<p class='text-center'>No tienes el permiso de acceso necesario</p>";

}
else {
echo "<h4 class='text-center'><strong>Administraci&oacute;n de contenidos de curso" . $_SESSION['curso'] . " | ".$_SESSION['nome_curso'] ."</strong></h4>";

//se arma la consulta para los usuarios del curso
$sql="SELECT * 
	  FROM curso" . $_SESSION['curso'] . "";

//se ejecuta la consulta y se trata el posible error
$resultado = mysqli_query($conexion, $sql ) or die(mysqli_error($conexion));

//se recupera una fila de resultado como matriz asociativa
$fila = mysqli_fetch_assoc($resultado);

//la variable cuenta el número de filas de resultado
$total_filas = mysqli_num_rows($resultado);
echo"<p class='small'>El campo Tipo determina en que página del menú aparecen los contenidos.
<br/>El campo Nombre determina el texto del vínculo para cargar la página detalle.
<br/>El campo Texto son los contenidos de la página detalle.</p>";
echo "<p><a href='crear-contidos-curso.php' title='Crear contenidos' class='btn btn-success'>Crear nuevo registro</a></p>";

echo" <div class='table-responsive'><table class='table table-striped'> 
        <tr>
		<th>id</th>
		<th>Nombre</th>
		<th>Tipo</th>
		<th>Foto</th>
		<th>Texto</th>
		<th>Modificar</th>
		<th>Borrar</th>
		</tr>";
		
	    do {  
		
	    echo "
		<tr>
		<td valign='top'>" . $fila['id'] . "</td>
		<td valign='top'>" . htmlentities($fila['nome']) . "</td>
		<td valign='top'>" . $fila['tipo'] . "</td>
		<td valign='top'>" . $fila['foto'] . "</td>
		<td valign='top'>" . htmlentities($fila['texto']) . "</td>
		<td valign='top'><a href='modificar-contidos-curso.php?id=" . $fila['id'] . "' title='Modificar' class='btn btn-success'>Modificar</a></td>
		<td valign='top'><a href='eliminar-contidos-curso.php?id=" . $fila['id'] . "' title='Borrar' class='btn btn-danger'>Borrar</a>
		</tr>";
			 
		   } while ($fila = mysqli_fetch_assoc($resultado));
echo"
	<tr><td colspan='6'><strong>Total registros:</strong></td><td><span class='badge badge-secondary'>" . $total_filas . "</span></td></tr>
	</table> </div>";

echo "<p class='text-center'><a class='btn btn-primary' href='admin.php'>Zona de Administraci&oacute;n</a></p>";
}
?>
      <br>
     <div class="col-sm-1">
     </div>   
  </div>
</div>
<?php include('pe2.php'); ?>
</body>
</html>