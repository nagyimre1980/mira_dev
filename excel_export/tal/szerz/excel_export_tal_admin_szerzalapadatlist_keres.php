<?php

function excel_export_admin_szerzalapadatlist_keres(){
$_POST['admin_szerzalapadatlist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_szerzalapadat_uj();

$i=0;
$adat[$i][]="<b>ID</b>";
$adat[$i][]="<b>Társaság</b>";
$adat[$i][]="<b>Keretszerződés</b>";
$adat[$i][]="<b>Szerződés típus</b>";
$adat[$i][]="<b>Szerződés hatályba lépésének időpontja</b>";
$adat[$i][]="<b>SAP szerződésszám</b>";
$adat[$i][]="<b>Megjegyzés</b>";

foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['szerz_id'];
 $adat[$i][]=$ert['tagv_kod'];
 $adat[$i][]=igennem_kod_ki_0nalis($ert['szerz_keret']);
 $adat[$i][]=$ert['szerz_tipus_nev'];
 $adat[$i][]=$ert['szerz_date_hatalybelep'];
 $adat[$i][]=$ert['szerz_sapszam'];
 $adat[$i][]=$ert['szerz_megj'];
}
}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Admin szerződés alapadatok excel export '.$date.'.xlsx';
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));


}
