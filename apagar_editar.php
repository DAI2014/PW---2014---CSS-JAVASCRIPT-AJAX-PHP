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
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
$val1 = htmlentities($_POST['fatura']);
$val2 = htmlentities($_POST['emissor']);
$val3 = htmlentities($_POST['inserido']);
$val4 = htmlentities($_POST['val']);

require_once("./_includes/funcoes.php");

if($val4==1){
$ligacao=ligar_base_dados();
$ben= mysql_query("select beneficio from faturas where n_fatura='$val1' and inserido_por=$val3",$ligacao);
$row = mysql_fetch_array($ben);
$ben2=$row[0];
$bentot = mysql_query("select total_beneficio from utilizadores where nif=$val3",$ligacao);
$row = mysql_fetch_array($bentot);
$bentot2=$row[0];
$novoben= $bentot2 - $ben2;

$actualizacao = mysql_query("update utilizadores set total_beneficio = $novoben where nif=$val3");
$resultado = mysql_query("delete from faturalinha where `Faturas_N_FATURA`= '$val1' and faturas_inserido_por=$val3", $ligacao);
$resultado2 = mysql_query("delete from faturas where n_fatura='$val1' and `Utilizadores_NIF(EMISSOR)`= $val2 and inserido_por=$val3 ",$ligacao);
}

}
?>



<?php
require_once("./_includes/funcoes.php");
ligar_base_dados();

?>

	<body>
	
	<?php

require_once("./_includes/funcoes.php");
ligar_base_dados();
?>	
	<legend> Apagar / Editar</legend>
	<table style="empty-cells:hide;" border="1"  class="table" cellpadding="1" cellspacing="1">
    
    <tr>
        <th>Fatura</th><th>Emissor</th><th>Receptor</th><th>Data de emissao</th><th>Data de Registo</th><th>Data Limite</th>
		<th>Beneficio</th><th>Tipo de Fatura</th><th>Inserida Por</th><th>Total de Fatura</th><th>Opccao</th><th>Submeter</th></th>
    </tr>
    
    
        <?php
									$resultado = lista_faturas($_SESSION['username']);
									while($row = mysql_fetch_array($resultado, MYSQL_NUM)){
									?>
									<form action="apagar_editar.php" method="post" id="ins">
									<tr><td><?php echo $row[0] ?></td><input name ="fatura" type="hidden" value="<?= $row[0] ?>"/>
									<td><?php echo $row[1] ?></td><input name ="emissor" type="hidden" value="<?= $row[1] ?>"/><td><?php echo $row[2] ?></td>
									<td><?php echo $row[3] ?></td><td><?php echo $row[4] ?></td><td><?php echo $row[5] ?></td>
									<td><?php echo $row[6] ?></td><td><?php echo $row[7] ?></td><td><?php echo $row[8] ?></td><input name ="inserido" type="hidden" value="<?= $row[8] ?>"/>
									<td><?php echo $row[9] ?></td>
									<td><select name="val"><option value="0" disabled="disabled" selected="selected">Selecione uma opcao</option>
									<option value="1">Apagar</option>
									<option value="2">Editar</option></select></td>
									<td><button onclick="myF()">Submit</button></tr>
									</form>
									<?php
									}
									?>        
    
    
</table>
<?php include 'footer.php' ?>
