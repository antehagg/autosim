<?php

require_once '/var/www/html/autosim/includes/dbApi/dbconnect.php';

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
		 $sqlInsertQuery = "INSERT INTO `dpsHistory`(`charId`, `dps`, `html`, `itemLevel`, `date`, `time`)
		 VALUES ($charId, $dps,'$html',$itemLevel, CURDATE(), CURTIME())";

		 $this->link->connect($this->db);
		 $this->link->sqlQuery($sqlInsertQuery);
		 $this->link->close();
	}

	public function getHistoryFromCharId($charId)
	{
		$sqlGetHistory = "SELECT * FROM dpsHistory WHERE charId=$charId ORDER BY `date` DESC";

		$this->link->connect($this->db);
		

		$result = $this->link->sqlQuery($sqlGetHistory);

		$dpsHistory = array();

		while($row = $result->fetch_assoc())
			$dpsHistory[] = $row;

		$this->link->close();

		return $dpsHistory;
	}
}

?>