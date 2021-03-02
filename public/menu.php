<?php
$cetak = $cetak."MENU \n";
$cetak = $cetak."-------- \n";
$cetak = $cetak."/ceknosc - no SC \n";
$cetak = $cetak."/adduser - username \n";
$cetak = $cetak."/help - lihat menu \n";

$data = array(
    'chat_id' => $chatid,
    'text'=> $cetak,
    'parse_mode'=>'Markdown',
    'reply_to_message_id' => $message_id);



    KirimPerintahCurl('sendMessage',$data);


?>