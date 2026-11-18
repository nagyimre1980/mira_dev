<?php
/*
Admin jogosultságok fülön lévő excel export futtátása mentési opcióval.
*/
$_SERVER['REMOTE_USER']='A2675@MVMH.LOCAL';
include_once("../config_uj.php");

$_POST['fajta_id']='admin_userlist_keres';
$_POST['egyeni_id1']='&ad=&nev=&tsz=&inaktiv=all&szerv_id=all&maxido=all&jog=all&kezd_date=&kezd_date_mod=n&veg_date=&veg_date_mod=k';

$GLOBALS['excel_auto_save']="1";
$GLOBALS['excel_auto_mappa'].='Admin Jogosultság/';
if(!is_dir($GLOBALS['excel_auto_mappa']))mkdir($GLOBALS['excel_auto_mappa']);
if(!is_dir($GLOBALS['excel_auto_mappa'])){
 echo 'Mappa nem létezik, és a létrehozása nem sikerült!';
 exit;
}

include_once('excel_admin_func.php');
include_once('../excel_export/excel_export.php');

cleanupExcelFiles($GLOBALS['excel_auto_mappa'],'Admin jogosultság','60');
?>