<?php

//$GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport']
//$GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']

/*
echo '<pre>';
print_r($GLOBALS[$GLOBALS['sessionname']]);
echo '</pre>';
*/

if(
(!isset($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport']))or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport']))and
 ($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport']=='0')
){
 szerz_file_nincsjoga();
}

$tomb_riport_jog=keres_riport_jog_szerz();

if(
($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='0')and
(!is_array($tomb_riport_jog))
){//Van-e a szerződés nyilvántartóra joga
 szerz_file_nincsjoga();
}

//Létezik-e a szerz_csop_id, ha ez nulla, akkor rekord nem található a hibaüzenet.
$szerz_csop_id=keres_csop_id($_GET['i'],$_GET['k']);
if($szerz_csop_id==''){
 szerz_file_nincsszerz();
}

$ful_riport_szerz_csop_all=keres_riport_szerznyilv_jog_all();
//Ezt az ellenőrzést majd idővel ki kell kapcsolni, ha a korábi excelek kikoptak!
if(($ful_riport_szerz_csop_all=='0')and(isset($_GET['a']))and($_GET['a']!='')){
$szerz_csop_id_adott=keres_csop_id_adott($_GET['a']);
$tomb_csopjog=keres_riport_szerznyilv_jog();
//Ha létezik, akkor kell joga lennie rá
if(
 //($ful_riport_szerz_csop_all=='0')and
 (!isset($tomb_csopjog[$szerz_csop_id_adott]))
 //and($tomb_csopjog[$szerz_csop_id_adott]=='1')
){
  szerz_file_nincsjoga();
}
}
//Akkor van joga.

$szerz_file_id=keres_mit2_mit1_csak_ertek('szerz_file','szerz_id',$_GET['i'],'szerz_tetel_modszam_kezi',$_GET['k'],'szerz_file_id');
if($szerz_file_id==''){
 szerz_file_nincsszerz();
}

$file_name=$szerz_file_id.'.pdf';
if($_GET['t']=='szerz'){
 $file=$GLOBALS['szerz_szerz'].$file_name;
 $file_name_ki=keres_mit1_mit1_csak_ertek('szerz_file','szerz_file_id',$szerz_file_id,'szerz_file_szerz_name');
}else{
 $file=$GLOBALS['szerz_ar'].$file_name;
 $file_name_ki=keres_mit1_mit1_csak_ertek('szerz_file','szerz_file_id',$szerz_file_id,'szerz_file_ar_name');
}

if($file_name_ki==''){
 exit;
}

if(
(!is_file($file))or
(!is_readable($file))
){
 szerz_file_nincsszerz();
}

header('Content-Type: application/pdf');
header('Content-Length: ' . filesize($file));
header('Content-Disposition: inline; filename="'.$file_name_ki.'"');

header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');
header('Expires: 0'); 
readfile($file);

//Hogy tuti ne menjen tovább  a kitöltő felületre
exit;

function szerz_file_nincsjoga(){
 echo '<!DOCTYPE HTML><html lang="hu"><head><meta HTTP-EQUIV="Content-Type" content="text/html; charset=utf-8"><meta name="content-language" content="hu, hun, hungarian"><link rel="shortcut icon" href="favicon.ico" type="image/x-icon"><meta name="googlebot" content="noarchive"><meta name="ROBOTS" content="NOINDEX, NOFOLLOW"><meta name="author" content="Nagy Imre"><meta name="copyright" content="MVM Services Zrt."><meta name="viewport" content="width=device-width, initial-scale=1">';
 echo '<title>'.$GLOBALS['rend_nev'].$GLOBALS['tesztdevmod'].'</title>';
 css_ki('k');
 nincs_joga();
 echo '</head><body>';
 exit;
}

function szerz_file_nincsszerz(){
 echo '<!DOCTYPE HTML><html lang="hu"><head><meta HTTP-EQUIV="Content-Type" content="text/html; charset=utf-8"><meta name="content-language" content="hu, hun, hungarian"><link rel="shortcut icon" href="favicon.ico" type="image/x-icon"><meta name="googlebot" content="noarchive"><meta name="ROBOTS" content="NOINDEX, NOFOLLOW"><meta name="author" content="Nagy Imre"><meta name="copyright" content="MVM Services Zrt."><meta name="viewport" content="width=device-width, initial-scale=1">';
 echo '<title>'.$GLOBALS['rend_nev'].$GLOBALS['tesztdevmod'].'</title>';
 css_ki('k');
 echo "<div style='text-align:center;display: block;margin:auto;width:50%;'>";
 echo "<span class='focim'>".$GLOBALS['rend_nev'].$GLOBALS['rend_str']."<br><br>";
 if($_GET['t']=='szerz'){
  echo '<h2>Szerződés nem található!</h2>';
 }else{
  echo '<h2>Árajánlat nem található!</h2>';
 }
 echo "</span></div><br>";
 alairas_ki();
 echo '</head><body>';
 exit;
}

function keres_csop_id_adott($szerz_tetel_adat_id){
$eredmeny_keres="";
$szerz_tetel_adat_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerz_tetel_adat_id);
 $sql="SELECT
 szerz_tetel_adat.szerz_csop_id
 FROM `szerz_tetel_adat` 
 where
 szerz_tetel_adat.szerz_tetel_adat_id='".$szerz_tetel_adat_id."'
 ";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres=$adatom['szerz_csop_id'];
 }
 return $eredmeny_keres;
}

function keres_csop_id($szerz_id,$szerz_tetel_modszam_kezi){
$eredmeny_keres="";
$szerz_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerz_id);
$szerz_tetel_modszam_kezi=mysqli_real_escape_string($GLOBALS['mysqli'],$szerz_tetel_modszam_kezi);
 $sql="SELECT
 szerz_csop_id
 FROM `szerz_tetel_adat` 
 where
 szerz_tetel_adat.szerz_id='".$szerz_id."' and 
 szerz_tetel_adat.szerz_tetel_modszam_kezi='".$szerz_tetel_modszam_kezi."' 
 order by szerz_tetel_adat.szerz_tetel_adat_id desc
 limit 1
 ";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres=$adatom['szerz_csop_id'];
 }
 return $eredmeny_keres;
}

function keres_riport_jog_szerz(){
$eredmeny_keres="";

 $sql="SELECT
 mira_user_riport_id
 FROM `mira_user_riport` 
 where
 mira_user_riport.user_ad='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."' and 
 (
 (mira_user_riport.riport_tipus='szerznyilv')
 or
 (mira_user_riport.riport_tipus='szerznyilv_elo')
 )
 ";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_riport_szerznyilv_jog_all(){
$eredmeny_keres="";

 $sql="SELECT
 mira_user.ful_riport_szerz_csop_all
 FROM `mira_user` 
 left join mira_user_riport_szerz ON mira_user_riport_szerz.user_ad = mira_user.user_ad
 where
 mira_user.user_ad='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'
 ";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres=$adatom['ful_riport_szerz_csop_all'];
 }
 return $eredmeny_keres;
}

function keres_riport_szerznyilv_jog(){
$eredmeny_keres="";

 $sql="SELECT
 mira_user_riport_szerz.szerz_csop_id 
 FROM `mira_user` 
 left join mira_user_riport_szerz ON mira_user_riport_szerz.user_ad = mira_user.user_ad
 where
 mira_user.user_ad='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'
 ";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szerz_csop_id']]='1';
 }
 return $eredmeny_keres;
}
?>