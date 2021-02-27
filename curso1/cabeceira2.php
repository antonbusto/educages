<div class="jumbotron text-center" style="margin-bottom:0;">
    <h1><a href="1.php" title="P�gina de inicio"><?php echo $_SESSION['nome_curso']; ?></a></h1>
    <div>
      		<?php  
		//si el usuario está conectado aparecerá esta línea en la cabecera
		if($_SESSION['conectado'])
		{
			echo '<a class="btn btn-dark" href="9.php" title="Ayuda"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a>';
			//si el usuario es adiministrador tiene el nivel 2
		if ($_SESSION['nivel_usuario']==2) {
		echo ' <a class="btn btn-success" href="admin.php" title="Back-end"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></a>';
		}
	 echo ' <a class="btn btn-danger" href="desconectar.php" title="Desconectar"> <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>';
		}
		?>
     </div>
</div>
