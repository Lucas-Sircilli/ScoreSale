<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	
	date_default_timezone_set('america/sao_paulo');
	
	try {
		if (isset($_POST["Id"])) {
			
			// Query do banco que encontra o usuário em questão e substitui a senha atual pela nova escolhida
			$Id = mysqli_real_escape_string($conn, $_POST["Id"]);
			$Nome = mysqli_real_escape_string($conn, $_POST["Nome"]);
			$Senha = mysqli_real_escape_string($conn, $_POST["Senha"]);
			$SenhaNova = mysqli_real_escape_string($conn, $_POST["SenhaNova"]);
			$sql = "SELECT * FROM usuarios WHERE id='" . $Id . "' AND senha='" . $Senha . "'";
			$stmt = $conn->prepare($sql); //
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			if ($row["senha"] != "" && $SenhaNova != "") {
				
				$stmt = $conn->prepare("UPDATE usuarios SET senha=? WHERE id=?");
				$stmt->bind_param('si', $SenhaNova, $Id);
				if (!$stmt->execute()) {
					echo '[' . $stmt->errno . "] " . $stmt->error;
				} else
                echo "   Registro gravado com sucesso!";
			} else if ($Senha != $row["senha"])
            echo "Senha Atual Não Compatível!";
            else if($SenhaNova == "")
            echo "É necessário colocar uma senha válida.";
		} else
        echo "falhou";
	}
	catch (Exception $e) {
		$erro = $e->getMessage();
		echo json_encode($erro);
	}
	
?>