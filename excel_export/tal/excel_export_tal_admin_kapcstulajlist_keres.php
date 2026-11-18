<?php

function excel_export_admin_kapcstulajlist_keres(){
$_POST['admin_kapcstulajlist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_kapcstulaj_uj();

$i=0;
$adat[$i][]="<b>Kód</b>";
$adat[$i][]="<b>Név</b>";
$adat[$i][]="<b>Inaktív</b>";

if(is_array($tomb)){
foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 
 $adat[$i][]=$ert['kapcs_tulaj_kod'];
 $adat[$i][]=$ert['kapcs_tulaj_nev'];
 $adat[$i][]=igennem_kod_ki($ert['kapcs_tulaj_inaktiv']);

}
}
}

$date=date("Y_m_d-H_i_s",time());
$filename="Tulajdonosi joggyakorló excel export ".$date.".xlsx";
//SimpleXLSXGen::fromArray( $adat )->downloadAs(rawurlencode($filename));
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

}

?>