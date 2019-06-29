<?php

    include 'engine/engine.php';
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>&#9776; Каталог</title>
    <script src="script.js" defer></script>

    <style>
        table {
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
        }
    </style>

</head>





<body>

<div>
    <div id="bigView">  
        <img src="big/<? echo $imagelist[2]?>" width="750px"/>
    </div>
    <div id="preView" class="preViewCl">
    <? 
        foreach ($imagelist as $key => $file) {
            // тест - проверяем, как функция перебирает значения в массиве. В продуктовой версии строчку закомментировать.
            // echo 'Ключ: '.$key.', имя файла: '.$file.'<br/>';

            echo $currentitem = '<img src="big/'.$file.'" height="100px" id="'.$file.'"/>';
            $imgtags .= $currentitem;
        };
    ?>
    </div>
</div>

</body>
</html>