<?php
    include $_SERVER["DOCUMENT_ROOT"].'/tamitama/hoodyshop'.'/element/header.php'; //when you install in your server maybe your directiory will different from this one you can change quote after "Documentroot" for the right path.
?>
<h1>hello</h1>

<?php 
    echo $_SERVER["DOCUMENT_ROOT"];
    $s = scandir($_SERVER["DOCUMENT_ROOT"].'/tamitama/hoodyshop');
    print_r($s);
?>
