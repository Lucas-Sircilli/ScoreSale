<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	
	date_default_timezone_set('america/sao_paulo');
	
	try {
		if (isset($_POST["Ordem"])) {
			
			$Ordem = mysqli_real_escape_string($conn, $_POST["Ordem"]);
			$Nome = mysqli_real_escape_string($conn, $_POST["Nome"]);
			$IdEmpresa = mysqli_real_escape_string($conn, $_POST["IdEmpresa"]);
			
			if ($Ordem == 1) {
				$sql = "SELECT * FROM vendedores WHERE id_empresas='" . $IdEmpresa . "' AND nome like'%" . $Nome . "%'" . "ORDER BY id_vendedores DESC";
			} else
            $sql = "SELECT * FROM vendedores WHERE id_empresas='" . $IdEmpresa . "' AND nome like'%" . $Nome . "%'" . "ORDER BY id_vendedores ASC";
			
			$stmt = $conn->prepare($sql); //
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows > 0) {
				
				for ($i = 0; $i < $result->num_rows; $i++) {
					$row = $result->fetch_assoc();
					
					$arr[$i] = "<td nowrap>" . $row["id_vendedores"] . "</td><td nowrap>" . $row["nome"] . "</td><td nowrap>" . $row["data_admissao"] . "</td><td nowrap>" . $row["data_demissao"] . "</td><td nowrap>" . $row["is_vendedor_ativo"] . "</td><td class='text-right' nowrap>
					<a class='btn btn-primary btn-sm' title='Editar Vendedor' onclick='EditarVendedor(" . $row["id_vendedores"] . ")'><span class='glyphicon glyphicon glyphicon-edit'></span></a>
					<a class='btn btn-danger btn-sm' title='Excluir Vendedor' onclick='Excluir(" . $row["id_vendedores"] . ")'><span class='glyphicon glyphicon glyphicon-trash'></span></a></td> ";
					
					/*$arr[$i] = "<td nowrap>'" . $row["id_vendedores"] . "'". "</td>" . "<td nowrap>'" . $row["nome"] . "'". "</td>" . "<td nowrap>'" . $row["data_admissao"] . "'". "</td>" . "<td nowrap>'" . $row["data_demissao"] . "'". "</td>" .
						"<td nowrap>'" . $row["is_vendedor_ativo"] . "'". "</td><td class='text-right' nowrap>
						<a class='btn btn-primary btn-sm' title='Editar Vendedor' onclick='EditarVendedor(" . $row["id_vendedores"] .")'><span class='glyphicon glyphicon glyphicon-edit'></span></a>
					<a class='btn btn-danger btn-sm' title='Excluir Vendedor' onclick='Excluir(". $row["id_vendedores"].")'><span class='glyphicon glyphicon glyphicon-trash'></span></a></td>"; */
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