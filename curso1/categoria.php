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
$nome="categoría foro";
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
     <div class="col-sm-2">
     </div> 
    <div class="col-sm-8">

<?php 
$sql = "SELECT
			id_categoria,
			nome_categoria,
			descricion_categoria
		FROM
			curso1_foro_categorias
		WHERE
			id_categoria = " . mysqli_real_escape_string($conexion, $_GET['id']);
$resultado = mysqli_query($conexion, $sql);
if(!$resultado)
{
	echo '<p class="text-center text-danger">La categor&iacute;a no se puede mostrar, por favor, inténtelo de nuevo m&aacute;s tarde.' . mysqli_error($conexion) . '</p>';
}
else
{
	if(mysqli_num_rows($resultado) == 0)
	{
		echo '<p class="text-center text-danger">Esa categor&iacute;a no existe.</p>';
	}
	else
	{
		//mostramos los datos de la categoría
		while($fila = mysqli_fetch_assoc($resultado))
		{
			echo '<p class="text-center"><strong>' . $fila['nome_categoria'] . '</strong></p><br />';
		}
	
		/*se inserta el tema en la tabla temas, usando la función mysqli_real_escape_string 
		para evitar inyección de código */
		$sql = "SELECT	
					id_tema,
					asunto_tema,
					data_tema,
					categoria_tema
				FROM
					curso1_foro_temas
				WHERE
					categoria_tema = " . mysqli_real_escape_string($conexion, $_GET['id']);
		
		//se ejecuta la consulta
		$resultado = mysqli_query($conexion, $sql);
		
		//si la consulta falla
		if(!$resultado)
		{
			echo '<p class="text-center text-danger">Los temas no se puede mostrar, por favor, inténtelo de nuevo más tarde. '. mysqli_error($conexion).'</p>';
		}
		else
		{
			//si la consuta no devuelve resultado
			if(mysqli_num_rows($resultado) == 0)
			{
				echo '<p class="text-center text-success">No hay temas en esta categoria.</p>';
				echo '<p class="text-center"><a <a class="btn btn-success" href="crear-tema.php">Crear nuevo Tema</a>  <a class="btn btn-primary" href="foro.php">Volver al Foro</a></p>';
			}
			else
			{
				//todo ha ido bien, se prepara la tabla
				echo '<div id="categorias"><table class="table table-bordered table-hover">
					  <tr>
						<th>Temas</th>
						<th>Creado el</th>
					  </tr>';	
					
				/*se listan todas las filas de la tabla temas convirtiendo las posibles etiquetas 
				introducidas en el campo asunto en entidades en html */
				while($fila = mysqli_fetch_assoc($resultado))
				{				
					echo '<tr>';
						echo '<td width="50%">';
							echo '<a href="tema.php?id=' . $fila['id_tema'] . '">' . htmlentities($fila['asunto_tema']) . '</a><br />';
						echo '</td>';
						echo '<td class="dereita">';
							echo date('d-m-Y', strtotime($fila['data_tema']));
						echo '</td>';
					echo '</tr>';
				}
									 echo '<tr>
						<td colspan="2" class="text-center"><a <a class="btn btn-success" href="crear-tema.php">Crear nuevo Tema</a>  <a class="btn btn-primary" href="foro.php">Volver al Foro</a></td>
					  </tr>';	
					echo '</div>';
			}
		}
	}
}
echo '</table>';
?>
</div>
      <br>
     <div class="col-sm-2">
     </div>   
  </div>
</div>
<?php include('pe2.php'); ?>
</body>
</html>