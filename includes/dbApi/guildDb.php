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

	public function __construct($name, $realmId, $regionId)
	{
		$this->name = $name;
		$this->regionId = $regionId;
		$this->realmId = $realmId;
		$this->dbName = 'autosim_core';
		$this->link = new DbConnector();
		$this->id = $this->getGuildIdFromName();

		$guildExist = $this->checkIfGuildExist();

		if($guildExist == 0)
			$this->insertGuild();
	}

	private function insertGuild()
	{
		$this->link->connect($this->dbName);

		$sqlInsert = "INSERT INTO `guilds`(`name`, `regionId`, `serverId`) VALUES ('" . $this->name . "'," . $this->regionId . "," . $this->realmId . ")";

		$result = $this->link->sqlQuery($sqlInsert);

		$this->link->close();
	}

	private function checkIfGuildExist()
	{
		$this->link->connect($this->dbName);

		$sqlCheck = "SELECT * From guilds WHERE name='" . $this->name . "'";

		$result = $this->link->sqlQuery($sqlCheck);

		$this->link->close();

		if($result->num_rows > 0)
			return 1;
		else
			return 0;
	}

	public function getGuildIdFromName()
	{
		$this->link->connect($this->dbName);

		$sqlQuery = "SELECT id FROM guilds WHERE name = '" . $this->name . "' AND regionId = " . $this->regionId . " AND serverId = "
		 . $this->realmId;

		$result = $this->link->sqlQuery($sqlQuery);

		$id = $result->fetch_row();

		$this->link->close();

		return $id[0];
	}

	public function getGuildMembers()
	{
		$this->link->connect($this->dbName);

		$sqlQuery = "SELECT name FROM `char` WHERE guildid=" . $this->id;

		$result = $this->link->sqlQuery($sqlQuery);

		$guildMembers = array();

		while($row = $result->fetch_assoc())
			$guildMembers[] = $row['name'];

		$this->link->close();

		return $guildMembers;
	}
}

?>