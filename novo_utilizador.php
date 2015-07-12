
<?php include 'header.php' ?>
<script src=“js/prototype.js” type=“text/javascript”></script>
<body>
<br />
<br />
<br />
<br />
<br />
<br />
<?php

require_once("./_includes/funcoes.php");
ligar_base_dados();
$utilizador = mysql_query("SELECT ID_TIPO, DESIGNACAO FROM tipo_utilizador WHERE ID_TIPO > 1");
$setor = mysql_query("SELECT ID_SECTOR, DESIGNACAO FROM setoractividade");
?>


<form action="novo_utilizador.php" method="post" id="form" name="form" onSubmit="return valida()">

<fieldset>
    <legend>Novo Utilizador</legend>

				<div class="col-xs-4"> 
                NIF: <input type="text" class="form-control input-sm" maxlength="9px" name="fnif" id="fnif" autocomplete="off" onBlur = "verificaNif()" required><span id="message"></span><br /> 
                NOME: <input type="text" class="form-control input-sm" name="fnome" id="fnome" maxlength="60px" required><span id="message1" > </span><br />
                MORADA: <input type="text" class="form-control input-sm" id="fmorada" name="fmorada" required><br />
                TELEFONE: <input type="text" class="form-control input-sm" maxlength="9px" id="ftelefone" name="ftelefone" required><span id="message3"></span><br />
                CODIGO POSTAL: <input type="text" class="form-control input-sm" maxlength="7px" id="fcodPostal" name="fcodPostal"  required><span id="message4"></span><br />
                BI: <input type="text" class="form-control input-sm" maxlength="9px" id="fbi" name="fbi" required><span id="message5" ></span><br />
                EMAIL: <input type="email" class="form-control input-sm" name="femail" id ="femail" required ><br />
                TIPO DE UTILIZADOR: <select name="stu" class="form-control input-sm" required>
									<option value="" disabled="disabled" selected="selected">Por favor selecione uma opccao</option>
									<?php
									while($row = mysql_fetch_array($utilizador, MYSQL_NUM)){
									?>
									<option value= <?= $row[0] ?>><?php echo $row[1] ?> </option>;
									<?php
									}
									?>
									</select>
									<br/>
				
				TIPO DE SETOR: <select name="sta" class="form-control input-sm"required >
									<option value="" disabled="disabled" selected="selected">Por favor selecione uma opccao</option>
									<?php
									while($row = mysql_fetch_array($setor, MYSQL_NUM)){
									?>
									<option value= <?= $row[0] ?>><?php echo $row[1] ?></option>;
									<?php
									}
									?>
									</select>
				<input type="submit"/>
				</div>
				</fieldset>
</form>

<script>
function verificaNif(){
			var isvalid = true;
            var username=$("#fnif").val();
			var elem2 = document.getElementById("message");
			if(username.length==9){
              $.ajax({
                    type:"post",
                    url:"verifica.php",
                    data:"username="+username,
                        success:function(data){						
                        if(data==0){
							elem2.style.color = "Green"
							elem2.innerHTML = "nif valido"
							
                        }
                        else{
							elem2.style.color = "Red"
							elem2.innerHTML = "nif invalido"
							isvalid = false;
                        }
                    }
                 });
				 } else {
				elem2.style.color = "Red"
				elem2.innerHTML = "nif invalido"
				isvalid = false;
				}
				return isvalid;
            }
			
function valida() {
var isvalid = true;


if(verifica_nome()==false || verifica_telefone()==false || verificaNif()==false || verifica_cp()==false || verifica_bi()==false  ){
isvalid=false;
}
	
return isvalid;
}

function verifica_nome(){
var elem = document.getElementById("message1");
elem.innerHTML = "";
var isvalid1 = true;
var nome = document.forms["form"]["fnome"].value;
var n = /^[-A-Z ]+$/i.test(nome);
if(n==false || nome.length<10){
	isvalid1=false;
	elem.style.color = "Red";
	elem.innerHTML = "nome invalido";
	};

return isvalid1;
};

function verifica_telefone(){
var elem3 = document.getElementById("message3");
elem3.innerHTML = "";
var isvalid2 = true;
var telefone = document.forms["form"]["ftelefone"].value;
var tel = telefone.match(/^\d+$/);
if(telefone.length!=9 || tel==null) {
    isvalid2 = false;
	elem3.style.color = "Red";
	elem3.innerHTML = "telefone invalido";
};
return isvalid2;
};

function verifica_bi(){
var elem5 = document.getElementById("message5");
elem5.innerHTML = "";
var isvalid3 = true;
var bi = document.forms["form"]["fbi"].value;
var b = bi.match(/^\d+$/);
if(bi.length!=9 || b==null) {
    isvalid3 = false;
	elem5.style.color = "Red";
	elem5.innerHTML = "nº de bi invalido";
};
return isvalid3;
};

function verifica_cp(){
var elem4 = document.getElementById("message4");
elem4.innerHTML = "";
var isvalid4 = true;
var cp = document.forms["form"]["fcodPostal"].value;
var c = cp.match(/^\d+$/);
if(cp.length!=7 || c==null) {
    isvalid4 = false;
	elem4.style.color = "Red";
	elem4.innerHTML = "codigo postal invalido - ex: xxxxyyy";
};
return isvalid4;
};

</script>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
require_once("./_includes/funcoes.php");
$ligacao=ligar_base_dados();

$val1 = htmlentities($_POST['fnif']);
$val2 = htmlentities($_POST['fbi']);
$val3 = htmlentities($_POST['fnome']);
$val4 = htmlentities($_POST['fmorada']);
$val5 = htmlentities($_POST['ftelefone']);
$val6 = htmlentities($_POST['fcodPostal']);
$val7 = htmlentities($_POST['femail']);
$val8 = htmlentities($_POST['stu']);
$val9 = htmlentities($_POST['sta']);
$val10 = random_string(10);
$val11 = md5($val10);


require_once ("C:/xampp/php/pear/Mail.php");

$from = 'nuno.e.freitas@gmail.com';
$to = $val7;
$subject ='Registo Portal E-Fatur-UM';
$body = "Bom Dia Sr. $val3, \n \n Obrigado por se registar no portal E-Fatur-UM, o seu login de acesso ao nosso site e '$val1' 
a sua password de acesso e '$val10', devera alterar a sua password quando efectuar o login no portal.\n \n Atentamente, \n Nuno Freitas. ";

$headers = array(
    'From' => $from,
    'To' => $to,
    'Subject' => $subject
);

$smtp = Mail::factory('smtp', array(
        'host' => 'ssl://smtp.gmail.com',
        'port' => '465',
        'auth' => true,
        'username' => 'nuno.e.freitas@gmail.com',
        'password' => 'guimaraes1'
    ));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
    echo('<p>' . $mail->getMessage() . '</p>');
} else {
    echo('<p>Mensagem enviada com sucesso!</p>');
}



mysql_query("INSERT INTO utilizadores (NIF, BI, NOME, MORADA, TELEFONE, 
  COD_POSTAL, TOTAL_BENEFICIO, FECHO_ATIVIDADE, Tipo_Utilizador_ID_TIPO, SetorActividade_ID_SECTOR, EMAIL)
    VALUES ($val1, $val2, '$val3', '$val4', $val5, '$val6', 0, 0, $val8, $val9, '$val7')", $ligacao);
	
mysql_query("INSERT INTO login (Utilizadores_NIF, PASSWORD, VALIDACAO) VALUES ($val1,'$val11',0)", $ligacao );

}

?>		
<?php include "footer.php"; ?>