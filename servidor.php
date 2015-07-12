<?php
define('DEBUG', false);
require_once ('_includes/mysql.connect.php');
require_once("lib/nusoap.php");

$server = new nusoap_server;
$server->register("total_faturas");
$server->register("total_faturas_cabeleireiro");
$server->register("total_faturas_mecanico");
$server->register("total_faturas_restauracao");
$server->register("total_faturas_consumidores");
$server->register("total_faturas_comerciantes");
$server->register("total_valor_faturas");
$server->register("total_valor_faturas_consumidor");
$server->register("total_valor_faturas_comerciante");

function ligar_base_dados(){    
    $ligacao = mysql_connect(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD) or die('Erro ao ligar ao servidor...');        
    mysql_select_db(MYSQL_DATABASE, $ligacao) or die('Erro ao selecionar a base de dados...');
    return $ligacao;
}

function total_valor_faturas(){

$ligacao = ligar_base_dados();
$resultado = mysql_query("select sum(totalfatura) from faturas",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

function total_valor_faturas_consumidor(){

$ligacao = ligar_base_dados();
$resultado = mysql_query("
select sum(totalfatura) from faturas where
Inserido_Por in (
select  NIF from utilizadores where Tipo_Utilizador_ID_TIPO = 2)",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

function total_valor_faturas_comerciante(){

$ligacao = ligar_base_dados();
$resultado = mysql_query("
select sum(totalfatura) from faturas where
Inserido_Por in (
select  NIF from utilizadores where Tipo_Utilizador_ID_TIPO = 3)",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

function total_faturas_comerciantes(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select count(*) from faturas where Inserido_Por in 
(select NIF from utilizadores where tipo_utilizador_id_tipo = 3)",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

function total_faturas_consumidores(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select count(*) from faturas where Inserido_Por in 
(select NIF from utilizadores where tipo_utilizador_id_tipo = 2)",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

function total_faturas(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select count(*) from faturas",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

function total_faturas_cabeleireiro(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select count(*) from faturas, utilizadores where utilizadores.SetorActividade_ID_SECTOR=1 and 
faturas.Inserido_Por=utilizadores.NIF",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

function total_faturas_mecanico(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select count(*) from faturas, utilizadores where utilizadores.SetorActividade_ID_SECTOR=2 and 
faturas.Inserido_Por=utilizadores.NIF",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

function total_faturas_restauracao(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select count(*) from faturas, utilizadores where utilizadores.SetorActividade_ID_SECTOR=3 and 
faturas.Inserido_Por=utilizadores.NIF",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : "";
$server->service($HTTP_RAW_POST_DATA);

?>