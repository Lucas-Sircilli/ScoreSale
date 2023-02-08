<style>
	b{
	padding-right: 15px !important;
	}
	.navbar-brand {
	background-image: url('./imagens/Logo-teste-Login.png');
	background-size: contain;
	background-repeat: no-repeat;
	background-position: center;
	width: 120px;
	height:40px;
	}
</style>
<script type="text/javascript">
	function AtualizaLGPD() {
		
		/*$.ajax({
   			type: "GET",
   			url: 'lgpdAtualiza.php',
   			
   			success: function(html) {
   			
			
   			},
   			error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
			console.log(xhr, ajaxOptions, thrownError)
   			}
			
			});
		setTimeout(function(){AtualizaLGPD();}, 60000);*/
	}
	
//setTimeout(function(){AtualizaLGPD();}, 1000);

function EditarSenha(){
$("#eSenhaAtual").val("");
$("#eSenhaNova").val("");
$("#eSucessomenu").val("");
$("#eErrormenu").val("");
$("#ModalSenha").modal("show");
}

function AlterarSenha(){
$("#eSucessomenu").text("");
$("#eErrormenu").text("");
var id = <?php echo $_SESSION['usuarioId']; ?>;
var usuario = "<?php echo $_SESSION['usuarioEmail']; ?>";

var dataU = {};

dataU.Id = id;
dataU.Nome = usuario;
dataU.Senha = $("#eSenhaAtual").val();
dataU.SenhaNova = $("#eSenhaNova").val();
$.ajax({
type: "POST",
url: 'AlterarSenha.php',
data: dataU,
success: function(html) {
if (html.indexOf("sucesso") != -1) {
$("#eSucessomenu").text(html);
$("#ModalSenha").modal("hide");
$("#FormLog").submit();
} else {
$("#eErrormenu").text(html);
}

},
error: function(xhr, ajaxOptions, thrownError) {
$("#eErrormenu").text(thrownError);
}

});
return;
}
function CarregaLoader(){
document.getElementById("loading").style.display = "flex";
}

function TiraLoader(){
$('#loading')[0].attributes[1].nodeValue = 'display: none !important';
}

</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div id="loading" style="display:none !important">
<img id="loading-image" src="./imagens/loader.svg" alt="Loading..." />
</div>
<nav class="navbar">
<div class="container-fluid">
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
<span class="icon-bar" style="background-color:#234fa8"></span>
<span class="icon-bar" style="background-color:#234fa8"></span>
<span class="icon-bar" style="background-color:#234fa8"></span>
</button>
<a class="navbar-brand" href="administrativo.php"></a>
</div>
<div class="collapse navbar-collapse" id="myNavbar">
<ul class="nav navbar-nav">
<?php 
if($_SESSION['usuarioNiveisAcessoId']=="1"){

if($_SERVER['PHP_SELF'] == '/usuarios.php') echo '<li class="active"><a href="usuarios.php">Usuários</a></li>';
else echo '<li><a href="usuarios.php">Usuários</a></li>';



if($_SERVER['PHP_SELF'] == '/empresas.php') echo '<li class="active"><a href="empresas.php">Empresas</a></li>';
else echo '<li><a href="empresas.php">Empresas</a></li>';

if($_SERVER['PHP_SELF'] == '/parceiros.php') echo '<li class="active"><a href="parceiros.php">Parceiros</a></li>';
else echo '<li><a href="parceiros.php">Parceiros</a></li>';

if($_SERVER['PHP_SELF'] == '/pontuacoes.php') echo '<li class="active"><a href="pontuacoes.php">Pontuações</a></li>';
else echo '<li><a href="pontuacoes.php">Pontuações</a></li>';


if($_SERVER['PHP_SELF'] == '/promocoes.php') echo '<li class="active"><a href="promocoes.php">Promoções</a></li>';
else echo '<li><a href="promocoes.php">Promoções</a></li>';
}
else if($_SESSION['usuarioNiveisAcessoId']=="2"){		


if($_SERVER['PHP_SELF'] == '/parceiros.php') echo '<li class="active"><a href="parceiros.php">Parceiros</a></li>';
else echo '<li><a href="parceiros.php">Parceiros</a></li>';

if($_SERVER['PHP_SELF'] == '/pontuacoes.php') echo '<li class="active"><a href="pontuacoes.php">Pontuações</a></li>';
else echo '<li><a href="pontuacoes.php">Pontuações</a></li>';

if($_SERVER['PHP_SELF'] == '/promocoes.php') echo '<li class="active"><a href="promocoes.php">Promoções</a></li>';
else echo '<li><a href="promocoes.php">Promoções</a></li>';


}		
else if($_SESSION['usuarioNiveisAcessoId']=="3"){

if($_SERVER['PHP_SELF'] == '/pontuacoes.php') echo '<li class="active"><a href="pontuacoes.php">Pontuações</a></li>';
else echo '<li><a href="pontuacoes.php">Pontuações</a></li>';
if($_SERVER['PHP_SELF'] == '/promocoes.php') echo '<li class="active"><a href="promocoes.php">Promoções</a></li>';
else echo '<li><a href="promocoes.php">Promoções</a></li>';
}				
?>
<!--<li <?php if ($_SERVER['PHP_SELF'] == '/comunicacao.php') echo 'class="active"'; ?>><a href="comunicacao.php">Comunicação</a></li>
<li <?php if ($_SERVER['PHP_SELF'] == '/calibracao.php') echo 'class="active"'; ?>><a href="calibracao.php">Calibração</a></li>
<li <?php if ($_SERVER['PHP_SELF'] == '/registros.php') echo 'class="active registros"';
else echo 'class="dropdown"'; ?>>
<a class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer">Registros <span class="caret"></span></a>
<ul class="dropdown-menu">
<li <?php if ($_SERVER['PHP_SELF'] == '/comunicacao.php') echo 'class="active"'; ?>><a href="log_execucao.php">Log Execução</a></li>
<li <?php if ($_SERVER['PHP_SELF'] == '/pesagens.php') echo 'class="active"'; ?>><a href="pesagens.php">Pesagens</a></li>
</ul>
</li>
<li <?php if ($_SERVER['PHP_SELF'] == '/usuarios.php') echo 'class="active"'; ?>><a href="usuarios.php">Usuários</a></li>-->
</ul>
<ul class="nav navbar-nav navbar-right">
<li class="dropdown">
<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['usuarioNome']; ?>
<span class="caret"></span></a>
<ul class="dropdown-menu">
<li><a href="#" onclick="EditarSenha()">Alterar Senha</a></li>
<li><a href="sair.php">Sair</a></li>
</ul>
</li>
</div>
<div class="row" style="background-color: #6c08cb; padding-bottom: 5px; padding-top: 5px;">
<div class="col-sm-12 col-xs-12 text-right" style="color: white;"><b><?= $TituloPage ?></b></div>
</div>
</div>
</nav>
<div id="ModalSenha" class="modal fade" role="dialog">
<div class="modal-dialog ">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header" style="background-color: #00091a; color:white; border-radius:5px 5px 0px 0px;">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Mudar Senha</h4>
</div>
<div class="modal-body">
<div class="row">
<div class="form-group form-group-sm col-xs-6 col-sm-6">
<label class="control-label">Senha Atual</label>
<input class="form-control" type="password" id="eSenhaAtual" name="eSenhaAtual" />
</div>
</div>
<div class="row">
<div class="form-group form-group-sm col-xs-6 col-sm-6">
<label class="control-label">Senha Nova</label>
<input class="form-control" type="password" id="eSenhaNova" name="eSenhaNova" />
</div>
</div>
<div class="row">
<div class="form-group form-group-sm col-xs-12 col-sm-12">
<span id="eErrormenu" name="eErrormenu" style="color:firebrick"></span>
<span id="eSucessomenu" name="eSucessomenu" style="color:green"></span>
</div>
</div>
</div>
<div class="modal-footer" style="background-color: #00091a; border-radius:0px 0px 5px 5px;">
<button type="button" class="btn btn-success" onclick="AlterarSenha()">Gravar</button>
<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
</div>
</div>
</div>
</div>