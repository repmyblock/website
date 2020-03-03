<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";
	$BigMenu = "represent";	
	 
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 

  if (empty ($SystemUser_ID)) { goto_signoff(); }
	$rmb = new repmyblock();

	if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);
	
	if (!empty($_POST)) {		
		$EncryptURL = $Decrypted_k . "&Query_FirstName=" . urlencode(trim($_POST["FirstName"])) . 
									"&Query_LastName=" . urlencode(trim($_POST["LastName"])) .
									"&Query_AD=" . urlencode(trim($_POST["AD"])) . "&Query_ED=" . urlencode(trim($_POST["ED"])) . 
									"&Query_ZIP=" . urlencode(trim($_POST["ZIP"])) . "&Query_COUNTY=" . urlencode(trim($_POST["COUNTY"])) . 
									"&Query_PARTY=" . urlencode($_POST["Party"]) . "&Query_NYSBOEID=" . urlencode(trim($_POST["UniqNYS"])) .
									"&Query_Congress=" . urlencode(trim($_POST["Congress"]));
		header("Location: voterlist/?k=" . EncryptURL($EncryptURL));		
		exit();
	}

	$FormFieldParty = $URIEncryptedString["UserParty"];

	if ( ! empty ($URIEncryptedString["RetReturnFirstName"])) { $FormFieldFirstName = $URIEncryptedString["RetReturnFirstName"]; }
	if ( ! empty ($URIEncryptedString["RetReturnLastName"])) { $FormFieldLastName = $URIEncryptedString["RetReturnLastName"]; }
	if ( ! empty ($URIEncryptedString["RetReturnAD"])) { $FormFieldAD = $URIEncryptedString["RetReturnAD"];  }
	if ( ! empty ($URIEncryptedString["RetReturnED"])) { $FormFieldED = $URIEncryptedString["RetReturnED"]; }
	if ( ! empty ($URIEncryptedString["RetReturnZIP"])) { $FormFieldZIP = $URIEncryptedString["RetReturnZIP"]; }
	if ( ! empty ($URIEncryptedString["RetReturnCOUNTY"])) { $FormFieldCounty = $URIEncryptedString["RetReturnCOUNTY"]; }
	if ( ! empty ($URIEncryptedString["RetReturnNYSBOEID"])) { $FormFieldNYSBOEID = $URIEncryptedString["RetReturnNYSBOEID"]; }
	if ( ! empty ($URIEncryptedString["RetReturnCongress"])) { $FormFieldCongress = $URIEncryptedString["RetReturnCongress"]; }
	if ( ! empty ($URIEncryptedString["RetReturnPARTY"])) { $FormFieldParty = $URIEncryptedString["RetReturnPARTY"]; }

	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/menu.php"; ?>
			<div class="col-9 float-left">

				<div class="Subhead">
			  	<h2 class="Subhead-heading">Voter Lookup</h2>
				</div>
			
			<?php 
				if ($VerifEmail == true) { 
					include $_SERVER["DOCUMENT_ROOT"] . "/warnings/emailverif.php";
				} else if ($VerifVoter == true) {
					include $_SERVER["DOCUMENT_ROOT"] . "/warnings/voterinfo.php";
				} 
			?>          
			
			<?php if (! empty ($ErrorMsg)) {
		    	
		    	echo "<FONT COLOR=BROWN SIZE=+1><B>" . $URIEncryptedString["ErrorMsg"] . "</B></FONT>";
		    	
		    } ?>
				
				<BR><BR>
				
				<B><FONT COLOR="BROWN">Some query combination are not possible.</FONT></B><BR>
				Try them but if you get a page that says: <I><B>"The Assembly District cannot be empty"</B></I>, 
				it means that that query combination does not work.
				    
				<div class="clearfix gutter d-flex flex-shrink-0">
									
				<div class="col-16">
				  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
						<div>
							<dl class="form-group col-3 d-inline-block"> 
								<dt><label for="user_profile_name">First Name</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="First" name="FirstName" VALUE="<?= $FormFieldFirstName ?>" id="">
								</dd>
							</dl>

							<dl class="form-group col-3 d-inline-block"> 
								<dt><label for="user_profile_name">Last Name</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Last" name="LastName" VALUE="<?= $FormFieldLastName ?>" id="">
								</dd>
							</dl>
							
							</div>
							
						
								<div>
							
							<dl class="form-group col-3 d-inline-block"> 
								<dt><label for="user_profile_name">Zipcode</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Zipcode" name="ZIP" VALUE="<?= $FormFieldZIP ?>" id="">
								</dd>
							</dl>
							
								<dl class="form-group col-3 d-inline-block"> 
								<dt><label for="user_profile_name">County</label><DT>
								<dd>
									<SELECT NAME="COUNTY">
									<OPTION VALUE="">Whole State</OPTION>
									<OPTION VALUE="NYC"<?php if ($FormFieldCounty == "NYC") { echo " SELECTED"; } ?>>New York City</OPTION>
									<OPTION VALUE="BQK"<?php if ($FormFieldCounty == "BQK" || empty ($FormFieldCounty)) { echo " SELECTED"; } ?>>Bronx, Queens, and Kings</OPTION>
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
							<dl class="form-group col-3 d-inline-block"> 
								<dt><label for="user_profile_name">NYS BOE ID</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="NYS Uniq ID" name="UniqNYS" VALUE="<?= $FormFieldNYSBOEID ?>" id="">
								</dd>
							</dl>
				
							<dl class="form-group col-3 d-inline-block"> 
								<dt><label for="user_profile_name">Party</label><DT>
								<dd>
									<SELECT NAME="Party">
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
							<dl class="form-group col-3 d-inline-block"> 
								<dt><label for="user_profile_name">Assembly District</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Assembly District" name="AD" VALUE="<?= $RetReturnAD ?>" id="">
								</dd>
							</dl>

							<dl class="form-group col-3 d-inline-block"> 
								<dt><label for="user_profile_name">Electoral District</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Electoral District" name="ED" VALUE="<?= $RetReturnED ?>" id="">
								</dd>
							</dl>					
						</div>
								
						<div>
							<dl class="form-group col-3 d-inline-block"> 
								<dt><label for="user_profile_name">Congressional District</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Congressional District" name="Congress" VALUE="<?= $FormFieldCongress ?>" id="">
								</dd>
							</dl>
						</div>

						<div>						
							<dl class="form-group col-3 d-inline-block"> 
								<dd>
									<button type="submit" class="btn btn-primary">Search Voter Registration</button>
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






<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";	?>