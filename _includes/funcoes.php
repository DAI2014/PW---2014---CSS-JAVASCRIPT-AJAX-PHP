<?php

define('DEBUG', false);
require_once 'mysql.connect.php';




function ligar_base_dados(){    
    $ligacao = mysql_connect(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD) or die('Erro ao ligar ao servidor...');        
    mysql_select_db(MYSQL_DATABASE, $ligacao) or die('Erro ao selecionar a base de dados...');
    return $ligacao;
}

function inserir_funcionalidades($elemento){
$ligacao=ligar_base_dados();
mysql_query("INSERT INTO funcionalidades values (DEFAULT,'$elemento')",$ligacao);

}

function inserir_tipo_fatura($elemento){
$ligacao=ligar_base_dados();
mysql_query("INSERT INTO Tipo_Fatura values (DEFAULT,'$elemento')",$ligacao);

}

function inserir_coimas($elemento,$elemento2){
$ligacao=ligar_base_dados();
mysql_query("INSERT INTO coimas values (DEFAULT,'$elemento', $elemento2)",$ligacao);

}

function inserir_parametros($elemento,$elemento2){
$ligacao=ligar_base_dados();
mysql_query("INSERT INTO parametros values (DEFAULT,'$elemento', $elemento2)",$ligacao);

}

function inserir_setor_actividade($elemento){
$ligacao=ligar_base_dados();
mysql_query("INSERT INTO setoractividade values (DEFAULT,'$elemento')",$ligacao);

}

function inserir_tipo_utilizador($elemento){
$ligacao=ligar_base_dados();
mysql_query("INSERT INTO tipo_utilizador values (DEFAULT,'$elemento')",$ligacao);

}

function validacao_login($elemento){
$ligacao=ligar_base_dados();
$validacao=mysql_query("SELECT validacao FROM Login where Utilizadores_NIF=$elemento",$ligacao);
if($validacao==1){
	$resultado = true;
} else {
$resultado = false;
}
return $resultado;
}

function login($elemento1, $elemento2){
$ligacao = ligar_base_dados();
$md5= md5($elemento2);
$resultado = mysql_query("SELECT UTILIZADORES_nif from login where utilizadores_nif = $elemento1 and password = '$md5' and validacao=1",$ligacao);
return $resultado;

}

function listar_setor_actividade(){
$ligacao=ligar_base_dados();
$resultado=mysql_query("SELECT DESIGNACAO FROM SetorActividade",$ligacao);
return $resultado;
}

function listar_tipo_utilizador(){
$ligacao=ligar_base_dados();
$resultado=mysql_query("SELECT DESIGNACAO FROM tipo_utilizador",$ligacao);
return $resultado;
}

function lista_login_por_validar(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("SELECT Utilizadores_NIF, bi, nome, morada, telefone, cod_postal, tipo_utilizador.DESIGNACAO, setoractividade.DESIGNACAO, EMAIL
FROM login
INNER JOIN utilizadores ON utilizadores.NIF = login.Utilizadores_NIF
INNER JOIN tipo_utilizador ON utilizadores.Tipo_Utilizador_ID_TIPO = tipo_utilizador.ID_TIPO
INNER JOIN setoractividade ON utilizadores.SetorActividade_ID_SECTOR = setoractividade.ID_SECTOR
WHERE validacao =0",$ligacao);
return $resultado;
}

function lista_login_validados(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("SELECT Utilizadores_NIF, bi, nome, morada, telefone, cod_postal, tipo_utilizador.DESIGNACAO, setoractividade.DESIGNACAO, EMAIL
FROM login
INNER JOIN utilizadores ON utilizadores.NIF = login.Utilizadores_NIF
INNER JOIN tipo_utilizador ON utilizadores.Tipo_Utilizador_ID_TIPO = tipo_utilizador.ID_TIPO
INNER JOIN setoractividade ON utilizadores.SetorActividade_ID_SECTOR = setoractividade.ID_SECTOR
WHERE validacao =1",$ligacao);
return $resultado;
}

function valida_utilizador($elemento){
$ligacao= ligar_base_dados();
$resultado = mysql_query("UPDATE login SET VALIDACAO=1 WHERE Utilizadores_NIF=$elemento",$ligacao);
return $resultado;
}

function nao_valida_utilizador($elemento){
$ligacao= ligar_base_dados();
$resultado = mysql_query("DELETE FROM login WHERE Utilizadores_NIF = $elemento",$ligacao);
$resultado2 = mysql_query("DELETE FROM utilizadores WHERE NIF = $elemento",$ligacao);
//return $resultado;

}


function utilizador_por_nif($elemento){
$ligacao = ligar_base_dados();
$resultado = mysql_query("SELECT nif, bi, nome, morada, telefone, cod_postal, tipo_utilizador.DESIGNACAO, setoractividade.DESIGNACAO, EMAIL
FROM utilizadores
INNER JOIN tipo_utilizador ON utilizadores.Tipo_Utilizador_ID_TIPO = tipo_utilizador.ID_TIPO
INNER JOIN setoractividade ON utilizadores.SetorActividade_ID_SECTOR = setoractividade.ID_SECTOR
WHERE NIF =$elemento",$ligacao);
return $resultado;

}


function lista_consumidores_beneficio_maximo(){
$ligacao = ligar_base_dados();
$ben = get_beneficio_maximo();
$resultado = mysql_query("SELECT nif, bi, nome, morada, telefone, cod_postal,total_beneficio, tipo_utilizador.DESIGNACAO, setoractividade.DESIGNACAO, EMAIL
FROM utilizadores
INNER JOIN tipo_utilizador ON utilizadores.Tipo_Utilizador_ID_TIPO = tipo_utilizador.ID_TIPO
INNER JOIN setoractividade ON utilizadores.SetorActividade_ID_SECTOR = setoractividade.ID_SECTOR
where total_beneficio>=$ben ",$ligacao);
return $resultado;
}

function inserir_fatura($ele1,$ele2,$ele3,$ele4,$ele5,$ele6,$ele7){
$ligacao = ligar_base_dados();

$parts = explode('/', $ele4);
$parts[0] = 25;
if($parts[1]>=12){
$parts[1]=1;
$parts[2]++;
}else{
$parts[1]++;
} 
$dataemissao = $ele4;
$limite = implode('/', $parts);
$hoje = date("d/m/y");
if(verifica_comerciante($ele6)){
$beneficio=0;
}else{
$beneficio = $ele7 * get_beneficio();
$beneficiototal = beneficio_consumidor($ele6) + $beneficio;
$res = mysql_query("update utilizadores set total_beneficio=$beneficiototal where nif=$ele6",$ligacao);
}

$resultado = mysql_query("insert into faturas(`N_FATURA`,`Utilizadores_NIF(EMISSOR)`,`NIF_RECEPTOR`,
 `DATA_FATURA`,`DATA_REGISTO`,`DATA_LIMITE`,`Beneficio`,`Tipo_Fatura_ID_Tipo_Fatura`,`inserido_por`, `totalfatura`, `Coimas_ID_COIMA`) 
 values('$ele1',$ele2, $ele3, '$ele4', '$hoje', '$limite', $beneficio,$ele5,$ele6,$ele7,4)",$ligacao);

}

function get_beneficio(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select valor from parametros where designacao like 'beneficiot%'",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

function beneficio_por_nif($elemento){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select nif,nome,total_beneficio from utilizadores where nif=$elemento",$ligacao);
}

function get_taxa($elemento){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select ID_PARAMETRO from parametros where valor=$elemento and designacao like 'iva%'",$ligacao);
$result = mysql_fetch_assoc($resultado);
return $result['ID_PARAMETRO'];
}


function nome($elemento){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select nome from utilizadores where nif=$elemento",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

function inserir_linha($ele0,$ele1,$ele2,$ele3,$ele4,$ele5,$ele6){
$ligacao = ligar_base_dados();
$resultado = mysql_query("insert into faturalinha (`n_linha`,`iva`,`taxa`,`total`, `base_tributavel`,`faturas_n_fatura`,`faturas_inserido_por`) 
						  values ($ele0, $ele1,$ele2,$ele3,$ele4,'$ele5',$ele6)",$ligacao);

}

function lista_faturas($ele){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select n_fatura, `Utilizadores_NIF(EMISSOR)`, NIF_RECEPTOR, DATA_FATURA,DATA_REGISTO,DATA_LIMITE,Beneficio, 
tipo_fatura.Descricao,Inserido_Por,totalfatura from faturas
inner join tipo_fatura on faturas.Tipo_Fatura_ID_Tipo_Fatura = tipo_fatura.ID_Tipo_Fatura
where inserido_por=$ele",$ligacao);
return $resultado;
}

function lista_faturas_limite(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select n_fatura, `Utilizadores_NIF(EMISSOR)`, NIF_RECEPTOR, DATA_FATURA,DATA_REGISTO,DATA_LIMITE,Beneficio, 
tipo_fatura.Descricao,Inserido_Por,totalfatura from faturas
inner join tipo_fatura on faturas.Tipo_Fatura_ID_Tipo_Fatura = tipo_fatura.ID_Tipo_Fatura
where str_to_date(data_registo, '%d/%m/%Y')>str_to_date(data_limite, '%d/%m/%Y')  and `Utilizadores_nif(emissor)`=inserido_por and coimas_id_coima=4 ", $ligacao);
return $resultado;

}

function aplicar_coimas(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select n_fatura, `Utilizadores_NIF(EMISSOR)`, NIF_RECEPTOR, DATA_FATURA,DATA_REGISTO,DATA_LIMITE,Beneficio, coimas.valor, 
tipo_fatura.Descricao,Inserido_Por,totalfatura from faturas
inner join tipo_fatura on faturas.Tipo_Fatura_ID_Tipo_Fatura = tipo_fatura.ID_Tipo_Fatura
inner join coimas on faturas.CoimasAplicadas_Coimas_ID_COIMA = coimas.valor
where str_to_date(data_registo, '%d/%m/%Y')>str_to_date(data_limite, '%d/%m/%Y')  and `Utilizadores_nif(emissor)`=inserido_por and `CoimasAplicadas_Coimas_ID_COIMA` IS NOT NULL", $ligacao);
return $resultado;

}


function verifica_admin($ele){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select * from utilizadores where nif=$ele and tipo_utilizador_id_tipo=1",$ligacao);
if(mysql_num_rows($resultado) != 1){
$resultado = false;
}else{
$resultado = true;
}
return $resultado;
}

function verifica_comerciante($ele){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select * from utilizadores where nif=$ele and tipo_utilizador_id_tipo=3",$ligacao);
if(mysql_num_rows($resultado) != 1){
$resultado = false;
}else{
$resultado = true;
}
return $resultado;
}

function verifica_consumidor($ele){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select * from utilizadores where nif=$ele and tipo_utilizador_id_tipo=2",$ligacao);
if(mysql_num_rows($resultado) != 1){
$resultado = false;
}else{
$resultado = true;
}
return $resultado;
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

function total_utilizadores_beneficio(){
$ligacao = ligar_base_dados();
$ben = get_beneficio_maximo();
$resultado = mysql_query("select count(*) from mydb.utilizadores where total_beneficio>=$ben",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

function get_beneficio_maximo(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select valor from parametros where designacao like 'beneficiomax%'",$ligacao);
$result = mysql_fetch_assoc($resultado);
return $result['valor'];
}

function soma_faturas(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("SELECT SUM(totalfatura) FROM mydb.faturas where inserido_por=`utilizadores_nif(emissor)`",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

function get_taxa_beneficio(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select valor from parametros where designacao like 'beneficiota%'",$ligacao);
$result = mysql_fetch_assoc($resultado);
return $result['valor'];
}

function altera_morada($ele,$ele2){
$ligacao = ligar_base_dados();
$resultado = mysql_query("update utilizadores set morada='$ele2' where nif=$ele",$ligacao);
}

function altera_telefone($ele,$ele2){
$ligacao = ligar_base_dados();
$resultado = mysql_query("update utilizadores set telefone='$ele2' where nif=$ele",$ligacao);
}

function altera_cod_postal($ele,$ele2){
$ligacao = ligar_base_dados();
$resultado = mysql_query("update utilizadores set cod_postal='$ele2' where nif=$ele",$ligacao);
}

function altera_email($ele,$ele2){
$ligacao = ligar_base_dados();
$resultado = mysql_query("update utilizadores set email='$ele2' where nif=$ele",$ligacao);
}

function altera_password($ele,$ele2,$ele3){
$ligacao = ligar_base_dados();
if((verifica_password($ele,$ele2))==true){
$md5= md5($ele3);
$hoje = date("d/m/y");
$resultado = mysql_query("update login set password='$md5' where utilizadores_nif=$ele",$ligacao);
$resultado = mysql_query("update login set data_alteracao='$hoje' where utilizadores_nif=$ele",$ligacao);

}
}

function verifica_data_password($ele){
$ligacao = ligar_base_dados();
$hoje = date("d/m/y");
$hoje2 = strtotime($hoje);
$resultado = mysql_query("select data_alteracao from login where Utilizadores_NIF=$ele",$ligacao);
$row = mysql_fetch_array($resultado);
$data_al = $row[0];
$data_str = strtotime($data_al);
$data_limite = strtotime($data_al,"+ 1 year");
if($hoje2>$data_limite){
$resultado2 = true;
} else {
$resultado2 = false;
}
return $resultado2;
}

function verifica_password($ele,$ele2){
$ligacao = ligar_base_dados();
$md5= md5($ele2);
$resultado = mysql_query("select * from login where utilizadores_nif=$ele and password='$md5'",$ligacao);
if(mysql_num_rows($resultado) != 1){
$resultado = false;
}else{
$resultado = true;
}
return $resultado;

}

function beneficio_consumidor($ele){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select total_beneficio from utilizadores where nif=$ele",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

function soma_iva_por_nif($ele){
$ligacao = ligar_base_dados();
$resultado = mysql_query("SELECT SUM(iva) FROM faturalinha  where faturas_inserido_por=$ele",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

function soma_faturas_por_nif($ele){
$ligacao = ligar_base_dados();
$resultado = mysql_query("SELECT SUM(totalfatura) FROM faturas where inserido_por=`utilizadores_nif(emissor)` and`utilizadores_nif(emissor)`=$ele ",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

function fecho_de_atividade($ele){
$ligacao = ligar_base_dados();
$resultado = mysql_query("update utilizadores set fecho_atividade=1 where nif=$ele",$ligacao);
$resultado = mysql_query("update login set validacao=0 where utilizadores_nif=$ele",$ligacao);
}

function verifica_divergencias(){

$ligacao = ligar_base_dados();
$resultado = mysql_query("SELECT a.n_fatura, a.`Utilizadores_NIF(EMISSOR)`, a.NIF_RECEPTOR, a.DATA_FATURA,a.DATA_REGISTO,a.DATA_LIMITE,
a.Beneficio, tipo_fatura.Descricao,a.Inserido_Por,a.totalfatura
FROM faturas a
INNER JOIN faturas b ON a.n_fatura = b.n_fatura
inner join tipo_fatura on a.Tipo_Fatura_ID_Tipo_Fatura = tipo_fatura.ID_Tipo_Fatura
WHERE a.totalfatura <> b.totalfatura",$ligacao);
return $resultado;
}

function verifica_divergencias_nao_inseridas(){

$ligacao = ligar_base_dados();
$resultado = mysql_query("SELECT n_fatura, `Utilizadores_NIF(EMISSOR)`, NIF_RECEPTOR, DATA_FATURA,DATA_REGISTO,DATA_LIMITE,
Beneficio, tipo_fatura.Descricao,Inserido_Por,totalfatura
from faturas
inner join tipo_fatura on Tipo_Fatura_ID_Tipo_Fatura = tipo_fatura.ID_Tipo_Fatura
where n_fatura in ( SELECT N_FATURA
from faturas
group by n_fatura
having count(*) <= 1) and `Utilizadores_NIF(EMISSOR)` <> inserido_por", $ligacao);
return $resultado;

}

function verifica_divergencias_coimas(){

$ligacao = ligar_base_dados();
$resultado = mysql_query("SELECT a.n_fatura, a.`Utilizadores_NIF(EMISSOR)`, a.NIF_RECEPTOR, a.DATA_FATURA,a.DATA_REGISTO,a.DATA_LIMITE,
a.Beneficio, tipo_fatura.Descricao,a.Inserido_Por,a.totalfatura
FROM faturas a
INNER JOIN faturas b ON a.n_fatura = b.n_fatura
inner join tipo_fatura on a.Tipo_Fatura_ID_Tipo_Fatura = tipo_fatura.ID_Tipo_Fatura
WHERE a.totalfatura <> b.totalfatura and a.Inserido_Por=a.`Utilizadores_NIF(EMISSOR)`",$ligacao);
return $resultado;
}


function lista_todas_faturas(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select n_fatura, `Utilizadores_NIF(EMISSOR)`, NIF_RECEPTOR, DATA_FATURA,DATA_REGISTO,DATA_LIMITE,Beneficio, 
tipo_fatura.Descricao,Inserido_Por,totalfatura from faturas
inner join tipo_fatura on faturas.Tipo_Fatura_ID_Tipo_Fatura = tipo_fatura.ID_Tipo_Fatura",$ligacao);
return $resultado;
}

function bloqueio_comerciantes($ele){
$ligacao= ligar_base_dados();
$resultado = mysql_query("UPDATE login SET VALIDACAO=0 WHERE Utilizadores_NIF=$ele",$ligacao);
return $resultado;
}

function lista_comerciantes(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("SELECT nif, bi, nome, morada, telefone, cod_postal, tipo_utilizador.DESIGNACAO, setoractividade.DESIGNACAO, EMAIL
FROM utilizadores
INNER JOIN tipo_utilizador ON utilizadores.Tipo_Utilizador_ID_TIPO = tipo_utilizador.ID_TIPO
INNER JOIN setoractividade ON utilizadores.SetorActividade_ID_SECTOR = setoractividade.ID_SECTOR
where tipo_utilizador.ID_tipo=3",$ligacao);
return $resultado;
}

function lista_consumidores(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("SELECT nif, bi, nome, morada, telefone, cod_postal, tipo_utilizador.DESIGNACAO, setoractividade.DESIGNACAO, EMAIL
FROM utilizadores
INNER JOIN tipo_utilizador ON utilizadores.Tipo_Utilizador_ID_TIPO = tipo_utilizador.ID_TIPO
INNER JOIN setoractividade ON utilizadores.SetorActividade_ID_SECTOR = setoractividade.ID_SECTOR
where tipo_utilizador.ID_tipo=2",$ligacao);
return $resultado;

}

function lista_coimas(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select n_fatura, `Utilizadores_NIF(EMISSOR)`, NIF_RECEPTOR, DATA_FATURA,DATA_REGISTO,DATA_LIMITE,Beneficio, 
tipo_fatura.Descricao,Inserido_Por,totalfatura, coimas.valor from faturas
inner join tipo_fatura on faturas.Tipo_Fatura_ID_Tipo_Fatura = tipo_fatura.ID_Tipo_Fatura
inner join coimas on faturas.coimas_id_coima = coimas.id_coima
where Coimas_ID_COIMA<>4 ",$ligacao);
return $resultado;

}

function lista_coimas_por_nif($ele){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select n_fatura, coimas.valor from faturas
inner join coimas on faturas.coimas_id_coima = coimas.id_coima
where Coimas_ID_COIMA<>4 and inserido_por=$ele",$ligacao);
return $resultado;

}

function lista_parametros(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select id_parametro,designacao from parametros",$ligacao);
return $resultado;

}

function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}

function get_id_parametros($ele){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select id_parametro from parametros where valor = $ele",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

function get_id_tipo_fatura($ele){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select id_tipo_fatura from tipo_fatura where descricao = '$ele'",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
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

function altera_parametros($ele1,$ele2){
$ligacao = ligar_base_dados();
$resultado = mysql_query("update parametros set valor=$ele1 where id_parametro=$ele2",$ligacao);

}
function total_faturas_comerciantes(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select count(*) from faturas where
Inserido_Por in (
select  NIF from utilizadores where Tipo_Utilizador_ID_TIPO = 3)",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

function n_consumidores(){
$ligacao = ligar_base_dados();
$resultado = mysql_query("select count(*) from utilizadores where Tipo_Utilizador_ID_TIPO=2",$ligacao);
$row = mysql_fetch_array($resultado);
return $row[0];
}

function total_beneficio_potencial(){
$ligacao = ligar_base_dados();
$total = total_valor_faturas_comerciante() * get_taxa_beneficio();
return $total;
}



?>

