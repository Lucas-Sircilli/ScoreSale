<?php
	session_start();
	try{
		unset(
		$_SESSION['usuarioId'],
		
		$_SESSION['usuarioNiveisAcessoId'],
		$_SESSION['usuarioEmail'],
		$_SESSION['usuarioSenha'],
		$_SESSION['usuarioNome']
		);
	}
	catch(Exception $e){}
	session_unset();
	$_SESSION['logindeslogado'] = "Deslogado com sucesso";
	//redirecionar o usuario para a página de login
	header("Location: index.php");
?>