<?php

namespace Models\DataBase;

use \Models\DataBase\DataBase as DataBase;

/**
 * Class FriendId
 * @package Models\DataBase
 */
class FriendId implements DataBase
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param $dbconnection
     * @return FriendId
     */
    public function getId($dbconnection)
    {
        $friends = mysqli_query($dbconnection,"SELECT `friend_chat_id` FROM `friends` WHERE `user_chat_id` = '$this->userId'");
        while ($id = mysqli_fetch_assoc($friends)){
            return $id['friend_chat_id'];
        }
    }
}