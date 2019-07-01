<?php
    session_start();
    include 'getCatalog.class.php';
    $prodCount = 25;
    // var_dump($_GET);

    // Проверяем, если массив $_GET имеет отличную от нуля длину - значит пользователь 
    // выбрал "купить" соответствующий товар. Помещаем выбранный товар в ячейку 'cart' массива $_SESSION в 
    // виде вложенного массива с ключом id и количеством.
    // Если товар с таким id в $_SESSION['cart'] уже есть (например, пользователь решил добавить ещё такого же товара),
    // то увеличиваем значение ячейки на соотвуствующее число.

    // !!!!! необходимо реализовать проверку на то, что id, полученный в $_GET реально существует. !!!!!

    if ((count($_GET) > 0) && (!isset($_GET['count']))) {

        foreach ($_GET as $id => $count) {
            if ($_SESSION['cart'][$id] <= 0) $_SESSION['cart'][$id] = $count;
            else $_SESSION['cart'][$id] += $count;
        };
    }

    // если пользователь нажал кнопку "ещё" - увечиливаем $prodCount - количество отображаемых товаров на странице.

    elseif (isset($_GET['count'])) {
        $prodCount = $_GET['count'];
    };

        // создаём массив содержащий n первых товаров из БД соответствующей структуры:
        // ключи равны артикулам товаров (id в БД), 
        // в ячейках - вложенные массивы с ключами 'product_name', 'price', 'prod_image'
    $catalog = new getCatalog($prodCount, $sqlconf);
    $products = $catalog->getCatalog();

    // Наполняем массив $cart - временная переменная для передачи во view v_header.php 
    // и подключаемый фрагмент v_headerCart.php
    // Данные копируются из $_SESSION, в котором содержимое корзины хранится на длительной основе.

    $cart = [];
    if (count($_SESSION['cart']) > 0)
        foreach ($_SESSION['cart'] as $id => $count) {
            if ($count > 0) {
                $cart[$id] = $count;
                $total += $products[$id]['price'] * $count; 
                };

            };
    // var_dump($cart);
?>