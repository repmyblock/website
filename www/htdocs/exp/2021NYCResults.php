<?php
//	$imgtoshow = "/brand/RunWithMe/RunWithMe.png";

	$TwitterImage = "https://static.repmyblock.nyc/pics/paste/AddYourName.png";
	$TwitterDesc = "These candidates are calling for @BOENYC to release the raw data so the results can be independently tabulated.";

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV CLASS="right f80">Candidates and member of the	Public demanding 
		that the NYC Board of Elections release of the ballots raw data
	</DIV>

<DIV CLASS="f60"><B>Candidate for Public Office</B></DIV>
<P CLASS="f40" style="margin-left: 1.5em">
	<B>Joycelyn Taylor</B>, Democratic Candidate for Mayor<BR>
	<?php /* <B>Aaron Foldenauer</B>, Democratic Candidate for Mayor<BR> */ ?>
	<B>Paperboy Love Prince</B>, Democratic Candidate for Mayor<BR>
	<B>Art Chang</B>, Democratic Candidate for Mayor<BR>
	<B>Theo Bruce Chino Tavarez</B>, Democratic Candidate for Public Advocate<BR>
	<B>Alex Pan</B>, Democratic Candidate for Comptroler<BR>
	<B>Kimberly Watkins</B>, Democratic Candidate for Manhattan Borough President<BR>
	<B>Robert Elstein</B>, Democratic Candidate for Brooklyn Borough President<BR>
	<B>Edward Irizarry</B>, Democratic Candidate for Judge of the Civil Court 2<SUP>nd</SUP> Municipal District<BR>
	<B>Kim Moscaritolo</B>, Democratic Candidate for City Council District 5<BR>
	<?php /* <B>Maria Ordo&ntilde;ez</B>, Candidate for City Council District 7<BR> */ ?>
	<?php /* <B>Lena Melendez</B>, Candidate for City Council District 7<BR> */ ?>
	<?php /* <B>Marti Allen-Cummings</B>, Candidate for City Council District 7<BR> */ ?>
	<B>Keith Harris</B>, Candidate for City Council District 7<BR>
	<B>Sheba Simpson-Amsterdam</B>, Candidate for City Council District 9<BR>
	<B>Shanequa Moore</B>, Candidate for City Council District 12<BR>
	<B>Lattina Brown</B>, Democratic Candidate for City Council District 17<BR>
	<B>Adriana Aviles</B>, Democratic Candidate for City Council District 19<BR>
	<B>Moumita Ahmed</B>, Democratic Candidate for City Council District 24<BR>
	<B>Badrun Khan</B>, Democratic Candidate for City Council District 26<BR>
	<B>Emily Sharpe </B>, Democratic Candidate for City Council District 26<BR>
	<B>Lutchi Gayot</B>, Democratic Candidate for City Council District 34<BR>
	<B>Rick Echevarria,</B> Democratic Candidate for City Council District 37<BR>
	<B>Cecilia Cortez</B>, Democratic Candidate for City Council District 40<BR>
	<B>Harriet Hines</B>, Democratic Candidate for City Council District 40<BR>
	<B>Anthony Beckford</B>, Democratic Candidate for City Council District 45<BR>
	<?php /* <B>Luis Ordo&ntilde;ez</B>, Male District Leader for AD 70<SUP>th</SUP> AD Part D<BR> */ ?>
	<B>Esther Yang</B>, Democratic Candidate for Female District Leader 76<SUP>th</SUP> AD Part A<BR>
</P>

<DIV CLASS="f60"><B>Previous Candidate for Public Office</B></DIV>
<P CLASS="f40" style="margin-left: 1.5em">
	<B>Jared Rich</B>, Candidate for Public Advocate, 2019 Special Election<BR>
	<B>Steve Lee</B>, Democratic Candidate for NYS Assembly District 40, 2020<BR>
</P>

<DIV CLASS="f60"><B>Party Members</B></DIV>
<P CLASS="f40" style="margin-left: 1.5em">
	<B>Christine Tuaillon</B>, Queens County Democratic Party Committee Member<BR>
</P>

<DIV CLASS="f60"><B>Members of the Public</B></DIV>
<P CLASS="f40" style="margin-left: 1.5em">
</P>
		
<DIV CLASS="f60"><B>Members of the Press</B></DIV>
<P CLASS="f40" style="margin-left: 1.5em">
</P>		
		
		
			<P CLASS="f30">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services.
			</P>
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
