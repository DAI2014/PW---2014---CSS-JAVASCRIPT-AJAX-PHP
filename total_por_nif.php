<?php include 'header.php' ?>

<body>
<br/>
<br/>
<br/>
<br/>
<div class="col-xs-7">
	<legend> Total de Faturacao por NIF</legend>
	<form action="total_por_nif.php" method="post">
		NIF Comerciante:<input type="text" class="form-control input-sm" name="nif" />
	<input type="submit">Submit</button>
	</form>
</div>
	
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
require_once("./_includes/funcoes.php");
ligar_base_dados();
$var = htmlentities($_POST['nif']);
$resultado1 = soma_iva_por_nif($var);
$resultado2 = soma_faturas_por_nif($var);
if(verifica_comerciante($var)!=true){
?>
<script>alert("Por favor insira um NIF de comerciante!!")</script>
<?php
}else{
?>
<table style="empty-cells:hide;" border="1" class="table" cellpadding="1" cellspacing="1">
    
<tr>
        <th>Total de faturacao</th><td><?= $resultado2 ?>€</td>
    </tr>
	<br/>
	<tr>
        <th>Total iva suportado</th><td><?= $resultado1 ?>€</td>
    </tr>
</table>
<?php
}
}
?>
</body>
</html>
<?php include 'footer.php'; ?>