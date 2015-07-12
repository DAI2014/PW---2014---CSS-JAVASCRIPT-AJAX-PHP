<?php
	require_once("./_includes/funcoes.php");
	$ligacao=ligar_base_dados();
 
	$procura=$_GET["descricao"];
	$query=mysql_query("SELECT * from parametros where designacao='$procura' ", $ligacao);
 
	$row = mysql_fetch_array($query);
	echo $row[2];

 
?>