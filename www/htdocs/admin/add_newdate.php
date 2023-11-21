<?php
	$Menu = "admin";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 

	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$rmb = new repmyblock();	
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$rmbstates = $rmb->ListStates();
	
	if ( ! empty ($_POST)) {
		
		echo "<PRE>" . print_r($_POST, 1) . "</PRE>";
		$ElectionText = trim($_POST["ElectText"]);
		$ElectionDate = trim($_POST["ElectionDate"]);
		$ElectionStateID = trim($_POST["State_ID"]);
		$ElectionType = trim($_POST["ElectionType"]);
		
		$result = $rmb->AddElectionDates($ElectionText, $ElectionDate, $ElectionStateID, $ElectionType);
		
		exit();
	}

	//	function ListElectionsDates ($limit = 50, $start = 0, $futureonly = false, $StateID = NULL) {
	$result = $rmb->ListElectionsDates();
	WriteStderr($result, "ListElections");
	
	$TopMenus = array ( 						
		array("k" => $k, "url" => "../admin/setup_elections", "text" => "Elections Dates"),
		array("k" => $k, "url" => "../admin/setup_dates", "text" => "Election Positions"),
		array("k" => $k, "url" => "../admin/setup_candidate", "text" => "Candidate")
	);


	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }	
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="<?= $DIVCol ?> float-left">

				<div class="Subhead">
			  	<h2 class="Subhead-heading">Elections Dates</h2>
				</div>
			
			<?php 
				if ($VerifEmail == true) { 
					include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_emailverif.php";
				} else if ($VerifVoter == true) {
					include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_voterinfo.php";
				} 
			?>          
			
			<?php if (! empty ($URIEncryptedString["ErrorMsg"])) {
		    	
		    	echo "<FONT COLOR=BROWN SIZE=+1><B>" . $URIEncryptedString["ErrorMsg"] . "</B></FONT>";
		    	echo "<BR><BR>";	
		    } ?>
				
				
					
				<B>Add a new date to canlendar</B>
				    
				<div class="clearfix gutter d-flex flex-shrink-0">
									
				<div class="col-12">
				  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
						<div>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Election Text</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Election Text" name="ElectText" VALUE="<?= $FormFieldPositionName ?>" id="">
								</dd>
							</dl>

							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Election Date</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="ElectionDate" name="ElectionDate" VALUE="<?= $FormFieldDBTable ?>" id="">
								</dd>
							</dl>
							
							</div>
							
						
						<div>
							
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Position State</label><DT>
								<dd>
									<SELECT class="mobilebig" NAME="ElectionState">
										<OPTION VALUE="">&nbsp;</OPTION>
										<?php foreach($rmbstates as $var) { ?>
											<OPTION VALUE="<?= $var["DataState_ID"] ?>"<?php if ($FormFieldType == $var["DataState_ID"]) { echo " SELECTED"; } ?>><?= $var["DataState_Name"] ?></OPTION>
										<?php } ?>
									<OPTION VALUE="other"<?php if ($FormFieldType == "other") { echo " SELECTED"; } ?>>Other</OPTION>
									</SELECT>
								</dd>
							</dl>
							
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Type of Position</label><DT>
								<dd>
									<SELECT class="mobilebig" NAME="ElectionType">
									<OPTION VALUE="">&nbsp;</OPTION>
									<OPTION VALUE="primary"<?php if ($FormFieldType == "primary") { echo " SELECTED"; } ?>>Primary</OPTION>
									<OPTION VALUE="general"<?php if ($FormFieldType == "general") { echo " SELECTED"; } ?>>General</OPTION>
									<OPTION VALUE="special"<?php if ($FormFieldType == "special") { echo " SELECTED"; } ?>>Special</OPTION>
									<OPTION VALUE="other"<?php if ($FormFieldType == "other") { echo " SELECTED"; } ?>>Other</OPTION>
									</SELECT>
								</dd>
							</dl>
							
						</DIV>
		
			

						<div>						
							<dl class="form-group col-12 d-inline-block"> 
								<dd>
									<button type="submit" class="submitred">Add New Date</button>
								</dd>
							</dl>
						</div>
					</form> 


				</div>
			</div>
		</div>
	</DIV>
</div>	

</DIV>
</DIV>
</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>