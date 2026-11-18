<?php
/*
Admin jogosultságok fülön lévő excel export futtátása mentési opcióval.
*/
$_SERVER['REMOTE_USER']='A2675@MVMH.LOCAL';
include_once("../config_uj.php");

$_POST['tipus']='kpi_riport';

$GLOBALS['excel_auto_save']="1";
$GLOBALS['excel_auto_mappa'].='Riport KPI/';
if(!is_dir($GLOBALS['excel_auto_mappa']))mkdir($GLOBALS['excel_auto_mappa']);
if(!is_dir($GLOBALS['excel_auto_mappa'])){
 echo 'Mappa nem létezik, és a létrehozása nem sikerült!';
 exit;
}

include_once('excel_admin_func.php');
include_once('../riport/riport_leker.php');

cleanupExcelFiles($GLOBALS['excel_auto_mappa'],'KPI riport','60');
?>