<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";

	if ( ! empty ($_POST)) {
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";

		$to = "theo@theochino.com";
		$emailsubject = time() . " - Your sample Democratic party petition and walk sheet.";
		$message = "Attached is the walk list for ";
		$EDAD = "43340";
		
		$Data = array("Dear" => "", "TotalSignatures" => "", "FullAddress" => "",
									"FullAddressLine2" => "", "ASSEMDISTR" => "", "ELECTDISTR" => "", "NumberVoters" => "",
									"PartyName" => "", "TotalSignatures" => "", "PartyNamePlural" => "");
					
		if ( ! empty ($_POST)) {
			foreach ($_POST as $key => $value) {
				if ( ! empty ($value)) {			
					SendWalkList($value, $emailsubject, $message, $EDAD, $key, $Data);		
					$EmailSend = "<FONT COLOR=GREEN>Sucess! Email sent to $value</FONT>";
				}
			}
		}
	}



  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$Party = PrintParty($UserParty);
	$rmb = new repmyblock();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	WriteStderr($URIEncryptedString, "URIEncryptedString");
	WriteStderr($rmbperson, "rmbperson");


	if ( ! empty ($URIEncryptedString["Query_NYSBOEID"])) {
		preg_match('/NY(.*)/', $URIEncryptedString["Query_NYSBOEID"], $matches, PREG_OFFSET_CAPTURE);
	 	if (is_numeric($matches[1][0])) {
			$NYSBOEID_padded = "NY" . str_pad($matches[1][0], 18, "0", STR_PAD_LEFT);
			$Result = $rmb->SearchVoter_Dated_NYSBOEID($URIEncryptedString["UniqNYSVoterID"], $DatedFiles, 
																								$DatedFilesID, $NYSBOEID_padded);
		} else {
			$ErrorMsg = "The NYS Voter ID is invalid";
		}
			
	} elseif (! empty ($URIEncryptedString["Query_LastName"])) {
		$Result = $rmb->SearchVoter_Dated_DB($URIEncryptedString["UniqNYSVoterID"], $DatedFiles, $DatedFilesID,
																					$URIEncryptedString["Query_FirstName"], $URIEncryptedString["Query_LastName"], NULL,
																					$URIEncryptedString["Query_ZIP"], $URIEncryptedString["Query_COUNTY"],
																					$URIEncryptedString["Query_PARTY"], $URIEncryptedString["Query_AD"],
																					$URIEncryptedString["Query_ED"], $URIEncryptedString["Query_Congress"]);
		WriteStderr($Result, "SearchVoter_Dated_DB");
																				
	} /* else {
			
	echo "JE SUIS ICI<BR>";
	exit();
		if (! empty ($URIEncryptedString["Query_AD"]) || ! empty ($URIEncryptedString["Query_ED"])) {	
			
			WriteStderr($URIEncryptedString, "URIEncryptedString in the Empty QueryAD and QueryED");
			
				header("Location: /" . $k . "/admin/byad");	
				exit();
				
				
				
		} else {	
			$ErrorMsg = "There is an error, a field is empty";
		}
	} 
	

	if ( ! empty ($Result)) {
		$ErrorMsg = "Voter not found";		
		header("Location: /" .  CreateEncoded ( array( 	
								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
								"SystemAdmin" => $URIEncryptedString["SystemAdmin"],
								"FirstName" => $URIEncryptedString["FirstName"],
								"LastName" => $URIEncryptedString["LastName"],
								"UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
								"UserParty" => $URIEncryptedString["UserParty"],
								"MenuDescription" => $URIEncryptedString["MenuDescription"],
								"RetReturnFirstName" => $URIEncryptedString["Query_FirstName"],
								"RetReturnLastName" => $URIEncryptedString["Query_LastName"],
								"RetReturnAD" => $URIEncryptedString["Query_AD"],
								"RetReturnED" => $URIEncryptedString["Query_ED"],
								"RetReturnZIP" => $URIEncryptedString["Query_ZIP"],
								"RetReturnCOUNTY" => $URIEncryptedString["Query_COUNTY"],
								"etReturnPARTY" => $URIEncryptedString["Query_PARTY"],
								"RetReturnNYSBOEID" => $URIEncryptedString["Query_NYSBOEID"],
								"RetReturnCongress" => $URIEncryptedString["Query_Congress"],
								"ErrorMsg" => $ErrorMsg								
					)) . "/admin/voterlookup");
		exit();
	}
*/
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Voter Lookup Result</h2>
				</div>

				<form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
				<div class="list-group-item filtered f60 hundred">
					<span><B>Raw Voter List</B></span>  	          			
				</div>
					
			 	<DIV class="panels">		
				<?php

				if ( ! empty ($Result)) {
						foreach ($Result as $var) {
							if ( ! empty ($var)) { 
								if (empty ($Query_AD) || ( $var["Raw_Voter_AssemblyDistr"] == $Query_AD)  ) {	
									if ( empty ($Query_ED) || ( $var["Raw_Voter_ElectDistr"] == $Query_ED)  ) {	
										if ( empty ($PARTY) || ($var["Raw_Voter_EnrollPolParty"] == $PARTY) ) {
															
											$EnrollVoterParty = $var["Raw_Voter_EnrollPolParty"];
											
											if ( $var["Raw_Voter_Gender"] == "M") {	$EnrollVoterSex = "male"; }
											else if ( $var["Raw_Voter_Gender"] == "F") {	$EnrollVoterSex = "female"; }
											else { $EnrollVoterSex = "other"; }
											
											preg_match('/^NY0+(.*)/', $var["Raw_Voter_UniqNYSVoterID"], $UniqMatches, PREG_OFFSET_CAPTURE);
											$UniqVoterID = "NY" . $UniqMatches[1][0];
				?>
				
				<div class="list-group-item f60">
					<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
					<?= $UniqVoterID ?> Status: <FONT COLOR=BROWN><?= $var["Raw_Voter_Status"] ?></FONT>
					<BR><BR>
					<TABLE BORDER=1>
					<TR>
						<TH style="padding:0px 10px;">First</TH>
						<TH style="padding:0px 10px;">Middle</TH>
						<TH style="padding:0px 10px;">Last</TH>
						<TH style="padding:0px 10px;">Suffix</TH>
					</TR>
					<TR ALIGN=CENTER>
						<TD style="padding:0px 10px;"><?= $var["Raw_Voter_FirstName"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["Raw_Voter_MiddleName"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["Raw_Voter_LastName"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["Raw_Voter_Suffix"] ?></TD>
					</TR>
				</TABLE>
				<BR>
				<TABLE BORDER=1>
					<TR>
						<TH style="padding:0px 10px;">Date of Birth</TH>
						<TH style="padding:0px 10px;">Age</TH>
						<TH style="padding:0px 10px;">Gender</TH>
						<TH style="padding:0px 10px;">Party</TH>
					</TR>
					<TR ALIGN=CENTER>
						<TD style="padding:0px 10px;"><?= PrintShortDate($var["Raw_Voter_DOB"]); ?></TD>
						<TD style="padding:0px 10px;">	<?php
										$dob = new DateTime($var["Raw_Voter_DOB"]);
	 									$now = new DateTime();
	 									$difference = $now->diff($dob);
	 									echo $difference->y;				
									?>
						<TD style="padding:0px 10px;"><?= $var["Raw_Voter_Gender"] ?></TD>
						<TD style="padding:0px 10px;"><?= NewYork_PrintParty($var["Raw_Voter_EnrollPolParty"]) ?></TD>
					</TR>
				</TABLE>
				<BR>
				<TABLE BORDER=1>
					<TR>
						<TH style="padding:0px 10px;">Assembly<BR>District</TH>
						<TH style="padding:0px 10px;">Electoral<BR>District</TH>
						<TH style="padding:0px 10px;">Congress</TH>
						<TH style="padding:0px 10px;">County</TH>
					</TR>
					<TR ALIGN=CENTER>
						<TD style="padding:0px 10px;"><?= $var["Raw_Voter_AssemblyDistr"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["Raw_Voter_ElectDistr"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["Raw_Voter_CongressDistr"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataCounty_Name"] ?></TD>
					</TR>
				</TABLE>
				<BR>
						
				<TABLE BORDER=1>
					<TR>
						<TH style="padding:0px 10px;">Address</TH>
					</TR>
					<TR>
						<TD style="padding:0px 10px;">		
							<?php if (! empty ($var["Raw_Voter_ResHouseNumber"])) echo $var["Raw_Voter_ResHouseNumber"]; ?>
							<?php if (! empty ($var["Raw_Voter_ResFracAddress"]))  echo $var["Raw_Voter_ResFracAddress"]; ?>
							<?php if (! empty ($var["Raw_Voter_ResPreStreet"])) echo $var["Raw_Voter_ResPreStreet"]; ?>
							<?php if (! empty ($var["Raw_Voter_ResStreetName"])) echo $var["Raw_Voter_ResStreetName"]; ?>
							<?php if (! empty ($var["Raw_Voter_ResPostStDir"])) echo $var["Raw_Voter_ResPostStDir"]; ?>
							<?php if (! empty ($var["Raw_Voter_ResApartment"])) echo " - Apt " . $var["Raw_Voter_ResApartment"]; ?>
							<BR>
							<?= $var["Raw_Voter_ResCity"] ?>, NY
							<?= $var["Raw_Voter_ResZip"] ?>
							<?php if (! empty ($var["Raw_Voter_ResZip4"])) echo " - " . $var["Raw_Voter_ResZip4"]; ?>
							<BR>
						</TD>
					</TR>
				</TABLE>
				<BR>
				<TABLE BORDER=1>
				<TR>
					<TH style="padding:0px 10px;">Legis #</TH>
					<TH style="padding:0px 10px;">Town</TH>
					<TH style="padding:0px 10px;">Ward</TH>
					<TH style="padding:0px 10px;">Senate</TH>
				</TR>
				<TR ALIGN=CENTER>
					<TD style="padding:0px 10px;"><?= $var["Raw_Voter_LegisDistr"] ?></TD>
					<TD style="padding:0px 10px;"><?= $var["Raw_Voter_TownCity"] ?></TD>
					<TD style="padding:0px 10px;"><?= $var["Raw_Voter_Ward"] ?></TD>
					<TD style="padding:0px 10px;"><?= $var["Raw_Voter_SenateDistr"] ?></TD>
				</TR>
			</TABLE>
			<BR>
					


			<?php 
						$MySpecialK = urlencode(CreateEncoded (array( 	
								"Raw_Voter_ID" => $var["Raw_Voter_ID"],
								"RawDatedFiles" => $DatedFiles,
			          "ED" => $var["Raw_Voter_ElectDistr"],
			          "AD" => $var["Raw_Voter_AssemblyDistr"],
			          "Raw_Voter_EnrollPolParty" => $var["Raw_Voter_EnrollPolParty"],
								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
								"SystemAdmin" => $URIEncryptedString["SystemAdmin"],
								"FirstName" => $URIEncryptedString["FirstName"],
								"LastName" => $URIEncryptedString["LastName"],
								"UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
								"UserParty" => $URIEncryptedString["UserParty"],
								"MenuDescription" => $URIEncryptedString["MenuDescription"]
						)));
			?>

			<svg class="octicon octicon-repo mr-1" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg>
			Download <a class="mr-1" href="<?= $FrontEndPDF ?>/raw_voterlist/?k=<?= $MySpecialK ?>">Walking 
			List</a> <a class="mr-1" href="<?= $FrontEndPDF ?>/raw_petitions/?k=<?= $MySpecialK ?>">Petition</a>
			<a class="mr-1" href="/admin/<?= $MySpecialK ?>/makecandidate">Make Candidate</a>
			<BR>
			
			<?php 
			
				$TheNewK = EncryptURL(	
					"SystemUser_ID=" . $URIEncryptedString["SystemUser_ID"]. 
					"&SystemAdmin=" .  $URIEncryptedString["SystemAdmin"] . 
					"&FirstName=" . $URIEncryptedString["FirstName"] . 
					"&LastName=" . $URIEncryptedString["LastName"] . 
					"&UniqNYSVoterID=" . $URIEncryptedString["UniqNYSVoterID"]. 
					"&UserParty=" . $URIEncryptedString["UserParty"]. 
					"&MenuDescription=" . $URIEncryptedString["MenuDescription"]
				); ?>
			
			<B><A HREF="/lgd/team/admin/?k=<?= $TheNewK ?>">Look for a new voter</A></B>
			
		</div>
		
		
		
																	
			<?php
						}
					}
				}
			}	 
		} 
	} else { ?>
			<div class="list-group-item f60">
				No voter found.
			</div>
	<?php } ?>
	
			</DIV>
		</FORM>
		</DIV>
	</DIV>
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
