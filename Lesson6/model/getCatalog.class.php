<?php

class getCatalog {

	private $dbConf;
	private $dbLimit;

	function __construct ($limit, $conf) {
		$this->dbLimit = $limit;
		$this->dbConf = $conf;
		}

	// Работа с БД посредством mysqli, этот блок кода не используется т.к. вместо него метод реализован через PDO.
	// -----------------------------------------------------------------------------------------

	// function makePrList($sqlconf, $lim) {
	// 	$link = mysqli_connect(	$sqlconf['host'], $sqlconf['user'], $sqlconf['pass'], $sqlconf['dbname']);
	// 	$query = sprintf('SELECT * FROM products LIMIT %u', $lim);
	// 	$allprod = mysqli_query($link, $query);
	// 	// var_dump($products);

	// 	$products = [];
	// 	while ($row = mysqli_fetch_assoc($allprod)) {
	// 	    // формируем двумерный массив, в котором ключи ячеек равны id, вложенные массивы содержат инфо о наименовании, цене товара и изображении.
	// 	    $products[$row['id']] = ['product_name' => $row['product_name'], 'price' => $row['price'], 'prod_image' => $row['prod_image']];
	// 		};
	// 	// проверяем, что функция отработала и массив сформирован, в продуктовой версии данную строчку закомментировать.
	// 	// var_dump($products);
	// 	mysqli_close($link);
	// 	return $products;
	// };
	// }
	// ------------------------------------------------------------------------------------------
	// Работа с БД посредством PDO.

	function getCatalog() {
		//  присваиваем переменной $catalog пустое значение чтобы исключить попадание случайного "мусора"
		$catalog = NULL;

		// настройки соединение с БД (массив с настройками получаем в объект через конструктор при создании объекта)
		$dsn = 'mysql:host='.$this->dbConf['host'].';dbname='.$this->dbConf['dbname'].';charset='.$this->dbConf['charset'];
		    $opt = [
		        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		        PDO::ATTR_EMULATE_PREPARES   => false,
		    ];
    	$pdo = new PDO($dsn, $this->dbConf['user'], $this->dbConf['pass'], $opt);
    	$res = $pdo->prepare('SELECT * FROM products LIMIT ?');
    	//var_dump($res);
    	$res->execute(array($this->dbLimit));

    	// формируем выходной массив, в котором ключи равны артикулам товаров (id в БД), 
    	// в ячейках - вложенные массивы с ключами 'product_name', 'price', 'prod_image'

    	foreach ($res as $row)
			{
			    $catalog[$row['id']] = ['product_name' => $row['product_name'], 'price' => $row['price'], 'prod_image' => $row['prod_image']];;
			};
    	return $catalog;
	}



};