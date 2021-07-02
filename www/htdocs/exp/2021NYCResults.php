<?php
//	$imgtoshow = "/brand/RunWithMe/RunWithMe.png";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV CLASS="right f80">Candidates and member of the Public demanding that the NYC Board of Elections 
		release of the ballots raw data</DIV>

<P>
	
<h4>Candidate for Public Office</h4>


<P style="margin-left: 1.5em">
	<?php /* <B>Joycelyn Taylor</B>, Democratic Candidate for Mayor<BR> */ ?>
	<B>Aaron Foldenauer</B>, Democratic Candidate for Mayor<BR>
	<B>Paperboy Love Prince</B>, Democratic Candidate for Mayor<BR>
	<B>Theo Bruce Chino Tavarez</B>, Democratic Candidate for Public Advocate<BR>
	<B>Alex Pan</B>, Democratic Candidate for Comptroler<BR>
	<B>Robert Elstein</B>, Democratic Candidate for Brooklyn Borough President<BR>
	<?php /* <B>Maria Ordo&ntilde;ez</B>, Candidate for City Council District 7<BR> */ ?>
	<B>Lattina Brown</B>, Democratic Candidate for City Council District 17<BR>
	<B>Badrun Khan</B>, Democratic Candidate for City Council District 26<BR>
	<B>Lutchi Gayot</B>, Democratic Candidate for City Council District 34<BR>
	<B>Rick Echevarria,</B> Democratic Candidate for City Council District 37<BR>
	<B>Cecilia Cortez</B>, Democratic Candidate for City Council District 40<BR>	
</P>

<h4>Party Members</h4>

<P style="margin-left: 1.5em">
	<?php	/* <B>Luis Ordo&ntilde;ez</B>, Male District Leader for AD XX Part X<BR> */ ?>
</P>

<h4>Members of the Public</h4>

<P style="margin-left: 1.5em">
</P>
		
<h4>Members of the Press</h4>
<P style="margin-left: 1.5em">
</P>		
		
		
			<P CLASS="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				it's services.
			</P>
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
