<?php

function keres_riport_tig_tabla(){
$eredmeny_keres='';

$sql="SELECT
    szerz_tetel_adat.szerz_tetel_id
    ,szerz_tetel_adat.szerz_tetel_adat_id
	,szerz_tetel_adat.szerz_tetel_szolg_mod_date as ab
	,szerz_tetel_adat.szerz_tetel_szolg_modveg_date as ac
	,szerz_tetel.szerz_tetel_vege_date as ad
	,szerz_tetel.szerz_tetel_szolg_origveg_date as ae
	,szerz_tetel.szerz_tetel_szolg_kezd_date as u
    ,szerz_tetel_adat.szerz_tetel_modszam_kezi
    ,szerz_tetel_adat.szerz_tetel_oradij
    ,szerz_tetel_adat.szerz_tetel_netto_szerzdij
    ,szerz_tetel_adat.szerz_elsz_tipus_id
    ,szerz_tetel_adat.szerz_tetel_netto_havidij_penznem
	,mira_tagv_kod.tagv_kod
	,mira_tagv_kod.tagv_kod_nev
	,mira_tagv_kod.tagv_kod_vevoazon
	,szerz_tipus.szerz_tipus_nev
	
	,mira_szolg_kod.szolg_kod_nev
	
	,szerz_elsz_tipus.szerz_elsz_tipus_nev
	
	,(
        SELECT GROUP_CONCAT(projekt_id SEPARATOR ',')
        FROM szerz_tetel_adat_projekt
        WHERE szerz_tetel_adat_projekt.szerz_tetel_adat_id = szerz_tetel_adat.szerz_tetel_adat_id
    ) AS projekt_id_tomeges
	
FROM szerz_tetel_adat
INNER JOIN (
    SELECT
        szerz_tetel_id,
        szerz_tetel_modszam_kezi,
        MAX(szerz_tetel_adat_id) AS max_id
    FROM szerz_tetel_adat ";
    //$sql.="WHERE szerz_tetel_id = 118";
    $sql.="GROUP BY szerz_tetel_id, szerz_tetel_modszam_kezi
) latest
    ON szerz_tetel_adat.szerz_tetel_adat_id = latest.max_id
inner join szerz_tetel ON szerz_tetel.szerz_tetel_id = latest.szerz_tetel_id
left join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id
left join mira_tagv_kod ON mira_tagv_kod.tagv_kod = szerz.tagv_kod
left join szerz_tipus ON szerz_tipus.szerz_tipus_id = szerz.szerz_tipus_id

left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = szerz_tetel_adat.szolg_kod

left join szerz_elsz_tipus ON szerz_elsz_tipus.szerz_elsz_tipus_id = szerz_tetel_adat.szerz_elsz_tipus_id
";
//,szerz_csop.szerz_csop_nev
//left join szerz_csop ON szerz_csop.szerz_csop_id = szerz_tetel_adat.szerz_csop_id
//ORDER BY a.szerz_tetel_modszam_kezi;
 //echo $sql."<br>";exit;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szerz_tetel_id']][$adatom['szerz_tetel_modszam_kezi']]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_riport_tig_tabla_nemszerz_alapjan($ev,$ho){
$eredmeny_keres='';
$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
$ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);
if($ho<10)$ho='0'.$ho;

$sql="SELECT 
szerz_tig_nemszerz_id as id
,DATE_FORMAT(szerz_tig_nemszerz_evho, '%Y') AS ev
,DATE_FORMAT(szerz_tig_nemszerz_evho, '%c') AS ho
,szerz_tig_nemszerz.szerz_tig_nemszerz_tagv_kod as tagv_kod
,mira_tagv_kod.tagv_kod_nev
,mira_tagv_kod.tagv_kod_vevoazon
,szerz_tipus.szerz_tipus_nev
,mira_szolg_kod.szolg_kod_nev
,szerz_tig_nemszerz.szerz_tig_nemszerz_szerzodes
,szerz_elsz_tipus.szerz_elsz_tipus_nev
,szerz_tig_nemszerz.szerz_tig_nemszerz_szerzosszeg
,szerz_tig_nemszerz.szerz_tig_nemszerz_haviosszeg
,szerz_tig_nemszerz.szerz_tig_nemszerz_haviosszeg_mod1
,szerz_tig_nemszerz.szerz_tig_nemszerz_haviosszeg_mod2
,szerz_tig_nemszerz.szerz_tig_nemszerz_penznem
,szerz_tig_nemszerz.szerz_tig_nemszerz_co
FROM `szerz_tig_nemszerz` 
left join mira_tagv_kod ON mira_tagv_kod.tagv_kod = szerz_tig_nemszerz.szerz_tig_nemszerz_tagv_kod
left join szerz_tipus ON szerz_tipus.szerz_tipus_id = szerz_tig_nemszerz.szerz_tig_nemszerz_szerz_tipus_id
left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = szerz_tig_nemszerz.szerz_tig_nemszerz_szolg_kod
left join szerz_elsz_tipus ON szerz_elsz_tipus.szerz_elsz_tipus_id = szerz_tig_nemszerz.szerz_tig_nemszerz_elsz_tipus_id

where szerz_tig_nemszerz.szerz_tig_nemszerz_evho BETWEEN '".$ev."-01-01' and '".$ev."-".$ho."-01' 
order by szerz_tig_nemszerz_evho asc, szerz_tig_nemszerz_tagv_kod asc, szerz_tig_nemszerz_evho asc
";
 
 //echo $sql."<br>";exit;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_riport_tig_tabla_nemszerz_alapjan_arfolyam($ev,$ho){
$eredmeny_keres='';
$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
$ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);
if($ho<10)$ho='0'.$ho;

//szerz_penznem_arfolyam.penznem = 'HUF' and
$sql="SELECT 
szerz_penznem_arfolyam.arfolyam_ert
,szerz_penznem_arfolyam.penznem
,DATE_FORMAT(szerz_penznem_arfolyam.arfolyam_date, '%Y%c') AS evho
FROM `szerz_penznem_arfolyam`
where 

szerz_penznem_arfolyam.arfolyam_date  BETWEEN '".$ev."-01-01' and '".$ev."-".$ho."-01' ";

 //echo $sql."<br>";exit;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['penznem']][$adatom['evho']]=$adatom['arfolyam_ert'];
 }
 return $eredmeny_keres;
}

function keres_riport_tig_tabla_proj33($ev,$ho_ig){
$eredmeny_keres='';
$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
$ho_ig=mysqli_real_escape_string($GLOBALS['mysqli'],$ho_ig);

// Tábla létezésének ellenőrzése
    $tabla_nev = "backup_adat_" . $ev . "_teny_3_3";
    $ellenorzo_sql = "SHOW TABLES LIKE '" . $tabla_nev . "'";
    $ellenorzo_eredmeny = mysqli_query($GLOBALS['mysqli'], $ellenorzo_sql);

    if (!$ellenorzo_eredmeny || mysqli_num_rows($ellenorzo_eredmeny) === 0) {
        return '';
    }

$sql="SELECT 
backup_pojekt.projekt_id
,backup_adat_".$ev."_teny_3_3.rogzitett_teny3_ora_egesz
FROM `backup_adat_".$ev."_teny_3_3`
inner join backup_pojekt ON backup_pojekt.backup_pojekt_id = backup_adat_".$ev."_teny_3_3.backup_pojekt_id 
inner join backup_ver ON backup_ver.backup_ver_id = backup_pojekt.backup_ver_id
where
backup_ver.backup_ver_ev='".$ev."' and 
backup_ver.backup_ver_ho <= '".$ho_ig."' and 
backup_ver.backup_ver_default = '1'
";

//if($ho<10)$ho='0'.$ho;
 //echo $sql."<br>";exit;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['projekt_id']]=$adatom['rogzitett_teny3_ora_egesz'];
 }
 return $eredmeny_keres;
}

function keres_riport_tig_tabla_egyebnat($ev,$ho_ig){
$eredmeny_keres='';
$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
$ho_ig=mysqli_real_escape_string($GLOBALS['mysqli'],$ho_ig);

$sql="SELECT szerz_tenybe_egyebnat.szerz_tetel_id
,DATE_FORMAT(szerz_tenybe_egyebnat.tenybe_egyebnat_evho,'%c') AS ho
,szerz_tenybe_egyebnat.egyebnat
FROM `szerz_tenybe_egyebnat`
where
szerz_tenybe_egyebnat.tenybe_egyebnat_evho BETWEEN '".$ev."01-01' AND '".$ev."-".$ho_ig."-01'";

 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szerz_tetel_id']][$adatom['ho']]=$adatom['egyebnat'];
 }
 return $eredmeny_keres;
}
?>