<?php

require_once 'dbconnect.php';
include 'regionDb.php';
include 'guildDb.php';
include 'realmDb.php';

class CharacterDb
{
	private $link;
	private $db;
	private $name;

	public function __construct($name)
	{
		$this->name = $name;
		$this->link = new DbConnector();
		$this->db = 'autosim_core';
	}

	public function checkIfExist()
	{
		$this->link->connect($this->db);

		$sqlCheck = "SELECT * From " . $this->db . ".char WHERE name='" . $this->name . "'";

		$result = $this->link->sqlQuery($sqlCheck);

		$this->link->close();

		if($result->num_rows > 0)
			return true;
		else
			return false;
	}

	public function getIdFromName($name, $regionId, $realmId, $guildId)
	{
		$this->link->connect($this->dbName);

		$sqlQuery = "SELECT id FROM guilds WHERE name = '$name' AND regionId = '$regionId' AND serverId = '$realmId' AND guildId = $guildId";

		$result = $this->link->sqlQuery($sqlQuery);

		$id = $result->fetch_row();

		$this->link->close();

		return $id[0];
	}

	public function insertChar()
	{
		$url = "http://eu.battle.net/api/wow/character/ravencrest/" . $this->name . "?fields=items,guild";
		$jsonResult = file_get_contents($url);
		$decodedresult = json_decode($jsonResult);

		$region = 'eu';
		$realm = $decodedresult->realm;
		$itemLevel = $decodedresult->items->averageItemLevelEquipped;
		$guild = $decodedresult->guild->name;

		var_dump($decodedresult);

		$regionDb = new Regiondb();
		$regionId = $regionDb->getRegionIdFromName($region);

		$realmDb = new RealmDd();
		$realmId = $realmDb->getRealmIdFromName('ravencrest', $regionId);

		$guildDb = new GuildDb();
		$guildId = $guildDb->getGuildIdFromName('Volym', $regionId, $realmId);

		$sqlInsertChar = "INSERT INTO `char`(`name`, `itemLevel`, `serverid`, `regionid`, `guildid`)
		 VALUES ('" . $this->name . "',$itemLevel,$realmId,$regionId,$guildId)";

		 echo $sqlInsertChar;

		 $this->link->connect($this->db);
		 $this->link->sqlQuery($sqlInsertChar);
		 $this->link->close();
	}
}
?>