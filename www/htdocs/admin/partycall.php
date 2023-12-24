<?php
	$Menu = "admin";
	$BigMenu = "represent";	

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	

	// Reset
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_admin.php";	
	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	
	$TopMenus = array ( 						
		array("k" => $k, "url" => "../admin/partycall", "text" => "Party Call"),
		array("k" => $k, "url" => "../admin/partycalladd", "text" => "Update Positions")
	);

	$rmb = new RMBAdmin(0);
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	
	if ( ! empty ($_POST)) {
		WriteStderr($_POST, "$_POST");	
		
		$FormFieldDTTAble = trim($_POST["DTTable"]);
		$FormFieldDTValue = trim($_POST["DTValue"]);
		$FormFieldParty = trim($_POST["Party"]);

	 	$ListPartyCall = $rmb->PartyCallInfo($FormFieldParty, $CurrentElectionID, $FormFieldDTTAble, $FormFieldDTValue); 	
		WriteStderr($ListPartyCall, "ListPartyCall");	
	}

	if ( ! empty ($ListPartyCall) ) {
		foreach ($ListPartyCall as $var) {
			if ( ! empty ($var) ) {
				$TotalCandidate += $var["ElectionsPartyCall_NumberUnixSex"];
			}
		}
	}

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";		
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left col-full">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 class="Subhead-heading">Party Call</h2>
				</DIV>
				<?php	PlurialMenu($k, $TopMenus); ?>   
			  <div class="clearfix gutter">
			  	<div class="row">
				  <div class="main">
			  	
			  		<DIV>
				<P class="f40">
		   		 <B>Current Settings:</B> <?= $ActiveTeam ?>
		   		 
		   	<?php WriteStderr($ListTeamNames, "List of name inside the code that are not appearing."); ?>

     	</P>
			</DIV>

				<FORM ACTION="" METHOD="POST">
					
						<div class="Box">
					  	<div class="Box-header pl-0">
					    	<div class="table-list-filters d-flex">
					  			<div class="table-list-header-toggle states flex-justify-start pl-3 f60">Party Call</B></div>
					  		</div>
					    </div>
					    
					    
							
						<div class="Box-body js-collaborated-repos-empty">
							<div class="flex-items-left">	
								<span class="ml-0 flex-items-baseline ">
									
							 <DIV>
							<dl class="form-group col-3 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">DTTable</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="DTTable" name="DTTable" VALUE="<?= $FormFieldDTTAble ?>" id="">
								</dd>
							</dl>
							
							<dl class="form-group col-3 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">DTValue</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="DTValue" name="DTValue" VALUE="<?= $FormFieldDTValue ?>" id="">
								</dd>
							</dl>
							
							<dl class="form-group col-3 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Party</label><DT>
								<dd>
									<SELECT  class="mobilebig" NAME="Party">
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
							
							<dl class="form-group col-3 d-inline-block"> 
								<dd>
									<button type="submit" class="submitred">Search User</button>
								</dd>
							</dl>
						</DIV>
								<DIV class="f40">
									<div id="resp-table">
										<div id="resp-table-header">
											<div class="table-header-cell">Party</div>
											<div class="table-header-cell">County</div>
											<div class="table-header-cell">Type</div>
											<div class="table-header-cell">District</div>
											<div class="table-header-cell">Candidates</div>
											<div class="table-header-cell">Status</div>
											<div class="table-header-cell">Sigs.</div>
											<div class="table-header-cell">Done</div>
											<div class="table-header-cell">&nbsp;</div>
										</div>

									<div id="resp-table-body">
										<div class="resp-table-row">
											<div class="table-body-cell"></div>
											<div class="table-body-cell"></div>
											<div class="table-body-cell"></div>
											<div class="table-body-cell"></div>
											<div class="table-body-cell"><?= $TotalCandidate ?></div>
											<div class="table-body-cell"></div>
											<div class="table-body-cell"></div>
											<div class="table-body-cell"></div>
											<div class="table-body-cell">
											</div>
										</div>													
									</div>						
															
									<?php 
			if ( ! empty ($ListPartyCall) ) {
				foreach ($ListPartyCall as $var) {
					if ( ! empty ($var) ) {
					
						$NewKEncrypt = CreateEncoded(array(
														"CandidatePetitionSet_ID" => $var["CandidatePetitionSet_ID"],	
														"Candidate_ID" => $var["Candidate_ID"],	
														"PendingBypass" => "yes"								
													));
		
						#	$style = "color:brown;style:bold;background-color:lightgrey;font-weight: bold;";
						if ( ! empty ($var["CandidateElection_DBTable"])) {
							preg_match('/(\d{2})(\d{3})/', $var["CandidateElection_DBTableValue"], $District, PREG_OFFSET_CAPTURE);
						}							
		?>
										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><?= $var["ElectionsPartyCall_Party"] ?></div>
												<div class="table-body-cell"><?= $var["DataCounty_Name"] ?></div>
												<div class="table-body-cell"><?= $var["ElectionsPartyCall_DBTable"] ?></div>
												<div class="table-body-cell"><?= $var["ElectionsPartyCall_DBTableValue"] ?></div>
												<div class="table-body-cell"><?= $var["ElectionsPartyCall_NumberUnixSex"] ?></div>
												<div class="table-body-cell"><?= $var["CandidatePositions_ID"] ?></div>
												<div class="table-body-cell">0</div>
												<div class="table-body-cell">0</div>
												<div class="table-body-cell">
												</div>
											</div>													
										</div>									
								<?php }
									} 		
								} 
							?>

							</DIV>
	</DIV>
	</DIV>
</DIV>

</DIV>
</DIV>
</DIV>
				</DIV>

		</DIV>
</FORM>

	</DIV>

	</DIV>



<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>