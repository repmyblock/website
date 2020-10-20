<?php
	$Menu = "voters";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }

	$rmb = new RepMyBlock();	
	$result = $rmb->FindAllActivesVoterForUniq($URIEncryptedString["Address"], $DatedFiles);
	
	$MyAddressToUse = "<B>" . DB_ReturnAddressLine1($result[0], 0) . "</B><BR>" . DB_ReturnAddressLine2($result[0]);
	
	if ( ! empty ($result)) {
		foreach ($result as $var) {
			if ( ! empty ($var)) {
				 
				if ( empty ($Counter[$MyAddressToUse] )) {
					$Counter[$MyAddressToUse] = 0;
				}
				
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Petition_ID"] = $var["Candidate_ID"];
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Elector_ID"] = $var["VotersIndexes_UniqNYSVoterID"];
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Elector_FullName"] = DB_ReturnFullName($var);
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Elector_Address"] = "Apt " . $var["Raw_Voter_ResApartment"];
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Binary"] = $var["BinNotNeeded"];
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Full_Elector_Address"] = $var["Raw_Voter_ResHouseNumber"] . " " . $var["Raw_Voter_ResStreetName"];
			}			
			
			$Counter[$MyAddressToUse]++;
		}	
	}
	
	
	WriteStderr($Electors, "Result of voters - result");
	
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ($MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>



<div class="row">
  <div class="main">

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>


<div class="<?= $Cols ?> float-left">
	
	<div class="Subhead">
  	<h2 class="Subhead-heading">Voters</h2>
	</div>

	<?php 
		if ($VerifEmail == true) { 
			include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_emailverif.php";
		} else if ($VerifVoter == true) {
			include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_voterinfo.php";
		} 
	?>




	<div class="Box">
  	<div class="Box-header pl-0">
    	<div class="table-list-filters d-flex">
  			<div class="table-list-header-toggle states flex-justify-start pl-3"><?= $MyAddressToUse ?><BR>
  				<A HREF="/lgd/<?= $k ?>/voterlist">Return to previous screen</A></div>
  			
  		</div>	
    </div>
    
    <div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
      We don't know your district <a href="/voter">create one</a>?
    </div>

		<div id="voters" >
<?php
			$Counter = 0;
			if ( ! empty ($Electors)) {
				foreach ($Electors as $Address => $Elector) {
					if ( ! empty ($Address)) { ?>
						
					 
<?php				foreach ($Elector as $Elect) {
					 		if (! empty ($Elect)) { ?>
								<div class="list-group-item f60">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-arrows-alt handle"></i>&nbsp;
									<span class="ml-1"><?= $Elect["Elector_Address"] ?></span>&nbsp;
									<INPUT TYPE="checkbox" NAME="CreateID[]" VALUE="<?= $Elect["Elector_ID"] ?>">&nbsp;&nbsp;
									<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
									&nbsp;<?= $Elect["Elector_FullName"] ?>
									
							<?php /*	<svg class="octicon octicon-repo mr-1" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg> */ ?>
							<?php /* Petition <a class="mr-1" href="<?= $k ?>/organize">#<?= $Elect["Petition_ID"] ?></a> */ ?>
									<a class="mr-1" href="/lgd/<?= $k ?>/updateuserinfo">Update Info</a>
									<a class="mr-1" href="/lgd/<?= $k ?>/showqrcode">Show QR Code</a></div><?php 
				}	 
						} ?>
						
						
						
<?php			}
				}
			} ?>
	 

	 
		</div>
	</div>
</div>

</div>
</DIV>
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
