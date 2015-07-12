<?php include 'header.php' ?>

<body>
<br />
<br />
<div class="bootstrap">
      <div class="container">
        <h1>Bem Vindo ao EFactur-UM</h1>
		<?php
if($_SESSION['username']==0){
?>
        <p>Por favor faça Login 1º</p>
        <p><a href="login.php" class="btn btn-primary btn-lg" role="button">LOGIN</a></p>
		<?php
		}
		?>
      </div>
    </div>
	
	
<!-- Imagens -->	
	<div class="row" style="text-align: center">
    <img src="images/automoveis.jpg" alt="" />
	<img src="images/motociclos.jpg" alt="" />
	<img src="images/restauracao.jpg" alt="" />
	<img src="images/cabeleireiros.jpg" alt="" />
	</div>
</body>

<?php include "footer.php"; ?>