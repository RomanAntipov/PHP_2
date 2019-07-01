<?php
    session_start();
    include 'model/m_cart.php';
    $basket = 'v-headerEmptyBasket.php';
    if (count($cart)>0) $basket = 'v-headerCart.php';
    $catalog = 'v-headerCatalog.php';
    include 'view/v-header.php';
?>

