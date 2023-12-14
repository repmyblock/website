<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	/*
	if ( ! empty ($_POST)) {
		// find which one is the right one.
		WriteStderr($_POST, "Result of Post:");
		
		if ( ! empty ($_POST["searchanothername"])) {
			header("Location: /web/brand/socialist/download");
			exit;
		}
		
		if (! empty ($_POST["checkoneyes"])) {
			header("Location: /" . CreateEncoded (array("NYSID" => trim($_POST["NYSID"]))) . "/brand/socialist/neighbors");
		} else {					
			header("Location: ../");
		}
		exit();
	}
	*/

	if ( ! empty ($_GET["k"])) {
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_brand_socialist.php";	
					
		$r = new SocialistBrand(0);	
		$result = $r->QueryVoter("SocDemAmerica", $URIEncryptedString["FirstName"], $URIEncryptedString["LastName"], $URIEncryptedString["Email"]);
				
		if ( empty ($result)) {
			$error_msg = "Could not find the voter. Check the name.";
			header("Location: /" . CreateEncoded (array("error_msg" => $error_msg)) .
																	"/brand/socialist/download");
			exit();
		}
		/*
		header("Location: " . $FrontEndPDF . "/" . CreateEncoded (
														array("NYSID" => trim($_POST["NYSID"]),
																	"Intrustions" => "yes",
																	"PetType" => "prefiled"
																	)) .
																	"/NY/packet");
		exit();
		*/
	}
	
  $now = new DateTime(); // Used to figure out the age.
	$imgtoshow = "/brand/socialist/Socialists.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	
	WriteStderr($result, "Results of Run With Me.");
?>
<DIV class="main">
		
	<FORM METHOD="POST" ACTION="">		
	<DIV class="right f80">Download a Social Democrat of America Petition</DIV>
	
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
				if ( $result[0]["Gender"] == "M") { $gender = "Male"; }
				else if ($result[0]["Gender"] == "F") { $gender = "Female"; }
			?>
	
			<INPUT TYPE="hidden" NAME="NYSID" VALUE="<?= $result[0]["UniqNYSVoterID"] ?>">	

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
				<TD><?= ucwords($result[0]["ResStreetName"]) ?></TD>
				<TD ALIGN=CENTER><?= $result[0]["ResZip"] ?></TD>
				<TD ALIGN=CENTER><?= $result[0]["CongressDistr"] ?></TD>
				<TD ALIGN=CENTER><?= $difference->y; ?></TD>				
				<TD ALIGN=CENTER><?= $gender ?></TD>
				
			</TR>
			</TABLE>
			
			&nbsp;<BR>

<?php /* 
			<DIV>
				<INPUT class="votertable" id="votertable" TYPE="Submit" NAME="checkoneyes" VALUE="Yes">
				<INPUT class="votertable" id="votertable" TYPE="Submit" NAME="checkoneno" VALUE="No">
			</DIV>
			*/ ?>
			
			
					<DIV>
				<INPUT class="votertable" id="votertable" TYPE="Submit" NAME="searchanothername" VALUE="Search another name">
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
       		  $dob = new DateTime($var["DOB"]);
 						$difference = $now->diff($dob);
 						if ( $var["Gender"] == "M") { $gender = "Male"; }
 						else if ($var["Gender"] == "F") { $gender = "Female"; }     	
       	?>
       
			<TR>
				<TD ALIGN=CENTER> 
					<INPUT TYPE="radio" NAME="NYSID" VALUE="<?= $var["UniqNYSVoterID"] ?>">	
				</TD>
				<TD><?= ucwords($var["FirstName"]) ?></TD>			
				<TD><?= ucwords($var["LastName"]) ?></TD>
				<TD><?= ucwords($var["ResStreetName"]) ?></TD>
				<TD ALIGN=CENTER><?= $var["CongressDistr"] ?></TD>
				<TD ALIGN=CENTER><?= $var["ResZip"] ?></TD>
				<TD ALIGN=CENTER><?= $difference->y; ?></TD>				
				<TD ALIGN=CENTER><?= $gender ?></TD>
			</TR>
       
       <?php 
       	$Counter++;
     }
}     ?>

			</TABLE>
			
			&nbsp;<BR>

<?php /*
			<DIV>
				<INPUT class="votertable" id="votertable" TYPE="Submit" NAME="checkoneyes" VALUE="That is me">
				<INPUT class="votertable" id="votertable" TYPE="Submit" NAME="checkoneno" VALUE="None of them are me">
			</DIV>
		*/ ?>
			
				<DIV>
				<INPUT class="votertable" id="votertable" TYPE="Submit" NAME="searchanothername" VALUE="Search another name">
			</DIV>
			
		</P>
						
<?php   } ?>

	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>