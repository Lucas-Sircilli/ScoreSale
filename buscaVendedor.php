<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	
	date_default_timezone_set('america/sao_paulo');
	
	try {    
		if (isset($_POST["Id"])) {
			
			$Id = mysqli_real_escape_string($conn, $_POST["Id"]);
			$IdEmpresa = mysqli_real_escape_string($conn, $_POST["IdEmpresa"]);
			$sqlpontuacao = "SELECT * FROM pontuacoes WHERE id_pontuacoes='" . $Id . "'";
			$stmtpontuacao = $conn->prepare($sqlpontuacao); //
			$stmtpontuacao->execute();
			$resultpontuacao = $stmtpontuacao->get_result();
			$rowpontuacao = $resultpontuacao->fetch_assoc();
			
			$sql = "SELECT * FROM vendedores WHERE id_empresas='" . $IdEmpresa . "'";
			$stmt = $conn->prepare($sql); //
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows > 0) {
				for ($i = 0; $i < $result->num_rows; $i++) {
					$row = $result->fetch_assoc();
					
					$arr[$i] = "<option value='" . $row["id_vendedores"] . "'" . ($rowpontuacao["id_vendedores"] == $row["id_vendedores"] ? 'selected' : '') . ">" . $row["nome"] . "</option>";
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