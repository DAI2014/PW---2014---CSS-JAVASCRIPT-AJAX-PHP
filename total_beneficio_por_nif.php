<?php include 'header.php' ?>

<body>
<br/>
<br/>
<br/>
<br/>
<div class="col-xs-7">
<legend> Beneficio por NIF</legend>
	<form action="total_beneficio_por_nif.php" method="post">
		NIF Consumidor:<input type="text" class="form-control input-sm" name="nif" />
	<input type="submit">Submit</button>
	</form>
</div>
	
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
require_once("./_includes/funcoes.php");
ligar_base_dados();
$var = htmlentities($_POST['nif']);
$resultado1 = beneficio_consumidor($var);
if(verifica_consumidor($var)!=true){
?>
<script>alert("Por favor insira um NIF de consumidor!!")</script>
<?php
}else{
?>
<table style="empty-cells:hide;" border="1" class="table" cellpadding="1" cellspacing="1">
    
<tr>
        <th>Total de beneficio</th><td><?= $resultado1 ?>€</td>
    </tr>
</table>
<?php
}
}
?>
</body>
</html>
<?php include 'footer.php'; ?>