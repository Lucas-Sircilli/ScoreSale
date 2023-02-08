<?php
	include_once("funcoes.php");
	include_once("conexao.php");
	
	/* echo '<pre>';
		var_dump($_SESSION);
	echo '</pre>';*/
	$TituloPage = "Cadastro de Pontuações";
	date_default_timezone_set('america/sao_paulo');
	
	try {
		if (isset($_GET["id"])){
			$id = $_GET["id"];
		}
		else
		$id = 0;
		
		/// Consulta empresas  ////
		$sql = "SELECT * FROM pontuacoes";
		if ($id != "" && $id != null){           
			$sql = $sql . " WHERE id_pontuacoes='" . $id . "'";
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
			$row["id_pontuacoes"] = 0;           
		}
		
		
		
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
		$("#eCEPObra").bind('blur', function(e){
		ConsultaCEPObra(); 
		});
		BuscaVendedor();
		BuscaObra();
		BuscaPromocao();
		// Number
		});
		
		function SubmeterForm() {
		CarregaLoader();
		$("#FormLog").submit();
		};
		
		function ConsultaCEPObra(){
		
		var CEP = $("#eCEPObra").val().replace("-","");
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
		
		$("#eBairroObra").val(json.bairro);
		$("#eCidadeObra").val(json.localidade);
		$("#eEnderecoObra").val(json.logradouro);    
		$("#eEstadoObra").val(json.uf);    
		
		},
		error: function(xhr, ajaxOptions, thrownError) {
		alert(thrownError);
		}
		
		});
		
		}
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
		return string.replace(/\D/g,'').substring(0,8);
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
		
		function EditarObra(id){
		
		$("#eError1").text("");
		$("#eSucesso1").text("");
		$.ajax({
		type: "POST",
		url: 'obrasQuery.php',
		data: {
		Idobra: id,
		},
		success: function(html) {
		var ob = JSON.parse(html)
		console.log(ob)
		
		$("#eIdObra").val(ob.id_obras);
		$("#eNomeObra").val(ob.nome);
		// $("#eCategoriaObra").val(ob.categoria);
		
		if(ob.categoria =='Residencial')
		$("#eCategoriaObra").val('Residencial');
		else if(ob.categoria =='Comercial')
		$("#eCategoriaObra").val('Comercial');
		else if(ob.categoria =='Obra')
		$("#eCategoriaObra").val('Obra');
		
		if(ob.situacao =='Nova Obra')
		$("#eSituacaoObra").val('Nova');
		else if(ob.situacao =='Reforma')
		$("#eSituacaoObra").val('Reforma');
		$("#eTipoEnderecoObra").val(ob.tipo_endereco);
		/*var childrenLenght = document.getElementById("eFasesObra").childElementCount - 1;
		for(i=0; i <= childrenLenght; i++){
		
		if(document.getElementById("eFasesObra").children[i].innerText == ob.fase_obra){
		
		$("#eFasesObra").val(i);
		i = childrenLenght;
		}
		}*/
		
		$("#eProfissionalObra").val(ob.profissional);
		$("#eIdParceirosObra").val(ob.id_parceiros);
		$("#eCEPObra").val(ob.cep);
		$("#eEnderecoObra").val(ob.endereco);
		$("#eNumeroObra").val(ob.numero);
		$("#eBairroObra").val(ob.bairro);
		$("#eCidadeObra").val(ob.cidade);
		$("#eComplementoObra").val(ob.complemento);
		$("#eEstadoObra").val(ob.estado);
		/* if(ob.situacao =='Nova Obra')
		$("#eSituacaoObra").val(0);
		else if(ob.situacao =='Reforma')
		$("#eSituacaoObra").val(1);
		if(ob.estado =='Acre')
		$("#eEstadoObra").val(0);
		else if(ob.estado =='Alagoas')
		$("#eEstadoObra").val(1);
		else if(ob.estado =='Amapá')
		$("#eEstadoObra").val(2);
		else if(ob.estado =='Amazonas')
		$("#eEstadoObra").val(3);
		else if(ob.estado =='Bahia')
		$("#eEstadoObra").val(4);
		else if(ob.estado =='Ceará')
		$("#eEstadoObra").val(5);
		else if(ob.estado =='Distrito Federal')
		$("#eEstadoObra").val(6);
		else if(ob.estado =='Espírito Santo')
		$("#eEstadoObra").val(7);
		else if(ob.estado =='Goiás')
		$("#eEstadoObra").val(8);
		else if(ob.estado =='Maranhão')
		$("#eEstadoObra").val(9);
		else if(ob.estado =='Mato Grosso')
		$("#eEstadoObra").val(10);
		else if(ob.estado =='Mato Grosso do Sul')
		$("#eEstadoObra").val(11);
		else if(ob.estado =='Minas Gerais')
		$("#eEstadoObra").val(12);
		else if(ob.estado =='Pará')
		$("#eEstadoObra").val(13);
		else if(ob.estado =='Paraíba')
		$("#eEstadoObra").val(14);
		else if(ob.estado =='Paraná')
		$("#eEstadoObra").val(15);
		else if(ob.estado =='Pernambuco')
		$("#eEstadoObra").val(16);
		else if(ob.estado =='Piauí')
		$("#eEstadoObra").val(17);
		else if(ob.estado =='Rio de Janeiro')
		$("#eEstadoObra").val(18);
		else if(ob.estado =='Rio Grande do Norte')
		$("#eEstadoObra").val(19);
		else if(ob.estado =='Rio Grande do Sul')
		$("#eEstadoObra").val(20);
		else if(ob.estado =='Rondônia')
		$("#eEstadoObra").val(21);
		else if(ob.estado =='Roraima')
		$("#eEstadoObra").val(22);
		else if(ob.estado =='Santa Catarina')
		$("#eEstadoObra").val(23);
		else if(ob.estado =='São Paulo')
		$("#eEstadoObra").val(24);
		else if(ob.estado =='Sergipe')
		$("#eEstadoObra").val(25);
		else if(ob.estado =='Tocantins')
		$("#eEstadoObra").val(26);
		else if(ob.estado =='Estrangeiro')
		$("#eEstadoObra").val(27);*/
		
		
		
		/*if(ob.tipo_endereco =='Comercial')
		$("#eTipoEnderecoObra").val(0);
		else if(ob.tipo_endereco =='Residencial')
		$("#eTipoEnderecoObra").val(1);*/
		
		
		
		//	$("#ePermissao").val(ob.niveis_acesso_id);
		//    $("#eSenha").val("");
		$("#ModalEdit").modal("show");
		},
		error: function(xhr, ajaxOptions, thrownError) {
		alert(thrownError);
		}
		
		});
		return;
		
		}
		
		
		function GravarObra(){
		$("#eError1").text("");
		$("#eSucesso1").text("");
		var dataU = {};
		if ($("#eNomeObra").val() == null || $("#eNomeObra").val() == "")
		$("#eError1").text("É necessário preencher o campo de Nome");
		
		if ($("#eCategoriaObra").children("option:selected").val() == null || $("#eCategoriaObra").children("option:selected").val() == "")
		$("#eError1").text("É necessário selecionar o campo de Categoria");  
		
		if ($("#eSituacaoObra").children("option:selected").val() == null || $("#eSituacaoObra").children("option:selected").val() == "")
		$("#eError1").text("É necessário selecionar o campo de Situação da obra");
		if ($("#eProfissionalObra").val() == null || $("#eProfissionalObra").val() == "")
		$("#eError1").text("É necessário preencher o campo de Profissional");
		if ($("#eCEPObra").val() == null || $("#eCEPObra").val() == "")
		$("#eError1").text("É necessário preencher o campo de CEP");
		if ($("#eEnderecoObra").val() == null || $("#eEnderecoObra").val() == "")
		$("#eError1").text("É necessário preencher o campo de Logradouro");
		if ($("#eNumeroObra").val() == null || $("#eNumeroObra").val() == "")
		$("#eError1").text("É necessário preencher o campo de Número");
		if ($("#eBairroObra").val() == null || $("#eBairroObra").val() == "")
		$("#eError1").text("É necessário preencher o campo de Bairro");
		if ($("#eCidadeObra").val() == null || $("#eCidadeObra").val() == "")
		$("#eError1").text("É necessário preencher o campo de Cidade");
		
		if ($("#eEstadoObra").children("option:selected").val() == null || $("#eEstadoObra").children("option:selected").val() == "")
		$("#eError1").text("É necessário selecionar o campo de Estado");
		
		if ($("#eTipoEnderecoObra").children("option:selected").val() == null || $("#eTipoEnderecoObra").children("option:selected").val() == "")
		$("#eError1").text("É necessário selecionar o campo de Tipo de Endereço");
		
		dataU.Id =$("#eIdObra").val();
		dataU.IdEmpresa = $('#eEmpresas').children('option:selected').val();
		//dataU.FaseObra =$("#eFasesObra").children("option:selected")[0].innerText;   
		dataU.IdParceiro =$('#eIdParceiroObra').val();
		dataU.Parceiro = $('#eProfissionalObra').val();
		dataU.TipoEndereco = $('#eTipoEnderecoObra').children("option:selected")[0].innerText;
		dataU.Categoria = $('#eCategoriaObra').children("option:selected")[0].innerText;
		dataU.Situacao = $('#eSituacaoObra').children("option:selected")[0].innerText;
		dataU.Estado = $("#eEstadoObra").children("option:selected").val();
		dataU.Nome =  $("#eNomeObra").val();
		dataU.CEP = $("#eCEPObra").val();
		dataU.Endereco = $("#eEnderecoObra").val();
		dataU.Numero = $("#eNumeroObra").val();
		dataU.Bairro = $("#eBairroObra").val();
		dataU.Complemento = $("#eComplementoObra").val();
		dataU.Cidade = $("#eCidadeObra").val();
		
		//dataU.IsvendedorAtivo = $("#eIsvendedorAtivo").children("option:selected")[0].innerText;
		
		if($("#eError1")[0].innerText == null || $("#eError1")[0].innerText == ""){
		$.ajax({
		type: "POST",
		url: 'obrasInsert.php',
		data: dataU,
		success: function(html) {
		if (html.indexOf("sucesso") != -1) {
		$("#eSucesso1").text(html);
		TiraLoader();
		$("#ModalEdit").modal("hide");
		var href =  window.location.href;
		$("#FormLog").submit();
		
		window.location.href = href;
		
		
		
		//window.location.href = "http://linkteste.com.br/empresas.php";
		} else {
		$("#eError1").text(html);
		TiraLoader();
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
		location.href= "http://localhost/ScoreSale/pontuacoes.php";
		// history.back();
		/* window.opener.location.reload();    
		window.close();*/
		}
		function GravarPontuacao() {
		try{
		debugger
		$("#eError").text("");
		$("#eSucesso").text("");
		var dataU = {};
		
		if ($("#eEmpresas").children("option:selected").val() == null || $("#eEmpresas").children("option:selected").val() == "")
		$("#eError").text("É necessário selecionar o campo de Empresas");
		if ($("#eVendedor").children("option:selected").val() == null || $("#eVendedor").children("option:selected").val() == "")
		$("#eError").text("É necessário selecionar o campo de Vendedor");
		if ($("#eParceiros").children("option:selected").val() == null || $("#eParceiros").children("option:selected").val() == "")
		$("#eError").text("É necessário selecionar o campo de Parceiros");
		/*   if ($("#eFase").children("option:selected").val() == null || $("#eFase").children("option:selected").val() == "")
		$("#eError").text("É necessário selecionar o campo de Fase da Obra"); */
		
		/*   if ($("#eObras").children("option:selected").val() == null || $("#eObras").children("option:selected").val() == "")
		$("#eError").text("É necessário selecionar o campo de Obras");*/
		
		dataU.Id = $("#eId").val(); 
		dataU.Empresa = $("#eEmpresas").children("option:selected").val();
		//dataU.Promocao = $("#ePromocoes").children("option:selected").val();
		dataU.Promocao = 0;
		dataU.Vendedor = $("#eVendedor").children("option:selected").val();
		dataU.Parceiro = $("#eParceiros").children("option:selected").val();
		dataU.NomeParceiro = $("#eParceiros").children("option:selected")[0].innerText;
		dataU.DataCadastro = $("#eDataCriacao").val();
		
		var selecionado = false;
		for (var i = 0; i < $("#eObras").children().length; i++){
		
		if(document.getElementById('eObras'+ i)!=null && document.getElementById('eObras'+ i).checked){
		//if($("#eObras"+i+":checked").val()==true){
		selecionado = true;
		try{
		var texto = document.getElementById("eObras").children[i].firstChild.innerText;
		debugger
		var splits = texto.split(" ");
		dataU.Obra = splits[1];
		}
		catch(ex)
		{
		console.log(ex);
		}
		}
		}
		
		if(!selecionado)
		{
		$("#eError").text("É necessário selecionar uma obra para gravar");
		TiraLoader();
		return;
		}
		
		// dataU.Obra = $("#eObras").children("option:selected").val();
		dataU.Fase = $("#eFases").children("option:selected")[0].innerText;
		dataU.Valor =  $("#eValor").val();
		dataU.Polo = $("#ePolo").val();
		
		
		
		
		/*if(!ValidateEmail(dataU.Email)){
		$("#eError").text("Email inválido");
		return;
		}*/
		if($("#eError")[0].innerText == null || $("#eError")[0].innerText == ""){
		$.ajax({
		type: "POST",
		url: 'pontuacaoInsert.php',
		data: dataU,
		success: function(html) {
		if (html.indexOf("sucesso") != -1) {
		CarregaLoader();
		$("#eSucesso").text(html);
		location.href= "http://localhost/ScoreSale/pontuacoes.php";
		//history.back();
		
		/* $("#FormLog").submit();
		window.opener.location.reload();    
		window.close();
		window.location.href = "http://linkteste.com.br/empresas.php";*/
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
		}
		TiraLoader();
		}
		catch(e){
		TiraLoader();
		}
		return;
		}
		
		function AdicionarObra(){
		
		if($("input[name=eProfissionalObra]").val() == ''){
		$("input[name=eProfissionalObra]").val($('#eParceiros').children('option:selected')[0].innerText);
		$('#eIdParceiroObra').val($('#eParceiros').children('option:selected').val());
		
		}
		
		$("#eIdObra").val(0);
		$("#eNomeObra").val("");
		// $("#eCategoriaObra").val("");
		//$("#eSituacaoObra").val("");
		$("#eCEPObra").val("");
		$("#eCidadeObra").val("");
		$("#eComplementoObra").val("");
		$("#eEnderecoObra").val("");
		$("#eNumeroObra").val("");
		$("#eBairroObra").val("");
		$("#eEstadoObra").val("");
		// $("#eTipoEnderecoObra").val("");
		
		
		// $("#eEmail").val("");
		// $("#eSenha").val("");
		$("#eError1").text("");
		$("#eSucesso1").text("");
		$("#ModalEdit").modal("show");
		}
		function removeAll(select) {
		while (select.options.length > 0) {
		select.remove(0);
		}}
		function removeAllObras(radio) {
		
		while (radio.children.length > 0) {
        radio.firstChild.remove();
		}
		
		}
		
		function BuscaObra(){
		
		var dataU = {};
		
		dataU.IdEmpresa = $('#eEmpresas').children('option:selected').val();
		dataU.Id = <?php echo $id;?>;
		dataU.IdParceiro = $('#eParceiros').children('option:selected').val();
		$.ajax({
		type: "POST",
		url: 'buscaObra.php',
		data: dataU,
		success: function(html) {
		var ob = JSON.parse(html)
		console.log(ob)
		
		var opcoes = "";
		
		try{    
		for(var i=0; i < ob.length; i++){
		opcoes += ob[i];
		//$("#eVendedor").html(ob[i]);
		}
		$("#eObras").html(opcoes);
		$("input[name=eProfissionalObra]").val($("#eParceiros").children("option:selected")[0].innerText);
		$('#eIdParceiroObra').val($('#eParceiros').children('option:selected').val());
		}
		catch(e){
		
		if(e.message.includes("Cannot read properties of null (reading 'length'")){
		alert("Não foi possível Encontrar Obras Cadastradas deste Parceiro");
		const radio = document.querySelectorAll("#eObras")[0]; 
		removeAllObras(radio);
		}
		$("input[name=eProfissionalObra]").val($("#eParceiros").children("option:selected")[0].innerText);
		$('#eIdParceiroObra').val($('#eParceiros').children('option:selected').val());
		}
		/*var x = document.getElementById("eVendedor");
		/*var option = document.createElement("option");
		option.value = ob.id_vendedores;
		option.text = ob.nome;*/
		
		
		/* $("#eVendedor").val(ob.nome);
		$("#eNomeVendedor").val(ob.nome);
		$("#eCpfVendedor").val(ob.cpf);
		$("#eRgVendedor").val(ob.rg);*/
		
		
		},
		error: function(xhr, ajaxOptions, thrownError) {
		alert(thrownError);
		}
		
		});
		return;
		}
		function BuscaVendedor(){
		
		var dataU = {};
		
		dataU.Id = <?php echo $id ?>;
		dataU.IdEmpresa = $('#eEmpresas').children('option:selected').val();
		$.ajax({
		type: "POST",
		url: 'buscaVendedor.php',
		data: dataU,
		success: function(html) {
		var ob = JSON.parse(html)
		console.log(ob)
		
		var opcoes = "";
		
		try{
		for(var i=0; i < ob.length; i++){
		opcoes += ob[i];
		//$("#eVendedor").html(ob[i]);
		}
		$("#eVendedor").html(opcoes);
		
		/*var x = document.getElementById("eVendedor");
		/*var option = document.createElement("option");
		option.value = ob.id_vendedores;
		option.text = ob.nome;*/
		
		
		/* $("#eVendedor").val(ob.nome);
		$("#eNomeVendedor").val(ob.nome);
		$("#eCpfVendedor").val(ob.cpf);
		$("#eRgVendedor").val(ob.rg);*/
		
		}
		catch(e){
		if(e.message.includes("Cannot read properties of null (reading 'length'")){
		alert("Não foi possível Encontrar Vendedores Cadastrados nesta Empresa");
		const select = document.querySelector('#eVendedor'); 
		removeAll(select);
		}}
		},
		error: function(xhr, ajaxOptions, thrownError) {
		alert(thrownError);
		}
		
		});
		return;
		}
		function BuscaPromocao(){
		
		var dataU = {};
		
		dataU.Id = <?php echo $id;?>;
		dataU.IdEmpresa = $('#eEmpresas').children('option:selected').val();
		dataU.IdPromocoes = $('#ePromocoes').children('option:selected').val();
		$.ajax({
		type: "POST",
		url: 'buscaPromocao.php',
		data: dataU,
		success: function(html) {
		var ob = JSON.parse(html)
		console.log(ob)
		
		var opcoes = "";
		
		try{
		for(var i=0; i < ob.length; i++){
		opcoes += ob[i];
		//$("#eVendedor").html(ob[i]);
		}
		$("#ePromocoes").html(opcoes);
		
		/*var x = document.getElementById("eVendedor");
		/*var option = document.createElement("option");
		option.value = ob.id_vendedores;
		option.text = ob.nome;*/
		
		
		/* $("#eVendedor").val(ob.nome);
		$("#eNomeVendedor").val(ob.nome);
		$("#eCpfVendedor").val(ob.cpf);
		$("#eRgVendedor").val(ob.rg);*/
		
		}
		catch(e){
		if(e.message.includes("Cannot read properties of null (reading 'length'")){
		alert("Não foi possível Encontrar Promocões Cadastrados nesta Empresa");
		const select = document.querySelector('#ePromocoes'); 
		removeAll(select);
		}}
		},
		error: function(xhr, ajaxOptions, thrownError) {
		alert(thrownError);
		}
		
		});
		return;
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
		}
		
		},
		error: function(xhr, ajaxOptions, thrownError) {
		$("#eError1").text(thrownError);
		}
		
		});
		return;
		}
		function ExcluirObra(){
		
		var dataU = {};
		dataU.Id = $("#IdExclude").val();
		
		$.ajax({
		type: "POST",
		url: 'obrasDelete.php',
		data: dataU,
		success: function(html) {
		if (html.indexOf("sucesso") != -1) {                  
		$("#ModalExcluir").modal("hide");
		var href =  window.location.href;
		$("#FormLog").submit();
		
		window.location.href = href;
		
		} else {
		$("#eError1").text(html);
		}
		
		},
		error: function(xhr, ajaxOptions, thrownError) {
		$("#eError1").text(thrownError);
		}
		
		});
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
		function CalculaPolos(){
		
		const valor = $("#eValor").val();
		var valorfinal = valor/10;
		$("#ePolo").val(parseFloat(valorfinal));
		/* const valorfinal = valor/10;
		$("eValor").val(valorfinal);*/
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
		<div class="container" style="padding-bottom:20px ">
		<div class="row">
		<div class="form-group-sm col-sm-4">
		<div class="collapse navbar-collapse" id="myNavbar">
		<ul class="nav navbar-nav" style="padding-bottom:10px">
		<li>
		<a onclick='GravarPontuacao();' class="btn btn-link"><i class="fa fa-floppy-o" ></i>&nbsp;Gravar</a>
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
		Dados de Pontuação
		</div>
		</div>
		<div class="panel-body">
		<div class="row">
		<div class="form-group form-group-sm col-sm-2">
		<label class="control-label">Id</label>
		<input class="form-control" id="eId" name="eId" value="<?php echo $row["id_pontuacoes"];?>" disabled />
		</div>
		<div class="form-group form-group-sm col-sm-7">
		<label class="control-label">Empresas</label>
		<select class="form-control" id="eEmpresas" name="eEmpresas" onchange="BuscaVendedor();BuscaObra();BuscaPromocao()">
		<?php
		if($_SESSION['usuarioNiveisAcessoId'] == 1){
		$sqlempresa = "SELECT * FROM empresas";
		$stmtempresa = $conn->prepare($sqlempresa); //
		$stmtempresa->execute();
		$resultempresa = $stmtempresa->get_result();
		if ($resultempresa->num_rows > 0) {
		for ($i = 0; $i < $resultempresa->num_rows; $i++) {
		$rowempresa = $resultempresa->fetch_assoc();
		
		
		echo "<option value='".$rowempresa["id_empresas"]."' ".($row["id_empresas"]==$rowempresa["id_empresas"] ? 'selected' : '').">".$rowempresa["razao_social"]."</option>";
		}}}
		if($_SESSION['usuarioNiveisAcessoId'] == 2){
		echo '<pre>';
		var_dump($row["id_empresas"]);
		echo '</pre>';
		$sqlempresa = "SELECT * FROM empresas WHERE cnpj='" . $_SESSION['usuarioEmail'] . "'";
		
		$stmtempresa = $conn->prepare($sqlempresa); //
		$stmtempresa->execute();
		$resultempresa = $stmtempresa->get_result();
		if ($resultempresa->num_rows > 0) {
		for ($i = 0; $i < $resultempresa->num_rows; $i++) {
		$rowempresa = $resultempresa->fetch_assoc();
		
		
		echo "<option value='".$rowempresa["id_empresas"]."' ".($row["id_empresas"]==$rowempresa["id_empresas"] ? 'selected' : '').">".$rowempresa["razao_social"]."</option>";
		}}}        
		?>
		</select>
		</div>
		<div class="form-group form-group-sm col-sm-3">
		<label class="control-label">Vendedores</label>
		<select class="form-control" id="eVendedor" name="eVendedor"></select>
		</div>
		<!-- <div class="form-group form-group-sm col-sm-3">
		<label class="control-label">Promoções</label>
		<select class="form-control" name="ePromocoes"  id="ePromocoes">
		<?php 
		/*$sqlpromocao = "SELECT * FROM promocoes";
		$stmtpromocao = $conn->prepare($sqlpromocao); //
		$stmtpromocao->execute();
		$resultpromocao = $stmtpromocao->get_result();
		if ($resultpromocao->num_rows > 0) {
		for ($i = 0; $i < $resultpromocao->num_rows; $i++) {
		$rowpromocao = $resultpromocao->fetch_assoc();
		
		
		echo "<option value='".$rowpromocao["id_promocoes"]."'" . ($row["id_promocoes"]==$rowpromocao["id_promocoes"] ? 'selected' : '').">".$rowpromocao["titulo"]."</option>";
		}}*/
		?>
		</select>
		</div> -->
		</div>
		<div class="row">
		
		<div class="form-group form-group-sm col-sm-4">
		<label class="control-label">Valor Total</label>
		<input class="form-control" id="eValor" name="eValor" onkeyup="CalculaPolos()"value="<?php echo $row["valorcompra"];?>"/>
		</div>
		<div class="form-group form-group-sm col-sm-4">
		<label class="control-label">Polos</label>
		<input class="form-control" id="ePolo" name="ePolo" value="<?php echo $row["pontuacoes"];?>"disabled/>
		</div>
		
		<?php
		if($_SESSION['usuarioNiveisAcessoId'] == 1)
		{
		echo '<div class="col-sm-4 form-group form-group-sm">';
		echo '<label class="control-label">Data da Pontuação</label>
		<div class="input-group date form_datetime col-md-12" style="z-index:0;">
		<input class="form-control" size="16" name="eDataCriacao" id="eDataCriacao" type="text" value="'.formata_data_exibicao($row["created"]).'"readonly />
		<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
		<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
		</div>
		</div>';
		}        
		?>
		
		
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
		<div class="col-sm-12 form-group-sm">
		<div class="panel panel-default">
		<div class="panel-heading clearfix">
		<h4 class="panel-title pull-left" style="padding-top: 7.5px;">Dados de Obra</h4>
		<div class="btn-group pull-right">
		<a class="btn btn-primary btn-sm" onclick='CarregaLoader();AdicionarObra()'class="btn btn-link"  ><i class="fa fa-plus" ></i></a>
		</div>
		</div>
		<div class="panel-body">
		<div class="row">
		<div class="form-group form-group-sm col-sm-6">
		<label class="control-label">Parceiros</label>
		<select onchange="BuscaObra()" class="form-control" id="eParceiros" name="eParceiros">
		<?php
		$sqlparceiro = "SELECT * FROM parceiros ORDER By nome ASC";
		$stmtparceiro = $conn->prepare($sqlparceiro); //
		$stmtparceiro->execute();
		$resultparceiro = $stmtparceiro->get_result();
		if ($resultparceiro->num_rows > 0) {
		for ($i = 0; $i < $resultparceiro->num_rows; $i++) {
		$rowparceiro = $resultparceiro->fetch_assoc();
		//  <option value='".$row["id_vendedores"]."'".($rowpontuacao["id_vendedores"]==$row["id_vendedores"] ? 'selected' : '').">".$row["nome"]."</option>";
		echo "<option value='".$rowparceiro["id_parceiros"]."'".($row["id_parceiros"]==$rowparceiro["id_parceiros"] ? 'selected' : '').">".$rowparceiro["nome"]."</option>";
		}} ?>
		</select>
		</div>
		<div class="form-group form-group-sm col-sm-6">
		<label class="control-label">Fase da Obra</label>
		<select class="form-control" name="eFases"  id="eFases" >
		<option value="0">Automação Som Imagem</option>
		<option value="1">Cobertura / Telhado</option>
		<option value="2">Elétrica / Hidráulica</option>
		<option value="3">Eletrodomésticos</option>
		<option value="4">Esquadrias / Batentes</option>
		<option value="5">Estratégico</option>
		<option value="6">Estrutura / Alvenaria</option>
		<option value="7">Fundação / Alicerce</option>
		<option value="8">Gestão de Obras</option>
		<option value="9">Iluminação</option>
		<option value="10">Inauguração</option>
		<option value="11">Mármores</option>
		<option value="12">Materiais Construção</option>
		<option value="13">Mobiliário</option>
		<option value="14">Objetos / Decoração</option>
		<option value="15">Paisagismo</option>
		<option value="16">Pintura / Acabamento</option>
		<option value="17"> Piscinas / Banheiras</option>
		<option value="18">Pisos / Revestimentos</option>
		<option value="19">Projeto / Implantação</option>
		<option value="20">Turismo</option>
		<option value="21">Vidros</option>
		</select>
		</div>
		</div>
		<div class="row">
		<div class="form-group form-group-sm col-sm-12">
		<label class="control-label">Obras</label>
		<div class="radio" id="eObras" name="eObras"></div>
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
		<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		<div class="modal-header" style="background-color: #00091a; color:white; border-radius:5px 5px 0px 0px;">
		<button type="button" class="close" onclick="TiraLoader()" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Edição de Obras</h4>
		</div>
		<div class="modal-body">
		<div class="row">
		<div class="form-group form-group-sm col-sm-2">
		<label class="control-label">Id</label>
		<input class="form-control" id="eIdObra" name="eIdObra" disabled/>
		</div>
		<div class="form-group form-group-sm col-sm-10">
		<label class="control-label">Profissional</label>
		<input class="form-control" id="eProfissionalObra" name="eProfissionalObra" disabled/>
		<input class="form-control" id="eIdParceiroObra" name="eIdParceiroObra" style="display:none"/>
		</div>
		</div>
		<div class="row">
		<div class="form-group form-group-sm col-sm-8">
		<label class="control-label">Nome da Obra</label>
		<input class="form-control" id="eNomeObra" name="eNomeObra"/>
		</div>
		<div class="form-group form-group-sm col-sm-4">
		<label class="control-label">Categoria Obra</label>
		<select class="form-control" id="eCategoriaObra" name="eCategoriaObra">
		<option value="Residencial">Residencial</option>
		<option value="Comercial">Comercial</option>
		<option value="Obra">Obra</option>
		</select>
		</div>
		</div>
		<div class="row">                     
		<div class="form-group form-group-sm col-sm-6">
		<label class="control-label">Situação</label>
		<select class="form-control" id="eSituacaoObra" name="eSituacaoObra">
		<option value="Nova">Nova Obra</option>
		<option value="Reforma">Reforma</option>
		</select>
		</div>
		<div class="form-group form-group-sm col-sm-6">
		<label class="control-label">Tipo Endereço</label>
		<select class="form-control" id="eTipoEnderecoObra" name="eTipoEnderecoObra">
		<option value="Comercial">Comercial</option>
		<option value="Residencial">Residencial</option>
		</select>
		</div>
		</div>
		<div class="row">
		<div class="form-group form-group-sm col-sm-3">
		<label class="control-label">CEP</label>
		<input class="form-control"  id="eCEPObra" onkeypress="handleMask(event, '99999-999')" name="eCEPObra" />
		</div>
		<div class="form-group form-group-sm col-sm-9">
		<label class="control-label">Logradouro</label>
		<input class="form-control" id="eEnderecoObra" name="eEnderecoObra"  />
		</div>
		</div>
		<div class="row">
		<div class="form-group form-group-sm col-sm-2">
		<label class="control-label">Número</label>
		<input class="form-control" id="eNumeroObra" name="eNumeroObra" value="<?php echo $row["numero"];?>"/>
		</div>
		<div class="form-group form-group-sm col-sm-5">
		<label class="control-label">Complemento</label>
		<input class="form-control" id="eComplementoObra" name="eComplementoObra" value="<?php echo $row["complemento"];?>"/>
		</div>
		<div class="form-group form-group-sm col-sm-5">
		<label class="control-label">Bairro</label>
		<input class="form-control" id="eBairroObra" name="eBairroObra"value="<?php echo $row["bairro"];?>"/> 
		</div>
		</div>
		<div class="row">
		<div class="form-group form-group-sm col-sm-8">
		<label class="control-label">Cidade</label>
		<input class="form-control" id="eCidadeObra" name="eCidadeObra"/>
		</div>
		<div class="form-group form-group-sm col-sm-4">
		<label class="control-label">Estado</label>
		<select class="form-control" id="eEstadoObra" name="eEstadoObra">
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
		</select value="<?php echo $row["estado"];?>>
		</div>
		</div>
		<div class="row">
		<div class="form-group form-group-sm col-sm-12">
		<span id="eError1" name="eError1" style="color:firebrick"></span>
		<span id="eSucesso1" name="eSucesso1" style="color:green"></span>
		</div>
		</div>
		</div>
		<div class="modal-footer" style="background-color: #00091a; border-radius:0px 0px 5px 5px;">
		<button type="button" class="btn btn-success" onclick="TiraLoader();GravarObra()">Gravar</button>
		<button type="button" class="btn btn-danger" onclick="TiraLoader()" data-dismiss="modal">Cancelar</button>
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
		<button type="button" class="close" onclick="TiraLoader()" data-dismiss="modal">&times;</button>
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
		<button type="button" class="btn btn-success btn" onclick="TiraLoader();ExcluirObra()">Excluir</button>
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