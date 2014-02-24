<?php

include "simulator.php";
include "../dbClasses/character.php";

$char = new Character("Lasrot", "eu", "ravencrest");
#$sim = new Simulator($char, 1000, 1, "crit,haste", 2000, 200);
$sim = new Simulator($char, 1000, 0);

?>