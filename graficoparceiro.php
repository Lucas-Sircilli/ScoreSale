<?php
	include_once("funcoesAPI.php");
	include_once("conexao.php");
	include_once("conexaoAPI.php");
	
	//$fp = fopen('data2.txt', 'w');
	try {
		
		$tipo = $_GET['tipo'] ?? '1';
		
		$receive = (object) verificaPostJson();
		//fwrite($fp, json_encode($receive, JSON_UNESCAPED_UNICODE)."\r\n");
		
		$resp = new stdClass();
		
		
		
		//$usuario = (object) getUsuario($receive,$conn);
		
		//fwrite($fp, json_encode($usuario, JSON_UNESCAPED_UNICODE)."\r\n");
		
		//$acesso = VerificaUsuario($usuario->id,$conn);
		
		$grafico = (array)  getGraficoParceiro($receive,$conn);
		if($grafico != null){
			$resp->resultadoOp = "Operação Realizada com sucesso!";
			$resp->grafico = $grafico;
			echo json_encode($resp, JSON_UNESCAPED_UNICODE);
			return;
		}
		else 
		echo "Não foi possível encontrar qualquer pontuação!!";
		return;
		
		//fwrite($fp, "ddddd".json_encode($resp, JSON_UNESCAPED_UNICODE)."\r\n");
	
	} catch (Exception $e) {
	
	// fwrite($fp, $e->getMessage());
	
	echo $e->getMessage();
	}
	
	//fclose($fp);
		