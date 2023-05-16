<?php
	$CandidateID = "378";
	// Check the state.
	
	preg_match('/\?([6-7]\d[A-D])/', $_SERVER['REQUEST_URI'], $Match, PREG_OFFSET_CAPTURE);
	
	// Check that the state is here so we don't go over the DB each time.
	$StateToMatch = array('61A'=>1,'65A'=>1,'65B'=>1,'65C'=>1,'65D'=>1,'66A'=>1,'66B'=>1,'67A'=>1,'67B'=>1,
												'67C'=>1,'68A'=>1,'68B'=>1,'68C'=>1,'68D'=>1,'69A'=>1,'69B'=>1,'69C'=>1,'70A'=>1,'70B'=>1,'70C'=>1,
												'70D'=>1,'71A'=>1,'71B'=>1,'72A'=>1,'72B'=>1,'73A'=>1,'73B'=>1,'73C'=>1,'74A'=>1,'74B'=>1,'74C'=>1,'74D'=>1,
												'75A'=>1,'75B'=>1,'76A'=>1,'76B'=>1);

	if ( empty ($StateToMatch[$Match[1][0]])) {
		header("Location: ../replacejayjacobs");
		exit();
	}

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_survey.php";	
					
	$r = new survey();
	
	if ( ! empty ($_POST)) {
				
		do { 
			$GoodRandomKey = strtoupper(PrintRandomText(12));
			$ResultRandom = $r->CheckSurveyRandomKey($GoodRandomKey);
		} while (! empty($ResultRandom));
				
		if ($_POST["Age"] < 200 && is_numeric($_POST["Age"])) { $Age = $_POST["Age"]; } else { $Age = NULL; }
		
		$DataToSave = array(
			"SurveyPresUser_RandomKey" => $GoodRandomKey,
			"Candidate_ID" => $CandidateID,
			"SurveyPresUser_State" => $Match[1][0],
			"SurveyPresUser_FirstName" => $_POST["FirstName"],
			"SurveyPresUser_LastName" => $_POST["LastName"],
			"SurveyPresUser_County" => $_POST["County"],
			"SurveyPresUser_ZipCode" => $_POST["Zipcode"],
			"SurveyPresUser_PartisanPartyCounty" => $_POST["Partisan_DemCounty"],
			"SurveyPresUser_PartisanClubMember" => $_POST["Partisan_ClubMember"],
			"SurveyPresUser_PartisanRanForOffice" => $_POST["Partisan_RanForOffice"],
			"SurveyPresUser_PartisanElectedToOffice" => $_POST["Partisan_ElectedToOffice"],
			"SurveyPresUser_PartisanNever" => $_POST["Partisan_Never"],
			"SurveyPresUser_DelegateStatusCandDelegate" => $_POST["DelegateStatus_AOCDelegate"],
			"SurveyPresUser_DelegateStatusWouldloveToBe" => $_POST["DelegateStatus_WouldloveToBe"],
			"SurveyPresUser_DelegateStatusVolunteerFor" => $_POST["DelegateStatus_VolunteerFor"],
			"SurveyPresUser_DelegateStatusTimeToRead" => $_POST["DelegateStatus_TimeToRead"],
			"SurveyPresUser_DelegateStatusWasDelegate" => $_POST["DelegateStatus_WasDelegate"],
			"SurveyPresUser_AffirmativeAfricanAmerican" => $_POST["Affirmative_AfricanAmerican"],
			"SurveyPresUser_AffirmativeHispanic" => $_POST["Affirmative_Hispanic"],
			"SurveyPresUser_AffirmativeAsianPacific" => $_POST["Affirmative_AsianPacific"],
			"SurveyPresUser_AffirmativeNativeAmerican" => $_POST["Affirmative_NativeAmerica"],
			"SurveyPresUser_AffirmativeDisability" => $_POST["Affirmative_Disability"],
			"SurveyPresUser_AffirmativeLGBT" => $_POST["Affirmative_LGBT"],
			"SurveyPresUser_AffirmativeYouth" => $_POST["Affirmative_Youth"],
			"SurveyPresUser_Age" => $Age
		);
		
		$r->SaveSurvey($DataToSave);
	
		header("Location: /replacejay/draft/replacejayjacobs/saved?" . $GoodRandomKey);
		exit();
	
	
	}
	
	$result = $r->FindState($CandidateID, $Match[1][0]);
	
	$HeaderTwitter = 1;
	$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/draft/ReplaceJayJacobs-ByeJay.jpg";
	$HeaderTwitterDesc = "If you are a Manhattan Democratic County Committee, sign the pledge of signing the petition for the New York County Committee joining the Replace Jay Jacobs Coalition.";   
	$HeaderTwitterTitle = "Replace Jay Jacobs - #ByeJay";   
	
	$HeaderOGImage = $HeaderTwitterPicLink;
	$HeaderOGDescription = $HeaderTwitterDesc;
	$HeaderOGTitle = $HeaderTwitterTitle;
	$HeaderOGImageWidth = "708";
	$HeaderOGImageHeight = "757";
	
	$HeaderTwitterSite = "@ReplaceJacobs"; 
	$HeaderTwitterCreator = "@ReplaceJacobs"; 


	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	// $imgtoshow = "/brand/socialist/Socialists.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80 p05">Help gather pledges from Manhattan County Committees!</DIV>
	
		<h1>Draft for the New York County to join the Replace Jay Jacobs coalition</h1>
	
			<P class="f60">
				About 1,700 party delegates and activists are renewing calls for Gov. Hochul to ditch Jacobs as he's set to host a state party meeting this week in Albany. 
			</P>
					
			<P CLASS="f60">
				The goal is to identify 15 County Committees in 6 Assembly District Parts willing to openly sign the petition to 
				put on the floor a vote to Replace Jay Jacobs.
			</P>
			
			<P CLASS="f60">
				The state of <?= $result["SurveyPresDelInfo_StateName"] ?> is allocated <?= $result["SurveyPresDelInfo_TotalDelegate"] ?> delegates. At
				this time we need to find as many democrats to show support for a possible AOC candidacy. The goal is to find 
				as many people to register as Democrat by <?= $result["SurveyPresDelInfo_LastDaySwitchParty"] ?>.
			</P>
			
			<FORM METHOD="POST" ACTION="">		
				
			<P class="f60">
				<DIV class="f60"><B>Pledge to sign:</B></DIV>
				<DIV class="f60"><INPUT class="" type="checkbox" NAME="DelegateStatus_WillSign" value="yes">&nbsp;&nbsp;I will sign the Petition for the County Committee to Join the Replace Jay Jacobs Coalition</DIV>
			</P>
	
		
			<P class="f60">
				<DIV class="f60"><B>First Name:</B></DIV> 
				<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="FirstName" PLACEHOLDER="First Name"><DIV>
			</P>
				
			<P class="f60">
				<DIV class="f60"><B>Last Name:</B></DIV>
				<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="LastName" PLACEHOLDER="Last Name"></DIV>
			</P>

			<P class="f60">
				<DIV class="f60"><B>Zipcode:</B></DIV>
				<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="Zipcode" PLACEHOLDER="Zipcode"></DIV>
			</P>
			
			<P class="f60">
				<DIV class="f60"><B>Election District</B></DIV>
				<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="Election District Number" PLACEHOLDER="ED"></DIV>
			</P>
			
			
			
			<P>
				<DIV><INPUT class="" TYPE="Submit" NAME="Survey" VALUE="Prepare the survey to email"></DIV>
			</P>
		
		<P class="f40">
			By clicking the "Register" button, you are creating a 
			RepMyBlock account, and you agree to RepMyBlock's 
			<A HREF="/text/terms">Terms of Use</A> and 
			<A HREF="/text/privacy">Privacy Policy.</A>
		</P>
			

			<P class="f60">
				Watch this 26 minutes documentary that explains what it means to be part of the governance of the County Democratic party.
			<B><A HREF="/<?= $middleuri ?>/exp/register/movie">Click here to watch the whole documentary.</A></B>
				<I>(Press the PLAY button and enter the password (all in uppercase) <FONT COLOR=BROWN><B>QCC4ALL</B></FONT> to access the documentary.)</I>
			</P>
			
			
			<P class="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services. <B>Replace Jay Jacobs's content does not reflect the Rep My Block tool.</B>
			</P>
			
</DIV>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
