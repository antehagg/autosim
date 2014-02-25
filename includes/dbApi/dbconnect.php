<?php

class DbConnector
{
	public $myscli;

	public function __construct()
	{

	}

	public function connect($db)
	{
		$this->myscli = new mysqli("localhost","root","ch3f3n",$db);

		if ($this->myscli->connect_errno)
		{
			echo "Failed to connect to MySQL: " . $this->myscli->connect_error();
			return false; 
		}
		return true;
	}

	public function close()
	{
		mysqli_close($this->myscli);
	}

	public function sqlQuery($query)
	{
		$result = $this->myscli->query($query);

		return $result;
	}

	public function getRegions()
	{
		$query = "SELECT * FROM regions";

		$connected = $this->connect("autosim_core");
		if($connected)
		{
			$result = $this->sqlQuery($query);

			$regionList = array();

			while($row = $result->fetch_assoc())
				$regionList[] = $row;

			$this->close();

			return $regionList;
		}
	}

	public function getServers()
	{
		$query = "SELECT * FROM servers";

		$connected = $this->connect("autosim_core");
		if($connected)
		{
			$result = $this->sqlQuery($query);

			$regionList = array();

			while($row = $result->fetch_assoc())
				$regionList[] = $row;

			$this->close();

			return $regionList;
		}
	}

	public function insertRegion($region)
	{

	}

	public function insertServer($server)
	{

	}

	public function getGuildWithId($id)
	{

	}
}

?>
