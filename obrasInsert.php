<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	date_default_timezone_set('america/sao_paulo');
	
	try {
		if (isset($_POST["Id"])) {
			
			$Id = mysqli_real_escape_string($conn, $_POST["Id"]);
			$IdEmpresa = mysqli_real_escape_string($conn, $_POST["IdEmpresa"]);
			$IdParceiro = mysqli_real_escape_string($conn, $_POST["IdParceiro"]);
			// $FaseObra = mysqli_real_escape_string($conn, $_POST["FaseObra"]);
			$Profissional = mysqli_real_escape_string($conn, $_POST["Parceiro"]);
			$TipoEndereco = mysqli_real_escape_string($conn, $_POST["TipoEndereco"]);
			$Categoria = mysqli_real_escape_string($conn, $_POST["Categoria"]);
			$Situacao = mysqli_real_escape_string($conn, $_POST["Situacao"]);
			$Estado = mysqli_real_escape_string($conn, $_POST["Estado"]);
			$Nome = mysqli_real_escape_string($conn, $_POST["Nome"]);
			$CEP = mysqli_real_escape_string($conn, $_POST["CEP"]);
			$Endereco = mysqli_real_escape_string($conn, $_POST["Endereco"]);
			$Numero = mysqli_real_escape_string($conn, $_POST["Numero"]);
			$Bairro = mysqli_real_escape_string($conn, $_POST["Bairro"]);
			$Cidade = mysqli_real_escape_string($conn, $_POST["Cidade"]);
			$Complemento = mysqli_real_escape_string($conn, $_POST["Complemento"]);
			
			if ($Id == 0) {
				$sql  = "SELECT * FROM obras WHERE id_obras='" . $Id . "'";
				$stmt = $conn->prepare($sql); //
				$stmt->execute();
				$result = $stmt->get_result();
				
				$stmt = $conn->prepare("INSERT INTO `obras` (id_parceiros,id_empresas,nome,profissional,categoria,situacao,cep,endereco,numero,complemento,bairro,cidade,estado,tipo_endereco,created,modified)  
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,Now(),Now())");
				
				$stmt->bind_param('iissssssssssss', $IdParceiro,$IdEmpresa, $Nome, $Profissional, $Categoria, $Situacao, $CEP, $Endereco, $Numero, $Complemento, $Bairro, $Cidade, $Estado, $TipoEndereco);
			
            
            
            if (!$stmt->execute()) {
			echo '[' . $stmt->errno . "] " . $stmt->error;
            } else {
			echo "Registro gravado com sucesso!";
            }
            
			} else {
            
            $sql = "SELECT * FROM obras WHERE id_obras='" . $Id . "'";
            
            $stmt = $conn->prepare($sql); //
            $stmt->execute();
            $result = $stmt->get_result();
            $row    = $result->fetch_assoc();
            
            
            $stmt = $conn->prepare("UPDATE obras SET nome=?,profissional=?,categoria=?,situacao=?,cep=?,endereco=?,numero=?,complemento=?,bairro=?,cidade=?,estado=?,tipo_endereco=?,modified=Now() WHERE id_obras=?");
            
            
            $stmt->bind_param('ssssssssssssi', $Nome, $Profissional, $Categoria, $Situacao, $CEP, $Endereco, $Numero, $Complemento, $Bairro, $Cidade, $Estado, $TipoEndereco, $Id);
            
            
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