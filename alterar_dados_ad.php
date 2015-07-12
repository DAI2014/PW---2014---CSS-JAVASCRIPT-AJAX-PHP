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
        
function ajaxFunction(){
var val = $("#parametros option:selected").text();

    var ajaxRequest;  // The variable that makes Ajax possible!

    try{
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e){
        // Internet Explorer Browsers
        try{
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try{
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e){
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }
    // Create a function that will receive data sent from the server
    ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
			var valor = ajaxRequest.responseText;
			//alert(valor);
			var ajaxDisplay = document.getElementById('ajaxDiv');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
            //document.getElementByID('va').innerHTML=ajaxRequest.responseText;
			//$("va").html(ajaxRequest.responseText);

        }
    }
    ajaxRequest.open("get", "altera_dados_ajax.php?descricao="+val,true);
    ajaxRequest.send(null); 


}
</script>

	
	
<?php

require_once("./_includes/funcoes.php");
ligar_base_dados();
function tipo_de_coimas(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select * from coimas",$ligacao);
return $resultado;
}
$parametros = lista_parametros();
?>
	<br>
	<br>
	<h3> Alteração de Dados</h3>
	<br>
	<br>
	<legend> Alteração de Parametros </legend>
    
	
								
	<form action="alterar_dados_ad.php" method="post">								
									<select id="parametros"  name="parametros"onChange="ajaxFunction()">
									<option value="" disabled="disabled" selected="selected">Por favor selecione uma opccao</option>
									<?php
									while($row = mysql_fetch_array($parametros, MYSQL_NUM)){
									?>
									<option value= <?= $row[0] ?>>
									<?php echo $row[1]?>
									</option>
									
									<?php
									}
									?>
									</select>

									<br>
									<br>
	<label> Valor actual </label><div id='ajaxDiv'></div>
	<br>
	<br>
	<label> Novo valor </label> <input id="nv" name="nv" type = "text">
	<input type="submit">
	</form>
	
<?php
require_once("./_includes/funcoes.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $val1 = htmlentities($_POST['parametros']);
	$val2 = htmlentities($_POST['nv']);
	altera_parametros($val2,$val1);
} 


?>
    
   

</body>
</html>
<?php include 'footer.php' ?>