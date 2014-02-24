<?php

require_once = './includes/simulator/simulator.php';

<html>
	<body>
		<INPUT TYPE = "Text" VALUE ="" NAME = "charname">
	</body>
</html>

$char = $_POST['charname'];
$sim = new Simulator($char, "eu", "ravencrest", 1000, 1, "crit,haste", 2000, 200);

?>