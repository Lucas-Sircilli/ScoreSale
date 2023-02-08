<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	
	$TituloPage = "Pontuações"; 
	date_default_timezone_set('america/sao_paulo');
	/* echo '<pre>';
		var_dump($_SESSION);
	echo '</pre>';*/
	
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
		/* (pr.cnpj='' OR pr.cpf='') */
		if($_SESSION['usuarioNiveisAcessoId']=="3")
		{
			$sql = "SELECT id_pontuacoes, CAST(pontuacoes AS UNSIGNED) pontuacoes, pt.nome, emp.razao_social, fase_obra, ob.endereco, pt.created , ob.nome 'nome_obra'
			FROM pontuacoes pt 
			LEFT JOIN parceiros pr ON pt.id_parceiros=pr.id_parceiros 
			LEFT JOIN empresas emp ON pt.id_empresas=emp.id_empresas 
			LEFT JOIN obras ob ON pt.id_obras=ob.id_obras 
		WHERE (pr.cnpj='". $_SESSION['usuarioEmail'] ."' OR pr.cpf='". $_SESSION['usuarioEmail'] ."') AND (YEAR(pt.created) = 2023)";
		
		if ($nome != "" && $nome != null)
		$sql = $sql . " AND pt.nome like'%" . $nome . "%'";
		if ($Ordem == 1)
		$sql = $sql . " ORDER By id_pontuacoes DESC ";
		else $sql = $sql . " ORDER By id_pontuacoes ASC ";
		}      
		else if($_SESSION['usuarioNiveisAcessoId']=="2")
		{
		$sql = "SELECT id_pontuacoes, CAST(pontuacoes AS UNSIGNED) pontuacoes, pt.nome, pr.razao_social, fase_obra, ob.endereco, pt.created , ob.nome 'nome_obra'
		FROM pontuacoes pt LEFT JOIN parceiros pr ON pt.id_parceiros=pr.id_parceiros 
		LEFT JOIN empresas emp ON pt.id_empresas=emp.id_empresas 
		LEFT JOIN obras ob ON pt.id_obras=ob.id_obras 
		WHERE emp.cnpj='". $_SESSION['usuarioEmail'] ."'";
		
		if ($nome != "" && $nome != null)
		$sql = $sql . " AND pt.nome like'%" . $nome . "%'";
		if ($Ordem == 1)
		$sql = $sql . " ORDER By id_pontuacoes DESC ";
		else $sql = $sql . " ORDER By id_pontuacoes ASC ";
		}
		else{
		//$sql = "SELECT * FROM pontuacoes";
		$sql = "SELECT id_pontuacoes, CAST(pontuacoes AS UNSIGNED) pontuacoes, pt.nome, emp.razao_social, fase_obra, ob.endereco, pt.created, ob.nome 'nome_obra'
		FROM pontuacoes pt 
		LEFT JOIN parceiros pr ON pt.id_parceiros=pr.id_parceiros 
		LEFT JOIN empresas emp ON pt.id_empresas=emp.id_empresas 
		LEFT JOIN obras ob ON pt.id_obras=ob.id_obras ";
		//WHERE pr.cnpj='". $_SESSION['usuarioEmail'] ."' OR pr.cpf='". $_SESSION['usuarioEmail'] ."'";
		
		if ($nome != "" && $nome != null)
		$sql = $sql . " WHERE pt.nome like'%" . $nome . "%'";
		if ($Ordem == 1)
		$sql = $sql . " ORDER By id_pontuacoes DESC ";
		else $sql = $sql . " ORDER By id_pontuacoes ASC ";
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
		CarregaLoader();
		$("#FormLog").submit();
		};
		
		function Editar(id) {
		$("#eError").text("");
		$("#eSucesso").text("");
		$.ajax({
		type: "POST",
		url: 'pontuacoesQuery.php',
		data: {
		IdUsuario: id,
		},
		success: function(html) {
		var ob = JSON.parse(html)
		console.log(ob)
		$("#eId").val(); 
		$("#eEmpresas").children("option:selected").val();
		$("#eVendedor").children("option:selected").val();
		$("#eParceiros").children("option:selected").val();
		dataU.Obra
		$("#eFase").children("option:selected")[0].innerText;
		$("#eValor").val(ob.valorcompra);
		$("#ePolo").val(ob.pontuacoes);
		$("#ModalEdit").modal("show");
		},
		error: function(xhr, ajaxOptions, thrownError) {
		alert(thrownError);
		}
		
		});
		return;
		};
		
		function Excluir(id){
		CarregaLoader();
		$("#ModalExcluir").modal("show");
		$("#IdExclude").val(id);
		}
		
		function AdicionarPontuacao(){
		CarregaLoader();
		location.href = "http://localhost/ScoreSale/pontuacoesCRUD.php?id="+0;
		/*$("#ModalEdit").modal("show");
		var w = window.open("http://linkteste.com.br/pontuacoesCRUD.php?id="+0);
		w.addEventListener("load", function(event) {
		location.reload();
		});*/
		}
		function EditarPontuacao(id) {
		CarregaLoader();
		location.href = "http://localhost/ScoreSale/pontuacoesCRUD.php?id="+id;
        /*  var w = window.open("http://linkteste.com.br/pontuacoesCRUD.php?id="+id);
		w.addEventListener("load", function(event) {
		location.reload();
		});*/
		}    
		
		function GravarUsuario() {
		if ($("#eNome").val() == null || $("#eNome").val() == "")
		$("#eError").text("É necessário preencher o campo nome");
		else if ($("#eEmail").val() == null || $("#eEmail").val() == "")
		$("#eError").text("É necessário preencher o campo email");
		else if ($("#eId").val() == 0 && ($("#eSenha").val() == null || $("#eSenha").val() == ""))
		$("#eError").text("É necessário preencher o campo senha");
		
		var dataU = {};
		dataU.Id = $("#eId").val();
		dataU.Nome = $("#eNome").val();
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
		
		function ExcluirUsuario(){
		
		var dataU = {};
		dataU.Id = $("#IdExclude").val();
		
		$.ajax({
		type: "POST",
		url: 'pontuacoesDelete.php',
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
		<label class="control-label">Nome ou Usuário</label>
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
		<?php 
		$permissao = $_SESSION['usuarioNiveisAcessoId'];
		if($permissao != "3"){
		echo "<div class='form-group form-group-sm form-group-xs col-xs-12 col-sm-12'>
		<a class='btn btn-primary' onclick='AdicionarPontuacao()' title='Adicionar Parceiro'>Adicionar Pontuação</span></a>
		</div>";} ?>
		</div>
		<div class="row">
		<div class="col-sm-12 col-xs-12 form-group-xs form-group-sm">
		<table class="table table-condensed table-striped" style="width: -webkit-fill-available">
		<thead>
		<tr>
		<th class="hidden-md hidden-lg"></th>
		<th class="hidden-xs hidden-sm">Id</th>
		<th class="hidden-xs hidden-sm">Polos</th>
		<th class="hidden-xs hidden-sm">Nome</th>
		<th class="hidden-xs hidden-sm">Empresa</th>
		<th class="hidden-xs hidden-sm">Fase da Obra</th>
		<th class="hidden-xs hidden-sm">Endereço da Obra</th>
		<th class="hidden-xs hidden-sm">Data</th>
		<th></th>
		</tr>
		</thead>
		<tbody>
		<?php
		if ($result->num_rows > 0) {
		for ($i = 0; $i < $result->num_rows; $i++) {
		$row = $result->fetch_assoc();
		/*$sql1 = "SELECT * FROM parceiros WHERE id_parceiros=".$row["id_parceiros"];
		$stmt1 = $conn->prepare($sql1); //
		$stmt1->execute();
		$result1 = $stmt1->get_result();
		$row1 = $result1->fetch_assoc();
		$sql2 = "SELECT * FROM empresas WHERE id_empresas=".$row["id_empresas"];
		$stmt2 = $conn->prepare($sql2); //
		$stmt2->execute();
		$result2 = $stmt2->get_result();
		$row2 = $result2->fetch_assoc();
		$sql3 = "SELECT * FROM obras WHERE id_obras=".$row["id_obras"];
		$stmt3 = $conn->prepare($sql3); //
		$stmt3->execute();
		$result3 = $stmt3->get_result();
		$row3 = $result3->fetch_assoc();
		$permissao = $_SESSION['usuarioNiveisAcessoId'];*/
		if($permissao == "3"){
		echo "<tr>
		<td class='hidden-md hidden-lg'>
		<b>Id: </b>" . $row["id_pontuacoes"] . "<br/>
		<b>Polos: </b>" . $row["pontuacoes"] . "<br/>
		<b>Nome: </b>" . $row["nome"] . "<br/>
		<b>Empresa: </b>" . $row["razao_social"] . "<br/>
		<b>Fase da Obra: </b>" . $row["fase_obra"] . "<br/>
		<b>Endereço da Obra: </b>" . $row["endereco"] . "<br/>
		<b>Data: </b>" . formata_data_exibicao2($row["created"]) . "<br/>
		</td>
		
		<td class='hidden-xs hidden-sm'>" . $row["id_pontuacoes"] . "</td>
		<td class='hidden-xs hidden-sm'>" . ($row["pontuacoes"]) . "</td>
		<td class='hidden-xs hidden-sm'>" . $row["nome"] . "</td>
		<td class='hidden-xs hidden-sm'>" . $row["razao_social"] . "</td>
		<td class='hidden-xs hidden-sm'>" . ($row["fase_obra"]) . "</td>
		<td class='hidden-xs hidden-sm'>" . $row["nome_obra"].'<br/><small>'.$row["endereco"] . "</small></td>
		<td class='hidden-xs hidden-sm'>" .  formata_data_exibicao2($row["created"]) . "</td>
		</tr>";
		}
		else
		echo "<tr>
		<td class='hidden-md hidden-lg'>
		<b>Id: </b>" . $row["id_pontuacoes"] . "<br/>
		<b>Polos: </b>" . $row["pontuacoes"] . "<br/>
		<b>Nome: </b>" . $row["nome"] . "<br/>
		<b>Empresa: </b>" . $row["razao_social"] . "<br/>
		<b>Fase da Obra: </b>" . $row["fase_obra"] . "<br/>
		<b>Endereço da Obra: </b>" . $row["endereco"] . "<br/>
		<b>Data: </b>" . formata_data_exibicao2($row["created"]) . "<br/>
		</td>
		
		<td class='hidden-xs hidden-sm'>" . $row["id_pontuacoes"] . "</td>
		<td class='hidden-xs hidden-sm'>" . ($row["pontuacoes"]) . "</td>
		<td class='hidden-xs hidden-sm'>" . $row["nome"] . "</td>
		<td class='hidden-xs hidden-sm'>" . $row["razao_social"] . "</td>
		<td class='hidden-xs hidden-sm'>" . ($row["fase_obra"]) . "</td>
		<td class='hidden-xs hidden-sm'>" . $row["endereco"]."<br/></td>									
		<td class='text-center' >" .  formata_data_exibicao2($row["created"]) . "</td>
		<td class='text-right' nowrap>
		<a class='btn btn-primary' title='Editar Pontuação' onclick='EditarPontuacao(" . $row["id_pontuacoes"] . ")'><span class='glyphicon glyphicon glyphicon-edit'></span></a>
		<a class='btn btn-danger' title='Excluir Pontuação' onclick='Excluir(" . $row["id_pontuacoes"] . ")'><span class='glyphicon glyphicon glyphicon-trash'></span></a>
		</td>						
		</tr>";
		
		}
		}
		?>
		</tbody>
		</table>
		<div class="row">&nbsp;</div>
		<div class="row">&nbsp;</div>
		<br>
		</div>
		</div>
		</div>
		<div id="ModalEdit" class="modal fade" role="dialog">
		<div class="modal-dialog ">
		<!-- Modal content-->
		<div class="modal-content">
		<div class="modal-header" style="background-color: #00091a; color:white; border-radius:5px 5px 0px 0px;">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Edição de Pontuação</h4>
		</div>
		<div class="modal-body">
		<div class="row">
		<div class="form-group form-group-sm form-group-xs col-xs-3 col-sm-3">
		<label class="control-label">Id</label>
		<input class="form-control" id="eId" name="eId" disabled />
		</div>
		<div class="col-sm-9 col-xs-9 form-group form-group-sm form-group-xs">
		<label class="control-label">Empresas</label>
		<select class="form-control" name="eEmpresas" id="eEmpresas">
		<?php
		$sql = "SELECT * FROM empresas";
		$stmt = $conn->prepare($sql); //
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
		for ($i = 0; $i < $result->num_rows; $i++) {
		$row = $result->fetch_assoc();
		
		echo "<option value='".$row["id_empresas"]."'>".$row["razao_social"]."</option>";
		}} ?>
		</select>
		</div>
		</div>
		<div class="row">
		<div class="form-group form-group-sm form-group-xs col-xs-3 col-sm-3">
		<label class="control-label">Vendedores</label>
		<input type="email" required class="form-control" id="eEmail" name="eEmail" />
		</div>
		<div class="col-sm-9 col-xs-9 form-group form-group-sm form-group-xs">
		<label class="control-label">Empresas</label>
		<select class="form-control" name="Empresas" id="Empresas">
		<?php
		$sql = "SELECT * FROM vendedores WHERE id_empresas='" . $id . "'";
		$stmt = $conn->prepare($sql); //
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
		for ($i = 0; $i < $result->num_rows; $i++) {
		$row = $result->fetch_assoc();
		echo "<option value='".$i."'>".$row["razao_social"]."</option>";
		}} ?>
		</select>
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
		<h4>Deseja realmente excluir este usuário?</h4>
		</div>
		</div>
		</div>
		<div class="modal-footer" style="background-color: #00091a; border-radius:0px 0px 5px 5px;">
		<button type="button" class="btn btn-success" onclick="ExcluirUsuario()">Excluir</button>
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