<?php

function conectar(){
	
	$server = "localhost";
	$username = "root";
	$password = "";
	$database = "mydb";
	$conn='';
	try{	
	$conn = new PDO("mysql:host=$server;dbname=$database;",$username,$password);
		$conn->exec("set names utf8");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	}catch(PDOException $e){
		return NULL;
	}
}

?>