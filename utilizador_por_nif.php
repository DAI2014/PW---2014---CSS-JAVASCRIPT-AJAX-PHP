<?php include 'header.php' ?>

<body>
<br/>
<br/>
<br/>
<br/>
<div class="col-xs-7">
<legend> Utilizador por NIF</legend>
	<form action="utilizador_por_nif.php" method="post">
		Utilizador por NIF:<input type="text" class="form-control input-sm" name="nif" />
	<input type="submit">Submit</button>
	</form>
</div>
	
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
require_once("./_includes/funcoes.php");
ligar_base_dados();
$var = htmlentities($_POST['nif']);
$resultado = utilizador_por_nif($var);
?>
<table style="empty-cells:hide;" border="1" class="table" cellpadding="1" cellspacing="1">
    
    <tr>
        <th>Login</th><th>BI</th><th>NOME</th><th>MORADA</th><th>TELEFONE</th><th>CODIGO POSTAL</th><th>TIPO DE UTILIZADOR</th>
		<th>SECTOR DE ACTIVIDADE</th><th>EMAIL</th>
    </tr>
    
    
        <?php
									while($row = mysql_fetch_array($resultado, MYSQL_NUM)){
									?>
									<tr><td><?php echo $row[0] ?></td><td><?php echo $row[1] ?></td><td><?php echo $row[2] ?></td>
									<td><?php echo $row[3] ?></td><td><?php echo $row[4] ?></td><td><?php echo $row[5] ?></td>
									<td><?php echo $row[6] ?></td><td><?php echo $row[7] ?></td><td><?php echo $row[8] ?></td>
									
									<?php
									}
									?>        
    
    
</table>
<?php
}
?>
</body>
</html>
<?php include 'footer.php'; ?>

