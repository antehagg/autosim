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
				<div id="activeChar">
					<?php
						session_start();
						if(isset($_GET['charname']))
							$_SESSION['charname'] = $_GET['charname'];
						if(isset($_GET['server']))
							$_SESSION['server'] = $_GET['server'];
						if(isset($_GET['region']))
							$_SESSION['region'] = $_GET['region'];

						if(!isset($_SESSION['charname']))
						{
							echo "Go back to <a href=\"index.php\">Home</a> and login a character.";
						}		
						else
						{
							drawCharBox();
						}
					?>					
				</div>
				<div id="simBox">
					<form action="simulate.php" method="post">

						<table class="floatleft">
							<tr>
								<td>Iterations:</td>
								<td><input type="text" name="iterations" value="1000"></td>
							</tr>
							<tr>
								<td>Scalefactors:</td>
								<td><input type="checkbox" name="scalefactors" value="Yes"></td>
							</tr>
							<tr>
								<td>Reforgeplot</td>
								<td><input type="text" name="reforgeplot" value=""></td>
							</tr>
							<tr>								
								<td>Reforgeamount</td>
								<td><input type="text" name="reforgeamount" value=""></td>
							</tr>
							<tr>
								<td>Reforgestep</td>
								<td><input type="text" name="reforgestep" value=""></td>
							</tr>
							<tr>
								<td></td>
								<td><input class="alignright" type="submit" value="Submit"></td>
							</tr>
						</table>					

						<textarea type="textarea" class="floatright" id="amrTextArea" name="amrText" value="" cols="45" rows="10"></textarea>
					</form>
				</div>
				<div id="dpsHistoryBox">
					<?php
						require_once "/var/www/html/autosim/includes/dbApi/characterDb.php";
						require_once "/var/www/html/autosim/includes/dbApi/dpsHistoryDb.php";

						drawHistoryBox(10);
					?>
				</div>
			</div>
		</div>
	</body>
</html>

<?php

function drawHistoryBox($items)
{
	$charDb = new CharacterDb($_SESSION['charname'], $_SESSION['region'], $_SESSION['server']);
	$charId = $charDb->getIdFromName();

	$dpsHistoryDb = new DpsHistoryDb();
	$dpsHistory = $dpsHistoryDb->getHistoryFromCharId($charId);

	echo "<p class=\"floatleft\">Dpshistory</p><br>";
	echo "<table class=\"CSSTableGenerator\">";
	echo "<tr><td>DPS</td><td> Date</td><td> Time</td><td> Link</td></tr>";

	$counter = 1;
	foreach($dpsHistory as $historyRow)
	{
		if($counter > $items)
			break;
		echo "<tr><td>" . $historyRow['dps'] . "</td><td> " . $historyRow['date'] . "</td><td> " . $historyRow['time'] . "</td><td> ";

		$simpagename = "simulations/" . $_SESSION['charname'] . "/" . $historyRow['html'] . ".html";

		echo "<a target = '_blank' href=\"$simpagename\">See simulation</a></td></tr>";
		$counter++;
	}
	echo "</table>";
}

function drawCharBox()
{
	echo "Active char: " . $_SESSION['charname'] . "<br>";
}

#$sim = new Simulator($char, "eu", "ravencrest", 1000, 1, "crit,haste", 2000, 200);

?>
