<?php

class Simulator
{
	private $name;
	private $region;
	private $server;

	private $iterations;
	private $calculate_scale_factors;
	// i.e reforge_plot_stat=crit,haste,mastery
	private $reforge_plot_stat;
	private $reforge_plot_amount;
	private $reforge_plot_step;

	private $simcFileName;
	private $outFileName;

	private $threads;

	// Will be used later when there is a frontend to move output files to.
	private $user;

	public function __construct($name, $region, $server, $iterations, $calculate_scale_factors,
	 $reforge_plot_stat, $reforge_plot_amount, $reforge_plot_step)
	{
		$this->name = $name;
		$this->region = $region;
		$this->server = $server;
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
		$outfileString = $this->name . $date . ".html";

		return $outfileString;
	}

	private function createSimcFile()
	{
		$this->simcFileName = "/home/ahagglund/autosim/simulationcraft/profiles/autosim/" . $this->name . ".simc";
		$fileHandle = fopen($this->simcFileName, 'w') or die("can't open file");

		$writeString = "armory=" . $this->region . "," . $this->server . "," . $this->name . "\n";
		$writeString .= "calculate_scale_factors=" . $this->calculate_scale_factors . "\n";

		$reforgePlotCheck = false;
		if($this->reforge_plot_stat != "" && $this->reforge_plot_amount > 0 && $this->reforge_plot_step > 0)
		{
			$writeString .= "reforge_plot_stat=" . $this->reforge_plot_stat . "\n";
			$writeString .= "reforge_plot_amount=" . $this->reforge_plot_amount . "\n";
			$writeString .= "reforge_plot_step=" . $this->reforge_plot_step . "\n";
			$reforgePlotCheck = true;
		}

		if(($reforgePlotCheck &| $this->calculate_scale_factors == 1) && $this->iterations < 10000)
		{
			$this->iterations = 10000;
			$this->threads = 4;
		}

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
	}
}

?>