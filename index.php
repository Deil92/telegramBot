<?php

require __DIR__ . '/vendor/autoload.php';
$host = 'localhost';
$database = 'telegbot';
$user = 'root';
$password = 'root';

$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));
$i = 0;
$bot_token = '501326766:AAGlw6wRABUZ35X-pzeM49nJ5AFTB5ZIy4Y';
while(true){
    $telegram = new Telegram($bot_token);
    // Get all the new updates and set the new correct update_id
    $req = $telegram->getUpdates();
    for ($i = 0; $i < $telegram->UpdateCount(); $i++) {
        // You NEED to call serveUpdate before accessing the values of message in Telegram Class
        $telegram->serveUpdate($i);
        $text = $telegram->Text();
        $chat_id = $telegram->ChatID();
        if ($text == '/start') {
            $reply = 'Добро пожаловать.  Вы хотите подписаться на рассылку?';
            $content = ['chat_id' => $chat_id, 'text' => $reply];
            $telegram->sendMessage($content);
            
            $option = [['Подписаться'] , ['Отписаться']];
            $keyb = $telegram->buildKeyBoard($option);
            $reply = 'Выберите нужный вариант';
            $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb , 'text' => $reply];
            $telegram->sendMessage($content);
            if(mysqli_query($link , "SELECT * FROM users WHERE user_id = " . $chat_id)->new_rows == 0){
                mysqli_query($link , "INSERT INTO users (user_id , subscription) VALUES (" . $chat_id . " , 0)");
            }
        }
        if($text == 'Подписаться'){
            $reply = 'Вы подписались';
            $content = ['chat_id' => $chat_id, 'text' => $reply];
            $telegram->sendMessage($content);
            mysqli_query($link , "UPDATE users SET subscription = 1 WHERE user_id = " . $chat_id);
        }
        if($text == 'Отписаться'){
            $reply = 'Вы отписались';
            $content = ['chat_id' => $chat_id, 'text' => $reply];
            $telegram->sendMessage($content);
            mysqli_query($link , "UPDATE users SET subscription = 0 WHERE user_id = " . $chat_id);
        }
    }
    sleep(5);
    $i++;
    if($i == 720){
        //video = new TrendVideo();
        $userdb = mysqli_query($link , "SELECT * FROM users WHERE subscription = 1");
        while($row = $userdb->fetch_assoc()){
           echo 'dwada'; 
        }
    }
}