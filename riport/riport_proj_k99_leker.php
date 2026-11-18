<?php

function riport_proj_k99(){

$tomb=keres_riport_k99_tev();
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
$filename="KK99 tevékenységek excel export ".$date.".xlsx";
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

}

function keres_riport_k99_tev(){
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
where projekt.projekt_szolg_kod='KK99'
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

?>