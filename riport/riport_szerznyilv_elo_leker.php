<?php
include_once('riport_szerznyilv_leker.php');

function riport_szerznyilv_elo(){

$i=0;
$adat[$i][]="<b>Szerződés azonosító</b>";//ID
$adat[$i][]="<b>Szolgáltatás azonosító</b>";//ID
if(
(isset($GLOBALS[$GLOBALS['sessionname']]['ful_admin']))and
($GLOBALS[$GLOBALS['sessionname']]['ful_admin']=='1')
){
 $adat[$i][]="<b>ADAT ID</b>";
}
$adat[$i][]="<b>Társaság</b>";
$adat[$i][]="<b>Társaság neve</b>";
$adat[$i][]="<b>Társasági kategória</b>";
$adat[$i][]="<b>Társasági kategória Hatályos mikortól</b>";
$adat[$i][]="<b>Keretszerződés</b>";
$adat[$i][]="<b>Szerződés típus</b>";
$adat[$i][]="<b>Szerződés hatályba lépésének időpontja</b>";
$adat[$i][]="<b>SAP szerződésszám</b>";
$adat[$i][]="<b>CO</b>";

//$adat[$i][]="<b>Hatályos szerződésmódosítás száma</b>";//J
$adat[$i][]="<b>Szerződés módosítás száma</b>";//J


$adat[$i][]="<b>Aktuális szerződésmódosítás</b>";
$adat[$i][]="<b>Folyamatban</b>";
$adat[$i][]="<b>Szolgáltatás csoport</b>";
$adat[$i][]="<b>Szolgáltatás kód</b>";
$adat[$i][]="<b>Szolgáltatás neve</b>";
$adat[$i][]="<b>Utókalkuláció</b>";
$adat[$i][]="<b>Nettó szerződés díj (eseti/maximális keret)</b>";

$adat[$i][]="<b>Szolgáltásnyújtás megkezdésének időpontja</b>";

$adat[$i][]="<b>Árajánlat aláírás dátuma</b>";
$adat[$i][]="<b>Aláírás dátuma</b>";

$adat[$i][]="<b>Nettó szerződéses havidíj</b>";
$adat[$i][]="<b>Devizanem</b>";
$adat[$i][]="<b>Elszámolás típusa</b>";
$adat[$i][]="<b>Óradíj</b>";

$adat[$i][]="<b>Szerződésmódosítás hatályba lépésének dátuma</b>";
$adat[$i][]="<b>Szerződésmódosítás vége (határozott esetén dátum)</b>";
$adat[$i][]="<b>Szolgáltatás megszünése - vége dátum</b>";


$adat[$i][]="<b>Szerződés időtartam eredeti (határozott esetén)</b>";
$adat[$i][]="<b>Szerződés időtartam aktuális (határozott esetén)</b>";

$adat[$i][]="<b>Idei naptári évi éves díj";
$adat[$i][]="<b>Naturália típus";
$adat[$i][]="<b>Naturália mennyiség (HAVI)";
$adat[$i][]="<b>Szerződésgazda";

$adat[$i][]="<b>Integrációban érintett";
$adat[$i][]="<b>Integrációs többlet FTE";
$adat[$i][]="<b>Integrációs naturália többlet havonta";
$adat[$i][]="<b>Integrációs többlet megjegyzés";


$adat[$i][]="<b>Általános megjegyzés";
$adat[$i][]="<b>TT megjegyzés";
//$adat[$i][]="<b>Szerződés elérése a hálózaton";
$adat[$i][]="<b>Szerződés";
$adat[$i][]="<b>Árajánlat";

$adat[$i][]="<b>Rögzítő";
$adat[$i][]="<b>Rögzítés ideje";
$adat[$i][]="<b>Módosító";
$adat[$i][]="<b>Módosítás ideje";
$adat[$i][]="<b>Módosítás ID</b>";//Volt J
$adat[$i][]="<b>Tevékenység</b>";
$adat[$i][]="<b>KPI típus</b>";

$tomb_szerz_jog=keres_riport_szerznyilv_jog();
$tomb=keres_riport_szerznyilv('elo',$tomb_szerz_jog);
include_once('../function.php');
foreach($tomb as $isor => $ert){
//if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['szerz_id'];
 $adat[$i][]=$ert['szerz_tetel_id'];
 
 if(
 (isset($GLOBALS[$GLOBALS['sessionname']]['ful_admin']))and
 ($GLOBALS[$GLOBALS['sessionname']]['ful_admin']=='1')
 ){
  $adat[$i][]=$ert['szerz_tetel_adat_id'];
 }

 $adat[$i][]=$ert['tagv_kod'];
 $adat[$i][]=$ert['tagv_kod_nev'];
 $adat[$i][]=kiert_szerz_tagvkat_kat($ert['szerz_tagvkat_kat']);
 $adat[$i][]=kidate_format_ev($ert['szerz_tagvkat_date_kezd']);
 $adat[$i][]=igennem_kod_ki($ert['szerz_keret']);
 $adat[$i][]=$ert['szerz_tipus_nev'];
 $adat[$i][]=$ert['szerz_date_hatalybelep'];
 $adat[$i][]=$ert['szerz_sapszam'];
 $adat[$i][]=$ert['szerz_tetel_co'];
 
 /*
 if($ert['szerz_tetel_szolg_kezd_date_folyamatban']=='1'){
  $adat[$i][]='-1';
 }else{
  $adat[$i][]=$ert['szerz_tetel_modszam'];
 }*/
 
 $adat[$i][]=$ert['szerz_tetel_modszam_kezi'];

 if(($ert['szerz_tetel_akt']=='1')and($ert['szerz_tetel_szolg_kezd_date_folyamatban']=='0')and($ert['szerz_tetel_akt_folyamatban']=='0')){
  //$adat[$i][]='Aktuális';
  $adat[$i][]='Igen';
 }else $adat[$i][]='';
 
 //Folyamatban
 if(($ert['szerz_tetel_szolg_kezd_date_folyamatban']=='1')or($ert['szerz_tetel_akt_folyamatban']=='1')){
  $adat[$i][]='Igen';
 }else{
  $adat[$i][]='';
 }
 
 $adat[$i][]=$ert['szerz_csop_nev'];
 $adat[$i][]=$ert['szolg_kod'];
 $adat[$i][]=$ert['szolg_kod_nev'];

 $adat[$i][]=igennem_kod_ki($ert['szerz_tetel_utok']);
 $adat[$i][]=$ert['szerz_tetel_netto_szerzdij'];
 $adat[$i][]=$ert['szerz_tetel_szolg_kezd_date'];
 
 $adat[$i][]=$ert['szerz_tetel_arajanlat_alair_date'];
 $adat[$i][]=$ert['szerz_tetel_alair_date'];
 
 $adat[$i][]=$ert['szerz_tetel_netto_havidij'];
 $adat[$i][]=$ert['szerz_tetel_netto_havidij_penznem'];
 $adat[$i][]=$ert['szerz_elsz_tipus_nev'];
 
 //Óradíj
 $adat[$i][]=$ert['szerz_tetel_oradij'];
 
 //Szerződésmódosítás hatályba lépésének dátuma - eleje
 if($ert['szerz_tetel_szolg_mod_date']!=''){
	$adat[$i][]=$ert['szerz_tetel_szolg_mod_date'];
 }else{$adat[$i][]='';}
 //Szerződésmódosítás hatályba lépésének dátuma - vége
 
 //Szerződésmódosítás vége (határozott esetén dátum) - eleje
 if($ert['szerz_tetel_szolg_modveg_date']!=''){
	 $adat[$i][]=$ert['szerz_tetel_szolg_modveg_date'];
 }else{$adat[$i][]='';}
 //Szerződésmódosítás vége (határozott esetén dátum) - vége
 
 //Szolgáltatás megszünése - vége dátum - eleje
 if($ert['szerz_tetel_vege']=='1'){
	$adat[$i][]=$ert['szerz_tetel_vege_date']; 
 }else{$adat[$i][]='';}
 //Szolgáltatás megszünése - vége dátum - vége
 
 //Szerződés időtartam (határozott esetén)
 $adat[$i][]=$ert['szerz_tetel_szolg_origveg_date'];
 
 //Szerződés időtartam aktuális (határozott esetén)
 $adat[$i][]=$ert['szerz_tetel_szolg_aktveg_date'];
 
 $adat[$i][]=$ert['szerz_tetel_netto_evesdij'];
 $adat[$i][]=$ert['szerz_naturalia_nev'];
 
 //$ert['szerz_tetel_naturalia_darab']++;
 //$ert['szerz_tetel_naturalia_darab']--;
 //$adat[$i][]=kiosszeg_format_eur($ert['szerz_tetel_naturalia_darab']);
 $adat[$i][]='<style nf="# ##0.00">'.$ert['szerz_tetel_naturalia_darab'].'</style>';
 
 $adat[$i][]=$ert['szerz_usergazda_nev'];
 
 $adat[$i][]=igennem_kod_ki($ert['szerz_tetel_integ_erintett']);
 //$adat[$i][]=kiosszeg_format_eur($ert['szerz_tetel_integ_tobblet']);
 //$adat[$i][]=kiosszeg_format_eur($ert['szerz_tetel_integ_tobblet_ho']);
 $adat[$i][]='<style nf="# ##0.00">'.$ert['szerz_tetel_integ_tobblet'].'</style>';
 $adat[$i][]='<style nf="# ##0.00">'.$ert['szerz_tetel_integ_tobblet_ho'].'</style>';
 
 $adat[$i][]=$ert['szerz_tetel_integ_megj'];
 
 $adat[$i][]=$ert['szerz_tetel_megj'];
 $adat[$i][]=$ert['szerz_tetel_tt_megj'];
 //$adat[$i][]='<a href="'.$ert['szerz_tetel_link'].'">'.$ert['szerz_tetel_link'].'</a>';
 if($ert['szerz_file_szerz_name']!='')
  $adat[$i][]='<a href="'.$GLOBALS['url'].'/?i='.$ert['szerz_id'].'&k='.$ert['szerz_tetel_modszam_kezi'].'&a='.$ert['szerz_tetel_adat_id'].'&t=szerz">'.$ert['szerz_file_szerz_name'].'</a>';//szerz_file_id szerz
 else $adat[$i][]='';
 
 if($ert['szerz_file_ar_name']!='')
  $adat[$i][]='<a href="'.$GLOBALS['url'].'/?i='.$ert['szerz_id'].'&k='.$ert['szerz_tetel_modszam_kezi'].'&a='.$ert['szerz_tetel_adat_id'].'&t=ar">'.$ert['szerz_file_ar_name'].'</a>';//szerz_file_id ar
 else $adat[$i][]='';
 
 //Rögzítő - eleje
 if($ert['szerz_tetel_modszam']=='0'){
  $adat[$i][]=$ert['user_nev'];
  $adat[$i][]=$ert['update_time']; 
 }else{
	$adat[$i][]=''; 
	$adat[$i][]=''; 
 }
 //Rögzítő - vége
 
 //Módosító - eleje
 if($ert['szerz_tetel_modszam']!='0'){
  $adat[$i][]=$ert['user_nev'];
  $adat[$i][]=$ert['update_time'];
 }else{
	$adat[$i][]=''; 
	$adat[$i][]=''; 
 }
 //Módosító - vége
 
//}

 if($ert['szerz_tetel_szolg_kezd_date_folyamatban']=='1'){
  $adat[$i][]='-1';
 }else{
  $adat[$i][]=$ert['szerz_tetel_modszam'];
 }

 $adat[$i][]=$ert['projekt_nevek'];
 $adat[$i][]=$ert['kpi_tipus_str'];

}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Szerződésnyilvántartó élő szerződések excel export '.$date.'.xlsx';
//(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

$xlsx = new Shuchkin\SimpleXLSXGen();
$xlsx->addSheet($adat,'Szerződés nyilvántartó - élő');
unset($adat);

//2. munkalap: KPI típusok
$adat_kpi=array();
$i=0;
$adat_kpi[$i][]="<b>Szolgáltatás csoport</b>";
$adat_kpi[$i][]="<b>KPI</b>";
$adat_kpi[$i][]="<b>KPI típus</b>";
$adat_kpi[$i][]="<b>Mutatószám megnevezése</b>";
$adat_kpi[$i][]="<b>Mutatószám számítás módja</b>";
$adat_kpi[$i][]="<b>Célérték kat. 1</b>";
$adat_kpi[$i][]="<b>Célérték kat. 2</b>";
$adat_kpi[$i][]="<b>Célérték kat. 3</b>";
$adat_kpi[$i][]="<b>Célérték kat. 4</b>";
$adat_kpi[$i][]="<b>Szakció mértéke</b>";

$tomb=keres_admin_kpitipus_szerznyilvhoz();

if(is_array($tomb)){
foreach($tomb as $ert){
 $i++;
 $adat_kpi[$i][]=$ert['szerz_csop_nev_str'];
 $adat_kpi[$i][]=$ert['kpi_tipus_kpi'];
 $adat_kpi[$i][]=$ert['kpi_tipus_tipus'];
 $adat_kpi[$i][]=$ert['kpi_tipus_mutmegn'];
 $adat_kpi[$i][]=$ert['kpi_tipus_mutszmod'];
 $adat_kpi[$i][]=$ert['kpi_tipus_ck_1'];
 $adat_kpi[$i][]=$ert['kpi_tipus_ck_2'];
 $adat_kpi[$i][]=$ert['kpi_tipus_ck_3'];
 $adat_kpi[$i][]=$ert['kpi_tipus_ck_4'];
 $adat_kpi[$i][]=$ert['kpi_tipus_szm'];
}
}

$xlsx->addSheet($adat_kpi,'KPI típusok');
unset($adat_kpi);

$xlsx->downloadAs(rawurlencode($filename));
exit;
}

?>