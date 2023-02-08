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
	
	
	
	function formata_data_mysql($strdata)
	{    
		try{
			if (strpos($strdata, "/") !== false) {
				$dtt = explode(" ", $strdata);    
				$dts = explode("/", $dtt[0]);  
				if(count($dts)>=1)			
				return $dts[2]."-".$dts[1]."-".$dts[0]." ".$dtt[1].":00"; 
			}
			else return $strdata;
		}
		catch (Exception $e) {
			return "";
		}	
	}
	
	function formata_data_exibicao($strdata)
	{    
		try{
			$dtt = explode(" ", $strdata);    
			$dts = explode("-", $dtt[0]); 
			if(count($dts)>=2 && count($dtt)>=1)		
			return $dts[2]."/".$dts[1]."/".$dts[0]." ".$dtt[1];    
		}
		catch (Exception $e) {
			return "";
		}
	}
	
	function formata_data_exibicao2($strdata)
	{    
		try{
			$dtt = explode(" ", $strdata);    
			$dts = explode("-", $dtt[0]); 
			if(count($dts)>=2 && count($dtt)>=1)		
			return $dts[2]."/".$dts[1]."/".$dts[0];    
		}
		catch (Exception $e) {
			return "";
		}
	}
	
	function convStatus($status)
	{
		if($status==0)
        return "Em Andamento";
		else if($status==1)
        return "Finalizada e Não Enviada";
		else if($status==2)
        return "Finalizada e Enviada";
	}
	
	
	function verifica_sessao()
	{
		if (is_session_started() === FALSE) session_start();
		
		try{
			//echo "console.log('".$_SESSION['usuarioNome']." - ".$_SESSION['usuarioNiveisAcessoId']."')";
			if (isset($_SESSION) == false || !isset($_SESSION['usuarioNome'])) {
				echo "console.log('FD PRIMEIRA LINHA')";
				$URL = "sair.php";
				
				echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
				echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
				exit();
			}
			}catch(Exception $e){
			echo "console.log('FD SEGUNDA LINHA')";
			$URL = "sair.php";
			echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
			echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
			exit();
			
		}
	}
	verifica_sessao();
	
	
	
?>
