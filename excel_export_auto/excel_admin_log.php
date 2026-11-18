<?php
/*
Admin jogosultságok fülön lévő excel export futtátása mentési opcióval.
*/
$_SERVER['REMOTE_USER']='A2675@MVMH.LOCAL';
include_once("../config_uj.php");

$_POST['fajta_id']='admin_loglist_keres';
$_POST['egyeni_id1']='&user_ad=&mikor=&adat_elozmeny=&adat=';

$GLOBALS['excel_auto_save']="1";
if(!isset($_GET['auto'])){
 $GLOBALS['excel_auto_mappa'].='Admin log/excel/';
}else{
 $GLOBALS['excel_auto_mappa'].='Admin log/';
}
if(!is_dir($GLOBALS['excel_auto_mappa']))mkdir($GLOBALS['excel_auto_mappa']);
if(!is_dir($GLOBALS['excel_auto_mappa'])){
 echo 'Mappa nem létezik, és a létrehozása nem sikerült!';
 exit;
}

include_once('excel_admin_func.php');
include_once('../excel_export/excel_export.php');

cleanupExcelFiles($GLOBALS['excel_auto_mappa'],'Admin log','1000');

?>