<?php

require_once "/var/www/html/autosim/includes/dbApi/characterDb.php";
require_once "/var/www/html/autosim/includes/dbClasses/guild.php";

class Character
{
	public $id;
	public $name;
	public $realm;
	public $region;

	public $regionId;
	public $realmId;

	public $characterDb;
	public $guild;

	public function __construct($name, $region, $realm)
	{
		$this->name = $name;
		$this->realm = $realm;
		$this->region = $region;
		
		$this->characterDb = new CharacterDb($name, $region, $realm);
		$charExist = $this->characterDb->checkIfExist();

		$regionDb = new RegionDb();
		$realmDb = new RealmDb();

		$this->regionId = $regionDb->getRegionIdFromName($region);
		$this->realmId = $realmDb->getRealmIdFromName($realm, $this->regionId);
		
		
		$this->guild = new Guild($this->characterDb->charJson->guild->name, $this->realmId, $this->regionId);



		if($charExist)
			$this->characterDb->updateChar();
		else
		{
			$this->characterDb->insertChar();
			$this->createDirectory();
		}

		$this->id = $this->characterDb->getIdFromName();
	}	

	private function createDirectory()
	{
		$path = "/var/www/html/autosim/simulations/" . $this->name;
		mkdir($path, 0777);
	}
}

?>