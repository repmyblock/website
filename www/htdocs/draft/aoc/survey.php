<?php
	$CandidateID = "376";
	// Check the state.
	
	preg_match('/\?([A-Z][A-Z])/', $_SERVER['REQUEST_URI'], $Match, PREG_OFFSET_CAPTURE);
	
	// Check that the state is here so we don't go over the DB each time.
	$StateToMatch = array('AB'=>1,'AL'=>1,'AK'=>1,'AS'=>1,'VI'=>1,'AZ'=>1,'AR'=>1,'CA'=>1,'CO'=>1,'CT'=>1,'DE'=>1,'DC'=>1,
												'FL'=>1,'GA'=>1,'FU'=>1,'HI'=>1,'ID'=>1,'IL'=>1,'IN'=>1,'IA'=>1,'KS'=>1,'KY'=>1,'LA'=>1,'ME'=>1,
												'MD'=>1,'MA'=>1,'MI'=>1,'MN'=>1,'MS'=>1,'MO'=>1,'MT'=>1,'NE'=>1,'NV'=>1,'NH'=>1,'NJ'=>1,'NM'=>1,
												'NY'=>1,'NC'=>1,'ND'=>1,'OH'=>1,'OK'=>1,'OR'=>1,'PA'=>1,'PR'=>1,'RO'=>1,'SC'=>1,'SD'=>1,'TN'=>1,
												'TX'=>1,'UT'=>1,'VE'=>1,'VA'=>1,'WA'=>1,'WV'=>1,'WI'=>1,'WY'=>1);


	if ( empty ($StateToMatch[$Match[1][0]])) {
		echo "Je suis dans le state doesn't match";
		exit();
		header("Location: ../aoc");
		exit();
	}

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_survey.php";	
					
	$r = new survey();
	
	if ( ! empty ($_POST)) {
		
		print "<PRE>" . print_r($_POST,1 ) . "</PRE>";
		
		exit();
		
		`SurveyPresUser_RandomKey` char(12),
		Candidate_ID int unsigned,
		SurveyPresUser_State char(2),
		SurveyPresUser_FirstName varchar(100),  [FirstName] => Theo
		SurveyPresUser_LastName varchar(100), [LastName] => Chino
		SurveyPresUser_County  varchar(100), [County] => New York
		SurveyPresUser_ZipCode  varchar(50), [Zipcode] => 10031
		SurveyPresUser_PartisanPartyCounty enum('yes', 'no'),  [Partisan_DemCounty] => yes
		SurveyPresUser_PartisanClubMember enum('yes', 'no'),  [Partisan_ClubMember] => yes
		SurveyPresUser_PartisanRanForOffice enum('yes', 'no'),   [Partisan_RanForOffice] => yes
		SurveyPresUser_PartisanElectedToOffice enum('yes', 'no'),[Partisan_ElectedToOffice] => yes
		SurveyPresUser_PartisanNever enum('yes', 'no'),   [Partisan_Never] => yes
		SurveyPresUser_DelegateStatusCandDelegate enum('yes', 'no'),  [DelegateStatus_AOCDelegate] => yes
		SurveyPresUser_DelegateStatusWouldloveToBe enum('yes', 'no'),  [DelegateStatus_WouldloveToBe] => yes
		SurveyPresUser_DelegateStatusVolunteerFor enum('yes', 'no'), [DelegateStatus_VolunteerFor] => yes
		SurveyPresUser_DelegateStatusTimeToRead enum('yes', 'no'),   [DelegateStatus_TimeToRead] => yes
		SurveyPresUser_DelegateStatusWasDelegate enum('yes', 'no'), [DelegateStatus_WasDelegate] => yes
		SurveyPresUser_AffirmativeAfricanAmerican enum('yes', 'no'),  [Affirmative_AfricanAmerican] => yes
		SurveyPresUser_AffirmativeHispanic enum('yes', 'no'),  [Affirmative_Hispanic] => yes
		SurveyPresUser_AffirmativeAsianPacific enum('yes', 'no'),  [Affirmative_AsianPacific] => yes
		SurveyPresUser_AffirmativeNativeAmerican enum('yes', 'no'),  [Affirmative_NativeAmerica] => yes
		SurveyPresUser_AffirmativeDisability enum('yes', 'no'),  [Affirmative_Disability] => yes
		SurveyPresUser_AffirmativeLGBT enum('yes', 'no'),  [Affirmative_LGBT] => yes
		SurveyPresUser_AffirmativeYouth enum('yes', 'no'),  [Affirmative_Youth] => yes
		SurveyPresUser_Age tinyint unsigned , [Age] => 12
		SurveyPresUser_DateTime datetime,
			
		   
   
   
   
   
   
    PrintRandomText($length = 9)
   
   
   
   
   
   
   
   

		$r->SaveSurvey($DataToSave);
		exit();
		
	}
	
	
	
	$result = $r->FindState($CandidateID, $Match[1][0]);
	
	$HeaderTwitter = 1;
	$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/draft/DraftAOCForPresidentIn2024.jpg";
	$HeaderTwitterDesc = "To save Democracy, Human Rights, and the Planet. The Status Quo will not make the changes we need to win the future we deserve. Bernie started the Political Revolution, We must finish it together. AOC must take the torch and lead the way forward.";   
	$HeaderTwitterTitle = "Draft AOC for President in 2024";   

	$HeaderOGImage = $HeaderTwitterPicLink;
	$HeaderOGDescription = $HeaderTwitterDesc;
	$HeaderOGTitle = $HeaderTwitterTitle;
	$HeaderOGImageWidth = "750";
	$HeaderOGImageHeight = "324";
	
	$HeaderTwitterSite = "@draftaoc2024"; 
	$HeaderTwitterCreator = "@draftaoc2024"; 

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	// $imgtoshow = "/brand/socialist/Socialists.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80 p05">Help put Socialists candidates on the ballot!</DIV>
	
		<h1>Draft AOC for President of the United States</h1>
	
			<P class="f60">
				Social Democrats of America is looking for Socialists to run or help other run for delegate to the Presidential 
				Convention in Chicago in 2024.
			</P>
			
			<P CLASS="f60">
				All the information about the convention is not yet out but the Democratic party of the state of <?= $result["SurveyPresDelInfo_StateName"] ?>
				published a draft of the <A HREF="<?= $FrontEndStatic . $result["SurveyPresDocuments_RMBURL"] ?>" TARGET="DSP">Delegate Selection Plan</A>.
			</P>

			<P CLASS="f60">
				The goal is also to remove money from the electoral process so the way this draft campaign is setup is by collecting
				in kind donations where each one of us perform easy tasks for the benefit of all. It could be from going to the county
				chair and picking up a copy of the voter database, standing at a corner passing leftlets, drawing a logo, or anything
				you feel will achieve the goal.
			</P>

			<P CLASS="f60">
				The state of <?= $result["SurveyPresDelInfo_StateName"] ?> is allocated <?= $result["SurveyPresDelInfo_TotalDelegate"] ?> delegates. At
				this time we need to find as many democrats to show support for a possible AOC candidacy. The goal is to find 
				as many people to register as Democrat by <?= $result["SurveyPresDelInfo_LastDaySwitchParty"] ?>.
			</P>
			
			<FORM METHOD="POST" ACTION="">			
		
			<P class="f60">
				<DIV class="f60"><B>First Name:</B></DIV> 
				<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="FirstName" PLACEHOLDER="First Name"><DIV>
			</P>
				
			<P class="f60">
				<DIV class="f60"><B>Last Name:</B></DIV>
				<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="LastName" PLACEHOLDER="Last Name"></DIV>
			</P>
			
			<P class="f60">
				<DIV class="f60"><B>County:</B></DIV>
				<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="County" PLACEHOLDER="County"></DIV>
			</P>

			<P class="f60">
				<DIV class="f60"><B>Zipcode:</B></DIV>
				<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="Zipcode" PLACEHOLDER="Zipcode"></DIV>
			</P>
			
			<P class="f60">
				<DIV class="f60"><B>Volunteer Information:</B></DIV>
				<DIV class="f60"><INPUT class="" type="checkbox" NAME="DelegateStatus_AOCDelegate" value="yes">&nbsp;&nbsp;Elected County/State party member</DIV>
				<DIV class="f60"><INPUT class="" type="checkbox" NAME="DelegateStatus_WouldloveToBe" value="yes">&nbsp;&nbsp;Democratic Club member</DIV>
				<DIV class="f60"><INPUT class="" type="checkbox" NAME="DelegateStatus_VolunteerFor" value="yes">&nbsp;&nbsp;Ran for elected office</DIV>
				<DIV class="f60"><INPUT class="" type="checkbox" NAME="DelegateStatus_TimeToRead" value="yes">&nbsp;&nbsp;Elected to goverment position</DIV>
				<DIV class="f60"><INPUT class="" type="checkbox" NAME="DelegateStatus_WasDelegate" value="yes">&nbsp;&nbsp;Never participated in politics</DIV>
			</P>

			<P class="f60">&nbsp;</P>
			
			<P class="f60">
				<DIV class="f60"><B>Partisan Information:</B></DIV>
				<DIV class="f60"><INPUT class="" type="checkbox" NAME="Partisan_DemCounty" value="yes">&nbsp;&nbsp;Elected County/State party member</DIV>
				<DIV class="f60"><INPUT class="" type="checkbox" NAME="Partisan_ClubMember" value="yes">&nbsp;&nbsp;Democratic Club member</DIV>
				<DIV class="f60"><INPUT class="" type="checkbox" NAME="Partisan_RanForOffice" value="yes">&nbsp;&nbsp;Ran for elected office</DIV>
				<DIV class="f60"><INPUT class="" type="checkbox" NAME="Partisan_ElectedToOffice" value="yes">&nbsp;&nbsp;Elected to goverment position</DIV>
				<DIV class="f60"><INPUT class="" type="checkbox" NAME="Partisan_Never" value="yes">&nbsp;&nbsp;Never participated in politics</DIV>
			</P>

			<P class="f60">&nbsp;</P>
			
			<P class="f60">
				<DIV class="f60"><B>Affirmative Action Information:</B></DIV>
				<DIV class="f60"><INPUT class="" type="checkbox" NAME="Affirmative_AfricanAmerican" value="yes">&nbsp;&nbsp;African-American</DIV>
				<DIV class="f60"><INPUT class="" type="checkbox" NAME="Affirmative_Hispanic" value="yes">&nbsp;&nbsp;Hispanic/Latino</DIV>
				<DIV class="f60"><INPUT class="" type="checkbox" NAME="Affirmative_AsianPacific" value="yes">&nbsp;&nbsp;Asian/Pacific</DIV>
				<DIV class="f60"><INPUT class="" type="checkbox" NAME="Affirmative_NativeAmerica" value="yes">&nbsp;&nbsp;Native American</DIV>
				<DIV class="f60"><INPUT class="" type="checkbox" NAME="Affirmative_Disability" value="yes">&nbsp;&nbsp;People with Disabilities</DIV>
				<DIV class="f60"><INPUT class="" type="checkbox" NAME="Affirmative_LGBT" value="yes">&nbsp;&nbsp;LGBTQ</DIV>
				<DIV class="f60"><INPUT class="" type="checkbox" NAME="Affirmative_Youth" value="yes">&nbsp;&nbsp;Youth <I>(18-36)</I></DIV>
				<DIV class="f60"><B>Age:</B></DIV>
				<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="Age" PLACEHOLDER="Age"></DIV>
			</P>
			
			<P class="f60">&nbsp;</P>
			
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
				its services. <B>Draft AOC's content does not reflect the Rep My Block tool.</B>
			</P>
			
</DIV>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
