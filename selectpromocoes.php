<?php
	include_once("funcoesAPI.php");
	include_once("conexao.php");
	include_once("conexaoAPI.php");
	
	//$fp = fopen('data2.txt', 'w');
	try {
		
		
		//$tipo = $_GET['tipo'] ?? '1';
		
		$receive = (object) verificaPostJson();
		//fwrite($fp, json_encode($receive, JSON_UNESCAPED_UNICODE)."\r\n");
		// echo json_encode($receive, JSON_UNESCAPED_UNICODE);
		
		$resp = new stdClass();
		$promocoes = (array) getPromocoes2($conn);
		if($promocoes != null){
			$resp->resultadoOp = "Operação Realizada com sucesso!";
			$resp->promocoes = $promocoes;
			echo json_encode($resp, JSON_UNESCAPED_UNICODE);
			return;
		}
		else 
		echo "Não foi possível encontrar qualquer promoção!!";
		return;
		//$usuario = (object) getUsuario($receive,$conn);
		//echo json_encode($usuario, JSON_UNESCAPED_UNICODE);
		//fwrite($fp, json_encode($usuario, JSON_UNESCAPED_UNICODE)."\r\n");
		
		/*if (isset($usuario->scalar) && $usuario->scalar==FALSE){
			
			echo "Usuario e/ou senha nao encontrados";
			return;
			
		} else {
		/*echo "ddddd"; 
		$acesso = VerificaUsuario($usuario->id,$conn);
		echo $acesso;
		/*if($acesso == true && $usuario->id == 1){
		$promocoes = (array)  getPromocoes($acesso,$conn);
		echo json_encode($promocoes, JSON_UNESCAPED_UNICODE);
		if($promocoes != null){
		$resp->resultadoOp = "Operação Realizada com sucesso!";
		$resp->promocoes = $promocoes;
		echo json_encode($resp, JSON_UNESCAPED_UNICODE);
		return;
		}
		else 
		echo "Não foi possível encontrar qualquer promoção!!";
		return;
		/*}
		else{
		echo "Usuário não possui permissão para esta operação!";
		return;
		}
		//fwrite($fp, "ddddd".json_encode($resp, JSON_UNESCAPED_UNICODE)."\r\n");
		}/**/
		} catch (Exception $e) {
		
		// fwrite($fp, $e->getMessage());
		
		echo $e->getMessage();
		}
		
		//fclose($fp);
				