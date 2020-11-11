<?php

//namespace Models\DBConnection;
namespace Models;

class DBConnection
{
    protected $host;
    protected $name;
    protected $username;
    protected $password;

    public function __construct($host, $name, $username, $password)
    {
        $this->host = $host;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
    }

    public function getConnection(){
        return mysqli_connect($this->host, $this->username, $this->password, $this->name);
    }
}