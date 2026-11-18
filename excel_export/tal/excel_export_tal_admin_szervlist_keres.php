<?php

function excel_export_admin_szervlist_keres(){
$_POST['szervlist_keres_talszam']="999999";//999.999
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

$tomb=keres_admin_szerv_uj();
$tomb_user=keres_user_hozzarend_szam($tomb);
$tomb_projekt=keres_projekt_hozzarend_szam($tomb);
$tomb_jovahagyok=keres_szerv_jovahagyok_hozzarend_szam($tomb);

$tomb_jovahagyok_adat=keres_szerv_jovahagyok_adat();
$tomb_jovahagyok_user_felettes_adat=keres_szerv_user_felettes_adat();

$i=0;
$adat[$i][]="<b>ID</b>";
$adat[$i][]="<b>Szervezet neve</b>";
$adat[$i][]="<b>Statisztika költséghely</b>";
$adat[$i][]="<b>AD költséghely</b>";
$adat[$i][]="<b>Szervezeti szolgáltatás kód</b>";
$adat[$i][]="<b>Szervezet csoportosítási név</b>";
$adat[$i][]="<b>SM SAP kód</b>";
$adat[$i][]="<b>Jóváhagyók száma</b>";
$adat[$i][]="<b>Hozzárendelt tevékenységek száma</b>";
$adat[$i][]="<b>Hozzárendelt felhasználók száma</b>";
$adat[$i][]="<b>Inaktív</b>";

if(is_array($tomb)){
foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['szerv_id'];
 $adat[$i][]=$ert['szerv_nev'];
 $adat[$i][]=$ert['szerv_koltsegkod'];
 $adat[$i][]=$ert['szerv_adkod'];
 $adat[$i][]=$ert['szerv_szolg_kod'];
 $adat[$i][]=$ert['mira_szerv_csoport_nev'];
 $adat[$i][]=$ert['szerv_sm_kod'];

 if(isset($tomb_jovahagyok[$ert['szerv_id']]))
  $tomb_jovahagyokszam=$tomb_jovahagyok[$ert['szerv_id']];
 else $tomb_jovahagyokszam=0;
 $adat[$i][]=$tomb_jovahagyokszam;
 
 if(isset($tomb_projekt[$ert['szerv_id']]))
  $tomb_projektszam=$tomb_projekt[$ert['szerv_id']];
 else $tomb_projektszam=0;
 $adat[$i][]=$tomb_projektszam;
 
 if(isset($tomb_user[$ert['szerv_id']]))
  $tomb_userszam=$tomb_user[$ert['szerv_id']];
 else $tomb_userszam=0;
 $adat[$i][]=$tomb_userszam;
 
 $adat[$i][]=igennem_kod_ki($ert['szerv_inaktiv']);
}
}
}

//Összes szervezet jóváhagyói - eleje
$i_s=0;
$adat_szerv_jov[$i_s][]="<b>Szervezet neve</b>";
$adat_szerv_jov[$i_s][]="<b>Jóváhagyó</b>";
$adat_szerv_jov[$i_s][]="<b>Jóváhagyó AD</b>";
$adat_szerv_jov[$i_s][]="<b>Jóváhagyó fül jogosultság</b>";
if(is_array($tomb_jovahagyok_adat)){
foreach($tomb_jovahagyok_adat as $isor => $ert){
 $i_s++;
 $adat_szerv_jov[$i_s][]=$ert['szerv_nev'];
 $adat_szerv_jov[$i_s][]=$ert['user_nev'];
 $adat_szerv_jov[$i_s][]=$ert['user_ad'];
 $adat_szerv_jov[$i_s][]=igennem_kod_ki($ert['ful_jovahagy']);
}
}
//Összes szervezet jóváhagyói - vége

//Felettes jóváhagyók - eleje
$i_f=0;
$adat_user_fel[$i_f][]="<b>Felhasználó</b>";
$adat_user_fel[$i_f][]="<b>Felhasználó AD</b>";
$adat_user_fel[$i_f][]="<b>Felettes jóváhagyó</b>";
$adat_user_fel[$i_f][]="<b>Felettes jóváhagyó AD</b>";
$adat_user_fel[$i_f][]="<b>Felettes jóváhagyó fül jogosultság</b>";
if(is_array($tomb_jovahagyok_user_felettes_adat)){
foreach($tomb_jovahagyok_user_felettes_adat as $isor => $ert){
 $i_f++;
 $adat_user_fel[$i_f][]=$ert['user_nev'];
 $adat_user_fel[$i_f][]=$ert['user_ad'];
 $adat_user_fel[$i_f][]=$ert['user_nev_ki'];
 $adat_user_fel[$i_f][]=$ert['user_ad_ki'];
 $adat_user_fel[$i_f][]=igennem_kod_ki($ert['ful_jovahagy']);
}
}
//Felettes jóváhagyók - vége

//print_r($adat);exit;
$date=date("Y_m_d-H_i_s",time());
$filename="Admin szervezet lista excel export ".$date.".xlsx";
//SimpleXLSXGen::fromArray( $adat )->downloadAs(rawurlencode($filename));
//(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

$xlsx = new Shuchkin\SimpleXLSXGen();
$xlsx->addSheet($adat,'Szervezet lista');

$xlsx->addSheet($adat_szerv_jov,'Összes szervezet jóváhagyói');
$xlsx->addSheet($adat_user_fel,'Felettes jóváhagyók');

if((isset($GLOBALS['excel_auto_save']))and($GLOBALS['excel_auto_save']=='1')and(isset($GLOBALS['excel_auto_mappa']))){
 $xlsx->saveAs($GLOBALS['excel_auto_mappa'].$filename);
}else{
 $xlsx->downloadAs(rawurlencode($filename));
 exit;
}

}

?>