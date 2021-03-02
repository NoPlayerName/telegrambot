<?php
						
$chatid = $message_data["chat"]["id"];
$message_id = $message_data["message_id"];
$text = $message_data["text"];
				
$data = array(
'chat_id' => $chatid,
'text'=>"Processing your request. ".$nama." please wait  ....... \xE2\x8F\xB3",
'parse_mode'=>'Markdown',
'reply_to_message_id' => $message_id
);			
KirimPerintahCurl('sendMessage',$data);	

$data = array(
'chat_id' => $chatid,
'action'=>'typing'
);			
KirimPerintahCurl('sendMessage',$data);
?>