<?php
    session_start();
    include 'db.php';
    include '../model/m_cart.php';

// var_dump($cart);
makeOrder($cart, $_SESSION['username'], 'testPhone', 'testAddress', $mysql);
$_SESSION['cart'] = [];
header ('location: ../index.php');