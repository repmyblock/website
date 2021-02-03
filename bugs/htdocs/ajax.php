<?php

$finalfile = "/usr/local/webserver/upload/files";
$arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];

/* 
if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
  echo "Could not lead Uploaded " .  $_FILES['file']['type'];
  return;
}
*/
 
if (!file_exists('uploads')) {
  mkdir('uploads', 0777);
}
 
move_uploaded_file($_FILES['file']['tmp_name'], $finalfile . "/" . time() . '_' . $_FILES['file']['name']);
 
echo "File " . $_FILES['file']['name'] . " uploaded successfully";
?>


