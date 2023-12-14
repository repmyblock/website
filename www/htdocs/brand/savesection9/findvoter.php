<?php


	$HeaderTwitter = "yes";
	$HeaderTwitterTitle = "Save Section 9 - Rep My Block";
	$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/paste/SaveSection9.jpg";
	$HeaderTwitterDesc = "Save Section 9, Run for Presidential Delegate.";
	$HeaderOGTitle = "Save Section 9, Run for Presidential Delegate.";
	$HeaderOGDescription = "Save Section 9, Run for Presidential Delegate.";
	$HeaderOGImage = "https://static.repmyblock.org/pics/paste/SaveSection9.jpg"; 
	$HeaderOGImageWidth = "960";
	$HeaderOGImageHeight = "541";
	
	$imgtoshow = "/brand/savesection9/SaveSection9.png";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	if ( ! empty ($_POST)) {
		// find which one is the right one.
		WriteStderr($_POST, "Result of Post:");
		if (! empty ($_POST["checkoneyes"])) {
			header("Location: /" . CreateEncoded (array(
					"NYSID" => trim($_POST["NYSID"]),
					"FirstName" => trim($URIEncryptedString["FirstName"]),
					"LastName" => trim($URIEncryptedString["LastName"]),		
			)) . "/brand/savesection9/foundsave");
		} else {					
			header("Location: /" . CreateEncoded (array(
					"FirstName" => trim($URIEncryptedString["FirstName"]),
					"LastName" => trim($URIEncryptedString["LastName"]),
					"Error" => "Found ID but not the right person"
			)) . "/brand/savesection9/notfound");
		}
		exit();
	}

	if ( ! empty ($_GET["k"])) {
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_brand_savesection9.php";	
					
		$r = new savesection9();	
		$result = $r->QueryVoter("savesection9", $URIEncryptedString["FirstName"], $URIEncryptedString["LastName"]);
																
		if ( empty ($result)) {
			header("Location: /" . CreateEncoded (array(
					"FirstName" => trim($URIEncryptedString["FirstName"]),
					"LastName" => trim($URIEncryptedString["LastName"]),
					"Error" => "We did not find the user"
			)) . "/brand/savesection9/notfound");
			exit();
		}
		
	}
	
  $now = new DateTime(); // Used to figure out the age.
	$imgtoshow = "/brand/savesection9/SaveSection9.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	
	WriteStderr($result, "Results of Run With Me.");
?>
<DIV class="main">
		
	<FORM METHOD="POST" ACTION="">		
	<DIV class="right f80">Run Biden Presidential Delegates</DIV>
	
		<P class="f60 p20">
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
        $dob = new DateTime($result[0]["VotersIndexes_DOB"]);
 				$difference = $now->diff($dob);
			?>
	
			<INPUT TYPE="hidden" NAME="NYSID" VALUE="<?= $result[0]["VotersIndexes_UniqStateVoterID"] ?>">	

			<TABLE id="VoterTable" width=100%>
			<TR>
				<TH>First Name</TH>			
				<TH>Last Name</TH>
				<TH>Street Address</TH>
				<TH>Zipcode</TH>
				<TH>Age</TH>				
				<TH>Gender</TH>
			</TR>
			
			<TR>
				<TD><?= ucwords($result[0]["DataFirstName_Text"]) ?></TD>
				<TD><?= ucwords($result[0]["DataLastName_Text"]) ?></TD>			
				<TD><?= ucwords($result[0]["DataStreet_Name"]) ?></TD>
				<TD ALIGN=CENTER><?= $result[0]["DataAddress_zipcode"] ?></TD>
				<TD ALIGN=CENTER><?= $difference->y; ?></TD>				
				<TD ALIGN=CENTER><?= ucwords($result[0]["Voters_Gender"]) ?></TD>
			</TR>
			</TABLE>
			
			&nbsp;<BR>

			<DIV>
				<INPUT class="votertable" id="votertable" TYPE="Submit" NAME="checkoneyes" VALUE="Yes">
				<INPUT class="votertable" id="votertable" TYPE="Submit" NAME="checkoneno" VALUE="No">
			</DIV>
			
       <?php } else { 
       	$Counter = 0;
    	 ?>
       
      
       
      <TABLE id="VoterTable" WIDTH=100%>
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
       		  $dob = new DateTime($var["VotersIndexes_DOB"]);
 						$difference = $now->diff($dob);
       	?>
       
			<TR>
				<TD ALIGN=CENTER> 
					<INPUT TYPE="radio" NAME="NYSID" VALUE="<?= $var["VotersIndexes_UniqStateVoterID"] ?>">	
				</TD>
				<TD><?= ucwords($var["DataLastName_Text"]) ?></TD>			
				<TD><?= ucwords($var["DataFirstName_Text"]) ?></TD>
				<TD><?= ucwords($var["DataStreet_Name"]) ?></TD>
				<TD ALIGN=CENTER><?= $var["DataAddress_zipcode"] ?></TD>
				<TD ALIGN=CENTER><?= $difference->y; ?></TD>				
				<TD ALIGN=CENTER><?= ucwords($var["Voters_Gender"]) ?></TD>
			</TR>
       
       <?php 
       	$Counter++;
     }
}     ?>



  
	
			</TABLE>
			
			&nbsp;<BR>

			<DIV>
				<INPUT class="votertable" id="votertable" TYPE="Submit" NAME="checkoneyes" VALUE="That is me">
				<INPUT class="votertable" id="votertable" TYPE="Submit" NAME="checkoneno" VALUE="None of them are me">
			</DIV>
		</P>
						
<?php   } ?>

	<P class="f50">
				This page is maintained by the <B><A HREF="https://www.facebook.com/groups/savesection9" TARGET="SS9">Save Section 9</A></B>.
				Check their facebook page at <B><A HREF="https://www.facebook.com/groups/savesection9" TARGET="SS9">https://www.facebook.com/groups/savesection9</A>.
			</P>
		
		
		<P class="f40">
			By clicking the "Register" button, you are creating a 
			RepMyBlock account, and you agree to RepMyBlock's 
			<A HREF="/text/terms">Terms of Use</A> and 
			<A HREF="/text/privacy">Privacy Policy.</A>
		</P>


		

	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>