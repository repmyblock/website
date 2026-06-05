<?php 

  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";
  
	$k = $_GET['k'] ?? '';
		
	if (!preg_match('/^([0-9a-fA-F]{12})(.*)$/', $k, $matches)) {
    http_response_code(404);
    exit();
	}

	$hex12 = strtolower($matches[1]); 							// first 12 hex chars
	$CandProfileID  = alphatonumber($matches[2]);   // everything after

	$path = $_SERVER['DOCUMENT_ROOT']
	      . '/shared/socialimg/'
	      . substr($hex12, 0, 4) . '/'
	      . substr($hex12, 4, 4) . '/'
	      . substr($hex12, 8, 4);

	$file = $path . '/voteheader.png';

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";
  
	if (! file_exists($file)) {
 		if (!is_dir($path)) {
	  	mkdir($path, 0775, true);
	  }
	    
	  if (
    	!is_dir($SharedPath . $SocialMediaPicsPath) ||
    	!file_exists($headerPath) ||
    	(time() - filemtime($headerPath)) > (3 * 60 * 60)
		) {

			$r = new welcome();  
			$resultcandidates = $r->CandidatesDetailed($CandProfileID, [ 
		      "PublicProfile.PublicProfile_ID", 
		      "CandidateProfile.CandidateProfile_ID", "Candidate.Candidate_ID",
		      "CandidateElection_Text", "CandidateElection_PetitionText",
		      "Elections_Text", "CandidateElection.CandidateElection_ID",
		      "TeamNGOEnd.TeamNGO_ID", "TeamNGOEnd_Major", 
		      "CandidateProfile_PicFileName", "CandidateProfile_SocialImgPath",
		      "CandidateProfile_Alias", "Elections_Date", "TeamNGOEnd.TeamNGO_ID", "TeamNGOEnd_LogoPath",
		      "TeamNGOPublic_ID"
  		]);
  		
  		// To classify the endorsments
		  if (! empty ($resultcandidates)) { 	
		  	foreach ($resultcandidates as $var) {
		  		if ( ! empty ($var["TeamNGOPublic_ID"])) {  			
		  			$endorsement[$var["TeamNGOEnd_Major"]][$var["TeamNGO_ID"]]["LogoPath"] = $var["TeamNGOEnd_LogoPath"];
		  		}
		  	}
		  }
		  
 		  $CandidateName = ucwords(strtolower($resultcandidates[0]["CandidateProfile_Alias"]));
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
			drawOutlinedText($image, $CandidateName, 230, 210, 80, "#000000");
			
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
			$image->writeImage($file);
		
			
			$image->clear();
			$image->destroy();

			$img->clear();
			$img->destroy();
		}
    // --------------------------------------------------
    // CREATE voteheader.png HERE
    // --------------------------------------------------

	} 
	
	#echo "The file is here: " . $path . "\n";
	if (!file_exists($file)) {
    http_response_code(404);
    die('Image not found');
}

	header('Content-Type: image/jpg');
	header('Content-Length: ' . filesize($file));

	readfile($file);
	exit;
	
?>