<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
	
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username"; $TypeTel = "telephone";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; $TypeTel = "text"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";
	$r = new welcome();	
	
	if (! empty($_POST)) {
		WriteStderr($_POST, "POST");	
		
		if ( ! empty($_POST["emailaddress"]) || ! empty($_POST["cellphone"])) {
			$r->SaveReferral($_POST["emailaddress"], $_POST["cellphone"]); 
			
			if ( ! empty($_POST["emailaddress"])) {
				WriteStderr($_POST["emailaddress"], "email");	
				require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";
				SendReferralWelcome($_POST["emailaddress"]);
			}
		}
		
		header("Location: /exp/share/qrcode");
		exit();
		
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	
?>
<DIV class="main">
		
	<DIV CLASS="right f80">Waiting in line to vote</DIV>

	
	
	<FORM METHOD="POST" ACTION="">	

																					
		<P CLASS="f60">
			Rep My Block will sent you information about the process at the end of December 2020 or January 2021 on 
			how to get involved. 
		</P>	
	
		<P CLASS="f60">
			Please give us either your email or your cell phone number.
		</P>
		
		<P CLASS="f80">
			<DIV CLASS="f80">Email:</DIV> 
			<DIV><INPUT CLASS="" type="<?= $TypeEmail ?>" autocorrect="off" autocapitalize="none" NAME="emailaddress" PLACEHOLDER="you@email.net" VALUE="<?= $_POST["emailaddress"] ?>"><DIV>
		</P>
		
		<BR>
		
		<P CLASS="f80">
			<DIV CLASS="f80">Cell Phone:</DIV> 
			<DIV><INPUT CLASS="" type="<?= $TypeTel ?>" autocorrect="off" autocapitalize="none" NAME="cellphone" PLACEHOLDER="1 (212) 555-1212" VALUE="<?= $_POST["emailaddress"] ?>"><DIV>
		</P>
			
		<BR>
			
		<P>
			<DIV><INPUT CLASS="" TYPE="Submit" NAME="SaveInfo" VALUE="Receive Information"></DIV>
		</P>
		
		<P CLASS="f40">
			By clicking the <B>"Receiving Information By Email"</B> button, 
			you are acknoleging to accept to receive email by <?= $CampaignName ?> the campaign. 
			RepMyBlock is a tool used by <?= $CampaignName ?> and the data available is collected
			trought the Voter Information file available freely to any candidate and citizen.
			<A HREF="/exp/<?= $middleuri ?>/terms">Terms of Use</A> and 
			<A HREF="/exp/<?= $middleuri ?>/privacy">Privacy Policy.</A>
		</P>
	
	

	
	
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>