<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_admin.php";

	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new RMBAdmin();	
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$result = $rmb->SearchUsers($URIEncryptedString["UserDetail"]);
	$privcodes = $rmb->ReturnPrivCodes();
	$teammember = $rmb->ReturnTeamMembership($URIEncryptedString["UserDetail"]);
	$teams = $rmb->ListsTeams();
	

	$TheNewK = CreateEncoded ( array( 		
			"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
			"SystemAdmin" => $URIEncryptedString["SystemAdmin"],
			"UserDetail" => $URIEncryptedString["UserDetail"],
			"MenuDescription" => $URIEncryptedString["MenuDescription"],	
	));

	if ( ! empty ($_POST)) {
		
		print "<PRE>" . print_r($_POST, 1) . "</PRE>";
		$TotalPrivs = 0;
		
		if ( ! empty ($_POST["Priviledges"])) {
			foreach ($_POST["Priviledges"] as $var) {
				if ($var == PERM_SUPERUSER) { $TotalPrivs = $var; }
				else { $TotalPrivs += $var; }
			}
			print "Total Privs: $TotalPrivs for " . $URIEncryptedString["UserDetail"];
			$rmb->UpdateSystemSetPriv($URIEncryptedString["UserDetail"], $TotalPrivs);
		} else if ( $result["SystemUser_Priv"] > 0) {
			$rmb->UpdateSystemSetPriv($URIEncryptedString["UserDetail"], 0);
		}
			
		header("Location: /" . $TheNewK . "/admin/userdetail");			
		exit();
	}
	
	
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
			
				<?php	if ( ! empty ($result)) { ?>

				<div class="list-group-item f60">
					First Name <INPUT TYPE="TEXT" VALUE="<?= $result["SystemUser_FirstName"] ?>">
					Last Name <INPUT TYPE="TEXT" VALUE="<?= $result["SystemUser_LastName"] ?>">
				</div>

				<div class="list-group-item f60">
						SystemUser_ID: <FONT COLOR=BROWN><?= $result["SystemUser_ID"] ?></FONT>
						SystemUserProfile_ID: <FONT COLOR=BROWN><?= $result["SystemUserProfile_ID"] ?></FONT>
					<BR>
						Last Login <FONT COLOR=BROWN><?= PrintDateTime($result["SystemUser_lastlogintime"]); ?></FONT>
						Create Time <FONT COLOR=BROWN><?= PrintDateTime($result["SystemUser_createtime"]); ?></FONT>
					<BR>
						Voters State ID <FONT COLOR=BROWN><?= $result["Voters_UniqStateVoterID"] ?></FONT>
						RMB Voters ID <FONT COLOR=BROWN><?= $result["Voters_ID"] ?></FONT>
					<BR>
						EDAD <FONT COLOR=BROWN><?= $result["SystemUser_EDAD"] ?></FONT>
						Num Voters <FONT COLOR=BROWN><?= $result["SystemUser_NumVoters"] ?></FONT>
						Party <FONT COLOR=BROWN><?= $result["SystemUser_Party"] ?></FONT>
				</div>

				<div class="list-group-item f60">Priv 
					<FONT COLOR=BROWN><?= $result["SystemUser_Priv"] ?></FONT>
					<UL>
					<?php
						if ( ! empty ($privcodes)) { 	
							foreach ($privcodes as $privar) {
								if (! empty ($privar)) {
					?>					
						
					<INPUT TYPE="checkbox" name="Priviledges[]" value="<?= $privar["AdminCode_Code"] ?>"<?php if (MatchPriviledges($result["SystemUser_Priv"], $privar["AdminCode_Code"]) == 1) { echo " CHECKED"; } ?>>&nbsp;<?= $privar["AdminCode_ProgName"] ?><BR>											
					<?php			
								}
							}
						}					
					?>
					<BR>
					<INPUT TYPE="checkbox" name="Priviledges[]" value="<?= PERM_SUPERUSER ?>"<?php if ($result["SystemUser_Priv"] == PERM_SUPERUSER) { echo " CHECKED"; } ?>>&nbsp;PERM_SUPERUSER

					
				</UL>
					</div>
					
					<div class="list-group-item f60">Team Membership
					<PRE><?= print_r($teammember,1 ) ?></PRE>
					<UL>
					<?php
						if ( ! empty ($teams )) { 	
							foreach ($teams  as $teaminfo) {
								if (! empty ($teaminfo)) {
					?>					
					<INPUT TYPE="checkbox" name="TeamMembership[<?= $teaminfo["Team_ID"]  ?>]" value="<?= $teaminfo["Team_ID"] ?>"<?php if ($teaminfo["Team_ID"] == 1) { echo " CHECKED"; } ?>>&nbsp;<?= $teaminfo["Team_Name"] ?>										
					Active: <INPUT TYPE="checkbox" name="TeamMembershipActive[<?= $teaminfo["Team_ID"]  ?>]" value="<?= $teaminfo["Team_ID"] ?>"<?php if ($teaminfo["Team_ID"] == 1) { echo " CHECKED"; } ?>>
					<BR>

					<?php			
								}
							}
						}					
					?>
					<BR>

					
				</UL>
					</div>
					
				
				<div class="list-group-item f60">
					Username <INPUT TYPE="TEXT" VALUE="<?= $result["SystemUser_username"] ?>">
					Email <INPUT TYPE="TEXT" VALUE="<?= $result["SystemUser_email"] ?>">
				</div>
				<div class="list-group-item f60">Email Verified 
					<SELECT NAME="emailverified">
						<OPTION VALUE="">&nbsp;</OPTION>
						<OPTION VALUE="no"<?php if ($result["SystemUser_emailverified"] == "no") { echo " SELECTED"; } ?>>No</OPTION>
						<OPTION VALUE="link"<?php if ($result["SystemUser_emailverified"] == "link") { echo " SELECTED"; } ?>>Link</OPTION>
						<OPTION VALUE="reply"<?php if ($result["SystemUser_emailverified"] == "reply") { echo " SELECTED"; } ?>>Reply</OPTION>
						<OPTION VALUE="both"<?php if ($result["SystemUser_emailverified"] == "both") { echo " SELECTED"; } ?>>Both</OPTION>
					</SELECT>
				</DIV>
				
				<div class="list-group-item f60">password <INPUT TYPE="TEXT" VALUE=""></div>
				
				
				<div class="list-group-item f60">
					Login method
					<SELECT NAME="ComplexMenu ">
						<OPTION VALUE="">&nbsp;</OPTION>
						<OPTION VALUE="yes"<?php if ($result["SystemUser_loginmethod"] == "password") { echo " SELECTED"; } ?>>Password</OPTION>
						<OPTION VALUE="no"<?php if ($result["SystemUser_loginmethod"] == "emaillink") { echo " SELECTED"; } ?>>Email Link</OPTION>
					</SELECT>
					Complex Menu 
					<SELECT NAME="ComplexMenu ">
						<OPTION VALUE="">&nbsp;</OPTION>
						<OPTION VALUE="yes"<?php if ($result["SystemUser_ComplexMenu"] == "yes") { echo " SELECTED"; } ?>>Yes</OPTION>
						<OPTION VALUE="no"<?php if ($result["SystemUser_ComplexMenu"] == "no") { echo " SELECTED"; } ?>>No</OPTION>
					</SELECT>
				</DIV>
				<div class="list-group-item f60">Email link id <INPUT TYPE="TEXT" VALUE="<?= $result["SystemUser_emaillinkid"] ?>"></div>
				<div class="list-group-item f60">
					Mobile phone <INPUT TYPE="TEXT" VALUE="<?= FormatPhoneNumber($result["SystemUser_mobilephone"]) ?>">
					Mobile verified 						
					<SELECT NAME="MobileVerified">
						<OPTION VALUE="">&nbsp;</OPTION>
						<OPTION VALUE="yes"<?php if ($result["SystemUser_mobileverified"] == "yes") { echo " SELECTED"; } ?>>Yes</OPTION>
						<OPTION VALUE="no"<?php if ($result["SystemUser_mobileverified"] == "no") { echo " SELECTED"; } ?>>No</OPTION>
					</SELECT>
				</div>
				<div class="list-group-item f60">
					Facebook Username <INPUT TYPE="TEXT" VALUE="<?= $result["SystemUser_facebookusername"] ?>">
					Facebook Verified 
						<SELECT NAME="FacebookVerified">
							<OPTION VALUE="">&nbsp;</OPTION>
							<OPTION VALUE="yes"<?php if ($result["SystemUser_facebookverified"] == "yes") { echo " SELECTED"; } ?>>Yes</OPTION>
							<OPTION VALUE="no"<?php if ($result["SystemUser_facebookverified"] == "no") { echo " SELECTED"; } ?>>No</OPTION>
						</SELECT>
				</div>
				<div class="list-group-item f60">
					Google Username <INPUT TYPE="TEXT" VALUE="<?= $result["SystemUser_googleusername"] ?>">
					Google verified 
						<SELECT NAME="GoogleVerified">
							<OPTION VALUE="">&nbsp;</OPTION>
							<OPTION VALUE="yes"<?php if ($result["SystemUser_googleverified"] == "yes") { echo " SELECTED"; } ?>>Yes</OPTION>
							<OPTION VALUE="no"<?php if ($result["SystemUser_googleverified"] == "no") { echo " SELECTED"; } ?>>No</OPTION>
						</SELECT>
				</div>
				<div class="list-group-item f60">Googlemap API ID <INPUT TYPE="TEXT" VALUE="<?= $var["SystemUser_googleapimapid"] ?>"></div>
				<div class="list-group-item f60"><button type="submit" class="btn btn-primary mobilemenu">Submit</BUTTON></DIV>
	<?php	} else { ?>
			<div class="list-group-item f60">
				No user found.
			</div>
	<?php } ?>
	
	
			</DIV>
					</form> 
			
			</DIV>
	
	<BR>
	
	
				
	<B><A HREF="/<?= $TheNewK ?>/admin/userlookup">Look for a new voter</A></B>
	
	
			</DIV>
		</FORM>
		</DIV>
	</DIV>
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
