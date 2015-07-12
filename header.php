<?php 
session_start(); 
require_once("./_includes/funcoes.php");
?>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EFACTUR-UM</title>

<link href="bootstrap.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="jquerycssmenu.css" />


<script type="text/javascript" src="js/jquery.min.1.2.6.js"></script>
<script type="text/javascript" src="js/jquerycssmenu.js"></script>
<script type="text/javascript" src="js/jquery.min.1.3.2.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
  var currentPosition = 0;
  var slideWidth = 750;
  var slides = $('.slide');
  var numberOfSlides = slides.length;

  // Remove scrollbar in JS
  $('#slidesContainer').css('overflow', 'hidden');

  // Wrap all .slides with #slideInner div
  slides
    .wrapAll('<div id="slideInner"></div>')
    // Float left to display horizontally, readjust .slides width
	.css({
      'float' : 'left',
      'width' : slideWidth
    });

  // Set #slideInner width equal to total width of all slides
  $('#slideInner').css('width', slideWidth * numberOfSlides);

  // Insert controls in the DOM
  $('#slideshow')
    .prepend('<span class="control" id="leftControl">Clicking moves left</span>')
    .append('<span class="control" id="rightControl">Clicking moves right</span>');

  // Hide left arrow control on first load
  manageControls(currentPosition);

  // Create event listeners for .controls clicks
  $('.control')
    .bind('click', function(){
    // Determine new position
	currentPosition = ($(this).attr('id')=='rightControl') ? currentPosition+1 : currentPosition-1;
    
	// Hide / show controls
    manageControls(currentPosition);
    // Move slideInner using margin-left
    $('#slideInner').animate({
      'marginLeft' : slideWidth*(-currentPosition)
    });
  });

  // manageControls: Hides and Shows controls depending on currentPosition
  function manageControls(position){
    // Hide left arrow if position is first slide
	if(position==0){ $('#leftControl').hide() } else{ $('#leftControl').show() }
	// Hide right arrow if position is last slide
    if(position==numberOfSlides-1){ $('#rightControl').hide() } else{ $('#rightControl').show() }
  }	
});
</script>
</head>


<div id="myjquerymenu" class="jquerycssmenu" >
<ul>
<li><a href="index.php">Home</a></li>

<li><a href="informacoes_uteis.php">Informações Uteis</a>
</li>
<?php
if(verifica_admin($_SESSION['username'])){
?>
<li><a href="#">Administrador</a>
  <ul>
  <li><a href="#">Utilizadores</a>
	<ul>
    <li><a href="validacao.php">Aprovar novos registos</a></li>
	<li><a href="bloqueio_comerciantes.php">Bloqueio Comerciantes</a></li>
	<li><a href="#">Consultas por NIF</a>
	<ul>
	<li><a href="utilizador_por_nif.php">Dados</a></li>
	<li><a href="total_por_nif.php">Faturacao e IVA</a></li>
	<li><a href="total_beneficio_por_nif.php">Beneficio</a></li>
	</ul>
	</li>
	<li><a href="#">Listagens</a>
	<ul>
	<li><a href="lista_consumidores.php">Lista de Consumidores</a></li>
	<li><a href="lista_comerciantes.php">Lista de Comerciantes</a></li>
	<li><a href="utilizadores_beneficio_maximo.php">Listagem de todos os Consumidores que atingiram o beneficio maximo</a></li>
	<li><a href="lista_faturas_limite.php">Listagem de Comerciantes com faturas depois do dia 25</a></li>
	<li><a href="aplicar_coimas.php">Aplicar coimas</a></li>
	</ul>
	</li>
	</ul>
	</li>
  <li><a href="#">Faturas</a>
  <ul>
  	<li><a href="divergencias.php">Listagem de Divergencias</a></li>
	<li><a href="lista_todas_faturas.php">Listagem de Todas as faturas</a></li>
  </ul>
  </li>
  <li><a href="lista_coimas.php">Lista Coimas</a></li>
  <li><a href="inserir_parametros.php">Inserir Dados</a></li>
  <li><a href="alterar_dados_ad.php">Alterar Dados</a></li>
  </ul>
</li>
<?php
}
?>
<?php
if(verifica_consumidor($_SESSION['username'])){
?>
<li><a href="#">Consumidor</a>
  <ul>
  <li><a href="inserir_fatura.php">Inserir Fatura</a></li>
  <li><a href="apagar_editar.php">Apagar\Editar ultima fatura</a></li>
  <li><a href="lista_faturas.php">Listar Faturas</a></li>
  <li><a href="beneficio.php">Consultar Beneficios</a></li>
  <li><a href="alterar_dados.php">Alterar Dados Pessoais</a></li>
  </ul>
</li>
<?php
}
?>
<?php
if(verifica_comerciante($_SESSION['username'])){
?>
<li><a href="#">Comerciante</a>
  <ul>
  <li><a href="inserir_fatura.php">Inserir Fatura Manual</a></li>
  <li><a href="upload_ficheiro.php">Inserir Fatura Ficheiro. ATENCAO Faturas inseridas/carregadas no sistema após o dia 25 poderão originar contraordenações</a></li>
  <li><a href="apagar_editar.php">Apagar\Editar faturas</a>
  <li><a href="total_faturado_por_nif.php">Consultar o valor total faturado e o valor de IVA suportado</a>
  <li><a href="lista_faturas.php">Listar Faturas</a> 
  <li><a href="comunicar_fecho.php">Comunicar Fecho de Atividade</a>
  <li><a href="coimas_por_nif.php">Consultar Coimas</a></li>
  <li><a href="alterar_dados.php">Alterar Dados Pessoais</a>
  </ul>
</li>
<?php
}
?>
<li><a href="novo_utilizador.php">Registar</a></li>
<li><a href="sobre.php" class="margin_l10">Sobre</a></li>
<li><a href="contactos.php" class="margin_l10">Contactos</a></li>
<?php
if($_SESSION['username']!=0){
?>
<li><a href="logout.php">LogOut</a></li>
<?php
}
?>
</ul>

<div class="row" style="text-align: center">
	<img src="images/um.gif" alt="UM" align="right/center" />
</div>


