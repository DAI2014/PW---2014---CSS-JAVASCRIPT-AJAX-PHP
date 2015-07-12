<?php include 'header.php' ?>

<body>
<br/>
<br/>
<br/>
<br/>

	
<?php
require_once("./_includes/funcoes.php");
ligar_base_dados();
$resultado = lista_consumidores_beneficio_maximo();
?>
<legend> Lista de Consumidore que atingiram o Beneficio Maximo</legend>
<table style="empty-cells:hide;" border="1" class="table" cellpadding="1" cellspacing="1">
    
    <tr>
        <th>Login</th><th>BI</th><th>NOME</th><th>MORADA</th><th>TELEFONE</th><th>CODIGO POSTAL</th><th>BENEFICIO</th><th>TIPO DE UTILIZADOR</th>
		<th>SECTOR DE ACTIVIDADE</th><th>EMAIL</th>
    </tr>
    
    
        <?php
									while($row = mysql_fetch_array($resultado, MYSQL_NUM)){
									?>
									<tr><td><?php echo $row[0] ?></td><td><?php echo $row[1] ?></td><td><?php echo $row[2] ?></td>
									<td><?php echo $row[3] ?></td><td><?php echo $row[4] ?></td><td><?php echo $row[5] ?></td>
									<td><?php echo $row[6] ?>€</td><td><?php echo $row[7] ?></td><td><?php echo $row[8] ?></td>
									<td><?php echo $row[9] ?></td>
									<?php
									}
									?>        
    
    
</table>
<a href="javascript:window.print();">Imprime </a>
</body>
</html>
<?php include 'footer.php'; ?>

