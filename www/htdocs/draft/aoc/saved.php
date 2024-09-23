<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_survey.php";	

	$r = new survey();
	preg_match('/\?(.*)/', $_SERVER['REQUEST_URI'], $Match, PREG_OFFSET_CAPTURE);			
	$result = $r->PullSurveyFromRandomKey(trim($Match[1][0]));
		
	$HeaderTwitter = 1;
	$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/draft/DraftAOCForPresidentIn2024.jpg";
	$HeaderTwitterDesc = "To save Democracy, Human Rights, and the Planet. The Status Quo will not make the changes we need to win the future we deserve. Bernie started the Political Revolution, We must finish it together. AOC must take the torch and lead the way forward.";   
	$HeaderTwitterTitle = "Draft AOC for President in 2028";   

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
	<DIV class="right f80 p05">Help Put Socialist Candidates on the Ballot!</DIV>
	
		<h1>Draft AOC for President of the United States in 2028</h1>

			<P class="f60">
				<B>Thank you for filling out the survey!</B>
			</P>
			
			<P CLASS="f60">
				To save your submission, please email the code <B><?= $Match[1][0] ?></B> to 
				<A TARGET="SendEmailSurvey" HREF="mailto:draftaoc@team.repmyblock.org?subject=Save Survey Code <?= $Match[1][0] ?>&body=DO NOT CHANGE THE SUBJECT.\nJust send the email as is for the computer to reply with the link.\nSurveyCode: <?= $Match[1][0] ?>"><B>draftaoc@team.repmyblock.org</B></A> wwith the subject line: 
				<A TARGET="SendEmailSurvey" HREF="mailto:draftaoc@team.repmyblock.org?subject=Save Survey Code <?= $Match[1][0] ?>&body=DO NOT CHANGE THE SUBJECT.\nJust send the email as is for the computer to reply with the link.\nSurveyCode: <?= $Match[1][0] ?>"><B>Save Survey Code <?= $Match[1][0] ?></B></A>.
			</P>

			<P class="f60"><P class="f60">
				<B>You should receive a response with further instructions within a few minutes.</B>
			</P>
			
			<P class="f60">
					Be sure to check your spam or junk folder for the follow-up instructions. In the response, 
					you&rsquo;ll be asked to forward the email to another Rep My Block address, so please watch 
					for that. This email will include a link to create your username and password for 
					the Rep My Block website.
			</P>
			
			<P class="f60">
				<B>Once you log in for the first time</B>, a volunteer from the Draft AOC team will reach out to you. 
				This may take anywhere from 1 day to 2 months, depending on the volume of responses.
			</P>
			
			<P CLASS="f60">
				While complete information about the convention isn&rsquo;t available yet, 
				the Democratic Party of <?= $result["SurveyPresDelInfo_StateName"] ?>
				has published a draft of the Delegate Selection Plan.
				<?= $result["SurveyPresDelInfo_StateName"] ?>
				has been allocated <?= $result["SurveyPresDelInfo_TotalDelegate"] ?>
				delegates, and with enough volunteers like you, we hope to bring AOC to the 2028 DNC Convention.
				published a draft of the <A HREF="<?= $FrontEndStatic . $result["SurveyPresDocuments_RMBURL"] ?>" TARGET="DSP">Delegate Selection Plan</A>.
			</P>
			

				<?php /* For <?= $result["SurveyPresDelInfo_StateName"] ?>, we have until <?= $result["SurveyPresDelInfo_LastDaySwitchParty"] ?>. */ ?>
			
			<P CLASS="f60">
				Don&rsquo;t forget to send your code to <A TARGET="SendEmailSurvey" HREF="mailto:draftaoc@team.repmyblock.org?subject=Save Survey Code <?= $Match[1][0] ?>&body=DO NOT CHANGE THE SUBJECT.\nJust send the email as is for the computer to reply with the link.\nSurveyCode: <?= $Match[1][0] ?>"><B>draftaoc@team.repmyblock.org</B></A>. 
			</P>
			
			<P>
				<BR>
			</P>

			<P CLASS="f60">
				<B>The Draft AOC 2028 Volunteer Team</B>
			</P>
		
		
		<P>
			<BR><BR><BR><BR>
		</P>
		
	<P class="f40">
			By clicking the "Register" button, you are creating a RepMyBlock account and agreeing to RepMyBlock's
			<A HREF="/text/terms">Terms of Use</A> and 
			<A HREF="/text/privacy">Privacy Policy.</A>
		</P>
			

			<P class="f60">
				Watch this 26-minute documentary to understand what it means to be part of the governance of the County Democratic Party. 
			<B><A HREF="/documentary">Click here to watch the whole documentary.</A></B>
				<I>(Press the PLAY button and enter the password <FONT COLOR=BROWN><B>QCC4ALL</B></FONT> (all in uppercase) to access it.)</I>
			</P>
			
	<P class="f60">
				Rep My Block is provided free of charge to any candidate who wishes to use its services.
				<B>Please note that Draft AOC's content is independent of the Rep My Block tool.</B>
			</P>
			
</DIV>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
