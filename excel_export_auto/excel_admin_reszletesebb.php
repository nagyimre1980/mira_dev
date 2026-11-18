<?php
/*
Admin jogosultságok fülön lévő excel export futtátása mentési opcióval.
*/
$_SERVER['REMOTE_USER']='A2675@MVMH.LOCAL';
include_once("../config_uj.php");

$_POST['idoszak_ev']=date("Y");
$_POST['idoszak_ho']='all';
$_POST['idoszak_nap']='all';
$_POST['idoszak_tipus']='reszletes2';
$_POST['kiuser']='all';
$_POST['user']='all';
$_POST['szerv_id']='all';
$_POST['projekt_id']='all';

$GLOBALS['excel_auto_save']="1";
$GLOBALS['excel_auto_mappa'].='Statisztika Részletesebb/';
if(!is_dir($GLOBALS['excel_auto_mappa']))mkdir($GLOBALS['excel_auto_mappa']);
if(!is_dir($GLOBALS['excel_auto_mappa'])){
 echo 'Mappa nem létezik, és a létrehozása nem sikerült!';
 exit;
}

include_once('excel_admin_func.php');
include_once('../excel_export/excel_export.php');

cleanupExcelFiles($GLOBALS['excel_auto_mappa'],'MIRA statisztika reszletesebb','60','csv');
?>