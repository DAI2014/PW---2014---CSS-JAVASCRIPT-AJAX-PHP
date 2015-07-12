<?php include 'header.php'; ?>
<?php
require_once("./_includes/funcoes.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
$elemento=mysql_real_escape_string($_POST['nif']);
if(verifica_comerciante($elemento)!=true){
?>
<script>alert("Por favor insira um NIF de comerciante!!")</script>
<?php
}else{
	bloqueio_comerciantes($elemento);
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
<legend> Bloqueio de Comerciantes</legend>
      <form action="bloqueio_comerciantes.php" method="post">
        NIF de Comerciante:<input type="text" class="form-control input-sm"  name = "nif"  required autofocus>
        <button name = "submit" type="submit" value="1">Bloquear</button>
      </form>

	  <?php include 'footer.php'; ?>
</div>
</body>
</html>	 