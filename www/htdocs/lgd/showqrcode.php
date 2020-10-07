<?php


	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();

	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";

?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Show QR Code</h2>
				</div>

			
			 	<DIV class="panels">		
				<?php
				
					$data = $FrontEndWebsite . "/exp/" . urlencode(CreateEncoded (array( 	
								"U" => $URIEncryptedString["Raw_Voter_UniqNYSVoterID"],
								"S" => $URIEncryptedString["SystemUser_ID"],
								"C" => "288"
						))) . "/user";
					$options = array("s" => "qr-h");
						
					require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/utils/php-qrcode-1/qrcode.php";
					$generator = new QRCode($data, $options);
					$image = $generator->render_image();
					ob_start(); // buffers future output			
					imagepng($image);				
					$qrcode_b64 = base64_encode(ob_get_contents());
					imagedestroy($image);
					ob_end_clean(); // clears buffered output
					echo "<IMG SRC=\"data:image/png;base64," . $qrcode_b64 . "\">";
?>
			
			<BR>
				
				

				
			<A HREF="/lgd/<?= $k ?>/voterquery">Look for a new voter</A></B>
			
		</div>
		
		
		
									
		
	
			</DIV>
		</FORM>
		</DIV>
	</DIV>
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
