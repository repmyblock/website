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
	
	// Bug need to fix why the plus is not passing correctly.
	$result = $rmb->ListTextMessage($URIEncryptedString["SMSText_Phone"]); //$URIEncryptedString["SystemUser_ID"]);	
	WriteStderr($result, "ListTextMessage");			
	
	if ( ! empty ($result)) {
		foreach($result as $var) {
			if ( ! empty ($var["Raw_Voter_UniqNYSVoterID"])) {
				$Names = $rmb->FindRawVoter($var["Raw_Voter_UniqNYSVoterID"], $DatedFiles);
				WriteStderr($Names, "Names from RawVoter");	
			}
		}
	}
	
	
	
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
		<div class="col-9 float-left">
			<div class="Subhead"><h2 class="Subhead-heading">Messages</h2></div>
			
			<?php
				PrintVerifMenu($VerifEmail, $VerifVoter);
			 	PlurialMenu($k, $TopMenus);
			?>

			<div class="Box">
			  <div class="Box-header pl-0">
				  <div class="table-list-filters d-flex">
						<div class="table-list-header-toggle states flex-justify-start pl-3">
							SMS with phone number <?= formatPhoneNumber($URIEncryptedString["SMSText_Phone"]) ?><BR>
							<B><?= $Names["Raw_Voter_FirstName"] ?> <?= $Names["Raw_Voter_LastName"] ?></B> - City: <?= $Names["Raw_Voter_ResCity"] ?>
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

							if ( $var["SMSText_direction"] == "inbound" || ($var["SMSText_direction"] == "outbound" && $var["Candidate_ID"] > 0 )) {
				?>

							    
			      <div class="Box-row simple public js-collab-repo">
			        
			  
			      	   
			        <?= ucfirst($var["SMSText_direction"]) ?> - <B><?= PrintDateTime($var["SMSText_DateWriten"]) ?>: </B>
			        
			        
			        
			            
			            <?= $var["SMSText_Text"] ?>
			          
			       
			      </div>

			   
			   
			  <?php }
					}	
			  	} ?>
			  	
			  	 <div class="Box-row simple public js-collab-repo">
			        
			  			
			      	   
							<TEXTAREA COLS=70 NAME="RESPONSE"></TEXTAREA>		<BR>          
							<INPUT TYPE="SUBMIT" VALUE="Send Text">		          
			       
			      </div>
			  	
			  	
			  	
			  	 </div>
			  <?php
				 } ?>

			</div>
		</div>
	</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>