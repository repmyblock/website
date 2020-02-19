<?php
	$imgtoshow = "/RunWithMe/RunWithMe.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
	
?>
<DIV class="main">
	<DIV CLASS="right f80">Run With Me</DIV>

			<P>
				<A HREF="register/">Register to download your petition and your walk sheet</A>
			</P>
			
				<P>
				Paperboy Prince is running for Congress in the 7<sup>th</sup> Congressional District and you can 
				access his website at <a href="https://paperboyprince.com/volunteer">https://paperboyprince.com/volunteer</a>	
			</P>
			
			
			<P>
				<iframe width="560" height="315" src="https://www.youtube.com/embed/3_BMIjWozLw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</P>
	
		
			<P>
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				it's services.
			</P>
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php"; ?>
