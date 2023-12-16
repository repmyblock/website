<?php
	include "brandheader.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	
	if ( ! empty ($_GET["k"])) {
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/brand/db_socialist.php";	
		$r = new SocialistBrand(0);	
		$result = $r->QueryVoter("SocDemAmerica", $URIEncryptedString["FirstName"], $URIEncryptedString["LastName"], $URIEncryptedString["Email"]);
				
		if ( ! empty ($_POST)) {
			header("Location: /" . CreateEncoded (array(
					"FirstName" => trim($URIEncryptedString["FirstName"]),
					"LastName" => trim($URIEncryptedString["LastName"]),
					"Email" => trim($URIEncryptedString["Email"]),
			)) . "/brand/" . $BrandingName . "/notfound");
			exit();
		} 
		
		if ( empty ($result)) {
			header("Location: /" . CreateEncoded (array(
					"FirstName" => trim($URIEncryptedString["FirstName"]),
					"LastName" => trim($URIEncryptedString["LastName"]),
					"Email" => trim($URIEncryptedString["Email"]),
					"Error" => "We did not find your voter information."
			)) . "/brand/" . $BrandingName . "/notfound");
			exit();
		} 

	}
	
  $now = new DateTime(); // Used to figure out the age.
	$imgtoshow = "/brand/socialist/Socialists.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	
	WriteStderr($result, "Results of Run With Me.");
?>
<DIV class="main">
		
	<FORM METHOD="POST" ACTION="">		
	<DIV class="right f80"><?= $BrandingTitle ?></DIV>
	
		<P class="f60 p20">
			<?php if (count ($result) == 1) { ?>
				We found this voter.<BR>
				<B>Is that you? </B>
			<?php } else if (count($result) > 1) { ?>
	
				We found <?= count($result) ?> voters with the same name.<BR>
				<?php /* <B>Please select the one that is you.</B> */ ?>
				
				<BR>
				If you recognize anyone and they live in <B>Congressional District</B> 7, 8, 9, 10, 11, 12, 13, and 14, there is
				a high probability that they can sign a petition for the SDA candidates.
				To stay posted with the next steps, consider joining either the 
			 	<A TARGET="NewWhat" HREF="https://chat.whatsapp.com/EDKNVkzhlEyI9qvUXqu5S8">WhatsApp</A> or 
				<A TARGET="NewTel" HREF="https://t.me/+hJgN1aRJFqU2MTAx">Telegram</A> channels.
				<I>(They are low notification group with a message every two days around 7:30 pm New York Time.)</I>
				       		
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
				<TH>Congress District</TH>
				<TH>Age</TH>				
				<TH>Gender</TH>
			</TR>
		
			<TR>
			<TD><?= ucwords($result[0]["DataFirstName_Text"]) ?></TD>
				<TD><?= ucwords($result[0]["DataLastName_Text"]) ?></TD>			
				<TD><?= ucwords($result[0]["DataStreet_Name"]) ?></TD>
				<TD ALIGN=CENTER><?= $result[0]["DataAddress_zipcode"] ?></TD>
				<TD ALIGN=CENTER><?= $result[0]["DataDistrict_Congress"] ?></TD>
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
				<TH>Congress District</TH>
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
				<TD ALIGN=CENTER><?= $var["DataDistrict_Congress"] ?></TD>
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
			</DIV>
			
		</P>
						
<?php   } ?>

	<P class="f50">
				<?= $BrandingMaintainer ?>
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