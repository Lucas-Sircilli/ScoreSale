<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	$servidor_ntp = $_POST["servidor_ntp"];	
	
	try {
		
		$stmt = $conn->prepare("UPDATE `configuracoes` SET `servidor_ntp`=?");			
		$stmt->bind_param(
		's',
		$servidor_ntp);
		if (!$stmt->execute()) {
			$erro = $stmt->error;
			echo $erro;
		} 
		else{
			
			//$comando = "sudo ntpdate ".$servidor_ntp;
			//$resp = shell_exec  ('echo [Time] #NTP= FallbackNTP='.$servidor_ntp.' > /etc/systemd/timesyncd.conf');
			echo "Gravado com sucesso";
		}			
		
	}
	catch (Exception $e) {
		echo 'Exceção capturada: ',  $e->getMessage(), "\n";
	}
?>