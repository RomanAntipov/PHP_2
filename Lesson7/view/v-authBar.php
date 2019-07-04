<? if ($_SESSION['auth']):?> 
	<?=$_SESSION['username']?>
	&#8195;<a href="engine/logeng.php?action=unlog">выход</a>
<?else:?>
    <a href="login.php">вход</a>
<?endif?>
<? if ($_SESSION['auth'] && $_SESSION['username'] == 'admin'):?>
    <br>
    <a href="administration.php">Управление заказами</a><br>
    <a href="products.php">Управление товарами</a>
<?endif;?>
