<?php
  if ( ! empty ($k)) { $MenuLogin = "logged"; }
  $Menu = "admin";
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_admin.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/js_logic.php";

  if ( empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}  
  $rmb = new RMBAdmin();  
  $rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
  $Party = PrintParty($URIEncryptedString["UserParty"]);

  $result = $rmb->ListAllDates();
  WriteStderr($result, "ListElectedPositions");
  
  $TopMenus = array (             
    array("k" => $k, "url" => "../admin/elections/index", "text" => "Election Positions"),
    array("k" => $k, "url" => "../admin/elections/datemgmt", "text" => "Elections Dates"),
    array("k" => $k, "url" => "../admin/setup_candidate", "text" => "Candidate")
  );
      
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
  if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>

    <div class="row layout">
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
      <div class="main">
        <div class="col-full">
          <div class="Subhead">
            <h2 class="Subhead-heading">Election Setups</h2>
          </div>
          <?php  PlurialMenu($k, $TopMenus); ?>
          <div class="clearfix gutter d-flex flex-shrink-0">
            
            <DIV>
							<div class="">List of positions available to run for</div>
                                            
              <table class= "basic-table" id="dataTable" border="1">
                <thead id="table-body">
                  <tr>
                    <th><input type="text" placeholder="Search Election Date" onkeyup="filterTable(0, this.value)"></th>
                    <th><input type="text" placeholder="Search State" onkeyup="filterTable(1, this.value)"></th>
                    <th><input type="text" placeholder="Search Type" onkeyup="filterTable(2, this.value)"></th>
                    <th><input type="text" placeholder="Search Election" onkeyup="filterTable(3, this.value)"></th>
                    <TH ROWSPAN=2><A class="submitred" style="padding: 5px 10px;" HREF="/<?= CreateEncoded (
                      [ "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],  
                        "SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"] ]);
                  ?>/admin/elections/dateadd">New Date</A></TH>
                  </tr>
                  <tr>
                    <TH>Election Date</TH>
                    <TH>State</TH>
                    <TH>Type</TH>                               
                    <TH>Election</TH>
                  </tr>
                </thead>
            
                <tbody>
<?php 
          $Counter = 0;
          if ( ! empty ($result)) {
            foreach ($result as $var) {
?>
                  <TR>
                    <TD><?= PrintDate($var["Elections_Date"]) ?></TD>
                    <TD><?= $var["DataState_Name"] ?></TD>
                    <TD><?= $var["Elections_Type"] ?></TD>
                    <TD><?= $var["Elections_Text"] ?></TD>
                    <TD style="text-align:center;"><A class="submitred" style="padding: 1px 10px;" HREF="/<?= CreateEncoded (
                        array(  
                          "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],  
                          "SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
                          "Elections_ID" => $var["Elections_ID"])
                        );
                    ?>/admin/elections/dateedit">Select</A></TD>
                  </TR>
                  
<?php
            }
          } 
?>
                </tbody>
              </table>
                
              
						</DIV>
          </div>
        </div>
      </div>
    </DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>
<?php Search_TDCol(); ?>
  </BODY> 
</HTML>