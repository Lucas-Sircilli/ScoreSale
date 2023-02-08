<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	date_default_timezone_set('america/sao_paulo');
	
	try {
		if (isset($_POST["Id"])) {
			
			//Variáveis da Imagem
			$Foto = mysqli_real_escape_string($conn, $_POST["Foto"]);
			$Meta = mysqli_real_escape_string($conn, $_POST["Meta"]);
			$Id = mysqli_real_escape_string($conn, $_POST["Id"]);
			$IdLoja = mysqli_real_escape_string($conn, $_POST["IdLoja"]);
			$Titulo = mysqli_real_escape_string($conn, $_POST["Titulo"]);
			$Descricao = mysqli_real_escape_string($conn, $_POST["Descricao"]);
			$dti = mysqli_real_escape_string($conn, $_POST["DataCadastro"]);
			$dti1 = mysqli_real_escape_string($conn, $_POST["DataValidade"]);
			
			//$Foto = mysqli_real_escape_string($conn, $_POST["Foto"]);
			$Loja = mysqli_real_escape_string($conn, $_POST["Loja"]);
			
			$DataCadastro = formata_data_mysql($dti);
			$DataValidade = formata_data_mysql($dti1);
			
			if ($Id == 0) {
				$sql  = "SELECT * FROM promocoes WHERE titulo='" . $Titulo . "'";
				$stmt = $conn->prepare($sql); //
				$stmt->execute();
				$result = $stmt->get_result();
				if ($result->num_rows > 0) {
					echo "Já existe uma promoção cadastrado com este título";
					return;
				}
				/*$sqlfoto  = "SELECT * FROM promocoes WHERE foto='" . $Foto . "'";
					$stmtfoto = $conn->prepare($sqlfoto); //
				$stmtfoto->execute();
				$resultfoto = $stmtfoto->get_result();
				elseif ($result->num_rows > 0) {
                echo "Já existe uma promoção cadastrado com este título";
                return;
				}*/
				
				$stmt = $conn->prepare("INSERT INTO `promocoes` (id_loja,titulo,descricao,loja,meta,data_cadastro,data_validade,foto)  
				VALUES (?,?,?,?,?,?,?,?)");
				
				$stmt->bind_param('isssssss', $IdLoja, $Titulo, $Descricao, $Loja,$Meta, $DataCadastro, $DataValidade,$Foto);
				
				if (!$stmt->execute()) {
                echo '[' . $stmt->errno . "] " . $stmt->error;
				} else {
                echo "Registro gravado com sucesso!";
				
				}
				
				} else {
				
				$sql = "SELECT * FROM promocoes WHERE id_promocoes='" . $Id . "'";
				
				$stmt = $conn->prepare($sql); //
				$stmt->execute();
				$result = $stmt->get_result();
				$row    = $result->fetch_assoc();
				
				if($row["id_promocoes"] == $Id) {
				$stmt = $conn->prepare("UPDATE promocoes SET id_loja=?,titulo=?,descricao=?,loja=?,meta=?,data_cadastro=?,data_validade=?,foto=? WHERE id_promocoes=?");
				$stmt->bind_param('isssssssi', $IdLoja, $Titulo, $Descricao,$Loja,$Meta, $DataCadastro,$DataValidade,$Foto, $Id);
				}
				/* if ($row["cnpj"] != $CNPJ) {
                echo "Não é permitido alterar o CNPJ de um usuário existente";
                return;
				}
				
				if ($Senha == "" || $Senha == null) {
                $stmt = $conn->prepare("UPDATE empresas SET nome=?,email=?,senha=senha WHERE id_empresas=?");
                $stmt->bind_param('ssi', $Nome, $Email, $Id);
				} else {
                
                $stmt = $conn->prepare("UPDATE promocoes SET id_loja=?,titulo=?,descricao=?,loja=?,data_cadastro=?,data_validade=?, WHERE id_empresas=?");
                
                $stmt->bind_param('ssssssi', $IdLoja, $Titulo, $Descricao,$Loja, $DataCadastro,$DataValidade, $Id);
				}*/
				
				if (!$stmt->execute()) {
                echo '[' . $stmt->errno . "] " . $stmt->error;
				} else {
                echo "Registro gravado com sucesso!";
                
                
				}
				}
				}
				}
				catch (Exception $e) {
				$erro = $e->getMessage();
				echo json_encode($erro);
				}				