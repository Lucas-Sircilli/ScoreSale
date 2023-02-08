<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	date_default_timezone_set('america/sao_paulo');
	
	try {
		if (isset($_POST["Id"])) {
			
			$IdEmpresa = mysqli_real_escape_string($conn, $_POST["IdEmpresa"]);
			$Id = mysqli_real_escape_string($conn, $_POST["Id"]);
			$Estado = mysqli_real_escape_string($conn, $_POST["Estado"]);
			$Nome = mysqli_real_escape_string($conn, $_POST["NomeVendedor"]);
			$CPF = mysqli_real_escape_string($conn, $_POST["Cpf"]);
			$RG = mysqli_real_escape_string($conn, $_POST["Rg"]);
			$CEP = mysqli_real_escape_string($conn, $_POST["CEP"]);
			$Endereco = mysqli_real_escape_string($conn, $_POST["Endereco"]);
			$Numero = mysqli_real_escape_string($conn, $_POST["Numero"]);
			$Bairro = mysqli_real_escape_string($conn, $_POST["Bairro"]);
			$Cidade = mysqli_real_escape_string($conn, $_POST["Cidade"]);
			$Complemento = mysqli_real_escape_string($conn, $_POST["Complemento"]);
			$Senha = "1234";
			
			
			
			
			$IsvendedorAtivo = mysqli_real_escape_string($conn, $_POST["IsvendedorAtivo"]);
			
			
			
			if ($Id == 0) {
				$dti = mysqli_real_escape_string($conn, $_POST["DataAniversario"]);
				$DataAniversario = formata_data_mysql($dti);
				$dti = mysqli_real_escape_string($conn, $_POST["DataAdmissao"]);
				$DataAdmissao = formata_data_mysql($dti);
				$dti = mysqli_real_escape_string($conn, $_POST["DataDemissao"]);
			$DataDemissao = formata_data_mysql($dti);
            
            $sql = "SELECT * FROM vendedores WHERE cpf='" . $CPF . "'";
            
            $stmt = $conn->prepare($sql); //
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
			echo "Já existe um vendedor cadastrado com este CPF";
			return;
            }
            
            $stmt = $conn->prepare("INSERT INTO `vendedores` (id_empresas,nome,cpf,rg,cep,endereco,numero,bairro,cidade,estado,complemento,data_aniversario,data_admissao,data_demissao,is_vendedor_ativo)  
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            
            $stmt->bind_param('sssssssssssssss', $IdEmpresa, $Nome, $CPF, $RG, $CEP, $Endereco, $Numero, $Bairro, $Cidade, $Estado, $Complemento, $DataAniversario, $DataAdmissao, $DataDemissao, $IsvendedorAtivo);
            
            if (!$stmt->execute()) {
			echo '[' . $stmt->errno . "] " . $stmt->error;
            } else {
			echo "Registro gravado com sucesso!";
			
			
			
            }
			} else {
            $DataAniversario = mysqli_real_escape_string($conn, $_POST["DataAniversario"]);
            $DataAdmissao = mysqli_real_escape_string($conn, $_POST["DataAdmissao"]);
            $DataDemissao = mysqli_real_escape_string($conn, $_POST["DataDemissao"]);
            
            $sql = "SELECT * FROM vendedores WHERE id_vendedores='" . $Id . "'";
            
            $stmt = $conn->prepare($sql); //
            $stmt->execute();
            $result = $stmt->get_result();
            $row    = $result->fetch_assoc();
            
            
            
            if ($Senha == "" || $Senha == null) {
			$stmt = $conn->prepare("UPDATE vendedores SET nome=?, WHERE id_vendedores=?");
			$stmt->bind_param('si', $Nome, $Id);
            } else {
			
			$stmt = $conn->prepare("UPDATE vendedores SET nome=?,cpf=?,rg=?,cep=?,endereco=?,numero=?, bairro=?,complemento=?, cidade=?, estado=?, data_aniversario=?,data_admissao=?,data_demissao=?,is_vendedor_ativo=? WHERE id_vendedores=?");
			
			$stmt->bind_param('ssssssssssssssi', $Nome, $CPF, $RG, $CEP, $Endereco, $Numero, $Bairro, $Complemento, $Cidade, $Estado, $DataAniversario, $DataAdmissao, $DataDemissao, $IsvendedorAtivo, $Id);
            }
            
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