<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	
	date_default_timezone_set('america/sao_paulo');
	
	try {
		if (isset($_POST["IdUsuario"])) {
			
			
			$IdUsuario = mysqli_real_escape_string($conn, $_POST["IdUsuario"]);
			$sql       = "SELECT * FROM usuarios WHERE id='" . $IdUsuario . "'";
			$stmt      = $conn->prepare($sql); //
			$stmt->execute();
			$result = $stmt->get_result();
			$row    = $result->fetch_assoc();
			echo json_encode($row);
		} else
        echo "falhou";
	}
	catch (Exception $e) {
		$erro = $e->getMessage();
		echo json_encode($erro);
	}
	
?>