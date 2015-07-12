<?php include 'header.php' ?>

<style>
.center {
    text-align: center;
    vertical-align: middle;
}
td, th {
    padding: 5px;   
}
tr {
    height: 25px;   
}

</style>
	<body>
	
	
	<?php

require_once("./_includes/funcoes.php");
ligar_base_dados();
$resultado = lista_coimas_por_nif($_SESSION['username']);
?>


	<legend> Coimas </legend>
	<table style="empty-cells:hide;" border="1" class="table" cellpadding="1" cellspacing="1">
    
    <tr>
        <th>Fatura</th><th>Valor da Coima</th></th>
    </tr>
    
    
        <?php
									while($row = mysql_fetch_array($resultado, MYSQL_NUM)){
									?>
									<form id="lista_de_faturas">
									<tr><td><?php echo $row[0] ?></td><td><?php echo $row[1] ?></td></tr>
									</form>
									<?php
									}
									?>        
    
    
</table>
</body>
</html>
<?php include 'footer.php' ?>