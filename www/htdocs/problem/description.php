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
	<DIV class="right f80">Description of the problem</DIV>


<P>
	<DIV class="videowrapper">
		<iframe src="https://www.youtube.com/embed/KtYLNV3_npk" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>
</P>

<P class="f40">
	<B>News Segments:</B> Corruption at the Board of Elections.
</P>

<P>
	<DIV class="videowrapper">
		<iframe src="https://www.youtube.com/embed/q93fQM8ppfk" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>
</P>

<P class="f40">
	<B>Radio Show:</B> How to Work the Political Machine.
</P>

<P>
	<DIV class="videowrapper">
		<iframe  src="https://www.youtube.com/embed/MnI7iBxCN4A" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>
</P>
<P>
	
	

			<P class="f40">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				it's services.
			</P>
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
