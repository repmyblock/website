<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	// $BigMenu = "represent";
	$Menu = "team";  
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php"; 

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  
	$rmb = new Teams();
	WriteStderr($URIEncryptedString, "URIEncryptedString");	
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	
	if (empty ($URIEncryptedString["ActiveTeam_ID"])) {
		print "<PRE>" . print_r($URIEncryptedString, 1) . "</PRE>";
		print "Problem with TeamID => " . $URIEncryptedString["ActiveTeam_ID"] . "<BR>";
		exit();
	}

	if ( ! empty ($_POST["Year"])) {
		WriteStderr($_POST, "Input \$_POST");

		// Search in the database.
		if ( $_POST["Year"] < 100 ) {
			if ( $_POST["Year"] > 05) { $Year = "19" . $_POST["Year"];
			} else { $Year = "20" . $_POST["Year"]; }
		} else { $Year = $_POST["Year"]; }
		
		// We need to put verification on the first and lastname so they don't pass 
		// bogus data.		
		$DBFirstName = $_POST["FirstName"];
		$DBLastName = $_POST["LastName"];
		$DOB = $Year . "-" . $_POST["Month"] . "-" . $_POST["Day"];
		
		// Before we go and search the Database, we need to check that the DOB info is right.
		
	 	$result = $rmb->SearchVoterDB($DBFirstName, $DBLastName, $DOB, "active");
		WriteStderr($result, "SearchVoterDB(DBFirstName: $DBFirstName, DBLastName: $DBLastName, DOB: $DOB)");
		
		switch(count($result)) {
			case 0:
				//echo "Did not find anything\n";
				$error_msg = "<FONT COLOR=BROWN><B>This person is not in the database.</B></FONT>";
				break;			
			
			case 1:				
				header("Location: /" .CreateEncoded ( array( 
								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
								"Raw_Voter_ID" => $resultPass["Raw_Voter_ID"],
								"FirstName" => $URIEncryptedString["FirstName"],
								"LastName" => $URIEncryptedString["LastName"],
								"VotersIndexes_ID" => $result[0]["VotersIndexes_ID"],
								"UniqNYSVoterID" => $result[0]["Raw_Voter_UniqNYSVoterID"],
								"UserParty" => $result[0]["Raw_Voter_RegParty"],
								"ActiveTeam_ID" => $URIEncryptedString["ActiveTeam_ID"],
							))  . "/lgd/team/voterresult");
				exit();
			
			default:
				if ( ! empty ($result)) {
					foreach($result as $var) {
						if ( ! empty ($var)) {
							$EncryptURL .= "&vi[]=" . $var["VotersIndexes_ID"];
						}	
					}
				}
				
				header("Location: /" . CreateEncoded ( array( 
								"SystemUser_ID" => $resultPass["SystemUser_ID"],
								"Raw_Voter_ID" => $resultPass["Raw_Voter_ID"],
								"FirstName" => $resultPass["SystemUser_FirstName"],
								"LastName" => $resultPass["SystemUser_LastName"],
								"VotersIndexes_ID" => $result[0]["VotersIndexes_ID"],
								"UniqNYSVoterID" => $resultPass["Raw_Voter_UniqNYSVoterID"],
								"UserParty" => $resultPass["Raw_Voter_RegParty"],
								"SystemAdmin" => $resultPass["SystemUser_Priv"],
								"ActiveTeam_ID" => $URIEncryptedString["ActiveTeam_ID"],
								"vi[]" => $var["VotersIndexes_ID"]
							))   . "/lgd/team/voterselect");
				exit();
		}		
	}

	$TopMenus = array ( 
						array("k" => $k, "url" => "team/index", "text" => "Team Members"),
						array("k" => $k, "url" => "team/teampetitions", "text" => "Manage Petitions"),
						array("k" => $k, "url" => "team/teamcandidate", "text" => "Setup Teams")
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
			    <h2 id="public-profile-heading" class="Subhead-heading">Create Petition</h2>
			  </div>
  
			<?php
			 	PlurialMenu($k, $TopMenus);
			?>


			  <div class="clearfix gutter d-flex flex-shrink-0">
		
					<div class="col-16 f40">
	
						<?= $error_msg ?>
						
						<?php /*
						<P>
							<A HREF="/<?= $k ?>/lgd/team/petitionbypass">Bypass Voter Search to create a petition</A>	
						</P>
						*/ ?>
	
					  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
							<div>
								<dl class="form-group col-3 d-inline-block"> 
									<dt><label for="user_profile_name">First Name</label><DT>
									<dd>
										<input class="form-control" type="text" Placeholder="First" name="FirstName"<?php if (!empty ($FirstName)) { echo " VALUE=" . $FirstName; } ?> id="user_profile_name">
									</dd>
								</dl>
			
								<dl class="form-group col-3 d-inline-block"> 
									<dt><label for="user_profile_name">Last Name</label><DT>
									<dd>
										<input class="form-control" type="text" Placeholder="Last" name="LastName"<?php if (!empty ($LastName)) { echo " VALUE=" . $LastName; } ?> id="user_profile_name">
									</dd>
								</dl>
							</DIV>
			
							<DIV>
								<dt><label for="user_profile_email">Date of Birth</label></dt>	
								<dl class="form-group col-1 d-inline-block">
									<dd>
										<input class="form-control" type="text" name="Day" id="" Placeholder="Day"<?= $SizeField ?>>
									</DD>
								</DL>  
							
								<dl class="form-group col-2 d-inline-block f60">      
									<DD>
										<select class="form-select" name="Month" id="">
											<option value="">Select month</option>
											<option value="01">January</option>
											<option value="02">February</option>
											<option value="03">March</option>
											<option value="04">April</option>
											<option value="05">May</option>
											<option value="06">June</option>
											<option value="07">July</option>
											<option value="08">August</option>
											<option value="09">September</option>
											<option value="10">October</option>
											<option value="11">November</option>
											<option value="12">December</option>
										</select>
									</DD>
								</DL>  
			
								<dl class="form-group col-1  d-inline-block">      
									<DD>
										<input class="form-control" type="text" Placeholder="Year" name="Year" id=""<?= $SizeField ?>>
									<dd>
								</dl>
			
								<p><button type="submit" class="submitred">Search Voter Registration</button></p>
			
							</form> 
			
							</div>
				  	</div>
			  	</div>
				</div>
			</div>		
		</div>
	</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
