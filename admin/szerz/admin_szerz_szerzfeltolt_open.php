<?php
//session_start();
session_start(['read_and_close' => true]);
include_once("../../config_uj.php"); 
include_once("../../function.php");
include_once("../../function_mysql.php");
//include_once("../function_mysql_admin.php");

login();

if(
(
(isset($GLOBALS[$GLOBALS['sessionname']]['ful_admin_all']))and
($GLOBALS[$GLOBALS['sessionname']]['ful_admin_all']=='1')
)
or
(
(isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_szerzfeltolt']))and
($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_szerzfeltolt']=='1')
)
){


if(
(!isset($_SESSION[$GLOBALS['sessionname']]['login_ad']))
){
 exit;
}

if(
(!isset($GLOBALS[$GLOBALS['sessionname']]['ful_admin']))
or
($GLOBALS[$GLOBALS['sessionname']]['ful_admin']=='0')
){
 exit;
}

if(
 (!isset($_POST['szerz_file_id']))or
 (!isset($_POST['tipus']))or
 ((isset($_POST['szerz_file_id']))and($_POST['szerz_file_id']==''))or
 (
  (isset($_POST['tipus']))and
  ($_POST['tipus']!='szerz')and
  ($_POST['tipus']!='ar')
 )
){
 exit;
}

$file_name=$_POST['szerz_file_id'].'.pdf';
if($_POST['tipus']=='szerz'){
 $file=$GLOBALS['szerz_szerz'].$file_name;
 $file_name_ki=keres_mit1_mit1_csak_ertek('szerz_file','szerz_file_id',$_POST['szerz_file_id'],'szerz_file_szerz_name');
}else{
 $file=$GLOBALS['szerz_ar'].$file_name;
 $file_name_ki=keres_mit1_mit1_csak_ertek('szerz_file','szerz_file_id',$_POST['szerz_file_id'],'szerz_file_ar_name');
}

if($file_name_ki==''){
 exit;
}

header('Content-Type: application/pdf');
header('Content-Length: ' . filesize($file));
header('Content-Disposition: inline; filename="'.$file_name_ki.'"');

header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');
header('Expires: 0'); 
readfile($file);

}else{
 exit;
}
?>