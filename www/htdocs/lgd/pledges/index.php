<?php 
	$Menu = "pledge";

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_pledges.php";  

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$rmb = new RMBpledges();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$Party = PrintParty($UserParty);
	
	$result = $rmb->ListBuildingsByADED($rmbperson["DataDistrict_StateAssembly"], $rmbperson["DataDistrict_Electoral"]);
	WriteStderr($result, "Buildings in District");

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>
<div class="row">
	<div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
				
				<div class="Subhead">
					<h2 class="Subhead-heading">Pledges</h2>
				</div>
				
				<P>
					<B>Building in the districts</B>
				</P>
				
				<div class="list-group-item filtered">
					<BR>			
												
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
								if (! empty ($var["DataAddress_ID"])) {
					?>		
	
					<TR ALIGN=CENTER>
						<TD style="padding:0px 10px;"><?= $var["DataAddress_HouseNumber"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataAddress_FracAddress"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataAddress_PreStreet"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataStreet_Name"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataAddress_PostStreet"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataAddress_zipcode"] ?></TD>
						<TD style="padding:0px 10px;"><A HREF=""><B>See inside <?= $var["DataHouse_ID"] ?></B></A></TD>
					</TR>
	
					<?php 
								}
							}
						}
					?>
					
					</TABLE>
				</div>
		</div>
	</DIV>
</DIV>

</DIV>
</DIV>
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>