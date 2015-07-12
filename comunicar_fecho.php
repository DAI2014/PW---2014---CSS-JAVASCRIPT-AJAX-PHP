<?php include 'header.php'; ?>
<?php
require_once("./_includes/funcoes.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
$elemento=$_SESSION['username'];
?>
<script>
var r=confirm("Tem a certeza que pretende terminar a sua Atividade, no caso de terminar atividade todo o acesso aos seus dados no site serão bloqueados");
if (r==true)
  {
<?php
	bloqueio_comerciantes($elemento);
?>
  }
</script>
<?php
}
?>

<br>
<br>
<br>
<br>
<br>
<br>
<div class="col-xs-7">
	<legend> Comunicar Fecho</legend>
      <form action="comunicar_fecho.php" method="post">
        <button name = "Terminar Actividade" type="submit" value="1" onClick="func">Proceder</button>
      </form>
</div>
	  
	<?php include 'footer.php'; ?> 