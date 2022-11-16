<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	// $BigMenu = "represent";
	$Menu = "team";  
	
 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();
	WriteStderr($URIEncryptedString, "URIEncryptedString");	
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$Party = PrintParty($UserParty);


	if ( ! empty ($_POST)) {
		WriteStderr($_POST, "Creating a new team \$_POST");

		print "I need to verify the team<BR>";
		

		exit();
	}


	$TopMenus = array ( 
						array("k" => $k, "url" => "team/team", "text" => "Manage Pledges"),
						array("k" => $k, "url" => "team/teampetitions", "text" => "Manage Petitions"),
						array("k" => $k, "url" => "team/teamcandidate", "text" => "Manage Candidates")
					);			
	WriteStderr($TopMenus, "Top Menu");					
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) {	 $Cols = "col-12"; $SizeField = " SIZE=10"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Create teams</h2>
			  </div>
  
			<?php
			 	PlurialMenu($k, $TopMenus);
			?>


			  <div class="clearfix gutter d-flex flex-shrink-0">
		
					<div class="col-16">
	
						<?= $error_msg ?>
						
					  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
							<div>
								<DL class="form-group col-12 d-inline-block f40">       
								  <DT><LABEL>Team Name</LABEL></DT>
								  <DD>
								    <INPUT class="form-control" type="text" placeholder="Team name" name="TeamName" value="<?= $rmbcandidate["TeamName"]; ?>">
								  </DD>
								</DL>
								  
								<DL class="form-group col-3 d-inline-block f40"> 
								  <DT><LABEL>Team Access Code</LABEL><DT>
								  <DD>
								    <INPUT class="form-control" type="text" placeholder="Team Access Code" name="TeamAccessCode" value="<?= $rmbcandidate["TeamAccessCode"]; ?>">
									</DD>
								  <DD>
								    <INPUT TYPE="SUBMIT" VALUE="Check Access Name">
								  </DD>
								</DL>
								
								<DL class="form-group col-12 d-inline-block f40"> 
								  <DT><LABEL>Admin Person</LABEL> must already by part of your team<DT>
								  <DD>
								    <INPUT class="form-control" type="text" placeholder="Username or Email" name="LastName" value="<?= $rmbcandidate["CandidateProfile_LastName"]; ?>">
								    <button type="submit" class="submitred">Check Username</button>
								  </DD>
								</DL>
								

							</DIV>
			
						
			
								<p><button type="submit" class="submitred">Search Voter Registration</button></p>
			
							</form> 
			
							</div>
				  	</div>
			  	</div>
				</div>
			</div>		
		</div>
	</div>

<script src="/js/ajax/checkusernameforteam.js"></script>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
