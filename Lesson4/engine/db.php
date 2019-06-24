<?php
	include 'config.php';

	$mysql = $sqlconf;

	// Функция, получающая из БД данныу УЗ пользователя по его логину.

	function getUser($login, $sqlconf) {

	    $link = mysqli_connect(	$sqlconf['host'], $sqlconf['user'], $sqlconf['pass'], $sqlconf['dbname']);
	    $query = sprintf('SELECT * FROM users WHERE login="%s" LIMIT 1', $login);
	    $mysql_query = mysqli_query($link, $query);
	    $user = NULL;
	    while ($row = mysqli_fetch_assoc($mysql_query)) {
	        $user[] = $row;
	    }
	    mysqli_close($link);
	    return $user[0];
	};

	// Функция, получающая из БД список товаров. На вход передаём конфигурацию файла БД и количество отражаемых на даном этапе товаров

	function makePrList($sqlconf, $lim) {
		$link = mysqli_connect(	$sqlconf['host'], $sqlconf['user'], $sqlconf['pass'], $sqlconf['dbname']);
		$query = sprintf('SELECT * FROM products LIMIT %u', $lim);
		// echo ($query);
		$allprod = mysqli_query($link, $query);
		// var_dump($products);

		$products = [];
		while ($row = mysqli_fetch_assoc($allprod)) {
		    // var_dump($row);
		    // формируем двумерный массив, в котором ключи ячеек равны id, вложенные массивы содержат инфо о наименовании, цене товара и изображении.
		    $products[$row['id']] = ['product_name' => $row['product_name'], 'price' => $row['price'], 'prod_image' => $row['prod_image']];
			};
		// проверяем, что функция отработала и массив сформирован, в продуктовой версии данную строчку закомментировать.
		// var_dump($products);
		mysqli_close($link);
		return $products;
	};

	function makeOrder($goods, $userName, $phone, $address, $sqlconf) {
		$link = mysqli_connect(	$sqlconf['host'], $sqlconf['user'], $sqlconf['pass'], $sqlconf['dbname']);

		// данным запросом создаём в таблице orders базы данных строчку с параметрами конкретного заказа.
		// ВАЖНО!!! В таблице содержится только номер заказа, имя пользователя, телефон и адрес.
		// Информация о заказанных товарах, их количестве будет храниться в отдельной таблице order_products!
		
		// var_dump($link);

		$queryOrder = sprintf('INSERT INTO orders (`User`, `phone`, `address`) VALUES ("%s", "%s", "%s")', $userName, $phone, $address);
		// var_dump($queryOrder);

		$mysql_queryOrder = mysqli_query($link, $queryOrder);
		// var_dump($mysql_queryOrder);

		// если строка в таблице orders создана успешно (переменная $mysql_queryOrder равна истине) - получаем из базы данных 
		// последний (только что созданный) номер заказа пользователя с таким именем. Это нужно для того, чтобы создать 
		// соответствующие строчки в таблице order_products

		if ($mysql_queryOrder) {
			$queryOrderNum = sprintf('SELECT max(id) as lastorder FROM orders WHERE user = "%s"', $userName);
			$mysql_getOrderNum = mysqli_query($link, $queryOrderNum);
			// var_dump(mysqli_fetch_assoc($mysql_getOrderNum)["lastorder"]);
			$lastOrderNum = (int)mysqli_fetch_assoc($mysql_getOrderNum)["lastorder"];
			// var_dump($lastOrderNum);

			// переменная lastOrderNum содержит номер только что созданного заказа.

			// теперь заполняем таблицу order_products. Первая колонка таблицы будет содержать номер заказа, вторая - id товара, 
			// третья - количество. Номера заказа могут повторяться столько раз, сколько уникальных товаров в заказе!

			foreach ($goods as $id => $count) {
				$queryOrderProd = sprintf('INSERT INTO order_products (`order_id`, `product_id`, `count`) VALUES ("%s", "%s", "%s")', $lastOrderNum, $id, $count);
				// var_dump($queryOrderProd);
				$mysql_OrderProd =  mysqli_query($link, $queryOrderProd);
			};
		};
		mysqli_close($link);
	};

	function getAllOrders($userName, $sqlconf) {
		$link = mysqli_connect(	$sqlconf['host'], $sqlconf['user'], $sqlconf['pass'], $sqlconf['dbname']);

		// проверяем имя пользователя. Если пользователь - admin - то выгрузим все заказы из БД. 
		// Иначе выводим информацию только о заказах конкретного пользователя.

		if ($userName == 'admin')
			$query = sprintf('SELECT * FROM orders');
		else $query = sprintf('SELECT * FROM orders WHERE User = "%s"',$userName);
		// var_dump($query);
		$allOrdersDB = mysqli_query($link, $query);	
		
		$allOrders = [];
		while ($row = mysqli_fetch_assoc($allOrdersDB)) {
			// var_dump($row);

			// формируем двумерный массив, в котором ключи ячеек равны id заказа, вложенные массивы содержат инфо 
			// о имени пользователя, контактных данных, и дате-времени заказа
		    $allOrders[$row['id']] = ['userName' => $row['User'], 'dateTime' => $row['datetime'], 'phone' => $row['phone'], 'address' => $row['address'], 'orderProducts' => getOrder_Products($link, $row['id'], $link)];
		};
		// проверяем, что функция отработала и массив сформирован, в продуктовой версии данную строчку закомментировать.
		// var_dump($allOrders);
		mysqli_close($link);
		return $allOrders;
		};

	function getOrder_Products($link, $orderId, $link) {
		$query = sprintf('
			SELECT product_id, product_name, price, count, price*count as totalprice FROM order_products
	    		INNER JOIN products ON product_id = products.id
	    		INNER JOIN orders ON order_id = orders.id
	    		WHERE order_id = %s
	    		ORDER BY order_id'
			, $orderId);

		$order_product = mysqli_query($link, $query);
		$allOP = [];
		$totalOrder = 0;
		while ($row = mysqli_fetch_assoc($order_product)) {
			// var_dump($row);

			// формируем двумерный массив, в котором ключи ячеек равны id товара в заказе, ячейки содержат количество товаров в заказе.

		    $allOP[$row['product_id']] = ['productName' => $row['product_name'], 'price' => $row['price'], 'count' => $row['count'], 'totalprice' => $row['totalprice']];
		    $totalOrder += $row['totalprice'];
		};
		$allOP['totalOrder'] = $totalOrder;
		return $allOP;
	};

	function killOrderProduct($orderId, $productId, $sqlconf) {
		$link = mysqli_connect($sqlconf['host'], $sqlconf['user'], $sqlconf['pass'], $sqlconf['dbname']);
		// var_dump($link);
		// запрос на удаление строки из таблицы order_products.

		if ($productId == 'all') $productQuery = '';
		else $productQuery = sprintf(' and (product_id = "%s")', $productId);
		
		$query = sprintf('DELETE FROM order_products WHERE (order_id = "%s")%s', $orderId, $productQuery);

		$killOrderProduct = mysqli_query($link, $query);

		if ($productId == 'all') {
			$OrderQuery = sprintf('DELETE FROM orders WHERE (id = "%s")', $orderId);
			$killOrder = mysqli_query($link, $OrderQuery);
		};
		mysqli_close($link);
	};

	function addNewProduct($productName, $price, $image, $sqlconf) {
		$link = mysqli_connect(	$sqlconf['host'], $sqlconf['user'], $sqlconf['pass'], $sqlconf['dbname']);
		// запрос на добавление в таблицу products строки с новым товаром (наименование товара, файл с изображением, цена).
		$query = sprintf('INSERT INTO products (product_name, prod_image, price) VALUES ("%s", "%s", "%s")', $productName, $image, $price);
		$addProduct = mysqli_query($link, $query);
		mysqli_close($link);
	};

	function killProduct($productId, $sqlconf) {
		$link = mysqli_connect(	$sqlconf['host'], $sqlconf['user'], $sqlconf['pass'], $sqlconf['dbname']);
		$query = sprintf('DELETE FROM products WHERE (id = "%s")', $productId);
		$kill = mysqli_query($link, $query);
		mysqli_close($link);
	};