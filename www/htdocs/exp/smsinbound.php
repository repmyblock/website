<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_VoteTheo.php";
$r = new sms();

$original = file_get_contents("php://input");
$json = json_decode($original, true);
$dir = $json["data"]["payload"]["direction"];
$message = $json["data"]["payload"]["text"];

if ( $dir == "outbound") {
        $to = $json["data"]["payload"]["from"];
        $from = $json["data"]["payload"]["to"]["0"]["phone_number"];

} else {
        $from = $json["data"]["payload"]["from"]["phone_number"];
        $to = $json["data"]["payload"]["to"]["0"]["phone_number"];
}

if($message){

 $fp = fopen('/tmp/SMSlog.txt', 'a');//opens file in append mode
 fwrite($fp, "From: ".$from.PHP_EOL);
 fwrite($fp, "Text: ".$message.PHP_EOL);
 fwrite($fp, PHP_EOL);
 fwrite($fp, print_r($json,1));
 fclose($fp);
}

$Voter = $r->SaveSMSReturn($message, $to, $from, $dir, $original);

?>
<html>
  <head>
    <title>Text Message Receiver</title>
  </head>
  <body>
    <h1>Text Message Receiver</h1>
  </body>
</html>
