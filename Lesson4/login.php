<?php
    include 'engine/logeng.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>&#9776; Login</title>
    <!-- <script src="script.js" defer></script> -->


</head>

<body>

<div>
	<form method="post">
        <fieldset><legend width="200px">Вход</legend>
            <div>
                <div>Логин:</div>
                <div><input type="text" name="login" placeholder="login"></div>
                <div>Пароль:</div>
                <div><input type="text" name="password" placeholder="password"></div>
                <button type="submit">Войти</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
</body>
</html>