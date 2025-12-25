<?php
  if ( ! empty ($k)) { $MenuLogin = "logged"; }
  $Menu = "admin";
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";

  if ( empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}  
  $rmb = new repmyblock();  
  $rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
  $Party = PrintParty($URIEncryptedString["UserParty"]);

  $result = $rmb->ListElectionsDates();
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
            
          	<FORM ACTION="" METHOD="POST">
           		<div class="">List of positions available to run for</div>
                
	            <TABLE BORDER=1>
	            	<TH>Election Date</TH>
								<TH>Type</TH>                               
								<TH>Election</TH>
								<TH>&nbsp;</TH>

<?php 
          $Counter = 0;
          if ( ! empty ($result)) {
            foreach ($result as $var) {
?>
                <TR>
                  <TD><?= PrintDate($var["Elections_Date"]) ?></TD>
                  <TD><?= $var["Elections_Type"] ?></TD>
                  <TD><?= $var["Elections_Text"] ?></TD>
                  <TD><A HREF="/<?= CreateEncoded (
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

							</TABLE>
              
              <p><button type="submit" class="submitred">Add a new electiondate</button></p>
            </FORM>
          </div>
        </div>
      </div>
    </DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>