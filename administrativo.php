<?php
	include_once("funcoes.php");
	$TituloPage = "Administrativo";
	
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta name="author" content="Lucas Pereira Lima Sircilli">
		<link rel="icon" href="./imagens/Logo-teste-Login.png">
		<title>Sessão Administrativa</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script src="js/jquery.min.js"></script>
		<link href="css/geral.css" rel="stylesheet">
		<script src="js/bootstrap.min.js"></script>
		<script src="js/carregaloader.js"></script>
	</head>
	<body>
		<?php include 'menu.php'; ?>
		
		<div class="container text-center">
			<img src="./imagens/Logo-teste-Login.png" style="height:30vh; margin-bottom:-20px; margin-top:100px;"/>
			<h3>Sistema Gestor de Configuração</h3>
		</div>
		<footer class="container-fluid text-center" style="background-color:#404041;position: fixed;bottom: 0px!important;width: 100vw;">
			<div class="row">
				<div class="col-sm-6 col-xs-6 text-left"><img src="./imagens/Logo-teste-Login.png" style="height:3vh;margin:10px"/></div>
				<!-- <div class="col-sm-6 col-xs-6 text-right"><a href=""><img src="./imagens/logo-branca.png" style="height:3vh;margin:10px"/></a></div> -->
			</div>
		</footer>
	</body>
</html>