<?php echo " ";?>

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
		a {
			text-decoration: none;
			color: #C7CBCF;
		}
		a:hover {
			text-decoration: underline;
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
		#inputSearch {
			background-color: #323639;
			color: #C7CBCF;
			margin: 10px;
			border: 1px solid #C7CBCF;
		}
	</style>
	<script src="js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript">
		$(function() {
			$("#buttonToggleTags").click(function() {
				$(".panelTags").slideToggle();
			});
		});
	</script>
</head>
<body>
	<!-- ajax jquery -->
	<script type="text/javascript">
		function resultsAjax() {
			if ($("#inputSearch").val() != '') {
				$.ajax({
					url: "results.php?search="+$("#inputSearch").val(),
					async: true,
					success: function(result) {
						$("#resultsArea").html(result);
					}
				})
			}
			else {
				$.ajax({
					url: "results.php?search=NULL",
					async: true,
					success: function(result) {
						$("#resultsArea").html(result);
					}
				})
			}
		}

		$(function() {
			resultsAjax ();

			$("#inputSearch").change(resultsAjax);
		})
	</script>

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
			<input type="text" name="inputSearch" id="inputSearch" placeholder="Search...">
			<button class="button" id="buttonToggleTags">Toggle Tags</button>
			<a href="analytics.php"><button class="button" id="buttonAnalytics">Analytics</button></a>
			<a href="new.php"><button class="button" id="buttonNew" title="Add New Subscription">
				<svg width="20" height="20" viewBox="0 0 400 400" style="fill:#FFFFFF;">
					<path class="st0" d="M248,400c-32,0-64,0-96,0c0-50.3,0-100.5,0-152c-52.4,0-102.2,0-152,0c0-32,0-64,0-96c50.3,0,100.5,0,152,0
					c0-52.4,0-102.2,0-152c32,0,64,0,96,0c0,50.3,0,100.5,0,152c52.4,0,102.2,0,152,0c0,32,0,64,0,96c-50.3,0-100.5,0-152,0
					C248,300.4,248,350.2,248,400z"/>
				</svg>
			</button></a>
		</div>
	</div>

	<!-- table -->
	<div id="resultsArea"></div>

	<!-- footer -->
	<div class="header">
		<!-- left side -->
		<div class="headerLeft">
			<!-- author -->
			<span>Created by <a href="https://www.nicovert.com">Nico Covert</a></span>
		</div>
		<!-- right side -->
		<div class="headerRight">
			<a href="#"><button class="button" id="buttonTop">Back to Top</button></a>
		</div>
	</div>
</body>
</html>