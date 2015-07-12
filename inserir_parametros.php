<?php include 'header.php'; ?>
<?php
require_once("./_includes/funcoes.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){

switch($_POST['submit']) {
    case '1': 
    $elemento=mysql_real_escape_string($_POST['designacao']);
	$elemento2=mysql_real_escape_string($_POST['valor']);
	inserir_coimas($elemento,$elemento2);
    break;
    case '2':
	$elemento=mysql_real_escape_string($_POST['funcionalidade']);
	inserir_funcionalidades($elemento);
    break;
	case '3':
	$elemento=mysql_real_escape_string($_POST['setor']);
	inserir_setor_actividade($elemento);
	break;
	case '4':
	$elemento=mysql_real_escape_string($_POST['tipofatura']);
	inserir_tipo_fatura($elemento);
	break;
	case '5':
	$elemento=mysql_real_escape_string($_POST['tipoutilizador']);
	inserir_tipo_utilizador($elemento);
	break;
	case '6':
	$elemento=mysql_real_escape_string($_POST['parametro']);
	$elemento2=mysql_real_escape_string($_POST['valorparametro']);
	echo $elemento, $elemento2;
	inserir_parametros($elemento,$elemento2);
	break;
} 


}

?>

<br />
<br />
<br />
<br />
<br />
<br />
<div class="col-xs-5">
<legend> Inserir Parametros</legend>
      <form action="inserir_parametros.php" method="post">
        Nova Coima:<input type="text" class="form-control input-sm"  name = "designacao" placeholder="Designacao" required autofocus>
		<input type="text" class="form-control input-sm"  name = "valor" placeholder="Valor" required autofocus>
        <button name = "submit" type="submit" value="1">Inserir</button>
      </form>
	  
	  <form action="inserir_parametros.php" method="post">
        Nova Funcionalidade:<input type="text" class="form-control input-sm"  name = "funcionalidade" placeholder="Funcionalidade" required autofocus>
        <button name = "submit" type="submit" value="2">Inserir</button>
      </form>
	  
	  <form action="inserir_parametros.php" method="post">
        Novo Sector de Actividade:<input type="text" class="form-control input-sm"  name = "setor" placeholder="Setor Actividade" required autofocus>
        <button name = "submit" type="submit" value="3">Inserir</button>
      </form>
	  
	  <form action="inserir_parametros.php" method="post">
        Novo Tipo de Fatura:<input type="text" class="form-control input-sm"  name = "tipofatura" placeholder="Tipo Fatura" required autofocus>
        <button name = "submit" type="submit" value="4">Inserir</button>
      </form>
	  
	  <form action="inserir_parametros.php" method="post">
        Novo Tipo de Utilizador:<input type="text" class="form-control input-sm"  name = "tipoutilizador" placeholder="Tipo de Utilizador" required autofocus>
        <button name = "submit" type="submit" value ="5">Inserir</button>
      </form>
	  
	  <form action="inserir_parametros.php" method="post">
        Novo Parametro:<input type="text" class="form-control input-sm" name = "parametro" placeholder="Designacao" required autofocus>
		<input type="text" class="form-control input-sm" name = "valorparametro" placeholder="Valor" required autofocus>
        <button name = "submit" type="submit" value="6">Inserir</button><p>Percentagens devem ser inseridas da seguinte forma : 1.xx</p>
      </form>
	  <br />
	  <?php include 'footer.php'; ?>
</div>
</body>
</html>	 
	  
	  