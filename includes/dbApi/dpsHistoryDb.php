<?php

require_once 'dbconnect.php';

class DpsHistoryDb
{
	private $id;
	private $dps;
	private $html;
	private $itemLevel;

	private $db;
	private $link;

	public function __construct()
	{
		$this->link = new DbConnector();
		$this->db = 'autosim_core';
	}

	public function insertNewSim($charId, $dps, $html, $itemLevel)
	{
		 $sqlInsertQuery = "INSERT INTO `dpsHistory`(`charId`, `dps`, `html`, `itemLevel`)
		 VALUES ($charId, $dps,'$html',$itemLevel)";

		 $this->link->connect($this->db);
		 $this->link->sqlQuery($sqlInsertQuery);
		 $this->link->close();
	}
}

?>