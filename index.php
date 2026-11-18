<?php
session_start();
include_once("config_uj.php");

include_once("function.php");
include_once("function_mysql.php");
include_once("ajax_func.php");

login();

if(
(isset($_POST['doc_open']))and
($_POST['doc_open']!="")
){

switch($_POST['doc_open']){
 case'open_kitolt_utm':
  include_once("doc/open_kitolt_utm.php");
 break;
 case'open_felh_kezi':
  include_once("doc/open_felh_kezi.php");
 break;
 case'open_jovah_kezi':
  include_once("doc/open_jovah_kezi.php");
 break;
 case'open_stat_kezi':
  include_once("doc/open_stat_kezi.php");
 break;
}

exit;
}elseif(
(isset($_GET['i']))and
(isset($_GET['k']))and
(isset($_GET['t']))and
($_GET['i']!='')and
($_GET['k']!='')and
(
  ($_GET['t']=='szerz')or
  ($_GET['t']=='ar')
)
){
include('riport/szerz_szerzfeltolt_open.php');
//exit;
}
//header('X-UA-Compatible: IE=edge');

//header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
//header("Cache-Control: no-cache");
//header("Cache-Control: post-check=0, pre-check=0", false);
//header("Pragma: no-cache");


//<link rel="icon" href="favicon.ico" type="image/x-icon" />
//<meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
?><!DOCTYPE HTML><?php
if($GLOBALS[$GLOBALS['sessionname']]['tagv']=='URBN'){//Optimum

if($GLOBALS['tesztdevmod']==" DEV")
 echo '<html lang="hu" style="background:##aefea5">';  //CFFFB3 6AFF00
elseif($GLOBALS['tesztdevmod']==" TESZT")
  echo '<html lang="hu" style="background:radial-gradient(circle, #00c21e 60%, #CFFFB3 100%)">';  //CFFFB3 6AFF00
else
 //echo '<html lang="hu" style="background:radial-gradient(circle,#6BF75E 0%,#E6FFE3 50%)">';
 echo '<html lang="hu" style="background:radial-gradient(circle, #0067bb 0%, #b9dfff 50%)">';
//radial-gradient(circle, #0067bb 0%, #c4e4ff 50%)

}else{
if($GLOBALS['tesztdevmod']==" DEV")
 echo '<html lang="hu" s1tyle="background:radial-gradient(circle, #465dea 0%, #d0dcf5 80%)">';
elseif($GLOBALS['tesztdevmod']==" TESZT")
 echo '<html lang="hu" style="background:radial-gradient(circle, #ffffff 0%, #ff38c5 100%)">';
else
 echo '<html lang="hu">';
}
//<html lang="hu">

?><head><meta charset="utf-8"><link rel="shortcut icon" href="favicon.ico" type="image/x-icon"><meta name="googlebot" content="noarchive"><meta name="ROBOTS" content="NOINDEX, NOFOLLOW"><meta name="author" content="Nagy Imre"><meta name="copyright" content="MVM Services Zrt."><meta name="viewport" content="width=device-width, initial-scale=1"><title><?php echo $GLOBALS['rend_nev'].$GLOBALS['tesztdevmod'];?></title><?php

function css_ki($mod){
 if($mod=='k'){
  echo '<link rel="stylesheet" href="css/jquery_ui_1_14_2_k.min.css">';
 }else{
  echo '<link rel="stylesheet" href="css/jquery_ui_1_14_2.min.css">';
 }
 
 echo '<link rel="stylesheet" href="css/select2_4_1_0.min.css">';
 echo '<link rel="stylesheet" href="css/jquery_multi_select_min_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.css">';
 echo '<link rel="stylesheet" href="css/default_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.css">';
}

//CSS élesítés után - eleje
/*
function css_ki($mod){
if($mod=='k'){
 echo '<link rel="stylesheet" href="css/default_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'_k.css">';
}else{
 echo '<link rel="stylesheet" href="css/default_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.css">';
}	
}
*/
//CSS élesítés után - vége

//echo '<script type="text/javascript" src="js/jquery-4.0.0-rc.1.min.js"></script>';
//echo '<script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>';
echo '<script src="js/jquery-4.1.0.min.js"></script>';

if(
(
(isset($_SESSION[$GLOBALS['sessionname']]['jog']))and
($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']==0)and
($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_stat']==0)and
($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport']==0)and
($GLOBALS[$GLOBALS['sessionname']]['ful_admin']==0)
)
or
(!isset($_SESSION[$GLOBALS['sessionname']]['jog']))
){
 css_ki('k');
 //echo '<script type="text/javascript" src="js/jquery_ui_1_13_2k.min.js"></script>';
 echo '<script src="js/jquery_ui_1_14_2k.min.js"></script>';
}elseif(isset($_SESSION[$GLOBALS['sessionname']]['jog'])){
 css_ki('');
 //echo '<script type="text/javascript" src="js/jquery_ui_1_13_2.min.js"></script>';
 echo '<script src="js/jquery_ui_1_14_2.min.js"></script>';
}

if(isset($_SESSION[$GLOBALS['sessionname']]['jog'])){
	
echo '<script src="js/fojs_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php"></script>';

//Élesítésnél
/*
if(
($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_stat']==0)and
($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport']==0)
)
 echo '<script src="js/fojs_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.js"></script>';
else
 echo '<script src="js/fojs_stat_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.js"></script>';
*/

}

if((isset($GLOBALS[$GLOBALS['sessionname']]['ful_admin']))and($GLOBALS[$GLOBALS['sessionname']]['ful_admin']=="1"))
 echo '<script src="js/admin_'.$GLOBALS['prog_ver_fo'].'_'.$GLOBALS['prog_ver'].'.php"></script>';

echo '</head><body>';

if(
(!isset($_SESSION[$GLOBALS['sessionname']]['login_ad']))
or($_SESSION[$GLOBALS['sessionname']]['login_ad']=="")
){
nincs_joga();
exit;
}

echo "<table border=0 class='table_focim'><tr>";
//echo "<td><b>".$_SESSION[$GLOBALS['sessionname']]['login_nev']."</b>";
//echo "<br>".$_SESSION[$GLOBALS['sessionname']]['szerv_nev'];
// onclick='indit_titkos_dolog(event)'
echo "<td><span class='focim'>".$GLOBALS['rend_nev'].$GLOBALS['rend_nev_tilte'];
if($GLOBALS['tesztdevmod']!=""){
 echo " -".$GLOBALS['tesztdevmod'];
}
echo "</span>";

echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<span style="display:block;font-size:22px;color:#fff" class="link">';
echo '<a target=_blank style="color:blue" href="https://teams.microsoft.com/meet/357008555169584?p=qdxYzQLKd8PJbZ3CMD ">MIRA kérdezz-felelek 2026.12.10 9:00-10:00 Csatlakozás itt</a>';
echo '</span>';

echo "</tr></table>";

echo "<div class=ui-widget-overlay id='ui-widget-overlay'></div>";
echo "<div id='dialog' title='Alap dialog'></div>";
echo "<div id='dialog2' title='Alap dialog'></div>";
//echo "<div id='dialog3' title='Alap dialog'></div>";
//echo "<div id='dialog4' title='Alap dialog'></div>";
echo "<div id='dialog_egyeni_close' title='Alap dialog'></div>";
//echo "<div id='dialog_egyeni_close2' title='Alap dialog'></div>";

//ie_no_support();

if(
($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']==0)and
($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_stat']==0)and
($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport']==0)and
($GLOBALS[$GLOBALS['sessionname']]['ful_admin']==0)
){

echo "<div id='fo_div_notab' class='fo_div_notab'>";
echo "<div id='fo_table_evho' class='idoszak_div'>";
echo "</div>";
echo "<div id='fodiv'></div>";

echo "</div>";

}else{

/*echo '<pre>';
print_r($_SESSION);
echo '</pre>';*/

echo "<div id='tabs_fo'>";

echo '<ul>';

if($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_rogzit']=="1")
 echo '<li id="tabs_ful_rogzit"><a href="#ful_rogzit">Tevékenység rögzítés '.refresh("ful_rogzit").'</a></li>';

if($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']=="1")
 echo '<li id="tabs_ful_rogzit_jovahagy"><a href="#ful_rogzit_jovahagy">Jóváhagyás '.refresh("ful_rogzit_jovahagy").'</a></li>';

if($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_stat']=="1")
 echo '<li id="tabs_ful_stat"><a href="#ful_stat">Statisztika '.refresh("ful_stat").'</a></li>';

if($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport']=="1")
 echo '<li id="tabs_ful_riport"><a href="#ful_riport">Riport '.refresh("ful_riport").'</a></li>';

if($GLOBALS[$GLOBALS['sessionname']]['ful_admin']=="1")
 echo '<li id="tabs_ful_admin"><a href="#ful_admin">Admin '.refresh("ful_admin").'</a></li>';

echo '</ul>';

echo '<div class="div_ablakok" style="float:none" id="ful_rogzit"></div>';

if($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']=="1")
 echo '<div class="div_ablakok" style="float:none" id="ful_rogzit_jovahagy"></div>';

if($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_stat']=="1")
 echo '<div class="div_ablakok" style="float:none" id="ful_stat"></div>';

if($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport']=="1")
 echo '<div class="div_ablakok" style="float:none" id="ful_riport"></div>';

if($GLOBALS[$GLOBALS['sessionname']]['ful_admin']=="1")
 echo '<div class="div_ablakok" style="float:none" id="ful_admin"></div>';

echo "</div>";

}

/*
echo "<form target=_blank id='pdf_export_akt_user' method=post action='pdf/'>";
echo "<input type='hidden' id='file_form_user' name='user' value='akt'>";
echo "<input type='hidden' id='file_form_idoszak_ev' name='idoszak_ev' value=''>";
echo "<input type='hidden' id='file_form_idoszak_ho' name='idoszak_ho' value=''>";
echo "</form>";
*/

/*
if($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_stat']==1){
 echo "<form target=_parent id='stat_export_form' method=post action='excel_export/excel_export.php'>";
 echo "<input type='hidden' id='stat_form_ev' name='idoszak_ev' value=''>";
 echo "<input type='hidden' id='stat_form_ho' name='idoszak_ho' value=''>";
 echo "<input type='hidden' id='stat_form_nap' name='idoszak_nap' value=''>";
 echo "<input type='hidden' id='stat_form_szerv_id' name='szerv_id' value=''>";
 echo "<input type='hidden' id='stat_form_projekt_id' name='projekt_id' value=''>";
 echo "<input type='hidden' id='stat_form_tipus' name='idoszak_tipus' value=''>";
 echo "<input type='hidden' id='stat_form_kiuser' name='kiuser' value=''>";
 echo "<input type='hidden' id='stat_form_user' name='user' value=''>";
 echo "</form>";
}
*/

/*
if($GLOBALS[$GLOBALS['sessionname']]['ful_admin']=="1"){
 echo "<form target=_parent id='kimeno_excel_export_open_form' method=post action='excel_export/excel_export.php'>";
 echo "<input type='hidden' id='kimeno_excel_export_open_fajta_id' name='fajta_id' value=''>";
 echo "<input type='hidden' id='kimeno_excel_export_open_egyeni_id1' name='egyeni_id1' value=''>";
 echo "<input type='hidden' id='kimeno_excel_export_open_egyeni_id2_kereses_kimeno' name='egyeni_id2_kereses_kimeno' value=''>";
 echo "<input type='hidden' id='kimeno_excel_export_open_egyeni_id2_kereses_bejovo' name='egyeni_id2_kereses_bejovo' value=''>";
 echo "</form>";
}
*/

alairas_ki();
echo '</body></html>';
?>