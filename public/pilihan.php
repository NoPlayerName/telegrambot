<?php
//cek username terdaftar atau tidak 
include "verifikasi.php";
$awalan = "yes";
if ($lolos == 1) {


	//jika terdapat text dari Pengirim

	if (isset($message_data["text"])) {
		$chatid = $message_data["chat"]["id"];
		$message_id = $message_data["message_id"];
		$text = $message_data["text"];

		if (stripos($komando, '/ceknosc') !== false) {
			if ($awalan == "yes") {
				include "incl_salamawal.php";
			}

			include 'tampildata.php';
		} elseif (stripos($komando, '/adduser') !== false) {
			if ($awalan == "yes") {
				include "incl_salamawal.php";
			}

			include 'tambahuser.php';
		} elseif (stripos($komando, '/start') !== false or stripos($komando, '/help') !== false) {
			if ($awalan == "yes") {
				include "incl_salamawal.php";
			}

			include 'menu.php';
		} else {

			$cetak = "maaf perintah yang kamu masukkan salah atau tidak terdaftar";
			$data = array(
				'chat_id' => $chatid,
				'text' => $cetak,
				'parse_mode' => 'Markdown',
				'reply_to_message_id' => $message_id
			);



			KirimPerintahCurl('sendMessage', $data);
		}
	}
}
