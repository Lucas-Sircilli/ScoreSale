<?php
	include_once("funcoesAPI.php");
	include_once("conexao.php");
	include_once("conexaoAPI.php");
	
	//$fp = fopen('data2.txt', 'w');
	try {
		
		// Busca o nome Fantasia da empresa em questão
		
		$tipo = $_GET['tipo'] ?? '1';
		
		
		$receive = (object) verificaPostJson();
		//fwrite($fp, json_encode($receive, JSON_UNESCAPED_UNICODE)."\r\n");
		
		
		$resp = new stdClass();
		
		
		//$parceiro = (object) getParceiro($receive,$conn);
		$empresa = (object) getEmpresa($receive,$conn);
		
		//fwrite($fp, json_encode($usuario, JSON_UNESCAPED_UNICODE)."\r\n");
		
		if (isset($empresa->scalar) && $empresa->scalar==FALSE) {
			
			echo "Empresa nao encontrada";
			return;
			
			} else {
			
			$acesso = VerificaEmpresa($receive->id_empresas,$conn);
			
			if($acesso == 1){
				if($empresa != null){
				//$resp->resultadoOp = "Operação Realizada com sucesso!";
				$resp->nome_fantasia = $empresa->nome_fantasia;
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
								