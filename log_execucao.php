<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	
	$TituloPage = "Log de Execução";
	date_default_timezone_set('PR');
	
	try {
		if (isset($_POST["DataInicial"])) {
			if (empty($_POST["DataInicial"]))
			$erro = "É necessário definir a Data Inicial";
			
			else {
				$DataInicial = mysqli_real_escape_string($conn, $_POST["DataInicial"]);
				$DataFinal = mysqli_real_escape_string($conn, $_POST["DataFinal"]);
				$IsConected  = mysqli_real_escape_string($conn, $_POST["IsConected"]);
				$Ordem  = mysqli_real_escape_string($conn, $_POST["Ordem"]);
				
				$dti = formata_data_mysql($DataInicial);
				$dtf = formata_data_mysql($DataFinal);
				//echo "<script>alert('".$$dt."')</script>";
			}
			} else {
			$DataInicial = date('d/m/Y 00:00');
			$DataFinal = date('d/m/Y 23:59');
			$IsConected  = 0;
			$Ordem  = 0;
			
			$dti = formata_data_mysql($DataInicial);
			$dtf = formata_data_mysql($DataFinal);
		}
		
		$sql = "SELECT * FROM LogBalanca WHERE DataCadastro>='" . $dti . "' && DataCadastro<='" . $dtf . "' ";
		if($IsConected==1)
		$sql = $sql." AND Valor<>'conected 1;' ";
	
	if($Ordem==1)
	$sql = $sql." ORDER By Id DESC ";
	
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
	<meta name="author" content="Douglas Chiodi - GVD Soluções Inteligentes">
	<link rel="icon" href="imagens/favicon.ico">
	<title><?= $TituloPage ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	
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
	</script>
	
	<body>
	
	<?php include 'menu.php'; ?>
	
	<div class="container ">
	<form id="FormLog" action="<?= $_SERVER["PHP_SELF"] ?>" method="POST">
	<div class="row">
	<div class="col-sm-12 form-group-sm">
	<div class="panel panel-default">
	<div class="panel-heading">
	<div class="panel-title">
	Dados de Pesquisa
	</div>
	</div>
	<div class="panel-body">
	<div class="row">
	<div class="col-sm-3 form-group form-group-sm">
	<label class="control-label">Data Inicial</label>
	<div class="input-group date form_datetime col-md-12">
	<input class="form-control" size="16" name="DataInicial" id="DataInicial" type="text" value="<?= $DataInicial ?>" readonly>
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
	</div>
	
	<div class="col-sm-3 form-group form-group-sm">
	<label class="control-label">Data Final</label>
	<div class="input-group date form_datetime col-md-12">
	<input class="form-control" size="16" name="DataFinal" id="DataFinal" type="text" value="<?= $DataFinal ?>" readonly>
	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
	<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
	</div>
	</div>
	
	<div class="col-sm-2 form-group form-group-sm">
	<label class="control-label">Amostras</label>
	<select class="form-control" name="IsConected" id="IsConected">
	<option value="0" <?= ($IsConected == '0') ? 'selected' : '' ?>>Trazer Tudo</option>
	<option value="1" <?= ($IsConected == '1') ? 'selected' : '' ?>>Descartar Conected</option>
	</select>
	</div>
	
	<div class="col-sm-2 form-group form-group-sm">
	<label class="control-label">Ordem</label>
	<select class="form-control" name="Ordem" id="Ordem">
	<option value="0" <?= ($Ordem == '0') ? 'selected' : '' ?>>Crecente</option>
	<option value="1" <?= ($Ordem == '1') ? 'selected' : '' ?>>Decrecente</option>
	</select>
	</div>
	
	
	<div class="col-sm-2 form-group form-group-sm">
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
	<div class="row">
	<div class="col-sm-12 form-group-sm">
	<table class="table table-condensed table-striped table-bordered">
	<thead>
	<tr>
	<th>Id</th>
	<th>Valor</th>
	<th>Data</th>
	</tr>
	</thead>
	<tbody>
	<?php
	if ($result->num_rows > 0) {
	for ($i = 0; $i < $result->num_rows; $i++) {
	$row = $result->fetch_assoc();
	echo "<tr><td nowrap>" . $row["Id"] . "</td><td>" . $row["Valor"] . "</td><td nowrap>" . $row["DataCadastro"] . "</td></tr>";
	}
	}
	?>
	</tbody>
	</table>
	
	</div>
	
	</div>
	
	</form>
	</div>
	</body>
	
	</html>	