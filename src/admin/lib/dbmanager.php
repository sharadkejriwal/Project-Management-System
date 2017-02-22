<?php

class DBManager
{
	public function __construct()
	{
		$this->dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	}
	
	public function query($query)
	{
		return $this->dbc->query($query);
	}
}

?>