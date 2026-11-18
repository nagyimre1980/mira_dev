<?php

function excel_export_admin_elsztipuslist_keres(){
$_POST['admin_elsztipuslist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_elsztipus_uj();

$i=0;
$adat[$i][]="<b>ID</b>";
$adat[$i][]="<b>Elszámolás típus</b>";

foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['szerz_elsz_tipus_id'];
 $adat[$i][]=$ert['szerz_elsz_tipus_nev'];
}
}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Admin elszámolás típusok excel export '.$date.'.xlsx';
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

}

?>