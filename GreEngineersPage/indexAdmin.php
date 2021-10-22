<?php
	error_reporting(0);
	session_start();
	include 'conexion.php';
	$bd = new MYSQLIFunctions();
	include 'funciones.php';
	$funciones = new funciones();

	if(!$funciones->validaSesion()){
	    ?><script type="text/javascript">
	        location.href='login';
	    </script><?php
	    exit;
	}else{
		//$inicio=$bd->select("SELECT Inicio as variable FROM `usuarios` WHERE Id=".$_SESSION['user']."")['variable'];
		//$url=$bd->select("SELECT Modulo as variable FROM `modulos` WHERE Id=".$inicio."")['variable'];
		header("Location:usuarios");
	}
?>
