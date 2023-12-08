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
			if ( $_POST["Year"] > 07) { $YearField = "19" .  trim(intval($_POST["Year"]));
			} else { $YearField = "20" . trim(intval($_POST["Year"])); }
		} else { $YearField = trim(intval($_POST["Year"])); }
		
		// We need to put verification on the first and lastname so they don't pass 
		// bogus data.		
		$DBFirstName = trim($_POST["FirstName"]);
		$DBLastName = trim($_POST["LastName"]);
	
		// Before we go and search the Database, we need to check that the DOB info is right.
		$DayField = trim(intval($_POST["Day"]));
		$MonthField = $_POST["Month"];

		if ( ! checkdate($MonthField, $DayField, $YearField) ) {
			header("Location: /" . CreateEncoded ( array( 
									"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
									"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
									"ActiveTeam_ID" => $URIEncryptedString["ActiveTeam_ID"],
									"ActiveTeam" => $URIEncryptedString["ActiveTeam"],
									"QueryFirstName" => $DBFirstName,
									"QueryLastName" => $DBLastName,
									"QueryMonth" => $MonthField,
									"QueryDay" => $DayField,
									"QueryYear" => $YearField,
										"ErrorMsg" => "The date of birth is incorect.",
								))   . "/lgd/team/target");
			exit();
		
		} else {
			$DOB = $YearField . "-" . $MonthField . "-" . $DayField;
	 		$result = $rmb->SearchVoterDB($DBFirstName, $DBLastName, $DOB, "active");
			WriteStderr($result, "SearchVoterDB(DBFirstName: $DBFirstName, DBLastName: $DBLastName, DOB: $DOB)");
			
			switch(count($result)) {
				case 0:
					//echo "Did not find anything\n";
					header("Location: /" . CreateEncoded ( array( 
									"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
									"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
									"ActiveTeam_ID" => $URIEncryptedString["ActiveTeam_ID"],
									"ActiveTeam" => $URIEncryptedString["ActiveTeam"],
									"QueryFirstName" => $DBFirstName,
									"QueryLastName" => $DBLastName,
									"QueryMonth" => $MonthField,
									"QueryDay" => $DayField,
									"QueryYear" => $YearField,
									"ErrorMsg" => "This person is not in the database.",
					))   . "/lgd/team/target");
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
									"ActiveTeam" => $URIEncryptedString["ActiveTeam"],
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
									"SystemUser_Priv" => $resultPass["SystemUser_Priv"],
									"ActiveTeam_ID" => $URIEncryptedString["ActiveTeam_ID"],
									"ActiveTeam" => $URIEncryptedString["ActiveTeam"],
									"vi[]" => $var["VotersIndexes_ID"]
								))   . "/lgd/team/voterselect");
					exit();
			}		
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
	
					<?php if ( ! empty ($URIEncryptedString["ErrorMsg"])) {
						echo "<FONT COLOR=BROWN><B>" . $URIEncryptedString["ErrorMsg"] . "</B></FONT>\n";
					} ?>
		
						
						
						
						<P>This is for the lawyers:
							<A HREF="/<?= $k ?>/lgd/team/petitionbypass">bypass Voter Search to create a petition</A>	
						</P>
						
					  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
							<div>
								<dl class="form-group col-5 d-inline-block"> 
									<dt><label for="user_profile_name">First Name</label><DT>
									<dd>
										<input class="form-control" type="text" Placeholder="First" name="FirstName"<?php if (!empty ($URIEncryptedString["QueryFirstName"])) { echo " VALUE=\"" . $URIEncryptedString["QueryFirstName"] . "\""; } ?> id="user_profile_name">
									</dd>
								</dl>
			
								<dl class="form-group col-6 d-inline-block"> 
									<dt><label for="user_profile_name">Last Name</label><DT>
									<dd>
										<input class="form-control" type="text" Placeholder="Last" name="LastName"<?php if (!empty ($URIEncryptedString["QueryLastName"])) { echo " VALUE=\"" . $URIEncryptedString["QueryLastName"] . "\""; } ?> id="user_profile_name">
									</dd>
								</dl>
							</DIV>
			
							<DIV>
								<dt><label for="user_profile_email">Date of Birth</label></dt>	
								<dl class="form-group col-3 d-inline-block">
									<dd>
										<input class="form-control" type="text" name="Day" id="" Placeholder="Day"<?php if (!empty ($URIEncryptedString["QueryDay"])) { echo " VALUE=\"" . $URIEncryptedString["QueryDay"] . "\""; } ?>>
									</DD>
								</DL>  
								
								
							
								<dl class="f40 col-4 d-inline-block ">      
									<DD>
										<select class="f40" name="Month" id="">
											<option value="">Select month</option>
											<option value="01"<?php if ($URIEncryptedString["QueryMonth"] == "1") { echo " SELECTED"; } ?>>January</option>
											<option value="02"<?php if ($URIEncryptedString["QueryMonth"] == "2") { echo " SELECTED"; } ?>>February</option>
											<option value="03"<?php if ($URIEncryptedString["QueryMonth"] == "3") { echo " SELECTED"; } ?>>March</option>
											<option value="04"<?php if ($URIEncryptedString["QueryMonth"] == "4") { echo " SELECTED"; } ?>>April</option>
											<option value="05"<?php if ($URIEncryptedString["QueryMonth"] == "5") { echo " SELECTED"; } ?>>May</option>
											<option value="06"<?php if ($URIEncryptedString["QueryMonth"] == "6") { echo " SELECTED"; } ?>>June</option>
											<option value="07"<?php if ($URIEncryptedString["QueryMonth"] == "7") { echo " SELECTED"; } ?>>July</option>
											<option value="08"<?php if ($URIEncryptedString["QueryMonth"] == "8") { echo " SELECTED"; } ?>>August</option>
											<option value="09"<?php if ($URIEncryptedString["QueryMonth"] == "9") { echo " SELECTED"; } ?>>September</option>
											<option value="10"<?php if ($URIEncryptedString["QueryMonth"] == "10") { echo " SELECTED"; } ?>>October</option>
											<option value="11"<?php if ($URIEncryptedString["QueryMonth"] == "11") { echo " SELECTED"; } ?>>November</option>
											<option value="12"<?php if ($URIEncryptedString["QueryMonth"] == "12") { echo " SELECTED"; } ?>>December</option>
										</select>
									</DD>
								</DL>  
			
								<dl class="form-group col-4  d-inline-block">      
									<DD>
										<input class="form-control" type="text" Placeholder="Year" name="Year" id=""<?php if (!empty ($URIEncryptedString["QueryYear"])) { echo " VALUE=\"" . $URIEncryptedString["QueryYear"] . "\""; } ?>>
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
