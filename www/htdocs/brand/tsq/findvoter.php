<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	if ( ! empty ($_POST)) {
		// find which one is the right one.
		WriteStderr($_POST, "Result of Post:");
		if (! empty ($_POST["checkoneyes"])) {
			header("Location: /" . CreateEncoded (array("NYSID" => trim($_POST["NYSID"]))) . "/brand/RunWithMe/neighbors");
		} else {					
			header("Location: ../");
		}
		exit();
	}

	if ( ! empty ($_GET["k"])) {
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";	
					
		$r = new RepMyBlock();	
		$result = $r->QueryVoterFile("PaperboyBrand", $URIEncryptedString["FirstName"], $URIEncryptedString["LastName"]);
																
		if ( empty ($result)) {
			$error_msg = "Could not find the voter. Check the name.";
			header("Location: ../download/?k=" . EncryptURL("error_msg=" . $error_msg));
			exit();
		}
		
	}
	
  $now = new DateTime(); // Used to figure out the age.
	$imgtoshow = "/brand/RunWithMe/RunWithMe.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	
	WriteStderr($result, "Results of Run With Me.");
?>
<DIV class="main">
		
	<FORM METHOD="POST" ACTION="">		
	<DIV class="right f80">Download a Paperboy Love Prince Petition</DIV>
	
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
        $dob = new DateTime($result[0]["DOB"]);
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
				<TH>Age</TH>				
				<TH>Gender</TH>
			</TR>
			
			<TR>
				<TD><?= ucwords($result[0]["LastName"]) ?></TD>			
				<TD><?= ucwords($result[0]["FirstName"]) ?></TD>
				<TD><?= ucwords($result[0]["ResStreetName"]) ?></TD>
				<TD ALIGN=CENTER><?= $result[0]["ResZip"] ?></TD>
				<TD ALIGN=CENTER><?= $difference->y; ?></TD>				
				<TD ALIGN=CENTER><?= $gender ?></TD>
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
       		  $dob = new DateTime($var["DOB"]);
 						$difference = $now->diff($dob);
 						if ( $var["Gender"] == "M") { $gender = "Male"; }
 						else if ($var["Gender"] == "F") { $gender = "Female"; }     	
       	?>
       
			<TR>
				<TD ALIGN=CENTER> 
					<INPUT TYPE="radio" NAME="NYSID" VALUE="<?= $var["UniqNYSVoterID"] ?>">	
				</TD>
				<TD><?= ucwords($var["LastName"]) ?></TD>			
				<TD><?= ucwords($var["FirstName"]) ?></TD>
				<TD><?= ucwords($var["ResStreetName"]) ?></TD>
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

			<DIV>
				<INPUT class="votertable" id="votertable" TYPE="Submit" NAME="checkoneyes" VALUE="That is me">
				<INPUT class="votertable" id="votertable" TYPE="Submit" NAME="checkoneno" VALUE="None of them are me">
			</DIV>
		</P>
						
<?php   } ?>



		

	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>