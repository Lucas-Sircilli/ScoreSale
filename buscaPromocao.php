<?php
	
	include_once("funcoes.php");
	include_once("conexao.php");
	
	date_default_timezone_set('america/sao_paulo');
	
	try {
		if (isset($_POST["Id"])) {
			
			$IdPontuacao = mysqli_real_escape_string($conn, $_POST["Id"]);
			$IdPromocao = mysqli_real_escape_string($conn, $_POST["IdPromocoes"]);
			$IdEmpresa = mysqli_real_escape_string($conn, $_POST["IdEmpresa"]);
			
			//$sqlpromocao = "SELECT * FROM promocoes WHERE id_loja='" . $IdEmpresa . "'";
			$sqlpromocao = "SELECT * FROM promocoes";
			$stmtpromocao = $conn->prepare($sqlpromocao); //
			$stmtpromocao->execute();
			$resultpromocao = $stmtpromocao->get_result();
			
			
			$sql = "SELECT * FROM pontuacoes WHERE id_pontuacoes='" . $IdPontuacao . "'";
			$stmt = $conn->prepare($sql); //
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			
			if ($resultpromocao->num_rows > 0) {
				for ($i = 0; $i < $resultpromocao->num_rows; $i++) {
					$rowpromocao = $resultpromocao->fetch_assoc();   
					
					$arr[$i] = "<option value='" . $rowpromocao["id_promocoes"] . "'" . ($row["id_promocoes"]==$rowpromocao["id_promocoes"] ? 'selected' : '') . ">" . $rowpromocao["titulo"] . "</option>";
					// $arr[$i] = "<option value='".$row["id_vendedores"]."'>".$row["nome"]."</option>";
					
				}
			}
			echo json_encode($arr);
		} else
		echo "falhou";
	}
	catch (Exception $e) {
		$erro = $e->getMessage();
		echo json_encode($erro);
	}
	
?>			