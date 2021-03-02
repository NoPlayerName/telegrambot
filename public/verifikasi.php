<?php
//$from_username="MRuhiyat";
$basis = file_get_contents('user.txt');
if(empty($from_username))
{
	$lolos=0;
	$alasan="username telegram anda kosong";
	$isi="*Warning* \xE2\x9D\x97 \n\n".$from_first.", anda tidak berhak mengakses bot ini karena ".$alasan.".\nSilahkan hubungi admin untuk verifikasi user anda.";
	$isi=$isi."\n\n*Terimakasih.*\n";
	$data = array(
	'chat_id' => $chatid,
	'text'=> $isi,
	'parse_mode'=>'Markdown',
	'reply_to_message_id' => $message_id
	);	
//	echo $isi;
KirimPerintahCurl('sendMessage',$data);
}
else
{	
if(stripos($basis,$from_username."\n")!==false)
{
	//do things here
	$lolos=1;
}
else
{
	$lolos=0;
	$alasan="username anda tidak/belum terdaftar";
	$isi="*Warning* \xE2\x9D\x97 \n\n".$from_first.", anda tidak berhak mengakses bot ini karena ".$alasan.".\nSilahkan hubungi admin untuk verifikasi user anda.";
	$isi=$isi."\n\n*Terimakasih.*\n";
	$data = array(
	'chat_id' => $chatid,
	'text'=> $isi,
	'parse_mode'=>'Markdown',
	'reply_to_message_id' => $message_id
	);	
//	echo $isi;
KirimPerintahCurl('sendMessage',$data);
}	
}
//echo $basis;
?>