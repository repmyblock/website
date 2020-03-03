<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";
	$BigMenu = "represent";	
	 
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 
	
  if (empty ($SystemUser_ID)) { goto_signoff(); }
	$rmb = new repmyblock();

	if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);
	
	// print "resultPass: " . "<PRE>" . print_r($URIEncryptedString, 1) . "</PRE>";
	
	if (! empty ($Query_AD)) {	
		if ( empty ($Query_ED)) {
			$Result = $rmb->ReturnGroupAD_Dated_DB($URIEncryptedString["UniqNYSVoterID"], $DatedFiles, $DatedFilesID, $Query_PARTY, $Query_AD);			
			// print "resultPass: " . "<PRE>" . print_r($Result, 1) . "</PRE>";
		} 
	}
	
	$MyTotal = 0;
	if ( ! empty ($Result)) {
		foreach ($Result as $var) {
			if ( ! empty ($var)) { 
				$Total += $var["Count"];
			}
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
					 	
					 	<div class="list-group-item f60">									
							<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
							AD: <?= $var["Raw_Voter_AssemblyDistr"] ?>	- Count: <?= $Total ?>
							<?= $var["Raw_Voter_EnrollPolParty"] ?>									
							<?php $MySpecialK = EncryptURL("Raw_Voter_ID=" . $var["Raw_Voter_ID"] . "&RawDatedFiles=" .  $DatedFiles . 
							                               "&AD=" . $var["Raw_Voter_AssemblyDistr"] . 
							                               "&Raw_Voter_EnrollPolParty=" . $var["Raw_Voter_EnrollPolParty"]); ?>
							<svg class="octicon octicon-repo mr-1" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg>
							<?php if ($Total < 5000) { ?>
								Download <a class="mr-1" href="<?= $FrontEndPDF ?>/raw_voterlist/?k=<?= $MySpecialK ?>">Walksheet</A> 
							<?php } ?>
						</div>
				<?php
				
				 if ( ! empty ($Result)) {
				foreach ($Result as $var) {
					if ( ! empty ($var)) { ?>
						
	
						
					 			
								<div class="list-group-item f60">
									
									<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
									AD: <?= $var["Raw_Voter_AssemblyDistr"] ?>	ED: <?= $var["Raw_Voter_ElectDistr"] ?>	- Count: <?= $var["Count"] ?>
									<?= $var["Raw_Voter_EnrollPolParty"] ?>									
									<?php $MySpecialK = EncryptURL("Raw_Voter_ID=" . $var["Raw_Voter_ID"] . "&RawDatedFiles=" .  $DatedFiles . 
									                               "&ED=" . $var["Raw_Voter_ElectDistr"] . "&AD=" . $var["Raw_Voter_AssemblyDistr"] . 
									                               "&Raw_Voter_EnrollPolParty=" . $var["Raw_Voter_EnrollPolParty"]); ?>
									<svg class="octicon octicon-repo mr-1" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg>
									Download <a class="mr-1" href="<?= $FrontEndPDF ?>/raw_voterlist/?k=<?= $MySpecialK ?>">Walksheet</A>
									</div>
									
			<?php	}	 
		}
	}
	
			?>
						
						
						</DIV>

</FORM>
</DIV>
</DIV>
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";	?>
