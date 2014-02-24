<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/main.css">
	</head>
	<body>
	Simulation:<br>
	DPS History:<br>
	</body>
</html>

<?php
include '/var/www/html/autosim/includes/simulator/simulator.php';

$char = $_GET['charname'];
$server = $_GET['server'];
$region = $_GET['region'];

#$sim = new Simulator($char, "eu", "ravencrest", 1000, 1, "crit,haste", 2000, 200);

?>
