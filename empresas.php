<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	
	$TituloPage = "Empresas";
	date_default_timezone_set('america/sao_paulo');
	
	// Adicionamos os atributos de nome e ordem para fazer a consulta e definir a ordem da tabela 
	try {
		if (isset($_POST["Nome"])) {
			
			$Ordem  = mysqli_real_escape_string($conn, $_POST["Ordem"]);
			$nome = mysqli_real_escape_string($conn, $_POST["Nome"]);
			
			//echo "<script>alert('".$$dt."')</script>";
			
			} else {
			$DataInicial = date('d/m/Y 00:00');
			$DataFinal = date('d/m/Y 23:59');
			
			$Ordem  = 0;
			$nome = "";
			$dti = formata_data_mysql($DataInicial);
			$dtf = formata_data_mysql($DataFinal);
		}
		
		// Consulta e definição de ordem e parametro de pesquisa no banco
		$sql = "SELECT * FROM empresas";
		if ($nome != "" && $nome != null)
		$sql = $sql . " WHERE razao_social like'%" . $nome . "%'";
		
		if ($Ordem == 1)
		$sql = $sql . " ORDER By id_empresas DESC ";
		
		$stmt = $conn->prepare($sql); //
		$stmt->execute();
		$result = $stmt->get_result();
		} catch (Exception $e) {
		$erro = $e->getMessage();
	}
	//// Fim da definição da Consulta SQL //// 
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta name="author" content="Lucas Pereira Lima Sircilli">
		<link rel="icon" href="./imagens/Logo-teste-Login.png">
		<title><?= $TituloPage ?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link href="css/geral.css" rel="stylesheet">
		<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap-datetimepicker.js"></script>
		<script src="js/locales/bootstrap-datetimepicker.pt-BR.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</head>
	<script type="text/javascript">
		
	// Quando o DOM da página estiver pronto ele deve executar esta função de Formata Data
	$(document).ready(function() {
	//	$( "#datetimepicker" ).datepicker();
	$('.form_datetime').datetimepicker({
	format: 'dd/mm/yyyy hh:ii',
	language: 'pt-BR',
	weekStart: 1,
	todayBtn: 1,
	autoclose: 1,
	todayHighlight: 1,
	startView: 2,
	forceParse: 0,
	showMeridian: 1
	});
	});
    // Fim da Função de Formata Data
	
	function SubmeterForm() {
	CarregaLoader();
	$("#FormLog").submit();
	}
	function EditarEmpresa(id) {
	CarregaLoader();
	location.href = "localhost/ScoreSale/empresasCRUD.php?id="+id;
	/*  var w = window.open("http://linkteste.com.br/empresasCRUD.php?id="+id);
	w.addEventListener("load", function(event) {
	location.reload();
	});*/
	}    
    // Função para Popular Campos do CRUD para Edição feita via Ajax 
	function Editar(id) {
	
	$("#eError").text("");
	$("#eSucesso").text("");
	$.ajax({
	type: "POST",
	url: 'empresasQuery.php',
	data: {
	IdEmpresa: id,
	},
	success: function(html) {
	var ob = JSON.parse(html)
	console.log(ob)
	
	$("#eId").val(ob.id_empresas);
	$("#eNome").val(ob.razao_social);
	$("#eSenha").val(ob.senha);
	$("#eInscricaoEstadual").val(ob.inscricao_estadual);
	$("#eInscricaoMunicipal").val(ob.inscricao_municipal);
	$("#eTelefone").val(ob.telefone);
	$("#eCnpj").val(ob.cnpj);
	$("#eEndereco").val(ob.endereco);
	$("#eWhatsapp").val(ob.whatsapp);
	$("#eEmail").val(ob.email);
	$("#eResponsavel").val(ob.responsavel);
	$("#eUsuario").val(ob.usuario);
	
	$("#eObservacao").val(ob.obs);
	$("#eDataFundacao").val(ob.data_fundacao);
	
	$("#eNomeSocio1").val(ob.nome_socio1);
	$("#ePercentualSocio1").val(ob.percentual_socio1);
	$("#eIsadminsocio1").val(ob.is_admin_socio1);
	$("#eNomeSocio2").val(ob.nome_socio2);
	$("#ePercentualSocio2").val(ob.percentual_socio2);
	$("#eIsadminsocio2").val(ob.is_admin_socio2);
	$("#eNomeSocio3").val(ob.nome_socio3);
	$("#ePercentualSocio3").val(ob.percentual_socio3);
	$("#eIsadminsocio3").val(ob.is_admin_socio3);
	$("#eNomeSocio4").val(ob.nome_socio4);
	$("#ePercentualSocio4").val(ob.percentual_socio4);
	$("#eIsadminsocio4").val(ob.is_admin_socio4);
	$("#eNomeSocio5").val(ob.nome_socio5);
	$("#ePercentualSocio5").val(ob.percentual_socio5);
	$("#eIsadminsocio5").val(ob.is_admin_socio5);
	
	
	//	$("#ePermissao").val(ob.niveis_acesso_id);
	//    $("#eSenha").val("");
	$("#ModalEdit").modal("show");
	},
	error: function(xhr, ajaxOptions, thrownError) {
	alert(thrownError);
	}
	
	});
	return;
	};
	// Fim da Função de Popular CRUD
	
	function Excluir(id){
	CarregaLoader();
	$("#ModalExcluir").modal("show");
	$("#IdExclude").val(id);
	}
	
	function AdicionarEmpresa() {
	CarregaLoader();
	location.href = "http://localhost/ScoreSale/empresasCRUD.php?id="+0;
	//location.href = "localhost/ScoreSale/empresasCRUD.php?id="+0;
	/* var w = window.open("http://linkteste.com.br/empresasCRUD.php?id="+0);
	w.addEventListener("load", function(event) {
	location.reload();
	});*/
	}
	// Verifica se alguma Variável obrigatória não foi inserida e cadastra o usuário no banco via Ajax
	function GravarEmpresa() {
	if ($("#eNome").val() == null || $("#eNome").val() == "")
	$("#eError").text("É necessário preencher o campo de Razão Social");
	else if ($("#eEmail").val() == null || $("#eEmail").val() == "")
	$("#eError").text("É necessário preencher o campo Email");
	else if ($("#eSenha").val() == null || $("#eSenha").val() == "")
	$("#eError").text("É necessário preencher o campo Senha");
	else if ($("#eInscricaoEstadual").val() == null || $("#eInscricaoEstadual").val() == "")
	$("#eError").text("É necessário preencher o campo de Inscrição Estadual");
	else if ($("#eInscricaoMunicipal").val() == null || $("#eInscricaoMunicipal").val() == "")
	$("#eError").text("É necessário preencher o campo de Inscrição Municipal");
	else if ($("#eTelefone").val() == null || $("#eTelefone").val() == "")
	$("#eError").text("É necessário preencher o campo Telefone");   
	else if ($("#eCnpj").val() == null || $("#eCnpj").val() == "")
	$("#eError").text("É necessário preencher o campo CNPJ");
	else if ($("#eEndereco").val() == null || $("#eEndereco").val() == "")
	$("#eError").text("É necessário preencher o campo Endereço");
	else if ($("#eResponsavel").val() == null || $("#eResponsavel").val() == "")
	$("#eError").text("É necessário preencher o campo Responsável");
	else if ($("#eWhatsapp").val() == null || $("#eWhatsapp").val() == "")
	$("#eError").text("É necessário preencher o campo WhatsApp");
	
	var dataU = {};
	dataU.Id = $("#eId").val();
	dataU.Nome = $("#eNome").val();
	dataU.Email = $("#eEmail").val();
	dataU.Usuario = $("#eUsuario").val();
	dataU.Telefone = $("#eTelefone").val();
	dataU.InscricaoEstadual = $("#eInscricaoEstadual").val();
	dataU.InscricaoMunicipal = $("#eInscricaoMunicipal").val();
	dataU.Senha = $("#eSenha").val();
	dataU.CNPJ = $("#eCnpj").val();
	dataU.Endereco = $("#eEndereco").val();
	dataU.Responsavel = $("#eResponsavel").val();
	dataU.Whatsapp = $("#eWhatsapp").val();
	dataU.Permissao = 2
	
	/*if(!ValidateEmail(dataU.Email)){
	$("#eError").text("Email inválido");
	return;
	}*/
	
	$.ajax({
	type: "POST",
	url: 'empresasInsert.php',
	data: dataU,
	success: function(html) {
	if (html.indexOf("sucesso") != -1) {
	$("#eSucesso").text(html);
	$("#ModalEdit").modal("hide");
	$("#FormLog").submit();
	
	} else {
	$("#eError").text(html);
	}
	
	},
	error: function(xhr, ajaxOptions, thrownError) {
	$("#eError").text(thrownError);
	},
	
	
	});
	return;
	}
	
	function ExcluirEmpresa(){
	
	var dataU = {};
	dataU.Id = $("#IdExclude").val();
	
	$.ajax({
	type: "POST",
	url: 'empresasDelete.php',
	data: dataU,
	success: function(html) {
	
	if (html.indexOf("sucesso") != -1) {                  
	$("#ModalExcluir").modal("hide");
	TiraLoader();
	$("#FormLog").submit();
	}
	else if(html.indexOf("obras vinculadas") != -1){
	alert(html);
	$("#ModalExcluir").modal("hide");
	TiraLoader();
	$("#FormLog").submit();
	}
	
	else {
	$("#eError").text(html);
	}
	
	},
	error: function(xhr, ajaxOptions, thrownError) {
	$("#eError").text(thrownError);
	}
	
	});
	return;
	}
	
	function ValidateEmail(mail) {
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
	return (true)
	}
	
	return (false)
	}
	</script>
	<body>
	<?php include 'menu.php'; ?>
	<div class="container ">
	<form id="FormLog" action="<?= $_SERVER["PHP_SELF"] ?>" method="POST">
	<div class="row">
	<div class="col-sm-12 col-xs-12 form-group-sm form-group-xs">
	<div class="panel panel-default">
	<div class="panel-heading">
	<div class="panel-title">
	Dados de Pesquisa
	</div>
	</div>
	<div class="panel-body">
	<div class="row">
	<div class="col-sm-4 col-4 form-group form-group-sm form-group-xs">
	<label class="control-label">Razão Social</label>
	<input class="form-control" name="Nome" id="Nome"></input>
	</div>
	<div class="col-sm-4 col-4 form-group form-group-sm form-group-xs">
	<label class="control-label">Ordem</label>
	<select class="form-control" name="Ordem" id="Ordem">
	<option value="0" <?= ($Ordem == '0') ? 'selected' : '' ?>>Crescente</option>
	<option value="1" <?= ($Ordem == '1') ? 'selected' : '' ?>>Decrescente</option>
	</select>
	</div>
	<div class="col-sm-1 col-1 form-group form-group-sm form-group-xs"></div>
	<div class="col-sm-3 col-3 form-group form-group-sm form-group-xs text-right">
	<label class="control-label">&nbsp;&nbsp; </label>
	<a class="form-control botoes btn btn-primary" onclick="SubmeterForm();">Pesquisar</a>
	</div>
	</div>
	<div class="row">
	</div>
	</div>
	</div>
	</div>
	</div>
	</form>
	<div class="row">
	<div class="form-group form-group-sm form-group-xs col-xs-12 col-sm-12">
	<a class="btn btn-primary" onclick="AdicionarEmpresa()" title="Adicionar Empresa">Adicionar Empresa</span></a>
	</div>
	</div>
	<div class="row">
	<div class="col-sm-12 col-xs-12 form-group-xs form-group-sm">
	<table class="table table-condensed table-striped" style="width: -webkit-fill-available">
	<thead>
	<tr>
	<th class="hidden-md hidden-lg"></th>
	<th class="hidden-xs hidden-sm">Id</th>
	<th class="hidden-xs hidden-sm">Razão Social</th>
	<th class="hidden-xs hidden-sm">CNPJ</th>
	<th class="hidden-xs hidden-sm">Endereco</th>
	<th class="hidden-xs hidden-sm">Whatsapp</th>
	<th class="hidden-xs hidden-sm">E-mail</th>
	<th class="hidden-xs hidden-sm">Responsável</th>
	<th></th>
	</tr>
	</thead>
	<tbody>
	<!-- Popula as tabelas com cada Usuário -->
	<?php
	if ($result->num_rows > 0) {
	for ($i = 0; $i < $result->num_rows; $i++) {
	$row = $result->fetch_assoc();
	echo "<tr>
	<td class='hidden-md hidden-lg'>
	<b>Id: </b>" . $row["id_empresas"] . "<br/>
	<b>Razão Social: </b>" . $row["razao_social"] . "<br/>
	<b>CNPJ: </b>" . $row["cnpj"] . "<br/>
	<b>Endereço: </b>" . $row["endereco"] . "<br/>
	<b>WhatsApp: </b>" . $row["whatsapp"] . "<br/>
	<b>Email: </b>" . $row["email"] . "<br/>
	<b>Responsável: </b>" . $row["responsavel"] . "<br/>
	</td>
	
	<td class='hidden-xs hidden-sm'>" . ($row["id_empresas"]) . "</td>
	<td class='hidden-xs hidden-sm'>" . ($row["razao_social"]) . "</td>
	<td class='hidden-xs hidden-sm'>" . ($row["cnpj"]) ."</td>
	<td class='hidden-xs hidden-sm'>" . ($row["endereco"]) . "</td>
	<td class='hidden-xs hidden-sm'>" . ($row["whatsapp"]) . "</td>
	<td class='hidden-xs hidden-sm'>" . ($row["email"]) ."</td>
	<td class='hidden-xs hidden-sm'>" . ($row["responsavel"]) . "</td>
	
	<td class='text-right'>
	<a class='btn btn-primary' title='Editar Empresa' onclick='EditarEmpresa(" . $row["id_empresas"] . ")'><span class='glyphicon glyphicon glyphicon-edit'></span></a>
	<a class='btn btn-danger' title='Excluir Usuário' onclick='Excluir(" . $row["id_empresas"] . ")'><span class='glyphicon glyphicon glyphicon-trash'></span></a>
	</td>
	</tr>";
	}
	}
	?>
	<!-- Fim da formula de Popular tabelas -->
	</tbody>
	</table>
	
	<div class="row">&nbsp;</div>
	<div class="row">&nbsp;</div>
	</div>
	</div>
	</div>
	<!-- Modal de Edição -->
	<div id="ModalEdit" class="modal fade" role="dialog">
	<div class="modal-dialog ">
	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header" style="background-color: #00091a; color:white; border-radius:5px 5px 0px 0px;">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Edição de Empresa</h4>
	</div>
	<div class="modal-body">
	<div class="row">
	<div class="form-group form-group-sm form-group-xs col-xs-3 col-sm-3">
	<label class="control-label">CNPJ</label>
	<input class="form-control" id="eCnpj" name="eCnpj" />
	</div>
	<div class="form-group form-group-sm form-group-xs col-xs-9 col-sm-9">
	<label class="control-label">Razão Social</label>
	<input class="form-control" id="eNome" name="eNome" />
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm form-group-xs col-xs-3 col-sm-3">
	<label class="control-label">Id</label>
	<input class="form-control" id="eId" name="eId" disabled />
	</div>
	<div class="form-group form-group-sm form-group-xs col-xs-9 col-sm-9">
	<label class="control-label">Endereço</label>
	<input class="form-control" id="eEndereco" name="eEndereco" />
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm form-group-xs col-xs-6 col-sm-6">
	<label class="control-label">Usuário</label>
	<input class="form-control" id="eUsuario" name="eUsuario" />
	</div>
	<div class="form-group form-group-sm form-group-xs col-xs-6 col-sm-6">
	<label class="control-label">Senha</label>
	<input class="form-control" type="password" id="eSenha" name="eSenha" />
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm form-group-xs col-xs-6 col-sm-6">
	<label class="control-label">Inscrição Estadual</label>
	<input class="form-control" id="eInscricaoEstadual" name="eInscricaoEstadual" />
	</div>
	<div class="form-group form-group-sm form-group-xs col-xs-6 col-sm-6">
	<label class="control-label">Inscrição Municipal</label>
	<input class="form-control" id="eInscricaoMunicipal" name="eInscricaoMunicipal" />
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm form-group-xs col-xs-3 col-sm-3">
	<label class="control-label">WhatsApp</label>
	<input class="form-control" id="eWhatsapp" name="eWhatsapp" />
	</div>
	<div class="form-group form-group-sm form-group-xs col-xs-9 col-sm-9">
	<label class="control-label">Email</label>
	<input type=email required class="form-control" id="eEmail" name="eEmail" />
	</div>
	</div>
	<!--	<div class="row">
	<div class="form-group form-group-sm col-sm-12">
	<label class="control-label">Grupo de Permissão</label>
	<select class="form-control" id="ePermissao" name="ePermissao">
	<option value="1">Administrador</option>
	<option value="3">Operador</option>
	</select>
	</div>                        
	</div> -->
	<div class="row">
	<div class="form-group form-group-sm form-group-xs col-xs-3 col-sm-3">
	<label class="control-label">Telefone</label>
	<input class="form-control" id="eTelefone" name="eTelefone" />
	</div>
	<div class="form-group form-group-sm form-group-xs col-xs-9 col-sm-9">
	<label class="control-label">Responsável</label>
	<input class="form-control" id="eResponsavel" name="eResponsavel" />
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm form-group-xs col-xs-12 col-sm-12">
	<span id="eError" name="eError" style="color:firebrick"></span>
	<span id="eSucesso" name="eSucesso" style="color:green"></span>
	</div>
	</div>
	</div>
	<div class="modal-footer" style="background-color: #00091a; border-radius:0px 0px 5px 5px;">
	<button type="button" class="btn btn-success" onclick="GravarEmpresa()">Gravar</button>
	<button type="button" class="btn btn-danger" onclick="TiraLoader()" data-dismiss="modal">Cancelar</button>
	</div>
	</div>
	</div>
	</div>
	<!-- Fim do Modal -->
	<!-- Modal de Excluir-->
	<div id="ModalExcluir" class="modal fade" role="dialog">
	<div class="modal-dialog ">
	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header" style="background-color: #00091a; color:white; border-radius:5px 5px 0px 0px;">
	<button type="button" class="close" onclick="TiraLoader()" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Atenção</h4>
	</div>
	<div class="modal-body">
	<div class="row">
	<div class="form-group form-group-sm form-group-xs col-xs-12 col-sm-12">
	<input name="IdExclude" id="IdExclude" style="display:none"/>
	<h4>Deseja realmente excluir esta Empresa?</h4>
	</div>
	</div>
	</div>
	<div class="modal-footer" style="background-color: #00091a; border-radius:0px 0px 5px 5px;">
	<button type="button" class="btn btn-success btn-sm" onclick="ExcluirEmpresa()">Excluir</button>
	<button type="button" class="btn btn-danger" onclick="TiraLoader()" data-dismiss="modal">Cancelar</button>
	</div>
	</div>
	</div>
	</div>
	<footer class="container-fluid text-center" style="background-color:#091742;position: fixed;bottom: 0px!important;width: 100vw;">
	<div class="row">
	<div class="col-sm-6 col-xs-6 text-left"><img src="./imagens/Logo-teste-Login.png" style="height:3vh;margin:10px"/></div>
	<!-- <div class="col-sm-6 col-xs-6 text-right"><a href=""><img src="./imagens/logo-branca.png" style="height:3vh;margin:10px"/></a></div> -->
	</div>
	</div>
	</footer>
	<!-- Fim do Modal -->
	</body>
	</html>		