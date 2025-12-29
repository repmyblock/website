<?php
  if ( ! empty ($k)) { $MenuLogin = "logged";  }  
  $Menu = "voters";
  $BigMenu = "represent";  
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}  
  $Party = PrintParty($URIEncryptedString["UserParty"]);

  if (! empty($_POST)) {  
  
    echo "Je suis dans le post:";
    print "<PRE>" . print_r($_POST, 1) . "</PRE>";
    exit();
    // This will be different answer depending
    $finalurl = "voters/voterresult";
    
    header("Location: /" .  CreateEncoded ( array( 
                "Query_FirstName" => $_POST["FirstName"],
                "Query_LastName" => $_POST["LastName"], 
                "Query_AD" => $_POST["AD"],
                "Query_ED" => $_POST["ED"],
                "Query_ZIP" => $_POST["ZIP"],
                "Query_COUNTY" => $_POST["COUNTY"],
                "Query_PARTY" => $_POST["Party"],
                "Query_NYSBOEID" => $_POST["UniqNYS"],
                "Query_Congress" => $_POST["Congress"],
                "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
                "FirstName" => $URIEncryptedString["FirstName"],
                "LastName" => $URIEncryptedString["LastName"],
                "UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
                 "SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
                 "EDAD" => $URIEncryptedString["EDAD"]
          )) . "/lgd/" . $finalurl);
    exit();
  }

  $rmb = new RepMyBlock();  
  $rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
  $TopMenus = array ( 
            array("k" => $k, "url" => "voters/voterlist", "text" => "District Voters"),
            array("k" => $k, "url" => "voters/voterquery", "text" => "Search Voter")
          );      
  WriteStderr($TopMenus, "Top Menu");
  
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
  if ($MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
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

                <div class="field">
                  <input type="text" id="HouseNumber" class="input" placeholder=" " required VALUE="<?= $HouseNumber ?>">
                  <label for="HouseNumber">House Number</label>
                </div>
                
                <div class="field">
				          <input type="text" id="username"  class="input" name="username" required placeholder=" " />
				          <label for="username">Username</label>
				        </div>

                <div class="field">
                  <input type="text" id="StreetName" class="input" placeholder=" " required VALUE="<?= $StreetName ?>">
                  <label for="StreetName">Street Name</label>
                </div>

                <div class="field">
                  <input type="text" id="ZipCode" class="input" placeholder=" " required VALUE="<?= $ZipCode ?>">
                  <label for="ZipCode">Zip Code</label>
                </div>

                <div class="field">
                  <input type="text" id="AD" class="input" placeholder=" " required VALUE="<?= $RepostAD ?>">
                  <label for="AD">AD</label>
                </div>

                <div class="field">
                  <input type="text" id="ED" class="input" placeholder=" " required VALUE="<?= $RepostED ?>">
                  <label for="ED">ED</label>
                </div>

         
             
          
                    County
                  
                    <SELECT NAME="County_ID">
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
                   </DIV>
                   
                  <div class="field">
                    <input type="text" id="FirstName" class="input" placeholder=" " required VALUE="<?= $FirstName ?>">
                    <label for="FirstName">First Name</label>
                  </div>
                 
                  <div class="field">
                    <input type="text" id="" class="input" placeholder=" " required VALUE="<?= $LastName ?>">
                    <label for="LastName">Last Name</label>
                  </div>
           
                  <div class="field">
                    <input type="text" id="BOECountyID" class="input" placeholder=" " required VALUE="<?= $BOECountyID ?>">
                    <label for="BOECountyID">BOECountyID</label>
                  </div>
                  
                  <div class="field">
                    <input type="text" id="BOEStateID" class="input" placeholder=" " required VALUE="<?= $BOEStateID ?>">
                    <label for="BOEStateID">BOEStateID</label>
                  </div>

                  <DIV><INPUT TYPE="SUBMIT" NAME="SearchBuilding" VALUE="Search buildings"></DIV>
              
              
           
              
                      <div class="list-group-item filtered">
                       
                      <TABLE>
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
                if (! empty ($result)) {
                  foreach ($result as $var) {
                    if (! empty ($var["DataAddress_HouseNumber"] && ! empty($var["DataStreet_Name"]) && ! empty ($var["DataAddress_zipcode"]))) {
?>    
      
                      <TR>
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