<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	
	$TituloPage = "Relatório de Acessos";
	date_default_timezone_set('america/sao_paulo');
	
	try {
		if (isset($_POST["Nome"])) {
			
			$Ordem  = mysqli_real_escape_string($conn, $_POST["Ordem"]);
			$nome = mysqli_real_escape_string($conn, $_POST["Nome"]);
			$eSala = mysqli_real_escape_string($conn, $_POST["eSala"]);
			$DataInicial = mysqli_real_escape_string($conn, $_POST["DataInicial"]);
			$DataFinal = mysqli_real_escape_string($conn, $_POST["DataFinal"]);	
			//echo "<script>alert('".$$dt."')</script>";
			
			} else {
			$DataInicial = date('d/m/Y 00:00');
			$DataFinal = date('d/m/Y 23:59');
			
			$Ordem  = 0;
			$eSala = '';
			$nome = "";
			
		}
		
		$dti = formata_data_mysql($DataInicial);
		$dtf = formata_data_mysql($DataFinal);
		
		$sql = "SELECT * FROM acessos WHERE ";
		if ($nome != "" && $nome != null)
		$sql = $sql . " (IpAcesso like '%" . $nome . "%' OR EventoAcesso like '%" . $nome . "%') AND ";
		if($eSala!=null && $eSala!='')
   		$sql = $sql . " SalaAcesso like '%" . $eSala . "%' AND ";
		
		$sql = $sql . " DataInicio>='" . $dti . "' && DataInicio<='" . $dtf . "'";
		
		if ($Ordem == 1)
	$sql = $sql . " ORDER By DataInicio DESC ";
	
	$stmt = $conn->prepare($sql); //
	$stmt->execute();
	$result = $stmt->get_result();
	
	$sql2 = "SELECT * FROM salas";
	$stmt = $conn->prepare($sql2); //
	$stmt->execute();
	$resultSala = $stmt->get_result();
	} catch (Exception $e) {
	$erro = $e->getMessage();
	}
	
	?>
	<!DOCTYPE html>
	<html lang="pt-br">
	<head>
	<meta name="author" content="Lucas Pereira Lima Sircilli">
	<link rel="icon" href="./imagens/logo-teste-ico-azulclaro.png">
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
	
	function ValidateEmail(mail) {
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
	return (true)
	}
	
	return (false)
	}
	
	function exportarCSV(){
	
	$.ajax({
	url : "AcessosQuery.php", 
	type: 'POST',
	data: {
	Ordem: $("#Ordem").val(),
	Nome: $("#Nome").val(),
	DataInicial: $("#DataInicial").val(),
	DataFinal: $("#DataFinal").val()
	},
	success: function(data){
	
	/*
	* Make CSV downloadable
	*/
	var downloadLink = document.createElement("a");
	var fileData = [data];
	
	var blobObject = new Blob(fileData,{
	type: "text/csv;charset=utf-8;"
	});
	
	var url = URL.createObjectURL(blobObject);
	downloadLink.href = url;
	downloadLink.download = "Acessos.csv";
	
	/*
	* Actually download CSV
	*/
	document.body.appendChild(downloadLink);
	downloadLink.click();
	document.body.removeChild(downloadLink);
	
	}
	});
	}
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
	<div class="col-sm-4 col-xs-4 form-group form-group-sm">
	<label class="control-label">Nome</label>
	<input class="form-control" name="Nome" id="Nome"></input>
	</div>
	<div class="form-group form-group-sm col-sm-4 col-xs-4">
	<label class="control-label">Sala</label>
	<select name="eSala" id="eSala" class="form-control">
	<option value="">Todas as salas</option>
	<?php
	if ($resultSala->num_rows > 0) {
	for ($i = 0; $i < $resultSala->num_rows; $i++) {
	$row = $resultSala->fetch_assoc();
	$selected = '';
	if($eSala==$row["nome"])
	$selected = 'selected';
	
	echo "<tr>
	<option value='" . $row["nome"] . "' ".$selected .">". ($row["nome"])." - ".($row["usuario"]) . "</option>";
	}
	}
	?>
	</select>
	</div>
	<div class="col-sm-2 col-xs-2 form-group form-group-sm">
	<label class="control-label">Ordem</label>
	<select class="form-control" name="Ordem" id="Ordem">
	<option value="0" <?= ($Ordem == '0') ? 'selected' : '' ?>>Crescente</option>
	<option value="1" <?= ($Ordem == '1') ? 'selected' : '' ?>>Decrecente</option>
	</select>
	</div>
	<div class="col-sm-3 col-xs-3 form-group form-group-sm">
	<label class="control-label">Data Inicial</label>
	<div class="input-group date form_datetime col-md-12">
	<input class="form-control" size="16" name="DataInicial" id="DataInicial" type="text" value="<?= $DataInicial ?>" readonly>
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
	</div>
	<div class="col-sm-3 col-xs-3 form-group form-group-sm">
	<label class="control-label">Data Final</label>
	<div class="input-group date form_datetime col-md-12">
	<input class="form-control" size="16" name="DataFinal" id="DataFinal" type="text" value="<?= $DataFinal ?>" readonly>
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
	</div>
	</div>
	<div class="row">
	<div class="col-sm-8 col-xs-8 form-group form-group-sm"></div>
	<div class="col-sm-2 col-xs-8 form-group form-group-sm text-right">
	<label class="control-label">&nbsp;&nbsp; </label>
	<a class="form-control botoes btn btn-primary" onclick="exportarCSV();">Exportar CSV</a>
	</div>
	<div class="col-sm-2 col-xs-2 form-group form-group-sm text-right">
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
	<div class="col-sm-12 col-xs-12 form-group-sm">
	<table class="table table-condensed table-striped ">
	<thead>
	<tr>
	<th>Endereço</th>
	<th>Sala</th>
	<th>Evento</th>
	<th>Data Início</th>
	<th>Data Fim</th>
	</tr>
	</thead>
	<tbody>
	<?php
	if ($result->num_rows > 0) {
	for ($i = 0; $i < $result->num_rows; $i++) {
	$row = $result->fetch_assoc();
	echo "<tr>
	<td nowrap>" . $row["IpAcesso"] . "</td>
	<td nowrap>" . ($row["SalaAcesso"]) . "</td>  
	<td nowrap>" . ($row["EventoAcesso"]) . "</td>
	<td nowrap>" . formata_data_exibicao($row["DataInicio"]) . "</td>
	<td nowrap>" . formata_data_exibicao($row["DataFim"]) . "</td>
	
	</tr>";
	}
	}
	?>
	</tbody>
	</table>
	</div>
	</div>
	</div>
	<div id="ModalEdit" class="modal fade" role="dialog">
	<div class="modal-dialog ">
	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header" style="background-color: #00091a; color:white; border-radius:5px 5px 0px 0px;">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Edição de Sala</h4>
	</div>
	<div class="modal-body">
	<div class="row">
	<div class="form-group form-group-sm col-sm-3 col-xs-3">
	<label class="control-label">Id</label>
	<input class="form-control" id="eId" name="eId" disabled />
	</div>
	<div class="form-group form-group-sm col-sm-9 col-xs-9">
	<label class="control-label">Nome</label>
	<input class="form-control" id="eNome" name="eNome" />
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-12 col-xs-2">
	<label class="control-label">URL da Câmera</label>
	<input type="text" class="form-control" id="eUrl" name="eUrl" onchange="urlAlterada();" />
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-6 col-xs-6">
	<label class="control-label">Usuário</label>
	<input type="text" class="form-control" id="eUsuario" name="eUsuario">
	</div>
	<div class="form-group form-group-sm col-sm-6 col-xs-6">
	<label class="control-label">Vídeo</label>
	<!--<img style='-webkit-user-select: none;margin: auto;width: 100%;' id="uVideo" name="uVideo" src="" />-->
	<iframe style='-webkit-user-select: none;margin: auto;width:100%;' id="uVideo" name="uVideo" src='' frameborder='0' allowfullscreen></iframe>
	</div>
	</div>
	<div class="row">
	<div class="form-group form-group-sm col-sm-12 col-xs-12">
	<span id="eError" name="eError" style="color:firebrick"></span>
	<span id="eSucesso" name="eSucesso" style="color:green"></span>
	</div>
	</div>
	</div>
	<div class="modal-footer" style="background-color: #00091a; border-radius:0px 0px 5px 5px;">
	<button type="button" class="btn btn-success" onclick="GravarSala()">Gravar</button>
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
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Atenção</h4>
	</div>
	<div class="modal-body">
	<div class="row">
	<div class="form-group form-group-sm col-xs-12 col-sm-12">
	<input name="IdExclude" id="IdExclude" style="display:none"/>
	<h4>Deseja realmente excluir esta sala?</h4>
	</div>
	</div>
	</div>
	<div class="modal-footer" style="background-color: #00091a; border-radius:0px 0px 5px 5px;">
	<button type="button" class="btn btn-success" onclick="ExcluirSala()">Excluir</button>
	<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	</div>
	</div>
	</div>
	</div>
	<footer class="container-fluid text-center" style="background-color:#091742;position: fixed;bottom: 0px!important;width: 100vw;">
	<div class="row">
	<div class="col-sm-6 col-xs-6 text-left"><img src="./imagens/Logo-Teste-Login.png" style="height:3vh;margin:10px"/></div>
	<div class="col-sm-6 col-xs-6 text-right"><a href=""><img src="./imagens/logo-branca.png" style="height:3vh;margin:10px"/></a></div>
	</div>
	</div>
	</footer>
	</body>
	</html>							