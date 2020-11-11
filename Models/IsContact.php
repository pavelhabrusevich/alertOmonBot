<?php

//namespace Models\DataBase\IsContact;
namespace Models;

//use \Models\DataBase\DataBase;

//class IsContact implements DataBase
class IsContact
{
    protected $user;
    protected $table;
    protected $column;

    public function __construct($user, $table, $column)
    {
        $this->user = $user;
        $this->table = $table;
        $this->column = $column;
    }

    public function isSet($dbconnection){
        $chatId = $this->user['user_id'];
        $query = "SELECT * FROM `$this->table` WHERE `$this->column` = '$chatId'";
        $contact = mysqli_query($dbconnection, $query);
        while ($id = mysqli_fetch_assoc($contact)) {
            return $id[$this->column];
        }
    }
}