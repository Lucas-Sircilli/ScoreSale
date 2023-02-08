<?php
	
	// Aqui Colocaremos os dados da conexão do nosso servidor
	$servidor = "localhost";
	$usuario = "root";
	$senha = "1234";
	$dbname = "projcrud";
	
	//Criar a conexao
	$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
	
	if(!$conn){
		die("Falha na conexao: " . mysqli_connect_error());
		}else{
		//echo "Conexao realizada com sucesso";
	}	
	
?>