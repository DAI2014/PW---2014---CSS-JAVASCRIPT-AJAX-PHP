<?php include 'header.php'; ?>
<?php
require_once("./_includes/funcoes.php");

?>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

	<legend> Beneficio</legend>
      <form>
        Total de Beneficio:<input value = <?= beneficio_consumidor($_SESSION['username']) ?>€ readonly="readonly" type="text" class="form-control" id="focusedInput">
      </form>
	  
	<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>  
	 
	  
<?php include 'footer.php'; ?> 