<?php
include 'koneksi.php';

if (empty($param)) {
    $cetak = "mohon isi juga parameternya";
}else{

    $query = mysqli_query($con, "SELECT * FROM som WHERE nosc = '$param' ");

    
       $cetak = @$cetak."SOM (Service Order Manager \n";
       $cetak = $cetak."-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-\n";
       while ($d = mysqli_fetch_array($query)) {
       $cetak = $cetak."ORDERID   : ".$d['nosom']."\n";
       
       $cetak = $cetak."TASK        : ".$d['tasksom']."\n";
       
       $cetak = $cetak."STATE       : ".$d['statesom']."\n";
       
       $cetak = $cetak."WFM         : ".$d['wfm']."\n";

       
   }
   $cetak = $cetak."============================\n";

$query = mysqli_query($con, "SELECT * FROM tom WHERE nosc = '$param' ");

   
    
       
         
       $replace2 = @$replace."".$d['tasktom']."";
       $replace2 = str_replace("_"," ",$replace2);

       $cetak = @$cetak." TOM (Tehnical Order Manager)\n";
       $cetak = $cetak."-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-\n";
       while ($d = mysqli_fetch_array($query)) {
       $cetak = $cetak."ORDERID   : ".$d['notom']."\n";
      
       $cetak = $cetak."TASK        : ".$replace2."\n";
       
       $cetak = $cetak."STATE       : ".$d['statetom']."\n";
       
       $cetak = $cetak."WFM         : ".$d['wfm']."\n";
       $cetak = $cetak."---------------------------\n";
   
   }

  
}
$data = array(
    'chat_id' => $chatid,
    'text'=> $cetak,
    'parse_mode'=>'Markdown',
    'reply_to_message_id' => $message_id);



    KirimPerintahCurl('sendMessage',$data);


?>