<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";
	$BigMenu = "represent";	
	 
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 
	
	if ( ! empty ($_POST)) {
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";		

		echo "<PRE>";
		print_r($_POST);
		echo "</PRE>";

		$to = "theo@theochino.com";
		$emailsubject = time() . " - Your sample Democratic party petition and walk sheet.";
		$message = "Attached is the walk list for ";
		$EDAD = "43340";
		
		$Data["Dear"] = "";
		$Data["TotalSignatures"] = "";
		$Data["FullAddress"]  = "";
		$Data["FullAddressLine2"] = "";
		$Data["ASSEMDISTR"] = "";
		$Data["ELECTDISTR"] = "";
		$Data["NumberVoters"] = "";
		$Data["PartyName"] = "";
		$Data["TotalSignatures"] = "";
		$Data["PartyNamePlural"] = "";
					
		if ( ! empty ($_POST)) {
			foreach ($_POST as $key => $value) {
				if ( ! empty ($value)) {			
					SendWalkList($value, $emailsubject, $message, $EDAD, $key, $Data);		
					$EmailSend = "<FONT COLOR=GREEN>Sucess! Email sent to $value</FONT>";
				}
			}
		}
	}

  if (empty ($SystemUser_ID)) { goto_signoff(); }
	$rmb = new repmyblock();

	if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);
	
	if ( ! empty($Query_FirstName) || ! empty ($Query_LastName)) {		
		$Result = $rmb->SearchVoter_Dated_DB($URIEncryptedString["UniqNYSVoterID"], $DatedFiles, $DatedFilesID, $Query_FirstName, $Query_LastName);
		
	} else {

		if (! empty ($AD)) {	
			if ( empty ($ED)) {
				header("Location: byad/?k=" . $k);	
				exit();
						
			} else {
				
				// Ugly Hack to remove one day
				$Result = $rmb->SearchByAD_Dated_DB($URIEncryptedString["UniqNYSVoterID"], $DatedFiles, $DatedFilesID, $PARTY, $AD, $ED);	
				$EmptyResultSet = $Result[0];
				$Result = array();
				$Result[0] = $EmptyResultSet;		
				$Result[0]["Raw_Voter_LastName"] = "UGLY HACK TO GET THE WALK LIST.";
				$Result[0]["Raw_Voter_ResHouseNumber"]= "";
				$Result[0]["Raw_Voter_ResFracAddress"] = "";
				$Result[0]["Raw_Voter_ResPreStreet"] = "";
				$Result[0]["Raw_Voter_ResStreetName"] = "";
				$Result[0]["Raw_Voter_ResPostStDir"] = "";
				$Result[0]["Raw_Voter_ResApartment"]= "";
				$Result[0]["Raw_Voter_ResCity"]= "";
				$Result[0]["Raw_Voter_ResZip"] = "";
				$Result[0]["Raw_Voter_ResZip4"] = "";
				$Result[0]["Raw_Voter_DOB"] = "";
				$Result[0]["Raw_Voter_Gender"] = "";
				$Result[0]["Raw_Voter_FirstName"] = "";
				$Result[0]["Raw_Voter_MiddleName"] = "";
				$Result[0]["Raw_Voter_Suffix"] = "";
			}
		} else {
			echo "The Assembly District cannot be empty, please go back to the previous screen";
			exit();
		}
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/menu.php"; ?>
			<div class="col-9 float-left">
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Find Raw Voter</h2>
				</div>
			
	
						 <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
						<div class="list-group-item filtered f60 hundred">
							<span><B>Raw Voter List</B></span>  	          			
						</div>
							
					 <DIV class="panels">
				<?php
		 if ( ! empty ($Result)) {
				foreach ($Result as $var) {
					if ( ! empty ($var)) { ?>
						
					 			
								<div class="list-group-item f60">
									<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
									<?= $var["Raw_Voter_ID"] ?><BR>
									Last: <?= $var["Raw_Voter_LastName"] ?>	First: <?= $var["Raw_Voter_FirstName"] ?>	Middle: <?= $var["Raw_Voter_MiddleName"] ?> Suffix: <?= $var["Raw_Voter_Suffix"] ?><BR>
									<?php if (! empty ($var["Raw_Voter_ResHouseNumber"])) echo $var["Raw_Voter_ResHouseNumber"]; ?>
									<?php if (! empty ($var["Raw_Voter_ResFracAddress"]))  echo $var["Raw_Voter_ResFracAddress"]; ?>
									<?php if (! empty ($var["Raw_Voter_ResPreStreet"])) echo $var["Raw_Voter_ResPreStreet"]; ?>
									<?php if (! empty ($var["Raw_Voter_ResStreetName"])) echo $var["Raw_Voter_ResStreetName"]; ?>
									<?php if (! empty ($var["Raw_Voter_ResPostStDir"])) echo $var["Raw_Voter_ResPostStDir"] . "<BR>"; ?>
									<?php if (! empty ($var["Raw_Voter_ResApartment"])) echo $var["Raw_Voter_ResApartment"] . "<BR>"; ?>

									<?= $var["Raw_Voter_ResCity"] ?>, NY
									<?= $var["Raw_Voter_ResZip"] ?> - <?= $var["Raw_Voter_ResZip4"] ?><BR>
									<?= $var["Raw_Voter_DOB"] ?> - <?= $var["Raw_Voter_Gender"] ?> - <?= $var["Raw_Voter_EnrollPolParty"] ?><BR>
									Cty: <?= $var["Raw_Voter_CountyCode"] ?> 
									AD: <?= $var["Raw_Voter_AssemblyDistr"] ?>
									ED:<?= $var["Raw_Voter_ElectDistr"] ?>
									Legist: <?= $var["Raw_Voter_LegisDistr"] ?>
									Town: <?= $var["Raw_Voter_TownCity"] ?>
									Ward: <?= $var["Raw_Voter_Ward"] ?>
									Congress: <?= $var["Raw_Voter_CongressDistr"] ?>
									Senate: <?= $var["Raw_Voter_SenateDistr"] ?>
									Status: <?= $var["Raw_Voter_Status"] ?><BR>

									<?php $MySpecialK = EncryptURL("Raw_Voter_ID=" . $var["Raw_Voter_ID"] . "&RawDatedFiles=" .  $DatedFiles . 
									                               "&ED=" . $var["Raw_Voter_ElectDistr"] . "&AD=" . $var["Raw_Voter_AssemblyDistr"] .
									                               "&Raw_Voter_EnrollPolParty=" . $var["Raw_Voter_EnrollPolParty"]); ?>
								
									<svg class="octicon octicon-repo mr-1" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg>
									Download <a class="mr-1" href="<?= $FrontEndPDF ?>/raw_voterlist/?k=<?= $MySpecialK ?>">Walking 
									List</a> <a class="mr-1" href="<?= $FrontEndPDF ?>/raw_petitions/?k=<?= $MySpecialK ?>">Petition</a>
									<BR>
									<?php if ( ! empty ($EmailSend)) { echo $EmailSend . "<BR>"; } ?>
									Email: 	<input class="form-control" type="text" Placeholder="Email Address" value="" name="<?= $MySpecialK ?>" id="">
										<button type="submit" value="<?= $MySpecialK ?>" class="btn btn-primary">Email Walking List</button>
								
									</div>
									
			<?php	}	 
				} 

	}?>
						
						
						</DIV>

</FORM>
</DIV>
</DIV>
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";	?>
