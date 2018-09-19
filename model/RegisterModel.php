<?php

class RegisterModel
{
    private $usernameInput;
	private $userPasswordInput;
	private $reEnterPassword;
	private $userDAL;

    public function __construct(uDAL $userDAL)
    {
        $this->userDAL = $userDAL;
    }

    public function tryRegister($Username, $Password, $reEnterPass){
		
		$this->usernameInput = trim($Username);
		$this->userPasswordInput = trim($Password);
		$this->reEnterPassword = trim($reEnterPass);
	
		if(!preg_match("/^[A-Za-z0-9]+$/", $Username))
		{
			throw new Exception('Username contains invalid characters.');
		}
		else if(!preg_match("/^[A-Za-z0-9]+$/", $Password, $reEnterPassword))
		{
			throw new Exception('Password contains invalid characters.');
		}
		
		else if (mb_strlen($this->usernameInput) < 3) 
		{
		 	throw new Exception("Username has too few characters, at least 3 characters.");
		}
		else if (mb_strlen($this->userPasswordInput) < 6) 
		{
		 	throw new Exception("Password has too few characters, at least 6 characters.");
		}
		else if ($this->reEnterPassword != $this->userPasswordInput) 
		{
		 	throw new Exception ("Passwords do not match.");
		}
	
		$user = $this->userDAL->getUser($this->usernameInput);
			
		if($user != null)
		{
			throw new Exception("User exists, pick another username.");
	
		}
    }
}