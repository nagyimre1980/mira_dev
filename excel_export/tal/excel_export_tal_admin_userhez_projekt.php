<?php

function excel_export_admin_userhez_projekt_keres(){
$_POST['user_projekthozza_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

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
  (isset($tomb_pegy[0]))and(isset($tomb_pegy[1]))and($tomb_pegy[0]!="")and($tomb_pegy[1]!="")
  ){
	  //$_POST[$tomb_pegy[0]]=$tomb_pegy[1];
	  //$_POST[$tomb_pegy[0]]=urldecode($tomb_pegy[1]);
	  $_POST[urldecode($tomb_pegy[0])]=urldecode($tomb_pegy[1]);
	  
  }
 }
 }
}

if(!isset($_POST['projekt_nev']))$_POST['projekt_nev']="";

$tomb_user=keres_admin_userhezprojekt($_POST['user_ad'],$_POST['projekt_nev'],$_POST['csakvan']);
$tomb_user_van=keres_userprojekt_user_hozzarend_adat($_POST['user_ad']);
$tomb_user_lat=keres_proj_akt_nevlike($_POST['projekt_nev']);

$szerv_id=keres_mit1_mit1_csak_ertek("mira_user","user_ad",$_POST['user_ad'],"szerv_id");
$tomb_user_osszes_tev=keres_userprojekt_user_osszes_tevekenyseg($_POST['user_ad'],$szerv_id);
$tomb_user_katkivetel=keres_user_projekt_katkivetel_hozzarend_adat($_POST['user_ad']);
excel_export_userhez_projekt_keres_katt_list_ki($tomb_user_osszes_tev,$tomb_user,$tomb_user_van,$tomb_user_lat,$tomb_user_katkivetel);

}

function excel_export_userhez_projekt_keres_katt_list_ki($tomb_user_osszes_tev,$tomb_user,$tomb_user_van,$tomb_user_lat,$tomb_user_katkivetel){

$i=0;
//$adat[$i][]="<b>ID</b>";
$adat[$i][]="<b>Tevékenység neve</b>";
$adat[$i][]="<b>Hozzárendelés</b>";
$adat[$i][]="<b>Önköltség kategória kivétel/b>";

if(is_array($tomb_user)){

foreach($tomb_user as $isor => $ert){

if($isor>0){//Első sor a talszám
 $i++;
 
if(isset($tomb_user_van[$ert['projekt_id']])){
 $ck="Igen";
}else{
 $ck="";
}

//$adat[$i][]=$ert['projekt_id'];
$adat[$i][]=$ert['projekt_nev'];
$adat[$i][]=$ck;

if((isset($tomb_user_katkivetel[$ert['projekt_id']]['nev']))and($tomb_user_katkivetel[$ert['projekt_id']]['nev']!=''))
 $adat[$i][]=$tomb_user_katkivetel[$ert['projekt_id']]['nev'].' - '.$tomb_user_katkivetel[$ert['projekt_id']]['nev_h'];
else $adat[$i][]='';

}
}
	
}

//Második munkalap összes szervezettel - eleje
$i=0;
$adat_all[$i][]="<b>Tevékenység neve</b>";
if(is_array($tomb_user)){
foreach($tomb_user_osszes_tev as $isor => $ert){
//if($isor>0){//Első sor a talszám
 $i++;
$adat_all[$i][]=$ert['projekt_nev'];
//}
}
	
}
//Második munkalap összes szervezettel - vége

//print_r($adat);exit;
$date=date("Y_m_d-H_i_s",time());
$filename="Felhasználóhoz rendelt tevékenységek excel export ".$date.".xlsx";
//SimpleXLSXGen::fromArray( $adat )->downloadAs(rawurlencode($filename));


//(string)(new SimpleXLSXGen)->addSheet($adat,'MIRA export - Saját tevékenységek')->downloadAs(rawurlencode($filename));
$xlsx = new Shuchkin\SimpleXLSXGen();
$xlsx->addSheet($adat,'Saját tevékenységek');


$xlsx->addSheet($adat_all,'User összes tevékenységei');

$xlsx->downloadAs(rawurlencode($filename));
exit;
}

?>