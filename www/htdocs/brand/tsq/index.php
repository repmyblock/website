<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	$imgtoshow = "/brand/RunWithMe/RunWithMe.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80">Join us on Times Square on February 22, 2026</DIV>
	<DIV Class="right f60">Run for New York City Political Parties leadership positions</DIV>
<BR>
	
	<TABLE BORDER=0>
		<TR><TD  VALIGN=TOP>
	<IMG SRC="/brand/tsq/TSQPetition.png">
	</TD>
	<TD>&nbsp;</TD>
	<TD VALIGN=TOP>
	
				<P class="f60">
					Join us inside the Times Square subway station to learn about petitioning for County Committee.
				</P>
				
				<P class="f60">
					<B>Meeting point:</B>
					By the <B>George M. Cohan statue</B><BR>
					Broadway & West 46th Street<BR>
					<I>If the weather is too cold or if it is raining, we will meet inside the subway by the shuttle tracks.</i></B>
				</P>
				
				<P class="f60">
					Rep My Block is looking for Democrats and Republicans to run for County leadership positions in 2026. The time commitment is only 22 hours per year.
				</P>

				<P class="f60">
					Watch this 26-minute documentary explaining what it means to be part of the governance of a County Democratic Party. Stream it on PBS:
					<B><A HREF="https://pbs.org/video/county-kigzrj">https://pbs.org/video/county-kigzrj</A></B>.
				</P>
				
				<P class="f60">
				To stay up to date, please <B><A HREF="https://www.mobilize.us/repmyblock/event/878129/">register using the Mobilize link</A></B>.
				</P>
			
	</TD></TR>
	</TABLE>
	
				
				
		
			<P class="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services.
			</P>
		

</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
