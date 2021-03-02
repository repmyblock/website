<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "voters";
	$BigMenu = "represent";	
	 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 
	
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();

	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);
	
	if (! empty ($URIEncryptedString["Query_AD"])) {	
			$Result = $rmb->ReturnGroupAD_Dated_DB($URIEncryptedString["UniqNYSVoterID"], $DatedFiles, $DatedFilesID, 
																							$URIEncryptedString["Query_PARTY"], $URIEncryptedString["Query_AD"], 
																							$URIEncryptedString["Query_ED"]);			
			WriteStderr($Result, "ReturnGroundAD_Dated_DB");
	}
	
	$MyTotal = 0;
	if ( ! empty ($Result)) {
		foreach ($Result as $var) {
			if ( ! empty ($var)) { 
				$Total += $var["Count"];
			}
		}
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Find Raw Voter</h2>
				</div>
			
	
						 <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
						<div class="list-group-item filtered f60 hundred">
							<span><B>Raw Voter List</B></span>  	          			
						</div>
							
					 <DIV class="panels">
					 	
					 	<?php if ( count ($Result) > 1) { ?>
					 	
					 	<div class="list-group-item f60">									
							<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
							AD: <?= $var["Raw_Voter_AssemblyDistr"] ?>	- Count: <?= $Total ?>
							<?= $var["Raw_Voter_EnrollPolParty"] ?>									
							<svg class="octicon octicon-repo mr-1" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg>
							<?php if ($Total < 5000) { ?>
								Download <a class="mr-1" href="<?= $FrontEndPDF ?>/NYS/<?= CreateEncoded (array( 	
																																								"Raw_Voter_ID" =>$var["Raw_Voter_ID"], 
																																								"RawDatedFiles" => $DatedFiles,
																																								"AD" => $var["Raw_Voter_AssemblyDistr"],
																																								"Raw_Voter_EnrollPolParty" => $var["Raw_Voter_EnrollPolParty"],
																																								"TypeSearch" => "Raw"				
																																							)); ?>/voterlist">Walksheet</A> 
							<?php } 
						echo "</div>";
						
					 } else {
							if ( count ($Result) < 1) {
								
								echo "<B><FONT SIZE=+2 COLOR=BROWN>You need to select a party to list by AD & ED.<BR>
								</FONT><FONT SIZE=+2>You cannot select ALL.</FONT>
								</FONT></B>";
							}
								
							} 
							
					
				
				 if ( ! empty ($Result)) {
				foreach ($Result as $var) {
					if ( ! empty ($var)) { ?>
						
	
						
					 			
								<div class="list-group-item f60">
									<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
									AD: <?= $var["Raw_Voter_AssemblyDistr"] ?>	ED: <?= $var["Raw_Voter_ElectDistr"] ?>	- Count: <?= $var["Count"] ?>
									<?= $var["Raw_Voter_EnrollPolParty"] ?>									
									<svg class="octicon octicon-repo mr-1" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg>
									Download <a class="mr-1" href="<?= $FrontEndPDF ?>/NYS/<?= CreateEncoded (array( 	
																																								"Raw_Voter_ID" =>$var["Raw_Voter_ID"], 
																																								"RawDatedFiles" => $DatedFiles,
																																								"AD" => $var["Raw_Voter_AssemblyDistr"],
																																								"ED" => $var["Raw_Voter_ElectDistr"],
																																								"Raw_Voter_EnrollPolParty" => $var["Raw_Voter_EnrollPolParty"],
																																								"TypeSearch" => "Raw"
																																							)); ?>/voterlist">Walksheet</A>
									</div>
									
			<?php	}	 
		}
	}
	
			?>
			
			
						
			
			
						<BR>
							<B><A HREF="/lgd/<?= $k ?>/voterquery">Back to the query screen</A></B>
						</DIV>

</FORM>
</DIV>
</DIV>
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
