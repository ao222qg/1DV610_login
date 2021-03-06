<?php


include_once('Exceptions.php');

class RegisterModel {
	
    private $usernameInput;
	private $userPasswordInput;
	private $rePasswordInput;
	private $dbh;
	private $user;

    public function __construct(dbh $dbh) {
        $this->dbh = $dbh;
    }

    public function doActionRegister(string $Username, string $Password, string $rePassword) : void {
		$this->usernameInput = trim($Username);
		$this->userPasswordInput = trim($Password);
		$this->rePasswordInput = trim($rePassword);

		if(!preg_match("/^[A-Za-z0-9]+$/", $this->usernameInput))
			throw new InvalidChars('Username contains invalid characters.');

		else if(!preg_match("/^[A-Za-z0-9]+$/", $this->userPasswordInput))
			throw new InvalidChars('Password contains invalid characters.');

		else if(!preg_match("/^[A-Za-z0-9]+$/", $this->rePasswordInput))
			throw new InvalidChars('Password contains invalid characters.');

		else if (strlen($this->usernameInput) < 3) 
		 	throw new ShortUsername("Username has too few characters, at least 3 characters.");
	
		else if (strlen($this->userPasswordInput) && strlen($this->rePasswordInput) < 6) 
		 	throw new ShortPassword("Password has too few characters, at least 6 characters.");
		
		else if ($this->rePasswordInput != $this->userPasswordInput) 
		 	throw new PasswordDontMatch("Passwords do not match.");
		
		else if($this->dbh->userExist($this->usernameInput, $this->userPasswordInput))
			throw new UserExists("User already exist.");
	
		else
			$this->user = new User($this->usernameInput, $this->userPasswordInput);
			$this->dbh->insertUser($this->user);
    }
}