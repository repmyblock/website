<?php 
	$Menu = "objections";
	$StateID = "1"; // This is for New York Right now.
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_objections.php";  

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	

	if (! empty ($_POST)) {
		
		header("Location: /" . MergeEncode(array(
																"DataAddress_HouseNumber" => $_POST["HouseNumber"], 
																"DataStreet_Name" => $_POST["StreetName"],
																"DataAddress_zipcode" => $_POST["ZipCode"],
																"DataCounty_ID" => $_POST["County_ID"],
																	"LastName" => $_POST["LastName"],
																	"FirstName" => $_POST["FirstName"],
															)) 
														 . "/lgd/objections/selecthouse");
		exit();
	}

	$rmb = new Objections();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$Party = PrintParty($UserParty);
	$ListCounties = $rmb->GetCountyFromState($StateID);
	
	WriteStderr($rmbperson, "Person");
	
	if ( empty ($URIEncryptedString["SearchedAD"])) {
		$SearchAD = $rmbperson["DataDistrict_StateAssembly"];
		$SearchED = $rmbperson["DataDistrict_Electoral"];
	} else {		
		$SearchAD = $URIEncryptedString["SearchedAD"];
		$SearchED = $URIEncryptedString["SearchedED"];
	}
	
	$result = $rmb->ListBuildingsByADED($SearchAD, $SearchED);	
	WriteStderr($result, "Buildings in District");

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>
<div class="row">
	<div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
				
				<div class="Subhead">
					<h2 class="Subhead-heading">Objections</h2>
				</div>

						<div class="Box">
					  	<div class="Box-header ">
					    
				<P>
					<B>Building in the districts</B>
				</P>
				
				<FORM ACTION="" METHOD="POST">
					<TABLE WIDTH=100%>
						
						<TR ALIGN=CENTER>
							<TH style="padding:0px 10px;">House Number</TH><TD><INPUT TYPE="INPUT" NAME="HouseNumber" VALUE="<?= $HouseNumber ?>" SIZE=2></TD>				
							<TH style="padding:0px 10px;" COLSPAN=4>Street Name</TH><TD><INPUT TYPE="INPUT" NAME="StreetName" VALUE="<?= $StreetName ?>" SIZE=30></TD>
						</TR>
						
						<TR ALIGN=CENTER>
							<TH style="padding:0px 10px;">ZipCode</TD><TD><INPUT TYPE="INPUT" NAME="ZipCode" VALUE="<?= $ZipCode ?>" SIZE=5></TD>
							<TH style="padding:0px 10px;">AD</TH><TD><INPUT TYPE="INPUT" NAME="AD" VALUE="<?= $RepostAD ?>" SIZE=2></TD>								
							<TH style="padding:0px 10px;">ED</TD><TD><INPUT TYPE="INPUT" NAME="ED" VALUE="<?= $RepostED ?>" SIZE=2></TD>
							<TH style="padding:0px 10px;">County</TD>
							<TD>
								<SELECT NAME="County_ID">
									<?php if ( ! empty ($ListCounties)) {
										foreach ($ListCounties as $var) {
											if ( ! empty ($var)) { ?>
												<OPTION VALUE="<?= $var["DataCounty_ID"] ?>"<?= ($rmbperson["DataCounty_ID"] == $var["DataCounty_ID"]) ? " SELECTED" : NULL ?>><?= $var["DataCounty_Name"] ?></OPTION>
												<?php
												}
											}
										}
									?>
								</SELECT>
							</TD>
						</TR>
						<TR ALIGN=CENTER>
							<TH style="padding:0px 10px;" COLSPAN=3>First Name</TH><TD><INPUT TYPE="INPUT" NAME="FirstName" VALUE="<?= $FirstName ?>" SIZE=20></TD>								
							<TH style="padding:0px 10px;">Last Name</TH></TD><TD COLSPAN=3><INPUT TYPE="INPUT" NAME="LastName" VALUE="<?= $LastName ?>" SIZE=20></TD>
						</TR>
						<TR>
							<TH COLSPAN=8 style="padding:0px 10px;"><INPUT TYPE="SUBMIT" NAME="SearchBuilding" VALUE="Search buildings" SIZE=2></TH>
						</TR>		
					</TABLE>
				</DIV>
				
				<div class="list-group-item filtered">
					<TABLE BORDER=1>
					<TR>
						<TH style="padding:0px 10px;">House</TH>
						<TH style="padding:0px 10px;">Frac</TH></TH>
						<TH style="padding:0px 10px;">Pre</TH>
						<TH style="padding:0px 10px;">Street Name</TH>
						<TH style="padding:0px 10px;">PostStreet</TH>
						<TH style="padding:0px 10px;">Zipcode</TH>
						<TH style="padding:0px 10px;">&nbsp;</TH>
					</TR>
										
					<?php 
						if (! empty ($result)) {
							foreach ($result as $var) {
								if (! empty ($var["DataAddress_HouseNumber"] && ! empty($var["DataStreet_Name"]) && ! empty ($var["DataAddress_zipcode"]))) {
					?>		
	
					<TR ALIGN=CENTER>
						<TD style="padding:0px 10px;"><?= $var["DataAddress_HouseNumber"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataAddress_FracAddress"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataAddress_PreStreet"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataStreet_Name"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataAddress_PostStreet"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataAddress_zipcode"] ?></TD>
						<TD style="padding:0px 10px;"><A HREF="/<?= MergeEncode(array(
																	"DataAddress_HouseNumber" => $var["DataAddress_HouseNumber"], 
																	"DataAddress_FracAddress" => $var["DataAddress_FracAddress"],
																	"DataAddress_PreStreet" => $var["DataAddress_PreStreet"],
																	"DataStreet_Name" => $var["DataStreet_Name"],
																	"DataAddress_PostStreet" => $var["DataAddress_PostStreet"],
																	"DataAddress_zipcode" => $var["DataAddress_zipcode"],
																
																)); 
															?>/lgd/objections/selecthouse"><B>See voters</B></A></TD>
					</TR>
					<?php 
								}
							}
						}
					?>
					</TABLE>
				</div>
				</FORM>
		</div>
	</DIV>
</DIV>

</DIV>
</DIV>
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>