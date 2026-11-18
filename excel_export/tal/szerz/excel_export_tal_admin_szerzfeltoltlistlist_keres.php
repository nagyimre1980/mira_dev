<?php

function excel_export_admin_szerzfeltoltlistlist_keres(){
$_POST['admin_szerzfeltoltlist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_szerzfeltolt_uj();

$i=0;
$adat[$i][]="<b>ID</b>";
$adat[$i][]="<b>Társaság</b>";
$adat[$i][]="<b>Szerződés módosítás szám</b>";
$adat[$i][]="<b>Szerződés típus</b>";
$adat[$i][]="<b>Megjegyzés</b>";
$adat[$i][]="<b>Szerződés</b>";
$adat[$i][]="<b>Árajánlat</b>";

if(is_array($tomb)){
foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['szerz_id'];
 $adat[$i][]=$ert['tagv_kod'];
 $adat[$i][]=$ert['szerz_tetel_modszam_kezi'];
 $adat[$i][]=$ert['szerz_tipus_nev'];
 $adat[$i][]=$ert['szerz_megj'];
 $adat[$i][]=$ert['szerz_file_szerz_name'];
 $adat[$i][]=$ert['szerz_file_ar_name'];
 
}
}
}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Admin szerződés feltöltése adatok excel export '.$date.'.xlsx';
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

}
?>