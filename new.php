<?php
	if(isset($_POST['submit'])) {
		//form submission save
		if (!isset($_POST['id']) || !isset($_POST['content']) || !isset($_POST['arrange'])
			|| !isset($_POST['name']) || !isset($_POST['url']) || !isset($_POST['date'])) {
			echo "<script>alert('Error: Missing Required Field(s)');</script>";
		}
		if (!isset($_POST['raceEth']) || $_POST['raceEth']=="") {
			$subRE = "null";
		} else {
			$subRE = "'" . $_POST['raceEth'] . "'";
		}
		if (!isset($_POST['nation']) || $_POST['nation']=="") {
			$subNat = "null";
		} else {
			$subNat = "'" . $_POST['nation'] . "'";
		}
		if (!isset($_POST['gender']) || $_POST['gender']=="") {
			$subGen = "null";
		} else {
			$subGen = "'" . $_POST['gender'] . "'";
		}

		$db = new PDO('sqlite:subzarre.db');
		$sqlNew = "INSERT INTO channel (id,name,thumbURL,subscribeDate)
				   VALUES
				   ('{$_POST['id']}','{$_POST['name']}','{$_POST['url']}','{$_POST['date']}')";

		$sqlNewTags = "INSERT INTO tags (channelID,content,arrangement,raceEthnicity,nationality,gender)
					   VALUES
					   ('{$_POST['id']}','{$_POST['content']}','{$_POST['arrange']}',{$subRE},{$subNat},{$subGen})";

		$resultNew = $db->query($sqlNew);
		$resultNewTags = $db->query($sqlNewTags);
		if ($resultNew==TRUE && $resultNewTags==TRUE) {
			echo "<script>alert('Subscription Created Successfully');</script>";
		} else {
			echo "<script>alert(" . implode($db->errorInfo()) . ");</script>";
		}

	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Subzarre</title>
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
		.buttonCaution:hover {
			color: red;
		}
		.buttonConfirm:hover {
			color: green;
		}
		.inputs {
			background-color: #323639;
			color: #C7CBCF;
			margin: 10px;
			border: 1px solid #C7CBCF;
		}
		.inputsFade {
			color: #757575;
		}
		#resultsArea {
			margin-left: 40%;
		}
		#imagePreview {
			vertical-align: top;
			margin-left: 10px;
		}
		.required {
			color: red;
		}
	</style>
	<script src="js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript">
		$(function() {
			$("#inUrl").change(function() {
				// update picture preview from url
				$("#imagePreview").attr("src",document.getElementById("inUrl").value);
			});
		});
	</script>
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
			<!-- <button class="button buttonConfirm" id="buttonSave">Save Changes</button> -->
			<a href="index.php"><button class="button" id="buttonHome">Home</button></a>
		</div>
	</div>

	<!-- body -->
	<div id="resultsArea">
		<form method="post">
			<label for="id">Channel ID:</label><br>
			<input type="text" name="id" id="inid" class="inputs" size="24" required><br><br>
			<label for="name">Channel Name:</label><br>
			<input type="text" name="name" id="inName" class="inputs" size="24" required><span class="required">*</span><br><br>
			<label for="url">Profile Picture (URL):</label><br>
			<input type="text" name="url" id="inUrl" class="inputs" size="24" required><span class="required">*</span>
			
			<img src="" id="imagePreview" width="50" height="50" title="Image Preview" /><br>
			<script type="text/javascript">
				$("#imagePreview").attr("src",document.getElementById("inUrl").value);
			</script>

			<label for="date">Subscribed Date:</label><br>
			<input type="text" name="date" id="inDate" class="inputs" size="24" placeholder="YYYY-MM-DD" required><span class="required">*</span><br><br>
			<label for="content">Content Tags (comma separated):</label><br>
			<input type="text" name="content" id="inContent" class="inputs" size="24" required><span class="required">*</span><br><br>
			<label for="arrange">Arrangement:</label><br>
			<input type="text" name="arrange" id="inArrange" class="inputs" size="24" required><span class="required">*</span><br><br>
			<label for="raceEth">Race/Ethnicity (comma separated):</label><br>
			<input type="text" name="raceEth" id="inRaceEth" class="inputs" size="24"><br><br>
			<label for="nation">Nationality (comma separated):</label><br>
			<input type="text" name="nation" id="inNation" class="inputs" size="24"><br><br>
			<label for="gender">Gender (comma separated):</label><br>
			<input type="text" name="gender" id="inGender" class="inputs" size="24"><br><br>

			<input type="submit" name="submit" class="button buttonConfirm" value="Save">
		</form>
		<p>* Required Field</p>

	</div>
</body>
</html>