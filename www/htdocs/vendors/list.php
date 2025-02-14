<?php
//	$imgtoshow = "/brand/RunWithMe/RunWithMe.png";
	$HeaderTwitter = 1;
	$HeaderTwitterPicLink = "https://www.repmyblock.org/images/training/ZoomWithPaperboy.png";
	$HeaderTwitterDesc = "Learn how to run for office with Paperboy Love Prince.";   
	$HeaderTwitterTitle = "Paperboy Love Prince interview every politician.";   
	
	$HeaderOGImage = $HeaderTwitterPicLink;
	$HeaderOGDescription = $HeaderTwitterDesc;
	$HeaderOGImageWidth = "450";
	$HeaderOGImageHeight = "253";
		
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
		
	
?>
<DIV class="main">
	<DIV class="right f80">Vendor List</DIV>

<BR>&nbsp;<BR>
<?php /* <h4><P class="f60"></P></h4> */ ?>


<UL>
<P>
	<B><U>COMPETE_</U></B><BR>
	<UL>
		The New Media partner for campaigns, causes, and consultants who want to influence their 
		audience where they are and where they are going.
		<BR>
	<B><A HREF="https://competeeverywhere.com" TARGET="TESTNEW">https://competeeverywhere.com</A></B>
	</UL>
</P>

<P>
	<B><U>FundHero</U></B><BR>
	<UL>
		FundHero was founded by a campaign managers for local races - think City Council, Mayor, State House, etc. 
		The app offers a simple donation page and low cost fundraising / finance reporting app (starting at $4.99/month) specifically designed to help local candidates like you. 
	<BR>
	<B><A HREF="https://fundhero.com" TARGET="TESTNEW">https://fundhero.com</A></B>	
	</UL>
</P>

<P>
	<B><U>North Shore Strategies</U></B><BR>
	<UL>
		North Shore Strategies empowers our clients to deliver on their goals with a powerful mix of 
		data-driven marketing and cutting edge messaging.  We provide high-impact services and strategies 
		to a wide array of for-profit companies and nonprofit organizations including political campaigns, 
		labor unions, and causes. We focus on building power through smart communications, we move the 
		needle so your voice cuts through the noise.
	<BR>
	<B><A HREF="https://nsstrategy.com" TARGET="TESTNEW">https://nsstrategy.com/</A></B>	
	</UL>
</P>

<P>
	<B><U>Kaplan Strategies</U></B><BR>
	<UL>
		Kaplan Strategies is one of the leading companies that own voter lists in all 50 states. 
		We have access to the voter lists that are regularly updated and include the most accurate, 
		up-to-date information.

		Our mission is to use voter lists in any political campaign. Also, we have always been 
		able to provide voter data that is accurate, current, comprehensive, but most of all, 
		simple to use.

		We understand how important voter data is. It is crucial for any campaign, direct mail, 
		phone calls, and online advertising. Accurate and up-to-date voter lists with email 
		content are fundamental for the campaign's success, and that is why we are working 
		hard on updating them.
	<BR>
	<B><A HREF="https://kaplanstrategies.com" TARGET="TESTNEW">https://kaplanstrategies.com</A></B>	
	</UL>
</P>


</UL>



			
			<P class="f40">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				it's services.
			</P>
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
