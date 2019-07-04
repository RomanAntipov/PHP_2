<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>&#9776; Каталог</title>
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

        #cart {
            min-height: 200px;
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
        <a href="administration.php">Управление</a>
    </div>
        <? include $basket;
        include $catalog ?>
</div>
</body>
</html>