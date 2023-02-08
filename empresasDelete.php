<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	date_default_timezone_set('america/sao_paulo');
	
	try {
		if (isset($_POST["Id"])) {
			
			$Id = mysqli_real_escape_string($conn, $_POST["Id"]);
			
			
			$sql = "SELECT * FROM empresas WHERE id_empresas='" . $Id . "'";
			
			$stmt = $conn->prepare($sql); //
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows == 0) {
				echo "Usuário não encontrado para excluir";
				return;
			}
			
			
			else {
				$sqlpontuacao  = "SELECT * FROM pontuacoes WHERE id_empresas='" . $Id . "'";
				$stmtpontuacao = $conn->prepare($sqlpontuacao);
				$stmtpontuacao->execute();
				$resultpontuacao = $stmtpontuacao->get_result();
				
				if ($resultpontuacao->num_rows > 0) {
					echo "Não é possível excluir esta empresa pois existem obras vinculadas à esta empresa!!";
					return;
				}
				
				else {
					$stmt = $conn->prepare("DELETE FROM `empresas` WHERE id_empresas=?");
					
					$stmt->bind_param('i', $Id);
					
					
					
					
					if (!$stmt->execute()) {
						echo '[' . $stmt->errno . "] " . $stmt->error;
						} else {
						$stmt = $conn->prepare("DELETE FROM `vendedores` WHERE id_empresas=?");
						
						$stmt->bind_param('i', $Id);
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