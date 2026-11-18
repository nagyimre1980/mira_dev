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

include_once("jquery_ui_1_14_2_k.min.css");
include_once("select2_4_1_0.min.css");
include_once("jquery_multi_select_min_".$GLOBALS['prog_ver_fo']."_".$GLOBALS['prog_ver'].".css");

include_once("default_".$GLOBALS['prog_ver_fo']."_".$GLOBALS['prog_ver'].".css");


?>