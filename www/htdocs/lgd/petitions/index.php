<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "petitions";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

  if (empty ($SystemUser_ID)) { goto_signoff(); }
	$rmb = new repmyblock();

	if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);


/*
	$Petitions[0]["Petition_ID"] = "2039";
	$Petitions[0]["Signed"] = 10;
	$Petitions[0]["Total"] = 1023;	

	$Petitions[1]["Petition_ID"] = "1022";
	$Petitions[1]["Signed"] = 1;
	$Petitions[1]["Total"] = 13;	

	$Petitions[2]["Petition_ID"] = "2059";
	$Petitions[2]["Signed"] = 114;
	$Petitions[2]["Total"] = 232;	
*/				
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/menu.php"; ?>
			<div class="col-9 float-left">
    

				<div class="Subhead">
			  	<h2 class="Subhead-heading">Petitions</h2>
				</div>
				
				<?php 
					if ($VerifEmail == true) { 
						include $_SERVER["DOCUMENT_ROOT"] . "/warnings/emailverif.php";
					} else if ($VerifVoter == true) {
						include $_SERVER["DOCUMENT_ROOT"] . "/warnings/voterinfo.php";
					} 
				?> 
			
			  <div class="Box">
					<div class="Box-header pl-0">
						<div class="table-list-filters d-flex">
							<div class="table-list-header-toggle states flex-justify-start pl-3">Organize your petitions</div>
						</div>
			    </div>
			    
			<?php if ( empty ($Petitions)) { ?>    
			    <div class="Box-body text-center py-6 js-collaborated-repos-empty">
			      You have not yet setup your petitions 
			    	<a href="setup/?k=<?= $k ?>">you can setup it up here.</a>
			    </div>
			<?php } ?>
			
				<div class="js-collaborated-repos">
			        
			<?php if ( ! empty ($Petitions)) {
				 	foreach ($Petitions as $Pet) {
				 		if (! empty ($Pet)) { ?>
							<div class="Box-row simple public js-collab-repo" data-repo-id="43183710" data-owner-id="5959961">
								<svg class="octicon octicon-repo mr-1" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg>
								<a class="mr-1" href="/lgd/petitions/organize/">Petition #<?= $Pet["Petition_ID"] ?></a>
								<span class="text-small">
								<span class="ml-2">
									<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
									<a href="/lgd/petitions/organize/"><?= $Pet["Signed"] ?> out of <?= $Pet["Total"] ?> signed</a>
								</span>
								</span>
							</div>
			<?php 	}
						}
					}
			?>
			
				</div>
			</div>
		</div>
	</DIV>
</DIV>
</DIV>





<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";	?>