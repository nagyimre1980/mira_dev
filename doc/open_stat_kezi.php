<?php
if(!isset($_SESSION[$GLOBALS['sessionname']]['login_ad']))exit;

$file = 'doc/pdf_vedett/mira_stat.pdf';
$filename = 'mira_stat.pdf';
$filename2 = 'MIRA statisztika kézikönyv.pdf';

header('Content-Description: File Transfer');
header("Content-type:application/pdf");
header('Content-Disposition: inline; filename="' . $filename . '"; filename*=UTF-8\'\'' . rawurlencode($filename2));
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