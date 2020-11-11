<?php

namespace Models;

class Contact
{
    protected $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    public function userContact(){
        if (isset($this->result["message"]["chat"]["id"]) == isset($this->result["message"]["contact"]["user_id"])){
            return isset($this->result['message']['contact']);
        }
    }

    public function friendContact(){
        if (isset($this->result["message"]["chat"]["id"]) !== isset($this->result["message"]["contact"]["user_id"])){
            return $this->result['message']['contact'];
        }
    }
}