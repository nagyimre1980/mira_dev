<?php

function excel_export_admin_kpiosszekaplist_keres(){
$_POST['admin_kpiosszekaplist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_kpiosszekap_uj();

$i=0;
$adat[$i][]="<b>Alapadat ID</b>";
$adat[$i][]="<b>Szolágltatás ID</b>";
$adat[$i][]="<b>KPI nem releváns</b>";
$adat[$i][]="<b>KPI típus ellenőrizendő</b>";
$adat[$i][]="<b>KPI típus</b>";
$adat[$i][]="<b>Társaság</b>";
$adat[$i][]="<b>Társasági kategória</b>";

$adat[$i][]="<b>Szerződés típus</b>";
$adat[$i][]="<b>Szerződés hatályba lépésének időpontja</b>";
$adat[$i][]="<b>Szolgáltásnyújtás megkezdésének időpontja</b>";
$adat[$i][]="<b>Szerződés aláírás dátuma</b>";
$adat[$i][]="<b>Szerződésmódosítás hatályba lépésének dátuma</b>";

$adat[$i][]="<b>Szolgáltatás megszünés dátuma</b>";

$adat[$i][]="<b>Szerződés módosítás száma</b>";

$adat[$i][]="<b>Szolgáltatás csoport</b>";
//$adat[$i][]="<b>Szolgáltatás kód</b>";
//$adat[$i][]="<b>Szolgáltatás neve</b>";
$adat[$i][]="<b>KPI Szolgáltatás kód</b>";
$adat[$i][]="<b>Megjegyzés</b>";


if(is_array($tomb)){
foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['szerz_id'];
 $adat[$i][]=$ert['szerz_tetel_id'];
 $adat[$i][]=igennem_kod_ki($ert['kpi_nemrelevans']);
 $adat[$i][]=igennem_kod_ki($ert['kpi_osszekapcs_ck']);
 $adat[$i][]=$ert['kpi_tipus_str'];
 $adat[$i][]=$ert['tagv_kod'];
 $adat[$i][]=kiert_szerz_tagvkat_kat($ert['szerz_tagvkat_kat']);

 $adat[$i][]=$ert['szerz_tipus_nev'];
 $adat[$i][]=kidate_format_ev($ert['szerz_date_hatalybelep']);
 $adat[$i][]=kidate_format_ev($ert['szerz_tetel_szolg_kezd_date_uj']);
 $adat[$i][]=kidate_format_ev($ert['szerz_tetel_alair_date_uj']);
 $adat[$i][]=kidate_format_ev($ert['szerz_tetel_szolg_mod_date_uj']);
 
  // 1. Betesszük a dátumokat egy tömbbe
 $datumok = [
    $ert['szerz_tetel_vege_date_uj'],
    $ert['szerz_tetel_szolg_origveg_date_uj'],
    $ert['szerz_tetel_szolg_aktveg_date_uj']
 ];
 // 2. Kiszűrjük az üres/NULL értékeket
 $szurt_datumok = array_filter($datumok);
 // 3. Ha maradt legalább egy érvényes dátum, kiírjuk a legkisebbet, különben semmit ('')
 $adat[$i][]=$szurt_datumok ? kidate_format_ev(min($szurt_datumok)) : '';
 
 $adat[$i][]=$ert['szerz_tetel_modszam_kezi'];
 $adat[$i][]=$ert['szerz_csop_nev'];
 //$adat[$i][]=$ert['szolg_kod'];
 //$adat[$i][]=$ert['szolg_kod_nev'];
 $adat[$i][]=$ert['kpi_szolg_kod'];
 $adat[$i][]=$ert['kpi_megj'];
}
}
}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Admin KPI típus szerződés összerendelés excel export '.$date.'.xlsx';
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

}

?>