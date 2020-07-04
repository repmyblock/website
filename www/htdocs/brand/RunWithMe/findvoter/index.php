<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";

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
	
	$imgtoshow = "/brand/RunWithMe/RunWithMe.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
		
	<FORM METHOD="POST" ACTION="">		
	<DIV CLASS="right f80">Download a Paperboy Love Prince Petition</DIV>
	
		<P>
			&nbsp;
		</P>
			
		<P>
			To prepare the petition, we need to verify your Voter Registration. Please enter your first and last name.
		</P>

		<P>
					
			<?php if (count ($result) == 1 ) { ?>
	
				We found this voter. 
				Is that you? 			 
		
			<INPUT TYPE="hidden" NAME="checkone" VALUE="<?= $result[0]["VotersIndexes_UniqNYSVoterID"] ?>">	

			
			<TABLE BORDER=1>
			<TR>
				<TH>&nbsp;</TH>
				<TH>First Name</TH>			
				<TH>Last Name</TH>
				<TH>Street Address</TH>
				<TH>Zipcode</TH>
				<TH>Age</TH>				
				<TH>Gender</TH>
			</TR>
			
			<TR>
				<TD>&nbsp;</TD>
				<TD><?= ucwords($result[0]["Raw_Voter_FirstName"]) ?></TD>			
				<TD><?= ucwords($result[0]["Raw_Voter_LastName"]) ?></TD>
				<TD><?= ucwords($result[0]["Raw_Voter_ResStreetName"]) ?></TD>
				<TD><?= $result[0]["Raw_Voter_ResZip"] ?></TD>
				<TD><?= $result[0]["Raw_Voter_DOB"] ?></TD>				
				<TD><?= $result[0]["Raw_Voter_Gender"] ?></TD>
			</TR>
			</TABLE>
			
			&nbsp;<BR>

			<DIV>
				<INPUT CLASS="" TYPE="Submit" NAME="checkoneyes" VALUE="yes">
				<INPUT CLASS="" TYPE="Submit" NAME="checkoneno" VALUE="no">
			</DIV>
			
		   
		 
			 
		   
            
            
       <?php } else { ?>
       
       
       echo "We found " . count($result) . "<BR>";
       
       
     <?php } ?>
	
		</P>
						



		

	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>