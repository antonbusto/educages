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
echo "<h4 class='text-center text-danger'>Acceso restringido</h4>";
echo "<p class='text-center'>No tienes el permiso de acceso necesario</p>";

}
else {
echo "<h4 class='text-center'><strong>Administraci&oacute;n de páginas de curso" . $_SESSION['curso'] . " | ".$_SESSION['nome_curso'] ."</strong></h4>";

//se aclara el significado del algunos campos
echo "<p class='small'>Si el valor de Pos: 1 esa página aparece en el men&uacute;. Si es 0 no se ver&aacute; en  el men&uacute.
<br/>P&aacute;gina: nombre del archivo php.  
<br/>Nombre: texto en el men&uacute; (campo Tipo de la tabla de contenidos, permite filtrar y agrupar registros de la tabla de contenidos).
<br />Ayuda: Textos de la p&aacute;gina de ayuda.</p>";

//se arma la consulta para los usuarios del curso
$sql="SELECT * 
	  FROM curso" . $_SESSION['curso'] . "_paxinas";

//se ejecuta la consulta y se trata el posible error
$resultado = mysqli_query($conexion, $sql ) or die(mysqli_error($conexion));

//se recupera una fila de resultado como matriz asociativa
$fila = mysqli_fetch_assoc($resultado);

//la variable cuenta el número de filas de resultado
$total_filas = mysqli_num_rows($resultado);
echo "<p><a href='engadir-pagina.php' title='Añadir página' class='btn btn-success' target='_blank'>Añadir nueva página a la tabla</a></p>";

echo" <div class='table-responsive'>
<table class='table table-striped'>
        <tr>
		<th>id</th>
		<th>P&aacute;gina</th>
		<th>Pos</th>
		<th>Nombre</th>
		<th>Ayuda</th>
		<th>Foto</th>
		<th>Texto</th>
		<th>Modificar</th>
		</tr>";
		
       /* se presenta el listado con todas las filas devueltas en la consulta
	   usando el bucle do para presentar el primer registro */
	    do {  
		
	    echo "
		<tr>
		<td>" . $fila['idpaxina'] . "</td>
		<td valign='top'>" . htmlentities($fila['paxina']) . "</td>
		<td valign='top'>" . $fila['posicion'] . "</td>
		<td valign='top'>" . $fila['nome'] . "</td>
		<td valign='top'>" . $fila['axuda'] . "</td>
		<td valign='top'>" . $fila['foto'] . "</td>
		<td valign='top'>" . $fila['texto'] . "</td>
		<td valign='top'><a href='modificar-paxina-curso.php?id=" . $fila['idpaxina'] . "' title='Modificar' class='btn btn-success'>Modificar</a></td>
		</tr>";
			 
		   } while ($fila = mysqli_fetch_assoc($resultado));

//se presenta el total de resultados y se cierra la tabla y el div
echo"
	<tr><td colspan='7' class='dereita'><strong>Total p&aacute;ginas:</strong></td><td class='dereita'><span class='badge badge-secondary'>" . $total_filas . "</span></td></tr>
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