<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	$HeaderTwitter = true;
	$HeaderTwitterPicLink = $FrontEndWebsite . "/brand/tsq/TSQPetition.png";
 	$HeaderTwitterTitle = "Rep My Block – Learn the Petition Process in Times Square on 2/22/26";
	$HeaderTwitterDesc = "Share this invitation with your friends across New York City.";
	$HeaderOGImage = $FrontEndWebsite . "/brand/tsq/TSQPetition.png";
	$HeaderOGImageWidth = "350";
  $HeaderOGImageHeight = "430";
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80">Join us on Times Square on February 22, 2026
	from 8 am to 7 pm</DIV>
	<DIV Class="right f60bold">Run for New York City Political Parties leadership positions</DIV>
<BR>
	
	<TABLE BORDER=0>
		<TR><TD  VALIGN=TOP>
	<IMG SRC="/brand/tsq/TSQPetition.png">
	</TD>
	<TD>&nbsp;</TD>
	<TD VALIGN=TOP>
		
				<P CLASS="f80bold">
					<FONT COLOR=BROWN>Due to inclement weather</FONT>, we are meeting inside the Times Square Station by the mural near the Shuttle Track.
					There is no need to exit the system to find us.
				</P>
	
				<P class="f60">
					Join us inside the Times Square subway station to learn about petitioning for County Committee.
				</P>
				
				<P class="f60">
					<B>Meeting point:</B><BR>
					Inside the Times Square Subway station by the Mural located near the Shuttle Tracks.<BR>
					<del>By the George M. Cohan statue</DEL><BR>
					<DEL>Broadway & West 46th Street</DEL><BR>
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
