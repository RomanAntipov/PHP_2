<?php
require_once ('/lib/Twig/autoloader.php');
Twig_Autoloader::register();


$dir = 'big/';

// получаем список всех файлов в директории big/ и помещаем его в массив $fileslist
$fileslist = scandir($dir);

// проверяем, что функция отработала и массив сформирован, в продуктовой версии данную строчку закомментировать.
// var_dump($fileslist);

// далее пересобираем массив без файлов, не являющихся изображениями

$imagelist = [];

foreach ($fileslist as $key => $file) {
    // тест - проверяем, как функция перебирает значения в массиве. В продуктовой версии строчку закомментировать.
    // echo 'Ключ: '.$key.', имя файла: '.$file.'<br/>';

    if (strpos(mime_content_type('big/'.$file), 'image') === 0) {    // если файл имеет тип изображение, то помещаем имя файла в массив $imagelist[] с тем же ключом
    $imagelist[$key] = $file;
    };
};

try {
	// Указывает, где хранятся шаблоны
  	$loader = new Twig_Loader_Filesystem('templates');
	// Инициализируем Twig
 	$twig = new Twig_Environment($loader);
	// Подгружаем шаблон
 	$template = $twig->loadTemplate('thanks.tmpl');
	// Передаем в шаблон переменные и значения
	// Выводим сформированное содержание
  	echo $template->render($imagelist);
 	} 
 catch (Exception $e) {
 	die ('ERROR: ' . $e->getMessage());
};

?>