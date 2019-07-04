<?php
    session_start();
    $prodCount = 25;
    
    include 'model/m_cart.php';
    $basket = 'v-headerEmptyBasket.php';
    if (count($cart)>0) $basket = 'v-headerCart.php';
    $catalog = 'v-headerCatalog.php';
    include 'view/v-header.php';
?>

