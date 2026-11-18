<?php

function excel_export_admin_tigadatvevoazonlist_keres(){
$_POST['admin_tigadatvevoazonlist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_tigadatvevoazon_uj();

$i=0;
$adat[$i][]="<b>SAP kód</b>";
$adat[$i][]="<b>Társaság neve</b>";
$adat[$i][]="<b>Vevő azonosító</b>";

foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['tagv_kod'];
 $adat[$i][]=$ert['tagv_kod_nev'];
 $adat[$i][]=$ert['tagv_kod_vevoazon'];
}
}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Admin vevő azonosító excel export '.$date.'.xlsx';
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

}

?>