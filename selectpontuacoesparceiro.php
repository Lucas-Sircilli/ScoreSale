<?php
	include_once("funcoesAPI.php");
	include_once("conexao.php");
	include_once("conexaoAPI.php");
	
	//$fp = fopen('data2.txt', 'w');
	try {
		
		
		$tipo = $_GET['tipo'] ?? '1';
		
		$receive = (object) verificaPostJson();
		$resp = new stdClass();
		
		$pontuacoes = (array)  getPontuacoesparceiro($receive,$conn);
		if($pontuacoes != null)
		{
			$resp->resultadoOp = "Operação Realizada com sucesso!";
			$resp->pontuacoes = $pontuacoes;
			echo json_encode($resp, JSON_UNESCAPED_UNICODE);
			return;
		}
		else 
		echo "Não foi possível encontrar qualquer pontuação!!";
		return;
		/*
			$usuario = (object) getUsuario($receive,$conn);
			
			//fwrite($fp, json_encode($usuario, JSON_UNESCAPED_UNICODE)."\r\n");
			
			if (isset($usuario->scalar) && $usuario->scalar==FALSE) {
			
			echo "Usuario e/ou senha nao encontrados";
			return;
			
		} else {
		
		$acesso = VerificaUsuario($usuario->id,$conn);
		
		if($acesso == 1 && $usuario->id == 1){
		$pontuacoes = (array)  getPontuacoesparceiro($receive,$conn);
		if($pontuacoes != null){
		$resp->resultadoOp = "Operação Realizada com sucesso!";
		$resp->pontuacoes = $pontuacoes;
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
		}*/
		} catch (Exception $e) {
		
		// fwrite($fp, $e->getMessage());
		
		echo $e->getMessage();
		}
		
		//fclose($fp);
				