<?php
session_start();
header('Content-Type: text/javascript; charset=UTF-8');

headers_for_page_cache();

function headers_for_page_cache($cache_length=3600*24*30){
    $cache_expire_date = gmdate("D, d M Y H:i:s", time() + $cache_length);
    header("Expires: $cache_expire_date");
    header("Pragma: cache");
    header("Cache-Control: max-age=$cache_length");
    header("User-Cache-Control: max-age=$cache_length");
//1 nap: 60sec * 60min * 24hours 86400
//1 óra 60sec * 60min 3600
}

include_once("../config_uj.php");
//$GLOBALS['prog_ver_fo']=explode("_",basename(__FILE__, '.php'))[1];
//$GLOBALS['prog_ver']=explode("_",basename(__FILE__, '.php'))[2];

include_once("jquery.ui.touch-punch.js");

//V1.064 nincs rá szükség!
//include_once("jquery.dialogOptions.js");

//include_once("jquery.tablesorter.min_2_31_3.js");
include_once("jquery.tablesorter_2_31_3.js");
include_once("jquery.tablesorter_sajat_".$GLOBALS['prog_ver_fo']."_".$GLOBALS['prog_ver'].".js");
//include_once("select2_4_1_0_rc1.js");
include_once("select2_4_1_0.js");
include_once("select2_4_1_0_emre.js");
include_once("maximize-select2-height.js");
include_once("autosize.js");
//include_once("jquery.mask_1_14_16.js");
//include_once("jquery.mousewheel.min_3_1_20.js");
//include_once("jquery.mousewheel_3_1_20.js");
///////////include_once("jquery.mousewheel_4_0_00_pre.js");
include_once("jquery.multi_select.js");
////////////include_once("glob/globalize.js");
////////////include_once("glob/globalize.culture.hu.js");
//include_once("glob/globalize.culture.de-DE.js");

include_once("fojs_".$GLOBALS['prog_ver_fo']."_".$GLOBALS['prog_ver'].".js");
include_once("fojs_select2_".$GLOBALS['prog_ver_fo']."_".$GLOBALS['prog_ver'].".js");
include_once("rogzit_".$GLOBALS['prog_ver_fo']."_".$GLOBALS['prog_ver'].".js");

include_once("rogzit_jovahagy_".$GLOBALS['prog_ver_fo']."_".$GLOBALS['prog_ver'].".js");
include_once("rogzit_stat_".$GLOBALS['prog_ver_fo']."_".$GLOBALS['prog_ver'].".js");
include_once("riport_".$GLOBALS['prog_ver_fo']."_".$GLOBALS['prog_ver'].".js");
include_once("riport_tervteny_".$GLOBALS['prog_ver_fo']."_".$GLOBALS['prog_ver'].".js");
include_once("rogzit_adatok_masol_".$GLOBALS['prog_ver_fo']."_".$GLOBALS['prog_ver'].".js");

?>