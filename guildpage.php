<html>
	<head>
		<style>
			body
			{
				background-color: #98bf21;
			}
		</style>
		<link rel="stylesheet" type="text/css" href="css/main.css">
	</head>
	<body>
		<div class="container">
			<div class="header">
			<h1 class="h1">Autosim</h1>
			</div>
			<div class="menubox">
				<ul class="navilist">
					<li class="navilistitem"><a class="navibuttons" href="index.php">Home</a></li>
					<li class="navilistitem"><a class="navibuttons" href="charpage.php">Character</a></li>
					<li class="navilistitem"><a class="navibuttons" href="guildpage.php">Guild</a></li>
				</ul>
			</div>
			<div class="mainbox">
				<div id="guildsearch">

				</div>
			<?php
				include "/var/www/html/autosim/includes/dbClasses/character.php";

				session_start(); 
				$character = new Character($_SESSION['charname'], $_SESSION['region'], $_SESSION['server']);
				$guildName = $character->characterDb->charJson->guild->name;
				echo "Active guild: " . $guildName . "<br>";

				var_dump($character->guild->members)
			?>
			</div>
		</div>
	</body>
</html>
