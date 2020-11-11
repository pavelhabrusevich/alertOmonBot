<?php

//namespace Models\CallBackResponse;
namespace Models;

class CallBackResponse
{
    protected $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    public function chatId(){
        if (isset($this->result['callback_query']['message']['chat']['id'])){
            return $this->result['callback_query']['message']['chat']['id'];
        }
    }

    public function query(){
        if (isset($this->result['callback_query']['data'])){
            return $this->result['callback_query']['data'];
        }
    }
}