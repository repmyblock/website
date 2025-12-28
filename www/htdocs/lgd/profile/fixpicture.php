<?php
  $Menu = "profile";  
	$BigMenu = "profile";
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
    
  if (! empty ($_POST)) {  	  	
  	if ( empty ($URIEncryptedString["PDFFilePath"])) {
  		header("Location: updatecandidateprofile");
  		exit();
  	} else {
  		header("Location: fixpdf");
	  	exit();
  	}
  }
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  $rmb = new repmyblock();  
  
  $rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);
  WriteStderr($rmbperson, "rmbperson array");
  	            
  if ($rmbperson["SystemUser_emailverified"] == "both") {                
    $TopMenus = array (
      array("k" => $k, "url" => "profile/user", "text" => "Public Profile"),
      array("k" => $k, "url" => "profile/profilevoter", "text" => "Voter Profile"),
      array("k" => $k, "url" => "profile/profilecandidate", "text" => "Candidate Profile"),
      array("k" => $k, "url" => "profile/profileteam", "text" => "Team Profile")
    );
  
  }              

  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
  if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
  
  $PicturePath = "/shared/pics/" . $URIEncryptedString["PicPath"] . "/TMP_" . $URIEncryptedString["PicName"];
?>

    <div class="row layout">
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
      <div class="main">
        <div class="col-full">
          <div class="Subhead">
            <h2 class="Subhead-heading">Candidate Profile</h2>
          </div>
          <?php  PlurialMenu($k, $TopMenus);  ?>
              	
              	<FORM ACTION="" METHOD="POST" ENCTYPE="multipart/form-data">
              		<INPUT TYPE="HIDDEN" NAME="FixPicture">
              		<DIV>
              			<P class="f60">
                    	<B>Please adjust the picture for the guide to enable the picture.</B>               
	                  </P>
 	            	</DIV>
               	
	              	<P CLASS="f60"><BR>
	              		
	              		 <STYLE>
      <?php require $_SERVER["DOCUMENT_ROOT"] . "/../libs/utils/External_Croppie/croppie.css"; ?>
    </STYLE>
		                <link rel="stylesheet" href="/css/" />     	
										<div id="demo-basic"></div>
									</P>
	         				
           
									<P class="f60">
                    <B>This profile will be presented to every person that visits the Rep My Block website.</B> You 
                    will be able to upload a one-page PDF of your platform that will be used to create a voter 
                    booklet that a voter will download and email.
                  </P>
      
									<P class="f60">        
               			<button id="cropBtn" class="submitred" type="button">Crop & Upload</button>
                  </p>   

 
                 
                      
                    
                  </DIV>
                </FORM>
                
              </DIV>
            </DIV>
          </DIV>
        </DIV>
      </DIV>
    </DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>
    <SCRIPT>
      <?php require $_SERVER["DOCUMENT_ROOT"] . "/../libs/utils/External_Croppie/croppie.min.js"; ?>
    </SCRIPT>
    <script>
			var c = new Croppie(document.getElementById('demo-basic'), {
			    viewport: {
			        width: 200,
			        height: 300,
			        type: 'square' //default 'square'
			    },
			    
			    boundary: {
			        width: 275,
			        height: 400
			    },
			    customClass: '',
			    enableZoom: true, //default true // previously showZoom
			    showZoomer: true, //default true
			    mouseWheelZoom: true, //default true
			    update: function (cropper) { }
			});

			// bind an image to croppie
			c.bind({
			    url: "<?= $PicturePath ?>"
			});

			// set the zoom programatically. Restricted to the min/max values of the slider
			c.setZoom(1.5);

			// get crop points from croppie
			var data = c.get();

			// get result from croppie
			// returns Promise
			var result = c.result('html').then(function (img) {
			    //img is html positioning & sizing the image correctly if resultType is 'html'
			    //img is base64 url of cropped image if resultType is 'canvas' 
			});

			cropBtn.addEventListener('click', () => {
		    // Get the cropped image result from croppie
		    c.result({
		        type: 'base64',
		        circle: false,
		        format: 'png',
		        size: 'viewport'
		    }).then((imageResult) => {
		        // Initialises a FormData object and appends the base64 image data to it
		        let formData = new FormData();
		        formData.append('base64_img', imageResult);

		        // Sends a POST request to upload_cropped.php
		        fetch('uploadcropped', {
		            method: 'POST',
		            body: formData
		        }).then(response => response.json()).then((data) => {
		            console.log(data);
		            window.location.href = "updatecandidateprofile";
		        });
		    });
		});

		</script>

	</BODY>
</HTML>