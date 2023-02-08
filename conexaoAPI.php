<?php
	
	include_once("conexao.php");
	
	
	function getUsuario(Object $rec, mysqli $conn) {
		$sql = "SELECT * FROM usuarios WHERE email='".$rec->usuarioEmail."' AND senha='".$rec->senha."'";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$usuario = $result->fetch_assoc();
		return $usuario;
	}
	
	function getParceiro(Object $rec, mysqli $conn) {
		// Query que busca o parceiro pelo seu documento
		$sql = "SELECT id_parceiros FROM parceiros WHERE cnpj='". $rec->documento . "' OR cpf='". $rec->documento . "'";
		
		//SELECT id_parceiros FROM parceiros WHERE cnpj="'+parametros!.usuario!.usuarioEmail.toString()+ '" OR cpf="'+ parametros!.usuario!.usuarioEmail.toString() + '"';
		//$sql = "SELECT * FROM pontuacoes WHERE id_parceiros='".$rec->id."'";
		
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$parceiro = $result->fetch_assoc();
		return $parceiro;
	}
	function getEmpresa(Object $rec, mysqli $conn) {
		// Query que busca a empresa pelo seu id
		$sql = "SELECT nome_fantasia FROM empresas WHERE id_empresas='". $rec->id_empresas . "'";
		
		//SELECT id_parceiros FROM parceiros WHERE cnpj="'+parametros!.usuario!.usuarioEmail.toString()+ '" OR cpf="'+ parametros!.usuario!.usuarioEmail.toString() + '"';
		//$sql = "SELECT * FROM pontuacoes WHERE id_parceiros='".$rec->id."'";
		
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$parceiro = $result->fetch_assoc();
		return $parceiro;
	}
	
	function VerificaUsuario($idUsuario, mysqli $conn) {
		
		
		$sql = "SELECT * FROM usuarios WHERE id='".$idUsuario."'";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$promocao = $result->fetch_assoc();
		
		if($promocao["id"] != null){				
			return true;
		}
		return false;
	}
	
	function VerificaParceiro($idparceiro, mysqli $conn) {
		
		
		$sql = "SELECT * FROM usuarios WHERE id='".$idparceiro."'";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$parceiro = $result->fetch_assoc();
		
		if($parceiro["id"] != null){				
			return true;
		}
		return false;
	}
	
	function VerificaEmpresa($idempresa, mysqli $conn) {
		
		
		$sql = "SELECT * FROM usuarios WHERE id='".$idempresa."'";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$parceiro = $result->fetch_assoc();
		
		if($parceiro["id"] != null){				
			return true;
		}
		return false;
	}
	
	
	function getPromocoes($user, mysqli $conn) {		
		if($user == true){
			//$query = "SELECT * FROM promocoes WHERE id'" . $idUsuario . "'" ;
			$sql = "SELECT * FROM promocoes";
		    $stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->get_result();
			$promocoes = $result->fetch_all(MYSQLI_ASSOC);
			//$promocoes = $query->fetchAll();
			
			return $promocoes;
		}
		else
		return;		
	}
	
	function getPromocoes2(mysqli $conn) {		
		
		//$query = "SELECT * FROM promocoes WHERE id'" . $idUsuario . "'" ;
		$sql = "SELECT * FROM promocoes";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$promocoes = $result->fetch_all(MYSQLI_ASSOC);
		//$promocoes = $query->fetchAll();
		
		return $promocoes;
		
	}		
	
	function getPontuacoesparceiro($user, mysqli $conn) {
		
		if($user == true){
			//$query = "SELECT * FROM promocoes WHERE id'" . $idUsuario . "'" ;
			$sql = "SELECT emp.nome_fantasia 'nome_fantasia', DATE_FORMAT(pt.created,'%d/%m/%Y') created, CAST(pt.pontuacoes AS SIGNED) as pontuacoes FROM pontuacoes pt
			left join empresas emp on pt.id_empresas=emp.id_empresas
			where pt.id_parceiros='" . $user->id . "'";
			//$sql = "SELECT * FROM pontuacoes WHERE id_parceiros='" . $user->id . "'" ;
		    $stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->get_result();
			$pontuacoes = $result->fetch_all(MYSQLI_ASSOC);
			//$promocoes = $query->fetchAll();
			
			return $pontuacoes;
		}
		else
		return;
	}
	
	function somaPontuacoes($dados, mysqli $conn){
		//SELECT SUM(pontuacoes),id_parceiros FROM pontuacoes WHERE created LIKE '%2022-12%' GROUP BY id_parceiros ORDER BY 1 DESC limit 1
		
		
		$sql = "SELECT CAST(SUM(COALESCE(pontuacoes, 0)) AS UNSIGNED) pontuacoes FROM pontuacoes WHERE id_parceiros='".$dados->id_parceiros."'";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$pontuacao = $result->fetch_all(MYSQLI_ASSOC);
		return $pontuacao;
	}
	
	function getGraficomaisPontuado($dados, mysqli $conn){
		//SELECT SUM(pontuacoes),id_parceiros FROM pontuacoes WHERE created LIKE '%2022-12%' GROUP BY id_parceiros ORDER BY 1 DESC limit 1
		$sql = "SELECT CAST(SUM(COALESCE(pontuacoes, 0)) AS UNSIGNED) pontuacoes,id_parceiros FROM pontuacoes WHERE created LIKE '%" . $dados->data . "%' GROUP BY id_parceiros ORDER BY 1 DESC limit 1";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$dadosgrafico = $result->fetch_all(MYSQLI_ASSOC);
		return $dadosgrafico;
	}
	
	function getGraficoParceiro($dados, mysqli $conn){
		//SELECT SUM(pontuacoes),id_parceiros FROM pontuacoes WHERE id_parceiros=17 AND created LIKE '%2022-11%';
		$sql = "SELECT CAST(SUM(COALESCE(pontuacoes, 0)) AS UNSIGNED) pontuacoes,id_parceiros FROM pontuacoes WHERE id_parceiros='" . $dados->id_parceiros . "' AND created LIKE '%" . $dados->data . "%'";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$dadosgrafico = $result->fetch_all(MYSQLI_ASSOC);
		return $dadosgrafico;
	}
	
	function getPontuacoes($user, mysqli $conn) {
		
		if($user == true){
			//$query = "SELECT * FROM promocoes WHERE id'" . $idUsuario . "'" ;
			$sql = "SELECT * FROM pontuacoes";
		    $stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->get_result();
			$pontuacoes = $result->fetch_all(MYSQLI_ASSOC);
			//$promocoes = $query->fetchAll();
			
			return $pontuacoes;
		}
		else
		return;
		
		
	}	