<?php
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";
  
  $middleuri = $_GET["k"];
  preg_match('/^([A-Za-z0-9]+)_(.*)$/', $middleuri, $matches, PREG_OFFSET_CAPTURE);
  $CandidateProfileID = preg_replace('/[^0-9.]+/', '', alphatonumber($matches[1][0]));
  $addtopics = time();
 
  $r = new welcome();  
  $resultcandidates = $r->CandidatesDetailed($CandidateProfileID, [ "debugsql",
      "PublicProfile.PublicProfile_ID", 
      "CandidateProfile.CandidateProfile_ID", "Candidate.Candidate_ID",
      "CandidateElection_Text", "CandidateElection_PetitionText",
      "Elections_Text", "CandidateElection.CandidateElection_ID",
      "TeamNGOEnd.TeamNGO_ID", "TeamNGOEnd_Major", 
      "CandidateProfile_PicFileName", "CandidateProfile_SocialImgPath"
  ]);
  
  $result = $r->CandidatesForElection(
    CandidateElectionID: $resultcandidates[0]["CandidateElection_ID"], 
    NotOnBallot: 'no',
    SQLTables: ["debugsql"]
  );
 
  $passparams = [];
  
  // To classify the endorsments
  if (! empty ($resultcandidates)) { 	
  	foreach ($resultcandidates as $var) {
  		if ( ! empty ($var["TeamNGOPublic_ID"])) {  			
  			$endorsement[$var["TeamNGOEnd_Major"]][$var["TeamNGO_ID"]]["LogoPath"] = $var["TeamNGOEnd_LogoPath"];
  		}
  	}
  }
  
  if ( empty ($resultcandidates[0]["CandidateProfile_SocialImgPath"])) {
  	$hash = md5(random_bytes(32));
  	$resultpath = substr($hash, 0, 4) . "/" . substr($hash, 4, 4) . "/" . substr($hash, 8, 4);
  	$r->UpdateSocialMediaPath($resultcandidates[0]["CandidateProfile_ID"], $resultpath);
  	$resultcandidates[0]["CandidateProfile_SocialImgPath"] = $resultpath;
  }
 
  $SocialMediaPicsPath = "/socialimg/" . $resultcandidates[0]["CandidateProfile_SocialImgPath"];
 	$HeaderFile = $SharedPath . $SocialMediaPicsPath . "/voteheader.png";
	
	if (
    !is_dir($SharedPath . $SocialMediaPicsPath) ||
    !file_exists($headerPath) ||
    (time() - filemtime($headerPath)) > (3 * 60 * 60)
	) {


		$CandidateImg = "/pics/" . (!empty($resultcandidates[0]["CandidateProfile_PicFileName"]) ?	
                           $resultcandidates[0]["CandidateProfile_PicFileName"] : "0000/NoPicture.jpg");
		
		if ( !is_dir($SharedPath . $SocialMediaPicsPath . $dir) ) { mkdir($SharedPath . $SocialMediaPicsPath . $dir, 0755, true); }

		$HeaderFile = $SocialMediaPicsPath . "/voteheader.png";

		$image = new Imagick();
		$image->newImage(1200, 630, new ImagickPixel("white"));
		$image->setImageFormat("png");
	
		// Title
		$draw = new ImagickDraw();
		$draw->setFillColor("black");
		
		$draw->setGravity(Imagick::GRAVITY_NORTH);

		$draw->setFontSize(80);
		drawOutlinedText($image, ucwords(strtolower($resultcandidates[0]["CandidateProfile_Alias"])), 230, 210, 80, "#000000");
		
		$draw->setFontSize(26);
		$image->annotateImage($draw, 60, 230, 0, $resultcandidates[0]["CandidateElection_PetitionText"]);
		
		// Subtitle
		drawOutlinedText($image, "The", 20, 50, 50, "#ee2e62");
		drawOutlinedText($image, "Represent My Block", 145, 50, 50, "#16317D");
		drawOutlinedText($image, "Voter Guide", 20, 110, 60, "#ee2e62");
		
		drawOutlinedText($image, "VOTE!", 500, 380, 120, "#16317D");
		drawOutlinedText($image, PrintShortDateNoOrd($resultcandidates[0]["Elections_Date"]), 500, 460, 70, "#000000");
		
		// RepMyBlock Logo
		$svgPath = $_SERVER["DOCUMENT_ROOT"] . "/images/RepMyBlock.svg";
		if (!is_readable($svgPath)) {
    	error_log("SVG not readable: " . $svgPath);
		} else {
			
			$drawBox = new ImagickDraw();

			$drawBox->setFillColor("#FCED00"); // yellow
			//$drawBox->setStrokeColor("#C9A400");
			$drawBox->setStrokeWidth(4);
			$drawBox->rectangle(1020, 0, 1180, 120);
			$image->drawImage($drawBox);
			
	    $svg = file_get_contents($svgPath);

	    $img2 = new Imagick();
	    $img2->setResolution(200, 200);
	    $img2->setBackgroundColor(new ImagickPixel("transparent"));

	    $img2->readImageBlob($svg);
	    $img2->setImageFormat("png");
	    $img2->resizeImage(150, 0, Imagick::FILTER_LANCZOS, 1);

	    $image->compositeImage($img2, Imagick::COMPOSITE_OVER, 1030, 00);

	    $img2->clear();
	    $img2->destroy();
		}
	
		$img = new Imagick($SharedPath . $CandidateImg);
		//$img->resizeImage(200, 300, Imagick::FILTER_LANCZOS, 1);

		// Bottom-left logo placement
		$image->compositeImage($img, Imagick::COMPOSITE_OVER, 20, 150);
		
		// Endorsement
	
		$start_x = -100;
		
		if (! empty ($endorsement["minor"])) {
			foreach ($endorsement["minor"] as $var) {
				if ( ! empty ($var)) {
					$img2 = new Imagick($SharedPath . "/" . $var["LogoPath"]);
					$image->compositeImage($img2, Imagick::COMPOSITE_OVER, $start_x += 120 , 500);
					$img2->clear();
					$img2->destroy();

				}
			}
		}

		if (! empty ($endorsement["local"])) {
			foreach ($endorsement["local"] as $var) {
				if ( ! empty ($var)) {
					$img2 = new Imagick($SharedPath . "/" . $var["LogoPath"]);
					$image->compositeImage($img2, Imagick::COMPOSITE_OVER, $start_x += 120, 500);
					$img2->clear();
					$img2->destroy();
				}
			}
		}
		
		if (! empty ($endorsement["major"])) {
		 	$start_x = 1020;
			foreach ($endorsement["major"] as $var) {
				if ( ! empty ($var)) {
					$img2 = new Imagick($SharedPath . "/" . $var["LogoPath"]);
					$image->compositeImage($img2, Imagick::COMPOSITE_OVER, $start_x -= 60, 30);
					$img2->clear();
					$img2->destroy();
				}
			}
		} 

		// Save final image
		$image->writeImage($SharedPath . $HeaderFile);
		$image->clear();
		$image->destroy();

		$img->clear();
		$img->destroy();
		
		$HeaderFile = "shared" . $HeaderFile;
	} else {
		if ( file_exists($SharedPath . $SocialMediaPicsPath . "/voteheader.png")) {
			$HeaderFile = "shared" . $SocialMediaPicsPath . "/voteheader.png";
		} else {
			$HeaderFile = "pics/paste/UniversalVoterGuide.jpg";
		}
	}
	
	$HeaderTwitter = "yes";
  $HeaderTwitterTitle = "Rep My Block - Universal Voter Guide";
  $HeaderTwitterPicLink = "https://static.repmyblock.org/" . $HeaderFile;
  $HeaderTwitterDesc = "Rep My Block Voter Guide, the only voter guide that don't restrict the candidate.";
  $HeaderOGTitle = "Rep My Block Voter Guide.";
  $HeaderOGDescription = "Rep My Block Voter Guide, the only voter guide that don't restrict the candidate.";
  $HeaderOGImage = "https://static.repmyblock.org/" . $HeaderFile;
  $HeaderOGImageWidth = "921";
  $HeaderOGImageHeight = "477";
	  
  
 
  
  if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
  } else { $TypeEmail = "text"; $TypeUsername = "text"; }
  
  
  $CandidateToDisplay = $resultcandidates[0];
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>


    <link rel="stylesheet" type="text/css" href="/css/guide.css">
    <DIV class="main">    
      <DIV class="right f80bold">Voter Guide</DIV>
        <DIV class="panels">    

<?php /*
	<?= $HeaderFile ?>
	<TABLE BORDER=1><TR><TD><CENTER><IMG SRC="https://dev-frontend-web.repmyblock.org/<?= $HeaderFile ?> "></CENTER></TD></TR></TABLE>
*/ ?>
     
<?php 
    if (! empty ($CandidateToDisplay)) {
      WriteStderr($CandidateToDisplay, "Voter Guide");
      print "          <br style=\"clear:both\">";
      $DateDesc = PrintShortDate($CandidateToDisplay["Elections_Date"]) . " - " . $CandidateToDisplay["Elections_Text"];
      $PrevDateDesc = $DateDesc;
      $PicturePath = "/shared/pics/" . (!empty($CandidateToDisplay["CandidateProfile_PicFileName"]) ?
                           $CandidateToDisplay["CandidateProfile_PicFileName"] : "0000/NoPicture.jpg");
      $CandidateName = ucwords(strtolower($CandidateToDisplay["CandidateProfile_Alias"]));
      $CandidatePublicID = $CandidateToDisplay["PublicProfile_ID"];
?>  
          <DIV class="f60"><B><?= $DateDesc ?></B></DIV>
          <I>Running for <?= $CandidateToDisplay["CandidateElection_PetitionText"] ?></I>

          <DIV>
            <DIV class="f80"><B><?= $CandidateName ?></B></DIV>  
            
            <DIV class='container2'>
              <DIV>
                <?php if (! empty ($CandidateToDisplay["CandidateProfile_Website"])) { ?><A TARGET="NEW" HREF="<?= $CandidateToDisplay["CandidateProfile_Website"] ?>"><?php } ?><IMG class="candidateprofile" style="float: left; margin: 0px 15px 0px 15px;" SRC="<?= $PicturePath ?>"><?php if (! empty ($CandidateToDisplay["CandidateProfile_Website"])) { ?></A><?php } ?>
                      <P class="f40" style="text-margin: 0px 0px 0px 0px;">
                        <?php if (! empty ($CandidateToDisplay["CandidateProfile_Statement"])) {
                          print "<UL>" . $CandidateToDisplay["CandidateProfile_Statement"] . "</UL>"; 
                        } else {
                          if ( empty ($CandidateToDisplay["SystemUser_ID"])) {
                           ?>
                          <UL>
                          <P CLASS="f60">
                              <B>We need your help to contact <B><?= $CandidateName ?></B>.</B>
                            </P>
                            
                    
            <?php 
                }
                        
                if (($CandidateToDisplay["CandidateRegAuthority_ID"]) == 1 && ! empty ($CandidateToDisplay["CandidateProfile_RegID"])) { ?>

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
                $guide_url = $CandidateToDisplay["CandidateProfile_Website"];
                if (!preg_match("~^(?:f|ht)tps?://~i", $guide_url )) {
                  $guide_hrefurl = "https://" . $guide_url ;
                } else {
                  $guide_hrefurl = $CandidateToDisplay["CandidateProfile_Website"];
                }
                $guide_url = preg_replace("~^(?:f|ht)tps?://~i", '', $guide_url);
                $facebook_url = preg_replace("~^(https?://)?(www\.)?facebook\.com/~i", '', $CandidateToDisplay["CandidateProfile_Facebook"]);
                $tictock_url = preg_replace("~^(https?://)?(www\.)?tiktok\.com/~i", '', $CandidateToDisplay["CandidateProfile_TikTok"]);
                $youtube_url = preg_replace("~^(https?://)?(www\.)?youtube\.com/~i", '', $CandidateToDisplay["CandidateProfile_YouTube"]);
                $instagram_url = preg_replace("~^(https?://)?(www\.)?instagram\.com/~i", '', $CandidateToDisplay["CandidateProfile_Instagram"]);
                $twitter_url = preg_replace("~^(https?://)?(www\.)?twitter\.com/~i", '', $CandidateToDisplay["CandidateProfile_Twitter"]);
            ?>    
          
            <P class="f60">
              <?php if (! empty ($CandidateToDisplay["CandidateProfile_Website"])) { ?><B>Website:</B> <A TARGET="NEW" HREF="<?= $guide_hrefurl ?>"><?= $guide_url ?></A><BR><?php } ?> 
              <?php if (! empty ($CandidateToDisplay["CandidateProfile_BallotPedia"])) { ?><A TARGET="NEW" HREF="<?= $CandidateToDisplay["CandidateProfile_BallotPedia"] ?>">Ballotpedia</A><BR><?php } ?>
              <?php if (! empty ($CandidateToDisplay["CandidateProfile_Email"])) { ?><B>Email:</B> <A TARGET="NEW" HREF="mailto:<?= $CandidateToDisplay["CandidateProfile_Email"] ?>"><?= $CandidateToDisplay["CandidateProfile_Email"] ?></A><?php } ?>
              <?php if (! empty ($CandidateToDisplay["CandidateProfile_PhoneNumber"])) { print " <B>Telephone:</B> " . $CandidateToDisplay["CandidateProfile_PhoneNumber"] . "<BR>"; } ?>
              <?php if (! empty ($CandidateToDisplay["CandidateProfile_Twitter"])) { ?>Twitter: <A TARGET="NEW" HREF="https://twitter.com/<?= $twitter_url ?>"><?= $twitter_url ?></A><?php } ?> 
              <?php if (! empty ($CandidateToDisplay["CandidateProfile_Facebook"])) { ?>Facebook: <A TARGET="NEW" HREF="https://facebook.com/<?= $facebook_url ?>"><?= $facebook_url ?></A><?php } ?> 
              <?php if (! empty ($CandidateToDisplay["CandidateProfile_Instagram"])) { ?>Instagram: <A TARGET="NEW" HREF="https://instagram.com/<?= $instagram_url ?>">@<?= $instagram_url ?></A><?php } ?> 
              <?php if (! empty ($CandidateToDisplay["CandidateProfile_TikTok"])) { ?>Tik Tok: <A TARGET="NEW" HREF="https://www.tiktok.com/<?= $tictock_url ?>"><?= $tictock_url ?></A><?php } ?> 
              <?php if (! empty ($CandidateToDisplay["CandidateProfile_YouTube"])) { ?>YouTube: <A TARGET="YouTubeRMB" HREF="https://youtube.com/<?= $youtube_url ?>"><?= $youtube_url ?></A><?php } ?> 
              <?php if (! empty ($CandidateToDisplay["CandidateProfile_FaxNumber"])) { print $CandidateToDisplay["CandidateProfile_FaxNumber"]; }  ?>
            </P>
          
          
      <?php if ( ! empty ($CandidateToDisplay["CandidateProfile_PDFFileName"])) { ?>            
        <P class="f60"><B><A TARGET="PDFCandidate" HREF="<?= $FrontEndStatic ?>/shared/platforms/<?= $CandidateToDisplay["CandidateProfile_PDFFileName"] ?>">Download <?= $CandidateToDisplay["CandidateProfile_Alias"] ?>'s Platform</A></B></P>
      <?php } ?>
      
      <?php if ( ! empty ($CandidateToDisplay["Team_EmailCode"]) || ! empty ($CandidateToDisplay["CandidateProfile_Donation"])) { ?>
        <P class="f40">        
          <?php if ( ! empty ($vCandidateToDisplayar["Team_EmailCode"])) { ?>            
            To volunteer, email <B><A  HREF="mailto:<?= $CandidateToDisplay["Team_EmailCode"] ?>"><?= $CandidateToDisplay["Team_EmailCode"] ?></A></B><BR>
          <?php } ?>
          
          <?php if ( ! empty ($CandidateToDisplay["CandidateProfile_Donation"])) { ?>            
            <B>Link to donate:</B> <A TARGET="DonationLink" HREF="<?= $CandidateToDisplay["CandidateProfile_Donation"] ?>"><?= $CandidateToDisplay["CandidateProfile_Donation"] ?></A><BR>
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

<?php if ( empty ($CandidateToDisplay["SystemUser_ID"])) { ?>
  <P CLASS="f80"><A HREF="<?= $FrontEndWebsite ?>/<?= numbertoalpha($CandidateToDisplay["PublicProfile_ID"]) ?>/voter/claim">Claim this profile</A></P>
<?php } ?>

	<h2>Tendencies political endorsement</h2>
<?php
			if (! empty ($endorsement["major"])) {
				foreach ($endorsement["major"] as $index => $var) {
					if ( ! empty ($var)) {
						$newparams = array_merge($passparams, ["t" => numbertoalpha($index)]);
						?>
							<A HREF="/<?= "b:" . base64_encode(http_build_query($newparams)) ?>/voter/guide"><IMG SRC="/shared/<?= $var["LogoPath"] ?>"></A>							
						<?php
					}
				}
			} else {
				echo "<BR><UL><FONT SIZE=+2>None</FONT></UL><BR>";
			}
?>

<?php
			if (! empty ($endorsement["support"])) {
				echo "<h2>This candidate supports</h2>\n";

				foreach ($endorsement["support"] as $index => $var) {
					if ( ! empty ($var)) {
						$newparams = array_merge($passparams, ["t" => numbertoalpha($index)]);
						?>
							<A HREF="/<?= "b:" . base64_encode(http_build_query($newparams)) ?>/voter/guide"><IMG SRC="/shared/<?= $var["LogoPath"] ?>"></A>							
						<?php
					}
				}
			}
?>

  
<?php 

$firsttime = true;
$PrevDateDesc = null;
$PrevElectionID = null;

if (!empty($result)) {
	echo "<h2>This candidate is running against</h2>\n";
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

      /* Detect new batch */
      $NewBatch =
        ($PrevDateDesc !== $DateDesc) ||
        ($PrevElectionID !== $var["CandidateElection_ID"]);

      /* Close previous batch */
      if ($NewBatch && !$firsttime) {
        echo "</div>"; // .election-batch
      }

      /* Open new batch + print headers */
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

	<BR>

	<h2>Endorsements</h2>
	<BR>
		<?php
		
		if ( ! empty ($endorsement["minor"]) && ! empty ($endorsement["local"]) ) {
		
			if (! empty ($endorsement["minor"])) {
				foreach ($endorsement["minor"] as $index => $var) {
					if ( ! empty ($var)) {
						$newparams = array_merge($passparams, ["n" => numbertoalpha($index)]);
						?>
							<A HREF="/<?= "b:" . base64_encode(http_build_query($newparams)) ?>/voter/guide"><IMG SRC="/shared/<?= $var["LogoPath"] ?>"></A>							
						<?php
					}
				}
				echo "<BR>";
			}
	
			if (! empty ($endorsement["local"])) {
				foreach ($endorsement["local"] as $index => $var) {
					if ( ! empty ($var)) {
						$newparams = array_merge($passparams, ["n" => numbertoalpha($index)]);
						?>
							<A HREF="/<?= "b:" . base64_encode(http_build_query($newparams)) ?>/voter/guide"><IMG SRC="/shared/<?= $var["LogoPath"] ?>"></A>							
						<?php
					}
				}
			}
			
			
		} else {
			echo "<UL><FONT SIZE=+2>None</FONT></UL>";
		}
		?>
		
    <h2><A HREF="/<?= "somethingsomethign" ?>/voter/guide">Other races in the district</A></H2>

 </DIV>
  <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
  </BODY>
</HTML>