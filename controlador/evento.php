<?php
require 'Tipousuariocontroller.php';
require 'Usuariocontroller.php';
$usuario = new usuarioController();
$tipo_usuario = new Tipousuariocontroller(true);

$dato=$_POST['evento'];

switch($dato){
		
	case 'eliminarUsuario':
		$tipo_usuario->ConexionDB();	
		$tipo_usuario->eliminarUsuario($_POST['user']);
		break;
}


?>