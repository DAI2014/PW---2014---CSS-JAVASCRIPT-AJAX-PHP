<?php include 'header.php'; ?>
<?php
require_once("./_includes/funcoes.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){

switch($_POST['submit']) {
    case '1': 
    $elemento=mysql_real_escape_string($_SESSION['username']);
	$elemento2=mysql_real_escape_string($_POST['morada']);
	altera_morada($elemento,$elemento2);
    break;
    case '2':
	$elemento=mysql_real_escape_string($_SESSION['username']);
	$elemento2=mysql_real_escape_string($_POST['telefone']);
	altera_telefone($elemento,$elemento2);
    break;
	case '3':
	$elemento=mysql_real_escape_string($_SESSION['username']);
	$elemento2=mysql_real_escape_string($_POST['cod_postal']);
	altera_cod_postal($elemento,$elemento2);
	break;
	case '4':
	$elemento=mysql_real_escape_string($_SESSION['username']);
	$elemento2=mysql_real_escape_string($_POST['email']);
	altera_email($elemento,$elemento2);
	break;
	case '5':
	$elemento=mysql_real_escape_string($_SESSION['username']);
	$elemento2=mysql_real_escape_string($_POST['password']);
	$elemento3=mysql_real_escape_string($_POST['password_nova']);
	altera_password($elemento,$elemento2,$elemento3);
	break;
} 


}

?>
<br>
<br>
<br>
<br>
<br>
<br>

<div class="col-xs-7">
<legend> Alterar Dados</legend>
      <form action="alterar_dados.php" method="post">
        Alterar Morada:<input type="text" class="form-control input-sm"  name = "morada" placeholder="Nova Morada" required autofocus>
        <button name = "submit" type="submit" value="1">Inserir</button>
      </form>
	  
	  <form action="alterar_dados.php" method="post">
        Alterar Telefone:<input type="text" class="form-control input-sm"  name = "telefone" placeholder="Novo Telefone" required autofocus>
        <button name = "submit" type="submit" value="2">Inserir</button>
      </form>
	  
	  <form action="alterar_dados.php" method="post">
        Alterar Codigo Postal:<input type="text" class="form-control input-sm"  name = "cod_postal" placeholder="Novo Codigo Postal" required autofocus>
        <button name = "submit" type="submit" value="3">Inserir</button>
      </form>
	  
	  <form action="alterar_dados.php" method="post">
        Alterar Email:<input type="text" class="form-control input-sm"  name = "email" placeholder="Novo Email" required autofocus>
        <button name = "submit" type="submit" value="4">Inserir</button>
      </form>
	  
	  <form action="alterar_dados.php" method="post">
	  
        Alterar Password
		<br>
		<br>
		Password Actual:<input type="password" class="form-control input-sm"  name = "password" placeholder="Nova Password" required autofocus>
		Nova Password:<input type="password" class="form-control input-sm"  name = "password_nova" placeholder="Nova Password" required autofocus>
        <button name = "submit" type="submit" value="5">Inserir</button>
      </form>
	  <br />
	  <?php include 'footer.php'; ?>
</div>	  
	