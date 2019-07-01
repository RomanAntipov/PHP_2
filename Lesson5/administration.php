<?php
    session_start();
    include 'engine/db.php';
    include 'engine/ordman.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>&#9776; Управление заказами</title>
    <!-- <script src="script.js" defer></script> -->

    <style>
        .orders {
            min-height: 100px;
            width: calc(100%-30px);
            margin: auto; 
            padding: 20px;
        }

        .catCl {
            overflow: hidden;

        }

        .catCl div {
            border: 2px solid darkblue;
            width: 150px;
            min-height: 271px;
            display: inline-block;
            margin: 10px;
            padding: 10px;
            text-align: center;
            float: left;

        }

        .catCl div img {
            height: 70px;
        }

        .input {
            width: 30px;
        }

    </style>

</head>

<body>

<div>
    <div align="right">
        <?php
        if ($_SESSION['auth']) echo $_SESSION['username'].'&#8195;<a href="engine/logeng.php?action=unlog">выход</a>';
        else echo '<a href="login.php">вход</a>';
        ?>
        <br>
        <a href="index.php">Главная страница</a>
        <?
        if ($_SESSION['auth'] && $_SESSION['username'] == 'admin'):?>
        <br>
        <a href="products.php">Управление товарами</a>
        <?endif;?>
        <!-- <? var_dump($ordersList)?> -->
    </div>
    <h2>
    	Список заказов:
    </h2>
    <div>
    	<?php
            foreach ($ordersList as $order_id => $item) {?>
        	<div class="orders">  
          	<p>
          		Заказ №<b><?=$order_id?></b>, Дата: <b><?=$item['dateTime']?></b>, Клиент: <b><?=$item['userName']?></b>
        	</p>

        
		        <table border="1" cellpadding="7" cellspacing="0">
		            <tr>
		                <td width="10%" align="center">Артикул </td>
		                <td width="40%" align="center">Наименование</td>
		                <td width="10%" align="center">Количество</td>
		                <td width="10%" align="center">Цена</td>
		                <td width="10%" align="center">Сумма</td>
		                <td width="20%" align="center"></td>
		            </tr>
		            <?php
		                foreach ($item['orderProducts'] as $productId => $prodProp) {
		                	if ($productId !== 'totalOrder'): ?>
		                <tr>
		                    <td width="10%" align="center"><?=$productId?> </td>
		                    <td width="40%" align="center"><?=$prodProp['productName']?></td>
		                    <td width="10%" align="center"><?=$prodProp['count']?></td>
		                    <td width="10%" align="center"><?=$prodProp['price']?></td>
		                    <td width="10%" align="center"><?=$prodProp['totalprice']?></td>
		                    <td width="20%" align="center"><a href="?OrderId=<?=$order_id?>&ProductId=<?=$productId?>">Удалить</a></td>
		                </tr>
		            <?
		            	endif;
		               ;}; 
		            ?>
		        </table>
        <p>Итого: <?=$item['orderProducts']['totalOrder']?>   <a href="?OrderId=<?=$order_id?>&ProductId=all">Удалить заказ полностью</a></p><hr>
    </div>

        <?
            ;}; 
        ?>
    </div>
   
	</div>
</body>
</html>