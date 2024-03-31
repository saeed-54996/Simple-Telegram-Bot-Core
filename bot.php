<?php

define('BOT_TOKEN', '6516960962:AAHOyEy8dqYSOCoMqGpG9fInXQuucMFEGdc');
// Replace your Telegram Bot token, get it from https://t.me/BotFather
define('ADMIN_ID', '141872429');
// Get your Telegram-ID from https://t.me/userinfobot
// This is used for reporting if a method is calling incorrect or with false parameters to telegram.

//After editing token and admin , you need to set a webhook to your script (set it by editing and opening this):
// https://api.telegram.org/bot<YourBOTToken>/setWebhook?drop_pending_updates=true&url=https://yourdomain.com/yourBotWebhookEndpoint

//----------------------------------------------------------------
define('API_URL', 'https://api.telegram.org/bot' . BOT_TOKEN . '/');
function bot($method, $parameters)
{
	if (!$parameters) {
		$parameters = array();
	}
	$parameters["method"] = $method;
	$handle = curl_init(API_URL);
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($handle, CURLOPT_TIMEOUT, 60);
	curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
	curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	$result = curl_exec($handle);
	$res = json_decode($result,true);
	if(!$res['ok']){
		bot("sendMessage", array('chat_id' => 'ADMIN_ID','text' => $result));
	}
	return $result;
}
//===============   BOT MAIN =============
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!isset($update["callback_query"])) {

    //===============  Telegram Basic Variables:  =============
    @$chat_id = $update["message"]['chat']['id'];
	@$text = $update["message"]['text'];
	@$username = $update["message"]['from']['username'];
	//first name & last name
	$first_name = $update["message"]['from']['first_name'];

	@$user_id = $update["message"]['from']['id'];
	@$message_id = $update["message"]['message_id'];
    //===============                             =============


    if($text="/start"){
        bot("sendMessage", array('chat_id' => $chat_id,'text' =>"Hello World!"));
    }

    
}
else{ //inline_keyboard answers:
}
// Uncomment below for getting all updates from telegram:
//bot("sendMessage", array('chat_id' => ADMIN_ID,'text' => json_encode($update)));