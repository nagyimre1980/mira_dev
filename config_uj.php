<?php
//error_reporting(E_ALL);

error_reporting(E_ALL);
ini_set('display_errors',"on");
ini_set('log_errors',"on");
ini_set('display_errors',1);
ini_set('error_reporting', E_ALL);
ini_set('display_startup_errors',1);
ini_set('log_errors',"on");

/*
function my_time() {
    // Itt állítsd be az időt, amit vissza szeretnél adni
    return strtotime('2024-05-01 12:00:00');
}
*/

$GLOBALS['prog_ver_fo']="1";
$GLOBALS['prog_ver']="101";

$GLOBALS['mail_tilt']="0";

$GLOBALS['sessionname']="mira_dev";
$GLOBALS['tesztdevmod']=" DEV";
$GLOBALS['rend_str']=" - DEV rendszer!";
$GLOBALS['rend_nev']="MIRA";
$GLOBALS['rend_nev_tilte']="";
$GLOBALS[$GLOBALS['sessionname']]['tagv']='KONT';
//$GLOBALS['rend_emailfelado']="konto-mira@mvm.hu";//konto-mira@mvm.hu
//$GLOBALS['rend_emailfelado']="noreply@mvm.hu";//konto-mira@mvm.hu
$GLOBALS['rend_emailfelado']="mira-mvms@mvm.hu";//konto-mira@mvm.hu
//$GLOBALS['rend_emailfelado']="hitelkartyaelszamolas@mvm.hu";//konto-mira@mvm.hu
$GLOBALS['rend_emailfelado_udv_str']="MVM Services Zrt.";//Aláírás vége szövege
$GLOBALS['rend_emailfelado_udv_str_auto']="MVMS GIG";
$GLOBALS['rend_email_auto_osszegzes_nev']="mira-mvms@mvm.hu";//Ide megy az összegző email neve
$GLOBALS['rend_email_auto_osszegzes_email']="mira-mvms@mvm.hu";//Ide megy az összegző email

//Melyik év-hótól nem látható a távollét oszlop. Tehát ez az első, ahol már nincs
$GLOBALS['tavollet_nemlat']['ev']="2023";
$GLOBALS['tavollet_nemlat']['ho']="1";
$GLOBALS['tagv_alap_napi_osszes_ido_min_ora']="0";
$GLOBALS['tagv_alap_napi_napi_ido_max_ora']="12";
$GLOBALS['tagv_alap_ev_kezdo_ev']="2022";
$GLOBALS['tagv_alap_ev_kezdo_ho']="1";

$GLOBALS['url']="https://dev-konto-portal.mvmh.local/mira_dev/";
$GLOBALS['szerz_szerz']="/mnt/konto_web_share/IT/Rendszerek/SAP/JOB/mira_dev/szerz/";
$GLOBALS['szerz_ar']="/mnt/konto_web_share/IT/Rendszerek/SAP/JOB/mira_dev/ar/";

$GLOBALS['log_mentes_mysqldump']="/srv/www/vhosts/dev-konto-portal/www/mysqldump/";
$GLOBALS['log_mentes_mysqldump_php']="mira_log.php";
$GLOBALS['log_mentes_fionamappa']="/srv/www/vhosts/dev-konto-portal/www/mira_dev/";
$GLOBALS['excel_auto_mappa']="/mnt/konto_web_share/IT/Backup/mira_dev/";
$GLOBALS['excel_auto_mappa_teszt']="1";

$GLOBALS['kitoltesi_utm']='MVM';//Csak akkor van kitöltési ha itt MVM szerepel, BSZK-URBN esetén üresen kell hagyni.

//$GLOBALS['mira']['ev_kezdo_ev']="2010";//Kezdő hónap az évhez
//$GLOBALS['mira']['ev_kezdo_ho']="4";//Fenti év melyik kezdőhónapja! Csak a fenti évre érvényes!
//mysqli_report(MYSQLI_REPORT_OFF);
//mysqli_report(MYSQLI_REPORT_ALL);
//mysqli_report(MYSQLI_REPORT_INDEX);
mysqli_report(MYSQLI_REPORT_ERROR);
//mysqli_report(MYSQLI_REPORT_STRICT);
//$GLOBALS['phpmailer_akt']="ajax_mail_uj651.php";
//$GLOBALS['phpmailer_akt']="ajax_mail_uj665.php";
//$GLOBALS['phpmailer_akt']="ajax_mail_uj671.php";
//$GLOBALS['phpmailer_akt']="ajax_mail_uj680.php";
//$GLOBALS['phpmailer_akt']="ajax_mail_uj691.php";
//$GLOBALS['phpmailer_akt']="ajax_mail_uj6100.php";
//$GLOBALS['phpmailer_akt']="ajax_mail_uj6110.php";
//$GLOBALS['phpmailer_akt']="ajax_mail_uj702.php";
//$GLOBALS['phpmailer_akt']="ajax_mail_uj711.php";
$GLOBALS['phpmailer_akt']="ajax_mail_uj720.php";
if((!isset($GLOBALS['nosql']))or((isset($GLOBALS['nosql']))and($GLOBALS['nosql']!="1"))){
//$GLOBALS['mysqli']=@mysqli_connect("10.110.139.25","mira_dev","VMPPrg6Q","mira_dev");
try {
 //$GLOBALS['mysqli']=mysqli_connect("10.110.139.25","mira_prod","CwD2HkUW","mira_prod");
 $GLOBALS['mysqli']=mysqli_connect("10.110.139.25","mira_dev","VMPPrg6Q","mira_dev");
 //$GLOBALS['mysqli']=mysqli_connect("10.110.139.25","mira_test","ULv6Gf7h","mira_test");
} catch (Exception $e) {
 error_log("MYSQL/MariaDB csatlakozasi hiba: ".$e->getMessage()); // Naplózás
 //die("Sajnáljuk, adatbázis hiba történt. Kérjük, próbálja újra később.".$e->getMessage());
 die("Sajnáljuk, adatbázis hiba történt. Kérjük, próbálja újra később.");
}
//$GLOBALS['mysqli']=@mysqli_connect("10.110.139.25","mira_test","ULv6Gf7h","mira_test");
//$GLOBALS['mysqli']=@mysqli_connect("10.110.139.25","mira_prod","CwD2HkUW","mira_prod");

//if(!$GLOBALS['mysqli']){
//printf("Can't connect to localhost. Errorcode: %d\n", mysqli_connect_errno());
//exit();
//}

//printf("System status: %s\n", mysqli_stat($GLOBALS['mysqli']));
//printf("System status: %s\n", mysqli_get_client_info($GLOBALS['mysqli']));
//printf("System status: %s\n", mysqli_get_server_version($GLOBALS['mysqli']));
//printf("System status: %s\n", mysqli_get_server_info($GLOBALS['mysqli']));
//print_r(mysqli_get_connection_stats($GLOBALS['mysqli']));

/*
mysqli_query($GLOBALS['mysqli'],'SET SESSION lc_messages = "hu_HU"');//4MB
$adat=mysqli_query($GLOBALS['mysqli'],'SHOW VARIABLES LIKE "%lc_messages%";');//4MB
while($adatom=mysqli_fetch_assoc($adat)){
 print_r($adatom);
}*/
//mysqli_query($GLOBALS['mysqli'],'SET SESSION sql_mode = ""');//4MB
//mysqli_multi_query($GLOBALS['mysqli'],'SET SESSION sql_mode = "";SET session tmp_table_size=536870912;SET session max_heap_table_size=536870912;');//4MB
//while(mysqli_next_result($GLOBALS['mysqli'])){;}
//mysqli_multi_query($GLOBALS['mysqli'],'SET SESSION innodb_buffer_pool_size = "3GB"');//4MB
}
?>