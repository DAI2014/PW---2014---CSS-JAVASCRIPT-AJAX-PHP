<?php include "header.php"; ?>

<?php
require_once("./_includes/funcoes.php");
ligar_base_dados();
?>

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
<legend> Total de Faturacao por NIF</legend>
<table style="empty-cells:hide;" border="1" class="table" cellpadding="1" cellspacing="1">
	<tr>
        <th>Total de faturacao</th><td><?= soma_faturas_por_nif($_SESSION['username']) ?>€</td>
    </tr>
	<br/>
	<tr>
        <th>Total iva suportado</th><td><?= soma_iva_por_nif($_SESSION['username']) ?>€</td>
    </tr>
</table>

<?php include "footer.php"; ?>