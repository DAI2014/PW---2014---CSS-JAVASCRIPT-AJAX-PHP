<?php 
include "header.php"; 
require_once("./_includes/funcoes.php");

?>
    <title>LOGIN</title>

    <!-- Ajusta ao meio -->
    <link href="signin.css" rel="stylesheet">

  
 <div class="container">
      <form class="form-signin"method="post" action="login.php">
        <h2 class="form-signin-heading">Autenticação:</h2>
        <input type="text" name="username" class="form-control" maxlength="9px" placeholder="Introduza NIF" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">OK</button>
      </form>
    </div>
	
<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$elemento=mysql_real_escape_string($_POST['username']);
	$elemento2=mysql_real_escape_string($_POST['password']);
	$resultado = login($elemento,$elemento2);
	if(mysql_num_rows($resultado) != 1){
	echo "Password ou login errado";	

}else {
if(verifica_data_password($_SESSION['username'])==true){
?>
<script>alert ("Ultima actualizacao de password foi a mais de 365 dias!!!"); </script>
<?php
}
$_SESSION['username'] = $_POST['username'];
	if(verifica_consumidor($_SESSION['username']) & beneficio_consumidor($_SESSION['username'])>=get_beneficio_maximo()){	
?>
<script>alert ("Ja atingiu o Beneficio Maximo!!!"); </script>
<script>location.href='index.php'</script>
<?php
}else{
?>
<script>location.href='index.php'</script>
<?php	
}
}
}
?>	
	<?php include "footer.php"; ?>