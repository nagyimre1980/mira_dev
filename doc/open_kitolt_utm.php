<?php
if(!isset($_SESSION[$GLOBALS['sessionname']]['login_ad']))exit;

$filename="open_kitolt_utm.xlsx";
$filename2="Kitöltési utmutató.xlsx";
$file="doc/pdf_vedett/".$filename;

header('Content-Description: File Transfer');
//header("Content-type:application/pdf");
header("Content-type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");//xlsx
header('Content-Disposition: inline; filename="'.$filename2.'"');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//header('Content-Transfer-Encoding: Binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
header('Accept-Ranges: none');
if (ob_get_level()) {//Nagy PDF ellen.
      ob_end_clean();
}
if(is_file($file)) readfile($file);
?>