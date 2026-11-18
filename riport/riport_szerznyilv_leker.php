<?php

function riport_szerznyilv(){

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
$adat[$i][]="<b>Szerződés aláírás dátuma</b>";

$adat[$i][]="<b>Nettó szerződéses havidíj</b>";
$adat[$i][]="<b>Devizanem</b>";
$adat[$i][]="<b>Elszámolás típusa</b>";
$adat[$i][]="<b>Óradíj</b>";

$adat[$i][]="<b>Szerződésmódosítás hatályba lépésének dátuma</b>";
$adat[$i][]="<b>Szerződésmódosítás vége (határozott esetén dátum)</b>";
$adat[$i][]="<b>Szolgáltatás megszünése - vége dátum</b>";//AB


$adat[$i][]="<b>Szerződés időtartam eredeti (határozott esetén)</b>";//AC
$adat[$i][]="<b>Szerződés időtartam aktuális (határozott esetén)</b>";//AD

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
$tomb=keres_riport_szerznyilv('teljes',$tomb_szerz_jog);
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
 $adat[$i][]=igennem_kod_ki_0nalis($ert['szerz_keret']);
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

 if(($ert['szerz_tetel_akt']=='1')and($ert['szerz_tetel_szolg_kezd_date_folyamatban']=='0')and($ert['szerz_tetel_akt_folyamatban']=='0')and($ert['szerz_tetel_vege']=='0')){
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

 $adat[$i][]=igennem_kod_ki_0nalis($ert['szerz_tetel_utok']);
 $adat[$i][]=$ert['szerz_tetel_netto_szerzdij'];
 $adat[$i][]=$ert['szerz_tetel_szolg_kezd_date'];//Szolgáltásnyújtás megkezdésének időpontja
 
 $adat[$i][]=$ert['szerz_tetel_arajanlat_alair_date'];//Árajánlat aláírás dátuma
 $adat[$i][]=$ert['szerz_tetel_alair_date'];//Szerződés aláírás dátuma
 
 $adat[$i][]=$ert['szerz_tetel_netto_havidij'];//Nettó szerződéses havidíj
 $adat[$i][]=$ert['szerz_tetel_netto_havidij_penznem'];//Pénznem
 $adat[$i][]=$ert['szerz_elsz_tipus_nev'];//Elszámolás típusa
 
 //Óradíj - Y
 $adat[$i][]=$ert['szerz_tetel_oradij'];//Óradíj
 
 //Szerződésmódosítás hatályba lépésének dátuma Z - eleje
 if($ert['szerz_tetel_szolg_mod_date']!=''){
	$adat[$i][]=$ert['szerz_tetel_szolg_mod_date'];
 }else{$adat[$i][]='';}
 //Szerződésmódosítás hatályba lépésének dátuma Z - vége
 
 //Szerződésmódosítás vége (határozott esetén dátum) AA - eleje
 if($ert['szerz_tetel_szolg_modveg_date']!=''){
	 $adat[$i][]=$ert['szerz_tetel_szolg_modveg_date'];
 }else{$adat[$i][]='';}
 //Szerződésmódosítás vége (határozott esetén dátum) AA - vége
 
 //Szolgáltatás megszünése - vége dátum AB - eleje
 if($ert['szerz_tetel_vege']=='1'){
	$adat[$i][]=$ert['szerz_tetel_vege_date']; 
 }else{$adat[$i][]='';}
 //Szolgáltatás megszünése - vége dátum AB - vége
 
 //Szerződés időtartam eredeti (határozott esetén) - AC
 $adat[$i][]=$ert['szerz_tetel_szolg_origveg_date'];
 
 //Szerződés időtartam aktuális (határozott esetén) - AD
 $adat[$i][]=$ert['szerz_tetel_szolg_aktveg_date'];
 
 $adat[$i][]=$ert['szerz_tetel_netto_evesdij'];
 $adat[$i][]=$ert['szerz_naturalia_nev'];
 
 //$ert['szerz_tetel_naturalia_darab']++;
 //$ert['szerz_tetel_naturalia_darab']--;
 //$adat[$i][]='<style nf="#,##0.00\ [$£-1];[Red]#,##0.00\ [$£-1]">'.kiosszeg_format_huf($ert['szerz_tetel_naturalia_darab']).'</style>';
 $adat[$i][]='<style nf="# ##0.00">'.$ert['szerz_tetel_naturalia_darab'].'</style>';
 
 $adat[$i][]=$ert['szerz_usergazda_nev'];
 
 $adat[$i][]=igennem_kod_ki_0nalis($ert['szerz_tetel_integ_erintett']);
 
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
$filename='Szerződésnyilvántartó teljes excel export '.$date.'.xlsx';

/*
if((isset($GLOBALS['excel_auto_save']))and($GLOBALS['excel_auto_save']=='1')and(isset($GLOBALS['excel_auto_mappa']))){
 (string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->saveAs($GLOBALS['excel_auto_mappa'].$filename);
}else{
 (string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));
}
*/

$xlsx = new Shuchkin\SimpleXLSXGen();
$xlsx->addSheet($adat,'Szerződés nyilvántartó - teljes');
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

//Letöltés
if((isset($GLOBALS['excel_auto_save']))and($GLOBALS['excel_auto_save']=='1')and(isset($GLOBALS['excel_auto_mappa']))){
 $xlsx->saveAs($GLOBALS['excel_auto_mappa'].$filename);
}else{
 $xlsx->downloadAs(rawurlencode($filename));
 exit;
}

}

function keres_riport_szerznyilv_jog(){
$eredmeny_keres="";

 $sql="SELECT
 mira_user.ful_riport_all,
 mira_user_riport_szerz.szerz_csop_id 
 FROM `mira_user` 
 left join mira_user_riport_szerz ON mira_user_riport_szerz.user_ad = mira_user.user_ad
 where
 mira_user.user_ad='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'
 ";
 return mysqli_fetch_all(mysqli_query($GLOBALS['mysqli'],$sql),MYSQLI_ASSOC);
}

function keres_riport_szerznyilv($mod,$tomb_szerz_jog){
$eredmeny_keres="";

$sql_t='';
if(is_array($tomb_szerz_jog)){
 if($tomb_szerz_jog[0]['ful_riport_all']=='0'){//Ekkor nincs teljes joga
 $tomb_user_szerz_csop_all=keres_mit1_mit1_csak_ertek('mira_user','user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad'],'ful_riport_szerz_csop_all');
	 if($tomb_user_szerz_csop_all=='0'){
	 foreach($tomb_szerz_jog as $ert){
		if($ert['szerz_csop_id']!=''){
		 if($sql_t!='')$sql_t.='or';
		 $sql_t.='(szerz_tetel_adat.szerz_csop_id="'.$ert['szerz_csop_id'].'")';
		}
	 }
	 }
 }
}

 $sql="SELECT szerz_tetel.*
 ,szerz_tetel_adat.*
 ,szerz.*
 ,szerz_csop.szerz_csop_nev 
 ,szerz_tipus.szerz_tipus_nev 
 ,mira_tagv_kod.tagv_kod_nev
 ,mira_szolg_kod.szolg_kod_nev
 ,szerz_elsz_tipus.szerz_elsz_tipus_nev
 ,szerz_naturalia.szerz_naturalia_nev
 ,szerz_usergazda.szerz_usergazda_nev
 ,mira_user_mod.user_nev
 ,szerz_tagvkat.szerz_tagvkat_kat
 ,szerz_tagvkat.szerz_tagvkat_date_kezd
 ,szerz_tetel_integ.szerz_tetel_integ_tobblet
 ,szerz_tetel_integ.szerz_tetel_integ_tobblet_ho
 ,szerz_tetel_integ.szerz_tetel_integ_megj
 ,szerz_file.szerz_file_szerz_name
 ,szerz_file.szerz_file_ar_name
 
   /* === ÚJ OSZLOP: projektek nevei vesszővel elválasztva === */
        ,(SELECT GROUP_CONCAT(DISTINCT p.projekt_nev SEPARATOR ', ')
         FROM szerz_tetel_adat_projekt stp 
         JOIN projekt p ON p.projekt_id = stp.projekt_id
         WHERE stp.szerz_tetel_adat_id = szerz_tetel_adat.szerz_tetel_adat_id) AS projekt_nevek

/* === KPI típusok ; jellel elválasztva === */
        ,(SELECT GROUP_CONCAT(
                DISTINCT kpi_tipus.kpi_tipus_kpi
                ORDER BY kpi_tipus.kpi_tipus_kpi ASC
                SEPARATOR '; '
            )
         FROM szerz_kpi
         LEFT JOIN szerz_kpi_osszekapcs
                ON szerz_kpi_osszekapcs.szerz_kpi_id = szerz_kpi.szerz_kpi_id
         LEFT JOIN kpi_tipus
                ON kpi_tipus.kpi_tipus_id = szerz_kpi_osszekapcs.kpi_tipus_id
         WHERE szerz_kpi.szerz_id = szerz_tetel_adat.szerz_id
           AND szerz_kpi.szerz_csop_id = szerz_tetel_adat.szerz_csop_id
           AND szerz_kpi.szerz_tetel_modszam_kezi = szerz_tetel_adat.szerz_tetel_modszam_kezi
        ) AS kpi_tipus_str
		 
 FROM `szerz_tetel` 
 inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_tetel_id = szerz_tetel.szerz_tetel_id
 inner join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id
 left join szerz_csop ON szerz_csop.szerz_csop_id = szerz_tetel_adat.szerz_csop_id
 left join szerz_tipus ON szerz_tipus.szerz_tipus_id = szerz.szerz_tipus_id
 left join mira_tagv_kod ON mira_tagv_kod.tagv_kod = szerz.tagv_kod
 left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = szerz_tetel_adat.szolg_kod
 left join szerz_elsz_tipus ON szerz_elsz_tipus.szerz_elsz_tipus_id = szerz_tetel_adat.szerz_elsz_tipus_id
 left join szerz_naturalia ON szerz_naturalia.szerz_naturalia_id = szerz_tetel_adat.szerz_naturalia_id
 left join szerz_usergazda ON szerz_usergazda.szerz_usergazda_ad = szerz_tetel_adat.szerz_usergazda_ad
 left join mira_user as mira_user_mod ON mira_user_mod.user_ad = szerz_tetel_adat.szerz_tetel_mod_user_ad 
 
 /*
 left join szerz_tagvkat ON szerz_tagvkat.tagv_kod = szerz.tagv_kod and szerz_tagvkat.szerz_tagvkat_akt='1'
 */
 
 left join szerz_tagvkat ON szerz_tagvkat.tagv_kod = szerz.tagv_kod
  AND COALESCE(szerz_tetel_adat.szerz_tetel_szolg_mod_date, szerz_tetel.szerz_tetel_szolg_kezd_date) >= szerz_tagvkat.szerz_tagvkat_date_kezd
  AND (
    szerz_tagvkat.szerz_tagvkat_date_veg IS NULL
    OR COALESCE(szerz_tetel_adat.szerz_tetel_szolg_mod_date, szerz_tetel.szerz_tetel_szolg_kezd_date) <= szerz_tagvkat.szerz_tagvkat_date_veg
  )
 
 left join szerz_tetel_integ ON szerz_tetel_integ.szerz_tetel_adat_id = szerz_tetel_adat.szerz_tetel_adat_id 
 
 left join szerz_file ON szerz_file.szerz_id = szerz.szerz_id 
  and szerz_file.szerz_tetel_modszam_kezi = szerz_tetel_adat.szerz_tetel_modszam_kezi 
  
 ";
 
 if($mod=='elo'){
  $sql.=" where
  szerz_tetel.szerz_tetel_vege='0' and 
  (
   (szerz_tetel.szerz_tetel_szolg_origveg_date is null)
   or
   (szerz_tetel.szerz_tetel_szolg_origveg_date>='".date("Y-m-d",time())."')
  )
  and
  (
   (szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban='1')
   or
   (
    (szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban='0')and
	(szerz_tetel_adat.szerz_tetel_akt='1')and
	(szerz_tetel_adat.szerz_tetel_akt_folyamatban='0')
   )
  )
  ";
  
  if($sql_t!=''){
	  $sql.=' and ('.$sql_t.')';
	 }
	 
 }else{
	 if($sql_t!=''){
	  $sql.=' where ('.$sql_t.')';
	 }
 }
 
 $sql.="order by szerz.tagv_kod asc,szerz_tetel_adat.szerz_tetel_id asc,szerz_tetel_adat.szerz_tetel_modszam asc,szerz_tetel_adat.szerz_tetel_adat_id asc,szerz.szerz_keret asc, szerz.szerz_tipus_id asc, szerz_tetel_adat.szerz_csop_id asc, szerz.szerz_date_hatalybelep asc
 ";
//echo $sql;exit;
 return mysqli_fetch_all(mysqli_query($GLOBALS['mysqli'],$sql),MYSQLI_ASSOC);
}

function keres_admin_kpitipus_szerznyilvhoz(){
$eredmeny_keres="";

 $sql="SELECT kpi_tipus.*,
       (SELECT GROUP_CONCAT(
                DISTINCT szerz_csop.szerz_csop_nev
                ORDER BY szerz_csop.szerz_csop_nev ASC
                SEPARATOR '; '
            )
        FROM szerz_csop
        WHERE kpi_tipus.kpi_szolg_kod IS NOT NULL
          AND kpi_tipus.kpi_szolg_kod <> ''
          AND (
                szerz_csop.kpi_szolg_kod = kpi_tipus.kpi_szolg_kod
             OR szerz_csop.kpi_szolg_kod_kozszolg = kpi_tipus.kpi_szolg_kod
          )
       ) AS szerz_csop_nev_str
 FROM `kpi_tipus` ";

 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}
?>