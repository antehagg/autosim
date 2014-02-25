<?php
include '/var/www/html/autosim/includes/dbApi/dbconnect.php';
require_once '/var/www/html/autosim/includes/dbClasses/region.php';


$dbConnect = new DbConnect();

$serverList = $dbConnect->getServers();

var_dump($serverList);


?>