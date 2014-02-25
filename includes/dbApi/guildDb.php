<?php

require_once '/var/www/html/autosim/includes/dbApi/dbconnect.php';

class GuildDb
{
	private $id;
	private $name;
	private $regionId;
	private $realmId;

	private $dbName;
	private $link;

	public function __construct()
	{
		$this->dbName = 'autosim_core';
		$this->link = new DbConnector();
	}

	public function getGuildIdFromName($name, $regionId, $realmId)
	{
		$this->link->connect($this->dbName);

		$sqlQuery = "SELECT id FROM ". $this->dbName . ".guilds WHERE name = '$name' AND regionId = '$regionId' AND serverId = '$realmId'";

		$result = $this->link->sqlQuery($sqlQuery);

		$id = $result->fetch_row();

		$this->link->close();

		return $id[0];
	}
}

?>