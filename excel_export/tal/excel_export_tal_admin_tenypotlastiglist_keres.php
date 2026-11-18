<?php

function excel_export_admin_tenypotlastiglist_keres(){
$_POST['admin_tenypotlastiglist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_tenypotlastig_uj();

$i=0;
$adat[$i][]="<b>Szolgáltatás ID</b>";
$adat[$i][]="<b>Év</b>";
$adat[$i][]="<b>hó</b>";
$adat[$i][]="<b>Egyéb naturália</b>";
$adat[$i][]="<b>Társaság</b>";
$adat[$i][]="<b>Szolgáltatás csoport</b>";
$adat[$i][]="<b>Szolgáltatás kód</b>";

foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['szerz_tetel_id'];
 $adat[$i][]=$ert['ev'];
 $adat[$i][]=$ert['ho'];
 $adat[$i][]="\0".$ert['egyebnat'];
}
}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename="Ténybetöltő TIG táblához excel export ".$date.".xlsx";
//SimpleXLSXGen::fromArray( $adat )->downloadAs(rawurlencode($filename));
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));


}

?>