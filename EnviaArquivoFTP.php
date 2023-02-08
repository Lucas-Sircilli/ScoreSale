<?php
	$file = $argv[1];
	$remote_file = $argv[2];
	$servidor_ftps = $argv[3];
	$usuario_ftps = $argv[4];
	$senha_ftps = $argv[5];
	
	$conn_id = ftp_ssl_connect($servidor_ftps) or die("Não é possivel conectar a ".$servidor_ftps);
	$login_result = ftp_login($conn_id, $usuario_ftps, $senha_ftps) or die("Usuário ou Senha Inválidos do FTPs");
	if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
		echo "sucesso";
		} else {
		echo "falhou";
	}
	
	// close the connection
	ftp_close($conn_id);
