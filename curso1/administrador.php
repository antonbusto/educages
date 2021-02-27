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
$nome="administrador de archivos";
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
     <div class="col-sm-3">
     </div> 
    <div class="col-sm-6">
<?php
if($_SESSION['nivel_usuario'] !=2 )
{
	//si un usuario con nivel 1 introduce directamente la direcci�n
echo "<h3 class='text-center text-danger'>Acceso restringido</h3>";
echo "<p class='text-center'>No tienes el permiso de acceso necesario</p>";

}
else {
if (!isset($_GET['directorio']) || $_GET['directorio'] == ".")
   {
   $directorio = ".";
   $nombre_directorio = " directorio raíz del curso";
   }
else	 
   {
   $directorio = $_GET['directorio'];
   $nombre_directorio = " directorio " . basename($directorio);
   }

// Cambio al directorio que se ha recibido como par�metro
if (!chdir($directorio))
   die("<h4 class='text-center text-warnig'>Error: no se puede acceder a este directorio</h4>");
echo "<h4 class='text-center'>Archivos del$nombre_directorio</h4>\n",
     "<table class='table table-hover'>\n";

// Abrimos un manejador del directorio
$manejador = opendir(".");

// Procesamos todos los elementos del directorio 
// que son a su vez directorios
while ($elemento = readdir($manejador))
   {
   if (is_dir($elemento) && 
      ($elemento != "." && !($directorio == "." && 
       $elemento == "..")))
      {
      if ($elemento == "..")
         {
         $ruta = dirname($directorio);
         $item = "Directorio Anterior";
         }
      else
         {
         $ruta = "$directorio/$elemento";
         $item = "$elemento";
         }
      echo "<tr>\n",
           "<td>\n",
           "<a href='administrador.php?directorio=",
            rawurlencode($ruta), "'>\n",
           "<img src='../imaxes/directorio.gif'", 
           " alt='Cambiar a $elemento' title='Cambiar a $elemento' border='0' />",
           "</a>\n",
           "</td>\n",
           "<td>$item</td>\n",
           "<td width='100'></td>\n",
           "<td>\n",
           "<a class='btn btn-success' href='operaciones_directorio.php?",
           "directorio=", rawurlencode($ruta), "'>\n",
           " Operaciones",
           "</a>\n",
           "</td>\n",
           "</tr>\n";
      }	
   }
   
// Rebobinamos el manejador
rewinddir($manejador);

// Procesamos todos los elementos del directorio que son ficheros
while ($elemento = readdir($manejador))
   {
   if (!is_dir($elemento))
      echo "<tr>\n",
           "<td>\n",
           "<a href='$directorio/$elemento'>\n",
           "<img src='../imaxes/fichero.gif'" , 
           " alt='Visualizar $elemento' title='Visualizar $elemento' border='0' />",
           "</a>\n",
           "</td>\n",
           "<td>$elemento</td>\n",
           "<td width='100'></td>\n",
           "<td>\n",
           "<a class='btn btn-success' href='operaciones_fichero.php?directorio=" ,
            rawurlencode("$directorio/$elemento"), "'>\n",
           " Operaciones",
           "</a>\n",
           "</td>\n",
           "</tr>\n";
   } 
closedir($manejador); 
echo "</table>\n";
	echo "<p class='text-center'><a href='admin.php' title='Administraci&oacute;n' class='btn btn-info'>Zona de Administrador</a></p>
	<p>&nbsp;</p>";
}
?>
     <div class="col-sm-3">
     </div>   
  </div>
</div>
<?php include('pe2.php'); ?>
</body>
</html>

