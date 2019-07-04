<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>&#9776; Управление товарами</title>
    <!-- <script src="script.js" defer></script> -->

    <style>
      /*  table {
             border-spacing: 0;
        }
        td {
            border: 0.5px solid white;
            text-align: center;
        }
        #bigView {
            text-align: center;
            margin: 20px 50px;
        }
        .preViewCl {
            display: flex;
            flex-direction: row;
            justify-content: space-evenly;
            flex-wrap: wrap;
            align-self: flex-start;
            width: 800px;
            margin: 20px auto;
        }*/

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
        <? include 'view\v-authBar.php' ?>
        <br>
        <a href="index.php">Главная страница</a>
     
    </div>
    <h2>
    	Управление товарами:
    </h2>

<div>
    <form method="get">
        <fieldset><legend width="200px">Создание нового товара</legend>
            <div>
                <div>Наименование товара</div>
                <div><input type="text" name="prodname" placeholder="Наименование товара"></div>
                <div>Цена</div>
                <div><input type="number" step="0.01" name="price" placeholder="Цена товара"></div>
                <div>Наименование файла с изображением (поместить в папку /img)</div>
                <div><input type="text" step="0.01" name="image" placeholder="filename.jpg"></div>
                <button type="submit">Создать</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>

<!-- Для создания нового продукта, в случае если в поля формы введены какие-то значения (для контроля этого в сессию помещаюется флаг true в ячейку $_SESSION['newProduct']['content'])) выводим таблицу с предполагаемыми параметрами будущего нового товара. -->

<? if ($_SESSION['newProduct']['content']):?>
    <h2>Создать новый товар:</h2>
    <br>
    <table border="1" cellpadding="7" cellspacing="0">
        <tr>
            <td width="50%" align="center">Изображение</td>
            <td width="40%" align="center">Наименование</td>
            <td width="10%" align="center">Цена</td>
        </tr>
        <tr>
            <td width="50%" align="center"><img src="img/<?=$_SESSION['newProduct']['image']?>" width="200px"></td>
            <td width="40%" align="center"><b><?=$_SESSION['newProduct']['prodname']?></b></td>
            <td width="10%" align="center"><b><?=$_SESSION['newProduct']['price']?></b></td>
    </table>
    <br>
    <a href="?action=add">Добавить товар в каталог</a>&#8195;&#8195;<a href="?action=clear">Очистить</a>
<?endif;?>


<? if ($_SESSION['killProduct']['content']):
    $killId=$_SESSION['killProduct']['id'];
    ?>
    <h2>Удаление товара из каталога:</h2>
    <br>
    <table border="1" cellpadding="7" cellspacing="0">
        <tr>
            <td width="10%" align="center">ID товара</td>
            <td width="45%" align="center">Изображение</td>
            <td width="35%" align="center">Наименование</td>
            <td width="10%" align="center">Цена</td>
        </tr>
        <tr>
            <td width="10%" align="center"><b><?=$_SESSION['killProduct']['id']?></b></td>
            <td width="45%" align="center"><img src="<?=$products[$killId]['prod_image']?>" width="200px"></td>
            <td width="35%" align="center"><b><?=$products[$killId]['product_name']?></b></td>
            <td width="10%" align="center"><b><?=$products[$killId]['price']?></b></td>
    </table>
    <br>
    <a href="?action=delete&id=<?=$killId?>">Удалить</a>&#8195;&#8195;<a href="?action=clearDelete&id=<?=$id?>">Не удалять</a>
<?endif;?>

    <h2>Существующие товары</h2>
    <div id="catalog" class="catCl">
    <?php
        foreach ($products as $id => $item) {
            $prodname = $item['product_name'];?>
            <div>
                <img src="<?=$item['prod_image']?>" alt="<?=$prodname?>" title="<?=$prodname?>"><br>
                <h2><?=$prodname?></h2>
                <p>Price: $<?=$item['price']?></p>
                <p><a href="?action=preDelete&id=<?=$id?>">Удалить товар</a></p>
          <!--       <p>
                    <form method="get">
                        <input type="number" name="<?=$id?>" class="input">
                        <button type="submit">Купить</button>
                    </form>
                </p> -->
            </div> <?
        };
    ?>
    </div>
</body>
</html>