<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";

	if ( ! empty ($_POST)) {
		if ($_POST["checkoneyes"] == "Prepare the petition") {
						
			$Counter = 0;
			foreach ($_POST["NYSID"] as $index => $NYSID) {
				if ( ! empty($NYSID)) {
					print "Found : $index => $NYSID<BR>";
					$StringURL .= "NYSID[" . $Counter . "]=$NYSID&Witness[" . $Counter . "]=" . $_POST["Witness"][$index] . "&";
					$Counter++;
				}
			}
			
			header("Location: /" . CreateEncoded (
														array("FirstName" => trim($_POST["FirstName"]),	
																	"LastName" => trim($_POST["LastName"]))) .
														"/brand/socialist/prepwitness");
			exit();
			
		}
		exit();
	}
	
	if ( ! empty ($_GET["k"])) {		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_brand_runwithme.php";	
					
		$r = new runwithme();	
		$result = $r->FindNeibors($URIEncryptedString["NYSID"]);
		WriteStderr($URIEncryptedString["NYSID"], "Neighbors ... ");
		
		/*												
		if ( empty ($result)) {
			$error_msg = "Could not find the voter. Check the name.";
			header("Location: ../download/?k=" . EncryptURL("error_msg=" . $error_msg));
			exit();
		}
		*/
	}
	
	$imgtoshow = "/brand/socialist/Socialists.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
?>
<DIV class="main">
		
	<FORM METHOD="POST" ACTION="">		
	<DIV CLASS="right f80">Download an Social Democrat of America Petition</DIV>
	
			
		<P CLASS="f50">
			We need to find the voters in your building that you know that
			can sign a petition.<BR>
			<B>Select only the voters you know.</B>
		</P>
		
		<INPUT TYPE="hidden" NAME="NYSID[0]" VALUE="<?= $URIEncryptedString["NYSID"] ?>">

			
			<TABLE ID="VoterTable">
			<TR>
				<TH>&nbsp;</TH>
				<TH>Apt</TH>				
				<TH>First Name</TH>			
				<TH>Last Name</TH>		
			</TR>

<?php 		
			$Counter = 1;
			if ( ! empty ($result)) {
				foreach  ($result as $var) {
					if ( ! empty ($var) && $URIEncryptedString["NYSID"] != $var["UniqNYSVoterID"]) {
?>

			<TR>
				<TD ALIGN=CENTER>
					<INPUT TYPE="checkbox" NAME="NYSID[<?= $Counter ?>]" VALUE="<?= $var["UniqNYSVoterID"] ?>">
					<INPUT TYPE="hidden" NAME="Witness[<?= $Counter ?>]" VALUE="<?= $var["FirstName"] . " " . $var["LastName"] ?>">
				</TD>
				<TD ALIGN=CENTER><?= $var["ResApartment"] ?></TD>
				<TD><?= ucwords($var["FirstName"]) ?></TD>			
				<TD><?= ucwords($var["LastName"]) ?></TD>
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
				<INPUT CLASS="" TYPE="Submit" NAME="checkoneyes" VALUE="Prepare the petition">
			</DIV>
		</P>
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>