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

$imgtags = '';
foreach ($imagelist as $key => $file) {
    // тест - проверяем, как функция перебирает значения в массиве. В продуктовой версии строчку закомментировать.
    // echo 'Ключ: '.$key.', имя файла: '.$file.'<br/>';


    // var_dump(strpos(mime_content_type('big/'.$file), 'image') === 0); // тест для проверки работы условия

    $currentitem = '<img src="big/'.$file.'" height="100px" id="'.$file.'"/>';
    $imgtags .= $currentitem;
};

?>