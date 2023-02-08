<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	
	$TituloPage = "Cadastro de Parceiros";
	date_default_timezone_set('america/sao_paulo');
	
	try {
		if (isset($_GET["id"])){
			$id = $_GET["id"];
		}
		
		/// Consulta empresas  ////
		$sql = "SELECT * FROM parceiros";
		if ($id != "" && $id != null){
			$sql = $sql . " WHERE id_parceiros='" . $id . "'";
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
			$row["id_parceiros"] = 0;           
		}       
		
		$sql = "SELECT * FROM parceiros WHERE id_parceiros='" . $id . "'";
		
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
	MostrarPessoa();
	$("#eCEP").bind('blur', function(e){
	ConsultaCEP(); 
	});
	$("#eCEPEmpresa").bind('blur', function(e){
	ConsultaCEP(); 
	});
	// Number
	});
	
	function SubmeterForm() {
	CarregaLoader();
	$("#FormLog").submit();
	};
	
	function Excluir(id){
	$("#ModalExcluir").modal("show");
	$("#IdExclude").val(id);
	}
	
	
	function Cancelar(){
	location.href= "http://localhost/ScoreSale/parceiros.php";
	// history.back();
	}
	
	function MostrarPessoa(){
	if($("#eTipopessoa").children("option:selected")[0].innerText == "Pessoa Jurídica"){
	document.getElementById("eInscricaoMunicipal").style.display = "block";
	document.getElementById("eCnpj").style.display = "block";
	document.getElementById("eRazaoSocial").style.display = "block";
	//document.getElementById("eDataFundacao").style.display = "block";
	document.getElementById("eeDataFundacao").style.display = "block";
	document.getElementById("elInscricaoMunicipal").style.display = "block";
	document.getElementById("elCnpj").style.display = "block";
	document.getElementById("elRazaoSocial").style.display = "block";
	document.getElementById("elDataFundacao").style.display = "block";
	
	document.getElementById("eCEPEmpresa").style.display = "block";
	document.getElementById("eEnderecoEmpresa").style.display = "block";
	document.getElementById("eNumeroEmpresa").style.display = "block";
	document.getElementById("eBairroEmpresa").style.display = "block";
	document.getElementById("eComplementoEmpresa").style.display = "block";
	document.getElementById("eCidadeEmpresa").style.display = "block";
	document.getElementById("eUfEmpresa").style.display = "block";
	
	document.getElementById("eCEP").style.display = "none";
	document.getElementById("eEndereco").style.display = "none";
	document.getElementById("eNumero").style.display = "none";
	document.getElementById("eBairro").style.display = "none";
	document.getElementById("eComplemento").style.display = "none";
	document.getElementById("eCidade").style.display = "none";
	document.getElementById("eUf").style.display = "none";
	
	
	document.getElementById("eRg").style.display = "none";
	document.getElementById("eCpf").style.display = "none";
	document.getElementById("eNome").style.display = "none";
	document.getElementById("eDataAniversario").style.display = "block";
	document.getElementById("eeDataAniversario").style.display = "none";
	document.getElementById("elRg").style.display = "none";
	document.getElementById("elCpf").style.display = "none";
	document.getElementById("elNome").style.display = "none";
	document.getElementById("elDataAniversario").style.display = "none";
	
	}
	else{
	document.getElementById("eInscricaoMunicipal").style.display = "none";
	document.getElementById("eCnpj").style.display = "none";
	document.getElementById("eRazaoSocial").style.display = "none";
	//document.getElementById("eDataFundacao").style.display = "none";	
	document.getElementById("eeDataFundacao").style.display = "none";			
	document.getElementById("elInscricaoMunicipal").style.display = "none";
	document.getElementById("elCnpj").style.display = "none";
	document.getElementById("elRazaoSocial").style.display = "none";
	document.getElementById("elDataFundacao").style.display = "none";
	
	document.getElementById("eCEPEmpresa").style.display = "none";
	document.getElementById("eEnderecoEmpresa").style.display = "none";
	document.getElementById("eNumeroEmpresa").style.display = "none";
	document.getElementById("eBairroEmpresa").style.display = "none";
	document.getElementById("eComplementoEmpresa").style.display = "none";
	document.getElementById("eCidadeEmpresa").style.display = "none";
	document.getElementById("eUfEmpresa").style.display = "none";
	
	document.getElementById("eCEP").style.display = "block";
	document.getElementById("eEndereco").style.display = "block";
	document.getElementById("eNumero").style.display = "block";
	document.getElementById("eBairro").style.display = "block";
	document.getElementById("eComplemento").style.display = "block";
	document.getElementById("eCidade").style.display = "block";
	document.getElementById("eUf").style.display = "block";
	
	document.getElementById("eRg").style.display = "block";
	document.getElementById("eCpf").style.display = "block";
	document.getElementById("eNome").style.display = "block";
	//document.getElementById("eDataAniversario").style.display = "block";
	document.getElementById("eeDataAniversario").style.display = "block";
	document.getElementById("elRg").style.display = "block";
	document.getElementById("elCpf").style.display = "block";
	document.getElementById("elNome").style.display = "block";
	document.getElementById("elDataAniversario").style.display = "block";
	}
	}
	
	
	function ConsultaCEP(){
	
	if($("#eTipopessoa").children("option:selected")[0].innerText == "Pessoa Física")
	var CEP = $("#eCEP").val().replace("-","");
	
	else if($("#eTipopessoa").children("option:selected")[0].innerText == "Pessoa Jurídica")
	var CEP = $("#eCEPEmpresa").val().replace("-","");
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
	if($("#eTipopessoa").children("option:selected")[0].innerText == "Pessoa Física"){
	var Bairro = $("#eBairro").val(json.bairro);
	var Cidade = $("#eCidade").val(json.localidade);
	var uf = $("#eUf").val(json.uf);
	var Endereco = $("#eEndereco").val(json.logradouro);				
	}
	else if($("#eTipopessoa").children("option:selected")[0].innerText == "Pessoa Jurídica"){
	var Bairro = $("#eBairroEmpresa").val(json.bairro);
	var Cidade = $("#eCidadeEmpresa").val(json.localidade);
	var UfEmpresa = $("#eUfEmpresa").val(json.uf);
	var Endereco = $("#eEnderecoEmpresa").val(json.logradouro);		
	}
	},
	error: function(xhr, ajaxOptions, thrownError) {
	alert(thrownError);
	}
	
	});
	
	}
	}
	function GravarParceiro() {
	
	$("#eError").text("");
	$("#eSucesso").text("");
	var dataU = {};
	
	if ($("#eTelefone").val() == null || $("#eTelefone").val() == "")
	$("#eError").text("É necessário preencher o campo de Telefone");
	
	if ($("#eEmail").val() == null || $("#eEmail").val() == "")
	$("#eError").text("É necessário preencher o campo de Email");
	
	if($("#eTipopessoa").children("option:selected")[0].innerText == "Pessoa Jurídica"){
	if ($("#eCnpj").val() == null || $("#eCnpj").val() == "")
	$("#eError").text("É necessário preencher o campo de CNPJ");
	
	if ($("#eRazaoSocial").val() == null || $("#eRazaoSocial").val() == "")
	$("#eError").text("É necessário preencher o campo de Razão Social em Pessoa Jurídica");
	
	if ($("#eCEPEmpresa").val() == null || $("#eCEPEmpresa").val() == "")
	$("#eError").text("É necessário preencher o campo de CEP");
	
	if ($("#eCidadeEmpresa").val() == null || $("#eCidadeEmpresa").val() == "")
	$("#eError").text("É necessário preencher o campo de Cidade em Pessoa Jurídica");
	
	if ($("#eUfEmpresa").val() == null || $("#eUfEmpresa").val() == "")
	$("#eError").text("É necessário preencher o campo de UF em Pessoa Jurídica");
	
	if ($("#eEnderecoEmpresa").val() == null || $("#eEnderecoEmpresa").val() == "")
	$("#eError").text("É necessário preencher o campo de Endereço em Pessoa Jurídica");
	
	if ($("#eNumeroEmpresa").val() == null || $("#eNumeroEmpresa").val() == "")
	$("#eError").text("É necessário preencher o campo de Número em Pessoa Jurídica");
	
	if ($("#eBairroEmpresa").val() == null || $("#eBairroEmpresa").val() == "")
	$("#eError").text("É necessário preencher o campo de Bairro em Pessoa Jurídica");
	
	if ($("#eInscricaoMunicipal").val() == null || $("#eInscricaoMunicipal").val() == "")
	$("#eError").text("É necessário preencher o campo de Inscrição Municipal em Pessoa Jurídica");
	
	if ($("#eDataFundacao").val() != null || $("#eDataFundacao").val() != ""){
	dataU.DataFundacao = $("#eDataFundacao").val();
	dataU.DataAniversario = $("#eDataFundacao").val();
	}
	
	dataU.CNPJ = $("#eCnpj").val();
	dataU.InscricaoMunicipal = $("#eInscricaoMunicipal").val();
	dataU.CPF =  $("#eCnpj").val();
	dataU.RG = $("#eInscricaoMunicipal").val();
	
	dataU.ComplementoEmpresa = $("#eComplementoEmpresa").val();
	dataU.RazaoSocial = $("#eRazaoSocial").val();
	dataU.Nome = $("#eRazaoSocial").val();
	dataU.CEPEmpresa = $("#eCEPEmpresa").val();
	dataU.EnderecoEmpresa = $("#eEnderecoEmpresa").val();
	dataU.CidadeEmpresa = $("#eCidadeEmpresa").val();
	dataU.UfEmpresa = $("#eUfEmpresa").val();
	dataU.NumeroEmpresa = $("#eNumeroEmpresa").val();
	dataU.BairroEmpresa = $("#eBairroEmpresa").val();
	
	dataU.Usuario = $("#eCnpj").val();
	
	
	}
	else   if($("#eTipopessoa").children("option:selected")[0].innerText == "Pessoa Física"){
	
	if ($("#eCidade").val() == null || $("#eCidade").val() == "")
	$("#eError").text("É necessário preencher o campo de Cidade");
	
	if ($("#eUf").val() == null || $("#eUf").val() == "")
	$("#eError").text("É necessário preencher o campo de UF");
	
	if ($("#eCEP").val() == null || $("#eCEP").val() == "")
	$("#eError").text("É necessário preencher o campo de CEP");
	
	if ($("#eEndereco").val() == null || $("#eEndereco").val() == "")
	$("#eError").text("É necessário preencher o campo de Logradouro");
	
	if ($("#eNumero").val() == null || $("#eNumero").val() == "")
	$("#eError").text("É necessário preencher o campo de Número");
	
	if ($("#eBairro").val() == null || $("#eBairro").val() == "")
	$("#eError").text("É necessário preencher o campo de Bairro");
	
	if ($("#eCpf").val() == null || $("#eCpf").val() == "")
	$("#eError").text("É necessário preencher o campo de CPF");
	
	if ($("#eRg").val() == null || $("#eRg").val() == "")
	$("#eError").text("É necessário preencher o campo de RG");
	
	if ($("#eNome").val() == null || $("#eNome").val() == "")
	$("#eError").text("É necessário preencher o campo de Nome");
	
	if ($("#eDataAniversario").val() != null || $("#eDataAniversario").val() != "")
	dataU.DataAniversario = $("#eDataAniversario").val();
	
	dataU.CEP = $("#eCEP").val();
	dataU.Endereco = $("#eEndereco").val();
	dataU.Numero = $("#eNumero").val();
	dataU.Bairro = $("#eBairro").val();
	dataU.Cidade = $("#eCidade").val();
	dataU.CPF = $("#eCpf").val();
	dataU.RG = $("#eRg").val();
	dataU.Nome = $("#eNome").val();
	dataU.UF  = $("#eUf").children("option:selected")[0].innerText;
	dataU.Complemento = $("#eComplemento").val();
	
	dataU.Usuario = $("#eCpf").val();
	}
	
	dataU.CAU = $("#eCAU").val();
	if ($("#eTipopessoa").val() == null || $("#eTipopessoa").val() == "")
	$("#eError").text("É necessário preencher o campo de Tipo de Pessoa");
	
	if ($("#eTipoProfissao").val() == null || $("#eTipoProfissao").val() == "")
	$("#eError").text("É necessário preencher o campo de Tipo de profissão");
	
	
	
	
	dataU.Permissao = 3;
	dataU.Id = $("#eId").val();
	dataU.Telefone = $("#eTelefone").val();
	dataU.Email = $("#eEmail").val();
	dataU.TipoPessoa  = $("#eTipopessoa").children("option:selected")[0].innerText;
	dataU.TipoProfissao  = $("#eTipoProfissao").children("option:selected")[0].innerText;
	
	dataU.NomeSocio1 = $("#eNomeSocio1").val();
	dataU.CpfSocio1 = $("#eCpfSocio1").val();
	dataU.RgSocio1 = $("eRgSocio1").val();
	dataU.EmailSocio1 = $("eEmailSocio1").val();
	dataU.DataAniversarioSocio1 = $("eDataAniversarioSocio1").val();
	dataU.TelefoneSocio1 = $("eTelefoneSocio1").val();
	dataU.PercentualSocio1 = $("#ePercentualSocio1").val();
	dataU.Isadminsocio1 = $("#eIsadminsocio1").children("option:selected")[0].innerText;
	
	dataU.NomeSocio2 = $("#eNomeSocio2").val();
	dataU.CpfSocio2 = $("#eCpfSocio2").val();
	dataU.RgSocio2 = $("eRgSocio2").val();
	dataU.EmailSocio2 = $("eEmailSocio2").val();
	dataU.DataAniversarioSocio2 = $("eDataAniversarioSocio2").val();
	dataU.TelefoneSocio2 = $("eTelefoneSocio2").val();
	dataU.PercentualSocio2 = $("#ePercentualSocio2").val();
	dataU.Isadminsocio2 = $("#eIsadminsocio2").children("option:selected")[0].innerText;
	
	dataU.NomeSocio3 = $("#eNomeSocio3").val();
	dataU.CpfSocio3 = $("#eCpfSocio3").val();
	dataU.RgSocio3 = $("eRgSocio3").val();
	dataU.EmailSocio3 = $("eEmailSocio3").val();
	dataU.DataAniversarioSocio3 = $("eDataAniversarioSocio3").val();
	dataU.TelefoneSocio3 = $("eTelefoneSocio3").val();
	dataU.PercentualSocio3 = $("#ePercentualSocio3").val();
	dataU.Isadminsocio3 = $("#eIsadminsocio3").children("option:selected")[0].innerText;
	
	dataU.NomeSocio4 = $("#eNomeSocio4").val();
	dataU.CpfSocio4 = $("#eCpfSocio4").val();
	dataU.RgSocio4 = $("eRgSocio4").val();
	dataU.EmailSocio4 = $("eEmailSocio4").val();
	dataU.DataAniversarioSocio4 = $("eDataAniversarioSocio4").val();
	dataU.TelefoneSocio4 = $("eTelefoneSocio4").val();
	dataU.PercentualSocio4 = $("#ePercentualSocio4").val();
	dataU.Isadminsocio4 = $("#eIsadminsocio4").children("option:selected")[0].innerText;
	
	dataU.NomeSocio5 = $("#eNomeSocio5").val();
	dataU.CpfSocio5 = $("#eCpfSocio5").val();
	dataU.RgSocio5 = $("eRgSocio5").val();
	dataU.EmailSocio5 = $("eEmailSocio5").val();
	dataU.DataAniversarioSocio5 = $("eDataAniversarioSocio5").val();
	dataU.TelefoneSocio5 = $("eTelefoneSocio5").val();
	dataU.PercentualSocio5 = $("#ePercentualSocio5").val();
	dataU.Isadminsocio5 = $("#eIsadminsocio5").children("option:selected")[0].innerText;
	
	/*if(!ValidateEmail(dataU.Email)){
	$("#eError").text("Email inválido");
	return;
	}*/
	
	if($("#eError")[0].innerText == null || $("#eError")[0].innerText == ""){
	$.ajax({
	type: "POST",
	url: 'parceirosInsert.php',
	data: dataU,
	success: function(html) {
	if (html.indexOf("sucesso") != -1) {
	$("#eSucesso").text(html);
	CarregaLoader();
	location.href= "http://localhost/ScoreSale/parceiros.php";
	//history.back();
	//$("#FormLog").submit();
	
	/*window.opener.location.reload();    
	window.close();*/
	//window.location.href = "http://linkteste.com.br/empresas.php";
	} else {
	CarregaLoader();
	$("#eError").text("---" + html);
	TiraLoader();
	}
	
	},
	error: function(xhr, ajaxOptions, thrownError) {
	CarregaLoader();
	console.log(xhr)
	console.log(ajaxOptions)
	console.log(thrownError)
	$("#eError").text("***" + thrownError);
	TiraLoader();
	}
	
	});}
	TiraLoader();
	return;
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
	var href =  window.location.href;
	$("#FormLog").submit();
	
	window.location.href = href;
	} else {
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
	
	var nan = count(val, /\D/, pos) 
	val = val.replace(/\D/g,'')
	
	var mask = mask.match(/^(\D*)(.+9)(\D*)$/)
	if (!mask) return
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
	<div class="form-group-sm col-sm-5 col-xs-7">
	<div class="collapse navbar-collapse" id="myNavbar">
	<ul class="nav navbar-nav" style="padding-bottom:10px">
	<li>
	<a onclick='CarregaLoader();GravarParceiro()' class="btn btn-link"><i class="fa fa-floppy-o" ></i>&nbsp;Gravar</a>
	</li>
	<li><a onclick='CarregaLoader();Cancelar()'class="btn btn-link"  ><i class="fa fa-times-circle-o" ></i>&nbsp;Voltar</a>
	</li>
	</ul>
	</div>
	</div>
	
	<div class="form-group form-group-sm text-right col-sm-8">
	<span id="eError" name="eError" style="color:firebrick"></span>
	<span id="eSucesso" name="eSucesso" style="color:green"></span>
	</div>                      		
	
	</div>
	<form id="FormLog" action="<?= $_SERVER["PHP_SELF"] ?>" method="POST">
	<div class="row">
	<div class="col-sm-12 form-group-sm">
	<div class="panel panel-default">
	<div class="panel-heading">
	<div class="panel-title">
	Dados do Parceiro
	</div>
	</div>
	<div class="panel-body">
	<div class="row">
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Id</label>
	<input class="form-control" id="eId" name="eId" value="<?php echo $row["id_parceiros"];?>" disabled />
	</div>
	
	<div class="form-group form-group-sm col-sm-3">
	<label class="control-label" id="elRg">RG</label>
	<input class="form-control" id="eRg" onkeypress="handleMask(event, '99.999.999-9')" name="eRg"
	value="<?php echo $row["rg"];?>"/>
	
	<label class="control-label" id="elInscricaoMunicipal">Inscrição Municipal</label>
	<input class="form-control" onkeypress="handleMask(event, '9999999')" id="eInscricaoMunicipal" name="eInscricaoMunicipal"value="<?php echo $row["inscricao_municipal"];?>"/> 
	</div>
	<div class="form-group form-group-sm col-sm-3">
	<label class="control-label" id="elCpf">CPF</label>
	<input class="form-control" id="eCpf" onkeypress="handleMask(event, '999.999.999-99')" name="eCpf" value="<?php echo $row["cpf"]; ?>" <?= ($row["cpf"] != null) ? 'disabled' : '' ?>/>
	
	<label class="control-label" id="elCnpj">CNPJ</label>
	<input class="form-control" id="eCnpj" onkeypress="handleMask(event, '99.999.999/9999-99')" name="eCnpj"value="<?php echo $row["cnpj"];?>"/>
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label"  id="elNome">Nome</label>
	<input class="form-control" id="eNome" name="eNome" value="<?php echo $row["nome"];?>"/>
	
	<label class="control-label"  id="elRazaoSocial">Razao Social</label>
	<input class="form-control" id="eRazaoSocial" name="eRazaoSocial"value="<?php echo $row["razao_social"];?>"/>
	</div>
	</div>
	<div class="row">                           
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label" id="elTelefone">Telefone</label>
	<input class="form-control" onkeypress="handleMask(event, '99 99999-9999')" id="eTelefone" name="eTelefone" 
	value="<?php echo $row["telefone"];?>"/>
	</div>
	<div class="form-group form-group-sm col-sm-8">
	<label class="control-label" id="elEmail">Email</label>
	<input class="form-control" id="eEmail" name="eEmail"
	value="<?php echo $row["email"];?>"/> 							
	</div>                           
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label"  id="elTipopessoa">Tipo de Pessoa</label>
	<select class="form-control" name="eTipopessoa"  id="eTipopessoa" onChange="MostrarPessoa();">
	<option value="0" <?= ($row["id_tipo_pessoa"]=='Pessoa Física') ? 'selected' : '' ?>>Pessoa Física</option>
	<option value="1"<?=($row["id_tipo_pessoa"]=='Pessoa Jurídica') ? 'selected' : '' ?>>Pessoa Jurídica</option>
	</select>
	</div>
	<div class="col-sm-4 form-group form-group-sm"  id="eeDataAniversario">
	<label class="control-label" id="elDataAniversario">Data de Nascimento</label>
	<div class="input-group date form_datetime col-md-12" style="z-index:0;">
	<input class="form-control" size="16" name="eDataAniversario" id="eDataAniversario" type="text" value="<?php echo formata_data_exibicao($row["data_aniversario"]);?>"readonly />
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
	</div>
	<div class="col-sm-4 form-group form-group-sm" id="eeDataFundacao">                             
	<label class="control-label" id="elDataFundacao">Data de Fundação</label>
	<div class="input-group date form_datetime col-md-12" style="z-index:0;">
	<input class="form-control" size="16" name="eDataFundacao" id="eDataFundacao" type="text" value="<?php echo formata_data_exibicao($row["data_fundacao"]);?>"readonly />
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
	</div>						
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label" id="elTipoProfissao">Profissão</label>
	<select class="form-control" name="eTipoProfissao"  id="eTipoProfissao" >
	<option value="0" <?= ($row["id_tipo_parceiro"]=='Engenheiro') ? 'selected' : '' ?>>Engenheiro</option>
	<option value="1"<?=($row["id_tipo_parceiro"]=='Arquiteto') ? 'selected' : '' ?>>Arquiteto</option>
	<option value="2" <?= ($row["id_tipo_parceiro"]=='Design') ? 'selected' : '' ?>>Design</option>
	</select>
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label" id="elCAU">CAU</label>
	<input class="form-control" id="eCAU" name="eCAU"
	value="<?php echo $row["cau"];?>"/> 							
	</div>   
	</div>
	</div>
	</div>
	</div>
	</div>
	<div class="row" name="epessoaFisica" >
	<div class="col-sm-12 form-group-sm">
	<div class="panel panel-default">
	<div class="panel-heading">
	<div class="panel-title">
	Endereço
	</div>
	</div>
	<div class="panel-body">
	<div class="row">
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">CEP</label>
	<input class="form-control" id="eCEP" onkeypress="handleMask(event, '99999-999')" name="eCEP"value="<?php echo $row["cep"];?>"/>
	<input class="form-control" id="eCEPEmpresa" onkeypress="handleMask(event, '99999-999')" name="eCEPEmpresa" value="<?php echo $row["cep_empresa"];?>"/>
	</div>
	<div class="form-group form-group-sm col-sm-8">
	<label class="control-label">Logradouro</label>
	<input class="form-control" id="eEndereco" name="eEndereco" value="<?php echo $row["endereco"];?>" />
	<input class="form-control" id="eEnderecoEmpresa" name="eEnderecoEmpresa" value="<?php echo $row["endereco_empresa"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Número</label>
	<input class="form-control" id="eNumero" name="eNumero" value="<?php echo $row["numero"];?>"/>
	<input class="form-control" id="eNumeroEmpresa" name="eNumeroEmpresa" value="<?php echo $row["numero_empresa"];?>"/>
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Bairro</label>
	<input class="form-control" id="eBairro" name="eBairro"value="<?php echo $row["bairro"];?>"/> 
	<input class="form-control" id="eBairroEmpresa" name="eBairroEmpresa"value="<?php echo $row["bairro_empresa"];?>"/> 
	</div>                        
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Complemento</label>
	<input class="form-control" id="eComplemento" name="eComplemento" value="<?php echo $row["complemento"];?>"/>
	<input class="form-control" id="eComplementoEmpresa" name="eComplementoEmpresa" value="<?php echo $row["complemento_empresa"];?>"/>
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Cidade</label>
	<input class="form-control" id="eCidade" name="eCidade" value="<?php echo $row["cidade"];?>"/>
	<input class="form-control" id="eCidadeEmpresa" name="eCidadeEmpresa" value="<?php echo $row["cidade_empresa"];?>"/>
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">UF</label>
	<select class="form-control" id="eUf" name="eUf" >
	<option value="" <?=($row["uf"]=='selecione') ? 'selected' : '' ?>>SELECIONE</option>
	<option value="AC" <?=($row["uf"]=='AC') ? 'selected' : '' ?>>AC</option>
	<option value="AL" <?=($row["uf"]=='AL') ? 'selected' : '' ?>>AL</option>
	<option value="AM" <?= ($row["uf"]=='AM') ? 'selected' : '' ?>>AM</option>
	<option value="AP" <?=($row["uf"]=='AP') ? 'selected' : '' ?>>AP</option>
	<option value="BA" <?=($row["uf"]=='BA') ? 'selected' : '' ?>>BA</option>
	<option value="CE" <?= ($row["uf"]=='CE') ? 'selected' : '' ?>>CE</option>
	<option value="DF" <?=($row["uf"]=='DF') ? 'selected' : '' ?>>DF</option>
	<option value="ES" <?=($row["uf"]=='ES') ? 'selected' : '' ?>>ES</option>
	<option value="GO" <?= ($row["uf"]=='GO') ? 'selected' : '' ?>>GO</option>
	<option value="MA" <?=($row["uf"]=='MA') ? 'selected' : '' ?>>MA</option>
	<option value="MG" <?=($row["uf"]=='MG') ? 'selected' : '' ?>>MG</option>
	<option value="MS" <?= ($row["uf"]=='MS') ? 'selected' : '' ?>>MS</option>
	<option value="MT" <?=($row["uf"]=='MT') ? 'selected' : '' ?>>MT</option>
	<option value="PA" <?=($row["uf"]=='PA') ? 'selected' : '' ?>>PA</option>
	<option value="PB" <?= ($row["uf"]=='PB') ? 'selected' : '' ?>>PB</option>
	<option value="PE" <?=($row["uf"]=='PE') ? 'selected' : '' ?>>PE</option>
	<option value="PI" <?=($row["uf"]=='PI') ? 'selected' : '' ?>>PI</option>
	<option value="PR" <?= ($row["uf"]=='PR') ? 'selected' : '' ?>>PR</option>
	<option value="RJ" <?=($row["uf"]=='RJ') ? 'selected' : '' ?>>RJ</option>
	<option value="RN" <?=($row["uf"]=='RN') ? 'selected' : '' ?>>RN</option>
	<option value="RO" <?= ($row["uf"]=='RO') ? 'selected' : '' ?>>RO</option>
	<option value="RR" <?=($row["uf"]=='RR') ? 'selected' : '' ?>>RR</option>
	<option value="RS" <?=($row["uf"]=='RS') ? 'selected' : '' ?>>RS</option>
	<option value="SC" <?= ($row["uf"]=='SC') ? 'selected' : '' ?>>SC</option>
	<option value="SE" <?=($row["uf"]=='SE') ? 'selected' : '' ?>>SE</option>
	<option value="SP" <?=($row["uf"]=='SP') ? 'selected' : '' ?>>SP</option>
	<option value="TO" <?= ($row["uf"]=='TO') ? 'selected' : '' ?>>TO</option>
	</select value="<?php echo $row["uf"];?>">
	
	<select class="form-control" id="eUfEmpresa" name="eUfEmpresa" >
	<option value="" <?=($row["UfEmpresa"]=='selecione') ? 'selected' : '' ?>>SELECIONE</option>
	<option value="AC" <?=($row["UfEmpresa"]=='AC') ? 'selected' : '' ?>>AC</option>
	<option value="AL" <?=($row["UfEmpresa"]=='AL') ? 'selected' : '' ?>>AL</option>
	<option value="AM" <?= ($row["UfEmpresa"]=='AM') ? 'selected' : '' ?>>AM</option>
	<option value="AP" <?=($row["UfEmpresa"]=='AP') ? 'selected' : '' ?>>AP</option>
	<option value="BA" <?=($row["UfEmpresa"]=='BA') ? 'selected' : '' ?>>BA</option>
	<option value="CE" <?= ($row["UfEmpresa"]=='CE') ? 'selected' : '' ?>>CE</option>
	<option value="DF" <?=($row["UfEmpresa"]=='DF') ? 'selected' : '' ?>>DF</option>
	<option value="ES" <?=($row["UfEmpresa"]=='ES') ? 'selected' : '' ?>>ES</option>
	<option value="GO" <?= ($row["UfEmpresa"]=='GO') ? 'selected' : '' ?>>GO</option>
	<option value="MA" <?=($row["UfEmpresa"]=='MA') ? 'selected' : '' ?>>MA</option>
	<option value="MG" <?=($row["UfEmpresa"]=='MG') ? 'selected' : '' ?>>MG</option>
	<option value="MS" <?= ($row["UfEmpresa"]=='MS') ? 'selected' : '' ?>>MS</option>
	<option value="MT" <?=($row["UfEmpresa"]=='MT') ? 'selected' : '' ?>>MT</option>
	<option value="PA" <?=($row["UfEmpresa"]=='PA') ? 'selected' : '' ?>>PA</option>
	<option value="PB" <?= ($row["UfEmpresa"]=='PB') ? 'selected' : '' ?>>PB</option>
	<option value="PE" <?=($row["UfEmpresa"]=='PE') ? 'selected' : '' ?>>PE</option>
	<option value="PI" <?=($row["UfEmpresa"]=='PI') ? 'selected' : '' ?>>PI</option>
	<option value="PR" <?= ($row["UfEmpresa"]=='PR') ? 'selected' : '' ?>>PR</option>
	<option value="RJ" <?=($row["UfEmpresa"]=='RJ') ? 'selected' : '' ?>>RJ</option>
	<option value="RN" <?=($row["UfEmpresa"]=='RN') ? 'selected' : '' ?>>RN</option>
	<option value="RO" <?= ($row["UfEmpresa"]=='RO') ? 'selected' : '' ?>>RO</option>
	<option value="RR" <?=($row["UfEmpresa"]=='RR') ? 'selected' : '' ?>>RR</option>
	<option value="RS" <?=($row["UfEmpresa"]=='RS') ? 'selected' : '' ?>>RS</option>
	<option value="SC" <?= ($row["UfEmpresa"]=='SC') ? 'selected' : '' ?>>SC</option>
	<option value="SE" <?=($row["UfEmpresa"]=='SE') ? 'selected' : '' ?>>SE</option>
	<option value="SP" <?=($row["UfEmpresa"]=='SP') ? 'selected' : '' ?>>SP</option>
	<option value="TO" <?= ($row["UfEmpresa"]=='TO') ? 'selected' : '' ?>>TO</option>
	</select value="<?php echo $row["UfEmpresa"];?>">
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	
	<!--	<div class="row"  name="epessoaJuridica" style="visibility:hidden" id="epessoaJuridica"> -->
	
	<div class="row">
	<div class="col-sm-12 form-group-sm">
	<div class="panel panel-default">
	<div class="panel-heading">
	<div class="panel-title">
	Sócio 01
	</div>
	</div>
	<div class="panel-body">
	<div class="row">
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Nome</label>
	<input class="form-control" id="eNomeSocio1" name="eNomeSocio1" value="<?php echo $row["nome_socio1"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Percentual</label>
	<input class="form-control" id="ePercentualSocio1" name="ePercentualSocio1" value="<?php echo $row["percentual_socio1"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Administrador?</label>
	<select class="form-control" name="eIsadminsocio1"  id="eIsadminsocio1" >
	<option value="0" <?= ($row["is_admin_socio1"]=='Sim') ? 'selected' : '' ?>>Sim</option>
	<option value="1"<?=($row["is_admin_socio1"]=='Não') ? 'selected' : '' ?>>Não</option>
	</select>
	</div>
	
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label" id="elRgSocio1">RG</label>
	<input class="form-control" id="eRgSocio1" onkeypress="handleMask(event, '99.999.999-9')" name="eRgSocio1"
	value="<?php echo $row["rg_socio1"];?>"/>								
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label" id="elCpfSocio1">CPF</label>
	<input class="form-control" id="eCpfSocio1" onkeypress="handleMask(event, '999.999.999-99')" name="eCpfSocio1" value="<?php echo $row["cpf_socio1"]; ?>" <?= ($row["cpf_socio1"] != null) ? 'disabled' : '' ?>/>							  
	</div>
	</div>      
	<div class="row">
	<div class="form-group form-group-sm col-sm-3">
	<label class="control-label" id="elTelefoneSocio1">Telefone</label>
	<input class="form-control" onkeypress="handleMask(event, '99 99999-9999')" id="eTelefoneSocio1" name="eTelefoneSocio1" 
	value="<?php echo $row["telefone_socio1"];?>"/>
	</div>
	<div class="form-group form-group-sm col-sm-6">
	<label class="control-label" id="elEmailSocio1">Email</label>
	<input class="form-control" id="eEmailSocio1" name="eEmailSocio1"
	value="<?php echo $row["email_socio1"];?>"/> 							
	</div>     
	<div class="col-sm-3 form-group form-group-sm"  id="eeDataAniversarioSocio1">
	<label class="control-label" id="elDataAniversarioSocio1">Data de Nascimento</label>
	<div class="input-group date form_datetime col-md-12" style="z-index:0;">
	<input class="form-control" size="16" name="eDataAniversarioSocio1" id="eDataAniversarioSocio1" type="text" value="<?php echo formata_data_exibicao($row["data_aniversario_socio1"]);?>"readonly />
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
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
	Sócio 02
	</div>
	</div>
	<div class="panel-body">
	<div class="row">
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Nome</label>
	<input class="form-control" id="eNomeSocio2" name="eNomeSocio2" value="<?php echo $row["nome_socio2"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Percentual</label>
	<input class="form-control" id="ePercentualSocio2" name="ePercentualSocio2" value="<?php echo $row["percentual_socio2"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Administrador?</label>
	<select class="form-control" name="eIsadminsocio2"  id="eIsadminsocio2" >
	<option value="0" <?= ($row["is_admin_socio2"]=='Sim') ? 'selected' : '' ?>>Sim</option>
	<option value="1"<?=($row["is_admin_socio2"]=='Não') ? 'selected' : '' ?>>Não</option>
	</select>
	</div>
	
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label" id="elRgSocio2">RG</label>
	<input class="form-control" id="eRgSocio2" onkeypress="handleMask(event, '99.999.999-9')" name="eRgSocio2"
	value="<?php echo $row["rg_socio2"];?>"/>								
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label" id="elCpfSocio2">CPF</label>
	<input class="form-control" id="eCpfSocio2" onkeypress="handleMask(event, '999.999.999-99')" name="eCpfSocio2" value="<?php echo $row["cpf_socio2"]; ?>" <?= ($row["cpf_socio2"] != null) ? 'disabled' : '' ?>/>							  
	</div>
	</div>      
	<div class="row">
	<div class="form-group form-group-sm col-sm-3">
	<label class="control-label" id="elTelefoneSocio2">Telefone</label>
	<input class="form-control" onkeypress="handleMask(event, '99 99999-9999')" id="eTelefoneSocio2" name="eTelefoneSocio2" 
	value="<?php echo $row["telefone_socio2"];?>"/>
	</div>
	<div class="form-group form-group-sm col-sm-6">
	<label class="control-label" id="elEmailSocio2">Email</label>
	<input class="form-control" id="eEmailSocio2" name="eEmailSocio2"
	value="<?php echo $row["email_socio2"];?>"/> 							
	</div>     
	<div class="col-sm-3 form-group form-group-sm"  id="eeDataAniversarioSocio2">
	<label class="control-label" id="elDataAniversarioSocio2">Data de Nascimento</label>
	<div class="input-group date form_datetime col-md-12" style="z-index:0;">
	<input class="form-control" size="16" name="eDataAniversarioSocio2" id="eDataAniversarioSocio2" type="text" value="<?php echo formata_data_exibicao($row["data_aniversario_socio2"]);?>"readonly />
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
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
	Sócio 03
	</div>
	</div>
	<div class="panel-body">
	<div class="row">
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Nome</label>
	<input class="form-control" id="eNomeSocio3" name="eNomeSocio3" value="<?php echo $row["nome_socio3"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Percentual</label>
	<input class="form-control" id="ePercentualSocio3" name="ePercentualSocio3" value="<?php echo $row["percentual_socio3"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Administrador?</label>
	<select class="form-control" name="eIsadminsocio3"  id="eIsadminsocio3" >
	<option value="0" <?= ($row["is_admin_socio3"]=='Sim') ? 'selected' : '' ?>>Sim</option>
	<option value="1"<?=($row["is_admin_socio3"]=='Não') ? 'selected' : '' ?>>Não</option>
	</select>
	</div>
	
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label" id="elRgSocio3">RG</label>
	<input class="form-control" id="eRgSocio3" onkeypress="handleMask(event, '99.999.999-9')" name="eRgSocio3"
	value="<?php echo $row["rg_socio3"];?>"/>								
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label" id="elCpfSocio3">CPF</label>
	<input class="form-control" id="eCpfSocio3" onkeypress="handleMask(event, '999.999.999-99')" name="eCpfSocio3" value="<?php echo $row["cpf_socio3"]; ?>" <?= ($row["cpf_socio3"] != null) ? 'disabled' : '' ?>/>							  
	</div>
	</div>      
	<div class="row">
	<div class="form-group form-group-sm col-sm-3">
	<label class="control-label" id="elTelefoneSocio3">Telefone</label>
	<input class="form-control" onkeypress="handleMask(event, '99 99999-9999')" id="eTelefoneSocio3" name="eTelefoneSocio3" 
	value="<?php echo $row["telefone_socio3"];?>"/>
	</div>
	<div class="form-group form-group-sm col-sm-6">
	<label class="control-label" id="elEmailSocio3">Email</label>
	<input class="form-control" id="eEmailSocio3" name="eEmailSocio3"
	value="<?php echo $row["email_socio3"];?>"/> 							
	</div>     
	<div class="col-sm-3 form-group form-group-sm"  id="eeDataAniversarioSocio3">
	<label class="control-label" id="elDataAniversarioSocio3">Data de Nascimento</label>
	<div class="input-group date form_datetime col-md-12" style="z-index:0;">
	<input class="form-control" size="16" name="eDataAniversarioSocio3" id="eDataAniversarioSocio3" type="text" value="<?php echo formata_data_exibicao($row["data_aniversario_socio3"]);?>"readonly />
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
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
	Sócio 04
	</div>
	</div>
	<div class="panel-body">
	<div class="row">
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Nome</label>
	<input class="form-control" id="eNomeSocio4" name="eNomeSocio4" value="<?php echo $row["nome_socio4"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Percentual</label>
	<input class="form-control" id="ePercentualSocio4" name="ePercentualSocio4" value="<?php echo $row["percentual_socio4"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Administrador?</label>
	<select class="form-control" name="eIsadminsocio4"  id="eIsadminsocio4" >
	<option value="0" <?= ($row["is_admin_socio4"]=='Sim') ? 'selected' : '' ?>>Sim</option>
	<option value="1"<?=($row["is_admin_socio4"]=='Não') ? 'selected' : '' ?>>Não</option>
	</select>
	</div>
	
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label" id="elRgSocio4">RG</label>
	<input class="form-control" id="eRgSocio4" onkeypress="handleMask(event, '99.999.999-9')" name="eRgSocio4"
	value="<?php echo $row["rg_socio4"];?>"/>								
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label" id="elCpfSocio4">CPF</label>
	<input class="form-control" id="eCpfSocio4" onkeypress="handleMask(event, '999.999.999-99')" name="eCpfSocio4" value="<?php echo $row["cpf_socio4"]; ?>" <?= ($row["cpf_socio4"] != null) ? 'disabled' : '' ?>/>							  
	</div>
	</div>      
	<div class="row">
	<div class="form-group form-group-sm col-sm-3">
	<label class="control-label" id="elTelefoneSocio4">Telefone</label>
	<input class="form-control" onkeypress="handleMask(event, '99 99999-9999')" id="eTelefoneSocio4" name="eTelefoneSocio4" 
	value="<?php echo $row["telefone_socio4"];?>"/>
	</div>
	<div class="form-group form-group-sm col-sm-6">
	<label class="control-label" id="elEmailSocio4">Email</label>
	<input class="form-control" id="eEmailSocio4" name="eEmailSocio4"
	value="<?php echo $row["email_socio4"];?>"/> 							
	</div>     
	<div class="col-sm-3 form-group form-group-sm"  id="eeDataAniversarioSocio4">
	<label class="control-label" id="elDataAniversarioSocio4">Data de Nascimento</label>
	<div class="input-group date form_datetime col-md-12" style="z-index:0;">
	<input class="form-control" size="16" name="eDataAniversarioSocio4" id="eDataAniversarioSocio4" type="text" value="<?php echo formata_data_exibicao($row["data_aniversario_socio4"]);?>"readonly />
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
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
	Sócio 05
	</div>
	</div>
	<div class="panel-body">
	<div class="row">
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Nome</label>
	<input class="form-control" id="eNomeSocio5" name="eNomeSocio5" value="<?php echo $row["nome_socio5"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Percentual</label>
	<input class="form-control" id="ePercentualSocio5" name="ePercentualSocio5" value="<?php echo $row["percentual_socio5"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Administrador?</label>
	<select class="form-control" name="eIsadminsocio5"  id="eIsadminsocio5" >
	<option value="0" <?= ($row["is_admin_socio5"]=='Sim') ? 'selected' : '' ?>>Sim</option>
	<option value="1"<?=($row["is_admin_socio5"]=='Não') ? 'selected' : '' ?>>Não</option>
	</select>
	</div>
	
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label" id="elRgSocio5">RG</label>
	<input class="form-control" id="eRgSocio5" onkeypress="handleMask(event, '99.999.999-9')" name="eRgSocio5"
	value="<?php echo $row["rg_socio5"];?>"/>								
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label" id="elCpfSocio5">CPF</label>
	<input class="form-control" id="eCpfSocio5" onkeypress="handleMask(event, '999.999.999-99')" name="eCpfSocio5" value="<?php echo $row["cpf_socio5"]; ?>" <?= ($row["cpf_socio5"] != null) ? 'disabled' : '' ?>/>							  
	</div>
	</div>      
	<div class="row">
	<div class="form-group form-group-sm col-sm-3">
	<label class="control-label" id="elTelefoneSocio5">Telefone</label>
	<input class="form-control" onkeypress="handleMask(event, '99 99999-9999')" id="eTelefoneSocio5" name="eTelefoneSocio5" 
	value="<?php echo $row["telefone_socio5"];?>"/>
	</div>
	<div class="form-group form-group-sm col-sm-6">
	<label class="control-label" id="elEmailSocio5">Email</label>
	<input class="form-control" id="eEmailSocio5" name="eEmailSocio5"
	value="<?php echo $row["email_socio5"];?>"/> 							
	</div>     
	<div class="col-sm-3 form-group form-group-sm"  id="eeDataAniversarioSocio5">
	<label class="control-label" id="elDataAniversarioSocio5">Data de Nascimento</label>
	<div class="input-group date form_datetime col-md-12" style="z-index:0;">
	<input class="form-control" size="16" name="eDataAniversarioSocio5" id="eDataAniversarioSocio5" type="text" value="<?php echo formata_data_exibicao($row["data_aniversario_socio5"]);?>"readonly />
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
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
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Id Vendedor</label>
	<input class="form-control" id="eIdVendedor" name="eIdVendedor" value="<?php echo $row1["id_vendedores"];?>" disabled/>
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Nome</label>
	<input class="form-control" id="eNomeVendedor" name="eNomeVendedor" value="<?php echo $row1["nome"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">CPF</label>
	<input class="form-control" id="eCpfVendedor" name="eCpfVendedor" value="<?php echo $row1["cpf"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">RG</label>
	<input class="form-control" id="eRgVendedor" name="eRgVendedor" value="<?php echo $row1["rg"];?>" />
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">CEP</label>
	<input class="form-control" id="eCepVendedor" name="eCepVendedor" value="<?php echo $row1["cep"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Logradouro</label>
	<input class="form-control" id="eEnderecoVendedor" name="eEnderecoVendedor" value="<?php echo $row1["endereco"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-2">
	<label class="control-label">Número</label>
	<input class="form-control" id="eNumeroVendedor" name="eNumeroVendedor" value="<?php echo $row1["numero"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Bairro</label>
	<input class="form-control" id="eBairroVendedor" name="eBairroVendedor" value="<?php echo $row1["bairro"];?>" />
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Complemento</label>
	<input class="form-control" id="eComplementoVendedor" name="eComplementoVendedor" value="<?php echo $row1["complemento"];?>" />
	</div>
	<div class="form-group form-group-sm col-sm-4">
	<label class="control-label">Cidade</label>
	<input class="form-control" id="eCidadeVendedor" name="eCidadeVendedor" value="<?php echo $row1["cidade"];?>" />
	</div>
	<div class="col-sm-4 form-group form-group-sm">
	<label class="control-label">Aniversário</label>
	<div class="input-group date form_datetime col-md-12" style="z-index:0;">
	<input class="form-control" size="16" name="eDataAniversario" id="eDataAniversario" type="text" value="<?php echo formata_data_exibicao($row1["data_aniversario"]);?>"readonly>
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span></input>
	</div>
	</div>
	</div>
	<div class="row">
	<div class="col-sm-4 form-group form-group-sm">
	<label class="control-label">Data de Admissão</label>
	<div class="input-group date form_datetime col-md-12" style="z-index:0;">
	<input class="form-control" size="16" name="eDataAdmissao" id="eDataAdmissao" type="text" value="<?php echo formata_data_exibicao($row1["data_admissao"]);?>"readonly>
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
	</div>
	<div class="col-sm-4 form-group form-group-sm">
	<label class="control-label">Data Demissão</label>
	<div class="input-group date form_datetime col-md-12" style="z-index:0;">
	<input class="form-control" size="16" name="eDataDemissao" id="eDataDemissao" type="text" value="<?php echo formata_data_exibicao($row1["data_demissao"]);?>"readonly>
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
	</div>
	<div class="col-sm-4 form-group form-group-sm">
	<label class="control-label">Vendedor Está ativo?</label>
	<select class="form-control" name="eIsvendedorAtivo" id="eIsvendedorAtivo" >
	<option value="0" <?= ($row1["is_vendedor_ativo"]=='Sim') ? 'selected' : '' ?>>Sim</option>
	<option value="1"<?=($row1["is_vendedor_ativo"]=='Não') ? 'selected' : '' ?>>Não</option>
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
	<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	</div>
	</div>
	</div>
	</div>
	</div>
	<div id="ModalExcluir" class="modal fade" role="dialog">
	<div class="modal-dialog ">
	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header" style="background-color: #00091a; color:white; border-radius:5px 5px 0px 0px;">
	<button type="button" class="close" onclick="TiraLoader()"data-dismiss="modal">&times;</button>
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