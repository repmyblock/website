<?php
	$CandidateID = 288;
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	if ( ! empty ($_POST)) {	
		if ($_POST["Save"] == "Prepare the PDF file") {
			
			require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
			require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
			require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_brand_runwithme.php";	
					
			$r = new runwithme();	
			
			WriteStderr($_POST, "Post From Prep Witnesses ");
			
			// Do the witness first.
			$SignatureGroup[0] = $_POST["NYSID"];
		//	$r->SavePetitionGroup($SignatureGroup, $_POST["Witness"], $_POST["NYSID"], $CandidateID, "Raw_Voter_" . $DatedFiles);
			
			// The rest of the petition
		//	$r->SavePetitionGroup($_POST["Sigs"], $_POST["NYSID"], $_POST["NYSID"], $CandidateID, "Raw_Voter_" . $DatedFiles);														
				
			
			header("Location: /" . CreateEncoded (
														array("NYSID" => trim($_POST["NYSID"]))) .
																	"/brand/socialist/preshowpdf");
			
				
		}
		
		exit();
	}
	$imgtoshow = "/brand/dnc/democratic.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
?>
<DIV class="main">
		
	<FORM METHOD="POST" ACTION="">		
	<DIV class="right f80">Download a Democratic County Committee petition</DIV>
	

		<P class="f50">
			Which on of these person will you ask to witness your own petition?<BR>
			<B>You cannot withness your own petition so you need to ask one of these person to do it.</B>
		</P>

			<INPUT TYPE="hidden" NAME="NYSID" VALUE="<?= $URIEncryptedString["NYSID"][0] ?>">
				
			<TABLE id="VoterTable">
			<TR>
				<TH>&nbsp;</TH>
				<TH>Witness</TH>				
			</TR>
			
					<TR>
				<TD><INPUT TYPE="radio" NAME="Witness" VALUE="BLANK"></TD>
				<TD>Leave the witness line blank</TD>				
			</TR>
			
				<TR>
				<TD>&nbsp;</TD>
				<TD>&nbsp;</TD>				
			</TR>

<?php 		
			$Counter = 1;
			if ( ! empty ($URIEncryptedString["Witness"])) {
				foreach  ($URIEncryptedString["Witness"] as  $index => $var) {
					if ( ! empty ($var)) {
?>

			
			<TR>
				<TD>
					<INPUT TYPE="radio" NAME="Witness" VALUE="<?= $URIEncryptedString["NYSID"][$index] ?>">
					<INPUT TYPE="hidden" NAME="Sigs[]" VALUE="<?= $URIEncryptedString["NYSID"][$index] ?>">
				</TD>
				<TD><?= $var ?></TD>
			
			</TR>
		
<?php					
					$Counter++;	
					}
				}
			}
?>			

				</TABLE>
			&nbsp;<BR>

			<DIV>
				<INPUT class="" TYPE="Submit" NAME="Save" VALUE="Prepare the PDF file">
			</DIV>
			
		   
		 
		

		

	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>