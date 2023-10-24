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
	<DIV class="right f80 p05">Help put Socialists candidates on the ballot!</DIV>
	
		<h1>Draft AOC for President of the United States for 2028</h1>

			<P class="f60">
				<B>Thanks for filling the survey.</B>
			</P>
			
			<P CLASS="f60">
				In order to save it, you will need to send the code to this	email address <A TARGET="SendEmailSurvey" HREF="mailto:draftaoc@team.repmyblock.org?subject=Save Survey Code <?= $Match[1][0] ?>&body=DO NOT CHANGE THE SUBJECT.\nJust send the email as is for the computer to reply with the link.\nSurveyCode: <?= $Match[1][0] ?>"><B>draftaoc@team.repmyblock.org</B></A> with the following subject: 
				<A TARGET="SendEmailSurvey" HREF="mailto:draftaoc@team.repmyblock.org?subject=Save Survey Code <?= $Match[1][0] ?>&body=DO NOT CHANGE THE SUBJECT.\nJust send the email as is for the computer to reply with the link.\nSurveyCode: <?= $Match[1][0] ?>"><B>Save Survey Code <?= $Match[1][0] ?></B></A>.
			</P>

			<P class="f60"><P class="f60">
				The computer will answer within seconds to about 5 minutes. 
			</P>
			
			<P class="f60">
				Check your junk folder for the rest of the instructions. You will need to forward the response to another Rep My Block email.
				Again you will need to check your spam box for the response which contains a link to create a username and password on the Rep My Block website.
			</P>
			
			<P class="f60">
				Once you loggin for the first time, a Draft AOC team volunteer will contact you. It can be from 1 day to 2 month depending on the amount of
				people responding.
			</P>
			
			<P CLASS="f60">
				All the information about the convention is not yet out but the Democratic party of the state of <?= $result["SurveyPresDelInfo_StateName"] ?>
				published a draft of the <A HREF="<?= $FrontEndStatic . $result["SurveyPresDocuments_RMBURL"] ?>" TARGET="DSP">Delegate Selection Plan</A>.
			</P>
			

			<P CLASS="f60">
				The state of <?= $result["SurveyPresDelInfo_StateName"] ?> is allocated <?= $result["SurveyPresDelInfo_TotalDelegate"] ?> delegates. Hopefully
				we'll find enought volunteer like yourself to draft AOC at the Chicago Convention. 
				For <?= $result["SurveyPresDelInfo_StateName"] ?>, we have until <?= $result["SurveyPresDelInfo_LastDaySwitchParty"] ?>.
			</P>
			
			<P CLASS="f60">
				Don't forget to send the code to <A TARGET="SendEmailSurvey" HREF="mailto:draftaoc@team.repmyblock.org?subject=Save Survey Code <?= $Match[1][0] ?>&body=DO NOT CHANGE THE SUBJECT.\nJust send the email as is for the computer to reply with the link.\nSurveyCode: <?= $Match[1][0] ?>"><B>draftaoc@team.repmyblock.org</B></A>. 
			</P>

			<P CLASS="f60">
				<B>The Draft AOC 2028 volunteer team.</B>
			</P>
		
		<P class="f40">
			By clicking the "Register" button, you are creating a 
			RepMyBlock account, and you agree to RepMyBlock's 
			<A HREF="/text/terms">Terms of Use</A> and 
			<A HREF="/text/privacy">Privacy Policy.</A>
		</P>
			

			
			
			<P class="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services. <B>Draft AOC's content does not reflect the Rep My Block tool.</B>
			</P>
			
</DIV>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
