<?php
  $Menu = "profile";
  $BigMenu = "profile";

  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }

  if ( ! empty ($_POST)) {
    $Encrypted_URL = $Decrypted_k;
    foreach ($_POST["PositionRunning"] as $var) {
      $Encrypted_URL .= "&Position[]=" . $var;
    }
    
    WriteStderr($_POST, "Post in ProfileCandidate.php");
    header("Location: /" . rawurlencode(EncryptURL($Encrypted_URL)) . "/lgd/profile/runposition");
    exit();
  }

  $rmb = new repmyblock();
  if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}
  $Party = PrintPartyAdjective($URIEncryptedString["UserParty"]);

  $rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);
  WriteStderr($rmbperson, "RMBPerson");
  
  $rmbcandidate = $rmb->ListCandidateInformationByUNIQ($rmbperson["Voters_UniqStateVoterID"]);
  WriteStderr($rmbcandidate, "RMBElectoral");
  
  if ( ! empty ($rmbcandidate)) {
	  foreach ($rmbcandidate as $var) {
	  	if (! empty ($var)) {
		  $PositionRunning[$var["Elections_ID"]][$var["CandidateElection_DBTable"]] = 
		  				array ("Candidate_ID" => $var["Candidate_ID"], "CandidateProfile_ID" => $var["CandidateProfile_ID"]);
  		}
  	}
  }	
 
  if ( ! empty ($rmbperson["Voters_UniqStateVoterID"])) {
  	 	  	
  	if ( $rmbperson["SystemUser_Priv"] & PERM_OPTION_ALLPOS ) {
      $rmbelectoral = $rmb->ListElections();
    } else {
    	$rmbelectoral = $rmb->ListElections("ADED");
    }
    
		WriteStderr($rmbelectoral, "RMBElectoral");
 
   	foreach ($rmbelectoral as $var) {
   		$SaveField = 0;
   		
   		switch ($var["ElectionsPosition_Type"]) {
   			case "party":
   				if ($var["ElectionsPosition_Party"] == $rmbperson["SystemUser_Party"]) {
   					$SaveField = 1;
   				}
   				break;
   				
   			case "office":
   				$SaveField = 1;
   				break;
   		}
   			
 			if ( $SaveField == 1) {
		 		$Position[$var["DataState_Name"]][$var["Elections_Date"]][$var["ElectionsPosition_Type"]]
 									[$var["ElectionsPosition_Party"]][$var["ElectionsPosition_Name"]] = 
						   			$var["ElectionsPosition_Explanation"];
				$ElectionID[$var["DataState_Name"]][$var["Elections_Date"]][$var["ElectionsPosition_Type"]]
 									[$var["ElectionsPosition_Party"]][$var["ElectionsPosition_Name"]] = 
						   			array("ElectionsPosition_ID" => $var["ElectionsPosition_ID"], 
						   						"Elections_ID" => $var["Elections_ID"],
						   						"DBTable" => $var["ElectionsPosition_DBTable"],
						   						"Order" => $var["ElectionsPosition_Order"]						   						
						   			);
			}
		}
		$URLinput = "updatecandidateprofile";
  } else {
    $Position[""][""]["County/Prescint Committee"][""]["COUNTY"] = 
					   			"The party is governed by committees of citizens who are registered in the party, " . 
					   			"from the national level down to state and community-level. County precints or committes " .
					   			"the most local level of party governance.";
		$URLinput = "input";
  }
  
  
  WriteStderr($Position, "Positions order");
  $TopMenus = array (
            array("k" => $k, "url" => "profile/user", "text" => "Public Profile"),
            array("k" => $k, "url" => "profile/profilevoter", "text" => "Voter Profile"),
            array("k" => $k, "url" => "profile/profilecandidate", "text" => "Candidate Profile"),
            array("k" => $k, "url" => "profile/profileteam", "text" => "Team Profile")
          );
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
  if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>
  <DIV class="row">
    <DIV class="main">
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
      <DIV class="<?= $Cols ?> float-left">

        <!-- Public Profile -->
        <DIV class="Subhead mt-0 mb-0">
          <H2 id="public-profile-heading" class="Subhead-heading">Candidate Profile</H2>
        </DIV>
        <?php PlurialMenu($k, $TopMenus); ?>
   
        <DIV class="clearfix gutter d-flex ">
        	
        	<FORM ACTION="" METHOD="POST">
        
          <DIV class="row">
          	<DIV class="main">

							<P class="f40">
                <B>
                  <FONT COLOR=BROWN>If you are a candidate for higher office, please send an email to</FONT> 
                  <A HREF="mailto:candidate@repmyblock.org" TARGET="MoreCandidate">candidate@repmyblock.org</A> 
                  <FONT COLOR=BROWN>to get the access code for the other positions.</FONT>
                </B>
            	</P>
                         	
		      	 	
             	<DIV class="f40 Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
    	        	We don't know your district <a href="/voter">create one</a>?
             	</DIV>
             						
            	<P>
            		<DIV class="list-group-item f60">
            			
            			
								<?php 
									if (! empty ($Position)) {
										
										foreach ($Position as $State => $Positions) {	?>
                  <P class="f80">Positions available for these elections to run for in the <?= $State ?> state.
                  	<p class="f70">If a position is missing, please email <A HREF="mailto:candidate@repmyblock.org" TARGET="MoreCandidate">candidate@repmyblock.org</A> 
                  	and we will add it.
                  </P>
                  	</P>     
                
									<?php
									array_multisort($Positions);
									foreach ($Positions as $Date => $PartyArray) {
										if (! empty ($Date) ) { ?>
											<P class="f80"><U><B>Election scheduled <?= PrintShortDate($Date) ?></B></U></P>
											<?php }
											foreach ($PartyArray as $Position=> $PositionArray) {
												// if (! empty ($PartyArray) ) {	print "<B>" . $Party . "</B><BR>";	}
												foreach ($PositionArray as $Party => $Party2Array) {
												
													foreach ($Party2Array as $PositionName => $Explain) {
														if (! empty ($Party2Array) ) { 

															$ElectProfileID = $PositionRunning[$ElectionID[$State][$Date][$Position][$Party][$PositionName]["Elections_ID"]]
																																			[$ElectionID[$State][$Date][$Position][$Party][$PositionName]["DBTable"]];
																																			
											
															$PositionFullName = "";
															if ( ! empty ($Party)) {	$PositionFullName = PrintPartyAdjective($Party) ." Party ";	} 
															$PositionFullName .= $PositionName;
															?>
															<P>
															
															<B>
															
															<?php if (! empty ($ElectProfileID)) { ?>
																<LI><FONT COLOR="BROWN">You are running for</FONT> <?= $PositionFullName ?><UL>
															<?php } else { ?>
																<UL><LI><?= $PositionFullName ?>
															<?php } ?>
															</B>
															
															<P><I><?= $Explain ?></I></P>
											
															<?php if (! empty ($ElectProfileID)) { ?>
																<B><A HREF="/<?= CreateEncoded ( array( 
																		"SystemUser_ID" => $rmbperson["SystemUser_ID"],
																		"ElectionsPosition_ID" => $ElectionID[$State][$Date][$Position][$Party][$PositionName]["ElectionsPosition_ID"],
																		"Elections_ID" => $ElectionID[$State][$Date][$Position][$Party][$PositionName]["Elections_ID"],
																		"VoterUniqID" => $rmbperson["Voters_UniqStateVoterID"],
																		"Party" => $Party,
																		"PositionFullName" => $PositionFullName,
																		"Position" => $Position,
																		"PositionName" => $PositionName,
																		"PositionOrder" => $ElectionID[$State][$Date][$Position][$Party][$PositionName]["Order"],
																		"DBTable" => $ElectionID[$State][$Date][$Position][$Party][$PositionName]["DBTable"],
																		"CandidateProfileID" => $ElectProfileID["CandidateProfile_ID"],
																		"Candidate_ID" => $ElectProfileID["Candidate_ID"],
																)); ?>/lgd/profile/<?= $URLinput ?>">Update for <?= $PositionFullName ?></A></B>				
																																				
															<?php } else { ?>
																<B><A HREF="/<?= CreateEncoded ( array( 
																			"SystemUser_ID" => $rmbperson["SystemUser_ID"],
																			"ElectionsPosition_ID" => $ElectionID[$State][$Date][$Position][$Party][$PositionName]["ElectionsPosition_ID"],
																			"Elections_ID" => $ElectionID[$State][$Date][$Position][$Party][$PositionName]["Elections_ID"],
																			"VoterUniqID" => $rmbperson["Voters_UniqStateVoterID"],
																			"Party" => $Party,
																			"PositionFullName" => $PositionFullName,
																			"Position" => $Position,
																			"PositionName" => $PositionName,
																			"PositionOrder" => $ElectionID[$State][$Date][$Position][$Party][$PositionName]["Order"],
																			"DBTable" => $ElectionID[$State][$Date][$Position][$Party][$PositionName]["DBTable"],
																)); ?>/lgd/profile/<?= $URLinput ?>">Run for <?= $PositionFullName ?></A></B>
															
															
															<?php } ?>
															</UL>
															</P>					
															<?php  
														}    
													}
												}
											}
										} ?>
										
										
								</DIV>
								<?php }	
							} else {
								
								?>
								
								The positions are not yet defined for this election cycle.<BR>
								Send an email to <A HREF="mailto:candidate@repmyblock.org" TARGET="MoreCandidate">candidate@repmyblock.org</A>
								to get added to the mailing list.
								
							<?php } ?>
										
								</DIV>
		
	             
	             	</FORM>
	            </DIV>
	          </DIV>
	        </DIV>
	      </DIV>
	    </DIV>
	  </DIV>
	</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>
