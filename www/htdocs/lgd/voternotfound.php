<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "voters";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";

	

	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Voter Lookup Result</h2>
				</div>

				<form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
				
			 	<DIV class="panels">		
						
						We did not find the voter with  .... Are you sure of the info.<BR>
						Is the person at the right address and have a DMV license?
						
						<a class="mr-1" href="/lgd/<?= 
							CreateEncoded (array( 	
								"U" => $URIEncryptedString["Raw_Voter_UniqNYSVoterID"],
								"S" => $URIEncryptedString["SystemUser_ID"],
								"C" => "288",
								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
    						"SystemAdmin" => $URIEncryptedString["SystemAdmin"]
						))
						?>/showqrcode">Show QR Code </a> 
						
	
			</DIV>
		</FORM>
		</DIV>
	</DIV>
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
