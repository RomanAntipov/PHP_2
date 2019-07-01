<?php
    // include './model/m_logeng.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>&#9776; Login <?=$today?></title>
    <!-- <script src="script.js" defer></script> -->

</head>

<body>

<div align="right">
        <?php
        if ($_SESSION['auth']) echo $_SESSION['username'].'&#8195;<a href="engine/logeng.php?action=unlog">выход</a>';
        else echo '<a href="login.php">вход</a>';
        ?>
        <br>
        <a href="administration.php">Управление</a>
</div>

<p>
    Добро пожаловать в наш интернет-магазин!
</p>
<div>
    <?include $content?>
</div>
</body>
</html>