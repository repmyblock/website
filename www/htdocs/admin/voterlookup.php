<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_admin.php"; 
	
 	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	
	if ( ! empty ($_POST)) {
		WriteStderr($_POST, "POST of VoterLookup");
		
		//function MergeEncode($VariableToPass, $VariableToRemove = "LastTimeUser") {
		header("Location: /" . CreateEncoded ( array( 	
																"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																"SystemAdmin" => $URIEncryptedString["SystemAdmin"],
																"UserDetail" => $var["SystemUser_ID"],
																"MenuDescription" => $URIEncryptedString["MenuDescription"],	
																"Query_FirstName" => $_POST["FirstName"],
																"Query_LastName" => $_POST["LastName"],
																"Query_HouseNumber" => $_POST["HouseNumber"],
																"Query_Address" => $_POST["Address"],
																"Query_AD" => $_POST["AD"],
																"Query_ED" => $_POST["ED"],
																"Query_ZIP" => $_POST["ZIP"],
																"Query_COUNTY" => $_POST["COUNTY"],
																"Query_PARTY" => $_POST["Party"],
																"Query_NYSBOEID" => $_POST["UniqNYS"],
																"Query_Congress" => $_POST["Congress"],					
																)) . "/admin/voterlist");													
		exit();
	}
	
 
	$Party = PrintParty($UserParty);
	$rmb = new RMBAdmin();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	WriteStderr($URIEncryptedString, "URIEncryptedString");
	WriteStderr($rmbperson, "rmbperson");
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Voter Lookup Query</h2>
				</div>

				<form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
					
			
		
			<?php if (! empty ($URIEncryptedString["ErrorMsg"])) {
		    	
		    	echo "<FONT COLOR=BROWN><B>" . $URIEncryptedString["ErrorMsg"] . "</B></FONT>";
		    	echo "<BR><BR>";	
		    } ?>
				
			
				    
				<div class="clearfix gutter d-flex flex-shrink-0">
									
				<div class="col-12">
				  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
				
							
					
							
									<div>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">First Name</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="First" name="FirstName" VALUE="<?= $FormFieldFirstName ?>" id="">
								</dd>
							</dl>

							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Last Name</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Last" name="LastName" VALUE="<?= $FormFieldLastName ?>" id="">
								</dd>
							</dl>
							</div>
							
							
									
									<div>
							<dl class="form-group col-2 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">House Number</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="House Number" name="HouseNumber" VALUE="<?= $FormFieldHouseNumber ?>" id="">
								</dd>
							</dl>

							<dl class="form-group col-46 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Address</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Address" name="Address" VALUE="<?= $FormFieldAddress ?>" id="">
								</dd>
							</dl>
							</div>
							
							
						
								<div>
							
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Zipcode</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Zipcode" name="ZIP" VALUE="<?= $FormFieldZIP ?>" id="">
								</dd>
							</dl>
							
								<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">County</label><DT>
								<dd>
									<SELECT class="mobilebig" NAME="COUNTY">
									<OPTION VALUE="">Whole State</OPTION>
									<OPTION VALUE="NYC"<?php if ($FormFieldCounty == "NYC"  || empty ($FormFieldCounty)) { echo " SELECTED"; } ?>>New York City</OPTION>
									<OPTION VALUE="BQK"<?php if ($FormFieldCounty == "BQK") { echo " SELECTED"; } ?>>Bronx, Queens, and Kings</OPTION>
									<OPTION VALUE="03"<?php if ($FormFieldCounty == "03") { echo " SELECTED"; } ?>>Bronx County (the Bronx)</OPTION>
									<OPTION VALUE="31"<?php if ($FormFieldCounty == "31") { echo " SELECTED"; } ?>>New York County (Manhattan)</OPTION>
									<OPTION VALUE="41"<?php if ($FormFieldCounty == "41") { echo " SELECTED"; } ?>>Queens County</OPTION>
									<OPTION VALUE="43"<?php if ($FormFieldCounty == "43") { echo " SELECTED"; } ?>>Richmond County (Staten Island)</OPTION>
									<OPTION VALUE="24"<?php if ($FormFieldCounty == "24") { echo " SELECTED"; } ?>>Kings County (Brooklyn)</OPTION>
									<OPTION VALUE="OUTSIDE"<?php if ($FormFieldCounty == "OUTSIDE") { echo " SELECTED"; } ?>>Outside New York City</OPTION>
									</SELECT>
								</dd>
							</dl>
							
						</DIV>

					<DIV>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">NYS BOE ID</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="NYS Uniq ID" name="UniqNYS" VALUE="<?= $FormFieldNYSBOEID ?>" id="">
								</dd>
							</dl>
				
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Party</label><DT>
								<dd>
									<SELECT  class="mobilebig" NAME="Party">
										<OPTION VALUE="">All</OPTION>
										<OPTION VALUE="DEM"<?php if ($FormFieldParty == "DEM") { echo " SELECTED"; } ?>>Democratic</OPTION>
										<OPTION VALUE="REP"<?php if ($FormFieldParty == "REP") { echo " SELECTED"; } ?>>Republican</OPTION>
										<OPTION VALUE="BLK"<?php if ($FormFieldParty == "BLK") { echo " SELECTED"; } ?>>No Affiliation</OPTION>
										<OPTION VALUE="GRE"<?php if ($FormFieldParty == "GRE") { echo " SELECTED"; } ?>>Green</OPTION>
										<OPTION VALUE="LBT"<?php if ($FormFieldParty == "LBT") { echo " SELECTED"; } ?>>Libertarian</OPTION>
										<OPTION VALUE="CON"<?php if ($FormFieldParty == "CON") { echo " SELECTED"; } ?>>Conservatives</OPTION>
										<OPTION VALUE="IND"<?php if ($FormFieldParty == "IND") { echo " SELECTED"; } ?>>Independence Party</OPTION>
										<OPTION VALUE="WOR"<?php if ($FormFieldParty == "WOR") { echo " SELECTED"; } ?>>Working Families</OPTION>
										<OPTION VALUE="WEP"<?php if ($FormFieldParty == "WEP") { echo " SELECTED"; } ?>>Women's Equality Party</OPTION>
										<OPTION VALUE="REF"<?php if ($FormFieldParty == "REF") { echo " SELECTED"; } ?>>Reform</OPTION>
										<OPTION VALUE="SAM"<?php if ($FormFieldParty == "SAM") { echo " SELECTED"; } ?>>SAM</OPTION>													
										<OPTION VALUE="OTH"<?php if ($FormFieldParty == "OTH") { echo " SELECTED"; } ?>>Other</OPTION>
									</SELECT>
								</dd>
							</dl>
						</div>

						<div>						
							<dl class="form-group col-2 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Assembly District</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Assembly District" name="AD" VALUE="<?= $RetReturnAD ?>" id="">
								</dd>
							</dl>

							<dl class="form-group col-2 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Electoral District</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Electoral District" name="ED" VALUE="<?= $RetReturnED ?>" id="">
								</dd>
							</dl>					
						</div>
								
						<div>
							<dl class="form-group col-2 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Congressional District</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Congressional District" name="Congress" VALUE="<?= $FormFieldCongress ?>" id="">
								</dd>
							</dl>
						</div>

						<div>						
							<dl class="form-group col-12 d-inline-block"> 
								<dd>
									<button type="submit" class="btn btn-primary mobilemenu">Search User</button>
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