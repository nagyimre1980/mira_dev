<?php

function excel_export_admin_arazasreflist_keres(){
$_POST['admin_arazasreflist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_arazasref_uj();

$i=0;
$adat[$i][]="<b>ID</b>";
$adat[$i][]="<b>Tevékenység neve</b>";
$adat[$i][]="<b>Árazási szempontból releváns</b>";
$adat[$i][]="<b>Inaktív</b>";

foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['projekt_id'];
 $adat[$i][]=$ert['projekt_nev'];
 $adat[$i][]=igennem_kod_ki_0nalis($ert['projekt_arazasref']);
 $adat[$i][]=igennem_kod_ki($ert['projekt_inaktiv']);
 
}
}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Admin árazási szempontból releváns excel export '.$date.'.xlsx';
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

}
?>