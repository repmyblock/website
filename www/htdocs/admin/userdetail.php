<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";

	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();	
	$var = $rmb->SearchUsers($URIEncryptedString["UserDetail"]);
	$privcodes = $rmb->ReturnPrivCodes();
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Rep My Block Users</h2>
				</div>

				<form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
				<div class="list-group-item filtered f60 hundred">
					<span><B>User Detail</B></span>  	          			
				</div>
					
			 	<DIV class="panels">							    
				<div class="clearfix gutter d-flex flex-shrink-0">
									
				<div class="col-12">
				  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
			
			
						
					<?php	
					
					
					
							if ( ! empty ($var)) { 
								
				?>
				
				<div class="list-group-item f60">SystemUser_ID: <FONT COLOR=BROWN><?= $var["SystemUser_ID"] ?></FONT></div>
				<div class="list-group-item f60">SystemUserProfile_ID: <FONT COLOR=BROWN><?= $var["SystemUserProfile_ID"] ?></FONT></div>
				<div class="list-group-item f60">SystemUser_createtime <FONT COLOR=BROWN><?= $var["SystemUser_createtime"] ?></div>
				<div class="list-group-item f60">SystemUser_lastlogintime <FONT COLOR=BROWN><?= $var["SystemUser_lastlogintime"] ?></div>
			
				<div class="list-group-item f60">First Name <INPUT TYPE="TEXT" VALUE="<?= $var["SystemUser_FirstName"] ?>"></div>
				<div class="list-group-item f60">Last Name <INPUT TYPE="TEXT" VALUE="<?= $var["SystemUser_LastName"] ?>"></div>

				<div class="list-group-item f60">Priv 
					<FONT COLOR=BROWN><?= $var["SystemUser_Priv"] ?></FONT>
					<UL>
					<?php
						if ( ! empty ($privcodes)) { 	
							foreach ($privcodes as $privar) {
								if (! empty ($privar)) {
					?>					
						
					<INPUT TYPE="checkbox" name="Priviledges[]" value="<?= $privar["AdminCode_Code"] ?>"<?php if (MatchPriviledges($var["SystemUser_Priv"], $privar["AdminCode_Code"]) == 1) { echo " CHECKED"; } ?>>
						&nbsp;<?= $privar["AdminCode_ProgName"] ?><BR>											
					<?php			
								}
							}
						}					
					?>
				</UL>
					</div>
				
				<div class="list-group-item f60">username <INPUT TYPE="TEXT" VALUE="<?= $var["SystemUser_username"] ?>"></div>
				<div class="list-group-item f60">email <INPUT TYPE="TEXT" VALUE="<?= $var["SystemUser_email"] ?>"></div>
				<div class="list-group-item f60">emailverified <INPUT TYPE="TEXT" VALUE="<?= $var["SystemUser_emailverified"] ?>"></div>
				<div class="list-group-item f60">password <INPUT TYPE="TEXT" VALUE=""></div>
				
				<div class="list-group-item f60">Voters_ID <INPUT TYPE="TEXT" VALUE="<?= $var["Voters_ID"] ?>"></div>
				<div class="list-group-item f60">Voters_UniqStateVoterID <INPUT TYPE="TEXT" VALUE="<?= $var["Voters_UniqStateVoterID"] ?>"></div>
				<div class="list-group-item f60">EDAD <INPUT TYPE="TEXT" VALUE="<?= $var["SystemUser_EDAD"] ?>"></div>
				<div class="list-group-item f60">NumVoters <INPUT TYPE="TEXT" VALUE="<?= $var["SystemUser_NumVoters"] ?>"></div>
				<div class="list-group-item f60">Party <INPUT TYPE="TEXT" VALUE="<?= $var["SystemUser_Party"] ?>"></div>
				<div class="list-group-item f60">ComplexMenu <INPUT TYPE="TEXT" VALUE="<?= $var["SystemUser_ComplexMenu"] ?>"></div>
				
			
				<div class="list-group-item f60">login method <INPUT TYPE="TEXT" VALUE="<?= $var["SystemUser_loginmethod"] ?>"></div>
				<div class="list-group-item f60">email link id <INPUT TYPE="TEXT" VALUE="<?= $var["SystemUser_emaillinkid"] ?>"></div>
				<div class="list-group-item f60">mobile phone <INPUT TYPE="TEXT" VALUE="<?= FormatPhoneNumber($var["SystemUser_mobilephone"]) ?>"></div>
				<div class="list-group-item f60">mobile verified <INPUT TYPE="TEXT" VALUE="<?= $var["SystemUser_mobileverified"] ?>"></div>
				<div class="list-group-item f60">facebook username <INPUT TYPE="TEXT" VALUE="<?= $var["SystemUser_facebookusername"] ?>"></div>
				<div class="list-group-item f60">facebook verified <INPUT TYPE="TEXT" VALUE="<?= $var["SystemUser_facebookverified"] ?>"></div>
				<div class="list-group-item f60">google username <INPUT TYPE="TEXT" VALUE="<?= $var["SystemUser_googleusername"] ?>"></div>
				<div class="list-group-item f60">google verified <INPUT TYPE="TEXT" VALUE="<?= $var["SystemUser_googleverified"] ?>"></div>
				<div class="list-group-item f60">Google MAP ID api <INPUT TYPE="TEXT" VALUE="<?= $var["SystemUser_googleapimapid"] ?>"></div>
							
							
				
		
		
																	
			<?php

		
		echo "</TR></TABLE>";
		
	} else { ?>
			<div class="list-group-item f60">
				No user found.
			</div>
	<?php } ?>
	
	
			</DIV>
					</form> 
			
			</DIV>
	
	<BR>
	
	
	<?php 
			
					$TheNewK = CreateEncoded ( array( 		
					"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
					"&SystemAdmin" => $URIEncryptedString["SystemAdmin"],
					"&FirstName" => $URIEncryptedString["FirstName"],
					"&LastName" => $URIEncryptedString["LastName"],
					"&UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
					"&UserParty" => $URIEncryptedString["UserParty"],
					"&MenuDescription" => $URIEncryptedString["MenuDescription"]
					));
	?>
				
	<B><A HREF="/<?= $TheNewK ?>/lgd/team/admin">Look for a new voter</A></B>
	
	
			</DIV>
		</FORM>
		</DIV>
	</DIV>
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
