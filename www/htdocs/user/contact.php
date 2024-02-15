<?php 
	$BigMenu = "contact";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 	

	/* User is logged */
	
?>
<div class="main_wopad">
	<DIV class="intro center">
		<DIV class="tadpad">
		<P class="BlueBox w3-blue">Contact Us</P>
	</DIV>
</DIV>

		
		<P class="BckGrndElement f80 center">CONTACT</P>
		
		<P class="f40 adpad">
			<B>Please email 	<B><A HREF="mailto:infos@repmyblock.org">infos@repmyblock.org</A></B> for general inquiries.</B>
		</P>
		
		



			<P class="BckGrndElement f80 center">VOLUNTEER TO MAKE REPMYBLOCK BETTER</P>

		<P class="f40 adpad">
			<B>Rep My Block</B> is an unincorporated organization run by volunteers who donate their skills, knowledge, 
			and resources. RepMyBlock is decentralized to avoid political filling requirements.
		</P>

		
		<P class="f40 adpad">
			<B>Rep My Block</B> relies on Computer Code by volunteers from the <A HREF="https://www.progcode.org" TARGET="ProgCode">Progressive 
			Coders Network</A> repository, such as the  <A HREF="http://www.nationalvoterfile.org" TARGET="NatVoterFile">National Voter File</A> Project. 
			We also thank all the Democratic, Republican, Green, Libertarian, 
			Conservative, Socialists, and Independent candidates who have donated their time, experiences, and data.
		</P>
		
		<P>
		<P class="center f80 adpad"><A HREF="/<?= $middleuri ?>/volunteer/tothecause">To volunteer your time or resources</A></P>
	</P>
							

</DIV>
	


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
