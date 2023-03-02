<?php
	$HeaderTwitter = 1;
	$HeaderTwitterPicLink = "https://www.repmyblock.org/images/status/RepMyBlockLiveStatus.jpg";
	$HeaderTwitterDesc = "Political Clubs, these are the current NYC District being represented by a local in district. Please refrain to presenting carpetbaggers.";   
	$HeaderTwitterTitle = "2023 Live Petitioning Status.";   
	
	$HeaderOGImage = $HeaderTwitterPicLink;
	$HeaderOGDescription = $HeaderTwitterDesc;
	$HeaderOGImageWidth = "712";
	$HeaderOGImageHeight = "460";

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";		
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_nolog.php";	

	#$rmb = new NoLog();
	#$StatusList = $rmb->AreaPetition("1374", "ADED");

  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>
<DIV class="main">

        <DIV class="right f80">2023 NYC Petition Status</DIV>


		  <P class="f60">
	     This list is prepared for the party clubs to avoid overlapping candidates. Clubs that want to have access to team and omnibus petitions use code <B>teamleaders</B> in the Team Profile submenu of the Personal Profile.
	       
		  </P>
		  
		  <P class="f60">
		  	You can also share <A HREF="/<?= $middleuri ?>/exp/register/movie">the link to the 26 minutes documentary titled <B>County: A Documentary</B></A>.
		  </P>
		  
			<?php 
				$min =  gmdate("i", time());
				$hour =  gmdate("H", time());
				$rounded_min = floor($min/5) * 5;
				if($rounded_min == 60) {
				   $rounded_min = "00"; $hour++;
				    if ($hour == 24) {
				    	$hour = "00";
				    }
				}
				
				include $StatusDirectory . "/" . $hour . "-" . $rounded_min . ".html";
				echo "\n<!-- Hour: $hour Minute: $rounded_min -->\n";
			?>
	
</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
