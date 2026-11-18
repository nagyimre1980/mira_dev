<?php
//session_start();
session_start(['read_and_close' => true]);
include_once("../config_uj.php"); 
include_once("../function.php");
include_once("../function_mysql.php");
//$start = microtime(true);
login('1');
//ini_set("pcre.jit","0");
//ini_set('max_execution_time', '60');
ini_set('memory_limit','3G');
require_once "../simplexlsx/xlsx_simplegen.php";
//Van-e sat joga, ha nincs, álj!

if(
(
(
 (!isset($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_stat']))
 or
 (
   (isset($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_stat']))
   and
   ($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_stat']=='0')
 )
)
and
(
(!isset($_SESSION[$GLOBALS['sessionname']]['jog']['ful_admin']))
or($_SESSION[$GLOBALS['sessionname']]['jog']['ful_admin']=="0")
)
)
and($_POST['mod_egyedi']!='xlsx_export_jovahagy_user')
and($_POST['mod_egyedi']!='xlsx_export_akt_user')
){
	echo 'Jogosultság hiba1!';
	exit;
}

egyeni_id_szetbont();

/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/

if(
(isset($_POST['mod_egyedi']))
and
(
 ($_POST['mod_egyedi']=='xlsx_export_akt_user')
  or
 ($_POST['mod_egyedi']=='xlsx_export_jovahagy_user')
)

and
(isset($_POST['user_ad']))and($_POST['user_ad']!='')and
(isset($_POST['ev']))and($_POST['ev']!='')and
(isset($_POST['ho']))and($_POST['ho']!='')
){
 include_once("excel_export_akt_user.php");
 excel_export_akt_user($_POST['user_ad'],$_POST['ev'],$_POST['ho']);
 exit;
}elseif(
 (isset($_POST['mod_egyedi']))and
 ($_POST['mod_egyedi']=='xlsx_export_jovahagy_user_tomeges')and
 (isset($_POST['tuser_ad']))and($_POST['tuser_ad']!='')and
 (isset($_POST['ev']))and($_POST['ev']!='')and
 (isset($_POST['ho']))and($_POST['ho']!='')
){
 include_once("excel_export_akt_user_tomeges.php");
 excel_export_akt_user_tomeges(urldecode($_POST['tuser_ad']),$_POST['ev'],$_POST['ho']);
 exit;
}

$_POST['oldalholvagyok']=0;
$_POST['stat_leker_talszam']=99999999999999;

if(isset($_POST['fajta_id'])){
switch($_POST['fajta_id']){
case'user_helyettes':
 include_once("../ajax_func.php");
 include_once("tal/excel_export_tal_user_helyettes.php");
 excel_export_user_helyettes();
break;
case'szerv_jovahagyo':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_szerv_jovahagyo.php");
 excel_export_szerv_jovahagyo();
break;
case'felettes_jovahagyo':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_felettes_jovahagyo.php");
 excel_export_felettes_jovahagyo();
break;
case'projekthez_user':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_projekthez_user.php");
 excel_export_projekthez_user();
break;
case'projekthez_userjovahagyo':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_projekthez_userjovahagyo.php");
 excel_export_projekthez_userjovahagyo();
break;
case'admin_userlist_keres':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_userlist_keres.php");
 excel_export_admin_userlist_keres();
break;
case'admin_szervlist_keres':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_szervlist_keres.php");
 excel_export_admin_szervlist_keres();
break;
case'admin_projektlist_keres':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_projektlist_keres.php");
 excel_export_admin_projektlist_keres();
break;
case'userhez_projekt':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_userhez_projekt.php");
 excel_export_admin_userhez_projekt_keres();
break;
case'userhez_projektjovahagyo':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_userhez_projektjovahagyo.php");
 excel_export_admin_userhez_projektjovahagyo_keres();
break;

case'userhez_stat_projekt':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_userhez_stat_projekt.php");
 excel_export_admin_userhez_stat_projekt_keres();
break;
case'admin_szervezethez_projekt_rend':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_szervezethez_projekt_rend.php");
 excel_export_admin_szervezethez_projekt_rend_keres();
break;
case'admin_szervezetben_user':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_szervezetben_user.php");
 excel_export_admin_szervezetben_user_rend_keres();
break;
case'admin_szervezethez_projekt':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_szervezethez_projekt.php");
 excel_export_admin_szervezethez_projekt_rend_keres();
break;

case'admin_tagvkodlist_keres':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_tagvlist_keres.php");
 excel_export_admin_tagvlist_keres();
break;

case'admin_szolgkodlist_keres':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_szolgkodlist_keres.php");
 excel_export_admin_szolgkodlist_keres();
break;

case'admin_csopnevlist_keres':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_csopnevlist_keres.php");
 excel_export_admin_csopnevlist_keres();
break;

case'admin_katnevlist_keres':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_katnevlist_keres.php");
 excel_export_admin_katnevlist_keres();
break;

case'admin_kapcstorzslist_keres':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_kapcstorzslist_keres.php");
 excel_export_admin_kapcstorzslist_keres();
break;

case'admin_kapcstulajlist_keres':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_kapcstulajlist_keres.php");
 excel_export_admin_kapcstulajlist_keres();
break;

case'admin_kapcsosszelist_keres':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_kapcsosszelist_keres.php");
 excel_export_admin_kapcsosszelist_keres();
break;

case'admin_tenypotlaslist_keres':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_tenypotlaslist_keres.php");
 excel_export_admin_tenypotlaslist_keres();
break;

case'admin_tenypotlastiglist_keres':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_tenypotlastiglist_keres.php");
 excel_export_admin_tenypotlastiglist_keres();
break;

case'admin_arazasreflist_keres':
 include_once("../admin/function_mysql_admin.php");
 include_once("tal/excel_export_tal_admin_arazasreflist_keres.php");
 excel_export_admin_arazasreflist_keres();
break;

case'admin_szerztipuslist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_szerztipuslist_keres.php");
 excel_export_admin_szerztipuslist_keres();
break;

case'admin_szerzalapadatlist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_szerzalapadatlist_keres.php");
 excel_export_admin_szerzalapadatlist_keres();
break;

case'admin_szolgkapadatlist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_szolgkapadatlist_keres.php");
 excel_export_admin_szolgkapadatlist_keres();
break;

case'admin_szolgmodadatlist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_szolgmodadatlist_keres.php");
 excel_export_admin_szolgmodadatlist_keres();
break;

case'admin_tigadatsapszamlist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_tigadatsapszamlist_keres.php");
 excel_export_admin_tigadatsapszamlist_keres();
break;

case'admin_tigadatcolist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_tigadatcolist_keres.php");
 excel_export_admin_tigadatcolist_keres();
break;

case'admin_tigadatvevoazonlist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_tigadatvevoazonlist_keres.php");
 excel_export_admin_tigadatvevoazonlist_keres();
break;

case'admin_tigadatnemszerzlist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_tigadatnemszerzlist_keres.php");
 excel_export_admin_tigadatnemszerzlist_keres();
break;

case'admin_integadatlist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_integadatlist_keres.php");
 excel_export_admin_integadatlist_keres();
break;

case'admin_szolgcsoplist_keres':
case'admin_szolgcsophozszolgkodlist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_szolgcsoplist_keres.php");
 excel_export_admin_szolgcsoplist_keres();
break;

case'admin_elsztipuslist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_elsztipuslist_keres.php");
 excel_export_admin_elsztipuslist_keres();
break;

case'admin_nattipuslist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_nattipuslist_keres.php");
 excel_export_admin_nattipuslist_keres();
break;

case'admin_szerzusergazdalist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_szerzusergazdalist_keres.php");
 excel_export_admin_szerzusergazdalist_keres();
break;

case'admin_tarskatlist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_tarskatlist_keres.php");
 excel_export_admin_tarskatlist_keres();
break;

case'admin_szerzfeltoltlist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_szerzfeltoltlistlist_keres.php");
 excel_export_admin_szerzfeltoltlistlist_keres();
break;

case'admin_kpiszolgkodlist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_kpiszolgkodlist_keres.php");
 excel_export_admin_kpiszolgkodlist_keres();
break;

case'admin_kpitipuslist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_kpitipuslist_keres.php");
 excel_export_admin_kpitipuslist_keres();
break;

case'admin_kpiosszekaplist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_kpiosszekaplist_keres.php");
 excel_export_admin_kpiosszekaplist_keres();
break;

case'admin_loglist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/excel_export_tal_admin_log_keres.php");
 excel_export_admin_loglist_keres();
break;

case'admin_ujszolgkapadatprojektlist_keres':
 include_once("../admin/function_mysql_admin.php");
  include_once("tal/szerz/excel_export_tal_admin_ujszolgkapadatprojektlist_keres.php");
 excel_export_admin_ujszolgkapadatprojektlist_keres();
break;

}
}

if(isset($_POST['idoszak_tipus'])){
 $tipus=$_POST['idoszak_tipus'];

if(isset($_POST['idoszak_ev']))
 $ev=$_POST['idoszak_ev'];

if(isset($_POST['idoszak_ho']))
 $ho=$_POST['idoszak_ho'];
 
switch($tipus){
case'user_napi':
 include_once("excel_export_user_napi.php");
 excel_export_user_napi($ev,$ho);
break;
case'napi_user':
 include_once("excel_export_napi_user.php");
 excel_export_napi_user($ev,$ho);
break;
case'projekt_napi':
 include_once("excel_export_projekt_napi.php");
 excel_export_projekt_napi($ev,$ho);
break;
case'projekt_szerv':
 include_once("excel_export_projekt_szerv.php");
 excel_export_projekt_szerv($ev,$ho);
break;


case'szervezet_napi':
 include_once("excel_export_szerv_napi.php");
 excel_export_szerv_napi($ev,$ho);
break;
case'szerv_projekt':
 include_once("excel_export_szerv_projekt.php");
 excel_export_szerv_projekt($ev,$ho);
break;


case'reszletes':
case'reszletes2':
//$start = microtime(true);
//$mem_start = memory_get_peak_usage();
 include_once("excel_export_reszletes.php");
 //include_once("excel_export_reszletes_uj.php");
 excel_export_reszletes($ev,$ho,$tipus);
// Memóriahasználat és időmérés
//error_log("Peak memory Legnagyobb hasznalt RAM: " . (memory_get_peak_usage() - $mem_start) / 1024 / 1024 . " MB");
//error_log("eppen most hasznalt RAM: " . (memory_get_usage()) / 1024 / 1024 . " MB");
//error_log("Time: " . (microtime(true) - $start) . " s");
break;
default:
 echo "Típushiba";
 exit;
break;

}
}

function egyeni_id_szetbont(){
//egyeni_id1
if(
(isset($_POST['egyeni_id1']))and
($_POST['egyeni_id1']!="")
){
 //$tomb_p=explode("&",urldecode($_POST['egyeni_id1']));
 $tomb_p=explode("&",$_POST['egyeni_id1']);
 if(is_array($tomb_p)){
 foreach($tomb_p as $ert){
  $tomb_pegy=explode("=",$ert);
  if(
  //(isset($tomb_pegy[0]))and(isset($tomb_pegy[1]))and($tomb_pegy[0]!="")and($tomb_pegy[1]!="")
  (isset($tomb_pegy[0]))and(isset($tomb_pegy[1]))and($tomb_pegy[0]!="")
  ){
	  //$_POST[$tomb_pegy[0]]=$tomb_pegy[1];
	  //$_POST[$tomb_pegy[0]]=urldecode($tomb_pegy[1]);
	  $_POST[urldecode($tomb_pegy[0])]=urldecode($tomb_pegy[1]);
	  
  }
 }
 }
}
}

//error_log("Peak memory: " . (memory_get_peak_usage()) / 1024 / 1024 . " MB");
//error_log("Time: " . (microtime(true) - $start) . " s");
?>