<?php

function excel_export_admin_projektlist_keres(){
$_POST['projektlist_keres_talszam']="999999";//999.999
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

$tomb=keres_admin_projekt_uj();
$tomb_szervszam=keres_projekt_hozzarend_szervszam($tomb);
$tomb_userszam=keres_projekt_hozzarend_userszam($tomb);

$i=0;
$adat[$i][]="<b>ID</b>";
$adat[$i][]="<b>Tevékenység neve</b>";
$adat[$i][]="<b>Rögzítés kezdete</b>";
$adat[$i][]="<b>Rögzítés vége</b>";
$adat[$i][]="<b>Társasági SAP kód</b>";
$adat[$i][]="<b>Tevékenységek szolgáltatás kód</b>";
$adat[$i][]="<b>Önköltség kategória</b>";
$adat[$i][]="<b>CO objektum</b>";
$adat[$i][]="<b>Leírás</b>";
$adat[$i][]="<b>Szervezetek száma</b>";
$adat[$i][]="<b>Felhasználók száma</b>";
$adat[$i][]="<b>Inaktív</b>";

if(is_array($tomb)){
foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['projekt_id'];
 $adat[$i][]=$ert['projekt_nev'];
 $adat[$i][]=$ert['projekt_kezd_date'];
 $adat[$i][]=$ert['projekt_veg_date'];
 $adat[$i][]=$ert['projekt_tagv_kod'];
 $adat[$i][]=$ert['projekt_szolg_kod'];
 
 if($ert['projekt_kat_nev']!='')
  $adat[$i][]=$ert['projekt_kat_nev'].' - '.$ert['projekt_kat_nev_h'];
 else $adat[$i][]="";
	 
 $adat[$i][]=$ert['projekt_co'];
 $adat[$i][]=str_replace("\n"," ",$ert['projekt_title']);
 
 if(isset($tomb_szervszam[$ert['projekt_id']]))
  $ki_szervszam=$tomb_szervszam[$ert['projekt_id']];
 else $ki_szervszam=0;
 $adat[$i][]=$ki_szervszam;
 
 if(isset($tomb_userszam[$ert['projekt_id']]))
  $ki_userszam=$tomb_userszam[$ert['projekt_id']];
 else $ki_userszam=0;
 $adat[$i][]=$ki_userszam;

 $adat[$i][]=igennem_kod_ki($ert['projekt_inaktiv']);
}
}
}
//print_r($adat);exit;
$date=date("Y_m_d-H_i_s",time());
$filename="Admin tevékenység lista excel export ".$date.".xlsx";
$xlsx = new Shuchkin\SimpleXLSXGen();
//SimpleXLSXGen::fromArray( $adat )->downloadAs(rawurlencode($filename));
//(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));
$xlsx->addSheet($adat,$GLOBALS['rend_nev'].' szervezetek export');
unset($adat);

//2. munkalap. Tevékenység - szervezet.
$adat2=array();
$i=0;
$adat2[$i][]="<b>Tevékenység neve</b>";
$adat2[$i][]="<b>Társasági SAP kód</b>";
$adat2[$i][]="<b>Társasági neve</b>";
$adat2[$i][]="<b>Szervezet csoportosítási név</b>";
$adat2[$i][]="<b>Szolgáltatás kód</b>";
$adat2[$i][]="<b>Szolgáltatási neve</b>";
$adat2[$i][]="<b>Szervezet neve</b>";
$adat2[$i][]="<b>Szervezet Statisztika költséghely</b>";
$adat2[$i][]="<b>Szervezet AD költséghely</b>";
$adat2[$i][]="<b>SM SAP kód</b>";
$adat2[$i][]="<b>Önköltség kategória</b>";
$tomb2=keres_admin_projekt_uj_szervprojekt();
if(is_array($tomb2)){
foreach($tomb2 as $isor => $ert){
 $i++;
 $adat2[$i][]=$ert['projekt_nev'];
 $adat2[$i][]=$ert['projekt_tagv_kod'];
 $adat2[$i][]=$ert['tagv_kod_nev'];
 $adat2[$i][]=$ert['projekt_kat_nev'];
 $adat2[$i][]=$ert['szolg_kod'];
 $adat2[$i][]=$ert['szolg_kod_nev'];
 $adat2[$i][]=$ert['szerv_nev'];
 $adat2[$i][]=$ert['szerv_koltsegkod'];
 $adat2[$i][]=$ert['szerv_adkod'];
 $adat2[$i][]=$ert['szerv_sm_kod'];
 
 if($ert['projekt_kat_nev']!='')
  $adat2[$i][]=$ert['projekt_kat_nev'].' - '.$ert['projekt_kat_nev_h'];
 else $adat2[$i][]="";
 
}
}
$xlsx->addSheet($adat2,$GLOBALS['rend_nev'].' szervezetek-tevékenységek');
unset($adat2);

//3. munkalap. Tevékenység - szervezet.
$adat3=array();
$i=0;
$adat3[$i][]="<b>Tevékenység neve</b>";
$adat3[$i][]="<b>Társasági SAP kód</b>";
$adat3[$i][]="<b>Társasági neve</b>";
$adat3[$i][]="<b>Szervezet csoportosítási név</b>";
$adat3[$i][]="<b>Szolgáltatás kód</b>";
$adat3[$i][]="<b>Szolgáltatási neve</b>";
$adat3[$i][]="<b>Felhasználó neve</b>";
$adat3[$i][]="<b>Felhasználó AD</b>";
$adat3[$i][]="<b>Felhasználó törzsszám</b>";
$adat3[$i][]="<b>Felhasználó szervezete</b>";
$adat3[$i][]="<b>Önköltség kategória</b>";
$tomb3=keres_admin_projekt_uj_szervuser();
if(is_array($tomb3)){
foreach($tomb3 as $isor => $ert){
 $i++;
 $adat3[$i][]=$ert['projekt_nev'];
 $adat3[$i][]=$ert['projekt_tagv_kod'];
 $adat3[$i][]=$ert['tagv_kod_nev'];
 $adat3[$i][]=$ert['projekt_kat_nev'];
 $adat3[$i][]=$ert['szolg_kod'];
 $adat3[$i][]=$ert['szolg_kod_nev'];
 $adat3[$i][]=$ert['user_nev'];
 $adat3[$i][]=$ert['user_ad'];
 $adat3[$i][]=$ert['user_tsz'];
 $adat3[$i][]=$ert['szerv_nev'];
 
 if($ert['projekt_kat_nev']!='')
  $adat3[$i][]=$ert['projekt_kat_nev'].' - '.$ert['projekt_kat_nev_h'];
 else $adat3[$i][]="";
}
}
$xlsx->addSheet($adat3,$GLOBALS['rend_nev'].' szervezetek-felhasználók');
unset($adat3);

//Letöltés
if((isset($GLOBALS['excel_auto_save']))and($GLOBALS['excel_auto_save']=='1')and(isset($GLOBALS['excel_auto_mappa']))){
 $xlsx->saveAs($GLOBALS['excel_auto_mappa'].$filename);
}else{
 $xlsx->downloadAs(rawurlencode($filename));
 exit;
}

}

function keres_admin_projekt_uj_szervuser(){
 $eredmeny_keres="";
 $sql="SELECT 
  projekt.projekt_nev,
  projekt.projekt_tagv_kod,
  mira_tagv_kod.tagv_kod_nev,
    
-- 1. csoport: Név prioritás
  COALESCE(
    projekt_kat_kiv_user.projekt_kat_nev, 
    projekt_kat_kiv.projekt_kat_nev, 
    projekt_kat.projekt_kat_nev
  ) AS projekt_kat_nev,

  -- 2. csoport: Név_h prioritás
  COALESCE(
    projekt_kat_kiv_user.projekt_kat_nev_h, 
    projekt_kat_kiv.projekt_kat_nev_h, 
    projekt_kat.projekt_kat_nev_h
  ) AS projekt_kat_nev_h, 

  mira_szolg_kod.szolg_kod,
  mira_szolg_kod.szolg_kod_nev,
  mira_user.user_nev,
  mira_user.user_ad,
  mira_user.user_tsz,
  mira_szerv.szerv_nev 
 FROM `projekt` 
 left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = projekt.projekt_szolg_kod
 left join projekt_kat ON projekt_kat.projekt_kat_id = projekt.projekt_kat_id 
 left join mira_tagv_kod ON mira_tagv_kod.tagv_kod = projekt.projekt_tagv_kod 
 inner join projekt_user ON projekt_user.projekt_id = projekt.projekt_id
 inner join mira_user ON mira_user.user_ad = projekt_user.user_ad
	and mira_user.user_inaktiv ='0'
 left join mira_szerv ON mira_szerv.szerv_id = mira_user.szerv_id
 
 left join projekt_szerv_katkivetel ON projekt_szerv_katkivetel.projekt_id = projekt.projekt_id
	and projekt_szerv_katkivetel.szerv_id = mira_user.szerv_id
 left join projekt_kat as projekt_kat_kiv ON projekt_kat_kiv.projekt_kat_id  = projekt_szerv_katkivetel.projekt_kat_id_kivetel 
 
 left join projekt_user_katkivetel ON projekt_user_katkivetel.projekt_id = projekt.projekt_id
	and projekt_user_katkivetel.user_ad = mira_user.user_ad
 left join projekt_kat as projekt_kat_kiv_user ON projekt_kat_kiv_user.projekt_kat_id  = projekt_user_katkivetel.projekt_user_kat_id_kivetel 
 
 where 
 projekt.projekt_inaktiv ='0'
 order by projekt.projekt_nev asc, mira_user.user_nev asc
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_projekt_uj_szervprojekt(){
 $eredmeny_keres="";
 /*
  projekt_kat.projekt_kat_nev,
  projekt_kat.projekt_kat_nev_h,
  projekt_kat_kiv.projekt_kat_nev,
  projekt_kat_kiv.projekt_kat_nev_h, 
 */

 $sql="SELECT 
  projekt.projekt_nev,
  projekt.projekt_tagv_kod,
  mira_tagv_kod.tagv_kod_nev,

  COALESCE(projekt_kat_kiv.projekt_kat_nev, projekt_kat.projekt_kat_nev) AS projekt_kat_nev,
  COALESCE(projekt_kat_kiv.projekt_kat_nev_h, projekt_kat.projekt_kat_nev_h) AS projekt_kat_nev_h,

  mira_szolg_kod.szolg_kod,
  mira_szolg_kod.szolg_kod_nev,
  mira_szerv.szerv_nev,
  mira_szerv.szerv_koltsegkod,
  mira_szerv.szerv_adkod,
  mira_szerv.szerv_sm_kod
 FROM `projekt` 
 left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = projekt.projekt_szolg_kod
 left join projekt_kat ON projekt_kat.projekt_kat_id = projekt.projekt_kat_id 
 left join mira_tagv_kod ON mira_tagv_kod.tagv_kod = projekt.projekt_tagv_kod 
 inner join projekt_szerv ON projekt_szerv.projekt_id = projekt.projekt_id
 inner join mira_szerv ON mira_szerv.szerv_id = projekt_szerv.szerv_id
	and mira_szerv.szerv_inaktiv='0'
 left join projekt_szerv_katkivetel ON projekt_szerv_katkivetel.projekt_id = projekt.projekt_id
	and projekt_szerv_katkivetel.szerv_id = projekt_szerv.szerv_id
 left join projekt_kat as projekt_kat_kiv ON projekt_kat_kiv.projekt_kat_id  = projekt_szerv_katkivetel.projekt_kat_id_kivetel 
 where 
 projekt.projekt_inaktiv ='0'
 order by projekt.projekt_nev asc, mira_szerv.szerv_nev asc
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

?>