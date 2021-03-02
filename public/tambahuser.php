<?php
$num=$param;
if(stripos($from_username,"mruhiyat")!==false)
{
$filename = 'user.txt';
$person = str_replace("@","",$num);
$status=1;

$basis = file_get_contents('user.txt');
if(empty($person))
{
	$msg="\nParameter username anda belum diisi.\n";
	$status=0;
}
else{
if(stripos($basis,$person)!==false)
{
	$msg="\nUsername *".$person."* sudah ada didalam database.\n";
	$status=0;
}
}
if($status==1)
{
// Let's make sure the file exists and is writable first.
if (is_writable($filename)) {
    // In our example we're opening $filename in append mode.
    // The file pointer is at the bottom of the file hence
    // that's where $somecontent will go when we fwrite() it.
    if (!$handle = fopen($filename, 'a')) {
         $msg="Cannot open file ($filename)";
         exit;
    }
    // Write $somecontent to our opened file.
    if (fwrite($handle, $person."\n") === FALSE) {
        $msg="Cannot write to file ($filename)";
        exit;
    }
    $msg="\nUser *".$person."* telah ditambahkan ke dalam database.\n";	
	if(copy("user.txt","user_backup.txt"))
	{$msg=$msg."Database telah dibackup.";}
	else
	{$msg=$msg."Database tidak dapat dibackup.";}
    fclose($handle);
} else {
    $msg="The file $filename is not writable";
}
}
}
else
{  $msg="\n".$from_first.", anda tidak berhak untuk menambah user aplikasi.\n";}
$cetak=$msg;

$data = array(
    'chat_id' => $chatid,
    'text'=> $cetak,
    'parse_mode'=>'Markdown',
    'reply_to_message_id' => $message_id);



    KirimPerintahCurl('sendMessage',$data);
?>
