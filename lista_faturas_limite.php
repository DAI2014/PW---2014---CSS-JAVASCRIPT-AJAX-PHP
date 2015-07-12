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
$resultado = lista_faturas_limite();
?>
	<legend> Lista de Faturas com limite ultrapassado</legend>
	<table style="empty-cells:hide;" border="1" class="table" cellpadding="1" cellspacing="1">
    
    <tr>
        <th>Fatura</th><th>Emissor</th><th>Receptor</th><th>Data de emissao</th><th>Data de Registo</th><th>Data Limite</th>
		<th>Beneficio</th><th>Tipo de Fatura</th><th>Inserida Por</th><th>Total de Fatura</th></th>
    </tr>
    
    
        <?php
									while($row = mysql_fetch_array($resultado, MYSQL_NUM)){
									?>
									<form id="lista_de_faturas">
									<tr><td><?php echo $row[0] ?></td><td><?php echo $row[1] ?></td><td><?php echo $row[2] ?></td>
									<td><?php echo $row[3] ?></td><td><?php echo $row[4] ?></td><td><?php echo $row[5] ?></td>
									<td><?php echo $row[6] ?></td><td><?php echo $row[7] ?></td><td><?php echo $row[8] ?></td>
									<td><?php echo $row[9] ?></td></tr>
									</form>
									<?php
									}
									?>        
    
    
</table>
</body>
<a href="javascript:window.print();">Imprime </a>
</html>
<?php include 'footer.php' ?>