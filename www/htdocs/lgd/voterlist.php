<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "voters";
	$BigMenu = "represent";	
	
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	// require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_voterlist.php";  
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }

	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($URIEncryptedString["UserParty"]);

	$rmb = new RepMyBlock();	
	$result = $rmb->GetPetitionsForCandidate($DatedFiles, 0, $URIEncryptedString["SystemUser_ID"]);
	
	if ( ! empty ($result)) {
		foreach ($result as $var) {
			if ( ! empty ($var)) {

				$MyAddressToUse = $var["Raw_Voter_ResHouseNumber"] . " " . 
													$var["Raw_Voter_ResStreetName"];

				if ( empty ($Counter[$MyAddressToUse] )) {
					$Counter[$MyAddressToUse] = 0;
				}
				
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Petition_ID"] = $var["Candidate_ID"];
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Elector_ID"] = $var["VotersIndexes_UniqNYSVoterID"];
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Elector_FullName"] = $var["CandidatePetition_VoterFullName"];
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Elector_Address"] = "Apt " . $var["Raw_Voter_ResApartment"];
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Full_Elector_Address"] = $var["Raw_Voter_ResHouseNumber"] . " " . $var["Raw_Voter_ResStreetName"];
			}			
			
			$Counter[$MyAddressToUse]++;
		}	
	}

			
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
	
	
			
				    
				<div class="clearfix gutter d-flex flex-shrink-0">
									
				<div class="col-12">
				  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
						<div>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">First Name</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="First" name="FirstName" VALUE="<?= $FormFieldFirstName ?>" id="">
								</dd>
							</dl>

							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Last Name</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Last" name="LastName" VALUE="<?= $FormFieldLastName ?>" id="">
								</dd>
							</dl>
							
							</div>
							
						
								<div>
							
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Zipcode</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Zipcode" name="ZIP" VALUE="<?= $FormFieldZIP ?>" id="">
								</dd>
							</dl>
							
								<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">County</label><DT>
								<dd>
									<SELECT CLASS="mobilebig" NAME="COUNTY">
									<OPTION VALUE="">Whole State</OPTION>
									<OPTION VALUE="NYC"<?php if ($FormFieldCounty == "NYC"  || empty ($FormFieldCounty)) { echo " SELECTED"; } ?>>New York City</OPTION>
									<OPTION VALUE="BQK"<?php if ($FormFieldCounty == "BQK") { echo " SELECTED"; } ?>>Bronx, Queens, and Kings</OPTION>
									<OPTION VALUE="03"<?php if ($FormFieldCounty == "03") { echo " SELECTED"; } ?>>Bronx County (the Bronx)</OPTION>
									<OPTION VALUE="31"<?php if ($FormFieldCounty == "31") { echo " SELECTED"; } ?>>New York County (Manhattan)</OPTION>
									<OPTION VALUE="41"<?php if ($FormFieldCounty == "41") { echo " SELECTED"; } ?>>Queens County</OPTION>
									<OPTION VALUE="43"<?php if ($FormFieldCounty == "43") { echo " SELECTED"; } ?>>Richmond County (Staten Island)</OPTION>
									<OPTION VALUE="24"<?php if ($FormFieldCounty == "24") { echo " SELECTED"; } ?>>Kings County (Brooklyn)</OPTION>
									<OPTION VALUE="OUTSIDE"<?php if ($FormFieldCounty == "OUTSIDE") { echo " SELECTED"; } ?>>Outside New York City</OPTION>
									</SELECT>
								</dd>
							</dl>
							
						</DIV>

					<DIV>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">NYS BOE ID</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="NYS Uniq ID" name="UniqNYS" VALUE="<?= $FormFieldNYSBOEID ?>" id="">
								</dd>
							</dl>
				
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Party</label><DT>
								<dd>
									<SELECT  CLASS="mobilebig" NAME="Party">
										<OPTION VALUE="">All</OPTION>
										<OPTION VALUE="DEM"<?php if ($FormFieldParty == "DEM") { echo " SELECTED"; } ?>>Democratic</OPTION>
										<OPTION VALUE="REP"<?php if ($FormFieldParty == "REP") { echo " SELECTED"; } ?>>Republican</OPTION>
										<OPTION VALUE="BLK"<?php if ($FormFieldParty == "BLK") { echo " SELECTED"; } ?>>No Affiliation</OPTION>
										<OPTION VALUE="GRE"<?php if ($FormFieldParty == "GRE") { echo " SELECTED"; } ?>>Green</OPTION>
										<OPTION VALUE="LBT"<?php if ($FormFieldParty == "LBT") { echo " SELECTED"; } ?>>Libertarian</OPTION>
										<OPTION VALUE="CON"<?php if ($FormFieldParty == "CON") { echo " SELECTED"; } ?>>Conservatives</OPTION>
										<OPTION VALUE="IND"<?php if ($FormFieldParty == "IND") { echo " SELECTED"; } ?>>Independence Party</OPTION>
										<OPTION VALUE="WOR"<?php if ($FormFieldParty == "WOR") { echo " SELECTED"; } ?>>Working Families</OPTION>
										<OPTION VALUE="WEP"<?php if ($FormFieldParty == "WEP") { echo " SELECTED"; } ?>>Women's Equality Party</OPTION>
										<OPTION VALUE="REF"<?php if ($FormFieldParty == "REF") { echo " SELECTED"; } ?>>Reform</OPTION>
										<OPTION VALUE="SAM"<?php if ($FormFieldParty == "SAM") { echo " SELECTED"; } ?>>SAM</OPTION>													
										<OPTION VALUE="OTH"<?php if ($FormFieldParty == "OTH") { echo " SELECTED"; } ?>>Other</OPTION>
									</SELECT>
								</dd>
							</dl>
						</div>

						<div>						
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Assembly District</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Assembly District" name="AD" VALUE="<?= $RetReturnAD ?>" id="">
								</dd>
							</dl>

							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Electoral District</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Electoral District" name="ED" VALUE="<?= $RetReturnED ?>" id="">
								</dd>
							</dl>					
						</div>
								
						<div>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Congressional District</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Congressional District" name="Congress" VALUE="<?= $FormFieldCongress ?>" id="">
								</dd>
							</dl>
						</div>

						<div>						
							<dl class="form-group col-12 d-inline-block"> 
								<dd>
									<button type="submit" class="btn btn-primary mobilemenu">Search Voter Registration</button>
								</dd>
							</dl>
						</div>
					</form> 

	<div class="Box">
  	<div class="Box-header pl-0">
    	<div class="table-list-filters d-flex">
  			<div class="table-list-header-toggle states flex-justify-start pl-3">Building Addresses</div>
  		</div>
    </div>
    
    <?php if ( $VerifVoter == true) {  ?>
			    <div class="Box-body text-center py-6 js-collaborated-repos-empty">
			      Before you can organise your voter list, 
			    	<a href=/lgd/<?= $k ?>/profilevoter">you need to verify your voter information</a> so we can figure which list to list.
			    </div>
			<?php } ?>
    
  
		<div id="voters" >
			
			
<?php

			$Counter = 0;
			if ( ! empty ($Electors)) {
				foreach ($Electors as $Address => $Elector) {
					if ( ! empty ($Address)) { ?>
						<div class="list-group-item filtered f60 hundred">
							<A CLASS="pad40" HREF="<?= $k ?>/open"><i class="fas fa-folder handle"></i></A>							
							
							
							<?php /* INPUT TYPE="checkbox" NAME="SelectAllAddresses" VALUE="<?= $Address ?>">&nbsp;&nbsp;
							<button class="accordeonbutton" id="<?= $Counter++ ?>">Open</button>	
							*/ ?>
							<span><B><?= $Address ?></B></span>  	          			
						</div>
<?php /*							
					 <DIV class="panels">
<?php				foreach ($Elector as $Elect) {
					 		if (! empty ($Elect)) { ?>
								<div class="list-group-item f60"><?php
									?>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-arrows-alt handle"></i>&nbsp;&nbsp;<?php
									?><INPUT TYPE="checkbox" NAME="CreateID[]" VALUE="<?= $Elect["Elector_ID"] ?>">&nbsp;&nbsp;<?php
									?><svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg><?php
									?>&nbsp;<?= $Elect["Elector_FullName"] ?><?php
									?><span class="ml-1"><?= $Elect["Elector_Address"] ?></span> <?php
									?><svg class="octicon octicon-repo mr-1" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg><?php
									?>Petition <a class="mr-1" href="/lgd/petitions/organize/">#<?= $Elect["Petition_ID"] ?></a><?php		
								?></div>			
<?php					}	 
						} ?>
						</DIV>
						*/ ?>
						
						
<?php			}
				}
			} ?>
	 
		</div>
	</div>
</div>

</div>
</DIV>
</DIV>



<script async type="text/javascript" src="/external/Sortable/Sortable.js"></script>    
  
<script>
	// Default SortableJS
	//import Sortable from 'sortablejs';

	// Core SortableJS (without default plugins)
	// import Sortable from 'sortablejs/modular/sortable.core.esm.js';

	// Complete SortableJS (with all plugins)
	// import Sortable from 'sortablejs/modular/sortable.complete.esm.js';
	
	var voters = document.getElementById('voters');	
	
	new Sortable(voters, {
		animation: 150,
		// handle: '.handle', // handle's class
		ghostClass: 'blue-background-class',
		//filter: '.filtered'
	});
	
	
	console.log("Console ... \n");
	


</script>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
