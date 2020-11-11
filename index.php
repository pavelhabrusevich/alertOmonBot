<?php
include('vendor/autoload.php');
//require 'autoload.php';

//require 'Models/SaveContact.php';
//require 'Models/SaveFriendContact.php';
//require 'Models/IsContact.php';
//require 'Models/FriendId.php';
//require "Models/DBConnection.php";

//require  "Models/MsgResponse.php";
//require  "Models/CallBackResponse.php";
//require  "Models/Contact.php";

//require "Models/Environment.php";

//use Models\DBConnection\DBConnection;
use Models\DBConnection;



//use Models\DataBase\SaveContact\SaveContact;
//use Models\DataBase\SaveFriendContact\SaveFriendContact;
//use Models\DataBase\IsContact\IsContact;
//use Models\DataBase\FriendId\FriendId;

use Models\SaveContact;
use Models\SaveFriendContact;
use Models\IsContact;
use Models\FriendId;



//use Models\MsgResponse\MsgResponse;
//use Models\CallBackResponse\CallBackResponse;
//use Models\Contact\Contact;

use Models\MsgResponse;
use Models\CallBackResponse;
use Models\Contact;


//use Models\Environment\Environment;

use Models\Environment;


use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;


//const TOKEN = '1274358640:AAFGPDZ15k9YrOAxKtsxcfi23oOx5hLrHpg';

//$urlGetUpdates = 'https://api.telegram.org/bot'. TOKEN . '/getUpdates';
//$urlSendMessage = 'https://api.telegram.org/bot'. TOKEN . '/sendMessage';

//подключение webhook
//const URLNGROK = 'https://264b739af2b0.ngrok.io/';
//echo $urlWebhook = 'https://api.telegram.org/bot'. TOKEN . '/setWebhook?url=' . URLNGROK;

file_put_contents( __DIR__ . 'log.txt', file_get_contents('php://input'));

$token = new Environment();
$token->urlWebhook();

$telegram = new Api($token->token());
$keyboard = new Keyboard();
$result = $telegram -> getWebhookUpdates();


//$msgText = msgText();
$msgResponse = new MsgResponse($result);
//$msgText->text();
//$msgChatId = msgChatId(); //chatId для sendMessage метода

$cbResponse = new CallBackResponse($result);
//$cbChatId = cbChatId(); //chatId для callBack метода
//$cbText = cbMsgText(); //text для callBack метода
//$cbQuery = cbQuery(); //callBackQuery для callBack метода

//$response = json_decode(file_get_contents('php://input'), TRUE);


$db = new DBConnection('localhost', 'telegram_bot', 'debian-sys-maint', 'jXv4ztAUHyr9U7as');



switch ($msgResponse->text()) {
    case "/start":
        $inlineButton = $keyboard->make()->inline()
            ->row($keyboard->inlineButton(['text' => 'arested', 'callback_data' => "arested"]))
            ->row($keyboard->inlineButton(['text' => 'friend contacts', 'callback_data' => "friend_contact"]))
            ->row($keyboard->inlineButton(['text' => 'my contacts', 'callback_data' => "my_contact"]));
        $telegram->sendMessage([
            'chat_id' => $msgResponse->chatId(),
            'text' => 'Alert Bot for safety',
            'reply_markup' => $inlineButton
        ]);
        break;

//    case "key":
//        $keyboardButton = $keyboard->make(['resize_keyboard' => true, 'request_contact' => true, 'one_time_keyboard' => true])
//            ->row(
//                $keyboard->Button(['text' => 'But1']),
//                $keyboard->Button(['text' => 'But2']));
//        $telegram->sendMessage([
//            'chat_id' => $msgChatId,
//            'text' => $msgText,
//            'reply_markup' => $keyboardButton
//        ]);
//        break;
}



switch ($cbResponse->query()) {
    case "my_contact":
        $shareContactButton = $keyboard->make(['resize_keyboard' => true, 'one_time_keyboard' => true])
            ->row($keyboard->Button(['text' => 'press to share your phone number', 'request_contact' => true]));
        $telegram->sendMessage([
            'chat_id' => $cbResponse->chatId(),
            'text' => 'Share your phone',
            'reply_markup' => $shareContactButton
        ]);
        break;

    case "friend_contact":
        $telegram->sendMessage([
            'chat_id' => $cbResponse->chatId(),
            'text' => 'Share friend\'s phone as attach contact'
        ]);
        break;

    case "arested":
        $friends = new FriendId($cbResponse->chatId());

        $telegram->sendMessage([
            'chat_id' => $friends->getId($db->getConnection()),
            'text' => 'your friend is arested'
        ]);
        break;
}





// сохранение в БД
$contact = new Contact($result);
// сохранение контакта клиента в БД
//$contact = getUserContact();
$user = new IsContact($contact->userContact(), 'users', 'chat_id');

$saveContact = new SaveContact($contact->userContact());
//$db = new DBConnection('localhost', 'telegram_bot', 'debian-sys-maint', 'jXv4ztAUHyr9U7as');

//if (isset($contact)){
if ($contact->userContact()){
    if (is_null($user->isSet($db->getConnection()))) {
        $saveContact->save($db->getConnection());
        $telegram->sendMessage([
            'chat_id' => $msgResponse->chatId(),
            'text' => 'Your phone number is saved'
        ]);
    } else {
        $telegram->sendMessage([
            'chat_id' => $msgResponse->chatId(),
            'text' => 'Number is saved early'
        ]);
    }
}


// сохранение контакта друга в БД
//$friendContact = getFriendContact();
$friendUser = new IsContact($contact->friendContact(), 'friends', 'friend_chat_id');
$friend = new SaveFriendContact($contact->friendContact(), $msgResponse->chatId());

if ($contact->friendContact()){
    if (is_null($friendUser->isSet($db->getConnection()))) {
        $friend->save($db->getConnection());
        $telegram->sendMessage([
            'chat_id' => $msgResponse->chatId(),
            'text' => 'Friend phone number is saved'
        ]);
    } else {
        $telegram->sendMessage([
            'chat_id' => $msgResponse->chatId(),
            'text' => 'Friend Number is saved early'
        ]);
    }
}