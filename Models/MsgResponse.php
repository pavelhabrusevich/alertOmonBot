<?php

namespace Models;

class MsgResponse
{
    protected $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    public function text(){
        if (isset($this->result["message"]["text"])){
            return $this->result["message"]["text"];
        }
    }

    function chatId(){
        if (isset($this->result["message"]["chat"]["id"])){
            return $this->result["message"]["chat"]["id"];
        }
    }
}