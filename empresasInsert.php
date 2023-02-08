<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	date_default_timezone_set('america/sao_paulo');
	
	try {
		if (isset($_POST["Id"])) {
			
			$Id = mysqli_real_escape_string($conn, $_POST["Id"]);
			$RamoEmpresa = mysqli_real_escape_string($conn, $_POST["RamosEmpresa"]);
			$CNPJ = mysqli_real_escape_string($conn, $_POST["CNPJ"]);
			$Permissao = mysqli_real_escape_string($conn, $_POST["Permissao"]);
			$Nome = mysqli_real_escape_string($conn, $_POST["Nome"]);
			$NomeFantasia = mysqli_real_escape_string($conn, $_POST["NomeFantasia"]);
			$Numero = mysqli_real_escape_string($conn, $_POST["Numero"]);
			$Bairro = mysqli_real_escape_string($conn, $_POST["Bairro"]);
			$Cidade = mysqli_real_escape_string($conn, $_POST["Cidade"]);
			$Complemento = mysqli_real_escape_string($conn, $_POST["Complemento"]);
			$Telefone2 = mysqli_real_escape_string($conn, $_POST["Telefone2"]);
			$CEP = mysqli_real_escape_string($conn, $_POST["CEP"]);
			$InscricaoEstadual = mysqli_real_escape_string($conn, $_POST["InscricaoEstadual"]);
			$InscricaoMunicipal = mysqli_real_escape_string($conn, $_POST["InscricaoMunicipal"]);
			$Telefone1 = mysqli_real_escape_string($conn, $_POST["Telefone1"]);
			$Endereco = mysqli_real_escape_string($conn, $_POST["Endereco"]);
			
			//$Usuario = mysqli_real_escape_string($conn, $_POST["Usuario"]);
			$Usuario = mysqli_real_escape_string($conn, $_POST["CNPJ"]);
			
			$Whatsapp = mysqli_real_escape_string($conn, $_POST["Whatsapp"]);
			$Responsavel = mysqli_real_escape_string($conn, $_POST["Responsavel"]);
			$Email = mysqli_real_escape_string($conn, $_POST["Email"]);
			$Senha = "1234";
			$Observacao = mysqli_real_escape_string($conn, $_POST["Observacao"]);
			$dti = mysqli_real_escape_string($conn, $_POST["DataFundacao"]);
			$DataFundacao = formata_data_mysql($dti);
			$DataCadastro = mysqli_real_escape_string($conn, $_POST["DataCadastro"]);
			
			$NomeSocio1 = mysqli_real_escape_string($conn, $_POST["NomeSocio1"]);
			$PercentualSocio1 = mysqli_real_escape_string($conn, $_POST["PercentualSocio1"]);
			$Isadminsocio1 = mysqli_real_escape_string($conn, $_POST["Isadminsocio1"]);
			
			$NomeSocio2 = mysqli_real_escape_string($conn, $_POST["NomeSocio2"]);
			$PercentualSocio2 = mysqli_real_escape_string($conn, $_POST["PercentualSocio2"]);
			$Isadminsocio2 = mysqli_real_escape_string($conn, $_POST["Isadminsocio2"]);
			$NomeSocio3 = mysqli_real_escape_string($conn, $_POST["NomeSocio3"]);
			$PercentualSocio3 = mysqli_real_escape_string($conn, $_POST["PercentualSocio3"]);
			$Isadminsocio3 = mysqli_real_escape_string($conn, $_POST["Isadminsocio3"]);
			$NomeSocio4 = mysqli_real_escape_string($conn, $_POST["NomeSocio4"]);
			$PercentualSocio4 = mysqli_real_escape_string($conn, $_POST["PercentualSocio4"]);
			$Isadminsocio4 = mysqli_real_escape_string($conn, $_POST["Isadminsocio4"]);
			$NomeSocio5 = mysqli_real_escape_string($conn, $_POST["NomeSocio5"]);
			$PercentualSocio5 = mysqli_real_escape_string($conn, $_POST["PercentualSocio5"]);
			$Isadminsocio5 = mysqli_real_escape_string($conn, $_POST["Isadminsocio5"]);
			
			
			if ($Id == 0) {
				$sql  = "SELECT * FROM empresas WHERE cnpj='" . $CNPJ . "'";
				$stmt = $conn->prepare($sql); //
				$stmt->execute();
				$result = $stmt->get_result();
				if ($result->num_rows > 0) {
					echo "Já existe um empresa cadastrado com este cnpj";
					return;
				}
				
				$stmt = $conn->prepare("INSERT INTO `empresas` (razao_social,nome_fantasia,cnpj,inscricao_estadual,inscricao_municipal,cep,endereco,bairro,numero,cidade,complemento,telefone1,telefone2,whatsapp,email,obs,responsavel,data_fundacao,ramos_empresa,nome_socio1,percentual_socio1, is_admin_socio1,nome_socio2,percentual_socio2, is_admin_socio2,nome_socio3,percentual_socio3, is_admin_socio3,nome_socio4,percentual_socio4, is_admin_socio4,nome_socio5,percentual_socio5, is_admin_socio5,data_alteracao,data_cadastro)  
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,Now(),Now())");
				
			$stmt->bind_param('ssssssssssssssssssssssssssssssssss', $Nome, $NomeFantasia, $CNPJ, $InscricaoEstadual, $InscricaoMunicipal, $CEP, $Endereco, $Bairro, $Numero, $Cidade, $Complemento, $Telefone1, $Telefone2, $Whatsapp, $Email, $Observacao, $Responsavel, $DataFundacao, $RamoEmpresa, $NomeSocio1, $PercentualSocio1, $Isadminsocio1, $NomeSocio2, $PercentualSocio2, $Isadminsocio2, $NomeSocio3, $PercentualSocio3, $Isadminsocio3, $NomeSocio4, $PercentualSocio4, $Isadminsocio4, $NomeSocio5, $PercentualSocio5, $Isadminsocio5 /*    ,$DataFundacao,
			$DataAlteracao,
			
			*/ );
			
			
			
			if (!$stmt->execute()) {
			echo '[' . $stmt->errno . "] " . $stmt->error;
			} else {
			$stmt = $conn->prepare("INSERT INTO `usuarios` (nome,email,senha,situacoe_id,niveis_acesso_id,created,modified)  
			VALUES (?,?,?,1,?,Now(),Now())");
			
			$stmt->bind_param('sssi', $Nome, $CNPJ, $Senha, $Permissao);
			
			if (!$stmt->execute()) {
			echo '[' . $stmt->errno . "] " . $stmt->error;
			} else
			echo "Registro gravado com sucesso!";
			}
			
			} else {
			
			$sql = "SELECT * FROM empresas WHERE id_empresas='" . $Id . "'";
			
			$stmt = $conn->prepare($sql); //
			$stmt->execute();
			$result = $stmt->get_result();
			$row    = $result->fetch_assoc();
			
			if ($row["cnpj"] != $CNPJ) {
			echo "Não é permitido alterar o CNPJ de um usuário existente";
			return;
			}
			
			if ($Senha == "" || $Senha == null) {
			$stmt = $conn->prepare("UPDATE empresas SET nome=?,email=?,senha=senha WHERE id_empresas=?");
			$stmt->bind_param('ssi', $Nome, $Email, $Id);
			} else {
			
			$stmt = $conn->prepare("UPDATE empresas SET razao_social=?,nome_fantasia=?,cnpj=?,inscricao_estadual=?,inscricao_municipal=?,cep=?,endereco=?,bairro=?,numero=?,cidade=?,complemento=?,telefone1=?,telefone2=?,whatsapp=?,email=?,obs=?,responsavel=?,data_fundacao=?,ramos_empresa=?,nome_socio1=?,percentual_socio1=?, is_admin_socio1=?,nome_socio2=?,percentual_socio2=?, is_admin_socio2=?,nome_socio3=?,percentual_socio3=?, is_admin_socio3=?,nome_socio4=?,percentual_socio4=?, is_admin_socio4=?,nome_socio5=?,percentual_socio5=?, is_admin_socio5=?,data_alteracao=Now() WHERE id_empresas=?");
			
			$stmt->bind_param('ssssssssssssssssssssssssssssssssssi', $Nome, $NomeFantasia, $CNPJ, $InscricaoEstadual, $InscricaoMunicipal, $CEP, $Endereco, $Bairro, $Numero, $Cidade, $Complemento, $Telefone1, $Telefone2, $Whatsapp, $Email, $Observacao, $Responsavel, $DataFundacao, $RamoEmpresa, $NomeSocio1, $PercentualSocio1, $Isadminsocio1, $NomeSocio2, $PercentualSocio2, $Isadminsocio2, $NomeSocio3, $PercentualSocio3, $Isadminsocio3, $NomeSocio4, $PercentualSocio4, $Isadminsocio4, $NomeSocio5, $PercentualSocio5, $Isadminsocio5, $Id);
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