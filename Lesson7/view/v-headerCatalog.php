    <div id="catalog" class="catCl">
    <?php
        foreach ($products as $id => $item) {
            $prodname = $item['product_name'];?>
            <div>
                <img src="<?=$item['prod_image']?>" alt="<?=$prodname?>" title="<?=$prodname?>"><br>
                <h2><?=$prodname?></h2>
                <p>Price: $<?=$item['price']?></p>
                <p>
                    <form method="get">
                        <input type="number" value = "1" name="<?=$id?>" class="input">
                        <button type="submit">Купить</button>
                    </form>
                </p>
            </div> <?
        };
    ?>
    </div>
    <!-- <p><?=$prodCount?></p> -->
    <a href="?count=<?=$prodCount + 25?>">ещё</a>