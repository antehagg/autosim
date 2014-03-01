<!DOCTYPE html>
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
				</ul>
			</div>
			<div class="mainbox">
				<?php
				simulate();
				?>
			</div>
		</div>
	</body>
</html>

<?php

function simulate()
{
	include "/var/www/html/autosim/includes/simulator/simulator.php";
	include "/var/www/html/autosim/includes/dbClasses/character.php";
	session_start(); 

	if(!isset($_SESSION['charname']))
	{
		echo "Go back to <a href=\"index.php\">Home</a> and login a character.";
	}		
	else
	{
		if(isset($_POST['iterations']))
			$iterations = $_POST['iterations'];
		else
			$iterations['iterations'] = 1000;
		if(isset($_POST['scalefactors']))
		{
			$scalefactors = 1;
		}
		else
			$scalefactors = 0;

		if(isset($_POST['reforgeplot']))
			$reforgeplot = $_POST['reforgeplot'];
		if(isset($_POST['reforgeamount']))
			$reforgeamount = $_POST['reforgeamount'];
		if(isset($_POST['reforgestep']))
			$reforgestep = $_POST['reforgestep'];
		if(isset($_POST['amrText']))
			$amrText = $_POST['amrText'];
	}

	$character = new Character($_SESSION['charname'], $_SESSION['region'], $_SESSION['server']);

	$simulator = new Simulator($character, $iterations, $amrText, $scalefactors, $reforgeplot, $reforgeamount, $reforgestep);

	$simpagename = "simulations/" . $character->name . "/" . $simulator->fileName . ".html";

	echo "<a target = '_blank' href=\"$simpagename\">See result</a>";
}

?>