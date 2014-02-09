<?php

class User
{
	private $userName;
	private $email;

	private $chars = array();

	public function __construct($userName, $email)
	{
		$this->userName = $userName;
		$this->email = $email;

		$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

		echo $salt;
	}
}

?>