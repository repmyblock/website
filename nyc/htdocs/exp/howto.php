<?php 
	$BigMenu = "howto";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 	

	/* User is logged */
	
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
			The filing period will begin on <B>March 22<SUP>nd</SUP></B> and end at midnight on March 25<SUP>th</SUP>. 
			<B>You do not need to drop your petitions before March 22<SUP>nd</SUP>.</B>
		<BR>
			Before you drop your petitions, you will need to apply for a Pre Assigned ID Number by 
			<B><A HREF="<?= $FrontEndPDF ?>/NYS/NYC/CRU_PreFile" TARGET="CRU">completing the Petition Pre Assigned Identification Number Application</A></B>
			and mailing it to the Candidate Record Unit at the Board of Election. 
		 <I>(If you have used the RepMyBlock system, <A HREF="<?= $FinalURL ?>/<?= $middleuri ?>/exp/login/login"><B>log into your account</B></A> to download a custom pre-filed one.)</I>
		</P>
		
		<P>
			<CENTER><IMG SRC="/images/202102-BOECalendar.png"></CENTER>
		</P>
	
		<P>&nbsp;<BR></P>
		
		<P CLASS="MediaCenter">
	 <iframe width="560" height="315" src="https://www.youtube.com/embed/lDt7hQFxPB8?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</P>
		
	</DIV>
	</DIV>
</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
