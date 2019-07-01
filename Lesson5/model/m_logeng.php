<?php
	include 'userAuth.class.php';
	include './engine/config.php';
	$mysql = $sqlconf;
	
	session_start();
	// $login = '';
	// $password = '';

	// if (isset($_POST['login'], $_POST['password'])) {

	// 	$login = $_POST['login'];
	// 	$password = $_POST['password'];
	// };
	// var_dump($login);
	// var_dump($password);

	if (isset($_GET['action']) && ($_GET['action'] == 'unlog')) {
		$_SESSION["auth"] = false;
		$_SESSION["username"] = 'nouser';
		header ('location: ../index.php');
	};

	$getUser = new userAuth($login, $mysql);
	$user = $getUser->getUser();
	// var_dump($user);
	if ($user) {
		// var_dump(password_verify('1234', $user['password']));
	    if (password_verify($password, $user['password'])) {

	        $_SESSION["auth"] = true;
	        $_SESSION["username"] = $user['username'];
	        header('location: index.php');
	    } 
	    else {
	        $_SESSION["auth"] = false;
	        $_SESSION["user_name"] = '';
	    };
	};
?>