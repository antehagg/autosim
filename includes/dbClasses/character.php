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

	public function __construct($name)
	{
		$this->name = $name;
		$this->characterDb = new CharacterDb($name);
		$charExist = $this->characterDb->checkIfExist();

		if($charExist)
			echo "it exist!";
		else
			$this->characterDb->insertChar();
	}
}

?>