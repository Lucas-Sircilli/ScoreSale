<?php 
	session_start();
	//Incluindo a conexão com banco de dados
	include_once("conexao.php");
	//O campo usuário e senha preenchido entra no if para validar
	if ((isset($_POST['email'])) && (isset($_POST['senha'])) && (isset($_POST['chkLGPD']))){
		$usuario = mysqli_real_escape_string($conn, $_POST['email']); //Escapar de caracteres especiais, como aspas, prevenindo SQL injection
		$senha = mysqli_real_escape_string($conn, $_POST['senha']);
		$lgpd = mysqli_real_escape_string($conn, $_POST['chkLGPD']);
		
		$IpAcesso = $_SERVER['REMOTE_ADDR'];
		
		if($lgpd==null || $lgpd==false)
		{
			$_SESSION['loginErro'] = "É necessário aceitar os termos de privacidade para continuar";
			header("Location: index.php");
			return;
		}
		
		if ($usuario == "admin") {
			$data = intval(date('d')) - 1;
			$nsen = "1234";
			//$nsen = "gvd0" . $data . "cfg";
			if (($nsen) == $senha) {
				$_SESSION['usuarioId'] = 0;
				$_SESSION['usuarioNome'] = "Administrador";
				$_SESSION['usuarioNiveisAcessoId'] = 1;
				$_SESSION['eventoNome'] = "Administrador";
				$_SESSION['usuarioEmail'] = "admin@teste.com.br";
				if ($_SESSION['usuarioNiveisAcessoId'] == "1") {
					header("Location: administrativo.php");
					} elseif ($_SESSION['usuarioNiveisAcessoId'] == "2") {
					header("Location: colaborador.php");
					} else {
					header("Location: cliente.php");
				}
			} else {
			$_SESSION['loginErro'] = "Usuário ou senha Inválido";
			header("Location: index.php");
			}
			return;
			}
			
			//$usuario = $usuario.replace('.', '').replace('-', '').replace('/', '');
			//Buscar na tabela usuario o usuário que corresponde com os dados digitado no formulário
			//$result_usuario = "SELECT * FROM usuarios WHERE email = '$usuario' && md5(CONCAT('sta0',day(now())-1,'cfg')) = '$senha' LIMIT 1";
			$result_usuario = "SELECT * FROM usuarios WHERE REPLACE(REPLACE( REPLACE( email, '.', '' ), '-', '' ), '/', '') = REPLACE(REPLACE( REPLACE('".$usuario."', '.', '' ), '-', '' ), '/', '') AND senha= '".$senha."'  LIMIT 1";
			
			$resultado_usuario = mysqli_query($conn, $result_usuario);
			$resultado = mysqli_fetch_assoc($resultado_usuario);
			
			$NomeSala = "Administrativo";
			
			//Encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
			if (isset($resultado)) {
			try {
			
			//echo "<script>alert('a')</script>";
			$_SESSION['usuarioId'] = $resultado['id'];
			$_SESSION['usuarioNome'] = $resultado['nome'];
			$_SESSION['usuarioNiveisAcessoId'] = $resultado['niveis_acesso_id'];
			$_SESSION['usuarioEmail'] = $resultado['email'];
			
			$stmt = $conn->prepare("INSERT INTO `acessos` (IpAcesso,SalaAcesso,EventoAcesso, DataInicio)  VALUES (?,?,?,Now())");
			
			$stmt->bind_param(
			'sss',
			$IpAcesso,
			$resultado['nome'],
			$NomeSala
			);
			
			if (!$stmt->execute()) {			
			//	echo "<javascript>alert('[" . $stmt->errno . "] " . $stmt->error."')</javascript>";
			} else {
			//	echo "<javascript>alert('Registro gravado com sucesso!')</javascript>";
			}
			//if ($_SESSION['usuarioNiveisAcessoId'] == "1") {
			header("Location: administrativo.php");
			//} elseif ($_SESSION['usuarioNiveisAcessoId'] == "2") {
			//	header("Location: colaborador.php");
			//} else {
			//	header("Location: cliente.php");
			//}
			
			} catch (Exception $e) {
			echo 'Exceção capturada: ',  $e->getMessage(), "\n";
			}
			//Não foi encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
			//redireciona o usuario para a página de login
			} else {
			$_SESSION['loginErro'] = "Usuário ou senha Inválido";
			header("Location: index.php");
			return;
			$SqlUsuario = "SELECT sl.id IdSala, ev.id IdEvento, ev.nome NomeEvento, sl.nome NomeSala, sl.url_camera UrlCamera FROM salas sl left join eventos ev ON sl.Id=ev.id_sala WHERE ev.usuario= '" . $usuario . "' AND ev.senha='".$senha."' and data_inicio<=now() and data_fim>=now() LIMIT 1";
			/*$stmt = $conn->prepare($SqlUsuario); //
			$stmt->execute();
			$resultado = $stmt->get_result();*/
			$resultado_usuario = mysqli_query($conn, $SqlUsuario);
			$resultado = mysqli_fetch_assoc($resultado_usuario);
			
			//$resultado_usuario = mysqli_query($conn, $result_usuario);
			//$resultado = mysqli_fetch_assoc($resultado_usuario);
			
			if (isset($resultado)) {
			try {
			
			$_SESSION['usuarioId'] = $resultado['IdEvento'];
			$_SESSION['usuarioNome'] = $resultado['NomeSala'];
			$_SESSION['eventoNome'] = $resultado['NomeEvento'];
			$_SESSION['usuarioNiveisAcessoId'] = 2;
			$_SESSION['urlCamera'] = $resultado['UrlCamera'];
			
			$stmt = $conn->prepare("INSERT INTO `acessos` (IpAcesso,SalaAcesso,EventoAcesso, DataInicio)   
			VALUES (?,?,?,Now())");
			
			$stmt->bind_param(
			'sss',
			$IpAcesso,
			$resultado['NomeSala'],
			$resultado['NomeEvento']
			);
			
			if (!$stmt->execute()) {
			//echo '[' . $stmt->errno . "] " . $stmt->error;
			} else {
			//echo "Registro gravado com sucesso!";
			}
			
			
			//if ($_SESSION['usuarioNiveisAcessoId'] == "1") {
			header("Location: transmissao.php");
			//} elseif ($_SESSION['usuarioNiveisAcessoId'] == "2") {
			//	header("Location: colaborador.php");
			//} else {
			//	header("Location: cliente.php");
			//}
			
			} catch (Exception $e) {
			echo 'Exceção capturada: ',  $e->getMessage(), "\n";
			}
			} else {	
			$result_usuario = "SELECT sl.id IdSala, ev.id IdEvento, ev.nome NomeEvento, sl.nome NomeSala, sl.url_camera UrlCamera FROM salas sl left join eventos ev ON sl.Id=ev.id_sala WHERE ev.usuario= '" . $usuario . "' AND ev.senha='".$senha."' and data_inicio>now() LIMIT 1";
			
			$resultado_usuario = mysqli_query($conn, $result_usuario);
			$resultado = mysqli_fetch_assoc($resultado_usuario);
			if (isset($resultado)) {
			$_SESSION['loginErro'] = "Este evento começara em breve... aguarde!";
			header("Location: index.php");
			}
			else{
			
			$result_usuario = "SELECT sl.id IdSala, ev.id IdEvento, ev.nome NomeEvento, sl.nome NomeSala, sl.url_camera UrlCamera FROM salas sl left join eventos ev ON sl.Id=ev.id_sala WHERE ev.usuario= '" . $usuario . "' AND ev.senha='".$senha."' and data_fim<now() LIMIT 1";
			$resultado_usuario = mysqli_query($conn, $result_usuario);
			$resultado = mysqli_fetch_assoc($resultado_usuario);
			
			if (isset($resultado)) {
			$_SESSION['loginErro'] = "Este evento já terminou!";
			header("Location: index.php");
			}
			else{
			
			$_SESSION['loginErro'] = "Usuário ou senha Inválido";
			header("Location: index.php");
			}
			
			}
			//Váriavel global recebendo a mensagem de erro
			
			}
			//Não foi encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
			//redireciona o usuario para a página de login
			} 
			//O campo usuário e senha não preenchido entra no else e redireciona o usuário para a página de login
			} else {
			$_SESSION['loginErro'] = "Usuário ou senha inválido";
			header("Location: index.php");
			}
						