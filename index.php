<?php

include('vendor/autoload.php');
require 'Models/loger.php';

use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Models\DataBase\DBConnection;
use Models\DataBase\SaveContact;
use Models\DataBase\SaveFriendContact;
use Models\DataBase\IsContact;
use Models\DataBase\FriendId;
use Models\MsgResponse;
use Models\CallBackResponse;
use Models\Contact;
use Models\Environment;


// настройка Webhook, Api
$token = new Environment();
$token->urlWebhook();
$telegram = new Api($token->token());
$keyboard = new Keyboard();
$result = $telegram -> getWebhookUpdates();

// message и callBack ответы
$msgResponse = new MsgResponse($result);
$cbResponse = new CallBackResponse($result);

// подключение к БД
$db = new DBConnection('localhost', 'telegram_bot', 'debian-sys-maint', 'jXv4ztAUHyr9U7as');

// доступные команды в боте (здесь можно дополнять новыми командами)
switch ($msgResponse->text()) {
    case "/start":
        $inlineButton = $keyboard->make()->inline()
            ->row($keyboard->inlineButton(['text' => 'Arrested', 'callback_data' => "arrested"]))
            ->row($keyboard->inlineButton(['text' => 'Add friend contact', 'callback_data' => "friend_contact"]))
            ->row($keyboard->inlineButton(['text' => 'Add my contact', 'callback_data' => "my_contact"]));
        $telegram->sendMessage([
            'chat_id' => $msgResponse->chatId(),
            'text' => 'Alert Bot for your safety. You need add friend contact and your contact. Click any button for further action',
            'reply_markup' => $inlineButton
        ]);
        break;
}

// ответы на callBack методы
switch ($cbResponse->query()) {
    case "my_contact":
        $shareContactButton = $keyboard->make(['resize_keyboard' => true, 'one_time_keyboard' => true])
            ->row($keyboard->Button(['text' => 'Press to share your phone number', 'request_contact' => true]));
        $telegram->sendMessage([
            'chat_id' => $cbResponse->chatId(),
            'text' => 'Use button below to share your phone number',
            'reply_markup' => $shareContactButton
        ]);
        break;

    case "friend_contact":
        $telegram->sendMessage([
            'chat_id' => $cbResponse->chatId(),
            'text' => 'Attach contact to share friend\'s phone number'
        ]);
        break;

    case "arrested":
        $friends = new FriendId($cbResponse->chatId());

        $telegram->sendMessage([
            'chat_id' => $friends->getId($db->getConnection()),
            'text' => 'Your friend is arrested'
        ]);
        break;
}


// сохранение контактов в БД:
$contact = new Contact($result);

// сохранение контакта клиента в БД
$user = new IsContact($contact->userContact(), 'users', 'chat_id');
$saveContact = new SaveContact($contact->userContact());

if ($contact->userContact()){
    if (is_null($user->isSet($db->getConnection()))) {
        $saveContact->save($db->getConnection());
        $telegram->sendMessage([
            'chat_id' => $msgResponse->chatId(),
            'text' => 'Your phone number is Saved'
        ]);
    } else {
        $telegram->sendMessage([
            'chat_id' => $msgResponse->chatId(),
            'text' => 'Your phone number is saved Early'
        ]);
    }
}


// сохранение контакта друга в БД
$friendUser = new IsContact($contact->friendContact(), 'friends', 'friend_chat_id');
$friend = new SaveFriendContact($contact->friendContact(), $msgResponse->chatId());

if ($contact->friendContact()){
    if (is_null($friendUser->isSet($db->getConnection()))) {
        $friend->save($db->getConnection());
        $telegram->sendMessage([
            'chat_id' => $msgResponse->chatId(),
            'text' => 'Friend phone number is Saved'
        ]);
    } else {
        $telegram->sendMessage([
            'chat_id' => $msgResponse->chatId(),
            'text' => 'Friend Number is saved Early'
        ]);
    }
}