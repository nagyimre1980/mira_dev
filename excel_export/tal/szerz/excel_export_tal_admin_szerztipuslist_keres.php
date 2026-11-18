<?php

function excel_export_admin_szerztipuslist_keres(){
$_POST['admin_szerztipuslist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_szerztipus_uj();

$i=0;
$adat[$i][]="<b>ID</b>";
$adat[$i][]="<b>Szerződés típus</b>";
$adat[$i][]="<b>Keretszerződés</b>";
$adat[$i][]="<b>Duplikálható szolgáltatás</b>";

foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['szerz_tipus_id'];
 $adat[$i][]=$ert['szerz_tipus_nev'];
 $adat[$i][]=igennem_kod_ki_0nalis($ert['szerz_tipus_szerz_keret']);
 $adat[$i][]=igennem_kod_ki_0nalis($ert['szerz_tipus_dupla']);
}
}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Admin szerződés típusok excel export '.$date.'.xlsx';
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

}

?>