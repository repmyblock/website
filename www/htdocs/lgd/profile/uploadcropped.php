<?php
header('Content-Type: application/json;');
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

$rmb = new repmyblock();

WriteStderr("Inside UploadCroppedImage AJAX");
// WriteStderr($_POST, "Incoming Post");
WriteStderr($URIEncryptedString, "URIEncrypted");

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
$image_path = $GeneralUploadDir . "/shared/pics/" . $URIEncryptedString["TmpPicPath"];

$data = explode(',', $_POST['base64_img']);
$data = base64_decode($data[1]);

$tmp_name = @tempnam(sys_get_temp_dir(), 'image');
$tmp_handle = fopen($tmp_name, 'w');
fwrite($tmp_handle, $data);

$image = imagecreatefrompng($tmp_name);
imagepng($image, $image_path);
fclose($tmp_handle);

rename($GeneralUploadDir . "/shared/pics/" . $URIEncryptedString["TmpPicPath"], $GeneralUploadDir . "/shared/pics/" .$URIEncryptedString["PicPath"]);
$rmb->updatecandidateprofile($URIEncryptedString["CandidateProfileID"], array("PicVerified" => 'yes'));

echo_data_exit(['result' => 'OK'], 200);

// UPDATE THE DATABASE FLAG.
