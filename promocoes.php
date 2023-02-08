<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	
	$TituloPage = "Promoções";
	date_default_timezone_set('america/sao_paulo');
    
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
		
		$sql = "SELECT * FROM promocoes";
		if ($nome != "" && $nome != null)
		$sql = $sql . " WHERE titulo like'%" . $nome . "%' OR descricao like'%" . $nome . "%'";
		
		if ($Ordem == 1)
		$sql = $sql . " ORDER By id_promocoes DESC ";
		
		$stmt = $conn->prepare($sql); //
		$stmt->execute();
		$result = $stmt->get_result();
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
	<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-datetimepicker.js"></script>
	<script src="js/locales/bootstrap-datetimepicker.pt-BR.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/geral.css"/>
	<script src="js/carregaloader.js"></script>
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
	
	// Number
	});
	
	function SubmeterForm() {
	$("#FormLog").submit();
	};
	function SubmeterModal() {
	$("#modalform").submit();
	};
	
	function EnviaEmail() {
	/*$.ajax({
	url: 'enviaEmail.php',
	type: 'post',
	data: data,
	//dataType: 'json',
	cache: false,
	contentType: false,
	processData: false,
    }).fail(function (xhr, ajaxOptions, thrownError) {
    
    $("#eError").text('Erro: ' + thrownError);
    
	}).done(function (data, textStatus, jqXHR) {
    
	$("#eSucesso").text(JSON.stringify(data));
	}); */
	}
	
	function UploadArquivo(){
	return new Promise(resolve => {
	// $('#eArquivo').click(function(){
	//var arquivo = $('#eArquivo')[0].files[0].name;
	// var dataU = {};
	////$("#eId").val() = 123;
	var size = $("#eArquivo")[0].files[0].size / 1000000;
	if(size >= 4)
	$("#eError").text("Não é permitido imagem de tamanho maior que 4MB, escolha outra imagem!!");
	event.preventDefault();
	var form = $("#modalform")[0];
	data = new FormData(form);
	// AJAX request
	if($("#eError")[0].innerText == null || $("#eError")[0].innerText == ""){
	$.ajax({
	url: 'uploadFile.php',
	type: 'post',
	data: data,
	//dataType: 'json',
	cache: false,
	contentType: false,
	processData: false,
	}).fail(function (xhr, ajaxOptions, thrownError) {
	$("#eError").text('Erro: ' + thrownError);
	}).done(function (data, textStatus, jqXHR) {
	//EnviaEmail();
	$("#eSucesso").text(JSON.stringify(data));
	setTimeout(() => {$("#ModalEdit").modal("hide");
	$("#FormLog").submit();}, 1000);
	
	}); 
	
	}});
	
	}
	
	function Editar(id) {
	$("#eError").text("");
	$("#eSucesso").text("");
	$.ajax({
	type: "POST",
	url: 'promocaoQuery.php',
	data: {
	Id: id,
	},
	success: function(html) {
	var ob = JSON.parse(html)
	console.log(ob)
	$("#eId").val(ob.id_promocoes);
	$("#eMeta").val(ob.meta);
	$("#eTitulo").val(ob.titulo);
	$("#eDescricao").val(ob.descricao);
	$("#eDataCadastro").val(ob.data_cadastro);
	$("#eDataValidade").val(ob.data_validade);
	$("#eFotoBanco").val(ob.foto);
	$("#eLojas").val(ob.id_loja);
	var image = $("#eImage")[0];
	if( image != null)
	image.remove();
	var img = new Image();
	img.src = ob.foto;
	img.id = "eImage";
	img.width = "200";
	img.height = "200";
	row = document.getElementById('eRow');
	row.appendChild(img);
	$('#eArquivo')[0].files[0] = img;
	
	
	//$("#eImage").attr('src', ob.foto.substring(1,100));
	
	//$("#ePermissao").val(ob.niveis_acesso_id);
	//$("#eSenha").val("");
	$("#ModalEdit").modal("show");
	},
	error: function(xhr, ajaxOptions, thrownError) {
	alert(thrownError);
	}
	
	});
	return;
	};
	
	function Excluir(id){
	$("#ModalExcluir").modal("show");
	$("#IdExclude").val(id);
	}
	
	function AdicionarPromocao() {
	$("#eId").val(0);
	$("#eTitulo").val("");
	$("#eDescricao").val("");
	$("#eError").text("");
	$("#eDataValidade").val("");
	$("#eDataCadastro").val("");
	var image = $("#eImage")[0];
	if( image != null)
	image.remove();
	$("#eSucesso").text("");
	$("#ModalEdit").modal("show");
	}
	
	function GravarPromocao() 
	{          
	console.log($("#eArquivo")[0].files[0])
	$("#eError").text("");
	if ($("#eTitulo").val() == null || $("#eTitulo").val() == "")
	$("#eError").text("É necessário preencher o campo nome");
	else if ($("#eDescricao").val() == null || $("#eDescricao").val() == "")
	$("#eError").text("É necessário preencher o campo email");
	else if ($("#eDataCadastro").val() == null || $("#eDataCadastro").val() == "")
	$("#eError").text("É necessário preencher o campo de Data Cadastro");
	else if ($("#eDataValidade").val() == null || $("#eDataValidade").val() == "")
	$("#eError").text("É necessário preencher o campo de Data de Validade da Promoção");
	else if ($('#eArquivo')[0].files[0] == 'undefined' && $("#eImage")[0] == 'undefined')
	$("#eError").text("É necessário fazer o upload de uma imagem para a promoção");
	else if ($("#eMeta").val() == null || $("#eMeta").val() == "")
	$("#eError").text("É necessário preencher o campo de Meta de Circulação");
	
	debugger
	var foto = true;
	if($("#eArquivo")[0].files[0]==undefined)
	foto = false;
	console.log("FOTO: " + foto);
	var microtime = 0 ;
	var dataU = {};
	dataU.Id = $("#eId").val();
	dataU.Meta = $("#eMeta").val();
	dataU.Loja = 0;
	dataU.IdLoja = $("#eLojas").children("option:selected").val();
	dataU.Titulo = $("#eTitulo").val();
	dataU.Descricao = $("#eDescricao").val();
	dataU.DataCadastro = $("#eDataCadastro").val();
	dataU.DataValidade = $("#eDataValidade").val();
	
	console.log("dataU.DataCadastro: "  + dataU.DataCadastro)
	console.log("dataU.DataValidade: "  + dataU.DataValidade)
	if(foto==true)
	{
	if($('#eArquivo')[0].files[0] != null && $("#eImage")[0] == null)
	{
	//alert("Entrou no primeiro if");
	microtime = $("#eId").val() + Math.floor(Math.random() * 10000000);
	dataU.Foto = "./media/" + microtime + "." + $('#eArquivo')[0].files[0].type.substring(6,12);
	$("#eMicrotime").val(dataU.Foto);
	}
	else if($('#eArquivo')[0].files[0] != null && $("#eImage")[0] != null)
	{
	var path = $("#eImage")[0].src.substring(31,60);
	$.ajax({
	type: "POST",
	url: 'DeletaArquivo.php',
	data: path
	});
	
	microtime = $("#eId").val() + Math.floor(Math.random() * 10000000);
	dataU.Foto = "./media/" + microtime + "." + $('#eArquivo')[0].files[0].type.substring(6,12);
	$("#eMicrotime").val(dataU.Foto);
	}		
	else if($('#eArquivo')[0].files[0] == null && $("#eImage")[0] != null){					
	$("#eSucesso").text("Sucesso");			 
	}
	}
	else{
	dataU.Foto = $("#eFotoBanco").val();
	}
	
	if($("#eError")[0].innerText == null || $("#eError")[0].innerText == ""){
	$.ajax({
	type: "POST",
	url: 'promocoesInsert.php',
	data: dataU,
	success: async function(html) {
	if (html.indexOf("sucesso") != -1) {
	if(foto==true)
	result = await UploadArquivo();
	else{
	$("#eSucesso").text(html);
	setTimeout(() => {$("#ModalEdit").modal("hide");
	$("#FormLog").submit();}, 1000);
	}
	} 
	else 
	{
	$("#eError").text(html);
	}
	},
	error: function(xhr, ajaxOptions, thrownError) {
	$("#eError").text(thrownError);
	}
	});
	}
	return;
	}
	
	function ExcluirPromocao(){
	
	var dataU = {};
	dataU.Id = $("#IdExclude").val();
	
	$.ajax({
	type: "POST",
	url: 'promocoesDelete.php',
	data: dataU,
	success: function(html) {
	if (html.indexOf("sucesso") != -1) {                  
	$("#ModalExcluir").modal("hide");
	$("#FormLog").submit();
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
	<label class="control-label">Nome ou Descrição</label>
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
	</div>
	</div>
	</div>
	</div>
	
	</form>
	<div class="row">
	<?php 
	$permissao = $_SESSION['usuarioNiveisAcessoId'];
	if($permissao != "3"){
	echo "<div class='form-group form-group-sm form-group-xs col-xs-12 col-sm-12'>
	<a class='btn btn-primary' onclick='AdicionarPromocao()' title='Adicionar Promoção'>Adicionar Promoção</span></a>
	</div>";} ?>
	</div>
	<div class="row">
	<div class="col-sm-12 col-xs-12 form-group-sm form-group-xs">
	<table class="table table-condensed table-striped " style="width: -webkit-fill-available">
	<thead>
	<tr>
	<th class="hidden-md hidden-lg"></th>
	<th class="hidden-xs hidden-sm">Id</th>
	<th class="hidden-xs hidden-sm">Título</th>
	<th class="hidden-xs hidden-sm">Data de Início</th>
	<th class="hidden-xs hidden-sm">Data de Fim</th>
	<th></th>
	</tr>
	</thead>
	<tbody>
	<?php
	if ($result->num_rows > 0) {
	for ($i = 0; $i < $result->num_rows; $i++) {
	$row = $result->fetch_assoc();
	
	echo "<tr>
	<td class='hidden-md hidden-lg'>
	<b>Id: </b>" . $row["id_promocoes"] . "<br/>
	<b>Título: </b>" . $row["titulo"] . "<br/>
	<b>Data de Início: </b>" . formata_data_exibicao2($row["data_cadastro"]) . "<br/>
	<b>Data de Fim: </b>" . formata_data_exibicao2($row["data_validade"]) . "<br/>
	</td>
	
	<td class='hidden-xs hidden-sm'>" . $row["id_promocoes"] . "</td>
	<td class='hidden-xs hidden-sm'>" . ($row["titulo"]) . "</td>
	<td class='hidden-xs hidden-sm'>" . formata_data_exibicao2($row["data_cadastro"]) . "</td>
	<td class='hidden-xs hidden-sm'>" . formata_data_exibicao2($row["data_validade"]) . "</td>
	
	<td class='text-right'>
	<a class='btn btn-primary' title='Editar Promoção' onclick='Editar(" . $row["id_promocoes"] . ")'><span class='glyphicon glyphicon glyphicon-edit'></span></a>
	<a class='btn btn-danger' title='Excluir Promoção' onclick='Excluir(" . $row["id_promocoes"] . ")'><span class='glyphicon glyphicon glyphicon-trash'></span></a>
	</td>
	</tr>";
	}
	}
	?>
	</tbody>
	</table>
	</div>
	</div>
	<div class="row">&nbsp;</div>
	</div>
	<div id="ModalEdit" class="modal fade" role="dialog">
	<div class="modal-dialog ">
	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header" style="background-color: #00091a; color:white; border-radius:5px 5px 0px 0px;">
	<button type="button" class="close" onclick="TiraLoader()" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Edição de Promoção</h4>
	</div>
	<div class="modal-body">
	<form method='POST' id="modalform"  enctype="multipart/form-data">
	<div class="row">
	<div class="form-group form-group-sm form-group-xs col-xs-3 col-sm-3">
	<label class="control-label">Id</label>
	<input class="form-control" id="eId" name="eId" disabled required />
	</div>
	<div class="form-group form-group-sm form-group-xs col-xs-5 col-sm-5">
	<label class="control-label">Título</label>
	<input class="form-control" id="eTitulo" name="eTitulo" required />
	</div>
	<div class="form-group form-group-sm form-group-xs col-xs-4 col-sm-4">
	<label class="control-label">Meta de Circulação</label>
	<input type="number" class="form-control" id="eMeta" name="eMeta" required />
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm form-group-xs col-xs-12 col-sm-12">
	<label class="control-label">Descrição</label>
	<textarea class="form-control" id="eDescricao" name="eDescricao" ></textarea>
	</div>
	
	
	</div>
	<div class="row">
	<div class="col-sm-6 col-xs-6 form-group form-group-sm form-group-xs">
	<label class="control-label">Data de Início</label>
	<div class="input-group date form_datetime col-md-12 col-xs-12" style="z-index:0;">
	<input class="form-control" size="16" name="eDataCadastro" id="eDataCadastro" type="text" value="<?php echo formata_data_exibicao($row1["data_cadastro"]);?>" readonly>
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
	</div>
	<div class="col-sm-6 col-xs-6 form-group form-group-sm form-group-xs">
	<label class="control-label">Data de Fim</label>
	<div class="input-group date form_datetime col-md-12 col-xs-12" style="z-index:0;">
	<input class="form-control" size="16" name="eDataValidade" id="eDataValidade" type="text" value="<?php echo formata_data_exibicao($row1["data_validade"]);?>" readonly>
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
	</div>
	<div class="form-group form-group-sm form-group-xs col-xs-12 col-sm-12">
	<label class="control-label">Selecione um Arquivo :</label>
	<!-- input type max file é o tamanho do input da imagem em bytes -->
	<input type="hidden" name="MAX_FILE_SIZE" value="300000000" />
	<input type="hidden" name="eMicrotime" id="eMicrotime" required />
	<input type="hidden" name="eFotoBanco" id="eFotoBanco" value="<?php echo formata_data_exibicao($row1["foto"]);?>" />
	<input type='file' name='eArquivo' id='eArquivo' class='form-control' ><br>
	</div>
	<!--<div class="col-sm-6 form-group form-group-sm">
	<label class="control-label">Empresas</label>
	<select class="form-control" id="eLojas" name="eLojas">
	<?php/*
	$sqlloja = "SELECT * FROM empresas";
	$stmtloja = $conn->prepare($sqlloja); //
	$stmtloja->execute();
	$resultloja = $stmtloja->get_result();
	if ($resultloja->num_rows > 0) {
	for ($i = 0; $i < $resultloja->num_rows; $i++) {
	$rowloja = $resultloja->fetch_assoc();
	//  <option value='".$row["id_vendedores"]."'".($rowpontuacao["id_vendedores"]==$row["id_vendedores"] ? 'selected' : '').">".$row["nome"]."</option>";
	echo "<option value='".$rowloja["id_empresas"]."'".">".$rowloja["razao_social"]."</option>";
	}} */?>
	</select>
	
	</div> -->
	</div>
	<div class="row">
	<div class="form-group form-group-sm form-group-xs col-xs-6 col-sm-6" id="eRow">
	<label class="control-label">Arquivo Vinculado</label>
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
	<button type="button" class="btn btn-success" id="eGravar" onclick="GravarPromocao()">Gravar</button>
	<button type="button" class="btn btn-danger" onclick="TiraLoader()" data-dismiss="modal">Cancelar</button>
	</div>
	</div>
	</div>
	</form>
	</div>
	<div id="ModalExcluir" class="modal fade" role="dialog">
	<div class="modal-dialog ">
	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header" style="background-color: #00091a; color:white; border-radius:5px 5px 0px 0px;">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Atenção</h4>
	</div>
	<div class="modal-body">
	<div class="row">
	<div class="form-group form-group-sm form-group-xs col-xs-12 col-sm-12">
	<input name="IdExclude" id="IdExclude" style="display:none"/>
	<h4>Deseja realmente excluir este usuário?</h4>
	</div>
	</div>
	</div>
	<div class="modal-footer" style="background-color: #00091a; border-radius:0px 0px 5px 5px;">
	<button type="button" class="btn btn-success" onclick="ExcluirPromocao()">Excluir</button>
	<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	</div>
	</div>
	</div>
	</div>
	<footer class="container-fluid text-center" style="background-color:#091742;position: fixed;bottom: 0px!important;width: 100vw;">
	<div class="row">
	<div class="col-sm-6 col-xs-6 text-left"><img src="./imagens/Logo-teste-Login.png" style="height:3vh;margin:10px"/></div>
	<!-- <div class="col-sm-6 col-xs6 text-right"><a href=""><img src="./imagens/logo-branca.png" style="height:3vh;margin:10px"/></a></div> -->
	</div>
	</div>
	</footer>
	</body>
	</html>	