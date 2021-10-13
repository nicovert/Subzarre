<?php 
	if(!isset($_GET['search'])) {
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
	if ($_GET['search']=="NULL") {
			$sql = "select * from channel join tags on channel.id = tags.channelID order by name collate nocase";
			$result = $db->query($sql);
		}
	else {
			if (str_contains($_GET['search'],":")) {
				$searchTag = substr($_GET['search'], 0, strpos($_GET['search'], ":"));
				$searchValue = substr($_GET['search'],strpos($_GET['search'], ":")+1);
				$sql = "select * from channel join tags on channel.id = tags.channelID
							where {$searchTag} like '{$searchValue}'";
			}
			else {
				$sql = "select * from channel join tags on channel.id = tags.channelID 
							where id like ('{$_GET['search']}')
								OR name like ('%{$_GET['search']}%')
								OR thumbURL like ('{$_GET['search']}')
								OR subscribeDate like ('%{$_GET['search']}%')
								OR content like ('%{$_GET['search']}%')
								OR raceEthnicity like ('%{$_GET['search']}%')
								OR nationality like ('%{$_GET['search']}%')
								OR gender like ('{$_GET['search']}%')";
			}

			if (str_contains($_GET['search'],"-")) {
				$searchMinus = substr($_GET['search'],strpos($_GET['search'], "-")+1);
				// $sql .= " and content not like '%{$searchMinus}%'";
				echo $searchMinus;
				$sql = "select * from channel join tags on channel.id = tags.channelID 
							where id not like '%{$searchMinus}%'
								and (name not like '%{$searchMinus}%' or name is null)
								and (thumbURL not like '%{$searchMinus}%' or thumbURL is null)
								and (subscribeDate not like '%{$searchMinus}%' or subscribeDate is null)
								and (content not like '%{$searchMinus}%' or content is null)
								and (raceEthnicity not like '%{$searchMinus}%' or raceEthnicity is null)
								and (nationality not like '%{$searchMinus}%' or nationality is null)
								and (gender not like '%{$searchMinus}%' or gender is null)";
			}
			$sql .= " order by name collate nocase";
			$result = $db->query($sql);
		}

	$rows = $result->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Subzarre</title>
	<style type="text/css">
		li {
			padding: 5px;
			width: 150px;
		}
		.outerUL {
			display: flex;
			flex-wrap: wrap;
			list-style: none;
			/*justify-content: space-around;*/
		}
		.panelChannel {
			border: 1px solid #C7CBCF;
			padding: 4px;
			overflow-wrap: break-word;
			overflow: hidden;
		}
		.innerLI {
			margin: 0px;
			border: 0px;
			line-height: 0.2;
			padding: 8px;
		}
		.innerUL {
			margin: 0px;
			margin-top: -10px;
			border: 0px;
			line-height: 0.2;
		}
		.innerUL ~ p {
			margin-top: 5px;
		}
		.editButton {
			float: right;
		}
	</style>
</head>
<body>
	<ul class="outerUL">
		<?php
			// var_dump($rows);
			foreach ($rows as $row) {
				$contentList = explode(",",$row['content']);
				if (empty($row['raceEthnicity'])) {
					$reExist = false;
				}
				else {
					$reExist = true;
					$reList = explode(",",$row['raceEthnicity']);
				}
				
				if (empty($row['nationality'])) {
					$natExist = false;
				}
				else {
					$natExist = true;
					$natList = explode(",",$row['nationality']);
				}
				
				if (empty($row['gender'])) {
					$genderExist = false;
				}
				else {
					$genderExist = true;
					$genderList = explode(",",$row['gender']);
				}
				?>

				<li>
					<div class="panelChannel">
						<a href="https://www.youtube.com/channel/<?php echo($row['id']);?>"><img src="<?php echo($row['thumbURL']);?>" width="100%"></a>
						<strong><?php echo($row['name']);?></strong>
						<div class="panelTags">
							<p>Subscribed Date:<br><?php echo($row['subscribeDate']);?></p>
							<p>Content:</p>
								<ul class='innerUL'>
									<?php foreach ($contentList as $content) {echo "<li class='innerLI'>".ucfirst($content)."</li>";}?>
								</ul>
							<p>Arrangement:<br>
								<?php echo("<ul class='innerUL'><li class='innerLI'>".ucfirst($row['arrangement'])."</li></ul>");?>
							</p>
							<p>Race/Ethnicity:</p>
								<ul class='innerUL'>
									<?php
										if ($reExist) {
											foreach ($reList as $re) {echo "<li class='innerLI'>".ucfirst($re)."</li>";}
										}
										else {echo "<li class='innerLI'>N/A</li>";}
									?>
								</ul>
							<p>Nationality:</p>
								<ul class='innerUL'>
									<?php
										if ($natExist) {
											foreach ($natList as $nat) {echo "<li class='innerLI'>".ucfirst($nat)."</li>";}
										}
										else {echo "<li class='innerLI'>N/A</li>";}
									?>
								</ul>
							<p>Gender:</p>
								<ul class='innerUL'>
									<?php
										if ($genderExist) {
											foreach ($genderList as $gender) {echo "<li class='innerLI'>".ucfirst($gender)."</li>";}
										}
										else {echo "<li class='innerLI'>N/A</li>";}
									?>
								</ul>

							<a href="edit.php?id=<?php echo($row['id']);?>"><button class="button editButton">Edit</button></a>
						</div>
					</div>
				</li>

				<?php }
		?>
	</ul>
</body>
</html>