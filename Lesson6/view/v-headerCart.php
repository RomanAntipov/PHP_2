    <div id="cart">  
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
                foreach ($cart as $id => $count) {?>
                <tr>
                    <td width="10%" align="center"><?=$id?> </td>
                    <td width="40%" align="center"><?=$products[$id]['product_name']?></td>
                    <td width="10%" align="center"><?=$count?></td>
                    <td width="10%" align="center"><?=$products[$id]['price']?></td>
                    <td width="10%" align="center"><?=$products[$id]['price']*$count?></td>
                    <td width="20%" align="center"><a href="?<?=$id.'='.(-1 * $count)?>">Удалить</a></td>
                </tr>
            <?
               ;}; 
            ?>
        </table>
        <?if ($total): ?>
            <p>
                Итого: <?=$total?> <br>
                 <a href="buy.php">Оформить заказ</a> 
            </p>
        <?php endif; ?>
    </div>