<?php

class UserManager
{
	public function __construct()
	{
		$this->ses = new Session();
	}
	
	public function isLoggedIn($user = null)
	{
		if ($user == null)
		{
			if ($this->ses->get('user') != false)
				return true;
			else
				return false;
		}
		
		if ($this->ses->get('user') == $user)
			return true;
		
		return false;
	}
	
	public function getUser()
	{
		if ($this->isLoggedIn())
			return $this->ses->get('user');
		
		return false;
	}
	
	public function login($user, $pass)
	{
		if ($this->isLoggedIn())
			return true;
		
		if ($user === 'admin' && $pass === 'admin')	
			return $this->ses->set('user', $user);
		
		return false;
	}
	
	public function logout()
	{		
		if ($this->isLoggedIn())
			return $this->ses->destroy('user');
		else
			return true;
		
		return false;
	}
}

?>