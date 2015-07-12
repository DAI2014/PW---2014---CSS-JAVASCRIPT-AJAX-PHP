<?php include "header.php"; ?>

<meta charset="utf-8">


<br />
<br />
<br />
<br />
<br />
<?php
require_once("./_includes/funcoes.php");
ligar_base_dados();

$tipofatura = mysql_query("SELECT * FROM tipo_fatura");
$iva = mysql_query("select * from parametros where designacao like 'iva%'" );
?>
<legend> Inserir Faturas</legend>
<form method="post" action="inserir_fatura.php">
<p><b>Identificação da Factura</b></p>
<div class="input-group">
  <span class="input-group-addon">NIF Consumidor</span>
  <?php
  if(verifica_consumidor($_SESSION['username'])){
  ?>
  <input value = <?= $_SESSION['username'] ?> readonly="readonly" type="text" class="form-control input-sm" maxlength="9px" placeholder="NIF Consumidor" name="nifconsumidor">
  <?php
  }else{
  ?>
  <input type="text" class="form-control input-sm" maxlength="9px" placeholder="NIF Consumidor" name="nifconsumidor">
  <?php
  }
  ?>
  <span class="input-group-addon">Consumidor</span>
  <?php
  if(verifica_consumidor($_SESSION['username'])){
  $nome= nome($_SESSION['username']);
  ?>
  <input value = <?=  $nome?> type="text" readonly="readonly" class="form-control input-sm" maxlength="100px" placeholder="Nome Consumidor" name="nomeconsumidor">
  <?php
  }else{
  ?>
  <input type="text" class="form-control input-sm" maxlength="100px" placeholder="Nome Consumidor" name="nomeconsumidor">
  <?php
  }
  ?>
</div>
<br>
<div class="input-group">
  <span class="input-group-addon">NIF Comerciante</span>
  <?php
  if(verifica_comerciante($_SESSION['username'])){
  ?>
  <input value = <?= $_SESSION['username'] ?> readonly="readonly" type="text" class="form-control input-sm" maxlength="9px" placeholder="NIF Comerciante" name="nifcomerciante">
   <?php
  }else{
  ?>
  <input type="text" class="form-control input-sm" maxlength="9px" placeholder="NIF Comerciante" name="nifcomerciante">
  <?php
  }
  ?>
</div>
<br />
<div class="input-group">
  <span class="input-group-addon">Numero da Factura</span>
  <input type="text" class="form-control input-sm" maxlength="20px" placeholder="Nº Factura" name ="numerofatura">
  <span class="input-group-addon">Tipo da Factura</span>
  <select name="tipofatura" class="form-control input-sm">
									<option value="" disabled="disabled" selected="selected">Por favor selecione uma opccao</option>
									<?php
									while($row = mysql_fetch_array($tipofatura, MYSQL_NUM)){
									?>
									<option value= <?= $row[0] ?>><?php echo $row[1] ?> </option>;
									<?php
									}
									?>
									</select>
									<br/>
</div>
<hr />


<p><b>Dados da Factura</b></p>
<div class="input-group">
  <span class="input-group-addon">Data Emissão</span>
  <input type="text" class="form-control input-sm" maxlength="20px" placeholder="Insira Dia/Mes/Ano" name="dataemissao">
</div>

<!-- Adicionar e Remover linhas NET -->
<script>
function addRow(tabela) {
	var table = document.getElementById(tabela);
	var rowCount = table.rows.length;
	if(rowCount < 20){                            // limit the user from creating fields more than your limits
		var row = table.insertRow(rowCount);
		var colCount = table.rows[0].cells.length;
		for(var i=0; i<colCount; i++) {
			var newcell = row.insertCell(i);
			newcell.innerHTML = table.rows[0].cells[i].innerHTML;
		}
	}else{
		 alert("Atingiu o limite de linhas");		   
	}
}

function deleteRow(tabela) {
	var table = document.getElementById(tabela);
	var rowCount = table.rows.length;
	for(var i=0; i<rowCount; i++) {
		var row = table.rows[i];
		var chkbox = row.cells[0].childNodes[0];
		if(null != chkbox && true == chkbox.checked) {
			if(rowCount <= 1) {               // limit the user from removing all the fields
				alert("Não pode remover a 1º linha");
				break;
			}
			table.deleteRow(i);
			rowCount--;
			i--;
		}
	}
}


function calcula(){
	
	var nlinhas = document.getElementById("dataTable").rows.length;
	var totalfatura = 0;
	var tbl = document.getElementById("dataTable");
     var rCount = tbl.rows.length;
	 for(var i=0; i<rCount; i++){		
         var total = tbl.rows[i].cells[1].children[1].value;
		 totalfatura = totalfatura + parseInt(total);
		 var piva = tbl.rows[i].cells[2].children[1].value;
		 if(piva==0){
			tbl.rows[i].cells[3].children[1].value = 0;
			tbl.rows[i].cells[4].children[1].value = total;
			}else{
		 tbl.rows[i].cells[3].children[1].value = parseFloat(total - (total/piva)).toFixed(2);
		 tbl.rows[i].cells[4].children[1].value = parseFloat(total/piva).toFixed(2);

		 }
	 }
	 document.getElementById("tf").value = totalfatura;
	 }
	 
  
</script>





<!-- http://techstream.org/Web-Development/PHP/Dynamic-Form-Processing-with-PHP -->

            <fieldset class="row2">
				<legend>Detalhes Factura</legend>
				<p> 
					<input type="button" value="Adicionar Linha" onClick="addRow('dataTable')" /> 
					<input type="button" value="Remover Linha" onClick="deleteRow('dataTable')"  /> 
					<p>(Coloque o visto nas checkbox que queira remover!!)</p>
				</p>
               <table id="dataTable" class="table" border="2">
			   <div class="input-group" >
                    <tr>
                      <p>
						<td><input type="checkbox" required="required" name="chk[]" checked="checked" /></td>
						<td>
							<span class="input-group">TOTAL</span>
							<input type="text" class="form-control input-sm" required="required" name="BX_total[]" id="total[]" >
						 </td>
						 <td>
							<span class="input-group" for="BX_taxa">TAXA</span>
							<select id="txiva[]" class="form-control input-sm" name="taxa_iva[]" onchange="calcula()">
									<option value="" disabled="disabled" selected="selected">Por favor selecione uma opccao</option>
									<?php
									while($row = mysql_fetch_array($iva, MYSQL_NUM)){
									?>
									<option value= <?= $row[2] ?>>
									<?php echo $row[1]?>
									</option>
									
									<?php
									}
									?>
									</select>
									<br/>
						 </td>
						 <td>
							<span class="input-group" for="BX_iva">IVA</span>
							<input type="text" class="form-control input-sm" readonly="readonly" class="small"  name="BX_iva[]" id="iva">
					     </td>
						 <td>
							<span class="input-group" for="BX_base">Base Tributável</span>
							<input type="text" class="form-control input-sm"  readonly="readonly" class="small"  name="BX_base[]" id="base">
						 </td>
							</p>
                    </tr>
					</div>
                </table>
            </fieldset>
			<input type="submit">
			<fieldset class="row2">
				<legend>Total</legend>
			<input type="text" readonly="readonly" name="totalfatura" id="tf">
			</fieldset>
</form>
		<br />
		<br />
		<br />


		
		
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
if($_POST['nifconsumidor']!=null){
$val1 = $_POST['nifconsumidor'];
echo "a";
}else{
$val1 = 0;
echo "b";
}
$val2 = $_POST['nomeconsumidor'];
$val3 = $_POST['nifcomerciante'];
$val4 = $_POST['numerofatura'];
$val5 = $_POST['tipofatura'];
$val6 = $_POST['dataemissao'];
$totalfatura = $_POST['totalfatura'];
$inseridopor = $_SESSION['username'];
require_once("./_includes/funcoes.php");
inserir_fatura($val4, $val3, $val1, $val6, $val5,$inseridopor,$totalfatura);
$n = sizeof($_POST['BX_total']);
for($i=0;$i<$n; $i++){
$total = $_POST['BX_total'][$i];
$taxa = get_taxa($_POST['taxa_iva'][$i]);
$iva = $_POST['BX_iva'][$i];
$base = $_POST['BX_base'][$i];
inserir_linha($i+1,$iva,$taxa,$total,$base,$val4,$inseridopor);

}

}
?>

<?php include "footer.php"; ?>