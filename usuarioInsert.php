<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	date_default_timezone_set('america/sao_paulo');
	
	try {
		if (isset($_POST["Id"])) {
			
			$Id        = mysqli_real_escape_string($conn, $_POST["Id"]);
			$Nome      = mysqli_real_escape_string($conn, $_POST["Nome"]);
			$Email     = mysqli_real_escape_string($conn, $_POST["Email"]);
			$Senha     = (mysqli_real_escape_string($conn, $_POST["Senha"]));
			$Permissao = (mysqli_real_escape_string($conn, $_POST["Permissao"]));
			
			if ($Id == 0) {
				$sql = "SELECT * FROM usuarios WHERE email='" . $Email . "'";
				
				$stmt = $conn->prepare($sql); //
				$stmt->execute();
				$result = $stmt->get_result();
				if ($result->num_rows > 0) {
					echo "Já existe um usuário cadastrado com este Login";
					return;
				}
				/* $stmt = $conn->prepare("INSERT INTO `usuarios` (nome,email,senha,situacoe_id,niveis_acesso_id,created,modified)  
				VALUES (?,?,md5(?),1,?,Now(), Now())");*/
				$stmt = $conn->prepare("INSERT INTO `usuarios` (nome,email,senha,situacoe_id,niveis_acesso_id,created,modified)  
				VALUES (?,?,?,1,?,Now(), Now())");
				
				$stmt->bind_param('sssi', $Nome, $Email, $Senha, $Permissao);
				
				if (!$stmt->execute()) {
					echo '[' . $stmt->errno . "] " . $stmt->error;
					} else {
					echo "Registro gravado com sucesso!";
				}
				} else {
				
				$sql = "SELECT * FROM usuarios WHERE id='" . $Id . "'";
				
				$stmt = $conn->prepare($sql); //
				$stmt->execute();
				$result = $stmt->get_result();
				$row    = $result->fetch_assoc();
				
				if ($row["email"] != $Email) {
                echo "Não é permitido alterar o login de um usuário existente";
                return;
				}
				
				if ($Senha == "" || $Senha == null) {
                echo "É necessário inserir a senha atual para edição do usuário em questão!!";
                return;
                /*    $stmt = $conn->prepare("UPDATE `usuarios` SET nome=?,email=?,niveis_acesso_id=?,senha=senha WHERE id=?");
                $stmt->bind_param(
                'ssii',
                $Nome,
                $Email,
                $Permissao,
                $Id
                );        */
				}
				if ($Senha != $row["senha"]) {
                echo "Não é permitido alterar a senha de um usuário existente";
                return;
				} else {
                
                $stmt = $conn->prepare("UPDATE `usuarios` SET nome=?,email=?,niveis_acesso_id=? WHERE id=?");
                $stmt->bind_param('ssii', $Nome, $Email, $Permissao, $Id);
				}
				
				if (!$stmt->execute()) {
                echo '[' . $stmt->errno . "] " . $stmt->error;
				} else {
                echo "Registro gravado com sucesso!";
				}
				}
				}
				}
				catch (Exception $e) {
				$erro = $e->getMessage();
				echo json_encode($erro);
				}				