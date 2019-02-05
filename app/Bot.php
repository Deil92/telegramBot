<?php 
namespace app;
use Telegram;

class Bot {
    private $bot_token = 'telegram_token';
    public function run($link){
        $telegram = new Telegram($this->bot_token);
        $model = new Model($link);
        $n = 0;
        while(true){
            $req = $telegram->getUpdates();
            for ($i = 0; $i < $telegram->UpdateCount(); $i++) {
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
                    if($model->findUser($chat_id)->new_rows == 0){
                        $model->addUser($chat_id);
                    }
                }
                if($text == 'Подписаться'){
                    $reply = 'Вы подписались';
                    $content = ['chat_id' => $chat_id, 'text' => $reply];
                    $telegram->sendMessage($content);
                    $model->updateSubscription($chat_id , 1);
                }
                if($text == 'Отписаться'){
                    $reply = 'Вы отписались';
                    $content = ['chat_id' => $chat_id, 'text' => $reply];
                    $telegram->sendMessage($content);
                    $model->updateSubscription($chat_id , 0);
                }

                    $video = new Youtube();
                    $videoList = $video->orderByNone();
                    $userdb = $model->selectSubscription();
                    while($row = $userdb->fetch_assoc()){
                        for($h = 0; $h < 20; $h++){
                            $reply = "Название : " . $videoList[$h]['name'];
                            $reply = $reply . "   Ссылка : " . $videoList[$h]['url'];
                            $telegram->sendMessage(['chat_id' => $row['user_id'], 'text' => $reply]);
                        }
                    }
                sleep(5);
            }
        }
    }
}