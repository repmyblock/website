<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
	
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";
	$r = new welcome();	
	
	if (! empty($_POST)) {
		//echo "POST: <PRE>" . print_r($_POST) . "</PRE>";
		parse_str(DecryptURL($_POST["String"]), $POSTEncryptedString);
		WriteStderr($POSTEncryptedString, "POSTEncryptedString");
		$r->SaveVolunteer($_POST["emailaddress"], $POSTEncryptedString["U"], $POSTEncryptedString["S"], $POSTEncryptedString["C"]); 
		
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";
		SendWelcomeVolunteerMessage($_POST["emailaddress"], $POSTEncryptedString["Campaign"], $POSTEncryptedString["CampaignEmail"], $POSTEncryptedString["VolunteerEmail"]);
		
		header("Location: /exp/" . CreateEncoded ( array( 	
								"FirstName" => $POSTEncryptedString["FirstName"] ,
								"Email" => $_POST["emailaddress"],
								"Campaign" => $POSTEncryptedString["Campaign"]
					)) . "/usersuccess");
		exit();
		
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	
?>
<DIV class="main">
		
	<DIV class="right f80">Share the knowledge</DIV>

	<P class="f60">
			
			 	<DIV class="panels">		
				<?php
				
					$data = $FrontEndWebsite . "/exp/rmb/inline";
					$options = array("b" => "qr-h");
						
					require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/utils/php-qrcode-1/qrcode.php";
					$generator = new QRCode($data, $options);
					$image = $generator->render_image();
					ob_start(); // buffers future output			
					imagepng($image);				
					$qrcode_b64 = base64_encode(ob_get_contents());
					imagedestroy($image);
					ob_end_clean(); // clears buffered output
					echo "<IMG WIDTH=100% SRC=\"data:image/png;base64," . $qrcode_b64 . "\">";
?>
			
			<BR>
				
				


			<DIV class="right f60">	
			<A HREF="<?= PrintReferer()  ?>">Return to previous menu</A></B>
		</DIV>
		</div>
		
		
		
									
		
	
			</DIV>
		</FORM>
		</DIV>
	</DIV>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>