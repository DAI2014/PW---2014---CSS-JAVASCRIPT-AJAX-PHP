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
function aplica_coimas($ele1,$ele2,$ele3,$ele4){
$ligacao = ligar_base_dados();
$resultado = mysql_query("UPDATE faturas SET Coimas_ID_COIMA = $ele1 where n_fatura = $ele2 and `Utilizadores_NIF(EMISSOR)` = $ele3 and inserido_por = $ele4",$ligacao);
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
$val1 = htmlentities($_POST['fatura']);
$val2 = htmlentities($_POST['emissor']);
$val3 = htmlentities($_POST['inserido']);
$val4 = htmlentities($_POST['coimas']);
var_dump($_REQUEST);
require_once("./_includes/funcoes.php");
ligar_base_dados();
aplica_coimas($val4,$val1,$val2,$val3);

//document.location.reload(true);

}
?>
	<body>
	
	
<?php

require_once("./_includes/funcoes.php");
ligar_base_dados();
function tipo_de_coimas(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select * from coimas",$ligacao);
return $resultado;
}
$resultado = lista_faturas_limite();
$divergencias = verifica_divergencias_coimas();
$divergencias2= verifica_divergencias_nao_inseridas();
?>
	<legend> Faturas inseridas fora de prazo </legend>
	<table style="empty-cells:hide;" border="1" class="table" cellpadding="1" cellspacing="1">
    
    <tr>
        <th>Fatura</th><th>Emissor</th><th>Receptor</th><th>Data de emissao</th><th>Data de Registo</th><th>Data Limite</th>
		<th>Beneficio</th><th>Tipo de Fatura</th><th>Inserida Por</th><th>Total de Fatura</th><th>Coimas</th><th>Submeter</th></th>
    </tr>
    
    
        <?php
									while($row = mysql_fetch_array($resultado, MYSQL_NUM)){
									?>
									<form id="faturas_fora_de_prazo" action ="aplicar_coimas.php" method = "post">
									<tr><td><?php echo $row[0] ?></td><input name ="fatura" type="hidden" value="<?= $row[0] ?>"/>
									<td><?php echo $row[1] ?></td><input name ="emissor" type="hidden" value="<?= $row[1] ?>"/>
									<td><?php echo $row[2] ?></td><td><?php echo $row[3] ?></td><td><?php echo $row[4] ?></td>
									<td><?php echo $row[5] ?></td><td><?php echo $row[6] ?></td><td><?php echo $row[7] ?></td>
									<td><?php echo $row[8] ?></td><input name ="inserido" type="hidden" value="<?= $row[8] ?>"/>
									<td><?php echo $row[9] ?></td>
									<td>
									<select id="coimas" class="form-control input-sm" name="coimas" ">
									<option value="" disabled="disabled" selected="selected">Por favor selecione uma opccao</option>
									<?php
									$coimas= tipo_de_coimas();
									while($row = mysql_fetch_array($coimas, MYSQL_NUM)){
									?>
									<option value= <?= $row[0] ?>>
									<?php echo $row[1]?>
									</option>
									
									<?php
									}
									?>
									</select>
									</td>
									<td>
									<input type="submit">
									</td>
									</tr>
									</form>
									<?php
									}
									?>        
    
    
</table>

	<legend> Faturas com divergencias de Totais </legend>
	<table style="empty-cells:hide;" border="1" class="table" cellpadding="1" cellspacing="1">
    
    <tr>
        <th>Fatura</th><th>Emissor</th><th>Receptor</th><th>Data de emissao</th><th>Data de Registo</th><th>Data Limite</th>
		<th>Beneficio</th><th>Tipo de Fatura</th><th>Inserida Por</th><th>Total de Fatura</th><th>Coimas</th><th>Submeter</th></th>
    </tr>
    
    
        <?php
									while($row = mysql_fetch_array($divergencias, MYSQL_NUM)){
									?>
									<form "faturas_divergencias_totais" action ="aplicar_coimas.php" method = "post">
									<tr><td><?php echo $row[0] ?></td><td><?php echo $row[1] ?></td><td><?php echo $row[2] ?></td>
									<td><?php echo $row[3] ?></td><td><?php echo $row[4] ?></td><td><?php echo $row[5] ?></td>
									<td><?php echo $row[6] ?></td><td><?php echo $row[7] ?></td><td><?php echo $row[8] ?></td>
									<td><?php echo $row[9] ?></td>
									<td>
									<select id="coimas" class="form-control input-sm" name="coimas" >
									<option value="" disabled="disabled" selected="selected">Por favor selecione uma opccao</option>
									<?php
									$coimas2= tipo_de_coimas();
									while($row = mysql_fetch_array($coimas2, MYSQL_NUM)){
									?>
									<option value= <?= $row[0] ?>>
									<?php echo $row[1]?>
									</option>
									
									<?php
									}
									?>
									</select>
									</td>
									<td>
									<button onclick="myF()">Submit</button>
									</td>
									</tr>
									</form>
									<?php
									}
									?>        
    
    
</table>

<legend> Faturas com divergencias de Faturas não inseridas </legend>
	<table style="empty-cells:hide;" border="1" class="table" cellpadding="1" cellspacing="1">
    
    <tr>
        <th>Fatura</th><th>Emissor</th><th>Receptor</th><th>Data de emissao</th><th>Data de Registo</th><th>Data Limite</th>
		<th>Beneficio</th><th>Tipo de Fatura</th><th>Inserida Por</th><th>Total de Fatura</th><th>Coimas</th><th>Submeter</th></th>
    </tr>
    
    
        <?php
									while($row = mysql_fetch_array($divergencias2, MYSQL_NUM)){
									?>
									<form "faturas_divergencias_nao_inseridas" action ="aplicar_coimas.php" method = "post">
									<tr><td><?php echo $row[0] ?></td><td><?php echo $row[1] ?></td><td><?php echo $row[2] ?></td>
									<td><?php echo $row[3] ?></td><td><?php echo $row[4] ?></td><td><?php echo $row[5] ?></td>
									<td><?php echo $row[6] ?></td><td><?php echo $row[7] ?></td><td><?php echo $row[8] ?></td>
									<td><?php echo $row[9] ?></td>
									<td>
									<select id="coimas" class="form-control input-sm" name="coimas" >
									<option value="" disabled="disabled" selected="selected">Por favor selecione uma opccao</option>
									<?php
									$coimas2= tipo_de_coimas();
									while($row = mysql_fetch_array($coimas2, MYSQL_NUM)){
									?>
									<option value= <?= $row[0] ?>>
									<?php echo $row[1]?>
									</option>
									
									<?php
									}
									?>
									</select>
									</td>
									<td>
									<button onclick="myF()">Submit</button>
									</td>
									</tr>
									</form>
									<?php
									}
									?>        
    
    
</table>
</body>
</html>
<?php include 'footer.php' ?>