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
		
		
		$usuario = (object) getUsuario($receive,$conn);
		
		//fwrite($fp, json_encode($usuario, JSON_UNESCAPED_UNICODE)."\r\n");
		
		if (isset($usuario->scalar) && $usuario->scalar==FALSE){
			
			echo "Usuario e/ou senha nao encontrados";
			return;
			
			} else {
			
			$acesso = VerificaUsuario($usuario->id,$conn);
			
			if($acesso == 1){
				
				$resp->resultadoOp = "Login Realizada com sucesso!";
				$resp->usuario = $usuario;
				echo json_encode($resp, JSON_UNESCAPED_UNICODE);
			return;
			}
			else{
			echo "Usuário e/ou Senha inválida, por favor tente novamente!";
			return;
			}
			//fwrite($fp, "ddddd".json_encode($resp, JSON_UNESCAPED_UNICODE)."\r\n");
			}
			} catch (Exception $e) {
			
			// fwrite($fp, $e->getMessage());
			
			echo $e->getMessage();
			}
			
			//fclose($fp);
						