<?php

require_once "/var/www/html/autosim/includes/dbApi/dbconnect.php";

class Region
{
	public $id;
	public $name;

	public $regionList = array();

	public function __construct($id, $name)
	{
		$this->id = $id;
		$this->name = $name;
	}
}

?>