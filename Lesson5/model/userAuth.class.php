<?php

class userAuth {

	private $userLogin;
	private $dbConf;

	function __construct ($login, $conf) {
		$this->userLogin = $login;
		$this->dbConf = $conf;
	}
	
	function getUser() {
	    $link = mysqli_connect($this->dbConf['host'], $this->dbConf['user'], $this->dbConf['pass'], $this->dbConf['dbname']);
	    $query = sprintf('SELECT * FROM users WHERE login="%s" LIMIT 1', $this->userLogin);
	    $mysql_query = mysqli_query($link, $query);
	    $user = NULL;
	    while ($row = mysqli_fetch_assoc($mysql_query)) {
	        $user[] = $row;
	    };
	    mysqli_close($link);
	    return $user[0];
	}
};