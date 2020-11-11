<?php
//use Telegram\Bot\Api;
//use Telegram\Bot\Keyboard\Keyboard;
//
//const TOKEN = '1274358640:AAFGPDZ15k9YrOAxKtsxcfi23oOx5hLrHpg';
//
//$urlGetUpdates = 'https://api.telegram.org/bot'. TOKEN . '/getUpdates';
//$urlSendMessage = 'https://api.telegram.org/bot'. TOKEN . '/sendMessage';
//
////подключение webhook
//const URLNGROK = 'https://264b739af2b0.ngrok.io/';
//echo $urlWebhook = 'https://api.telegram.org/bot'. TOKEN . '/setWebhook?url=' . URLNGROK;
//
//$telegram = new Api(TOKEN);
//$keyboard = new Keyboard();
//$result = $telegram -> getWebhookUpdates();
//
//// для sendMessage метода
//function msgText(){
//    global $result;
//    if (isset($result["message"]["text"])){
//        return $result["message"]["text"];
//    }
//}
//function msgChatId(){
//    global $result;
//    if (isset($result["message"]["chat"]["id"])){
//        return $result["message"]["chat"]["id"];
//    }
//}
//// для callBack метода
//function cbChatId(){
//    global $result;
//    if (isset($result['callback_query']['message']['chat']['id'])){
//        return $result['callback_query']['message']['chat']['id'];
//    }
//}
//function cbMsgText(){
//    global $result;
//    if (isset($result['callback_query']['message']['text'])){
//        return $result['callback_query']['message']['text'];
//    }
//}
//function cbQuery(){
//    global $result;
//    if (isset($result['callback_query']['data'])){
//        return $result['callback_query']['data'];
//    }
//}
//
//function getUserContact(){
//    global $result;
//    if ($result["message"]["chat"]["id"] == $result["message"]["contact"]["user_id"]){
//        return $result['message']['contact'];
//    }
//}
//function getFriendContact(){
//    global $result;
//    if ($result["message"]["chat"]["id"] !== $result["message"]["contact"]["user_id"]){
//        return $result['message']['contact'];
//    }
//}

//file_put_contents( __DIR__ . '/../log.txt', file_get_contents('php://input'));