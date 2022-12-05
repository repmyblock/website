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
  $rmbcandidate = $rmb->ListCandidateInformation($URIEncryptedString["SystemUser_ID"]);
  $result = $rmb->ListElectedPositions($rmbperson["DataState_Abbrev"]);
  
  WriteStderr($rmbperson, "User");
  WriteStderr($rmbcandidate, "RMBCandidate");
  WriteStderr($result, "Positions order");
  
  if (! empty($result)) {
    foreach($result as $var) {
      if (! empty ($var)) {
        $Position[$var["ElectionsPosition_Type"]][$var["ElectionsPosition_Name"]][$var["ElectionsPosition_Party"]]["Desc"] = $var["ElectionsPosition_Explanation"];
        $Position[$var["ElectionsPosition_Type"]][$var["ElectionsPosition_Name"]][$var["ElectionsPosition_Party"]]["ID"] = $var["ElectionsPosition_ID"];
        
        // This is a hack to not repeat the the position.   
        if ( ! empty ($rmbcandidate)) {
	        foreach ($rmbcandidate as $vor) {
  	        if ($vor["CandidateElection_DBTable"] == $var["ElectionsPosition_DBTable"] && $vor["CandidateGroup_Party"] == $var["ElectionsPosition_Party"]) {
    	        $Position[$var["ElectionsPosition_Type"]][$var["ElectionsPosition_Name"]][$var["ElectionsPosition_Party"]]["NOTSHOW"] = $vor["Candidate_ID"];
      	    }  
        	}
        }
      }
    }
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
                    <A HREF="mailto:candidate@repmyblock.org">candidate@repmyblock.org</A> 
                    <FONT COLOR=BROWN>to access the omnibus petitions.</FONT>
                  </B>
              	</P>
                    
                <P class="f40"><B>Open positions to run for in the <?= $Party ?> Party</B></P>
                  <DIV class="f40 Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
                    We don't know your district <a href="/voter">create one</a>?
                  </DIV>  
                <P>
                                
<?php       
      $Counter = 0;
      if ( ! empty ($Position)) {

				if ( $rmbperson["SystemUser_Priv"] & PERM_OPTION_ALLPOS ) {
					
				  foreach ($Position as $PartyPosition => $Positions) {
	          //if ( ! empty ($PartyPosition)) {
	            if ( $PartyPosition == "party") { ?>
	                    <DIV class="list-group-item filtered f60">
	                      <SPAN><B><?= ucfirst($PartyPosition) ?></B></SPAN>                         
	                    </DIV>
	                    
	                    <DIV class="list-group-item f60">
	                    
	<?php
	 					
	            // rmbperson["SystemUser_Priv"]
	             //if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_PLEDGES )
	            
	            foreach ($Positions as $Pos => $Explain) {
	               if (! empty ($Pos) ) { 
	              	
	               	 if (empty ($Explain[$URIEncryptedString["UserParty"]]["NOTSHOW"])) { 
	                    $ShowRunForSelected = 1;
	                    ?>
	                    <INPUT TYPE="checkbox" NAME="PositionRunning[]" VALUE="<?= $Explain[$URIEncryptedString["UserParty"]]["ID"] ?>"><?php 
	                  } else { 
	                    ?>&nbsp;&nbsp;&nbsp;<?php /* <A HREF="/<?= $k ?>/lgd/downloads/downloads">Go to the download page to get the petition.</A> */  
	                  } ?>&nbsp;&nbsp;<B><?= $Pos ?></B><?php 
	                 
	                   if (! empty ($Explain[$URIEncryptedString["UserParty"]]["NOTSHOW"])) { ?>                    
	                      <BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="/<?= CreateEncoded ( array( 
	                                          "SystemUser_ID" => $rmbperson["SystemUser_ID"],
	                                          "Candidate_ID" => $Explain[$URIEncryptedString["UserParty"]]["NOTSHOW"],
	                                          "FileNameName" => $rmbcandidate[0]["Candidate_DispName"],    
	                                          "FileNameStateID" => $rmbcandidate[0]["Candidate_UniqStateVoterID"],  
	                                        )); ?>/lgd/profile/updatecandidateprofile">Update your <?= $Pos ?> candidate profile</A>
	                  <?php } ?>
	    									<P class="f40 pad-3"><?= $Explain[$URIEncryptedString["UserParty"]]["Desc"] ?></P>
	                   
	<?php          	}    
								}
								
								echo "</DIV>\n";
								
																
            } 
        	}
      } else { ?>
   
    	
			
			 <DIV class="list-group-item filtered f60">
        <SPAN><B>Party</B></SPAN>                         
      </DIV>
      
	     <DIV class="list-group-item f60">
	     	
	     	<?php
	     if (empty ($Position["party"]["County Committee"][$URIEncryptedString["UserParty"]]["NOTSHOW"])) { 
	                    $ShowRunForSelected = 1;
	                    ?>
	                    <INPUT TYPE="checkbox" NAME="PositionRunning[]" VALUE="<?= $Position["party"]["County Committee"][$URIEncryptedString["UserParty"]]["ID"] ?>"><?php 
	                  } else { 
	                    ?>&nbsp;&nbsp;&nbsp;<?php /* <A HREF="/<?= $k ?>/lgd/downloads/downloads">Go to the download page to get the petition.</A> */  
	              } ?>
	                  &nbsp;&nbsp;<B>County Committee</B><?php 
	                 
	                   if (! empty ($Position["party"]["County Committee"][$URIEncryptedString["UserParty"]]["NOTSHOW"])) { ?>                    
	                      <BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="/<?= CreateEncoded ( array( 
	                                          "SystemUser_ID" => $rmbperson["SystemUser_ID"],
	                                          "Candidate_ID" => $Position["party"]["County Committee"][$URIEncryptedString["UserParty"]]["ID"],
	                                          "FileNameName" => $rmbcandidate[0]["Candidate_DispName"],    
	                                          "FileNameStateID" => $rmbcandidate[0]["Candidate_UniqStateVoterID"],  
	                                        )); ?>/lgd/profile/updatecandidateprofile">Update your County Committee candidate profile</A>
	                  <?php  } ?><P class="f40 pad-3"><?= $Position["party"]["County Committee"][$URIEncryptedString["UserParty"]]["Desc"] ?></P>
	                   
	
	     	
					
<?php     }
?>                  
		</P>
    <?php 

    if ( $ShowRunForSelected == 1 ) { ?>
    	      <P><BUTTON type="submit" class="submitred">Run for the selected positions</BUTTON></p> 
   <?php } 
   
    } ?>
             </FORM>
             </DIV>
              </DIV>
            </DIV>
          </DIV>
        </DIV>
      </DIV>
    </DIV>
  </DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>
