<?php

include('inc/zip.php');
include('inc/functions.php');

// Receive vars

if (isset($_GET['f']) && $_GET['f'] != '') {
  $req_folder = $_GET['f'];                 // RELATIVA a index.php
} else {
  $req_folder = REQ_FOLDER;                 // RELATIVA a index.php
}

if (isset($_GET['m']) && $_GET['m'] != '') {
  $mode = $_GET['m'];                 // RELATIVA a index.php
} else {
  $mode = MODE;                 // RELATIVA a index.php
}

// Some Internal Vars

$zip_file = $req_folder.'.archive.zip';
$zip_path = './' . $zip_file;

// Dispatch

switch ($mode) {
  case 'array':
    $files = js($req_folder, 'array');
  break;
  case 'html':
    /* Headers */
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: text/html; charset=utf-8'); 
    $files = js($req_folder, 'html');
    print_r($files);
  break;
  case 'json':
    /* Headers */
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');
    /* JSON */
    $files = js($req_folder, 'json');
    echo json_encode($files);
  break;
  default:
    /* Headers */
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');
    /* JSON */
    $files = js($req_folder, 'array');
    //print_r($files);
  break;
}

// Unlink

if(file_exists($zip_path)) {
  unlink($zip_path);
}

//Dynamic

$result = create_zip($files, $zip_path);

//Static: use a satic array defined in config.php
//$result = create_zip($files_to_zip, $zip_path);

if ($result) {

  header('Pragma: public');
  header('Expires: 0');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Cache-Control: public');
  header('Content-Description: File Transfer');
  header('Content-type: application/octet-stream');
  header('Content-Disposition: attachment; filename="'.$zip_file.'"');
  header('Content-Transfer-Encoding: binary');
  header('Content-Length: '.filesize($zip_path));
  ob_end_flush();
  @readfile($zipPath);

}

?>