<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	if ( ! empty ($_POST)) {
		// find which one is the right one.
		foreach ($_POST["NYSIDVERIF"] as $index => $var) {
			if ( $var == $_POST["NYSID"]) {
				if (! empty ($_POST["checkoneyes"])) {
					header("Location: ../neighbors/?k=" . EncryptURL("NYSID=" . $_POST["NYSID"] . 
																												  "&HseNbr=" . $_POST["ResHouseNumber"][$index] .
																													"&FracAdd=" . $_POST["ResFracAddress"][$index] .
																													"&Apt=" . $_POST["ResApartment"][$index] .
																													"&PreSt=" . $_POST["ResPreStreet"][$index] .
																													"&St=" . $_POST["ResStreetName"][$index] .
																													"&PostSt=" . $_POST["ResPostStDir"][$index] .
																													"&City=" . $_POST["ResCity"][$index] .
																													"&Zip=" . $_POST["ResZip"][$index]));
				} else {
					
					header("Location: ../");
					exit();
					
				}
			}			
		}		
		exit();
	}

	
	if ( ! empty ($_GET["k"])) {
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_brand_runwithme.php";	
					
		$r = new runwithme();	
		$result = $r->FindVoter($URIEncryptedString["FirstName"], $URIEncryptedString["LastName"], 
														"Raw_Voter_" . $DatedFiles);	
																
		if ( empty ($result)) {
			$error_msg = "Could not find the voter. Check the name.";
			header("Location: ../download/?k=" . EncryptURL("error_msg=" . $error_msg));
			exit();
		}
		
	}
	
  $now = new DateTime(); // Used to figure out the age.
	$imgtoshow = "/brand/RunWithMe/RunWithMe.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
?>
<DIV class="main">
		
	<FORM METHOD="POST" ACTION="">		
	<DIV CLASS="right f80">Download a Paperboy Love Prince Petition</DIV>
	
		<P CLASS="f60 p20">
			<?php if (count ($result) == 1) { ?>
				We found this voter.<BR>
				<B>Is that you? </B>
			<?php } else if (count($result) > 1) { ?>
	
				We found <?= count($result) ?> voters with the same name.<BR>
				<B>Please select the one that is you.</B>
       		
       <?php } ?>
    	
		</P>

		<P>
			<?php if (count ($result) == 1 ) { 
				$Counter = 0;
        $dob = new DateTime($result[0]["Raw_Voter_DOB"]);
 				$difference = $now->diff($dob);
				if ( $result[0]["Raw_Voter_Gender"] == "M") { $gender = "Male"; }
				else if ($result[0]["Raw_Voter_Gender"] == "F") { $gender = "Female"; }
			?>
	
			<INPUT TYPE="hidden" NAME="NYSID" VALUE="<?= $result[0]["VotersIndexes_UniqNYSVoterID"] ?>">	
			<INPUT TYPE="hidden" NAME="NYSIDVERIF[<?= $Counter ?>]" VALUE="<?= $result[0]["VotersIndexes_UniqNYSVoterID"] ?>">	
			<INPUT TYPE="hidden" NAME="ResHouseNumber[<?= $Counter ?>]" VALUE="<?= $result[0]["Raw_Voter_ResHouseNumber"] ?>">	
			<INPUT TYPE="hidden" NAME="ResFracAddress[<?= $Counter ?>]" VALUE="<?= $result[0]["Raw_Voter_ResFracAddress"] ?>">	
			<INPUT TYPE="hidden" NAME="ResApartment[<?= $Counter ?>]" VALUE="<?= $result[0]["Raw_Voter_ResApartment"] ?>">	
			<INPUT TYPE="hidden" NAME="ResPreStreet[<?= $Counter ?>]" VALUE="<?= $result[0]["Raw_Voter_ResPreStreet"] ?>">	
			<INPUT TYPE="hidden" NAME="ResStreetName[<?= $Counter ?>]" VALUE="<?= $result[0]["Raw_Voter_ResStreetName"] ?>">	
			<INPUT TYPE="hidden" NAME="ResPostStDir[<?= $Counter ?>]" VALUE="<?= $result[0]["Raw_Voter_ResPostStDir"] ?>">	
			<INPUT TYPE="hidden" NAME="ResCity[<?= $Counter ?>]" VALUE="<?= $result[0]["Raw_Voter_ResCity"] ?>">	
			<INPUT TYPE="hidden" NAME="ResZip[<?= $Counter ?>]" VALUE="<?= $result[0]["Raw_Voter_ResZip"] ?>">	

			<TABLE ID="VoterTable" width=100%>
			<TR>
				<TH>First Name</TH>			
				<TH>Last Name</TH>
				<TH>Street Address</TH>
				<TH>Zipcode</TH>
				<TH>Age</TH>				
				<TH>Gender</TH>
			</TR>
			
			<TR>
				<TD><?= ucwords($result[0]["Raw_Voter_FirstName"]) ?></TD>			
				<TD><?= ucwords($result[0]["Raw_Voter_LastName"]) ?></TD>
				<TD><?= ucwords($result[0]["Raw_Voter_ResStreetName"]) ?></TD>
				<TD ALIGN=CENTER><?= $result[0]["Raw_Voter_ResZip"] ?></TD>
				<TD ALIGN=CENTER><?= $difference->y; ?></TD>				
				<TD ALIGN=CENTER><?= $gender ?></TD>
			</TR>
			</TABLE>
			
			&nbsp;<BR>

			<DIV>
				<INPUT CLASS="votertable" id="votertable" TYPE="Submit" NAME="checkoneyes" VALUE="Yes">
				<INPUT CLASS="votertable" id="votertable" TYPE="Submit" NAME="checkoneno" VALUE="No">
			</DIV>
			
       <?php } else { 
       	$Counter = 0;
    	 ?>
       
      
       
       <TABLE ID="VoterTable" WIDTH=100%>
			<TR>
				<TH>&nbsp;</TH>
				<TH>First Name</TH>			
				<TH>Last Name</TH>
				<TH>Street Address</TH>
				<TH>Zipcode</TH>
				<TH>Age</TH>				
				<TH>Gender</TH>
			</TR>
       
       <?php
       	foreach ($result as $var) {
       		if ( ! empty ($var)) {
       		  $dob = new DateTime($var["Raw_Voter_DOB"]);
 						$difference = $now->diff($dob);
 						if ( $var["Raw_Voter_Gender"] == "M") { $gender = "Male"; }
 						else if ($var["Raw_Voter_Gender"] == "F") { $gender = "Female"; }     	
       	?>
       
			<TR>
				<TD ALIGN=CENTER> 
					<INPUT TYPE="radio" NAME="NYSID" VALUE="<?= $var["VotersIndexes_UniqNYSVoterID"] ?>">	
					<INPUT TYPE="hidden" NAME="NYSIDVERIF[<?= $Counter ?>]" VALUE="<?= $var["VotersIndexes_UniqNYSVoterID"] ?>">	
					<INPUT TYPE="hidden" NAME="ResHouseNumber[<?= $Counter ?>]" VALUE="<?= $var["Raw_Voter_ResHouseNumber"] ?>">	
					<INPUT TYPE="hidden" NAME="ResFracAddress[<?= $Counter ?>]" VALUE="<?= $var["Raw_Voter_ResFracAddress"] ?>">	
					<INPUT TYPE="hidden" NAME="ResApartment[<?= $Counter ?>]" VALUE="<?= $var["Raw_Voter_ResApartment"] ?>">	
					<INPUT TYPE="hidden" NAME="ResPreStreet[<?= $Counter ?>]" VALUE="<?= $var["Raw_Voter_ResPreStreet"] ?>">	
					<INPUT TYPE="hidden" NAME="ResStreetName[<?= $Counter ?>]" VALUE="<?= $var["Raw_Voter_ResStreetName"] ?>">	
					<INPUT TYPE="hidden" NAME="ResPostStDir[<?= $Counter ?>]" VALUE="<?= $var["Raw_Voter_ResPostStDir"] ?>">	
					<INPUT TYPE="hidden" NAME="ResCity[<?= $Counter ?>]" VALUE="<?= $var["Raw_Voter_ResCity"] ?>">	
					<INPUT TYPE="hidden" NAME="ResZip[<?= $Counter ?>]" VALUE="<?= $var["Raw_Voter_ResZip"] ?>">
				</TD>
				<TD><?= ucwords($var["Raw_Voter_FirstName"]) ?></TD>			
				<TD><?= ucwords($var["Raw_Voter_LastName"]) ?></TD>
				<TD><?= ucwords($var["Raw_Voter_ResStreetName"]) ?></TD>
				<TD ALIGN=CENTER><?= $var["Raw_Voter_ResZip"] ?></TD>
				<TD ALIGN=CENTER><?= $difference->y; ?></TD>				
				<TD ALIGN=CENTER><?= $gender ?></TD>
			</TR>
       
       <?php 
       	$Counter++;
     }
}     ?>



  
	
			</TABLE>
			
			&nbsp;<BR>

			<DIV>
				<INPUT CLASS="votertable" id="votertable" TYPE="Submit" NAME="checkoneyes" VALUE="That is me">
				<INPUT CLASS="votertable" id="votertable" TYPE="Submit" NAME="checkoneno" VALUE="None of them are me">
			</DIV>
		</P>
						
<?php   } ?>



		

	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>