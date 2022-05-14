<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "petitions";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();
  $rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
  
  if ( ! empty ($_POST)) {
  	
  	if ( ! empty ($_POST["TYPE"]) && ! empty ($_POST["VALUE"])) {
	  	$result = $rmb->ListRawNYEDByDistricts(trim($_POST["TYPE"]), intval($_POST["VALUE"]));
  	} else {
  		$ErrorMsg = "The Search cannot be empty";
  	}	

  }

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Walk Sheets</h2>
				</div>
				
			  <div class="Box">
					<div class="Box-header pl-0">
						<div class="table-list-filters d-flex">
							<div class="table-list-header-toggle states flex-justify-start pl-3">Walk Sheets</div>
						</div>
			    </div>
			    
			    <div class="Box-body  py-6 js-collaborated-repos-empty">
			    	<FORM ACTION="" METHOD="POST">
			    		
			    	<?php if ( ! empty ($ErrorMsg)) {
			    		
			    		echo "<B><FONT COLOR=BROWN>" . $ErrorMsg . "</FONT><BR>";
			    		
			    	} ?>
			    		
			    		
			    	
			     	<SELECT NAME="TYPE">
			     		<OPTION>&nbsp;</OPTION>	
			     		<OPTION VALUE="AD"<?php if ($_POST["TYPE"] == "AD") { echo " SELECTED"; } ?>>State Assembly District</OPTION>	
			     		<OPTION VALUE="SN"<?php if ($_POST["TYPE"] == "SN") { echo " SELECTED"; } ?>>State Senatorial District</OPTION>	
			     		<OPTION VALUE="CG"<?php if ($_POST["TYPE"] == "CG") { echo " SELECTED"; } ?>>Congressional District</OPTION>	
			    <?php /* 		<OPTION VALUE="County">County District</OPTION>	*/ ?>
			     	</SELECT>
			     	
			    	<INPUT TYPE="TEXT" NAME="VALUE" SIZE=5 VALUE="<?= $_POST["VALUE"] ?>">
		     	 	<button type="submit" class="btn btn-primary">Get the list of Walk Sheets</button>
			     	</FORM>
				</P>	
			    		
			    		
			    </div>
		
				<div class="js-collaborated-repos">
			        
			<?php 
				WriteStderr($result, "ReturnTeamInfo");
				
			if ( ! empty ($result)) {
				 	foreach ($result as $Pet) {
				 		if (! empty ($Pet)) { 
				 			
				 			
				 			?>
				
				 			
							<div class="Box-row simple public js-collab-repo" data-repo-id="43183710" data-owner-id="5959961">
								<svg class="octicon octicon-repo mr-1" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg>
								<B>AD:</B> <?= $Pet["AD"] ?> <B>ED:</B> <?= $Pet["ED"] ?>
										
								<A HREF="/<?= CreateEncoded ( array( 
									"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
									"DataDistrict_ID" => $Pet["DataDistrict_ID"], 
									"ED" => $Pet["ED"],
									"AD" => $Pet["AD"]
									)) ?>/lgd/petitions/walksheets">Download walksheet</A>	
							</div>
			<?php 	}
						}
					}
			?>
			
				</div>
			</div>

			
		</div>
	</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
