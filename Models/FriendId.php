<?php

//namespace Models\DataBase\FriendId;
namespace Models;

//use \Models\DataBase\DataBase;

//class FriendId implements DataBase
class FriendId
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function getId($dbconnection)
    {
        $friends = mysqli_query($dbconnection,"SELECT `friend_chat_id` FROM `friends` WHERE `user_chat_id` = '$this->userId'");
        while ($id = mysqli_fetch_assoc($friends)){
            return $id['friend_chat_id'];
        }
    }
}