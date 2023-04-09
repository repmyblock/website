<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_trac.php";  

echo "Pulling Screenshot je suis la.";

$URLService = "https://upload.repmyblock.org/getshot.php";
$PostString = array(
											"height" => 1000,
											"width" => 200,
											"page" => "/request"
										);
  							
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $URLService);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);	
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $PostString);
curl_exec($ch);
$info = curl_getinfo($ch);
	
echo "<PRE>";
print_r($info);
	
?>
