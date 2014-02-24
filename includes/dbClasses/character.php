<?php

require_once "../dbApi/characterDb.php";

class Character
{
	private $name;
	private $realm;
	private $region;
	private $guild;
	private $dpsHistory;
	private $itemLevel;

	private $characterDb;

	public function __construct($name, $region, $realm)
	{
		$this->name = $name;
		$this->realm = $realm;
		$this->region = $region;
		$this->characterDb = new CharacterDb($name, $region, $realm);
		$charExist = $this->characterDb->checkIfExist();

		if($charExist)
		{
			echo "Updateing char!\n";
			$this->characterDb->updateChar();
		}
		else
			$this->characterDb->insertChar();
	}	
}

?>