<?php
	if(isset($_POST['submit'])) {
		//form submission save
		if (!isset($_POST['id']) || !isset($_POST['content']) || !isset($_POST['arrange'])
			|| !isset($_POST['name']) || !isset($_POST['date'])) {
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

		//download profile image to save to /images/
		if (isset($_POST['url']) && $_POST['url']!="" && isset($_POST['id'])) {
			$imageFile = "images/{$_POST['id']}.jpg";
			file_put_contents($imageFile, file_get_contents($_POST['url']));
		}

		//write to database
		$db = new PDO('sqlite:subzarre.db');
		$sqlUpdateChannel = "UPDATE channel
							 SET name='{$_POST['name']}',
							 subscribeDate='{$_POST['date']}'
							 WHERE id='{$_POST['id']}'";

		$sqlUpdateTags = "UPDATE tags
						  SET content='{$_POST['content']}',
						  arrangement='{$_POST['arrange']}',
						  raceEthnicity={$subRE},
						  nationality={$subNat},
						  gender={$subGen}
						  WHERE channelID='{$_POST['id']}'";

		$resultChannel = $db->query($sqlUpdateChannel);
		$resultTags = $db->query($sqlUpdateTags);
		if ($resultChannel==TRUE && $resultTags==TRUE) {
			echo "<script>alert('Subscription Updated Successfully');</script>";
		} else {
			echo "<script>alert(" . implode($db->errorInfo()) . ");</script>";
		}

	}
	if (isset($_POST['delete'])) {
		//form submission delete
		if (!isset($_POST['id']) || !isset($_POST['content']) || !isset($_POST['arrange'])
			|| !isset($_POST['name']) || !isset($_POST['date'])) {
			echo "<script>alert('Error: Missing Required Field(s)');</script>";
		}

		$db = new PDO('sqlite:subzarre.db');
		$sqlDelete="DELETE FROM channel WHERE id='{$_POST['id']}'";
		$sqlDeleteTags="DELETE FROM tags WHERE channelID='{$_POST['id']}'";
		$resultDelete=$db->query($sqlDelete);
		$resultDeleteTags=$db->query($sqlDeleteTags);
		if ($resultDelete == TRUE && $resultDeleteTags == TRUE) {
			if (!unlink("images/{$_POST['id']}.jpg")) {
				echo "<script>alert('Subscription Deleted Succesfully\nError Deleting Profile Image');</script>";
				header('Location: index.php');
				exit;
			} else {
				echo "<script>alert('Subscription Deleted Succesfully');</script>";
				header('Location: index.php');
				exit;
			}
		} else {
			echo "<script>alert('Error Deleting Subscription');</script>";
		}
	}

	if(!isset($_GET['id'])) {
    	echo("<!DOCTYPE html>
			<html>
				<head>
					<title>Subzarre</title>
					<style type='text/css'>
						* {font-family: sans-serif;}
						body {
							color: #C7CBCF;
							background-color: #202124;
						}
					</style>
				</head>
				<body>
					<center>
					<h1>404</h1>
					<h4>Page Not Found</h4>
					</center>
				</body>
			</html>");
    	exit();
	}


	$db = new PDO('sqlite:subzarre.db');
	if ($_GET['id'] == "NEW") {
		# code...
	} else {
		$sqlGet = "select * from channel join tags on channel.id = tags.channelID
						where id like '{$_GET['id']}'";
		$result = $db->query($sqlGet);
		$rows = $result->fetchAll();
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
		#buttonDeleteConfirm, #labelDeleteConfirm {
			display: hidden;
		}
	</style>
	<script src="js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript">
		$(function() {
			$("#buttonDeleteConfirm").hide();
			$("#labelDeleteConfirm").hide();

			$("#inUrl").change(function() {
				// update picture preview from url
				if (!document.getElementById("inUrl").value
					|| document.getElementById("inUrl").value === "") {
					$("#imagePreview").attr("src","images/"+document.getElementById("inid").value);
				} else {
					$("#imagePreview").attr("src",document.getElementById("inUrl").value);
				}
			});

			$("#buttonDelete").click(function() {
				//confirm delete
				$("#buttonDelete").hide();
				$("#buttonDeleteConfirm").show();
				$("#labelDeleteConfirm").show();
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
		<?php
			foreach ($rows as $row) {
				$channelID = $row['id'];
				$channelName = $row['name'];
				$date = $row['subscribeDate'];
				$content = $row['content'];
				$arrange = $row['arrangement'];
				if (empty($row['raceEthnicity']) || $row['raceEthnicity']=="") {
					$reExist = false;
					$raceEth="";
				}
				else {
					$reExist = true;
					$raceEth = $row['raceEthnicity'];
				}
				
				if (empty($row['nationality']) || $row['nationality']=="") {
					$natExist = false;
					$nationality="";
				}
				else {
					$natExist = true;
					$nationality = $row['nationality'];
				}
				
				if (empty($row['gender']) || $row['gender']=="") {
					$genderExist = false;
					$gender="";
				}
				else {
					$genderExist = true;
					$gender = $row['gender'];
				}
			}
		?>

		<form method="post">
			<label for="id">Channel ID:</label><br>
			<input type="text" name="id" id="inid" class="inputs inputsFade" value="<?php echo($channelID);?>" size="24" readonly required><br><br>
			<label for="name">Channel Name:</label><br>
			<input type="text" name="name" id="inName" class="inputs" size="24" value="<?php echo($channelName);?>" required><span class="required">*</span><br><br>
			<label for="url">Profile Picture (URL):</label><br>
			<input type="text" name="url" id="inUrl" class="inputs" size="24" value="">
			
			<img src="" id="imagePreview" width="50" height="50" title="Image Preview" /><br>
			<script type="text/javascript">
				$("#imagePreview").attr("src","images/"+document.getElementById("inid").value)+"<?php echo time();?>";
			</script>

			<label for="date">Subscribed Date:</label><br>
			<input type="text" name="date" id="inDate" class="inputs" size="24" placeholder="YYYY-MM-DD" value="<?php echo($date);?>" required><span class="required">*</span><br><br>
			<label for="content">Content Tags (comma separated):</label><br>
			<input type="text" name="content" id="inContent" class="inputs" size="24" value="<?php echo($content);?>" required><span class="required">*</span><br><br>
			<label for="arrange">Arrangement:</label><br>
			<input type="text" name="arrange" id="inArrange" class="inputs" size="24" value="<?php echo($arrange);?>" required><span class="required">*</span><br><br>
			<label for="raceEth">Race/Ethnicity (comma separated):</label><br>
			<input type="text" name="raceEth" id="inRaceEth" class="inputs" size="24" value="<?php echo($raceEth);?>"><br><br>
			<label for="nation">Nationality (comma separated):</label><br>
			<input type="text" name="nation" id="inNation" class="inputs" size="24" value="<?php echo($nationality);?>"><br><br>
			<label for="gender">Gender (comma separated):</label><br>
			<input type="text" name="gender" id="inGender" class="inputs" size="24" value="<?php echo($gender);?>"><br><br>

			<input type="submit" name="submit" class="button buttonConfirm" value="Save"><br>
			<button class="button buttonCaution" id="buttonDelete" onclick="return false;">Delete</button>
			<input type="submit" name="delete" class="button buttonCaution" value="Yes" id="buttonDeleteConfirm"> <span id="labelDeleteConfirm">Are you sure?</span>
		</form>
		<!-- <button class="button buttonCaution" id="buttonDelete">Delete</button> -->
		<p>* Required Field</p>

	</div>
</body>
</html>