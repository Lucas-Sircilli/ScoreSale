<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	date_default_timezone_set('america/sao_paulo');
	
	try {
		if (isset($_POST["Id"])) {
			
			$Id = mysqli_real_escape_string($conn, $_POST["Id"]);
			$CNPJ = mysqli_real_escape_string($conn, $_POST["CNPJ"]);
			$CPF = mysqli_real_escape_string($conn, $_POST["CPF"]);
			
			$sql = "SELECT * FROM parceiros WHERE id_parceiros='" . $Id . "'";
			
			$stmt = $conn->prepare($sql); //
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows == 0) {
				echo "Parceiro n«ªo encontrado para excluir";
				return;
				} else {
				$stmt = $conn->prepare("DELETE FROM `parceiros` WHERE id_parceiros=?");
				
				$stmt->bind_param('i', $Id);
				
				if (!$stmt->execute()) {
					echo '[' . $stmt->errno . "] " . $stmt->error;
					} else {
					if ($CNPJ != "" || $CNPJ != null) {
						
						$stmt = $conn->prepare("DELETE FROM `usuarios` WHERE email=?");
						
						$stmt->bind_param('s', $CNPJ);
						} else {
						
					$stmt = $conn->prepare("DELETE FROM `usuarios` WHERE email=?");
                    
                    $stmt->bind_param('s', $CPF);
					}
					if (!$stmt->execute()) {
                    echo '[' . $stmt->errno . "] " . $stmt->error;
					} else {
                    echo "Registro excluido com sucesso!";
                    
					}
					}
					}
					}
					}
					catch (Exception $e) {
					$erro = $e->getMessage();
					echo json_encode($erro);
					}
										