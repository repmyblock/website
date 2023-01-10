<?php
	$Menu = "profile";  
	$BigMenu = "represent";	

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new RepMyBlock();
	$rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);

	if ( empty ($URIEncryptedString["MenuDescription"])) { $URIEncryptedString["MenuDescription"] = "District Not Defined";}	
	$Party = PrintParty($URIEncryptedString["UserParty"]);
	
	

	if ( ! empty ($_POST["Year"])) {
		WriteStderr($_POST, "Input \$_POST");

		// Search in the database.
		if ( $_POST["Year"] < 100 ) {
			if ( $_POST["Year"] > 05) { $Year = "19" . trim($_POST["Year"]);
			} else { $Year = "20" . trim($_POST["Year"]); }
		} else { $Year = trim($_POST["Year"]); }
		
		// We need to put verification on the first and lastname so they don't pass 
		// bogus data.		
		$DBFirstName = $_POST["FirstName"];
		$DBLastName = $_POST["LastName"];
		$DOB = $Year . "-" .  trim($_POST["Month"]) . "-" .  trim($_POST["Day"]);
		
		// Before we go and search the Database, we need to check that the DOB info is right.
		
	 	$result = $rmb->SearchVoterDB($DBFirstName, $DBLastName, $DOB, "active");
		WriteStderr($result, "SearchVoterDB(DBFirstName: $DBFirstName, DBLastName: $DBLastName, DOB: $DOB)");
		
		switch(count($result)) {
			case 0:
				//echo "Did not find anything\n";
				$error_msg = "<P class=\"f60\"><FONT COLOR=BROWN><B>We don't have</FONT> $DBFirstName $DBLastName " . 
											"<FONT COLOR=BROWN>born</FONT> " . PrintShortDate($DOB) . " <FONT COLOR=BROWN>in our database.<BR></B></FONT> " .
											"It my not be your fault. We get our data from the Board of Election files and sometimes they contain errors. " .
											"If you believe it's a mistake, check your registration with the local board of election on their website." . 
				"</P>";
				break;			
			
			case 1:				
				header("Location: /" .CreateEncoded ( array( 
								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
								"Raw_Voter_ID" => $resultPass["Raw_Voter_ID"],
								"FirstName" => $URIEncryptedString["FirstName"],
								"LastName" => $URIEncryptedString["LastName"],
								"VotersIndexes_ID" => $result[0]["VotersIndexes_ID"],
								"UniqNYSVoterID" => $result[0]["Raw_Voter_UniqNYSVoterID"],
								"UserParty" => $result[0]["Raw_Voter_RegParty"]
							))  . "/lgd/profile/result");
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
								"vi[]" => $var["VotersIndexes_ID"]
							))   . "/lgd/profile/select");
				exit();
		}		
	}
	
	// This is because we'll add some logic later.
	$FirstName = $URIEncryptedString["FirstName"];
	$LastName = $URIEncryptedString["LastName"];
	
	$TopMenus = array ( 
								array("k" => $k, "url" => "profile/user", "text" => "Public Profile"),
								array("k" => $k, "url" => "profile/profilevoter", "text" => "Voter Profile"),
								array("k" => $k, "url" => "profile/profilecandidate", "text" => "Candidate Profile"),
								array("k" => $k, "url" => "profile/profileteam", "text" => "Team Profile")
							);

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) {	 $Cols = "col-12"; $SizeField = " SIZE=10"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Voter Profile</h2>
			  </div>
  
			<?php
			 	PlurialMenu($k, $TopMenus);
			?>


			  <div class="clearfix gutter d-flex flex-shrink-0">
		
					<div class="col-16">
	
						<?= $error_msg ?>
	
					  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
							<div>
								<dl class="form-group col-5 d-inline-block"> 
									<dt><label for="user_profile_name" class="f40">First Name</label><DT>
									<dd>
										<input class="form-control" type="text" Placeholder="First" name="FirstName"<?php if (!empty ($FirstName)) { echo " VALUE=" . $FirstName; } ?> id="user_profile_name">
									</dd>
								</dl>
			
								<dl class="form-group col-5 d-inline-block"> 
									<dt><label for="user_profile_name" class="f40">Last Name</label><DT>
									<dd>
										<input class="form-control" type="text" Placeholder="Last" name="LastName"<?php if (!empty ($LastName)) { echo " VALUE=" . $LastName; } ?> id="user_profile_name">
									</dd>
								</dl>
							</DIV>
			
							<DIV>
								<dt><label for="user_profile_email" class="f40">Date of Birth</label></dt>	
								<dl class="form-group col-4 d-inline-block">
									<dd>
										<input class="f40" class="" type="text" name="Day" id="" Placeholder="Day"<?= $SizeField ?>>
									</DD>
								</DL>  
							
								<dl class="f40 col-3 d-inline-block">      
									<DD>
										<select class="f40" class="form-select" name="Month" id="">
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
			
								<dl class="form-group col-3  d-inline-block">      
									<DD>
										<input class="f40" class="form-control" type="text" Placeholder="Year" name="Year" id=""<?= $SizeField ?>>
									<dd>
								</dl>
			
								<p><INPUT class="" TYPE="Submit" NAME="SaveInfo" VALUE="Search Voter Registration"></p>
			
							</form> 
			
							</div>
				  	</div>
			  	</div>
				</div>
			</div>		
		</div>
	</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
