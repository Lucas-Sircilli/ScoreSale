<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	date_default_timezone_set('america/sao_paulo');
	
	try {
		if (isset($_POST["Id"])) {
			
			$Id = mysqli_real_escape_string($conn, $_POST["Id"]);
			
			
			$sql = "SELECT * FROM promocoes WHERE id_promocoes='" . $Id . "'";
			
			$stmt = $conn->prepare($sql); //
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows == 0) {
				echo "Promoção não encontrado para excluir";
				return;
				} else {
				$row = $result->fetch_assoc();
				$foto = $row["foto"];
				$path = substr($foto, 2);
				//$handle = fopen(row["foto"], "r+");
				unlink($path);
				
				$stmt = $conn->prepare("DELETE FROM `promocoes` WHERE id_promocoes=?");
				
				$stmt->bind_param('i', $Id);
				
				if (!$stmt->execute()) {
					echo '[' . $stmt->errno . "] " . $stmt->error;
					} else {
					echo "Registro excluido com sucesso!";
				}
			}
			}
			}
			catch (Exception $e) {
			$erro = $e->getMessage();
			echo json_encode($erro);
			}			