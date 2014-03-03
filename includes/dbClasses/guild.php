<?php
require_once "/var/www/html/autosim/includes/dbApi/guildDb.php";

class Guild
{
	private $name;
	private $serverId;
	public $members;
	private $guildDb;

	public function __construct($name, $serverId, $regionId)
	{
		$this->name = $name;
		$this->serverId = $serverId;
		$this->guildDb = new GuildDb($name, $serverId, $regionId);

		$this->members = $this->guildDb->getGuildMembers();
	}
}

?>