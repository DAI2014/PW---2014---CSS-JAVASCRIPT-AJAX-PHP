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
require_once("./_includes/funcoes.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){

$allowedExts = array("txt");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if (($_FILES["file"]["size"] < 20000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
		echo "Ficheiro carregado com sucesso";
		$nome = $_FILES["file"]["name"];
		$f=file_get_contents("upload/" .$nome);
		$faturas = explode('?',$f);
		for($i=0; $i<count($faturas);$i++){
		$fatura = explode('!',$faturas[$i]);
		$cabecalho = explode(',',$fatura[0]);
		$linhas = explode('&',$fatura[1]);
		$nfatura = $cabecalho[0];
		$nifemissor = $cabecalho[1];
		$nifreceptor = $cabecalho[2];
		$data = $cabecalho[3];
		$tipofatura = get_id_tipo_fatura($cabecalho[4]);
		$total = $cabecalho[5];
		$inseridopor = $cabecalho[1];
		inserir_fatura($nfatura,$nifemissor,$nifreceptor,$data,$tipofatura,$inseridopor,$total);
		for($j=0;$j<count($linhas);$j++){
		$linha = explode(',',$linhas[$j]);
		$nlinha = $linha[0];
		$taxa = $linha[1];
		$total_linha = $linha[2];
		$basetributavel = round(($total_linha * $taxa),2);
		$iva = $total_linha - $basetributavel; 
		$idiva = get_id_parametros($taxa);
		inserir_linha($nlinha, $iva, $idiva, $total_linha, $basetributavel,$nfatura ,$inseridopor);
}

}
      }
    }

  }
else
  {
  echo "Invalid file";
  }

}
?>
<br>
<br>
	<legend> Carregar Ficheiro</legend>
	<br>
	<form action="upload_ficheiro.php" method="post" enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file"><br>
<p>Apenas podem ser carregados ficheiros .txt</p>
<input type="submit" name="submit" value="Submit">
</form>



<?php include 'footer.php' ?>