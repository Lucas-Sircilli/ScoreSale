<?php
	function is_session_started()
	{
		if (php_sapi_name() !== 'cli') {
			if (version_compare(phpversion(), '5.4.0', '>=')) {
				return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
				} else {
				return session_id() === '' ? FALSE : TRUE;
			}
		}
		return FALSE;
	}
	
	function printArray($array, $pad=''){
		$fp = fopen('data.txt', 'w');
		
		
		
		foreach ($array as $key => $value){
			
			fwrite($fp, $pad . "$key => $value\r\n");
			if(is_array($value)){
				printArray($value, $pad.' ');
			}  
		} 
		fclose($fp);
	}
	
	function verificaPostJson(){
		if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
			throw new Exception('Request method must be POST!');
		}
		
		//Make sure that the content type of the POST request has been set to application/json
		$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
	if(strpos($contentType, 'application/json') === false){
	throw new Exception('Content type must be: application/json');
    }
	
    $content = trim(file_get_contents("php://input"));
	
    $data = json_decode($content, true);
    printArray($data);
	return $data;
	}
	
	function verificaGetJson(){
    $fp = fopen('data.txt', 'w');
	
    if(strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') != 0){
	fwrite($fp,'Request method must be GET!');
	throw new Exception('Request method must be GET!');
    }
    
	
    fwrite($fp,$_SERVER["CONTENT_TYPE"]);
	
    $content = trim(file_get_contents("php://input"));
    fwrite($fp,$content."ssssssssssss");
    $data = json_decode($content, true);
    //printArray($data);
	
	fclose($fp);
	return $data;
	}
	
	function formata_data_mysql($strdata)
	{    
    $dtt = explode(" ", $strdata);    
    $dts = explode("/", $dtt[0]);   
    return $dts[2]."-".$dts[1]."-".$dts[0]." ".$dtt[1].":00";    
	}
	
	function formata_data_exibicao($strdata)
	{    
    $dtt = explode(" ", $strdata);    
    $dts = explode("-", $dtt[0]);   
    return $dts[2]."/".$dts[1]."/".$dts[0]." ".$dtt[1];    
	}
	
	function convStatus($status)
	{
    if($status==0)
	return "Em Andamento";
    else if($status==1)
	return "Finalizada e Nè´™o Enviada";
    else if($status==2)
	return "Finalizada e Enviada";
	}
	
	
	function verifica_sessao()
	{
    if (is_session_started() === FALSE) session_start();
    if (isset($_SESSION) == false || $_SESSION['usuarioNome'] == null) {
	
	$URL = "sair.php";
	echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
	echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
	exit();
    }
	}
	//verifica_sessao();
	
	
	?>
		