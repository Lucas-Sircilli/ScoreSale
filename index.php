<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="">
		<meta name="author" content="Lucas Pereira Lima Sircilli">
		<link rel="icon" href="imagens/Logo-teste-Login.png">
		<title>Site Sample - Login</title>
		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<!-- <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">/ -->
		<!-- Custom styles for this template -->
		<link href="css/signin.css" rel="stylesheet">
		<link href="css/geral.css" rel="stylesheet">
		<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
		<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
		<!-- <script src="js/ie-emulation-modes-warning.js"></script> -->
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style>
			.text-success{
		color: white;
		}
		body{
		background-image: url("imagens/Tela-Login-LS.png") ;
		background-repeat: no-repeat;
		background-color: #cccccc;
		background-size: cover;
		background-attachment: fixed;
		
		}
		.text-danger {
		color: #e73c39;
		}
		#loading {
		margin-top:-40px !important;
		}
		
		</style>
		</head>
		<script type="text/javascript">
		function downloadPdf(){
      	$.ajax({
        url: './arquivos/privacidade.pdf',
        success: function(data) {
		var blob=new Blob([data]);
		var link=document.createElement('a');
		link.href=window.URL.createObjectURL(blob);
		link.download="politica_privacidade.pdf";
		link.click();
        }
		});
		}
		
		function CarregaLoader(){
        document.getElementById("loading").style.display = "flex";
		}
		
		</script>
		<body>
		<div id="loading" style="display:none !important">
		<img id="loading-image" src="./imagens/loader.gif" alt="Loading..." />
		</div>
		<div class="container text-center">
		<img src="./imagens/Logo-Teste-Login.png" style="height:20vh"/>
		<form class="form-signin" method="POST"  onsubmit="CarregaLoader()" action="valida.php">
		<h2 class="form-signin-heading">Login</h2>
		<label for="inputEmail" class="sr-only">Usuário</label>
		<input type="text" name="email" id="inputEmail" class="form-control" placeholder="Usuário" required autofocus>
		<label for="inputPassword" class="sr-only">Senha</label>
		<input type="password" name="senha" id="inputPassword" class="form-control" placeholder="Senha" required>
		<div class="checkbox">
		<!--É necessário colocar o link ou o arquivo em questão das politicas de privacidade no href abaixo exemplo: arquivos/privacidade.pdf -->
		<label><input type="checkbox" name="chkLGPD" id="chkLGPD" value="sim"  required>Concordo com os a <a href="" target="_blank">Política de Privacidade</a></label>
		</div>
		<button class="btn btn-lg btn-primary btn-block " type="submit">Acessar</button>
		</form>
		<p class="text-center text-danger">
		<?php if(isset($_SESSION['loginErro'])){
		echo $_SESSION['loginErro'];
		unset($_SESSION['loginErro']);
		}?>
		</p>
		<p class="text-center text-success">
		<?php 
		if(isset($_SESSION['logindeslogado'])){
		echo $_SESSION['logindeslogado'];
		unset($_SESSION['logindeslogado']);
		}
		?>
		</p>
		</div>
		<!-- /container -->
		<footer class="container-fluid text-center" style="background-color:#5a0f1e;position: fixed;bottom: 0px!important;width: 100vw;" >
		<div class="row">
		<div class="col-sm-6 col-xs-6 text-left"><img src="./imagens/Logo-Teste-Login.png" style="height:3vh;margin:10px"/></div>
		<!-- <div class="col-sm-6 col-xs-6 text-right"><a href=""><img src="./imagens/logo-branca.png" style="height:3vh;margin:10px"/></a></div> -->
		</div>
		</footer>
		</body>
		</html>						