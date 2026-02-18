<?php
  $Menu = "profile";
  $BigMenu = "profile";

  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }

  if ( ! empty ($_POST)) {  
    if ( empty ($_POST["DataState_ID"]) || empty ($_POST["ElectionsPosition_ID"])) {
      $error_msg = "You must chose a state and a position";
    } else { 
      WriteStderr($_POST, "Post in ProfileCandidate.php");
      header("Location: /" . CreateEncoded ([
        "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
        "FirstName" => $URIEncryptedString["FirstName"], 
        "LastName" => $URIEncryptedString["LastName"],
        "PositionID" => $_POST["ElectionsPosition_ID"],
        "DataStateID" => $_POST["DataState_ID"],
        "DateElection" => $_POST["ElectionDate"],
      ]) . "/lgd/profile/candidate/runposition");
      exit();
    }
  }

  $rmb = new repmyblock();
  if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}
  $Party = PrintPartyAdjective($URIEncryptedString["UserParty"]);

  $rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);
  $rmbcandprof = $rmb->ListProfilesForCandidates($URIEncryptedString["SystemUser_ID"]);
  WriteStderr($rmbperson, "RMBPerson");
   
	$rmbelectdates = $rmb->ListAllElectionsDates(true);
	$rmbpositions = $rmb->ListAllPositions();

  WriteStderr($Position, "Positions order");
  $TopMenus = [
          ["k" => $k, "url" => "profile/user", "text" => "Public Profile"],
          ["k" => $k, "url" => "profile/voter/card", "text" => "Voter Profile"], 
          ["k" => $k, "url" => "profile/candidate/public", "text" => "Candidate Profile"],
          ["k" => $k, "url" => "profile/team/section", "text" => "Team Profile"]
       ];
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
  if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>



  <div class="row layout">
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
      <div class="main">
        <div class="col-full">
          <div class="Subhead">
            <h2 class="Subhead-heading">Candidate Profile</h2>
          </div>

        <?php PlurialMenu($k, $TopMenus); ?>
   
        <DIV class="clearfix gutter d-flex ">
          
          <FORM ACTION="" METHOD="POST">
        
            <DIV class="row">
              <DIV class="main">
                
                <DIV class="f60">
                  <B>Current defined profiles:</B>
                  <UL>
<?php                if (! empty ($rmbcandprof)) {
                    foreach ($rmbcandprof as $var) {
                      if (! empty ($var)) { 
?>
									

                    <LI>
                      <A HREF="/<?= MergeEncode([	                                  
	                                       "PublicProfileID" => $var["PublicProfile_ID"]
	                              ]) ?>/lgd/profile/candidate/updatecandidateprofile"><?= $var["Elections_Text"]  . " - " . $var["CandidateElection_Text"] ?></A>
                      Team ID: <?= $var["Team_ID"] ?> <?php /*<PRE><?= print_r($var) ?></PRE> */ ?>
                      
                    </LI>
<?php                 }
                    }              
                  } 
?>
                  </UL>        
                </DIV>
              
                <P class="f40">
                  <B>
                    <FONT COLOR=BROWN>If you are a candidate for higher office, please 
                    follow the instructions on</FONT>
                      <A TARGET="pdfguide" HREF="<?= $FrontEndStatic ?>/shared/instructions/01-SetupYourCandidateProfile.pdf">this guide
                      starting page 9</A>
                    <FONT COLOR=BROWN>to enable all the codes for the other positions.</FONT>
                  </B>
                </P>
                             
                 
                <DIV class="f40 Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
                  We don't know your district <a href="/voter">create one</a>?
                </DIV>
              
           

                <div class="voter-form">
                  <div class="field autocomplete">
                    <input id="StateName" class="input" type="text" name="StateName" placeholder=" " autocomplete="off">
                    <label for="StateName">State</label>
                    <div id="stateSuggestions" class="suggestions hidden"></div>
                  </div>

                  <div class="field autocomplete">
                    <input id="Position" class="input" type="text" name="Position" placeholder=" " autocomplete="off">
                    <label for="Position">Position</label>
                    <div id="positionSuggestions" class="suggestions hidden"></div>
                  </div>

                  <div id="manualPositionModal" class="modal hidden">
                    <div class="modal-content">
                      <h3>Enter position manually</h3>
                      <textarea id="manualPositionText" rows="4" placeholder="Please describe the position…"></textarea>
                      <div class="modal-actions">
                        <button type="button" id="manualCancel">Cancel</button>
                        <button type="button" id="manualSave">Save</button>
                      </div>
                    </div>
                  </DIV>
                   
                  <div class="field">
                    <input type="date" id="ElectionDate" class="input" name="ElectionDate" placeholder=" ">
                    <label for="ElectionDate">Election Date</label>
                  </div>
                          
                            
                  <DIV class="">
                    <INPUT class="f60bold" TYPE="Submit" NAME="SaveInfo" VALUE="Run for the position">
                  </DIV>

                  <input type="hidden" id="DataState_ID" name="DataState_ID">
                  <input type="hidden" id="ElectionsPosition_ID" name="ElectionsPosition_ID">
                </DIV>
              </DIV>
            </DIV>
          </form>  
        </DIV>
      </DIV>
    </DIV>
  </DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>
    <script>
      const rmbelectdates = <?php echo json_encode($rmbelectdates, JSON_UNESCAPED_UNICODE); ?>;
      const rmbpositions  = <?php echo json_encode($rmbpositions, JSON_UNESCAPED_UNICODE); ?>;
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/js/candidateselection.js";  ?>
    </script>
  </body>
</HTML>