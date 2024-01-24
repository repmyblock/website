<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "objections";
	// $BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_objections.php";	
	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	
	if (! empty ($URIEncryptedString["CurrentSelectDate"])) {
		$CurrentSelectDate = $URIEncryptedString["CurrentSelectDate"];
	}
	
	$rmb = new Objections();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$objections = $rmb->ListOjbections($SystemUser_ID);
	
	//$result = $r->GetSignedElectors($Candidate_ID);
	$EncryptURL = EncryptURL("CandidateID=" . $Candidate_ID . "&PetitionSetID=" . $CandidatePetitionSet_ID);
	
	$TopMenus = array ( 
		array("k" => $k, "url" => "team/index", "text" => "Team Members"),
		array("k" => $k, "url" => "team/teampetitions", "text" => "Manage Petitions"),
		array("k" => $k, "url" => "team/teamcandidate", "text" => "Setup Teams")
	);			
	WriteStderr($TopMenus, "Top Menu");		
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";		
	if ( $MobileDisplay == true) {	 $Cols = "col-12"; $SizeField = " SIZE=10"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left col-full">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 class="Subhead-heading">Objections management</h2>
				</DIV>
				<?php	PlurialMenu($k, $TopMenus); ?>   
			  <div class="clearfix gutter">
			  	<div class="row">
				  <div class="main">
			  	
			  		<DIV>
				<P class="f40">
		   		 
		   	<?php WriteStderr($ListTeamNames, "List of name inside the code that are not appearing."); ?>

     	</P>
			</DIV>

						<div class="Box">
					  	<div class="Box-header pl-0">
					    	<div class="table-list-filters d-flex">
					  			<div class="table-list-header-toggle states flex-justify-start pl-3 f60">Petitions objections</B></div>
					  		</div>
					    </div>
	
					
								
							<div class="Box-body js-collaborated-repos-empty">
								<div class="flex-items-left">	
									<span class="ml-0 flex-items-baseline ">
										
											
									<h2>Ojections in progress</H2>
									<P CLASS="f60">
							
										<A HREF="createobjection">Create an objection</A></P>
																	
										<DIV class="p40">
										<TABLE BORDER=1>
											<TR>
											
												<TH class="table-header-cell">Volume ID</TH>
												<TH class="table-header-cell">Sheets</TH>
												<TH class="table-header-cell">Total Sigs.</TH>
												<TH class="table-header-cell">Sigs. Needed</TH>
												<TH class="table-header-cell">% in limbo</TH>
												<TH class="table-header-cell">&nbsp;</TH>
											</TR>
											
											

									
									<?php 
											if ( ! empty ($objections) ) {
												foreach ($objections as $var) {
													if ( !empty($var)) { 
																						?>
				
				<TR>
					
						<TD style="padding:0px 10px;"><?= $var["Objections_VolumeID"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["Objections_SheetsNumber"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["Objections_PetitionSigs"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["Objections_SigsNeeded"] ?></TD>
						<TD style="padding:0px 10px;">&nbsp;</TD>
						
						<TD style="padding:0px 10px;"><A HREF="/<?= MergeEncode(array(
																	"Objections_ID" => $var["Objections_ID"] , 
																)); 
																?>/lgd/objections/addvoter">update</A></TD>
				</TR>
				
								<?php } 
							}   
										
										} else {
							?>
								<TR><TD COLSPAN=6 ALIGN=CENTER><BR>No objections have been defined for this election<BR>&nbsp;<BR></TD></TR>
							<?php } ?>
						</TABLE>
						</P>		</DIV>
	</DIV>
	</DIV>
</DIV>

</DIV>
</DIV>
</DIV>
				</DIV>

		</DIV>


	</DIV>

	</DIV>



					
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>