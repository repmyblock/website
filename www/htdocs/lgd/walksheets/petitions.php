<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "walksheets";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock(0);
  
  if ( ! empty ($_POST) && $_POST["TYPE"] != "Select a district type") {
  		WriteStderr($_POST, "Post New");	
  	if ( ! empty ($_POST["TYPE"]) && ! empty ($_POST["VALUE"])) {
	  	//$result = $rmb->ListRawNYEDByDistricts(trim($_POST["TYPE"]), intval($_POST["VALUE"]));
	  	$result = $rmb->ListEDByDistricts(trim($_POST["TYPE"]), intval($_POST["VALUE"]), 8);
  	} else {
  		$ErrorMsg = "The Search cannot be empty";
  	}	
  } else {
  	$ErrorMsg = "You must select a district type";
  }	
  
  $rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; $selCols = "col-12";} else { $Cols = "col-9"; }
?>
<DIV class="row">
  <DIV class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<DIV class="<?= $Cols ?> float-left">
				<DIV class="Subhead">
			  	<h2 class="Subhead-heading">Walk Sheets</h2>
				</DIV>
			    <P class="f40 js-collaborated-repos-empty">
			    	<FORM ACTION="" METHOD="POST">
			    		
			    	<?php if ( ! empty ($ErrorMsg)) {
			    		echo "<P><B><FONT COLOR=BROWN>" . $ErrorMsg . "</FONT><BR></P>";
			    	} ?>

			     	<SELECT class="f40 <?= $selCols ?>" NAME="TYPE" PLACEHOLDER="">
			     		<OPTION>Select a district type</OPTION>	
			     		<OPTION VALUE="AD"<?php if ($_POST["TYPE"] == "AD") { echo " SELECTED"; } ?>>State Assembly District</OPTION>	
			     		<OPTION VALUE="SN"<?php if ($_POST["TYPE"] == "SN") { echo " SELECTED"; } ?>>State Senatorial District</OPTION>	
			      <?php /* <OPTION VALUE="CG"<?php if ($_POST["TYPE"] == "CG") { echo " SELECTED"; } ?>>Congressional District</OPTION>	*/ ?>
			    	<?php /* <OPTION VALUE="County">County District</OPTION>	*/ ?>
			     	</SELECT>
			     	
			    	<INPUT class="F40" TYPE="TEXT" NAME="VALUE" SIZE=5 PLACEHOLDER="Enter district number" VALUE="<?= $_POST["VALUE"] ?>">			     	
						<P>	
				    	<SELECT NAME="PARTY" class="f40 <?= $selCols ?>">
				     		<OPTION VALUE="ALL"<?php if ($_POST["PARTY"] == "ALL") { echo " SELECTED"; } ?>>All Parties</OPTION>	
				     		<OPTION VALUE="DEM"<?php if ($_POST["PARTY"] == "DEM") { echo " SELECTED"; } ?>>Democratic</OPTION>	
				     		<OPTION VALUE="REP"<?php if ($_POST["PARTY"] == "REP") { echo " SELECTED"; } ?>>Republican</OPTION>	
				     		<OPTION VALUE="WOR"<?php if ($_POST["PARTY"] == "WOR") { echo " SELECTED"; } ?>>Working Families</OPTION>	
				     		<OPTION VALUE="CON"<?php if ($_POST["PARTY"] == "CON") { echo " SELECTED"; } ?>>Conservative</OPTION>	
				    		<?php /* 	<OPTION VALUE="County">County District</OPTION>	*/ ?>
				     	</SELECT>
				    
				     	<INPUT type="submit" class="" VALUE="Get the list of Walk Sheets">
				    </P>
				    
				    </FORM>	    		
			    </P>
		
			<?php 
				WriteStderr($result, "ReturnTeamInfo");			
				if ( ! empty ($result)) {
			?>
					<DIV class="f60 js-collaborated-repos">
				<?php
				 	foreach ($result as $Pet) {
				 		if (! empty ($Pet)) { 
				 			?>
							<P class="f40">
								<svg class="octicon octicon-repo mr-1" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg>
								<B>AD:</B> <?= $Pet["AD"] ?> <B>ED:</B> <?= $Pet["ED"] ?>
										
								<A HREF="/<?= CreateEncoded ( array( 
									"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
									"DataDistrict_ID" => $Pet["DataDistrict_ID"], 
									"ED" => $Pet["ED"],
									"AD" => $Pet["AD"],
									"PARTY" => $_POST["PARTY"]
									)) ?>/lgd/walksheets/walksheets">Download walksheet</A>	
							</P>
			<?php 	}
						}
					}
			?>
				</DIV>
			</DIV>
		</DIV>
	</DIV>
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
