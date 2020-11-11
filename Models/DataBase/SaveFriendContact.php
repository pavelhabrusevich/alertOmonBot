<?php

namespace Models\DataBase;

use \Models\DataBase\DataBase  as DataBase;

class SaveFriendContact implements DataBase
{
    protected $contact;
    protected $parentUserId;

    public function __construct($contact, $parentUserId)
    {
        $this->contact = $contact;
        $this->parentUserId = $parentUserId;
    }

    public function save($dbconnection){
        $userId = $this->contact['user_id'];
        $phoneNumber = $this->contact['phone_number'];
        $firstName = $this->contact['first_name'];
        $query = "INSERT INTO `friends` (`friend_chat_id`, `friend_phone_number`, `friend_first_name`, `user_chat_id`) 
        VALUES ('$userId', '$phoneNumber', '$firstName', '$this->parentUserId')";
        mysqli_query($dbconnection, $query);
    }
}