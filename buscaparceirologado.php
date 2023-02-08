<?php
	include_once("funcoesAPI.php");
	include_once("conexao.php");
	include_once("conexaoAPI.php");
	
	//$fp = fopen('data2.txt', 'w');
	try {
		
		
		$tipo = $_GET['tipo'] ?? '1';
		
		// Operação que executa uma query para select no parceiro em questão e retorna o id
		
		$receive = (object) verificaPostJson();
		//fwrite($fp, json_encode($receive, JSON_UNESCAPED_UNICODE)."\r\n");
		
		
		$resp = new stdClass();
		
		
		//$parceiro = (object) getParceiro($receive,$conn);
		$parceiro = (object) getParceiro($receive,$conn);
		
		//fwrite($fp, json_encode($usuario, JSON_UNESCAPED_UNICODE)."\r\n");
		
		if (isset($parceiro->scalar) && $parceiro->scalar==FALSE) {
			
			echo "Parceiro nao encontrado";
			return;
			
			} else {
			
			$acesso = VerificaParceiro($parceiro->id_parceiros,$conn);
			
			if($acesso == 1){
				if($parceiro != null){
					//$resp->resultadoOp = "Operação Realizada com sucesso!";
					$resp->id_parceiros = $parceiro->id_parceiros;
					echo json_encode($resp, JSON_UNESCAPED_UNICODE);
					return;
				}
				else 
				echo "Não foi possível encontrar qualquer pontuação!!";
				return;
			}
			else{
				echo "Usuário não possui permissão para esta operação!";
				return;
			}
			//fwrite($fp, "ddddd".json_encode($resp, JSON_UNESCAPED_UNICODE)."\r\n");
		}
		} catch (Exception $e) {
		
		// fwrite($fp, $e->getMessage());
		
		echo $e->getMessage();
	}
	
	//fclose($fp);
