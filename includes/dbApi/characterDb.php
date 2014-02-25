<?php

require_once '/var/www/html/autosim/includes/dbApi/dbconnect.php';
include '/var/www/html/autosim/includes/dbApi/regionDb.php';
include '/var/www/html/autosim/includes/dbApi/guildDb.php';
include '/var/www/html/autosim/includes/dbApi/realmDb.php';

class CharacterDb
{
	private $link;
	private $db;
	private $charId;
	private $name;
	private $realm;
	private $region;
	public $charJson;

	public $realmId;
	public $regionId;

	public function __construct($name, $region, $realm)
	{
		$this->name = $name;
		$this->region = $region;
		$this->realm = $realm;
		$this->link = new DbConnector();
		$this->db = 'autosim_core';
		$this->getIds();
		$this->charId = $this->getIdFromName($this->name, $this->regionId, $this->realmId);
		$this->charJson = $this->getCharFromApi();
	}

	private function getIds()
	{
		$regionDb = new Regiondb();
		$this->regionId = $regionDb->getRegionIdFromName($this->region);

		$realmDb = new RealmDd();
		$this->realmId = $realmDb->getRealmIdFromName($this->realm, $this->regionId);
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

	public function getIdFromName()
	{
		$this->link->connect($this->db);

		$sqlQuery = "SELECT id FROM `char` WHERE name = '" . $this->name . "' AND regionId = " . $this->regionId . " AND serverId = " . $this->realmId;

		$result = $this->link->sqlQuery($sqlQuery);

		$id = $result->fetch_row();

		$this->link->close();

		return $id[0];
	}

	private function getCharFromApi()
	{
		$url = "http://" . $this->region . ".battle.net/api/wow/character/" . $this->realm . "/" . $this->name . "?fields=items,guild";
		$jsonResult = file_get_contents($url);
		$decodedresult = json_decode($jsonResult);

		return $decodedresult;
	}

	public function updateChar()
	{
		$region = $this->region;
		$realm = $this->realm;
		$itemLevel = $this->charJson->items->averageItemLevelEquipped;
		$guild = $this->charJson->guild->name;

		$guildDb = new GuildDb();
		$guildId = $guildDb->getGuildIdFromName('Volym', $this->regionId, $this->realmId);

		$sqlUpdateChar = "UPDATE `char` SET itemLevel = $itemLevel ,guildid = $guildId
		 WHERE id=" . $this->charId;

		 $this->link->connect($this->db);
		 $this->link->sqlQuery($sqlUpdateChar);
		 $this->link->close();
	}

	public function insertChar()
	{
		$region = $this->region;
		$realm = $this->realm;
		$itemLevel = $this->charJson->items->averageItemLevelEquipped;
		$guild = $this->charJson->guild->name;

		$realmId = $this->realmId;
		$regionId = $this->regionId;

		$guildDb = new GuildDb();
		$guildId = $guildDb->getGuildIdFromName('Volym', $regionId, $realmId);

		$sqlInsertChar = "INSERT INTO `char`(`name`, `itemLevel`, `serverid`, `regionid`, `guildid`)
		 VALUES ('" . $this->name . "',$itemLevel,$realmId,$regionId,$guildId)";

		 $this->link->connect($this->db);
		 $this->link->sqlQuery($sqlInsertChar);
		 $this->link->close();
	}
}
?>