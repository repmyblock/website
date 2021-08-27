<?php 	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	

	if ( ! empty($_POST)) {
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";  
	
		WriteStderr($_POST, "Welcome Post");		
		$r = new welcome();		
		
		$FirstName = titleCase($_POST["FirstName"]);
		$RefName = titleCase($_POST["RefName"]);
		
		$ReferenceID = $r->SaveReferral($_POST["Email"], NULL, $RefName, $FirstName, "yes");
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";
		SendReferralWelcome($_POST["Email"], $FirstName, $RefName,  $ReferenceID);
		header("Location: /exp/" . CreateEncoded (
				array( 
					"FirstName" => $FirstName,
					"RefName" => $RefName,
					"ReferenceID" => $ReferenceID
				)) . "/sentreferal");
		exit();
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 	
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>

<div class="main">
	<DIV CLASS="right f80">Nominate</DIV>
	
	
		<P CLASS="f40">
			
				If you know someone that would be perfect to represent their block
				for the County Committee position, 
				please let us know and we'll send them an email 
				with instructions.
			
		</P>
		
		<FORM ACTION="" METHOD="POST">
		<P CLASS="f80">
			<DIV CLASS="f80">Your name:</DIV> 
			<DIV><INPUT CLASS="" type="<?= $TypeUsername ?>" autocorrect="off" autocapitalize="none" NAME="RefName" PLACEHOLDER="Your name" VALUE="<?= $_POST["RefName"] ?>"><DIV>
		</P>
		<P CLASS="f80">
			<DIV CLASS="f80">Your friend first name:</DIV>
			<DIV><INPUT CLASS="" type="<?= $TypeUsername ?>" autocorrect="off" autocapitalize="none" NAME="FirstName" PLACEHOLDER="First name" VALUE="<?= $_POST["FirstName"] ?>"></DIV>
		</P>
		<P CLASS="f80">
			<DIV CLASS="f80">Your friend email address:</DIV> 
			<DIV><INPUT CLASS="" type="<?= $TypeEmail ?>" autocorrect="off" autocapitalize="none" NAME="Email" PLACEHOLDER="you@email.net" VALUE="<?= $_POST["Email"] ?>"><DIV>
		</P>
		<P CLASS="f80">
			<DIV><INPUT CLASS="" TYPE="Submit" NAME="SaveInfo" VALUE="Send the information"></DIV>
		</P>
		</FORM>
				
							
		<P CLASS="f40">
			Rep My Block is a non-partisan effort to get New Yorkers to a party leadership that represent their collective value. 
			
		</P>

<?php /*		
		<P>
			<link rel="stylesheet" href="/maps/RepMyBlockMaps.1f948dd0.css">
			<div id="map" class="map"></div>
		  <span id="status"></span>
		  <script src="/maps/RepMyBlockMaps.c7bbff3b.js"></script>
	  </P>
	 */ ?>
		
		<P CLASS="f80 center"><A HREF="/exp/<?= $middleuri ?>/register">Register on the Rep My Block website</A></P>
	</DIV>

</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>