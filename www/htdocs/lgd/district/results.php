<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_district.php";  

	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}
	$rmb = new RMBdistrict();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$Party = PrintParty($URIEncryptedString["UserParty"]);
	
	$result = $rmb->ListResultsByEDAD(intval($rmbperson["DataDistrict_StateAssembly"]), intval($rmbperson["DataDistrict_Electoral"]) );
	WriteStderr($result, "Candidates in the Loop");

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Election Results</h2>
			  </div>
     
				<?php	PlurialMenu($k, $TopMenus); ?>   

			  <div class="clearfix gutter d-flex flex-shrink-0">

				<div class="row">
				  <div class="main">
						<FORM ACTION="" METHOD="POST">
						<div class="Box">
					  	<div class="Box-header pl-0">
					    	<div class="table-list-filters d-flex">
					  			<div class="table-list-header-toggle states flex-justify-start pl-3">Results for 
					  				<B>AD <?= $result[0]["DataDistrict_StateAssembly"] ?></B> and
					  				<B>ED	<?= $result[0]["DataDistrict_Electoral"] ?></B></div>
					  		</div>
					    </div>
				    
					    <div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
					      We don't know your district <a href="/voter">create one</a>?
					    </div>

							<?php 			
										$Counter = 0;
										if ( ! empty ($result)) {
										?>
								<div class="flex-items-left">	
								
									
									<span class="ml-4 flex-items-baseline">
										
										
							<TABLE BORDER=1>
										<TR>
											<TH style="padding:0px 10px;">Date</TH>
											<TH style="padding:0px 10px;">Election</TH>
											<TH style="padding:0px 10px;">Race</TH>
											<TH style="padding:0px 10px;">Votes</TH>
											<TH style="padding:0px 10px;">Total</TH>
											<TH style="padding:0px 10px;">Manual</TH>
											<TH style="padding:0px 10px;">Absentee</TH>
											<TH style="padding:0px 10px;">Affid</TH>
											<TH style="padding:0px 10px;">Write</TH>
										</TR>
										
										
									
									
									<?php 
										foreach ($result as $var) { 
											
											if ( $var["TeamMember_Active"] == "no") {
												$style = "color:brown;style:bold;background-color:lightgrey;font-weight: bold;";
											} else {
												$style = "text-align:left";
											}
									
									if ( ! empty ($var["ElectResult_ID"])) {
									
									if ( $var["CandidateElection_ID"] != $PrevElectionID) {
									
									
								if ( ! empty ($firsttime) ) { ?>
									
									<TR ALIGN=CENTER VALIGN=TOP>
										
										<TD style="padding:0px 10px;<?= $style ?>" COLSPAN=3>&nbsp</TD>
		
										<TD style="padding:0px 10px;text-align:right"><B><?= $result = intval($TotalVoted /  intval($var["CandidateElection_Number"])) ?></B></TD>
										

										<TD style="padding:0px 10px;<?= $style ?>"><?= $TotalCounter ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>"><B><FONT COLOR="BROWN"><?= $result - $TotalCounter ?></FONT></B></TD>
										
									</TR>
									
									
										<TR ALIGN=CENTER>
										<TD COLSPAN=9>&nbsp;</TD>
										</TR>
									<?php } 
									$firsttime = 1;
									
								
									
									
											
											?>
											
											
									
									
							
									
									
									
									<TR ALIGN=CENTER VALIGN=TOP>
										
										<TD style="padding:0px 10px;<?= $style ?>"><?= PrintDate($var["Elections_Date"]) ?>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["Elections_Type"] ?>
																				
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["CandidateElection_Text"] ?>
											<?php if ($var["CandidateElection_Number"] > 1) { echo "<I>(Vote for " . $var["CandidateElection_Number"]. ")</I>"; } ?>
										</td>
		
										<TD style="padding:0px 10px;<?= $style ?>">&nbsp;</TD>
										

										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["ElectResultAdmin_PubCounter"] ?>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["ElectResultAdmin_ManualEmerg"] ?>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["ElectResultAdmin_AbsMili"] ?>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["ElectResultAdmin_Affidavit"] ?>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["ElectResultAdmin_Scattered"] ?>
									</TR>
									
									
									<?php 
												$TotalCounter = $var["ElectResultAdmin_PubCounter"] + $var["ElectResultAdmin_ManualEmerg"] + $var["ElectResultAdmin_AbsMili"]
																				+ $var["ElectResultAdmin_Affidavit"];
												$TotalVoted = 0;
									
												$PrevElectionID = $var["CandidateElection_ID"];
												
									} ?>
									
									<TR>
										
										<TD style="padding:0px 10px;<?= $style ?>">&nbsp;</TD>
										<TD style="padding:0px 10px;<?= $style ?>">&nbsp;</TD>
											<TD style="padding:0px 10px;text-align:right">
										<B><?= $var["Candidate_DispName"] ?></B> (<?= $var["Candidate_Party"] ?> <?= $var["Candidate_FullPartyName"] ?>)
									
										<TD style="padding:0px 10px;text-align:right"><?= $var["ElectResultCandidate_Count"] ?>
										<TD style="padding:0px 10px;text-align:right">
											
											<?php $TotalVoted += $var["ElectResultCandidate_Count"]; ?>
											
											
										</TD>										
										
										
									</TR>
										
										
										
										
										<?php /*
										<TH style="padding:0px 10px;"><A HREF="/<?=  CreateEncoded (
																												array( 
																													"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																													"Team_ID" => $_POST["Team_ID"],
																											    "TeamMember_ID" => $var["TeamMember_ID"]
																												)
																									); ?>/lgd/team/memberinfo"">Member Info</A></TH> */ ?>
									</TR>
									
								<?php } 
								
								}?>
								
								</TABLE>
																	
										
										
										
									
												
				

								
									
									
								</div>

							<?php
											
										} 
							?>

							</div>
			
					</div>
					</FORM>
			</div>
		</DIV>
	</DIV>
	</DIV>
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>