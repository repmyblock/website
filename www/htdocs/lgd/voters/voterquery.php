<?php
  if ( ! empty ($k)) { $MenuLogin = "logged";  }  
  $Menu = "voters";
  $BigMenu = "represent";  
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_searchvoters.php";  

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}  
  $Party = PrintParty($URIEncryptedString["UserParty"]);

  if (! empty($_POST)) {  
    // This will be different answer depending
    $finalurl = "voters/voterquery";
     
    header("Location: /" .  CreateEncoded ( [
								"Query_Made" => 1, 
			          "Query_FirstName" => $_POST["FirstName"],
			          "Query_LastName" => $_POST["LastName"], 
			          "Query_AD" => $_POST["AD"],
			          "Query_ED" => $_POST["ED"],
			          "Query_HouseNumber" => $_POST["HouseNumber"],
			          "Query_StreetName" => $_POST["StreetName"],
			          "Query_ZIP" => $_POST["ZIP"],
			          "Query_COUNTY" => $_POST["CountyID"],
			          "Query_PARTY" => $_POST["Party"],
			          "Query_BOEID" => $_POST["BOECountyID"],
			          "Query_BOEStateID" => $_POST["BOEStateID"],
			          "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
			          "FirstName" => $URIEncryptedString["FirstName"],
			          "LastName" => $URIEncryptedString["LastName"],
			          "UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
			          "SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
			          "EDAD" => $URIEncryptedString["EDAD"]
			    ]) . "/lgd/" . $finalurl);
    exit();
  }

  $rmb = new SearchVoters();  
  $ListCounties = $rmb->GetCountyFromState('1');
  $rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
  $TopMenus = [
    ["k" => $k, "url" => "voters/voterlist", "text" => "District Voters"],
    ["k" => $k, "url" => "voters/voterquery", "text" => "Search Voter"]
  ];      
  WriteStderr($TopMenus, "Top Menu");
  
  if (! empty ($URIEncryptedString["Query_Made"])) {
	  $ListVoterAtAddress = $rmb->VoterSearch(
      [
      	"HouseNumber" => $URIEncryptedString["Query_HouseNumber"], 
        "FracAddress" => $URIEncryptedString["DataAddress_FracAddress"], 
     	  "PreStreet" => $URIEncryptedString["DataAddress_PreStreet"], 
      	"StreetName" => $URIEncryptedString["Query_StreetName"], 
        "PostStreet" => $URIEncryptedString["DataAddress_PostStreet"], 
        "Zipcode" => $URIEncryptedString["Query_ZIP"],
        "County" => $URIEncryptedString["Query_COUNTY"], 
        "FirstName" => $URIEncryptedString["Query_FirstName"],
        "LastName" => $URIEncryptedString["Query_LastName"],
        "BOEVSNID" => $URIEncryptedString["Query_BOEID"],
        "BOEStateID" => $URIEncryptedString["Query_BOEStateID"],
      ]
  	);
  }
    
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
  // if ($MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>

    <div class="row layout">
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
      <div class="main">
        <div class="col-full">
          <div class="Subhead">
            <h2 class="Subhead-heading">Voters</h2>
          </div>
          <?php PlurialMenu($k, $TopMenus); ?>
            
          <FORM ACTION="" METHOD="POST">  
              
            <div class="clearfix gutter d-flex flex-shrink-0">
              <div class="list-group-item filtered">
       
	              <div class="voter-form">
	                <div class="field" style="grid-column: span 6;">
	                  <input type="text" id="FirstName" name="FirstName" class="input" placeholder=" "  VALUE="<?= $Query_FirstName ?>">
	                  <label for="FirstName">First Name</label>
	                </div>
	               
	                <div class="field" style="grid-column: span 6;"> 
	                  <input type="text" id="" name="LastName" class="input" placeholder=" "  VALUE="<?= $Query_LastName ?>">
	                  <label for="LastName">Last Name</label>
	                </div>  
                </DIV>

								<div class="voter-form">
  								<div class="field" style="grid-column: span 2;">
                 		<input type="text" id="HouseNumber" name="HouseNumber" class="input" placeholder=" " VALUE="<?= $Query_HouseNumber ?>">
                  	<label for="HouseNumber">Number</label>
                	</div>
          
                
		  						<div class="field" style="grid-column: span 6;">		
    	              <input type="text" id="StreetName" name="StreetName" class="input" placeholder=" "  VALUE="<?= $Query_StreetName ?>">
      	            <label for="StreetName">Street Name</label>
               		</div>

	                <div class="field" style="grid-column: span 4;">
	                  <input type="text" id="ZipCode" name="ZipCode" class="input" placeholder=" "  VALUE="<?= $Query_ZIP ?>">
	                  <label for="ZipCode">Zip Code</label>
	                </div>
                
	              </DIV>
  
              	<div class="voter-form">

	                <div class="field" style="grid-column: span 2;">
	                  <input type="text" id="AD" name="AD" class="input" placeholder=" "  VALUE="<?= $Query_AD ?>">
	                  <label for="AD">AD</label>
	                </div>

	                <div class="field" style="grid-column: span 2;">
	                  <input type="text" id="ED" name="ED" class="input" placeholder=" "  VALUE="<?= $Query_ED ?>">
	                  <label for="ED">ED</label>
	                </div>

      
<STYLE>
        

.voter-form {
  display: grid;
  grid-template-columns: repeat(12, 1fr);
  gap: 16px;
  align-items: end;
}

</STYLE>       
  
          
                    <div class="field field-select" style="grid-column: span 8;">
                     	 <select id="CountyID" name="CountyID" class="select" >
    												<option value="" disabled selected hidden></option>
                    
<?php                 if ( ! empty ($ListCounties)) {
                        foreach ($ListCounties as $var) {
                          if ( ! empty ($var)) { 
?>
                            <OPTION VALUE="<?= $var["DataCounty_ID"] ?>"<?= ($rmbperson["DataCounty_ID"] == $var["DataCounty_ID"]) ? " SELECTED" : NULL ?>><?= $var["DataCounty_Name"] ?></OPTION>
<?php
                            }
                          }
                        }
?>
                    </SELECT>
                    <label for="CountyID">County<SUP>*</SUP></label>
                   </DIV>
                    </DIV>
                
                  
                  <div class="voter-form">
           
                  <div class="field" style="grid-column: span 6;">
                    <input type="text" id="BOECountyID" name="BOECountyID" class="input" placeholder=" "  VALUE="<?= $Query_BOEID ?>">
                    <label for="BOECountyID">BOE County ID</label>
                  </div>
                  
                  <div class="field" style="grid-column: span 6;">
                    <input type="text" id="BOEStateID" name="BOEStateID" class="input" placeholder=" "  VALUE="<?= $Query_BOEStateID ?>">
                    <label for="BOEStateID">Voter Serial Number</label>
                  </div>

								</DIV>

                  <DIV style="grid-column: span 12;"><INPUT TYPE="SUBMIT" NAME="SearchBuilding" VALUE="Search buildings"></DIV>
              
              
           </DIV>
         </DIV>
              
              
             <PRE><?= print_r($URIEncryptedString, 1) ?></PRE>
              
              
                      <div class="list-group-item filtered">
                       
                      <TABLE BORDER =1>
                        <TR>
                          <TH style="padding:0px 10px;">House</TH>
                          <TH style="padding:0px 10px;">Frac</TH>
                          <TH style="padding:0px 10px;">Pre</TH>
                          <TH style="padding:0px 10px;">Street Name</TH>
                          <TH style="padding:0px 10px;">PostStreet</TH>
                          <TH style="padding:0px 10px;">Zipcode</TH>
                          <TH style="padding:0px 10px;">&nbsp;</TH>
                        </TR>                  
<?php 
                if (! empty ($ListVoterAtAddress)) {
                  foreach ($ListVoterAtAddress as $var) {
                    if (! empty ($var["DataAddress_HouseNumber"] && ! empty($var["DataStreet_Name"]) && ! empty ($var["DataAddress_zipcode"]))) {
?>    
      
                      <TR>
                            <TD style="padding:0px 10px;"><?= $var["DataAddress_HouseNumber"] ?></TD>
                            <TD style="padding:0px 10px;"><?= $var["DataAddress_FracAddress"] ?></TD>
                            <TD style="padding:0px 10px;"><?= $var["DataAddress_PreStreet"] ?></TD>
                            <TD style="padding:0px 10px;"><?= $var["DataStreet_Name"] ?></TD>
                            <TD style="padding:0px 10px;"><?= $var["DataAddress_PostStreet"] ?></TD>
                            <TD style="padding:0px 10px;"><?= $var["DataAddress_zipcode"] ?></TD>
                            <TD style="padding:0px 10px;"><A HREF="/<?= MergeEncode(
                            								[
                                              "DataAddress_HouseNumber" => $var["DataAddress_HouseNumber"], 
                                              "DataAddress_FracAddress" => $var["DataAddress_FracAddress"],
                                              "DataAddress_PreStreet" => $var["DataAddress_PreStreet"],
                                              "DataStreet_Name" => $var["DataStreet_Name"],
                                              "DataAddress_PostStreet" => $var["DataAddress_PostStreet"],
                                              "DataAddress_zipcode" => $var["DataAddress_zipcode"],
                                          	]); 
                                          ?>/lgd/objections/selecthouse"><B>See voters</B></A></TD>
              </TR>
<?php
                    }
                  }
                }
?>
                        </TABLE>
             
           
               
         
                  

                    </DIV>
                  </DIV>
                </DIV>
              </DIV>
            </DIV>     
          </FORM>  
        </DIV>   
      </DIV>
    </DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>
  </BODY>
</HTML>