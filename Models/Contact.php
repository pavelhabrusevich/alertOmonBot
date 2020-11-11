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
        if ($this->result["message"]["chat"]["id"] == $this->result["message"]["contact"]["user_id"]){
            return $this->result['message']['contact'];
        }
    }

    public function friendContact(){
        if ($this->result["message"]["chat"]["id"] !== $this->result["message"]["contact"]["user_id"]){
            return $this->result['message']['contact'];
        }
    }
}