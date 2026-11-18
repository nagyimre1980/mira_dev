<?php

function excel_export_admin_kpitipuslist_keres(){
$_POST['admin_kpitipuslist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_kpitipus_uj();

$i=0;
$adat[$i][]="<b>ID</b>";
$adat[$i][]="<b>KPI</b>";
$adat[$i][]="<b>KPI típus</b>";
$adat[$i][]="<b>Mutatószám megnevezése</b>";
$adat[$i][]="<b>Mutatószám számítás módja</b>";
$adat[$i][]="<b>Célérték kat. 1</b>";
$adat[$i][]="<b>Célérték kat. 2</b>";
$adat[$i][]="<b>Célérték kat. 3</b>";
$adat[$i][]="<b>Célérték kat. 4</b>";
$adat[$i][]="<b>Szakció mértéke</b>";

if(is_array($tomb)){
foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['kpi_tipus_id'];
 $adat[$i][]=$ert['kpi_tipus_kpi'];
 $adat[$i][]=$ert['kpi_tipus_tipus'];
 $adat[$i][]=$ert['kpi_tipus_mutmegn'];
 $adat[$i][]=$ert['kpi_tipus_mutszmod'];
 $adat[$i][]=$ert['kpi_tipus_ck_1'];
 $adat[$i][]=$ert['kpi_tipus_ck_2'];
 $adat[$i][]=$ert['kpi_tipus_ck_3'];
 $adat[$i][]=$ert['kpi_tipus_ck_4'];
 $adat[$i][]=$ert['kpi_tipus_szm'];
}
}
}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Admin KPI típusok excel export '.$date.'.xlsx';
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

}

?>