<?php
namespace app;

require __DIR__ . '/../vendor/autoload.php';

$db = require_once 'db.php';

$link = mysqli_connect($db[0], $db[1], $db[2], $db[3]) 
        or die("Ошибка " . mysqli_error($link));

$bot = new Bot;
$bot->run($link);