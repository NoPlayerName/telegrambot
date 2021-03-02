<?php
    set_time_limit(60);
    //masukan nomor token Anda di sini
    define('TOKEN','1198713433:AAF6VhTA-i6bWDTgLPg_zftCHJDWAsr1HjI');

    //Fungsi untuk Penyederhanaan kirim perintah dari URI API Telegram
    function BotKirim($perintah){
        return 'https://api.telegram.org/bot'.TOKEN.'/'.$perintah;
    }

    /* Fungsi untuk mengirim "perintah" ke Telegram
     * Perintah tersebut bisa berupa
     *  -SendMessage = Untuk mengirim atau membalas pesan
     *  -SendSticker = Untuk mengirim pesan
     *  -Dan sebagainya, Anda bisa memm
     *
     * Adapun dua fungsi di sini yakni pertama menggunakan
     * stream dan yang kedua menggunkan curl
     *
     * */
    function KirimPerintahStream($perintah,$data){
         $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents(BotKirim($perintah), false, $context);
        return $result;
    }

    function KirimPerintahCurl($perintah,$data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,BotKirim($perintah));
        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $kembali = curl_exec ($ch);
        curl_close ($ch);

        return $kembali;
    }

    /*  Perintah untuk mendapatkan Update dari Api Telegram.
     *  Fungsi ini menjadi penting karena kita menggunakan metode "Long-Polling".
     *  Jika Anda menggunakan webhooks, fungsi ini tidaklah diperlukan lagi.
     */

    function DapatkanUpdate($offset)
    {
        //kirim ke Bot
        $url = BotKirim("getUpdates")."?offset=".$offset;
        //dapatkan hasilnya berupa JSON
        $kirim = file_get_contents($url);
        //kemudian decode JSON tersebut
        $hasil = json_decode($kirim, true);
        if ($hasil["ok"]==1)
            {
                /* Jika hasil["ok"] bernilai satu maka berikan isi JSONnya.
                 * Untuk dipergunakan mengirim perintah balik ke Telegram
                 */
                return $hasil["result"];
            }
        else
            {   /* Jika tidak maka kosongkan hasilnya.
                 * Hasil harus berupa Array karena kita menggunakan JSON.
                 */
                return array();
            }
    }

   

    function JalankanBot()
        {
            $update_id  = 0; //mula-mula tepatkan nilai offset pada nol

            //cek file apakah terdapat file "last_update_id"
            if (file_exists("last_update_id")) {
                //jika ada, maka baca offset tersebut dari file "last_update_id"
                $update_id = (int)file_get_contents("last_update_id");
            }
            //baca JSON dari bot, cek dan dapatkan pembaharuan JSON nya
            $updates = DapatkanUpdate($update_id);

            include 'kondisi.php';
            foreach ($updates as $message)
            {
                $update_id = $message["update_id"];;
                $message_data = $message["message"];
                $text = $message_data["text"];
                $isi = @$message_data["text"];
                $isi = @str_replace("  "," ",$isi);
                $from_id = $message_data["from"]["id"];
                $from_first = $message_data["from"]["first_name"];
                $from_last = @$message_data["from"]["last_name"];
                $from_username = $message_data["from"]["username"]; 
                $chatid = $message_data["chat"]["id"];
                $chat_name = @$message_data["chat"]["title"];  
                $chat_type = $message_data["chat"]["type"];      
                $message_id = $message_data["message_id"];
                $nama = $from_first;
                $lengkap = $from_first." ".$from_last;
                $dates = $message_data["date"];
                $date = date("Y-m-d, H:m:s", $dates);			
                $arr_kata1=explode(" ",$isi);
                $komando=$arr_kata1[0];
                $param=@$arr_kata1[1];
                $param2=@$arr_kata1[2];	
                include $pasang;
                
            }
            //tulis dan tandai updatenya yang nanti digunakan untuk nilai offset
            file_put_contents("last_update_id", $update_id + 1);
        }

    while(true){
      JalankanBot();
            $jeda = 1; // jeda 1 detik
            
            if(php_sapi_name()==="cli") {
                sleep($jeda); //beri jeda 1 detik
            } else {
                echo '<meta http-equiv="refresh" content="'.$jeda.'">';
                echo 'Now Bot is running .... ';
                break;
                }
    }
