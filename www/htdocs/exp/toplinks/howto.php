<?php 
	$BigMenu = "howto";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 	

	/* User is logged */
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/DeadlineDates.php";	
?>

<div class="main">
	<div class="row">
		<div class="register">				<P>
			<h1 CLASS="intro">How to file</H1>
		</P>
		
		<P CLASS="f60">
			<B>How to file the documents.</B>
		</P>

		<P CLASS="f40">
			The filing period will begin on <B><?= $ImportantDates["NY"]["LongDate"]["FirstSubmitDay"]?></B> 
			and end at midnight on <B><?= $ImportantDates["NY"]["LongDate"]["LastPetitionDay"] ?></B>. 
			<B>You do not need to drop your petitions before <?= $ImportantDates["NY"]["LongDate"]["FirstSubmitDay"]?>.</B>
		<BR>
			Before you drop your petitions, you will need to apply for a Pre Assigned ID Number by 
			<B><A HREF="<?= $FrontEndPDF ?>/BLANK/NY/NYC/CRU_PreFile" TARGET="CRU">completing the Petition Pre Assigned Identification Number Application</A></B>
			and mailing it to the Candidate Record Unit at the Board of Election.
		<BR>
		 <I>(If you have used the RepMyBlock system, <A HREF="/<?= $middleuri ?>/exp/login/login"><B>log into your account</B></A> to download a custom pre-filed one.)</I>
		</P>
		
		<P>
			<DIV class="videowrapper">
				<CENTER>
					<iframe src="https://www.youtube.com/embed/9GfIm72Ksz0?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</CENTER>
			</DIV>
		</P>
		
	</DIV>
	</DIV>
</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
