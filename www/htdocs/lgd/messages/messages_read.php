<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "messages";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_sms.php";  
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	

	$rmb = new sms();
	
	$NumberOfMessages = 1;
	$TopMenus = array ( 
								array("k" => $k, "url" => "messages", "text" => "Internal Messaging"),
								array("k" => $k, "url" => "messages_sms", "text" => "Text Messages"),
								array("k" => $k, "url" => "messages_setup", "text" => "Setup Messaging")
							);			
	WriteStderr($TopMenus, "Top Menu");													
	WriteStderr($URIEncryptedString["SystemUser_ID"], "URIEncryptedString[\"SystemUser_ID\"]");		
	
	$result = $rmb->ListInboundText(); //$URIEncryptedString["SystemUser_ID"]);	
	WriteStderr($result, "ListInboundText");			
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
		<div class="col-9 float-left">
			<div class="Subhead"><h2 class="Subhead-heading">Messages</h2></div>
			
			<?php
			 	PlurialMenu($k, $TopMenus);
			?>

			<div class="Box">
			  <div class="Box-header pl-0">
				  <div class="table-list-filters d-flex">
						<div class="table-list-header-toggle states flex-justify-start pl-3">
							SMS Campaigns #<?= $URIEncryptedString["SMSCampaign_ID"] ?><BR>
							<?= $URIEncryptedString["District"] ?>: <B><?= $URIEncryptedString["Candidate_DispName"] ?></B> - <?= $URIEncryptedString["Candidate_FullPartyName"] ?> 				
						</div>
					</div>
				</div>

				<?php if (count($result) == 0) { ?>
					<div class="Box-body text-center py-6 js-collaborated-repos-empty" >
						You don't have any campaigns.<BR>
						<A HREF="">Create a SMS campaign</A>
					</div>
				<?php } else { ?>
					<div class="js-collaborated-repos">
				<?php 	
					foreach ($result as $var) {
						if (! empty ($var)) {

				?>

							    
			      <div class="Box-row simple public js-collab-repo" data-repo-id="43183710" data-owner-id="5959961">
			        
			        
			      	   
			        <?= PrintDateTime($var["SMSText_DateWriten"]) ?> 
			        <svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
			        <a class="mr-1" href="/lgd/<?= CreateEncoded ( array( 
																					"SMSCampaign_ID" => $var["SMSText_ID"],
																					"SMSText_Phone" => urlencode($var["SMSText_PhoneTo"]),
																					"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																			    "FirstName" => $URIEncryptedString["FirstName"],
																			    "LastName" => $URIEncryptedString["LastName"],
																			    "UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
																			   	"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"]
																				)) ?>/messages_thread"><?= formatPhoneNumber($var["SMSText_PhoneTo"]) ?></a>
			        <span class="text-small">
			          <BR>
			            
			            <?= $var["SMSText_Text"] ?>
			          
			        </span>
			      </div>

			   
			   
			  <?php }
			  	} ?>
			  	 </div>
			  <?php
				 } ?>

			</div>
		</div>
	</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
