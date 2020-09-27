<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";

	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();
	
	/* 
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

 

	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($URIEncryptedString["UserParty"]);

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
																				
	} else {
		
		if (! empty ($URIEncryptedString["Query_AD"]) || ! empty ($URIEncryptedString["Query_ED"])) {	
			WriteStderr($URIEncryptedString, "URIEncryptedString in the Empty QueryAD and QueryED");
			header("Location: /admin/" . $k . "/byad");	
			exit();
		} else {	
			$ErrorMsg = "There is an error, a field is empty";
		}
	} 
	
	/*
	if ( empty ($Result)) {
		$ErrorMsg = "User not found";		
		header("Location: /admin/" .  CreateEncoded ( array( 	
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
					)) . "/userlookup");
		exit();
	}
	*/
	
	$Result = $rmb->SearchUsers($DatedFiles);
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Rep My Block Users</h2>
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
								
				?>
				
				<div class="list-group-item f60">
					<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
					<?= $var["SystemUser_ID"] ?> Username: <FONT COLOR=BROWN><?= $var["SystemUser_username"] ?></FONT>&nbsp;Email:&nbsp;<FONT COLOR="BROWN"><?= $var["SystemUser_email"] ?></FONT>
		

			
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
			
			
			
		</div>
		
		
		
																	
			<?php
					
			}	 
		} 
	} else { ?>
			<div class="list-group-item f60">
				No user found.
			</div>
	<?php } ?>
	
	<BR>
	<B><A HREF="/lgd/team/admin/?k=<?= $TheNewK ?>">Look for a new voter</A></B>
	
			</DIV>
		</FORM>
		</DIV>
	</DIV>
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
