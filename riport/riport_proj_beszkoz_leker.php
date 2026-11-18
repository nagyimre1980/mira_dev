<?php

function riport_proj_beszkoz(){

$tomb=keres_riport_proj_beszkoz_tev();
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

$date=date("Y_m_d-H_i_s",time());
$filename="Beszerzési és közbeszerzési tevékenységek excel export ".$date.".xlsx";
$xlsx = new Shuchkin\SimpleXLSXGen();
$xlsx->addSheet($adat,$GLOBALS['rend_nev'].' export');
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
$tomb2=keres_admin_projekt_uj_szervprojekt();
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
$tomb3=keres_admin_projekt_uj_szervuser();
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
}
$xlsx->addSheet($adat3,$GLOBALS['rend_nev'].' szervezetek-felhasználók');
unset($adat3);

//Letöltés
$xlsx->downloadAs(rawurlencode($filename));
exit;
}

function keres_riport_proj_beszkoz_tev(){
$eredmeny_keres='';

$sql="SELECT
projekt.projekt_id,
projekt.projekt_nev,
projekt.projekt_kezd_date,
projekt.projekt_veg_date,
projekt.projekt_tagv_kod,
projekt.projekt_szolg_kod,

projekt.projekt_co,
projekt.projekt_title,
projekt.projekt_inaktiv,

projekt_kat.projekt_kat_nev,
projekt_kat.projekt_kat_nev_h
FROM `projekt`
left join projekt_kat ON projekt_kat.projekt_kat_id = projekt.projekt_kat_id
where 
(
 (projekt.projekt_szolg_kod like '__BE')
 or
 (projekt.projekt_szolg_kod like '__KB')
)and 
projekt.projekt_inaktiv ='0' 
order by projekt.projekt_id ASC
";
 //echo $sql."<br>";//exit;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_projekt_uj_szervuser(){
 $eredmeny_keres="";
 $sql="SELECT 
  projekt.projekt_nev,
  projekt.projekt_tagv_kod,
  mira_tagv_kod.tagv_kod_nev,
  projekt_kat.projekt_kat_nev,
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
 where 
 (
 (projekt.projekt_szolg_kod like '__BE')
 or
 (projekt.projekt_szolg_kod like '__KB')
 ) and 
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
 $sql="SELECT 
  projekt.projekt_nev,
  projekt.projekt_tagv_kod,
  mira_tagv_kod.tagv_kod_nev,
  projekt_kat.projekt_kat_nev,
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
 where 
 (
 (projekt.projekt_szolg_kod like '__BE')
 or
 (projekt.projekt_szolg_kod like '__KB')
 ) and 
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