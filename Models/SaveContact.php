<?php

//namespace Models\DataBase\SaveContact;
namespace Models;

//require __DIR__ . '/DataBase.php';

//use \Models\DataBase\DataBase;

//class SaveContact implements DataBase
class SaveContact
{
    protected $contact;

    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    public function save($dbconnection){
        $userId = $this->contact['user_id'];
        $phoneNumber = $this->contact['phone_number'];
        $firstName = $this->contact['first_name'];
        $lastName = $this->contact['last_name'];
        $query = "INSERT INTO `users` (`chat_id`, `phone_number`, `first_name`, `last_name`) VALUES ('$userId', '$phoneNumber', '$firstName', '$lastName')";
        mysqli_query($dbconnection, $query);
    }
}