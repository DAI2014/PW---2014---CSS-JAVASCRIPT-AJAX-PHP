<?php include "header.php"; ?>		
		<title>Bar</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link href="styles.css" rel="stylesheet" />
		<script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/knockout-3.0.0.js"></script>
		<script src="js/globalize.min.js"></script>
		<script src="js/dx.chartjs.js"></script>

	<?php
require_once("lib/nusoap.php");
$client = new nusoap_client("http://localhost/web/teste/servidor.php", false);
?>
<script>
	$(function ()  
				{
   var dataSource = [
    { Ano: "Ano: 2013", total: <?= $client->call("total_faturas") ?>, comerciantes: <?= $client->call("total_faturas_comerciantes") ?>, consumidores: <?= $client->call("total_faturas_consumidores") ?>},
];

$("#chartContainer").dxChart({
    dataSource: dataSource,
    commonSeriesSettings: {
        argumentField: "Ano",
        type: "bar",
        hoverMode: "allArgumentPoints",
        selectionMode: "allArgumentPoints",
        label: {
            visible: true,
            format: "fixedPoint",
            precision: 0
        }
    },
    series: [
	{ valueField: "total", name: "Total" },
        { valueField: "comerciantes", name: "Comerciantes" },
        { valueField: "consumidores", name: "Consumidores" },
    ],
    title: "Numero de faturas inseridas",
    legend: {
        verticalAlignment: "bottom",
        horizontalAlignment: "center"
    },
    pointClick: function (point) {
        this.select();
    }
});
}		
			);
			
	$(function ()  
				{
   var dataSource = [
    { Ano: "Ano: 2013", total_valor: <?= $client->call("total_valor_faturas") ?>, 
	comerciantes_valor: <?= $client->call("total_valor_faturas_consumidor") ?>, 
	consumidores_valor: <?= $client->call("total_valor_faturas_comerciante") ?>},
];

$("#chartContainer2").dxChart({
    dataSource: dataSource,
    commonSeriesSettings: {
        argumentField: "Ano",
        type: "bar",
        hoverMode: "allArgumentPoints",
        selectionMode: "allArgumentPoints",
        label: {
            visible: true,
            format: "fixedPoint",
            precision: 0
        }
    },
    series: [
	{ valueField: "total_valor", name: "Total de faturas inseridas" },
        { valueField: "comerciantes_valor", name: "Por Comerciantes" },
        { valueField: "consumidores_valor", name: "Por Consumidores" },
    ],
    title: "Faturas inseridas em valor /€",
    legend: {
        verticalAlignment: "bottom",
        horizontalAlignment: "center"
    },
    pointClick: function (point) {
        this.select();
    }
});
}		
			);

			
	$(function ()  
				{
   var dataSource = [
    { Ano: "Ano: 2013", total: <?= $client->call("total_faturas_comerciantes") ?>, 
	cab: <?= $client->call("total_faturas_cabeleireiro") ?>, mec: <?= $client->call("total_faturas_mecanico") ?>,
	res: <?= $client->call("total_faturas_restauracao") ?>},
];

$("#chartContainer3").dxChart({
    dataSource: dataSource,
    commonSeriesSettings: {
        argumentField: "Ano",
        type: "bar",
        hoverMode: "allArgumentPoints",
        selectionMode: "allArgumentPoints",
        label: {
            visible: true,
            format: "fixedPoint",
            precision: 0
        }
    },
    series: [
	{ valueField: "total", name: "Total de faturas inseridas por comerciantes" },
        { valueField: "cab", name: "Cabelereiro" },
        { valueField: "mec", name: "Mecanico" },
		{ valueField: "res", name: "Restauracao" },
		
    ],
    title: "Numero de Faturas inseridas por sector de Actividade",
    legend: {
        verticalAlignment: "bottom",
        horizontalAlignment: "center"
    },
    pointClick: function (point) {
        this.select();
    }
});
}		
			);			
			

		</script>
		<br>
		<br>
		<br>
		<br>
		<div class="line"></div>		
		<div class="title">
			<h1>Informações uteis</h1>
		</div>
		<div class="content">
			<div class="pane">
				<div class="long-title"><h3></h3></div>
				<div id="chartContainer" style="width: 100%; height: 440px;"></div>
				
			</div>
		</div>
		<br>
		<br>
		<br>
		<br>
				<div class="content">
			<div class="pane">
				<div class="long-title"><h3></h3></div>
				<div id="chartContainer2" style="width: 100%; height: 440px;"></div>
			</div>
		</div>
		<br>
		<br>
		<br>
		<br>
		<div class="content">
			<div class="pane">
				<div class="long-title"><h3></h3></div>
				<div id="chartContainer3" style="width: 100%; height: 440px;"></div>
				
			</div>
		</div>
		<br>
		<br>
		<br>
		<br>
	</body>
</html>

<?php include "footer.php"; ?>