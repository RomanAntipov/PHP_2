<?php
    session_start();
    include 'db.php';
    // include 'cart.php';
// в случае, если на страницу управления товарами попадает пользователь (не admin) или 
// неавторизованный посетитель - перекидываем его на главную страницу.
if (!$_SESSION['auth'] || $_SESSION['username'] !== 'admin') {
	header ('location: index.php');
};

// получаем из БД полный список товаров для отображения на странице (значения массива $products потом используются на странице с вёрсткой.

$products = makePrList($mysql);

// если на странице введены какие-то значения в поля форм создания товара - помещаем его данные в сессию для временного хранения.

if (isset($_GET['prodname']) && isset($_GET['price']) && isset($_GET['image'])) {
	// var_dump($_GET);
	$_SESSION['newProduct'] = $_GET;
	$_SESSION['newProduct']['content'] = true;

	// addNewProduct($_GET['prodname'], $_GET['price'], $_GET['image']);
	// $_GET;
	header ('location: products.php');
};

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		// если пользователь нажал "очистить" - через get получаем параметр action=clear. В этом случае очищаем в сессиях переменную, 
		// в которой хранятся параметры товара.

		case ($_GET['action'] == 'clear'):
			unset($_SESSION['newProduct']);
			header ('location: products.php');
			break;
		
		// если пользователь нажал "Добавить товар" - через get получаем параметр action=add. В этом случае вызываем функцию, 
		// которая добавляет значения в БД. Переменные для передачи в функцию берутся из сессии.

		case ($_GET['action'] == 'add'):
			addNewProduct($_SESSION['newProduct']['prodname'], $_SESSION['newProduct']['price'], 'img/'.$_SESSION['newProduct']['image'], $mysql);
			unset($_SESSION['newProduct']);
			header ('location: products.php');
			break;

		case ($_GET['action'] == 'preDelete'):
			$_SESSION['killProduct']['id'] = $_GET['id'];
			$_SESSION['killProduct']['content'] = true;
			break;


		case ($_GET['action'] == 'clearDelete'):
			unset($_SESSION['killProduct']);
			header ('location: products.php');
			break;

		// если пользователь нажал "удалить товар" под таблицей предварительной проверки перед удалением - через get 
		// получаем параметр action=delete. В этом случае вызываем функцию, которая удаляет соответствующую строку из таблицы products в БД.

		case ($_GET['action'] == 'delete'):
			killProduct($_GET['id'], $mysql);
			unset($_SESSION['killProduct']);
			header ('location: products.php');
			break;
	};
};