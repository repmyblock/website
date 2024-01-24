<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	// $BigMenu = "represent";
	$Menu = "objections"; 
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_objections.php"; 

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  
	$rmb = new Objections();
	WriteStderr($URIEncryptedString, "URIEncryptedString");	
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);

	if ( ! empty ($_POST["VolumeID"])) {
		WriteStderr($_POST, "Input \$_POST");
		$OjbectionFolder = $rmb->CreateNewObjectionFolder(trim($_POST["VolumeID"]), trim($_POST["NumberSheets"]));		
		header("Location: /" . CreateEncoded ( array( 
								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
								"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
								"Objections_ID" => $OjbectionFolder,								
							)) . "/lgd/objections/addvoter");
			exit();
	}

	$TopMenus = array ( 
						array("k" => $k, "url" => "team/index", "text" => "Team Members"),
						array("k" => $k, "url" => "team/teampetitions", "text" => "Manage Petitions"),
						array("k" => $k, "url" => "team/teamcandidate", "text" => "Setup Teams")
					);
							
	WriteStderr($TopMenus, "Top Menu");					
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) {	 $Cols = "col-12"; $SizeField = " SIZE=10"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Create Objections</h2>
			  </div>
  
			<?php
			 	PlurialMenu($k, $TopMenus);
			?>


			  <div class="clearfix gutter d-flex flex-shrink-0">
		
					<div class="col-16 f40">
	
					<?php if ( ! empty ($URIEncryptedString["ErrorMsg"])) {
						echo "<FONT COLOR=BROWN><B>" . $URIEncryptedString["ErrorMsg"] . "</B></FONT>\n";
					} ?>
		
						
					  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
							<div>
								<dl class="form-group col-5 d-inline-block"> 
									<dt><label for="user_profile_name">Volume ID</label><DT>
									<dd>
										<input class="form-control" type="text" Placeholder="Volume ID" name="VolumeID"<?php if (!empty ($URIEncryptedString["ObjVolumeID"])) { echo " VALUE=\"" . $URIEncryptedString["QueryFirstName"] . "\""; } ?> id="user_profile_name">
									</dd>
								</dl>
			
								<dl class="form-group col-6 d-inline-block"> 
									<dt><label for="user_profile_name">Numbers of Sheets in Volume</label><DT>
									<dd>
										<input class="form-control" type="text" Placeholder="Number of Sheets" name="NumberSheets"<?php if (!empty ($URIEncryptedString["NumberSheets"])) { echo " VALUE=\"" . $URIEncryptedString["QueryLastName"] . "\""; } ?> id="user_profile_name">
									</dd>
								</dl>
							</DIV>
			
							
			
								<p><button type="submit" class="submitred">Create the Objection Folder</button></p>
			
							</form> 
			
							</div>
				  	</div>
			  	</div>
				</div>
			</div>		
		</div>
	</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
