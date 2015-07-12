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
<script>
function myF(){
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
$val1 = htmlentities($_POST['nif']);
$val2 = htmlentities($_POST['val']);
require_once("./_includes/funcoes.php");
ligar_base_dados();
if($val2==1){
valida_utilizador($val1);
} else {
nao_valida_utilizador($val1);
}
}
?>
document.location.reload(true);

}
<?php
require_once("./_includes/funcoes.php");
ligar_base_dados();
$elemento = "<script>document.write(nif)</script>"

?>
}


}
</script>
	<body>
	
	<?php

require_once("./_includes/funcoes.php");
ligar_base_dados();
$resultado = lista_login_por_validar();
?>
	<legend> Validar Utilizadores</legend>
	<table style="empty-cells:hide;" border="1"  class="table" cellpadding="1" cellspacing="1">
    
    <tr>
        <th>Login</th><th>BI</th><th>NOME</th><th>MORADA</th><th>TELEFONE</th><th>CODIGO POSTAL</th><th>TIPO DE UTILIZADOR</th>
		<th>SECTOR DE ACTIVIDADE</th><th>EMAIL</th><th>Validar</th><th>Comentarios</th></th>
    </tr>
    
    
        <?php
									while($row = mysql_fetch_array($resultado, MYSQL_NUM)){
									?>
									<form action="validacao.php" method="post" id="ins">
									<tr><td><?php echo $row[0] ?></td><input name ="nif" type="hidden" value="<?= $row[0] ?>"/><td><?php echo $row[1] ?></td><td><?php echo $row[2] ?></td>
									<td><?php echo $row[3] ?></td><td><?php echo $row[4] ?></td><td><?php echo $row[5] ?></td>
									<td><?php echo $row[6] ?></td><td><?php echo $row[7] ?></td><td><?php echo $row[8] ?></td>
									<td><select name="val"><option value="0" disabled="disabled" selected="selected">Selecione uma opcao</option>
									<option value="1">Validar</option>
									<option value="2">Nao validar</option></select></td><td><input type="text" name="comentarios"></td>
									<td><button onclick="myF()">Submit</button></tr>
									</form>
									<?php
									}
									?>        
    
    
</table>
<?php include 'footer.php' ?>
