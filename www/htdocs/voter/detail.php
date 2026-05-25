<?php
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";
  
  $middleuri = $_GET["k"];
  preg_match('/^([A-Za-z0-9]+)_(.*)$/', $middleuri, $matches, PREG_OFFSET_CAPTURE);
  $CandidateProfileID = preg_replace('/[^0-9.]+/', '', alphatonumber($matches[1][0]));
  $addtopics = time();
  
  $r = new welcome(0);  
  $var = $r->CandidatesDetailed($CandidateProfileID, [ "debugsql",
      "PublicProfile.PublicProfile_ID", 
      "CandidateProfile.CandidateProfile_ID", "Candidate.Candidate_ID",
      "CandidateElection_Text", "CandidateElection_PetitionText",
      "Elections_Text", "CandidateElection.CandidateElection_ID"
  ]);
  
  $result = $r->CandidatesForElection(
    CandidateElectionID: $var["CandidateElection_ID"], SQLTables: ["debugsql"]
  );
  
    
  $HeaderTwitter = "yes";
  $HeaderTwitterTitle = "Rep My Block - Universal Voter Guide";
  $HeaderTwitterPicLink = "https://static.repmyblock.org/pics/paste/UniversalVoterGuide.jpg";
  $HeaderTwitterDesc = "Rep My Block Voter Guide, the only voter guide that don't restrict the candidate.";
  $HeaderOGTitle = "Rep My Block Voter Guide.";
  $HeaderOGDescription = "Rep My Block Voter Guide, the only voter guide that don't restrict the candidate.";
  $HeaderOGImage = "https://static.repmyblock.org/pics/paste/UniversalVoterGuide.jpg"; 
  $HeaderOGImageWidth = "921";
  $HeaderOGImageHeight = "477";
  
  if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
  } else { $TypeEmail = "text"; $TypeUsername = "text"; }
  
  WriteStderr($result, "Voter Guide");
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

    <link rel="stylesheet" type="text/css" href="/css/guide.css">
    <DIV class="main">    
      <DIV class="right f80bold">Voter Guide</DIV>
        <DIV class="panels">    
     
<?php 
    if (! empty ($var)) {
      WriteStderr($var, "Voter Guide");
      print "          <br style=\"clear:both\">";
      $DateDesc = PrintShortDate($var["Elections_Date"]) . " - " . $var["Elections_Text"];
      $PrevDateDesc = $DateDesc;
      $PicturePath = "/shared/pics/" . (!empty($var["CandidateProfile_PicFileName"]) ?
                           $var["CandidateProfile_PicFileName"] : "0000/NoPicture.jpg");
      $CandidateName = ucwords(strtolower($var["CandidateProfile_Alias"]));
      $CandidatePublicID = $var["PublicProfile_ID"];
?>  
          <DIV class="f60"><B><?= $DateDesc ?></B></DIV>
          <I>Running for <?= $var["CandidateElection_PetitionText"] ?></I>

          <DIV>
            <DIV class="f80"><B><?= $CandidateName ?></B></DIV>  
            
            <DIV class='container2'>
              <DIV>
                <?php if (! empty ($var["CandidateProfile_Website"])) { ?><A TARGET="NEW" HREF="<?= $var["CandidateProfile_Website"] ?>"><?php } ?><IMG class="candidateprofile" style="float: left; margin: 0px 15px 0px 15px;" SRC="<?= $PicturePath ?>"><?php if (! empty ($var["CandidateProfile_Website"])) { ?></A><?php } ?>
                      <P class="f40" style="text-margin: 0px 0px 0px 0px;">
                        <?php if (! empty ($var["CandidateProfile_Statement"])) {
                          print "<UL>" . $var["CandidateProfile_Statement"] . "</UL>"; 
                        } else {
                          if ( empty ($var["SystemUser_ID"])) {
                           ?>
                          
                  
                          <UL>
                          <P CLASS="f60">
                              <B>We need your help to contact <B><?= $CandidateName ?></B>.</B>
                            </P>
                            
                    
            <?php 
                }
                        
                if (($var["CandidateRegAuthority_ID"]) == 1 && ! empty ($var["CandidateProfile_RegID"])) { ?>

                  <P CLASS="f40">
                    After you have cut and paste the information from <B><?= $CandidateName ?></B> FEC form that
                    is found at
                    <A HREF="https://www.fec.gov/data/candidate/<?= $var["CandidateProfile_RegID"] ?>/?tab=about-candidate" TARGET="FECPAGE">https://www.fec.gov/data/candidate/<?= $var["CandidateProfile_RegID"] ?>/?tab=about-candidate</A>
                    email them asking them to update this voter guide at
                    <B><?=  $FrontEndWebsite . $_SERVER['REQUEST_URI'] ?></B>
                  </P>
                    
                  <P CLASS="f40">
                    You can help us by contacting them directly by 
                    following these instructions.
                  </P>
            
                  <P CLASS="f40">
                        
                  
                    To find the email, click on this FEC filing and scroll down to the Committees section. 
                    Click on the committee name to open the Committee Registration page. In the side menu, 
                    click on Filings, then look for the PDF under "Statement of Organization".
                  </P>
                  
                    
                </UL>
                
                
              <?php } ?>
                
                
            <?php  } ?>
                
         
            </DIV>  
    <br style="clear:both">
    <DIV class='container3'>

            <?php 
                // Clean up the variable.
                // Fix the Website to make sure.
                $guide_url = $var["CandidateProfile_Website"];
                if (!preg_match("~^(?:f|ht)tps?://~i", $guide_url )) {
                  $guide_hrefurl = "https://" . $guide_url ;
                } else {
                  $guide_hrefurl = $var["CandidateProfile_Website"];
                }
                $guide_url = preg_replace("~^(?:f|ht)tps?://~i", '', $guide_url);
                $facebook_url = preg_replace("~^(https?://)?(www\.)?facebook\.com/~i", '', $var["CandidateProfile_Facebook"]);
                $tictock_url = preg_replace("~^(https?://)?(www\.)?tiktok\.com/~i", '', $var["CandidateProfile_TikTok"]);
                $youtube_url = preg_replace("~^(https?://)?(www\.)?youtube\.com/~i", '', $var["CandidateProfile_YouTube"]);
                $instagram_url = preg_replace("~^(https?://)?(www\.)?instagram\.com/~i", '', $var["CandidateProfile_Instagram"]);
                $twitter_url = preg_replace("~^(https?://)?(www\.)?twitter\.com/~i", '', $var["CandidateProfile_Twitter"]);
            ?>    
          
            <P class="f60">
              <?php if (! empty ($var["CandidateProfile_Website"])) { ?><B>Website:</B> <A TARGET="NEW" HREF="<?= $guide_hrefurl ?>"><?= $guide_url ?></A><BR><?php } ?> 
              <?php if (! empty ($var["CandidateProfile_BallotPedia"])) { ?><A TARGET="NEW" HREF="<?= $var["CandidateProfile_BallotPedia"] ?>">Ballotpedia</A><BR><?php } ?>
              <?php if (! empty ($var["CandidateProfile_Email"])) { ?><B>Email:</B> <A TARGET="NEW" HREF="mailto:<?= $var["CandidateProfile_Email"] ?>"><?= $var["CandidateProfile_Email"] ?></A><?php } ?>
              <?php if (! empty ($var["CandidateProfile_PhoneNumber"])) { print " <B>Telephone:</B> " . $var["CandidateProfile_PhoneNumber"] . "<BR>"; } ?>
              <?php if (! empty ($var["CandidateProfile_Twitter"])) { ?>Twitter: <A TARGET="NEW" HREF="https://twitter.com/<?= $twitter_url ?>"><?= $twitter_url ?></A><?php } ?> 
              <?php if (! empty ($var["CandidateProfile_Facebook"])) { ?>Facebook: <A TARGET="NEW" HREF="https://facebook.com/<?= $facebook_url ?>"><?= $facebook_url ?></A><?php } ?> 
              <?php if (! empty ($var["CandidateProfile_Instagram"])) { ?>Instagram: <A TARGET="NEW" HREF="https://instagram.com/<?= $instagram_url ?>">@<?= $instagram_url ?></A><?php } ?> 
              <?php if (! empty ($var["CandidateProfile_TikTok"])) { ?>Tik Tok: <A TARGET="NEW" HREF="https://www.tiktok.com/<?= $tictock_url ?>"><?= $tictock_url ?></A><?php } ?> 
              <?php if (! empty ($var["CandidateProfile_YouTube"])) { ?>YouTube: <A TARGET="YouTubeRMB" HREF="https://youtube.com/<?= $youtube_url ?>"><?= $youtube_url ?></A><?php } ?> 
              <?php if (! empty ($var["CandidateProfile_FaxNumber"])) { print $var["CandidateProfile_FaxNumber"]; }  ?>
            </P>
          
          
      <?php if ( ! empty ($var["CandidateProfile_PDFFileName"])) { ?>            
        <P class="f60"><B><A TARGET="PDFCandidate" HREF="<?= $FrontEndStatic ?>/shared/platforms/<?= $var["CandidateProfile_PDFFileName"] ?>">Download <?= $var["CandidateProfile_Alias"] ?>'s Platform</A></B></P>
      <?php } ?>
      
      <?php if ( ! empty ($var["Team_EmailCode"]) || ! empty ($var["CandidateProfile_Donation"])) { ?>
        <P class="f40">        
          <?php if ( ! empty ($var["Team_EmailCode"])) { ?>            
            To volunteer, email <B><A  HREF="mailto:<?= $var["Team_EmailCode"] ?>"><?= $var["Team_EmailCode"] ?></A></B><BR>
          <?php } ?>
          
          <?php if ( ! empty ($var["CandidateProfile_Donation"])) { ?>            
            <B>Link to donate:</B> <A TARGET="DonationLink" HREF="<?= $var["CandidateProfile_Donation"] ?>"><?= $var["CandidateProfile_Donation"] ?></A><BR>
          <?php } ?>
        </P>
      <?php } ?>          
      
    </DIV>
  </DIV>
</DIV>


<?php
      
  } else {
    header("Location:/error/404.php");
  }
  
  
 ?>

</DIV>

<?php if ( empty ($var["SystemUser_ID"])) { ?>
  <P CLASS="f80"><A HREF="<?= $FrontEndWebsite ?>/<?= numbertoalpha($var["PublicProfile_ID"]) ?>/voter/claim">Claim this profile</A></P>
<?php } ?>

	<h2>Endorsements</h2>
	
	<BR>

  <h2>This candidate is running against</h2>

<?php 

$firsttime = true;
$PrevDateDesc = null;
$PrevElectionID = null;

if (!empty($result)) {
  foreach ($result as $var) {

    if (
      ! empty($var["PublicProfile_ID"]) &&
      $var["CandidateProfile_NotOnBallot"] != 'yes' &&
      $var["CandidateProfile_PublishProfile"] != 'no' &&
      $var["PublicProfile_ID"] != $CandidatePublicID
    ) {

      $DateDesc = PrintShortDate($var["Elections_Date"]) . " - " . $var["Elections_Text"];

      $PicturePath = "/shared/pics/" . (!empty($var["CandidateProfile_PicFileName"]) ?
                           $var["CandidateProfile_PicFileName"] : "0000/NoPicture.jpg");

      $FullAlias = preg_replace('/[^a-zA-Z0-9]+/', '', $var["CandidateProfile_Alias"]);
      $DetailURL = "/" . numbertoalpha($var["CANDPROFID"]) . "_" . strtolower($FullAlias) . "/voter/detail";

      /* 🔑 Detect new batch */
      $NewBatch =
        ($PrevDateDesc !== $DateDesc) ||
        ($PrevElectionID !== $var["CandidateElection_ID"]);

      /* 🔒 Close previous batch */
      if ($NewBatch && !$firsttime) {
        echo "</div>"; // .election-batch
      }

      /* 🔒 Open new batch + print headers */
    
      ?>

      <!-- Candidate card -->
      <div class="candidate-card frame">
        <span class="ribbon <?= strtolower($var["Candidate_Party"]) ?>">
          <?= $var["Candidate_Party"] ?>
        </span>
        <a href="<?= $DetailURL ?>">
          <img src="<?= $PicturePath ?>" class="imgothercandidate">
        </a>
        <div class="candidate-name">
          <?= ucwords(strtolower($var["CandidateProfile_Alias"])) ?>
        </div>
      </div>

      <?php
      $PrevDateDesc = $DateDesc;
      $PrevElectionID = $var["CandidateElection_ID"];
      $firsttime = false;
    }
  }

}
?>


       <h2><A HREF="guide">Other races in the district</A></H2>

 </DIV>
  <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
  </BODY>
</HTML>