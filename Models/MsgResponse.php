<?php

namespace Models;

/**
 * Class MsgResponse
 * @package Models
 */
class MsgResponse
{
    protected $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    /**
     * @return text if message response
     */
    public function text(){
        if (isset($this->result["message"]["text"])){
            return $this->result["message"]["text"];
        }
    }

    /**
     * @return chat id if message response
     */
    function chatId(){
        if (isset($this->result["message"]["chat"]["id"])){
            return $this->result["message"]["chat"]["id"];
        }
    }
}