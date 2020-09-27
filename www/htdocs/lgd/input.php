<?php
	$Menu = "profile";  
	$BigMenu = "represent";	

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();

	if ( empty ($URIEncryptedString["MenuDescription"])) { $URIEncryptedString["MenuDescription"] = "District Not Defined";}	
	$Party = NewYork_PrintParty($URIEncryptedString["UserParty"]);

	if ( ! empty ($_POST)) {
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
		
	 	$result = $rmb->SearchVoterDB($DBFirstName, $DBLastName, $DOB);
		WriteStderr($result, "SearchVoterDB(DBFirstName: $DBFirstName, DBLastName: $DBLastName, DOB: $DOB)");
		
		switch(count($result)) {
			case 0:
				//echo "Did not find anything\n";
				$error_msg = "<FONT COLOR=BROWN><B>This person is not in the database.</B></FONT>";
				break;			
			
			case 1:				
				header("Location: /lgd/" .CreateEncoded ( array( 
								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
								"Raw_Voter_ID" => $resultPass["Raw_Voter_ID"],
								"FirstName" => $URIEncryptedString["FirstName"],
								"LastName" => $URIEncryptedString["LastName"],
								"VotersIndexes_ID" => $result[0]["VotersIndexes_ID"],
								"UniqNYSVoterID" => $result[0]["Raw_Voter_UniqNYSVoterID"],
								"UserParty" => $result[0]["Raw_Voter_RegParty"]
							))  . "/result");
				exit();
			
			default:
				if ( ! empty ($result)) {
					foreach($result as $var) {
						if ( ! empty ($var)) {
							$EncryptURL .= "&vi[]=" . $var["VotersIndexes_ID"];
						}	
					}
				}
				
				header("Location: /lgd/" . CreateEncoded ( array( 
								"SystemUser_ID" => $resultPass["SystemUser_ID"],
								"Raw_Voter_ID" => $resultPass["Raw_Voter_ID"],
								"FirstName" => $resultPass["SystemUser_FirstName"],
								"LastName" => $resultPass["SystemUser_LastName"],
								"VotersIndexes_ID" => $result[0]["VotersIndexes_ID"],
								"UniqNYSVoterID" => $resultPass["Raw_Voter_UniqNYSVoterID"],
								"UserParty" => $resultPass["Raw_Voter_RegParty"],
								"SystemAdmin" => $resultPass["SystemUser_Priv"],
								"vi[]" => $var["VotersIndexes_ID"]
							))   . "/select");
				exit();
		}		
	}
	
	// This is because we'll add some logic later.
	$FirstName = $URIEncryptedString["FirstName"];
	$LastName = $URIEncryptedString["LastName"];

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
				if ($VerifEmail == true) { 
					include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_emailverif.php";
				} else if ($VerifVoter == true) {
					include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_voterinfo.php";
				} 
?>		
  
				<nav class="UnderlineNav pt-1 mb-4" aria-label="Billing navigation">
					<div class="UnderlineNav-body">
						<a href="/lgd/<?= $k ?>/profile" class="mobilemenu UnderlineNav-item">Public Profile</a>
						<a href="/lgd/<?= $k ?>/profilevoter" class="mobilemenu UnderlineNav-item selected">Voter Profile</a>
						<a href="/lgd/<?= $k ?>/profilecandidate" class="mobilemenu UnderlineNav-item">Candidate Profile</a>
					</div>
				</nav>


			  <div class="clearfix gutter d-flex flex-shrink-0">
		
					<div class="col-16">
	
						<?= $error_msg ?>
	
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
							
								<dl class="form-group col-2  d-inline-block">      
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
			
								<p><button type="submit" class="btn btn-primary">Search Voter Registration</button></p>
			
							</form> 
			
							</div>
				  	</div>
			  	</div>
				</div>
			</div>		
		</div>
	</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>