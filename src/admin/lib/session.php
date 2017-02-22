<?php

class Session
{
	public function __construct()
	{
		@session_start();
	}
	
	public function get($key)
	{
		if (isset($_SESSION[$key]))
			return $_SESSION[$key];
		
		return false;
	}
	
	public function set($key, $val)
	{
		$_SESSION[$key] = $val;
		return true;
	}
	
	public function destroy($key)
	{
		unset($_SESSION[$key]);
		return true;
	}
	
	public function destroy_all()
	{
		return @session_destroy();
	}
}

?>