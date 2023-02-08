<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	
	$TituloPage = "Parceiros";
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
		
		$sql = "SELECT id_parceiros, nome, CASE WHEN cpf is null OR cpf='' THEN cnpj else cpf end as cpf, id_tipo_parceiro, id_tipo_pessoa, data_aniversario FROM parceiros";
		if ($nome != "" && $nome != null)
		$sql = $sql . " WHERE nome like'%" . $nome . "%' OR email like'%" . $nome . "%'";
		
		if ($Ordem == 0){
			$sql = $sql . " ORDER By nome ASC ";
		}
		
		elseif ($Ordem == 1){
			$sql = $sql . " ORDER By nome DESC ";
		}
		
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
		<link href="css/geral.css" rel="stylesheet">
		<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
		<script src="js/jquery.min.js"></script>
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
		
		// Number
		});
		
		function SubmeterForm() {
		$("#FormLog").submit();
		};
		
		function EditarParceiro(id) {
		CarregaLoader();
		location.href = "http://localhost/ScoreSale/parceirosCRUD.php?id="+id;
		/* var w = window.open("http://linkteste.com.br/parceirosCRUD.php?id="+id);
		w.addEventListener("load", function(event) {
		location.reload();
		});*/
		}    
		
		
		function Editar(id) {
		$("#eError").text("");
		$("#eSucesso").text("");
		$.ajax({
		type: "POST",
		url: 'usuarioQuery.php',
		data: {
		IdUsuario: id,
		},
		success: function(html) {
		var ob = JSON.parse(html)
		console.log(ob)
		$("#eId").val(ob.id);
		$("#eNome").val(ob.nome);
		$("#eTelefone").val(ob.telefone);
		$("#eEmail").val(ob.email);
		$("#ePermissao").val(ob.niveis_acesso_id);
		$("#eSenha").val("");
		$("#ModalEdit").modal("show");
		},
		error: function(xhr, ajaxOptions, thrownError) {
		alert(thrownError);
		}
		
		});
		return;
		};
		
		function Excluir(id,cpf,cnpj){
		//CarregaLoader();
		$("#ModalExcluir").modal("show");
		$("#IdExclude").val(id);
		$("#CPFExclude").val(cpf);
		$("#CNPJExclude").val(cnpj);
		}
		
		function AdicionarUsuario() {
		$("#eId").val(0);
		$("#eNome").val("");
		$("#eTelefone").val("");
		$("#eEmail").val("");
		$("#eSenha").val("");
		$("#eError").text("");
		$("#eSucesso").text("");
		$("#ModalEdit").modal("show");
		}
		
		function AdicionarParceiro() {
		CarregaLoader();
		location.href = "http://localhost/ScoreSale/parceirosCRUD.php?id="+0;
		/* $("#ModalEdit").modal("show");
		var w = window.open("http://linkteste.com.br/parceirosCRUD.php?id="+0);
		w.addEventListener("load", function(event) {
		location.reload();
		});*/
		}
		function GravarUsuario() {
		if ($("#eNome").val() == null || $("#eNome").val() == "")
		$("#eError").text("É necessário preencher o campo nome");
		else if ($("#eTelefone").val() == null || $("#eTelefone").val() == "")
		$("#eError").text("É necessário preencher o campo telefone");
		else if ($("#eEmail").val() == null || $("#eEmail").val() == "")
		$("#eError").text("É necessário preencher o campo email");
		else if ($("#eId").val() == 0 && ($("#eSenha").val() == null || $("#eSenha").val() == ""))
		$("#eError").text("É necessário preencher o campo senha");
		
		var dataU = {};
		dataU.Id = $("#eId").val();
		dataU.Nome = $("#eNome").val();
		dataU.Telefone = $("#eTelefone").val();
		dataU.Email = $("#eEmail").val();
		dataU.Senha = $("#eSenha").val();
		dataU.Permissao = $("#ePermissao").val();
		
		/*if(!ValidateEmail(dataU.Email)){
		$("#eError").text("Email inválido");
		return;
		}*/
		
		$.ajax({
		type: "POST",
		url: 'usuarioInsert.php',
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
		}
		
		});
		return;
		}
		
		function ExcluirParceiro(){
		
		var dataU = {};
		dataU.Id = $("#IdExclude").val();
		dataU.CPF = $("#CPFExclude").val();
		dataU.CNPJ = $("#CNPJExclude").val();
		
		$.ajax({
		type: "POST",
		url: 'parceirosDelete.php',
		data: dataU,
		success: function(html) {
		if (html.indexOf("sucesso") != -1) {                  
		$("#ModalExcluir").modal("hide");
		TiraLoader();
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
		<div class="container ">
		<form id="FormLog" action="<?= $_SERVER["PHP_SELF"] ?>" method="POST">
		<div class="row">
		<div class="col-sm-12 col-xs-12 form-group-sm">
		<div class="panel panel-default">
		<div class="panel-heading">
		<div class="panel-title">
		Dados de Pesquisa
		</div>
		</div>
		<div class="panel-body">
		<div class="row">
		<div class="col-sm-4 col-4 form-group form-group-sm">
		<label class="control-label">Nome</label>
		<input class="form-control" name="Nome" id="Nome"></input>
		</div>
		<div class="col-sm-4 col-4 form-group form-group-sm">
		<label class="control-label">Ordem</label>
		<select class="form-control" name="Ordem" id="Ordem">
		<option value="0" <?= ($Ordem == '0') ? 'selected' : '' ?>>Crescente</option>
		<option value="1" <?= ($Ordem == '1') ? 'selected' : '' ?>>Decrescente</option>
		</select>
		</div>
		<div class="col-sm-1 col-1 form-group form-group-sm"></div>
		<div class="col-sm-3 col-3 form-group form-group-sm text-right">
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
		if($permissao != "2"){
		echo "<div class='form-group form-group-sm form-group-xs col-xs-12 col-sm-12'>
		<a class='btn btn-primary' onclick='AdicionarParceiro()' title='Adicionar Parceiro'>Adicionar Parceiro</span></a>
		</div>";} ?>
		</div>
		<div class="row">
		<div class="col-sm-12 col-xs-12 form-group-sm form-group-xs">
		<table class="table table-condensed table-striped" style="width: -webkit-fill-available ">
		<thead>
		<tr>
		<th class="hidden-md hidden-lg"></th>
		<th class="hidden-xs hidden-sm">Id</th> 
		<th class="hidden-xs hidden-sm">Nome/Razão Social</th>
		<th class="hidden-xs hidden-sm">CPF/CNPJ</th>
		<th class="hidden-xs hidden-sm">Profissão</th>
		<th class="hidden-xs hidden-sm">Tipo</th>
		<th class="hidden-xs hidden-sm">Data Nascimento/Fundação</th>
		<th></th>
		</tr>
		</thead>
		<tbody>
		<?php
		if ($result->num_rows > 0) {
		for ($i = 0; $i < $result->num_rows; $i++) {
		$row = $result->fetch_assoc();
		$permissao = $_SESSION['usuarioNiveisAcessoId'];
		if($permissao =="2"){
		echo "<tr>
		<td class='hidden-md hidden-lg'>
		<b>Id: </b>" . $row["id_parceiros"] . "<br/>
		<b>Nome/Razão Social: </b>" . $row["nome"] . "<br/>
		<b>CPF/CNPJ: </b>" . $row["cpf"] . "<br/>
		<b>Profissão: </b>" . $row["id_tipo_parceiro"] . "<br/>
		<b>Tipo: </b>" . $row["id_tipo_pessoa"] . "<br/>
		<b>Data Nascimento/Fundação: </b>" . formata_data_exibicao2($row["data_aniversario"]) . "<br/>
		</td>
		
		<td class='hidden-xs hidden-sm'>" . $row["id_parceiros"] . "</td>
		<td class='hidden-xs hidden-sm'>" . ($row["nome"]) . "</td>
		<td class='hidden-xs hidden-sm'>" . ($row["cpf"]) ."</td> 
		<td class='hidden-xs hidden-sm'>" . ($row["id_tipo_parceiro"]) ."</td>
		<td class='hidden-xs hidden-sm'>" . ($row["id_tipo_pessoa"]) ."</td>
		<td class='hidden-xs hidden-sm'>" . formata_data_exibicao2($row["data_aniversario"]) . "</td>
		</tr>";
		}
		else 
		echo "<tr>
		<td class='hidden-md hidden-lg'>
		<b>Id: </b>" . $row["id_parceiros"] . "<br/>
		<b>Nome/Razão Social: </b>" . $row["nome"] . "<br/>
		<b>CPF/CNPJ: </b>" . $row["cpf"] . "<br/>
		<b>Profissão: </b>" . $row["id_tipo_parceiro"] . "<br/>
		<b>Tipo: </b>" . $row["id_tipo_pessoa"] . "<br/>
		<b>Data Nascimento: </b>" . formata_data_exibicao2($row["data_aniversario"]) . "<br/>
		</td>
		
		<td class='hidden-xs hidden-sm'>" . $row["id_parceiros"] . "</td>
		<td class='hidden-xs hidden-sm'>" . ($row["nome"]) . "</td>
		<td class='hidden-xs hidden-sm'>" . ($row["cpf"]) ."</td> 
		<td class='hidden-xs hidden-sm'>" . ($row["id_tipo_parceiro"]) ."</td>
		<td class='hidden-xs hidden-sm'>" . ($row["id_tipo_pessoa"]) ."</td>
		<td class='hidden-xs hidden-sm'>" . formata_data_exibicao2($row["data_aniversario"]) . "</td>
		
		
		<td class='text-right'>
		<a class='btn btn-primary' title='Editar Parceiro' onclick='EditarParceiro(" . $row["id_parceiros"] . ")'><span class='glyphicon glyphicon glyphicon-edit'></span></a>
		<a class='btn btn-danger' title='Excluir Parceiro' onclick='Excluir(" . $row["id_parceiros"] .",\"". $row["cpf"] . "\",\"" . ($row["cnpj"]!=null?$row["cnpj"]:"") . "\")'><span class='glyphicon glyphicon glyphicon-trash'></span></a>
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
		<div id="ModalEdit" class="modal fade" role="dialog">
		<div class="modal-dialog ">
		<!-- Modal content-->
		<div class="modal-content">
		<div class="modal-header" style="background-color: #00091a; color:white; border-radius:5px 5px 0px 0px;">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Edição de Usuário</h4>
		</div>
		<div class="modal-body">
		<div class="row">
		<div class="form-group form-group-sm form-group-xs col-xs-3 col-sm-3">
		<label class="control-label">Id</label>
		<input class="form-control" id="eId" name="eId" disabled />
		</div>
		<div class="form-group form-group-sm form-group-xs col-xs-9 col-sm-9">
		<label class="control-label">Nome</label>
		<input class="form-control" id="eNome" name="eNome" />
		</div>
		</div>
		<div class="row">
		<div class="form-group form-group-sm form-group-xs col-xs-6 col-sm-6">
		<label class="control-label">Telefone</label>
		<input type="telefone" required class="form-control" id="eTelefone" name="eTelefone" />
		</div>
		<div class="form-group form-group-sm form-group-xs col-xs-6 col-sm-6">
		<label class="control-label">Usuário</label>
		<input type="email" required class="form-control" id="eEmail" name="eEmail" />
		</div>
		<div class="form-group form-group-sm form-group-xs col-xs-6 col-sm-6">
		<label class="control-label">Senha</label>
		<input class="form-control" type="password" id="eSenha" name="eSenha" />
		</div>
		</div>
		<div class="row">
		<div class="form-group form-group-sm form-group-xs col-xs-12 col-sm-12">
		<label class="control-label">Grupo de Permissão</label>
		<select class="form-control" id="ePermissao" name="ePermissao">
		<option value="1">Administrador</option>
		<option value="3">Operador</option>
		</select>
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
		<button type="button" class="btn btn-success" onclick="GravarUsuario()">Gravar</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
		</div>
		</div>
		</div>
		</div>
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
		<input name="CPFExclude" id="CPFExclude" style="display:none"/>
		<input name="CNPJExclude" id="CNPJExclude" style="display:none"/>
		<h4>Deseja realmente excluir este usuário?</h4>
		</div>
		</div>
		</div>
		<div class="modal-footer" style="background-color: #00091a; border-radius:0px 0px 5px 5px;">
		<button type="button" class="btn btn-success" onclick="ExcluirParceiro()">Excluir</button>
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
		</body>
		</html>		