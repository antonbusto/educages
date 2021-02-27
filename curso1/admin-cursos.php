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
$nome="administracion de cursos";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title><?php echo ucfirst($nome); ?></title>
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
     <div class="col-sm-1">
     </div> 
    <div class="col-sm-10">
<?php
if($_SESSION['nivel_usuario'] !=2 )
{
//en caso de no tener el nivel 2
echo "<p class='text-center text-danger'><strong>Acceso restringido</strong></p>";
echo "<p class='text-center'>No tienes el permiso de acceso necesario</p>";
}
else {
	echo "<h4 class='text-center'><strong>Administraci&oacute;n de Cursos</strong></h4>";

//se arma la consulta para los usuarios del curso
$sql="SELECT * 
	  FROM cursos";

//se ejecuta la consulta y se trata el posible error
$resultado = mysqli_query($conexion, $sql ) or die(mysqli_error($conexion));

//se recupera una fila de resultado como matriz asociativa
$fila = mysqli_fetch_assoc($resultado);

//la variable cuenta el número de filas de resultado
$total_filas = mysqli_num_rows($resultado);

echo "<p><a href='crear-cursos.php' title='Crear cursos' class='btn btn-success'>Crear nuevo curso</a></p>";

echo "<div class='table-responsive'>";
echo "<table class='table table-striped'>
        <tr>
		<th>id</th>
		<th>denominaci&oacute;n</th>
		<th>programa pdf</th>
		<th>horas</th>
		<th>inicio</th>
		<th>fin</th>
		<th>prezo</th>
		<th>Modificar</th>
		<th>Borrar</th>
		</tr>";
		
       /* se presenta el listado con todas las filas devueltas en la consulta
	   usando el bucle do para presentar el primer registro */
	    do {  
		
	    echo "
		<tr>
		<td valign='top'>" . $fila['id_curso'] . "</td>
		<td valign='top'>" . htmlentities($fila['nome_curso']) . "</td>
		<td valign='top'>" . $fila['programa_curso'] . "</td>
		<td valign='top'>" . $fila['duracion_curso'] . "</td>
		<td valign='top'>" . cambia($fila['inicio_curso']) . "</td>
		<td valign='top'>" . cambia($fila['fin_curso']) . "</td>
		<td valign='top'>" . $fila['prezo_curso'] . "</td>
		<td valign='top'><a href='modificar-cursos.php?id=" . $fila['id_curso'] . "' title='Modificar' class='btn btn-success'>Modificar</a></td>
		<td valign='top'><a href='eliminar-cursos.php?id=" . $fila['id_curso'] . "' title='Borrar' class='btn btn-danger'>Borrar</a></td>
		</tr>";
			 
		   } while ($fila = mysqli_fetch_assoc($resultado));

//se presenta el total de resultados y se cierra la tabla y el div
echo"
	<tr><td colspan='8' class='dereita'><strong>Total cursos:</strong></td><td><span class='badge badge-secondary'>" . $total_filas . "</span></td></tr>
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