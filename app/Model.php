<?php
namespace app;

class Model {
    private $link;
    public function __construct($link){
        $this->link = $link;
    }
    public function query($query){
        return mysqli_query($this->link , $query);
    }
    public function addUser($chat_id){
        $query = "INSERT INTO users (user_id , subscription) VALUES (" . $chat_id . " , 0)";
        return $this->query($query);
    }
    public function updateSubscription($chat_id , $subscription){
        $query = "UPDATE users SET subscription = " . $subscription . " WHERE user_id = " . $chat_id;
        return $this->query($query);
    }
    public function findUser($chat_id){
        $query = "SELECT * FROM users WHERE user_id = " . $chat_id;
        return $this->query($query);
    }
    public function selectSubscription(){
        $query = "SELECT * FROM users WHERE subscription = 1";
        return $this->query($query);
    }
}