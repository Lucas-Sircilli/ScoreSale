<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	
	$TituloPage = "Cadastro de Empresas";
	date_default_timezone_set('america/sao_paulo');
	
	try {
		if (isset($_GET["id"])){
			$id = $_GET["id"];
			
		}
		
		/// Consulta empresas  ////
		$sql = "SELECT * FROM empresas";
		if ($id != "" && $id != null){
			
			$sql = $sql . " WHERE id_empresas='" . $id . "'";
		}
		
		
		
		
		$stmt = $conn->prepare($sql); //
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($result->num_rows > 0) {
			for ($i = 0; $i < $result->num_rows; $i++) {
				$row = $result->fetch_assoc();
				
			}
			
		}
		
	if($id == 0){
	
	$row["id_empresas"] = 0;
	
	}
	
	
	$sql = "SELECT * FROM vendedores WHERE id_empresas='" . $id . "'";
	
	
	
	$stmt = $conn->prepare($sql); //
	$stmt->execute();
	$result = $stmt->get_result();
	
	/*if ($result->num_rows > 0) {
	for ($i = 0; $i < $result->num_rows; $i++) {
	$row1 = $result->fetch_assoc();
	
	}
	
	}*/
	
	/* if($id == 0){
	
	$row1["id_vendedores"] = 0;
	
	}*/
	
	} catch (Exception $e) {
	$erro = $e->getMessage();
	}
	
	
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="js/bootstrap-datetimepicker.js"></script>
	<script src="js/locales/bootstrap-datetimepicker.pt-BR.js"></script>
	<script src="js/bootstrap.min.js"></script>
	</head>
	<script type="text/javascript">
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
	$("#eCEP").bind('blur', function(e){
	ConsultaCEP(); 
	});
	$("#eCepVendedor").bind('blur', function(e){
	ConsultaCEPVendedor(); 
	});
	// Number
	});
	
	
	function createTable( opcoes, fieldTitles) {
	let tbl = document.getElementById("eTabelaVendedor");
	let thead = document.createElement('thead');
	let thr = document.createElement('tr');
	fieldTitles.forEach((fieldTitle) => {
	let th = document.createElement('th');
	th.appendChild(document.createTextNode(fieldTitle));
	thr.appendChild(th);
	});
	thead.appendChild(thr);
	tbl.appendChild(thead);
	let tbdy = document.createElement('tbody');
	for(var i=0; i < opcoes.length; i++){
	//opcoes[i];
	let tr = document.createElement('tr');
	tr.innerHTML= opcoes[i];
	tbdy.appendChild(tr);
	}
	tbl.appendChild(tbdy);
	}
	function SubmeterForm(){
	CarregaLoader();
	var dataU = {};
	dataU.Ordem = $("#eOrdemVendedor").children("option:selected").val();
	dataU.Nome = $("#eNomePesquisa").val();
	dataU.IdEmpresa = <?php echo $id; ?>;
	$.ajax({
	type: "POST",
	url: 'pesquisaVendedores.php',
	data: dataU,
	success: function(html) {
	/*var href =  window.location.href;
	$("#FormLog").submit();
	window.location.href = href;*/
	
	var ob = JSON.parse(html);
	var opcoes = [];
	$("#eTabelaVendedor").empty();
	try{    
	for(var i=0; i < ob.length; i++){
	opcoes[i] = ob[i];
	
	}
	// $("#eTabelaVendedor").html(opcoes);
	createTable(opcoes,['Id', 'Nome','Data de Admissão','Data de Demissão','Vendedor está ativo?']);
	TiraLoader();
	}
	catch(e){
	console.log(e);
	if(e.message.includes("Cannot read properties of null (reading 'length'")){
	TiraLoader();
	alert("Não foi possível Encontrar Vendedores Cadastrados desta Empresa");}
	}
	
	},
	error: function(xhr, ajaxOptions, thrownError) {
	console.log(thrownError);
	TiraLoader();
	
	}
	
	});
	/*var href =  window.location.href;
	$("#FormLog").submit();
	window.location.href = href;*/
	}
	
	function EditarVendedor(id) {
	
	$("#eError1").text("");
	$("#eSucesso1").text("");
	$.ajax({
	type: "POST",
	url: 'vendedoresQuery.php',
	data: {
	IdVendedor: id,
	},
	success: function(html) {
	var ob = JSON.parse(html)
	console.log(ob)
	$("#eIdVendedor").val(ob.id_vendedores);
	$("#eNomeVendedor").val(ob.nome);
	$("#eCpfVendedor").val(ob.cpf);
	$("#eRgVendedor").val(ob.rg);
	$("#eCepVendedor").val(ob.cep);
	$("#eEnderecoVendedor").val(ob.endereco);
	$("#eNumeroVendedor").val(ob.numero);
	$("#eBairroVendedor").val(ob.bairro);
	$("#eComplementoVendedor").val(ob.complemento);
	$("#eCidadeVendedor").val(ob.cidade);
	$("#eDataAniversario").val(ob.data_aniversario);
	$("#eDataAdmissao").val(ob.data_admissao);
	$("#eDataDemissao").val(ob.data_demissao);
	$("#eEstadoVendedor").val(ob.estado);
	
	if(ob.is_vendedor_ativo =='Sim')
	$("#eIsvendedorAtivo").val(0);
	else if(ob.is_vendedor_ativo =='Não')
	$("#eIsvendedorAtivo").val(1);
	
	
	
	//	$("#ePermissao").val(ob.niveis_acesso_id);
	//    $("#eSenha").val("");
	CarregaLoader();
	$("#ModalEdit").modal("show");
	},
	error: function(xhr, ajaxOptions, thrownError) {
	alert(thrownError);
	}
	
	});
	return;
	}
	/* function Editar(id) {
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
	$("#eTelefone1").val(ob.telefone1);
	$("#eTelefone2").val(ob.telefone2);
	$("#eCEP").val(ob.cep);
	$("#eBairro").val(ob.bairro);
	$("#eCidade").val(ob.cidade);
	$("#Complemento").val(ob.complemento);
	$("#eCnpj").val(ob.cnpj);
	$("#eEndereco").val(ob.endereco);
	$("#eWhatsapp").val(ob.whatsapp);
	$("#eEmail").val(ob.email);
	$("#eResponsavel").val(ob.responsavel);
	//$("#eUsuario").val(ob.usuario);
	$("#eUsuario").val(cnpj);
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
	};*/
	
	function Excluir(id){
	CarregaLoader();
	$("#ModalExcluir").modal("show");
	$("#IdExclude").val(id);
	}
	
	function GravarVendedor(){
	CarregaLoader();
	$("#eError1").text("");
	$("#eSucesso1").text("");
	var dataU = {};
	if ($("#eNomeVendedor").val() == null || $("#eNomeVendedor").val() == "")
	$("#eError1").text("É necessário preencher o campo de Nome");
	
	if ($("#eCpfVendedor").val() == null || $("#eCpfVendedor").val() == "")
	$("#eError1").text("É necessário preencher o campo de CPF");  
	if ($("#eRgVendedor").val() == null || $("#eRgVendedor").val() == "")
	$("#eError1").text("É necessário preencher o campo de RG");
	if ($("#eCepVendedor").val() == null || $("#eCepVendedor").val() == "")
	$("#eError1").text("É necessário preencher o campo de CEP");
	if ($("#eEnderecoVendedor").val() == null || $("#eEnderecoVendedor").val() == "")
	$("#eError1").text("É necessário preencher o campo de Logradouro");
	if ($("#eNumeroVendedor").val() == null || $("#eNumeroVendedor").val() == "")
	$("#eError1").text("É necessário preencher o campo de Número");
	if ($("#eBairroVendedor").val() == null || $("#eBairroVendedor").val() == "")
	$("#eError1").text("É necessário preencher o campo de Bairro");
	if ($("#eCidadeVendedor").val() == null || $("#eCidadeVendedor").val() == "")
	$("#eError1").text("É necessário preencher o campo de Cidade");
	
	if ($("#eDataAniversario").val() == null || $("#eDataAniversario").val() == "")
	$("#eError1").text("É necessário preencher o campo de Data de Aniversário");
	
	if ($("#eDataAdmissao").val() == null || $("#eDataAdmissao").val() == "")
	$("#eError1").text("É necessário preencher o campo de Data de Admissão");
	
	if ($("#eDataDemissao").val() != null || $("#eDataDemissao").val() != "")
	dataU.DataFundacao = $("#eDataDemissao").val();
	
	
	dataU.IdEmpresa =<?php echo $id; ?>;
	dataU.Id = $("#eIdVendedor").val();   
	dataU.NomeVendedor =  $("#eNomeVendedor").val();
	dataU.Cpf = $("#eCpfVendedor").val();
	dataU.Rg = $("#eRgVendedor").val();
	dataU.CEP = $("#eCepVendedor").val();
	dataU.Endereco = $("#eEnderecoVendedor").val();
	dataU.Numero = $("#eNumeroVendedor").val();
	dataU.Bairro = $("#eBairroVendedor").val();
	dataU.Complemento = $("#eComplementoVendedor").val();
	dataU.Cidade = $("#eCidadeVendedor").val();
	dataU.DataAniversario = $("#eDataAniversario").val();
	dataU.DataAdmissao = $("#eDataAdmissao").val();
	dataU.DataDemissao = $("#eDataDemissao").val();
	dataU.Estado = $("#eEstadoVendedor").children("option:selected").val();
	dataU.IsvendedorAtivo = $("#eIsvendedorAtivo").children("option:selected")[0].innerText;
	
	if($("#eError1")[0].innerText == null || $("#eError1")[0].innerText == ""){
	$.ajax({
	type: "POST",
	url: 'vendedoresInsert.php',
	data: dataU,
	success: function(html) {
	if (html.indexOf("sucesso") != -1) {
	$("#eSucesso1").text(html);
	TiraLoader();
	$("#ModalEdit").modal("hide");
	var href =  window.location.href;
	$("#FormLog").submit();
	
	window.location.href = href;
	} else {
	$("#eError1").text(html);
	
	}
	
	},
	error: function(xhr, ajaxOptions, thrownError) {
	TiraLoader();
	$("#eError1").text(thrownError);
	}
	
	});}
	return;
	}
	function Cancelar(){
	location.href= "http://localhost/ScoreSale/empresas.php";
	//history.back();
	/*window.opener.location.reload();    
	window.close();*/
	}
	function GravarEmpresa() {
	$("#eError").text("");
	$("#eSucesso").text("");
	var dataU = {};
	if ($("#eCEP").val() == null || $("#eCEP").val() == "")
	$("#eError").text("É necessário preencher o campo de CEP");
	
	if ($("#eNomeFantasia").val() == null || $("#eNomeFantasia").val() == "")
	$("#eError").text("É necessário preencher o campo de Nome Fantasia");
	
	if ($("#eNumero").val() == null || $("#eNumero").val() == "")
	$("#eError").text("É necessário preencher o campo de Numero do Endereço");
	
	if ($("#eBairro").val() == null || $("#eBairro").val() == "")
	$("#eError").text("É necessário preencher o campo de Bairro");
	
	if ($("#eCidade").val() == null || $("#eCidade").val() == "")
	$("#eError").text("É necessário preencher o campo de Cidade");
	
	if ($("#eBairro").val() == null || $("#eBairro").val() == "")
	$("#eError").text("É necessário preencher o campo de Bairro");
	
	if ($("#eNome").val() == null || $("#eNome").val() == "")
	$("#eError").text("É necessário preencher o campo de Razão Social");
	
	if ($("#eEmail").val() == null || $("#eEmail").val() == "")
	$("#eError").text("É necessário preencher o campo de Email");
	
	if ($("#eCnpj").val() == null || $("#eCnpj").val() == "")
	$("#eError").text("É necessário preencher o campo de CNPJ");
	
	if ($("#eInscricaoEstadual").val() == null || $("#eInscricaoEstadual").val() == "")
	$("#eError").text("É necessário preencher o campo de Inscrição Estadual");
	
	if ($("#eInscricaoMunicipal").val() == null || $("#eInscricaoMunicipal").val() == "")
	$("#eError").text("É necessário preencher o campo de Inscrição Municipal");
	
	if ($("#eEndereco").val() == null || $("#eEndereco").val() == "")
	$("#eError").text("É necessário preencher o campo de Logradouro");
	
	if ($("#eResponsavel").val() == null || $("#eResponsavel").val() == "")
	$("#eError").text("É necessário preencher o campo de Responsável");
	
	//if ($("#eWhatsapp").val() == null || $("#eWhatsapp").val() == "")
	//  $("#eError").text("É necessário preencher o campo de Whatsapp");
	
	if ($("#eDataFundacao").val() != null || $("#eDataFundacao").val() != "")
	dataU.DataFundacao = $("#eDataFundacao").val();
	dataU.NomeFantasia =  $("#eNomeFantasia").val();
	dataU.CEP = $("#eCEP").val();
	dataU.Numero = $("#eNumero").val();
	dataU.Bairro = $("#eBairro").val();
	dataU.Cidade = $("#eCidade").val();
	dataU.Complemento = $("#eComplemento").val();
	dataU.Telefone2 = $("#eTelefone2").val();
	dataU.NomeSocio1 = $("#eNomeSocio1").val();
	dataU.PercentualSocio1 = $("#ePercentualSocio1").val();
	dataU.Isadminsocio1 = $("#eIsadminsocio1").children("option:selected")[0].innerText;
	dataU.RamosEmpresa = $("#eRamosEmpresa").children("option:selected")[0].innerText;
	//dataU.Isadminsocio1 = $("#eIsadminsocio1").val();
	
	dataU.NomeSocio2 = $("#eNomeSocio2").val();
	dataU.PercentualSocio2 = $("#ePercentualSocio2").val();
	//dataU.Isadminsocio2 = $("#eIsadminsocio2").val();
	dataU.Isadminsocio2 = $("#eIsadminsocio2").children("option:selected")[0].innerText;
	
	dataU.NomeSocio3 = $("#eNomeSocio3").val();
	dataU.PercentualSocio3 = $("#ePercentualSocio3").val();
	//dataU.Isadminsocio3 = $("#eIsadminsocio3").val();
	dataU.Isadminsocio3 = $("#eIsadminsocio3").children("option:selected")[0].innerText;
	
	dataU.NomeSocio4 = $("#eNomeSocio4").val();
	dataU.PercentualSocio4 = $("#ePercentualSocio4").val();
	//dataU.Isadminsocio4 = $("#eIsadminsocio4").val();
	dataU.Isadminsocio4 = $("#eIsadminsocio4").children("option:selected")[0].innerText;
	
	dataU.NomeSocio5 = $("#eNomeSocio5").val();
	dataU.PercentualSocio5 = $("#ePercentualSocio5").val();
	//dataU.Isadminsocio5 = $("#eIsadminsocio5").val();
	dataU.Isadminsocio5 = $("#eIsadminsocio5").children("option:selected")[0].innerText;
	
	dataU.Observacao = $("#eObservacao").val();
	dataU.Id = $("#eId").val();
	dataU.Nome = $("#eNome").val();
	dataU.Email = $("#eEmail").val();
	//dataU.Usuario = $("#eUsuario").val();
	dataU.Usuario = $("#eCnpj").val();
	dataU.Telefone1 = $("#eTelefone1").val();
	dataU.InscricaoEstadual = $("#eInscricaoEstadual").val();
	dataU.InscricaoMunicipal = $("#eInscricaoMunicipal").val();
	dataU.CNPJ = $("#eCnpj").val();
	dataU.Endereco = $("#eEndereco").val();
	dataU.Responsavel = $("#eResponsavel").val();
	dataU.DataFundacao = $("#eDataFundacao").val();
	dataU.Whatsapp = $("#eWhatsapp").val();
	dataU.Permissao = 2;
	
	/*if(!ValidateEmail(dataU.Email)){
	$("#eError").text("Email inválido");
	return;
	}*/
	if($("#eError")[0].innerText == null || $("#eError")[0].innerText == ""){
	$.ajax({
	type: "POST",
	url: 'empresasInsert.php',
	data: dataU,
	success: function(html) {
	if (html.indexOf("sucesso") != -1) {
	CarregaLoader();
	$("#eSucesso").text(html);
	location.href= "http://localhost/ScoreSale/empresas.php";
	//history.back();
	
	
	/* window.opener.location.reload();    
	window.close();
	window.location.href = "http://linkteste.com.br/empresas.php";*/
	} else {
	CarregaLoader();
	$("#eError").text(html);
	TiraLoader();
	}
	
	},
	error: function(xhr, ajaxOptions, thrownError) {
	CarregaLoader();
	$("#eError").text(thrownError);
	TiraLoader();
	}
	
	});}
	TiraLoader();
	return;
	}
    
	
	/* GravarEmpresa().then(
	function(value){if($("#eError")[0].innerText == null || $("#eError")[0].innerText == "")
	alert("Teste");
	CarregaLoader();   
	});*/
	
	function AdicionarVendedor(){
	CarregaLoader();
	var id = <?php echo $id; ?>;
	$("#eIdVendedor").val(0);
	$("#eNomeVendedor").val("");
	$("#eCpfVendedor").val("");
	$("#eRgVendedor").val("");
	$("#eCepVendedor").val("");
	$("#eEnderecoVendedor").val("");
	$("#eNumeroVendedor").val("");
	$("#eBairroVendedor").val("");
	$("#eComplementoVendedor").val("");
	$("#eCidadeVendedor").val("");
	$("#eDataAniversario").val("");
	$("#eDataAdmissao").val("");
	$("#eDataDemissao").val("");
	$("#eIsvendedorAtivo").val(0);
	
	// $("#eEmail").val("");
	// $("#eSenha").val("");
	if(id == 0){
	alert("Não é possível Adicionar um vendedor!! É necessário que você crie ou acesse uma empresa já cadastrada.");
	TiraLoader();
	}
	else{
	$("#eError1").text("");
	$("#eSucesso").text("");
	$("#ModalEdit").modal("show");
	}
	
	}
	function ExcluirVendedor(){
	
	var dataU = {};
	dataU.Id = $("#IdExclude").val();
	
	$.ajax({
	type: "POST",
	url: 'vendedoresDelete.php',
	data: dataU,
	success: function(html) {
	if (html.indexOf("sucesso") != -1) {                  
	$("#ModalExcluir").modal("hide");
	var href =  window.location.href;
	$("#FormLog").submit();
	
	window.location.href = href;
	
	} else {
	$("#eError1").text(html);
	TiraLoader();
	}
	
	},
	error: function(xhr, ajaxOptions, thrownError) {
	$("#eError1").text(thrownError);
	TiraLoader();
	}
	
	});
	TiraLoader();
	return;
	}
	function ConsultaCEPVendedor(){
	
	if($("#eCepVendedor").val() != null)
	var CEP = $("#eCepVendedor").val().replace("-","");
	
	if(CEP.length == 8){
	var url = 'https://viacep.com.br/ws/'+ CEP +'/json/'
	//   alert(url);
	$.ajax({
	url: url,
	datatype: 'jsonp',
	crossdomain: true,
	contenType: "application/json",
	success: function(json) {
	$("#eBairroVendedor").val(json.bairro);
	$("#eCidadeVendedor").val(json.localidade);
	$("#eEnderecoVendedor").val(json.logradouro);
	$("#eEstadoVendedor").val(json.uf);
	},
	error: function(xhr, ajaxOptions, thrownError) {
	alert(thrownError);
	}
	
	});
	
	}
	}  
	function ConsultaCEP(){
	var CEP = $("#eCEP").val().replace("-","");
	//alert("TesteCEP");
	if(CEP.length == 8){
	var url = 'https://viacep.com.br/ws/'+ CEP +'/json/'
	//   alert(url);
	$.ajax({
	url: url,
	datatype: 'jsonp',
	crossdomain: true,
	contenType: "application/json",
	success: function(json) {
	$("#eBairro").val(json.bairro);
	$("#eCidade").val(json.localidade);
	$("#eEndereco").val(json.logradouro);
	},
	error: function(xhr, ajaxOptions, thrownError) {
	alert(thrownError);
	}
	
	});
	
	}
	}
	function ExcluirUsuario(){
	
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
	} else {
	TiraLoader();
	$("#eError").text(html);
	}
	
	},
	error: function(xhr, ajaxOptions, thrownError) {
	TiraLoader();
	$("#eError").text(thrownError);
	}
	
	});
	TiraLoader();
	return;
	}
	
	function ValidateEmail(mail) {
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
	return (true)
	}
	
	return (false)
	}
	function handleMask(event, mask) {
	with (event) {
	stopPropagation()
	preventDefault()
	if (!charCode) return
	var c = String.fromCharCode(charCode)
	if (c.match(/\D/)) return
	with (target) {
	var val = value.substring(0, selectionStart) + c + value.substr(selectionEnd)
	var pos = selectionStart + 1
	}
	}
	var nan = count(val, /\D/, pos) // nan va calcolato prima di eliminare i separatori
	val = val.replace(/\D/g,'')
	
	var mask = mask.match(/^(\D*)(.+9)(\D*)$/)
	if (!mask) return // meglio exception?
	if (val.length > count(mask[2], /9/)) return
	
	for (var txt='', im=0, iv=0; im<mask[2].length && iv<val.length; im+=1) {
	var c = mask[2].charAt(im)
	txt += c.match(/\D/) ? c : val.charAt(iv++)
	}
	
	with (event.target) {
	value = mask[1] + txt + mask[3]
	selectionStart = selectionEnd = pos + (pos==1 ? mask[1].length : count(value, /\D/, pos) - nan)
	}
	
	function count(str, c, e) {
	e = e || str.length
	for (var n=0, i=0; i<e; i+=1) if (str.charAt(i).match(c)) n+=1
	return n
	}
	}
	$("input[name='number']").focusout(function(){
	var number = this.value.replace(/(\d{2})(\d{3})(\d{2})/,"$1-$2-$3");
	this.value = number;
	})
	$("input[name='masknumber']").on("keyup change", function(){
	$("input[name='number']").val(destroyMask(this.value));
	this.value = createMask($("input[name='number']").val());
	})
	
	function createMask(string){
	return string.replace(/(\d{2})(\d{3})(\d{2})/,"$1-$2-$3");
	}
	
	function destroyMask(string){
	return string.replace(/\D/g,'').substring(0,8);}
	</script>
	<body>
	<?php include 'menu.php'; ?>
	<div class="container" style="padding-bottom:20px ">
	<div class="row">
	<div class="form-group-sm col-sm-12">
	<div class="collapse navbar-collapse" id="myNavbar">
	<ul class="nav navbar-nav" style="padding-bottom:10px ">
	<li>
	<a onclick='CarregaLoader();GravarEmpresa()' class="btn btn-link"><i class="fa fa-floppy-o" ></i>&nbsp;Gravar</a>
	</li>
	<li><a onclick='CarregaLoader();Cancelar()'class="btn btn-link"  ><i class="fa fa-times-circle-o" ></i>&nbsp;Voltar</a>
	</li>
	</ul>
	</div>
	</div>
	</div>
	<form id="FormLog" action="<?= $_SERVER["PHP_SELF"] ?>" method="POST">
	<div class="row">
	<div class="col-sm-12 form-group-sm">
	<div class="panel panel-default">
	<div class="panel-heading">
	<div class="panel-title">
	Dados da Empresa
	</div>
	</div>
	<div class="panel-body">
	<div class="row">
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Id</label>
	<input class="form-control" id="eId" name="eId" value="<?php echo $row["id_empresas"];?>" disabled />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">CNPJ</label>
	<input class="form-control" id="eCnpj" onkeypress="handleMask(event, '99.999.999/9999-99')" name="eCnpj"  value="<?php echo $row["cnpj"]; ?>" <?= ($row["cnpj"] != null) ? 'disabled' : '' ?>/>
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Razão Social</label>
	<input class="form-control" id="eNome" name="eNome"
	value="<?php echo $row["razao_social"];?>"/>
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Nome Fantasia</label>
	<input class="form-control" id="eNomeFantasia" name="eNomeFantasia"
	value="<?php echo $row["nome_fantasia"];?>"/>
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Inscrição Estadual</label>
	<input class="form-control" id="eInscricaoEstadual" onkeypress="handleMask(event, '999.999.999.999')" name="eInscricaoEstadual" value="<?php echo $row["inscricao_estadual"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Inscrição Municipal</label>
	<input class="form-control" id="eInscricaoMunicipal" name="eInscricaoMunicipal" value="<?php echo $row["inscricao_municipal"];?>"/>
	</div>
	<div class="col-sm-4 form-group form-group-sm">
	<label class="control-label">Data Fundação</label>
	<div class="input-group date form_datetime col-md-12" style="z-index:0;">
	<input class="form-control" size="16" name="eDataFundacao" id="eDataFundacao" type="text" value="<?php echo formata_data_exibicao($row["data_fundacao"]);?>"readonly>
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Observação</label>
	<textarea class="form-control" id="eObservacao" name="eObservacao" ><?php echo $row["obs"];?></textarea>
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Ramos da Empresa</label>
	<select class="form-control" name="eRamosEmpresa"  id="eRamosEmpresa" >
	<option value="0" <?= ($row["ramos_empresa"]=='Automação Som Imagem') ? 'selected' : '' ?>>Automação Som Imagem</option>
	<option value="1"<?= ($row["ramos_empresa"]=='Cobertura / Telhado') ? 'selected' : '' ?>>Cobertura / Telhado</option>
	<option value="2"<?= ($row["ramos_empresa"]=='Elétrica / Hidráulica') ? 'selected' : '' ?>>Elétrica / Hidráulica</option>
	<option value="3"<?= ($row["ramos_empresa"]=='Eletrodomésticos') ? 'selected' : '' ?>>Eletrodomésticos</option>
	<option value="4"<?= ($row["ramos_empresa"]=='Esquadrias / Batentes') ? 'selected' : '' ?>>Esquadrias / Batentes</option>
	<option value="5"<?= ($row["ramos_empresa"]=='Estratégico') ? 'selected' : '' ?>>Estratégico</option>
	<option value="6"<?= ($row["ramos_empresa"]=='Estrutura / Alvenaria') ? 'selected' : '' ?>>Estrutura / Alvenaria</option>
	<option value="7"<?= ($row["ramos_empresa"]=='Fundação / Alicerce') ? 'selected' : '' ?>>Fundação / Alicerce</option>
	<option value="8"<?= ($row["ramos_empresa"]=='Gestão de Obras') ? 'selected' : '' ?>>Gestão de Obras</option>
	<option value="9"<?= ($row["ramos_empresa"]=='Iluminação') ? 'selected' : '' ?>>Iluminação</option>
	<option value="10"<?= ($row["ramos_empresa"]=='Inauguração') ? 'selected' : '' ?>>Inauguração</option>
	<option value="11"<?= ($row["ramos_empresa"]=='Mármores') ? 'selected' : '' ?>>Mármores</option>
	<option value="12"<?= ($row["ramos_empresa"]=='Materiais Construção') ? 'selected' : '' ?>>Materiais Construção</option>
	<option value="13"<?= ($row["ramos_empresa"]=='Mobiliário') ? 'selected' : '' ?>>Mobiliário</option>
	<option value="14"<?= ($row["ramos_empresa"]=='Objetos / Decoração') ? 'selected' : '' ?>>Objetos / Decoração</option>
	<option value="15"<?= ($row["ramos_empresa"]=='Paisagismo') ? 'selected' : '' ?>>Paisagismo</option>
	<option value="16"<?= ($row["ramos_empresa"]=='Pintura / Acabamento') ? 'selected' : '' ?>>Pintura / Acabamento</option>
	<option value="17"<?= ($row["ramos_empresa"]=='Piscinas / Banheiras') ? 'selected' : '' ?>> Piscinas / Banheiras</option>
	<option value="18"<?= ($row["ramos_empresa"]=='Pisos / Revestimentos') ? 'selected' : '' ?>>Pisos / Revestimentos</option>
	<option value="19"<?= ($row["ramos_empresa"]=='Projeto / Implantação') ? 'selected' : '' ?>>Projeto / Implantação</option>
	<option value="20"<?= ($row["ramos_empresa"]=='Turismo') ? 'selected' : '' ?>>Turismo</option>
	<option value="21"<?= ($row["ramos_empresa"]=='Vidros') ? 'selected' : '' ?>>Vidros</option>
	</select>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	<div class="row">
	<div class="col-sm-12 form-group-sm">
	<div class="panel panel-default">
	<div class="panel-heading">
	<div class="panel-title">
	Endereço e Contato
	</div>
	</div>
	<div class="panel-body">
	<div class="row">
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">CEP</label>
	<input class="form-control" id="eCEP" name="eCEP" onkeypress="handleMask(event, '99999-999')" value="<?php echo $row["cep"];?>"/>
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Logradouro</label>
	<input class="form-control" id="eEndereco" name="eEndereco" value="<?php echo $row["endereco"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Número</label>
	<input class="form-control" id="eNumero" name="eNumero" value="<?php echo $row["numero"];?>"/>
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Bairro</label>
	<input class="form-control" id="eBairro" name="eBairro"value="<?php echo $row["bairro"];?>"/> 
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Complemento</label>
	<input class="form-control" id="eComplemento" name="eComplemento" value="<?php echo $row["complemento"];?>"/>
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Cidade</label>
	<input class="form-control" id="eCidade" name="eCidade" value="<?php echo $row["cidade"];?>"/>
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Email</label>
	<input type=email required class="form-control" id="eEmail" name="eEmail" value="<?php echo $row["email"];?>"/>
	</div>
	</div>
	<!-- <div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Usuário</label>
	<input class="form-control" id="eUsuario" name="eUsuario" value="<?// php echo $row["usuario"];?>" disabled />
	</div> -->
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
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">WhatsApp</label>
	<input class="form-control" id="eWhatsapp" name="eWhatsapp" onkeypress="handleMask(event, '(99)99999-9999')" value="<?php echo $row["whatsapp"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Telefone 1</label>
	<input class="form-control" id="eTelefone1" name="eTelefone1" onkeypress="handleMask(event, '(99)9999-9999')" value="<?php echo $row["telefone1"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Telefone 2</label>
	<input class="form-control" id="eTelefone2" name="eTelefone2" onkeypress="handleMask(event, '(99)9999-9999')" value="<?php echo $row["telefone2"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-6">
	<label class="control-label">Responsável</label>
	<input class="form-control" id="eResponsavel" name="eResponsavel" value="<?php echo $row["responsavel"];?>" />
	</div>
	</div>
	<!-- <div class="form-group form-group-sm col-sm-6">
	<label class="control-label">Observação</label>
	<input class="form-control" id="eObservacao" name="eObservacao" value="<?//php echo $row["obs"];?>" />
	</div> -->
	</div>
	</div>
	</div>
	</div>
	<div class="row">
	<div class="col-sm-12 form-group-sm">
	<div class="panel panel-default">
	<div class="panel-heading">
	<div class="panel-title">
	Sócios
	</div>
	</div>
	<div class="panel-body">
	<div class="row">
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Nome do Sócio 1</label>
	<input class="form-control" id="eNomeSocio1" name="eNomeSocio1" value="<?php echo $row["nome_socio1"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Percentual do Sócio 1</label>
	<input class="form-control" id="ePercentualSocio1" name="ePercentualSocio1" value="<?php echo $row["percentual_socio1"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Sócio 1 é Administrador?</label>
	<select class="form-control" name="eIsadminsocio1"  id="eIsadminsocio1" >
	<option value="0" <?= ($row["is_admin_socio1"]=='Sim') ? 'selected' : '' ?>>Sim</option>
	<option value="1"<?=($row["is_admin_socio1"]=='Não') ? 'selected' : '' ?>>Não</option>
	</select>
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Nome do Sócio 2</label>
	<input class="form-control" id="eNomeSocio2" name="eNomeSocio2" value="<?php echo $row["nome_socio2"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Percentual do Sócio 2</label>
	<input class="form-control" id="ePercentualSocio2" name="ePercentualSocio2" value="<?php echo $row["percentual_socio2"];?>" />
	</div>
	<!--<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Sócio 2 é Administrador?</label>
	<input class="form-control" id="eIsadminsocio2" name="eIsadminsocio2" value="<?//php echo $row["is_admin_socio2"];?>" />
	</div> -->
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Sócio 2 é Administrador?</label>
	<select class="form-control" name="eIsadminsocio2" id="eIsadminsocio2" >
	<option value="0" <?= ($row["is_admin_socio2"]=='Sim') ? 'selected' : '' ?>>Sim</option>
	<option value="1"<?=($row["is_admin_socio2"]=='Não') ? 'selected' : '' ?>>Não</option>
	</select>
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Nome do Sócio 3</label>
	<input class="form-control" id="eNomeSocio3" name="eNomeSocio3" value="<?php echo $row["nome_socio3"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Percentual do Sócio 3</label>
	<input class="form-control" id="ePercentualSocio3" name="ePercentualSocio3" value="<?php echo $row["percentual_socio3"];?>" />
	</div>
	<!-- <div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Sócio 3 é Administrador?</label>
	<input class="form-control" id="eIsadminsocio3" name="eIsadminsocio3" value="<?//php echo $row["is_admin_socio3"];?>" />
	</div> -->
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Sócio 3 é Administrador?</label>
	<select class="form-control" name="eIsadminsocio3" id="eIsadminsocio3" >
	<option value="0" <?= ($row["is_admin_socio3"]=='Sim') ? 'selected' : '' ?>>Sim</option>
	<option value="1"<?=($row["is_admin_socio3"]=='Não') ? 'selected' : '' ?>>Não</option>
	</select>
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Nome do Sócio 4</label>
	<input class="form-control" id="eNomeSocio4" name="eNomeSocio4" value="<?php echo $row["nome_socio4"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Percentual do Sócio 4</label>
	<input class="form-control" id="ePercentualSocio4" name="ePercentualSocio4"value="<?php echo $row["percentual_socio4"];?>" />
	</div>
	<!-- <div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Sócio 4 é Administrador?</label>
	<input class="form-control" id="eIsadminsocio4" name="eIsadminsocio4" value="<?//php echo $row["is_admin_socio4"];?>" />
	</div> -->
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Sócio 4 é Administrador?</label>
	<select class="form-control" name="eIsadminsocio4" id="eIsadminsocio4" >
	<option value="0" <?= ($row["is_admin_socio4"]=='Sim') ? 'selected' : '' ?>>Sim</option>
	<option value="1"<?=($row["is_admin_socio4"]=='Não') ? 'selected' : '' ?>>Não</option>
	</select>
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Nome do Sócio 5</label>
	<input class="form-control" id="eNomeSocio5" name="eNomeSocio5" value="<?php echo $row["nome_socio5"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Percentual do Sócio 5</label>
	<input class="form-control" id="ePercentualSocio5" name="ePercentualSocio5" value="<?php echo $row["percentual_socio5"];?>" />
	</div>
	<!-- <div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Sócio 5 é Administrador?</label>
	<input class="form-control" id="eIsadminsocio5" name="eIsadminsocio5" value="<?//php echo $row["is_admin_socio5"];?>" /> 
	</div> -->
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Sócio 5 é Administrador?</label>
	<select class="form-control" name="eIsadminsocio5" id="eIsadminsocio5" >
	<option value="0" <?= ($row["is_admin_socio5"]=='Sim') ? 'selected' : '' ?>>Sim</option>
	<option value="1"<?=($row["is_admin_socio5"]=='Não') ? 'selected' : '' ?>>Não</option>
	</select>
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-12">
	<span id="eError" name="eError" style="color:firebrick"></span>
	<span id="eSucesso" name="eSucesso" style="color:green"></span>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	<div class="row">
	<div class="col-sm-12 form-group-sm">
	<div class="panel panel-default">
	<div class="panel-heading">
	<div class="panel-title">
	Dados de Vendedores
	</div> 
	</div>
	<div class="panel-body">
	<div class="row">
	<div class="col-sm-4 form-group form-group-sm">
	<label class="control-label">Nome</label>
	<input class="form-control" name="eNomePesquisa" id="eNomePesquisa"></input>
	</div>
	<div class="col-sm-2 form-group form-group-sm">
	<label class="control-label">Ordem</label>
	<select class="form-control" name="eOrdemVendedor" id="eOrdemVendedor">
	<option value="0" <?= ($Ordem == '0') ? 'selected' : '' ?>>Crescente</option>
	<option value="1" <?= ($Ordem == '1') ? 'selected' : '' ?>>Decrescente</option>
	</select>
	</div>
	<div class="col-sm-4 form-group form-group-sm"></div>
	<div class="col-sm-2 form-group form-group-sm text-right">
	<label class="control-label">&nbsp;&nbsp; </label>
	<a class="form-control botoes btn btn-primary" onclick="SubmeterForm();">Pesquisar</a>
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-12">
	<a class="btn btn-primary" onclick="AdicionarVendedor()" title="Adicionar Vendedor">Adicionar Vendedor</span></a>
	</div>
	</div>
	<div class="row">
	<div class="col-sm-12 form-group-sm">
	<table class="table table-condensed table-striped" id="eTabelaVendedor" name="eTabelaVendedor">
	<thead>
	<tr>
	<th>Id</th>
	<th>Nome</th>
	<th>Data de Admissão</th>
	<th>Data de Demissão</th>
	<th>Vendedor está ativo?</th>
	<th></th>
	</tr>
	</thead>
	<tbody>
	<?php
	if ($result->num_rows > 0) {
	for ($i = 0; $i < $result->num_rows; $i++) {
	$row1 = $result->fetch_assoc();
	echo "<tr>
	<td nowrap>" . $row1["id_vendedores"] . "</td>
	<td nowrap>" . ($row1["nome"]) . "</td>
	<td nowrap>" . ($row1["data_aniversario"]) ."</td>
	<td nowrap>" . ($row1["data_admissao"]) . "</td>
	<td nowrap>" . ($row1["is_vendedor_ativo"]) . "</td>
	
	
	
	
	<td class='text-right' nowrap>
	<a class='btn btn-primary btn-sm' title='Editar Vendedor' onclick='EditarVendedor(" . $row1["id_vendedores"] .")'><span class='glyphicon glyphicon glyphicon-edit'></span></a>
	<a class='btn btn-danger btn-sm' title='Excluir Vendedor' onclick='Excluir(". $row1["id_vendedores"].")'><span class='glyphicon glyphicon glyphicon-trash'></span></a>
	</td>
	</tr>";
	}
	}
	?>
	</tbody>
	</table>
	<div class="row">&nbsp;</div>
	<div class="row">&nbsp;</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	<div class="row">&nbsp;</div>
	</form>
	</div>
	<div id="ModalEdit" class="modal fade" role="dialog">
	<div class="modal-dialog ">
	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header" style="background-color: #00091a; color:white; border-radius:5px 5px 0px 0px;">
	<button type="button" class="close" onclick="TiraLoader()" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Edição de Vendedor</h4>
	</div>
	<div class="modal-body">
	<div class="row">
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Id</label>
	<input class="form-control" id="eIdVendedor" name="eIdVendedor" value="<?php echo $row1["id_vendedores"];?>" disabled/>
	</div>
	<div class="form-group form-group-sm col-sm-10">
	<label class="control-label">Nome</label>
	<input class="form-control" id="eNomeVendedor" name="eNomeVendedor" value="<?php echo $row1["nome"];?>" />
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">CPF</label>
	<input class="form-control" id="eCpfVendedor" name="eCpfVendedor" onkeypress="handleMask(event, '999.999.999-99')" value="<?php echo $row1["cpf"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">RG</label>
	<input class="form-control" id="eRgVendedor" name="eRgVendedor" onkeypress="handleMask(event, '99.999.999-9')" value="<?php echo $row1["rg"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Vendedor Está Ativo?</label>
	<select class="form-control" name="eIsvendedorAtivo" id="eIsvendedorAtivo" >
	<option value="0" <?= ($row1["is_vendedor_ativo"]=='Sim') ? 'selected' : '' ?>>Sim</option>
	<option value="1"<?=($row1["is_vendedor_ativo"]=='Não') ? 'selected' : '' ?>>Não</option>
	</select>
	</div>
	</div>
	<div class="row">
	<div class="col-sm-6 form-group form-group-sm">
	<label class="control-label">Aniversário</label>
	<div class="input-group date form_datetime col-md-12" style="z-index:0;">
	<input class="form-control" size="16" name="eDataAniversario" id="eDataAniversario" type="text" value="<?php echo formata_data_exibicao($row1["data_aniversario"]);?>"readonly>
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
	</div>
	<div class="col-sm-6 form-group form-group-sm">
	<label class="control-label">Data de Admissão</label>
	<div class="input-group date form_datetime col-md-12" style="z-index:0;">
	<input class="form-control" size="16" name="eDataAdmissao" id="eDataAdmissao" type="text" value="<?php echo formata_data_exibicao($row1["data_admissao"]);?>"readonly>
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
	</div>
	</div>
	<div class="row">
	<div class="col-sm-6 form-group form-group-sm">
	<label class="control-label">Data Demissão</label>
	<div class="input-group date form_datetime col-md-12" style="z-index:0;">
	<input class="form-control" size="16" name="eDataDemissao" id="eDataDemissao" type="text" value="<?php echo formata_data_exibicao($row1["data_demissao"]);?>"readonly>
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
	</div>
	<div class="form-group form-group-sm col-sm-6">
	<label class="control-label">CEP</label>
	<input class="form-control" id="eCepVendedor" name="eCepVendedor" onkeypress="handleMask(event, '99999-999')" value="<?php echo $row1["cep"];?>" />
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-12">
	<label class="control-label">Logradouro</label>
	<input class="form-control" id="eEnderecoVendedor" name="eEnderecoVendedor" value="<?php echo $row1["endereco"];?>" />
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Número</label>
	<input class="form-control" id="eNumeroVendedor" name="eNumeroVendedor" value="<?php echo $row1["numero"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-5">
	<label class="control-label">Complemento</label>
	<input class="form-control" id="eComplementoVendedor" name="eComplementoVendedor" value="<?php echo $row1["complemento"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-5">
	<label class="control-label">Bairro</label>
	<input class="form-control" id="eBairroVendedor" name="eBairroVendedor" value="<?php echo $row1["bairro"];?>" />
	</div>
	</div>
	<div class ="row">
	<div class="form-group form-group-sm col-sm-6">
	<label class="control-label">Cidade</label>
	<input class="form-control" id="eCidadeVendedor" name="eCidadeVendedor" value="<?php echo $row1["cidade"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-6">
	<label class="control-label">Estado</label>
	<select class="form-control" id="eEstadoVendedor" name="eEstadoVendedor">
	<option value="AC">Acre</option>
	<option value="AL">Alagoas</option>
	<option value="AP">Amapá</option>
	<option value="AM">Amazonas</option>
	<option value="BA">Bahia</option>
	<option value="CE">Ceará</option>
	<option value="DF">Distrito Federal</option>
	<option value="ES">Espírito Santo</option>
	<option value="GO">Goiás</option>
	<option value="MA">Maranhão</option>
	<option value="MT">Mato Grosso</option>
	<option value="MS">Mato Grosso do Sul</option>
	<option value="MG">Minas Gerais</option>
	<option value="PA">Pará</option>
	<option value="PB">Paraíba</option>
	<option value="PR">Paraná</option>
	<option value="PE">Pernambuco</option>
	<option value="PI">Piauí</option>
	<option value="RJ">Rio de Janeiro</option>
	<option value="RN">Rio Grande do Norte</option>
	<option value="RS">Rio Grande do Sul</option>
	<option value="RO">Rondônia</option>
	<option value="RR">Roraima</option>
	<option value="SC">Santa Catarina</option>
	<option value="SP">São Paulo</option>
	<option value="SE">Sergipe</option>
	<option value="TO">Tocantins</option>
	</select>
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-12">
	<span id="eError1" name="eError1" style="color:firebrick"></span>
	<span id="eSucesso1" name="eSucesso1" style="color:green"></span>
	</div>
	</div>
	</div>
	</div>
	<div class="modal-footer" style="background-color: #00091a; border-radius:0px 0px 5px 5px;">
	<button type="button" class="btn btn-success" onclick="GravarVendedor()">Gravar</button>
	<button type="button" class="btn btn-danger" onclick="TiraLoader()" data-dismiss="modal">Cancelar</button>
	</div>
	</div>
	</div>
	</div>
	<div id="ModalExcluir" class="modal fade" role="dialog">
	<div class="modal-dialog ">
	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header" style="background-color: #00091a; color:white; border-radius:5px 5px 0px 0px;">
	<button type="button" class="close" onclick="TiraLoader();" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Atenção</h4>
	</div>
	<div class="modal-body">
	<div class="row">
	<div class="form-group form-group-sm col-sm-12">
	<input name="IdExclude" id="IdExclude" style="display:none"/>
	<h4>Deseja realmente excluir?</h4>
	</div>
	</div>
	</div>
	<div class="modal-footer" style="background-color: #00091a; border-radius:0px 0px 5px 5px;">
	<button type="button" class="btn btn-success btn" onclick="ExcluirVendedor()">Excluir</button>
	<button type="button" class="btn btn-danger" onclick="TiraLoader()" data-dismiss="modal">Cancelar</button>
	</div>
	</div>
	</div>
	</div>
	<footer class="container-fluid text-center" style="background-color:#091742 z-index:1; position: fixed;bottom: 0px!important;width: 100vw;">
	<div class="row">
	<div class="col-sm-6 text-left"><img src="./imagens/Logo-teste-Login.png" style="height:3vh;margin:10px"/></div>
	<!-- <div class="col-sm-6 text-right"><a href=""><img src="./imagens/logo-branca.png" style="height:3vh;margin:10px"/></a></div> -->
	</div>
	</div>
	</footer>
	</body>
	<!-- </html> -->	