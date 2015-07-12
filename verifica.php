<?php
	require_once("./_includes/funcoes.php");
	$ligacao=ligar_base_dados();
 
	$username=$_POST["username"];
	$query=mysql_query("SELECT * from login where utilizadores_nif = $username ", $ligacao);
 
	$find=mysql_num_rows($query);
 
  echo $find;
 
?>