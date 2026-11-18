<?php

function excel_export_admin_szolgkapadatlist_keres(){
$_POST['admin_szolgkapadatlist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_szolgkapadat_uj();

$i=0;
$adat[$i][]="<b>Alapadat ID</b>";
$adat[$i][]="<b>Szolgáltatás ID </b>";
$adat[$i][]="<b>Módosítás DB ID</b>";
$adat[$i][]="<b>Társaság</b>";
$adat[$i][]="<b>Keretszerződés</b>";
$adat[$i][]="<b>Szerződés típus</b>";
$adat[$i][]="<b>Szerződés hatályba lépésének időpontja</b>";
$adat[$i][]="<b>SAP szerződésszám</b>";
$adat[$i][]="<b>CO</b>";
$adat[$i][]="<b>Módosítás ID</b>";
$adat[$i][]="<b>Aktuális Módosítás ID</b>";
$adat[$i][]="<b>Szerződés módosítás száma</b>";
$adat[$i][]="<b>Folyamatban</b>";
$adat[$i][]="<b>Szolgáltatás csoport</b>";
$adat[$i][]="<b>Szolgáltatás kód</b>";
$adat[$i][]="<b>Utókalkuláció</b>";
$adat[$i][]="<b>Nettó szerződés díj (eseti/maximális keret)</b>";

$adat[$i][]="<b>Szolgáltásnyújtás megkezdésének időpontja</b>";
$adat[$i][]="<b>Árajánlat aláírás dátuma</b>";
$adat[$i][]="<b>Szerződés aláírás dátuma</b>";

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
$adat[$i][]="<b>Általános megjegyzés";
$adat[$i][]="<b>TT megjegyzés";

//$adat[$i][]="<b>Szerződés elérése a hálózaton";
$adat[$i][]="<b>Szerződés";
$adat[$i][]="<b>Árajánlat";

$adat[$i][]="<b>Rögzítő";
$adat[$i][]="<b>Rögzítés ideje";
$adat[$i][]="<b>Módosító";
$adat[$i][]="<b>Módosítás ideje";
$adat[$i][]="<b>Tevékenység";

foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['szerz_id'];
 $adat[$i][]=$ert['szerz_tetel_id'];
 $adat[$i][]=$ert['szerz_tetel_adat_id'];
 $adat[$i][]=$ert['tagv_kod'];
 $adat[$i][]=igennem_kod_ki_0nalis($ert['szerz_keret']);
 $adat[$i][]=$ert['szerz_tipus_nev'];
 $adat[$i][]=$ert['szerz_date_hatalybelep'];
 $adat[$i][]=$ert['szerz_sapszam'];
 $adat[$i][]=$ert['szerz_tetel_co'];
 
 if($ert['szerz_tetel_szolg_kezd_date_folyamatban']=='1'){
  $adat[$i][]='-1';
 }else{
  $adat[$i][]=$ert['szerz_tetel_modszam'];
 }

 if(($ert['szerz_tetel_akt']=='1')and($ert['szerz_tetel_szolg_kezd_date_folyamatban']=='0')and($ert['szerz_tetel_akt_folyamatban']=='0')){
  //$adat[$i][]='Aktuális';
  $adat[$i][]='Igen';
 }else $adat[$i][]='';
 
 //Szerződés módosítás száma
 $adat[$i][]=$ert['szerz_tetel_modszam_kezi'];
 
 //Folyamatban
 if(($ert['szerz_tetel_szolg_kezd_date_folyamatban']=='1')or($ert['szerz_tetel_akt_folyamatban']=='1')){
  $adat[$i][]='Igen';
 }else{
  $adat[$i][]='';
 }
 
 $adat[$i][]=$ert['szerz_csop_nev'];
 $adat[$i][]=$ert['szolg_kod'];
 $adat[$i][]=igennem_kod_ki_0nalis($ert['szerz_tetel_utok']);
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
 
 //Szerződés időtartam eredeti (határozott esetén)
 $adat[$i][]=$ert['szerz_tetel_szolg_origveg_date'];

 //Szerződés időtartam aktuális (határozott esetén)
 $adat[$i][]=$ert['szerz_tetel_szolg_aktveg_date'];

 $adat[$i][]=$ert['szerz_tetel_netto_evesdij'];
 $adat[$i][]=$ert['szerz_naturalia_nev'];
 
 //$ert['szerz_tetel_naturalia_darab']++;
 //$ert['szerz_tetel_naturalia_darab']--;
 $adat[$i][]=kiosszeg_format_eur($ert['szerz_tetel_naturalia_darab']);
 
 if($ert['szerz_usergazda_inaktiv']=='1')$ert['szerz_usergazda_nev'].=' - Inaktív';
 $adat[$i][]=$ert['szerz_usergazda_nev'];
 
 $adat[$i][]=igennem_kod_ki_0nalis($ert['szerz_tetel_integ_erintett']);
 $adat[$i][]=$ert['szerz_tetel_megj'];
 $adat[$i][]=$ert['szerz_tetel_tt_megj'];
 
 //$adat[$i][]=$ert['szerz_tetel_link'];
 if($ert['szerz_file_szerz_name']!='')
  $adat[$i][]='<a href="'.$GLOBALS['url'].'/?i='.$ert['szerz_id'].'&k='.$ert['szerz_tetel_modszam_kezi'].'&t=szerz">'.$ert['szerz_file_szerz_name'].'</a>';//szerz_file_id szerz
 else $adat[$i][]='';
 
 if($ert['szerz_file_ar_name']!='')
  $adat[$i][]='<a href="'.$GLOBALS['url'].'/?i='.$ert['szerz_id'].'&k='.$ert['szerz_tetel_modszam_kezi'].'&t=ar">'.$ert['szerz_file_ar_name'].'</a>';//szerz_file_id ar
 else $adat[$i][]='';

 //Rögzítő - eleje
 if($ert['szerz_tetel_modszam']=='0'){
  $adat[$i][]=$ert['user_nev'];
  if($ert['update_time']!='0000-00-00 00:00:00')
   $adat[$i][]=$ert['update_time'];
  else $adat[$i][]='';
 }else{
	$adat[$i][]='';
	$adat[$i][]=''; 
 }
 //Rögzítő - vége
 
 //Módosító - eleje
 if($ert['szerz_tetel_modszam']!='0'){
  $adat[$i][]=$ert['user_nev'];
  if($ert['update_time']!='0000-00-00 00:00:00')
   $adat[$i][]=$ert['update_time'];
  else $adat[$i][]='';
 }else{
	$adat[$i][]=''; 
	$adat[$i][]=''; 
 }
 //Módosító - vége
 
 $adat[$i][]=$ert['projekt_nevek'];
 
}
}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Admin szolgáltatáshoz kapcsolódó adatok excel export '.$date.'.xlsx';
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));


}
?>