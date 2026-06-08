<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json;');
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

WriteStderr("Inside UploadCroppedImage AJAX");
$rmb = new repmyblock();

#WriteStderr($_POST, "Incoming Post");
#WriteStderr($URIEncryptedString, "URIEncrypted");

/**
 * Echos data as json and terminates the script.
 *
 * @param int $http_response The HTTP reponse to set.
 * @param mixed $data The data to output as JSON.
 * @return void
 */
function echo_data_exit($data, int $http_response = 200) {
    http_response_code($http_response);
    echo json_encode($data);
		WriteStderr($data, "Inside AJAX echo data exit");
    exit;
}


// If the request method isn't POST then return a 405 HTTP error.
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo_data_exit(['result' => "The method {$_SERVER['REQUEST_METHOD']} is not allowed for this page."], 405);
}

if(!isset($_POST['base64_img'])) {
  echo_data_exit(400, ['result' => 'Bad request']);
}

// The path where the image gets saved
$image_path = $GeneralUploadDir . "/shared/pics/" . $URIEncryptedString["PicPath"] . "/TMP_" . $URIEncryptedString["PicName"];

$data = explode(',', $_POST['base64_img']);
$data = base64_decode($data[1]);

$tmp_name = @tempnam(sys_get_temp_dir(), 'image');
$tmp_handle = fopen($tmp_name, 'w');
fwrite($tmp_handle, $data);

// iF jpeg
//imagejpeg($image, $image_path, 100); // use jpeg since filename is jpeg
//imagedestroy($image);

$image = imagecreatefrompng($tmp_name);
imagepng($image, $image_path);
fclose($tmp_handle);
imagedestroy($image);
$old = $GeneralUploadDir . "/shared/pics/" . $URIEncryptedString["PicPath"] . "/TMP_" . $URIEncryptedString["PicName"];
$new = $GeneralUploadDir . "/shared/pics/" . $URIEncryptedString["PicPath"] . "/CRP_" . $URIEncryptedString["PicName"];

rename(
	$GeneralUploadDir . "/shared/pics/" . $URIEncryptedString["PicPath"] . "/TMP_" . $URIEncryptedString["PicName"], 
	$GeneralUploadDir . "/shared/pics/" . $URIEncryptedString["PicPath"] . "/CRP_" . $URIEncryptedString["PicName"]
);


WriteStderr(null, "Inside AJAX URIEncryptedString OLD: " . $old );
WriteStderr(null, "Inside AJAX URIEncryptedString NEW: " . $new );



WriteStderr($URIEncryptedString, "Inside AJAX URIEncryptedString");
$CandidateProfileFromPublic = $rmb->FindPublicProfile(Candidate_ID: $URIEncryptedString["Candidate_ID"]);
WriteStderr($CandidateProfileFromPublic, "Inside AJAX CandidateProfileFromPublic");

$rmb->UpdateCandidateProfileAutoCycle($CandidateProfileFromPublic["CandidateProfile_ID"], $URIEncryptedString["Candidate_ID"],[
	"PicVerified" => 'yes', 
	"MakePublic" => $CandidateProfileFromPublic["PublicProfile_PublishProfile"], 
	"TmpPicFile" => $URIEncryptedString["PicPath"] . "/CRP_" . $URIEncryptedString["PicName"]
]);

WriteStderr(null, "Finished the UpdateCandidateProfileAutoCycle");
	
echo_data_exit(['result' => 'OK'], 200);

// UPDATE THE DATABASE FLAG.