<?php

require_once "/var/www/html/autosim/includes/dbApi/characterDb.php";

class Character
{
	public $id;
	public $name;
	public $realm;
	public $region;
	private $guild;
	private $dpsHistory;
	public $itemLevel;

	public $characterDb;

	public function __construct($name, $region, $realm)
	{
		$this->name = $name;
		$this->realm = $realm;
		$this->region = $region;
		$this->characterDb = new CharacterDb($name, $region, $realm);
		$charExist = $this->characterDb->checkIfExist();

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
		mkdir($path, 0775);
	}
}

?>