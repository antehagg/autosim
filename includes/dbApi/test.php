<?php

include 'dbconnect.php';
require_once '../dbClasses/region.php';

$dbConnect = new DbConnect();

$serverList = $dbConnect->getServers();

var_dump($serverList);


?>