<?php
	$db = new PDO('sqlite:subzarre.db');

	// comma seperated, array, unique
	// race/ethnicity
	$reSQL = "select raceEthnicity from tags where content not like '%secondchannel%'";
	$reResult = $db->query($reSQL);
	$reRows = $reResult->fetchAll();
	$reString = "";
	foreach ($reRows as $key => $reRow) {
		if ($key == 0) {
			$reString .= $reRow[0];
		}
		elseif (empty($reRow[0])) {
			$reString .= ",N/A";
		}
		else {
			$reString .= ",".$reRow[0];
		}
	}
	$reArray = explode(",", $reString);
	$reArray = array_count_values($reArray);
	asort($reArray);

	// nationality
	$natSQL = "select nationality from tags where content not like '%secondchannel%'";
	$natResult = $db->query($natSQL);
	$natRows = $natResult->fetchAll();
	$natString="";
	foreach ($natRows as $key => $natRow) {
		if ($key == 0) {
			$natString .= $natRow[0];
		}
		elseif (empty($natRow[0])) {
			$natString .= ",N/A";
		}
		else {
			$natString .= ",".$natRow[0];
		}
	}
	$natArray = explode(",", $natString);
	$natArray = array_count_values($natArray);
	asort($natArray);

	// gender
	$genderSQL = "select gender from tags where content not like '%secondchannel%'";
	$genderResult = $db->query($genderSQL);
	$genderRows = $genderResult->fetchAll();
	$genderString="";
	foreach ($genderRows as $key => $genderRow) {
		if ($key == 0) {
			$genderString .= $genderRow[0];
		}
		elseif (empty($genderRow[0])) {
			$genderString .= ",N/A";
		}
		else {
			$genderString .= ",".$genderRow[0];
		}
	}
	$genderArray = explode(",", $genderString);
	$genderArray = array_count_values($genderArray);
	asort($genderArray);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Subzarre - Analytics</title>
	<script src="js/jquery-3.5.1.min.js"></script>
	<script src="js/jquery.canvasjs.min.js"></script>
	<style type="text/css">
		* {font-family: sans-serif;}
		body {
			color: #C7CBCF;
			background-color: #202124;
		}
		.header {
			display: flex;
			justify-content: space-between;
		}
		.headerLeft {
			display: flex;
			margin-left: 50px;
		}
		.headerRight {
			display: flex;
			margin-right: 50px;
			align-items: center;
		}
		.button {
			background-color: #323639;
			color: #C7CBCF;
			cursor: pointer;
			padding: 5px 10px;
			margin: 4px 2px;
			border: 1px solid #C7CBCF;
		}
		.outerUL {
			display: flex;
			flex-wrap: wrap;
			list-style: none;
			justify-content: space-around;
		}
		.chart {
			width: 500px;
			height: 700px;
			border: 1px solid #C7CBCF;
		}
	</style>
</head>
<body>
	<!-- header -->
	<div class="header">
		<!-- left side -->
		<div class="headerLeft">
			<!-- title -->
			<h1>Subzarre</h1>
		</div>
		<!-- right side -->
		<div class="headerRight">
			<!-- search -->
			<a href="index.php"><button class="button" id="buttonHome">Home</button></a>
		</div>
	</div>

	<!-- charts -->
	<div class="charts">
		<script type="text/javascript">
			$(function() {
				// race/ethnicity chart
				var reChart = new CanvasJS.Chart("reChart",
					{
						backgroundColor: "#202124", 
						axisX: {
							interval: 1,
							gridColor: "#C7CBCF",
							labelFontColor: "#C7CBCF",
							lineColor: "#C7CBCF",
							tickColor: "#C7CBCF"
						},
						axisY: {
							gridColor: "#C7CBCF",
							labelFontColor: "#C7CBCF",
							lineColor: "#C7CBCF",
							tickColor: "#C7CBCF"
						},
						data: [
							{
								type: "bar",
								color: "#C7CBCF",
								dataPoints: [
									<?php
										foreach ($reArray as $reKey => $reCount) {
											if ($reKey == array_key_last($reArray)) {
												echo "{ y: ".$reCount.", label: '".$reKey."'}";
											}
											else {
												echo "{ y: ".$reCount.", label: '".$reKey."'},";
											}
										}
									?>
								]
							}
						]
					}
				);

				// nationality chart
				var natChart = new CanvasJS.Chart("natChart",
					{
						backgroundColor: "#202124", 
						axisX: {
							interval: 1,
							gridColor: "#C7CBCF",
							labelFontColor: "#C7CBCF",
							lineColor: "#C7CBCF",
							tickColor: "#C7CBCF"
						},
						axisY: {
							gridColor: "#C7CBCF",
							labelFontColor: "#C7CBCF",
							lineColor: "#C7CBCF",
							tickColor: "#C7CBCF"
						},
						data: [
							{
								type: "bar",
								color: "#C7CBCF",
								dataPoints: [
									<?php
										foreach ($natArray as $natKey => $natCount) {
											if ($natKey == array_key_last($natArray)) {
												echo "{ y: ".$natCount.", label: '".$natKey."'}";
											}
											else {
												echo "{ y: ".$natCount.", label: '".$natKey."'},";
											}
										}
									?>
								]
							}
						]
					}
				);

				// gender chart
				var genderChart = new CanvasJS.Chart("genderChart",
					{
						backgroundColor: "#202124", 
						axisX: {
							interval: 1,
							gridColor: "#C7CBCF",
							labelFontColor: "#C7CBCF",
							lineColor: "#C7CBCF",
							tickColor: "#C7CBCF"
						},
						axisY: {
							gridColor: "#C7CBCF",
							labelFontColor: "#C7CBCF",
							lineColor: "#C7CBCF",
							tickColor: "#C7CBCF"
						},
						data: [
							{
								type: "bar",
								color: "#C7CBCF",
								dataPoints: [
									<?php
										foreach ($genderArray as $genderKey => $genderCount) {
											if ($genderKey == array_key_last($genderArray)) {
												echo "{ y: ".$genderCount.", label: '".$genderKey."'}";
											}
											else {
												echo "{ y: ".$genderCount.", label: '".$genderKey."'},";
											}
										}
									?>
								]
							}
						]
					}
				);

				reChart.render();
				natChart.render();
				genderChart.render();
			})
		</script>
		<ul class="outerUL">
			<li>
				<h4>Race/Ethnicity</h4>
				<div id="reChart" class="chart"></div>
			</li>
			<li>
				<h4>Nationality</h4>
				<div id="natChart" class="chart"></div>
			</li>
			<li>
				<h4>Gender</h4>
				<div id="genderChart" class="chart"></div>
			</li>
		</ul>
	</div>
	
</body>
</html>