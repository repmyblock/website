<?php
  if ( ! empty ($k)) { $MenuLogin = "logged"; }
  $Menu = "admin";
  $BigMenu = "represent";  

  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_admin.php";

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}
  
  $rmb = new RMBAdmin();  
  $rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
   WriteStderr($rmbperson, "rmbperson");
  $result = $rmb->ListOnlyCandidates($URIEncryptedString["Candidate_ID"]);
   WriteStderr($result, "result");
	$resultprofile = $rmb->ListProfileFromCandidateID($URIEncryptedString["Candidate_ID"]);
   WriteStderr($resultprofile, "resultprofile");
   
  if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
  } else { $TypeEmail = "text"; $TypeUsername = "text"; }
  
  WriteStderr($var, "Voter Guide");
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";

?>

    <div class="row layout">
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
      <div class="main">
        <div class="col-full">
          <div class="Subhead">
            <h2 class="Subhead-heading">Candidates Maintenance</h2>
          </div>

          <div class="clearfix gutter d-flex flex-shrink-0">

            <div class="Box">
              
              
              <DIV>
              	
              
             
                   
             
<?php 
                      if (! empty ($result)) {
                        WriteStderr($result, "Voter Guide");
                        print "<br style=\"clear:both\" />";
                        $DateDesc = PrintShortDate($result["Elections_Date"]) . " - " . $result["Elections_Text"];
                        $PrevDateDesc = $DateDesc;
                        $PicturePath =  
                                      ((empty($result["CandidateProfile_PicFileName"])) ? 
                                      ((empty($result["Candidate_Party"]) || $result["Candidate_Party"] == "BLK") ? 
                                        "0000/NoPicture.jpg" :                             
                                        "0000/" . $result["DataState_Abbrev"] . "/" . $result["Candidate_Party"] . "_NoPic.jpg") : 
                                        ($result["CandidateProfile_PicFileName"] . "?" . $addtopics));
?>
                              
                <DIV>    
                  <P>
                    <DIV class="f80"><B><?= $result["Candidate_DispName"] ?></B></DIV>  
                  </P>      

                <DIV class='container2'>
                  <DIV>
                    <?php if (! empty ($result["CandidateProfile_Website"])) { ?><A TARGET="NEW" HREF="<?= $result["CandidateProfile_Website"] ?>"><?php } ?><IMG class="candidate" style="float: left; margin: 0px 15px 0px 15px;" SRC="/shared/pics/<?= $PicturePath ?>" class='iconDetails'><?php if (! empty ($var["CandidateProfile_Website"])) { ?></A><?php } ?>
                    <DIV class="f60"><B><?= $DateDesc ?></B></DIV>
                    <P class="f40" style="text-margin: 0px 0px 0px 0px;">
                      <I>Running for <?= $result["CandidateElection_PetitionText"] ?></I>
                      <?php if (! empty ($result["CandidateProfile_Statement"])) { print $var["CandidateProfile_Statement"]; }  ?>
                    </P>
                  </DIV>  
                  <br style="clear:both">
                      <DIV class='container3'>
                      <P class="f60">
                        <?php if (! empty ($result["CandidateProfile_Website"])) { ?><B>Website:</B> <A TARGET="NEW" HREF="<?= $result["CandidateProfile_Website"] ?>"><?= $result["CandidateProfile_Website"] ?></A><BR><?php } ?> 
                        <?php if (! empty ($result["CandidateProfile_BallotPedia"])) { ?><A TARGET="NEW" HREF="<?= $result["CandidateProfile_BallotPedia"] ?>">Ballotpedia</A><BR><?php } ?>
                        <?php if (! empty ($result["CandidateProfile_Email"])) { ?><B>Email:</B> <A TARGET="NEW" HREF="mailto:<?= $result["CandidateProfile_Email"] ?>"><?= $result["CandidateProfile_Email"] ?></A><?php } ?>
                        <?php if (! empty ($result["CandidateProfile_PhoneNumber"])) { print " <B>Telephone:</B> " . $result["CandidateProfile_PhoneNumber"] . "<BR>"; } ?>
                        <?php if (! empty ($result["CandidateProfile_Twitter"])) { ?>Twitter: <A TARGET="NEW" HREF="https://twitter.com/<?= $result["CandidateProfile_Twitter"] ?>">@<?= $result["CandidateProfile_Twitter"] ?></A><?php } ?> 
                        <?php if (! empty ($result["CandidateProfile_Facebook"])) { ?>Facebook: <A TARGET="NEW" HREF="https://facebook.com/<?= $result["CandidateProfile_Facebook"] ?>"><?= $result["CandidateProfile_Facebook"] ?></A><?php } ?> 
                        <?php if (! empty ($result["CandidateProfile_Instagram"])) { ?>Instagram: <A TARGET="NEW" HREF="https://instagram.com/<?= $result["CandidateProfile_Instagram"] ?>">@<?= $result["CandidateProfile_Instagram"] ?></A><?php } ?> 
                        <?php if (! empty ($result["CandidateProfile_TikTok"])) { print $result["CandidateProfile_TikTok"] . " - "; } ?> 
                        <?php if (! empty ($result["CandidateProfile_YouTube"])) { print $result["CandidateProfile_YouTube"] . " - "; }  ?>
                        <?php if (! empty ($result["CandidateProfile_FaxNumber"])) { print $result["CandidateProfile_FaxNumber"]; }  ?>
                      </P>
                    
                <?php if ( ! empty ($result["CandidateProfile_PDFFileName"])) { ?>            
                  <P class="f40"><A TARGET="PDFCandidate" HREF="<?= $FrontEndStatic ?>/shared/platforms/<?= $result["CandidateProfile_PDFFileName"] ?>">Download <?= $result["CandidateProfile_Alias"] ?>'s Platform</A></P>
                <?php } ?>
                
                
                
                
              </DIV>
            </DIV>
          </DIV>
          </P>
          
          <?php 
          	if ( ! empty ($resultprofile)) {
          		foreach ($resultprofile as $var) {
          			if ( ! empty ($var)) {
  								?>
   								 <H1>Candidate Profile ID: <?= $var["CandidateProfile_ID"] ?></H1>
   								 <DIV>
  								 <A class="submitred" style="padding: 1px 10px;" HREF="/<?= CreateEncoded (
                        [
                          "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],  
                          "SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
                          "Candidate_ID" => $var["Candidate_ID"],
                          "CandidateProfile_ID" => $var["CandidateProfile_ID"],
                          "ReturnURL" => "/admin/candidate/detail?Candidate_ID=" . $URIEncryptedString["Candidate_ID"]
                        ]
                      );
                    ?>/admin/candidate/setpublicprofile">Set this profile as Public Profile</A>
	  								 </DIV>
  								
  								
  									
  										Quarantine: <?= $var["[CandidateProfile_Quarantine"] ?><BR>
					            Not On Ballot: <?= $var["CandidateProfile_NotOnBallot"] ?><BR>
					            Picture Verified: <?= $var["CandidateProfile_PicVerif"] ?><BR>
					            PDF Verified: <?= $var["CandidateProfile_PDFVerif"] ?><BR>
  								<?php
          			
	          		}
          		}
          	}
          ?>
          
          <?php print "<PRE>" . print_r( $result, 1) . "</PRE>"; ?>
          <?php print "<PRE>" . print_r($resultprofile, 1 ) . "</PRE>"; ?>
<?php
      
  } else {
    header("Location:/error/404.php");
  }
?>
                  </DIV>
                 
                  <DIV class="right f60">  
                    <A HREF="guide">Return to previous menu</A>
                  </DIV>
                </DIV>
              </DIV>
            </DIV>
          </DIV>
        </DIV>
      </DIV>
    </DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>
  </BODY> 
</HTML>