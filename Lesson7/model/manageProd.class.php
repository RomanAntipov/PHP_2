<?php

class manageProd {

	private $dbConf;

	function __construct ($conf) {
		$this->dbConf = $conf;
		}

	// Работа с БД посредством mysqli, этот блок кода не используется т.к. вместо него метод реализован через PDO.
	// -----------------------------------------------------------------------------------------

	
	// ------------------------------------------------------------------------------------------
	// Работа с БД посредством PDO.

	//  присваиваем переменной $catalog пустое значение чтобы исключить попадание случайного "мусора"
	function addNewProduct($productName, $price, $image) {
		//  в массиве $queryValues будем хранить значения для дальнейшего запроса в БД.
		$queryValues = [
			'productName' => $productName,
			'price' => $price,
			'image' => $image
		];
		$dsn = 'mysql:host='.$this->dbConf['host'].';dbname='.$this->dbConf['dbname'].';charset='.$this->dbConf['charset'];
		    $opt = [
		        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		        PDO::ATTR_EMULATE_PREPARES   => false,
		    ];
    	$pdo = new PDO($dsn, $this->dbConf['user'], $this->dbConf['pass'], $opt);
    	$res = $pdo->prepare('INSERT INTO products (product_name, prod_image, price) VALUES (:productName, :image, :price)');
    	//var_dump($res);
    	$res->execute($queryValues);
	}

	function killProduct($productId) {

		$dsn = 'mysql:host='.$this->dbConf['host'].';dbname='.$this->dbConf['dbname'].';charset='.$this->dbConf['charset'];
		    $opt = [
		        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		        PDO::ATTR_EMULATE_PREPARES   => false,
		    ];
    	$pdo = new PDO($dsn, $this->dbConf['user'], $this->dbConf['pass'], $opt);
    	$res = $pdo->prepare('DELETE FROM products WHERE (id = ?)');
    	//var_dump($res);
    	$res->execute(array($productId));
	}


};