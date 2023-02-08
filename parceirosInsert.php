<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	date_default_timezone_set('america/sao_paulo');
	
	try {
		
		if (isset($_POST["Id"])) {
			
			$Id = mysqli_real_escape_string($conn, $_POST["Id"]);
			$RG = mysqli_real_escape_string($conn, $_POST["RG"]);
			$CPF = mysqli_real_escape_string($conn, $_POST["CPF"]);
			
			$Nome = mysqli_real_escape_string($conn, $_POST["Nome"]);
			
			$Telefone = mysqli_real_escape_string($conn, $_POST["Telefone"]);
			$Email = mysqli_real_escape_string($conn, $_POST["Email"]);
			$TipoPessoa = mysqli_real_escape_string($conn, $_POST["TipoPessoa"]);
			$TipoProfissao = mysqli_real_escape_string($conn, $_POST["TipoProfissao"]);
			$CNPJ = mysqli_real_escape_string($conn, $_POST["CNPJ"]);
			$Permissao = mysqli_real_escape_string($conn, $_POST["Permissao"]);
			$RazaoSocial = mysqli_real_escape_string($conn, $_POST["RazaoSocial"]);
			$CEP = mysqli_real_escape_string($conn, $_POST["CEP"]);
			$Endereco = mysqli_real_escape_string($conn, $_POST["Endereco"]);
			$Numero = mysqli_real_escape_string($conn, $_POST["Numero"]);
			$Bairro = mysqli_real_escape_string($conn, $_POST["Bairro"]);
			$Cidade = mysqli_real_escape_string($conn, $_POST["Cidade"]);
			$UF = mysqli_real_escape_string($conn, $_POST["UF"]);
			$Complemento = mysqli_real_escape_string($conn, $_POST["Complemento"]);
			$CEPEmpresa = mysqli_real_escape_string($conn, $_POST["CEPEmpresa"]);
			$EnderecoEmpresa = mysqli_real_escape_string($conn, $_POST["EnderecoEmpresa"]);
			$NumeroEmpresa = mysqli_real_escape_string($conn, $_POST["NumeroEmpresa"]);
			$BairroEmpresa = mysqli_real_escape_string($conn, $_POST["BairroEmpresa"]);
			$CidadeEmpresa = mysqli_real_escape_string($conn, $_POST["CidadeEmpresa"]);
			$UfEmpresa = mysqli_real_escape_string($conn, $_POST["UfEmpresa"]);
		$ComplementoEmpresa = mysqli_real_escape_string($conn, $_POST["ComplementoEmpresa"]);
        $InscricaoMunicipal = mysqli_real_escape_string($conn, $_POST["InscricaoMunicipal"]);
        
        $Senha = "1234";
        $dti = mysqli_real_escape_string($conn, $_POST["DataFundacao"]);
        $DataFundacao = formata_data_mysql($dti);
        $dti = mysqli_real_escape_string($conn, $_POST["DataAniversario"]);
        $DataAniversario = formata_data_mysql($dti);
        
		/*echo $DataAniversario." | ";
		echo $TipoPessoa." | ";
		echo $Permissao." |** ";*/
		
        $NomeSocio1 = mysqli_real_escape_string($conn, $_POST["NomeSocio1"]);
        $CpfSocio1 = mysqli_real_escape_string($conn, $_POST["CpfSocio1"]);
        $RgSocio1 = mysqli_real_escape_string($conn, $_POST["RgSocio1"]);
        $EmailSocio1 = mysqli_real_escape_string($conn, $_POST["EmailSocio1"]);
        $DataNascimentoSocio1 = mysqli_real_escape_string($conn, $_POST["DataNascimentoSocio1"]);
        $TelefoneSocio1 = mysqli_real_escape_string($conn, $_POST["TelefoneSocio1"]);
        $PercentualSocio1 = mysqli_real_escape_string($conn, $_POST["PercentualSocio1"]);
        $Isadminsocio1 = mysqli_real_escape_string($conn, $_POST["Isadminsocio1"]);
        
        $NomeSocio2 = mysqli_real_escape_string($conn, $_POST["NomeSocio2"]);
		$CpfSocio2 = mysqli_real_escape_string($conn, $_POST["CpfSocio2"]);
        $RgSocio2 = mysqli_real_escape_string($conn, $_POST["RgSocio2"]);
        $EmailSocio2 = mysqli_real_escape_string($conn, $_POST["EmailSocio2"]);
        $DataNascimentoSocio2 = mysqli_real_escape_string($conn, $_POST["DataNascimentoSocio2"]);
        $TelefoneSocio2 = mysqli_real_escape_string($conn, $_POST["TelefoneSocio2"]);
        $PercentualSocio2 = mysqli_real_escape_string($conn, $_POST["PercentualSocio2"]);
        $Isadminsocio2 = mysqli_real_escape_string($conn, $_POST["Isadminsocio2"]);
		
        $NomeSocio3 = mysqli_real_escape_string($conn, $_POST["NomeSocio3"]);
		$CpfSocio3 = mysqli_real_escape_string($conn, $_POST["CpfSocio3"]);
        $RgSocio3 = mysqli_real_escape_string($conn, $_POST["RgSocio3"]);
        $EmailSocio3 = mysqli_real_escape_string($conn, $_POST["EmailSocio3"]);
        $DataNascimentoSocio3 = mysqli_real_escape_string($conn, $_POST["DataNascimentoSocio3"]);
        $TelefoneSocio3 = mysqli_real_escape_string($conn, $_POST["TelefoneSocio3"]);
        $PercentualSocio3 = mysqli_real_escape_string($conn, $_POST["PercentualSocio3"]);
        $Isadminsocio3 = mysqli_real_escape_string($conn, $_POST["Isadminsocio3"]);
		
        $NomeSocio4 = mysqli_real_escape_string($conn, $_POST["NomeSocio4"]);
		$CpfSocio4 = mysqli_real_escape_string($conn, $_POST["CpfSocio4"]);
        $RgSocio4 = mysqli_real_escape_string($conn, $_POST["RgSocio4"]);
        $EmailSocio4 = mysqli_real_escape_string($conn, $_POST["EmailSocio4"]);
        $DataNascimentoSocio4 = mysqli_real_escape_string($conn, $_POST["DataNascimentoSocio4"]);
        $TelefoneSocio4 = mysqli_real_escape_string($conn, $_POST["TelefoneSocio4"]);
        $PercentualSocio4 = mysqli_real_escape_string($conn, $_POST["PercentualSocio4"]);
        $Isadminsocio4 = mysqli_real_escape_string($conn, $_POST["Isadminsocio4"]);
		
        $NomeSocio5 = mysqli_real_escape_string($conn, $_POST["NomeSocio5"]);
		$CpfSocio5 = mysqli_real_escape_string($conn, $_POST["CpfSocio5"]);
        $RgSocio5 = mysqli_real_escape_string($conn, $_POST["RgSocio5"]);
        $EmailSocio5 = mysqli_real_escape_string($conn, $_POST["EmailSocio5"]);
        $DataNascimentoSocio5 = mysqli_real_escape_string($conn, $_POST["DataNascimentoSocio5"]);
        $TelefoneSocio5 = mysqli_real_escape_string($conn, $_POST["TelefoneSocio5"]);
        $PercentualSocio5 = mysqli_real_escape_string($conn, $_POST["PercentualSocio5"]);
        $Isadminsocio5 = mysqli_real_escape_string($conn, $_POST["Isadminsocio5"]);
		
        $CAU = mysqli_real_escape_string($conn, $_POST["CAU"]);
        
		
        if ($Id == 0) {
		$sql  = "SELECT * FROM parceiros WHERE cpf='" . $CPF . "'";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($result->num_rows > 0) {
		echo "Já existe um parceiro cadastrado com este CPF";
		return;
		}
		
		$stmt = $conn->prepare("INSERT INTO `parceiros` (
		nome, telefone, email, cpf, rg, cep, endereco, numero, bairro, complemento
		, cidade, uf, data_aniversario, id_tipo_parceiro, id_tipo_pessoa, razao_social, cnpj, cep_empresa, endereco_empresa, numero_empresa
		, bairro_empresa, complemento_empresa, cidade_empresa, uf_empresa, inscricao_municipal, data_fundacao, nome_socio1, cpf_socio1, rg_socio1, email_socio1, data_aniversario_socio1, telefone_socio1, percentual_socio1, is_admin_socio1, nome_socio2
		, cpf_socio2, rg_socio2, email_socio2, data_aniversario_socio2, telefone_socio2, percentual_socio2, is_admin_socio2, nome_socio3, cpf_socio3, rg_socio3, email_socio3, data_aniversario_socio3, telefone_socio3, percentual_socio3, is_admin_socio3
		, nome_socio4, cpf_socio4, rg_socio4, email_socio4, data_aniversario_socio4, telefone_socio4, percentual_socio4, is_admin_socio4, nome_socio5, cpf_socio5, rg_socio5, email_socio5, data_aniversario_socio5, telefone_socio5, percentual_socio5
		, is_admin_socio5, cau
		,data_alteracao,data_cadastro)  
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,Now(),Now())");
		$stmt->bind_param('sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss'
		, $Nome, $Telefone, $Email, $CPF, $RG, $CEP, $Endereco, $Numero, $Bairro, $Complemento
		, $Cidade, $UF, $DataAniversario, $TipoProfissao, $TipoPessoa, $RazaoSocial, $CNPJ, $CEPEmpresa, $EnderecoEmpresa, $NumeroEmpresa
		, $BairroEmpresa, $ComplementoEmpresa, $CidadeEmpresa, $UfEmpresa, $InscricaoMunicipal, $DataFundacao, $NomeSocio1, $CpfSocio1, $RgSocio1, $EmailSocio1, $DataNascimentoSocio1, $TelefoneSocio1, $PercentualSocio1, $Isadminsocio1, $NomeSocio2
		, $CpfSocio2, $RgSocio2, $EmailSocio2, $DataNascimentoSocio2, $TelefoneSocio2, $PercentualSocio2, $Isadminsocio2, $NomeSocio3, $CpfSocio3, $RgSocio3, $EmailSocio3, $DataNascimentoSocio3, $TelefoneSocio3, $PercentualSocio3, $Isadminsocio3, $NomeSocio4
		, $CpfSocio4, $RgSocio4, $EmailSocio4, $DataNascimentoSocio4, $TelefoneSocio4, $PercentualSocio4, $Isadminsocio4, $NomeSocio5, $CpfSocio5, $RgSocio5, $EmailSocio5, $DataNascimentoSocio5, $TelefoneSocio5, $PercentualSocio5
		, $Isadminsocio5, $CAU);
		
		if (!$stmt->execute()) {
		echo '** [' . $stmt->errno . "] " . $stmt->error;
		} else {
		
		if ($CNPJ != "" || $CNPJ != null) {
		
		$stmt = $conn->prepare("INSERT INTO `usuarios` (nome,email,senha,situacoe_id,niveis_acesso_id,created,modified)  
		VALUES (?,?,?,1,?,Now(),Now())");
		
		
		$stmt->bind_param('sssi', $Nome, $CNPJ, $Senha, $Permissao);
		
		} else {
		
		$stmt = $conn->prepare("INSERT INTO `usuarios` (nome,email,senha,situacoe_id,niveis_acesso_id,created,modified)  
		VALUES (?,?,?,1,?,Now(),Now())");
		
		$stmt->bind_param('sssi', $Nome, $CPF, $Senha, $Permissao);
		}
		
		if (!$stmt->execute()) {
		echo '[' . $stmt->errno . "] " . $stmt->error;
		} else
		echo "Registro gravado com sucesso!";
		}
		
        } else {
		
		$sql = "SELECT * FROM parceiros WHERE id_parceiros='" . $Id . "'";
		
		$stmt = $conn->prepare($sql); //
		$stmt->execute();
		$result = $stmt->get_result();
		$row    = $result->fetch_assoc();
		
		if ($row["cpf"] != $CPF) {
		echo "Não é permitido alterar o CPF de um usuário existente";
		return;
		}
		
		if ($Senha == "" || $Senha == null) {
		$stmt = $conn->prepare("UPDATE parceiros SET nome=?,telefone=?,email=?,senha=senha WHERE id_parceiros=?");
		$stmt->bind_param('sssi', $Nome, $Telefone, $Email, $Id);
		} else {
		
		$stmt = $conn->prepare("UPDATE parceiros SET 
		nome=?,telefone=?,email=?,cpf=?,rg=?,cep=?,endereco=?,numero=?,bairro=?,complemento=?,
		cidade=?,uf=?,data_aniversario=?,id_tipo_parceiro=?,id_tipo_pessoa=?,razao_social=?,cnpj=?,cep_empresa=?,endereco_empresa=?,numero_empresa=?,
		bairro_empresa=?,complemento_empresa=?,cidade_empresa=?,uf_empresa=?,inscricao_municipal=?,data_fundacao=?,nome_socio1=?,cpf_socio1=?,rg_socio1=?,email_socio1=?,
		data_aniversario_socio1=?,telefone_socio1=?,percentual_socio1=?,is_admin_socio1=?,nome_socio2=?,cpf_socio2=?,rg_socio2=?,email_socio2=?,data_aniversario_socio2=?,telefone_socio1=?,
		percentual_socio2=?,is_admin_socio2=?,nome_socio3=?,cpf_socio3=?,rg_socio3=?,email_socio3=?,data_aniversario_socio3=?,telefone_socio3=?,percentual_socio3=?,is_admin_socio3=?,
		nome_socio4=?,cpf_socio4=?,rg_socio4=?,email_socio4=?,data_aniversario_socio4=?,telefone_socio4=?,percentual_socio4=?,is_admin_socio4=?,nome_socio5=?,cpf_socio5=?,
		rg_socio5=?,email_socio5=?,data_aniversario_socio5=?,telefone_socio5=?,percentual_socio5=?,is_admin_socio5=?,cau=?,data_alteracao=Now() WHERE id_parceiros=?");                
		
		$stmt->bind_param('sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssi', 
		$Nome, $Telefone, $Email, $CPF, $RG, $CEP, $Endereco, $Numero, $Bairro, $Complemento, 
		$Cidade, $UF, $DataAniversario, $TipoProfissao, $TipoPessoa, $RazaoSocial, $CNPJ, $CEPEmpresa, $EnderecoEmpresa, $NumeroEmpresa, 
		$BairroEmpresa, $ComplementoEmpresa, $CidadeEmpresa, $UfEmpresa, $InscricaoMunicipal, $DataFundacao, $NomeSocio1, $CpfSocio1, $RgSocio1, $EmailSocio1, 
		$DataNascimentoSocio1, $TelefoneSocio1, $PercentualSocio1, $Isadminsocio1, $NomeSocio2, $CpfSocio2, $RgSocio2, $EmailSocio2, $DataNascimentoSocio2, $TelefoneSocio2, 
		$PercentualSocio2, $Isadminsocio2, $NomeSocio3, $CpfSocio3, $RgSocio3, $EmailSocio3, $DataNascimentoSocio3, $TelefoneSocio3, $PercentualSocio3, $Isadminsocio3, 
		$NomeSocio4, $CpfSocio4, $RgSocio4, $EmailSocio4, $DataNascimentoSocio4, $TelefoneSocio4, $PercentualSocio4, $Isadminsocio4, $NomeSocio5, $CpfSocio5, 
		$RgSocio5, $EmailSocio5, $DataNascimentoSocio5, $TelefoneSocio5, $PercentualSocio5, $Isadminsocio5, $CAU, $Id);
		}
		
		if (!$stmt->execute()) {
		echo '[' . $stmt->errno . "] " . $stmt->error;
		} else {
		if ($CNPJ != "" || $CNPJ != null) {
		$stmt = $conn->prepare("UPDATE usuarios SET nome=?,modified=Now() WHERE email=?");
		
		$stmt->bind_param('ss', $Nome, $CNPJ);
		} else {
		$stmt = $conn->prepare("UPDATE usuarios SET nome=?,modified=Now() WHERE email=?");
		
		$stmt->bind_param('ss', $Nome, $CPF);
		
		}
		if (!$stmt->execute()) {
		echo '[' . $stmt->errno . "] " . $stmt->error;
		} else
		echo "Registro gravado com sucesso!";
		}
        }/**/
		}
		}
		catch (Exception $e) {
		echo 'Exceção capturada: ',  $e->getMessage(), "\n";
		echo "ddd";//$e->getMessage();
		// echo json_encode($erro);
		}		