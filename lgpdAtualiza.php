<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	date_default_timezone_set('america/sao_paulo');
	
	try {
		
		$IpAcesso = $_SERVER['REMOTE_ADDR'];
		$sala = $_SESSION['usuarioNome'];
		
		$usuarioNiveisAcessoId=999;
		if(isset($_SESSION['usuarioNiveisAcessoId']))
		$usuarioNiveisAcessoId=$_SESSION['usuarioNiveisAcessoId'];
		
		$evento = "Administrativo";
		if(isset($_SESSION['eventoNome']))
		$evento = $_SESSION['eventoNome'];
		$idEvento = $_SESSION['usuarioId'];
		
		$sql = "SELECT IdAcessos FROM acessos WHERE IpAcesso='".$IpAcesso."' AND SalaAcesso='".$sala."' AND (EventoAcesso='".$evento."' OR EventoAcesso='Administrativo') order by DataInicio DESC limit 1 ";
		
		$stmt = $conn->prepare($sql); //
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();	
			
			$stmt = $conn->prepare("UPDATE `acessos` SET DataFim=Now() WHERE IdAcessos=?");
			$stmt->bind_param(
			'i',
			$row["IdAcessos"]	
			);				
			
			
			if (!$stmt->execute()) {
				echo '[' . $stmt->errno . "] " . $stmt->error;
				} else {
				echo "Registro gravado com sucesso!";
			}
			echo "<script>".$usuarioNiveisAcessoId."</script>";
			//if($_SESSION['usuarioNiveisAcessoId']==2){ echo "<script>alert('".$_SESSION['usuarioNiveisAcessoId']."');</script>"; return;}
			
			if($usuarioNiveisAcessoId==2){
				$sql2 = "SELECT Id  FROM eventos WHERE Id= '" . $idEvento."' and data_fim>now()  LIMIT 1";
				echo $sql2."                   ";
				$stmt2 = $conn->prepare($sql2); //
				$stmt2->execute();
				$resultado = $stmt2->get_result();
				
				/*if (!isset($resultado)) {
					//$_SESSION['loginErro'] = "Este evento já terminou!";
					header("Location: sair.php");
					}
				else{*/
				if ($resultado->num_rows > 0) {
					echo "EVENTO AINDA ATIVO 2                ";
					
					for ($i = 0; $i < $resultado->num_rows; $i++) {
						$row = $resultado->fetch_assoc();
						echo "<tr>". $row["Id"] . "   ";
					}
				}
				else{
					echo "EVENTO ACABOU FALTA FECHAR 2";
					header("Location: sair.php");
					//header("Location: sair.php");
				}
				//}
				
			}
			
			return;
		}
	
	
	} catch (Exception $e) {
	
	$erro = $e->getMessage();
	echo json_encode($erro);
	}
		