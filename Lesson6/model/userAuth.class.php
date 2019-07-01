<?php

class userAuth {

	private $userLogin;
	private $dbConf;

	function __construct ($login, $conf) {
		$this->userLogin = $login;
		$this->dbConf = $conf;
		}

	// Работа с БД посредством mysqli, этот блок кода не используется т.к. вместо него метод реализован через PDO.
	// -----------------------------------------------------------------------------------------
	// function getUser() {
	//     $link = mysqli_connect($this->dbConf['host'], $this->dbConf['user'], $this->dbConf['pass'], $this->dbConf['dbname']);
	//     $query = sprintf('SELECT * FROM users WHERE login="%s" LIMIT 1', $this->userLogin);
	//     $mysql_query = mysqli_query($link, $query);
	//     $user = NULL;
	//     while ($row = mysqli_fetch_assoc($mysql_query)) {
	//         $user[] = $row;
	//     };
	//     mysqli_close($link);
	//     return $user[0];
	// }
	// ------------------------------------------------------------------------------------------
	// Работа с БД посредством PDO.

	function getUser() {
		//  $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		$user = NULL;
		$dsn = 'mysql:host='.$this->dbConf['host'].';dbname='.$this->dbConf['dbname'].';charset='.$this->dbConf['charset'];
		// var_dump($dsn);
		    $opt = [
		        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		        PDO::ATTR_EMULATE_PREPARES   => false,
		    ];
    	$pdo = new PDO($dsn, $this->dbConf['user'], $this->dbConf['pass'], $opt);
    	$res = $pdo->prepare('SELECT * FROM users WHERE login=? LIMIT 1');
    	//var_dump($res);
    	$res->execute(array($this->userLogin));
    	foreach ($res as $row)
			{
			    $user[] = $row;
			};
    	return $user[0];
	}



};