<?php
    session_start();

    $prodCount = 25;

    if ((count($_GET) > 0) && (!isset($_GET['count']))) {

        foreach ($_GET as $id => $count) {
            if ($_SESSION['cart'][$id] <= 0) $_SESSION['cart'][$id] = $count;
            else $_SESSION['cart'][$id] += $count;
        };
    }
    elseif (isset($_GET['count'])) {
        $prodCount = $_GET['count'];
        // echo "prodCount=".$prodCount."     _GET['count']=".$_GET['count'];
    };

        // создаём массив содержащий все товары из БД
    $products = makePrList($mysql, $prodCount);

    $cart = [];
    if (count($_SESSION['cart']) > 0)
        foreach ($_SESSION['cart'] as $id => $count) {
            if ($count > 0) {
                $cart[$id] = $count;
                $total += $products[$id]['price'] * $count; 
                };

            };

?>