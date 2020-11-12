<?php

namespace Models;

/**
 * Class CallBackResponse
 * @package Models
 */
class CallBackResponse
{
    protected $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    /**
     * @return chat id if Call Back response
     */
    public function chatId(){
        if (isset($this->result['callback_query']['message']['chat']['id'])){
            return $this->result['callback_query']['message']['chat']['id'];
        }
    }

    /**
     * @return data if Call Back response
     */
    public function query(){
        if (isset($this->result['callback_query']['data'])){
            return $this->result['callback_query']['data'];
        }
    }
}