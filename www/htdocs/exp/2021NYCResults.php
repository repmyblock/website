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
	<B>Joycelyn Taylor</B>, Candidate for Mayor<BR>
	<B>Aaron Foldenauer</B>, Candidate for Mayor<BR>
	<B>Paperboy Love Prince</B>, Candidate for Mayor<BR>
	<B>Theo Bruce Chino Tavarez</B>, Candidate for Public Advocate<BR>
	<B>Maria Ordo&ntilde;ez</B>, Candidate for City Council District 7<BR>
	<B>Lattina Brown</B>, Candidate for City Council District 17<BR>
	<B>Badrun Khan</B>, Candidate for City Council District 26<BR>
	<B>Lutchi Gayot</B>, Candidate for City Council District 34<BR>
	<B>Rick Echevarria,</B> Candidate for City Council District 37<BR>
	<B>Cecilia Cortez</B>, Candidate for City Council District 40<BR>	
</P>

<h4>Members of the Democratic Parties</h4>

<P style="margin-left: 1.5em">
		<B>Luis Ordo&ntilde;ez</B>, Male District Leader for AD XX Part X<BR>
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
