<?php

require_once '/var/www/html/autosim/includes/dbApi/dbconnect.php';

class RegionDb
{
	private $id;
	private $name;
	private $link;
	private $dbName;

	public function __construct()
	{
		$this->dbName = 'autosim_core';
		$this->link = new DbConnector();
	}

	public function getRegionNames()
	{
		$this->link->connect($this->dbName);

		$sqlQuery = "SELECT name FROM regions";

		echo $sqlQuery;

		$result = $this->link->sqlQuery($sqlQuery);

		$regionList = array();

		while($row = $result->fetch_assoc())
			$regionList[] = $row['name'];

		$this->link->close();

		return $regionList;
	}

	public function getRegionIdFromName($name)
	{
		$this->link->connect($this->dbName);

		$sqlQuery = "SELECT id FROM ". $this->dbName . ".regions WHERE name = '$name'";

		$result = $this->link->sqlQuery($sqlQuery);

		$id = $result->fetch_row();

		$this->link->close();

		return $id[0];
	}
}

?>