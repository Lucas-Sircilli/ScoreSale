<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	
	date_default_timezone_set('america/sao_paulo');
	
	try {
		if (isset($_POST["Id"])) {
			
			// Queries que encontram a respectiva pontuação e faz um Select para todas as obras disponíveis para aquele parceiro e pontuação
			
			$Id = mysqli_real_escape_string($conn, $_POST["Id"]);
			$IdParceiro = mysqli_real_escape_string($conn, $_POST["IdParceiro"]);
			$IdEmpresa = mysqli_real_escape_string($conn, $_POST["IdEmpresa"]);
			if ($Id == 0) {
				//$sql  = "SELECT * FROM obras WHERE id_parceiros='" . $IdParceiro . "' and id_empresas='" . $IdEmpresa . "'";
				$sql  = "SELECT * FROM obras WHERE id_parceiros='" . $IdParceiro . "' and id_empresas='" . $IdEmpresa . "'";
				$stmt = $conn->prepare($sql); //
				$stmt->execute();
				$result = $stmt->get_result();
				if ($result->num_rows > 0) {
					
					for ($i = 0; $i < $result->num_rows; $i++) {
						$row = $result->fetch_assoc();
						
						//$arr[$i] = "<option value='".$row["id_vendedores"]."'".($rowpontuacao["id_vendedores"]==$row["id_vendedores"] ? 'selected' : '').">".$row["nome"]."</option>";
						$arr[$i] = "<div class='" . "radio" . "'><label  ><input type='" . "radio" . "' id='" . "eObras" . $i . "' name='Obra'" . "> <b>Id:</b> " . $row["id_obras"] . "&nbsp;&nbsp;<a href='javascript:CarregaLoader();EditarObra(" . $row["id_obras"] . ");'>      Editar</a>" . "<a href='javascript:Excluir(" . $row["id_obras"] . ");'style='color:red'>      Excluir</a>" . "<br><b>Nome:</b> " . $row["nome"] . "<br><b>Situação:</b> " . $row["situacao"] . "<br><b>Categoria:</b> " . $row["categoria"] . "</input></label><hr/></div>";
					}
				}
				echo json_encode($arr);
				} else {
				
				$sqlparceiro  = "SELECT * FROM pontuacoes WHERE id_pontuacoes='" . $Id . "'";
				$stmtparceiro = $conn->prepare($sqlparceiro); //
				$stmtparceiro->execute();
				$resultparceiro = $stmtparceiro->get_result();
				$rowparceiro    = $resultparceiro->fetch_assoc();
				
				
				$sql  = "SELECT * FROM obras WHERE id_parceiros='" . $IdParceiro . "'";
				$stmt = $conn->prepare($sql); //
				$stmt->execute();
				$result = $stmt->get_result();
				if ($result->num_rows > 0) {
					
					for ($i = 0; $i < $result->num_rows; $i++) {
						$row = $result->fetch_assoc();
						
						//$arr[$i] = "<option value='".$row["id_vendedores"]."'".($rowpontuacao["id_vendedores"]==$row["id_vendedores"] ? 'selected' : '').">".$row["nome"]."</option>";
						$arr[$i] = "<div class='" . "radio" . "'><label  ><input type='" . "radio" . "' id='" . "eObras" . $i . "' name='Obra'" . ($rowparceiro["id_obras"] == $row["id_obras"] ? 'checked' : '') . "><b>Id:</b> " . $row["id_obras"] . "&nbsp;&nbsp;<a href='javascript:EditarObra(" . $row["id_obras"] . ");'>      Editar</a>" . "<a href='javascript:Excluir(" . $row["id_obras"] . ");'style='color:red'>      Excluir</a>" . "<br><b>Nome:</b> " . $row["nome"] . "<br><b>Situação:</b> " . $row["situacao"] . "<br><b>Categoria:</b> " . $row["categoria"] . "</input></label><hr/></div>";
					}
				}
				echo json_encode($arr);
			}
		} else
		echo "falhou";
	}
	catch (Exception $e) {
	$erro = $e->getMessage();
	echo json_encode($erro);
	}
	
	?>						