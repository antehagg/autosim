<?php

require_once '/var/www/html/autosim/includes/dbApi/dbconnect.php';

class RealmDb
{
	private $id;
	private $name;
	private $regionId;

	private $dbName;
	private $link;

	public function __construct()
	{
		$this->dbName = 'autosim_core';
		$this->link = new DbConnector();
	}

	public function getRealmNames()
	{
		$this->link->connect($this->dbName);

		$sqlQuery = "SELECT name FROM servers";

		echo $sqlQuery;

		$result = $this->link->sqlQuery($sqlQuery);

		$realmList = array();

		while($row = $result->fetch_assoc())
			$realmList[] = $row['name'];

		$this->link->close();

		return $realmList;
	}

	public function getRealmIdFromName($name, $regionId)
	{
		$this->link->connect($this->dbName);

		$sqlQuery = "SELECT id FROM ". $this->dbName . ".servers WHERE name = '$name' AND regionId = '$regionId'";

		$result = $this->link->sqlQuery($sqlQuery);

		$id = $result->fetch_row();

		$this->link->close();

		return $id[0];
	}
}

?>