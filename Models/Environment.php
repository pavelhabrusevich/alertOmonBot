<?php

namespace Models;

/**
 * Class Environment
 * @package Models
 */
class Environment
{
    const TOKEN = '1274358640:AAFGPDZ15k9YrOAxKtsxcfi23oOx5hLrHpg';
    const URLNGROK = 'https://9ff205f66c55.ngrok.io//';

//    no webHook methods;
//    public $urlGetUpdates = 'https://api.telegram.org/bot'. self::TOKEN . '/getUpdates';
//    public $urlSendMessage = 'https://api.telegram.org/bot'. self::TOKEN . '/sendMessage';

    public function token(){
        return self::TOKEN;
    }

    public function urlWebhook(){
        echo 'PUT FOLLOWING LINK TO BROWSER: https://api.telegram.org/bot'. self::TOKEN . '/setWebhook?url=' . self::URLNGROK;
    }
}