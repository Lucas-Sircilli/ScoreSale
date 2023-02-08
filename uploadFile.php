<?php
	/*include_once("funcoes.php");
		include_once("conexao.php");
	date_default_timezone_set('america/sao_paulo');*/
	// file name
	
	try {
		$type = explode(".", $_FILES['eArquivo']['name']);
		//$newfilename = round(microtime(true)) . '.' . end($type);
		// Location
		//$location = "./media/".$newfilename;
		// $location = $_POST["eMicrotime"] . '.' . end($type);
		$location = $_POST["eMicrotime"];
		
		// file extension
		$file_extension = pathinfo($location, PATHINFO_EXTENSION);
		$file_extension = strtolower($file_extension);
		
		// Valid image extensions
		$image_ext = array("jpg","png","jpeg","webp");
		
		//$response = 0;
		
		/*$sql = "SELECT * FROM promocoes WHERE foto='" . $location  . "'";
			$stmt = $conn->prepare($sql); //
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows > 0) {
            return;
            //$response = "O nome da imagem já está sendo usado, por favor renomeie";
		}*/
		//else{
		if(in_array($file_extension,$image_ext)){
			// Upload file
			if(move_uploaded_file($_FILES['eArquivo']['tmp_name'],$location)){
			//$response = "Registro gravado com sucesso!". $_POST["eMicrotime"];
			//echo json_encode($response);
			//$upload_max_size = ini_get('upload_max_filesize');
			echo "Registro gravado com sucesso!";
			
			}
			}//}
			else
			echo "Não Foi Possível Gravar a Imagem!";
			//mail ('email@email.com','email of name',"name is ".$_POST['nametag']);
			}
			catch (Exception $e) {
			$erro = $e->getMessage();
			echo json_encode($erro);
			}
			
			?>			