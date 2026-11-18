<?php
session_start(['read_and_close' => true]);
$GLOBALS['nosql']=1;
include_once("../config_uj.php");
header('Content-Type: text/javascript; charset=UTF-8');
if(
(!isset($_SESSION[$GLOBALS['sessionname']]['jog']['ful_admin']))
or($_SESSION[$GLOBALS['sessionname']]['jog']['ful_admin']=="0")
){
exit;
}
?>"use strict";<?php

include_once('jquery.mask_1_14_16.js');
include_once('jquery.number.js');
include_once('admin_fo_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_user_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_szerv_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_proj_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_arazasref_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_terv_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_csop_nev_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_kat_nev_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_tagv_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_szolgkod_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_munkanapuser_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_honapzaras_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_hibajavitas_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_log_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_kapcstulaj_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_kapcstorzs_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_kapcsossze_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_tervezes_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_tenypotlas_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('admin_tenypotlastig_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');

include_once('szerz/admin_szerz_szerztipus_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('szerz/admin_szerz_szerzalapadat_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('szerz/admin_szerz_szerzfeltolt_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('szerz/admin_szerz_tarskat_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('szerz/admin_szerz_szolgcsop_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('szerz/admin_szerz_elsztipus_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('szerz/admin_szerz_nattipus_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('szerz/admin_szerz_usergazda_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('szerz/admin_szerz_szolgkapadat_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('szerz/admin_szerz_szolgmodadat_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('szerz/admin_szerz_tigadat_penznem_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('szerz/admin_szerz_tigadat_co_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('szerz/admin_szerz_tigadat_sapszam_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('szerz/admin_szerz_tigadat_vevoazon_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('szerz/admin_szerz_tigadat_nemszerz_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('szerz/admin_szerz_integadat_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');

include_once('szerz/admin_kpi_szolgkod_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('szerz/admin_kpi_tipus_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');
include_once('szerz/admin_kpi_osszekap_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php');

//include_once("jquery-migrate-3.5.2.js");
?>