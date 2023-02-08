<?php
	$servidor_ftps = $_POST["servidor_ftps"];	echo "Servidor: ".$servidor_ftps."<br/>";
	$usuario_ftps = $_POST["usuario_ftps"];	echo "Usuário: ".$usuario_ftps."<br/>";
	$senha_ftps = $_POST["senha_ftps"];
	$pasta_ftps = $_POST["pasta_ftps"];	echo "Pasta: ".$pasta_ftps."<br/><br/>";
	$conn_id = ftp_ssl_connect($servidor_ftps) or die("Não é possivel conectar a ".$servidor_ftps);
	//$conn_id = ftp_connect($servidor_ftps) or die("Não é possivel conectar a ".$servidor_ftps);
	// login with username and password
	$login_result = ftp_login($conn_id, $usuario_ftps, $senha_ftps) or die("Usuário ou Senha Inválidos do FTPs");
	
	
	if(ftp_pwd($conn_id)!=null)
	{
		echo "Conexão executada com sucesso!<br/>";
		echo "Pastas encontradas: ".ftp_pwd($conn_id)."</br>";
		if(ftp_pwd($conn_id)!="/".$pasta_ftps)
		{
			echo "Sua pasta não foi encontrada no servidor";
		}
	}
	
	else echo "Falha na conexão!";
	
	// close the ssl connection
	ftp_close($conn_id);
?>