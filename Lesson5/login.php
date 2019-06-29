<?php
    $today = date('d-m-Y');
    session_start();
    // var_dump($today);

    // var_dump($_SESSION);
    if ($_SESSION["auth"] == true)
        $content = 'view/v_contWelc.php';
    else $content = 'view/v_contForm.php';

    if (isset($_POST['login'], $_POST['password'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];
        include 'model/m_logeng.php';
    };

    include 'view/v_login.php';