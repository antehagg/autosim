<?php

class DbConnect
{
	private $myscli;

	public function __construct()
	{
		
	}

	private function connect($db)
	{
		$this->myscli = new mysqli("localhost","root","ch3f3n",$db);

		if ($this->myscli->connect_errno)
		{
			echo "Failed to connect to MySQL: " . $this->myscli->connect_error();
			return false; 
		}
		echo "Connected\n";
		return true;
	}

	private function close()
	{
		mysqli_close($this->myscli);
	}

	private function sqlQuery($query)
	{
		$result = $this->myscli->query($query);

		$this->close();

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
