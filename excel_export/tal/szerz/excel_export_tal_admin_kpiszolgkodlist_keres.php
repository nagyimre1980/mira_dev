<?php

function excel_export_admin_kpiszolgkodlist_keres(){
$_POST['admin_kpiszolgkodlist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_kpiszolgkod_uj();

$i=0;
$adat[$i][]="<b>KPI szolgáltatás kód</b>";

if(is_array($tomb)){
foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['kpi_szolg_kod'];
}
}
}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Admin KPI szolgáltatás kód excel export '.$date.'.xlsx';
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

}

?>