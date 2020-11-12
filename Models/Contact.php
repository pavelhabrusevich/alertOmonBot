<?php

namespace Models;

/**
 * Class Contact
 * @package Models
 */
class Contact
{
    protected $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    /**
     * @return main user contact
     */
    public function userContact(){
        if (isset($this->result["message"]["chat"]["id"])
            && isset($this->result["message"]["contact"]["user_id"])
            && $this->result["message"]["chat"]["id"] == $this->result["message"]["contact"]["user_id"]){
            return $this->result['message']['contact'];
        }
    }

    /**
     * @return friend contact
     */
    public function friendContact(){
        if (isset($this->result["message"]["chat"]["id"])
            && isset($this->result["message"]["contact"]["user_id"])
            && $this->result["message"]["chat"]["id"] !== $this->result["message"]["contact"]["user_id"]){
            return $this->result['message']['contact'];
        }
    }
}