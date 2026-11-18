<?php

function excel_export_admin_nattipuslist_keres(){
$_POST['admin_nattipuslist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_nattipus_uj();

$i=0;
$adat[$i][]="<b>ID</b>";
$adat[$i][]="<b>Naturália típus</b>";

foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['szerz_naturalia_id'];
 $adat[$i][]=$ert['szerz_naturalia_nev'];
}
}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Admin naturális típusok excel export '.$date.'.xlsx';
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

}
?>