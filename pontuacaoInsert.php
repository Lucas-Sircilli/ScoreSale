<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	date_default_timezone_set('america/sao_paulo');
	
	try {
		if (isset($_POST["Id"])) {
			
			$Id = mysqli_real_escape_string($conn, $_POST["Id"]);
			$Promocao = mysqli_real_escape_string($conn, $_POST["Promocao"]);
			$Nome = mysqli_real_escape_string($conn, $_POST["NomeParceiro"]);
			$Parceiro = mysqli_real_escape_string($conn, $_POST["Parceiro"]);
			$Empresa = mysqli_real_escape_string($conn, $_POST["Empresa"]);
			$Vendedor = mysqli_real_escape_string($conn, $_POST["Vendedor"]);
			$Obra = mysqli_real_escape_string($conn, $_POST["Obra"]);
			$Valor = mysqli_real_escape_string($conn, $_POST["Valor"]);
			$Fase = mysqli_real_escape_string($conn, $_POST["Fase"]);
			$Polo = mysqli_real_escape_string($conn, $_POST["Polo"]);
			
			$dti = mysqli_real_escape_string($conn, $_POST["DataCadastro"]);
			$DataCriacao = formata_data_mysql($dti);
			
			
			
			if ($Id == 0) {
				
				$stmt = $conn->prepare("INSERT INTO `pontuacoes` (id_parceiros,id_empresas,id_vendedores,id_obras,id_promocoes,nome,valorcompra, fase_obra,pontuacoes,created,modified)  
				VALUES (?,?,?,?,?,?,?,?,?,Now(),Now())");
				
				$stmt->bind_param('iiiiissss', $Parceiro, $Empresa, $Vendedor, $Obra, $Promocao, $Nome, $Valor,$Fase, $Polo);
				
				
				
				if (!$stmt->execute()) {
					echo '[' . $stmt->errno . "] " . $stmt->error;
				} else
                echo "Registro gravado com sucesso!";
				
				
				} else {
				
				$sql = "SELECT * FROM pontuacoes WHERE id_pontuacoes='" . $Id . "'";
				
				$stmt = $conn->prepare($sql); //
				$stmt->execute();
				$result = $stmt->get_result();
				$row    = $result->fetch_assoc();
				
				$stmt = $conn->prepare("UPDATE pontuacoes SET id_parceiros=?,id_empresas=?,id_vendedores=?,id_obras=?,id_promocoes=?,nome=?,fase_obra=?,valorcompra=?,pontuacoes=?,modified=Now(), created=? WHERE id_pontuacoes=?");
				
				$stmt->bind_param('iiiiisssssi', $Parceiro, $Empresa, $Vendedor, $Obra, $Promocao, $Nome, $Fase, $Valor, $Polo, $DataCriacao, $Id);
				
				
				if (!$stmt->execute()) {
                echo '[' . $stmt->errno . "] " . $stmt->error;
				} else
                echo "Registro gravado com sucesso!";
				
				
				
				
				}
				}
				}
				catch (Exception $e) {
				$erro = $e->getMessage();
				echo json_encode($erro);
				}				