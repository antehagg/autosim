<?php

include "/var/www/html/autosim/includes/dbApi/dpsHistoryDb.php";

class Simulator
{
	private $character;
	private $name;
	private $region;
	private $server;

	private $iterations;
	private $calculate_scale_factors;
	// i.e reforge_plot_stat=crit,haste,mastery
	private $reforge_plot_stat;
	private $reforge_plot_amount;
	private $reforge_plot_step;
	private $amrText;

	private $simcFileName;
	public $outFileName;
	public $fileName;

	private $threads;

	// Will be used later when there is a frontend to move output files to.
	private $user;

	public function __construct($character, $iterations, $amrText ,$calculate_scale_factors,
	 $reforge_plot_stat, $reforge_plot_amount, $reforge_plot_step)
	{
		$this->amrText = $amrText;
		$this->character = $character;
		$this->iterations = $iterations;
		$this->calculate_scale_factors = $calculate_scale_factors;
		$this->reforge_plot_stat = $reforge_plot_stat;	
		$this->reforge_plot_amount = $reforge_plot_amount;
		$this->reforge_plot_step = $reforge_plot_step;
		$this->threads = 1;

		$this->outFileName = $this->setOutFile();
		$this->createSimcFile();
		$this->simulateFile();
	}

	private function setOutFile()
	{
		date_default_timezone_set ("Europe/Stockholm");
		$date = date('Ymdhis', time());
		$this->fileName = $this->character->name . $date;
		$outfileString = "/var/www/html/autosim/simulations/" . $this->character->name . "/" . $this->character->name . $date . ".html";

		return $outfileString;
	}

	private function createSimcFile()
	{
		$this->simcFileName = "/var/www/html/autosim/simulationcraft/profiles/autosim/" . $this->character->name . ".simc";
		$fileHandle = fopen($this->simcFileName, 'w') or die("can't open file");
		chmod($this->simcFileName, 0777);

		if($this->amrText == '' || !isset($this->amrText))
			$writeString = "armory=" . $this->character->region . "," . $this->character->realm . "," . $this->character->name . "\n";
		else
			$writeString = $this->amrText . "\n";

		$writeString .= "calculate_scale_factors=" . $this->calculate_scale_factors . "\n";

		$reforgePlotCheck = false;
		if($this->reforge_plot_stat != "" && $this->reforge_plot_amount > 0 && $this->reforge_plot_step > 0)
		{
			$writeString .= "reforge_plot_stat=" . $this->reforge_plot_stat . "\n";
			$writeString .= "reforge_plot_amount=" . $this->reforge_plot_amount . "\n";
			$writeString .= "reforge_plot_step=" . $this->reforge_plot_step . "\n";
			$reforgePlotCheck = true;
		}

		if(($reforgePlotCheck || $this->calculate_scale_factors == 1) && $this->iterations < 10000)
		{
			$this->iterations = 10000;
			$this->threads = 4;
		}

		//make sure we dont sim stupidly high iterations
		if($this->iterations > 10000)
			$this->iterations = 10000;

		$writeString .= "threads=" . $this->threads . "\n";
		$writeString .= "iterations=" . $this->iterations . "\n";
		$writeString .= "html=" . $this->outFileName;


		fwrite($fileHandle, $writeString);
		fclose($fileHandle);
	}

	private function simulateFile()
	{
		$command = "simc " . $this->simcFileName;
		exec($command, $output);

		$dpsArray = explode(" ", $output[11]);	

		if(count($dpsArray) == 5)
			$dps = $dpsArray[1];
		elseif(count($dpsArray) == 6)
			$dps = $dpsArray[2];

		$dpsHistory = new DpsHistoryDb();

		$dpsHistory->insertNewSim($this->character->id, $dps, $this->fileName, $this->character->characterDb->charJson->items->averageItemLevelEquipped);
	}
}

?>