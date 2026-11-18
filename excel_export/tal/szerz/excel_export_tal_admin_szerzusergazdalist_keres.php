<?php

function excel_export_admin_szerzusergazdalist_keres(){
$_POST['admin_szerzusergazdalist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb=keres_admin_szerzusergazda_uj();

$i=0;
$adat[$i][]="<b>AD azonosító</b>";
$adat[$i][]="<b>Név</b>";
$adat[$i][]="<b>Email</b>";
$adat[$i][]="<b>Törzsszám</b>";
$adat[$i][]="<b>Inaktív</b>";

foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['szerz_usergazda_ad'];
 $adat[$i][]=$ert['szerz_usergazda_nev'];
 $adat[$i][]=$ert['szerz_usergazda_email'];
 $adat[$i][]=$ert['szerz_usergazda_tsz'];
 $adat[$i][]=igennem_kod_ki_0nalis($ert['szerz_usergazda_inaktiv']);
}
}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Admin szerződésgazda excel export '.$date.'.xlsx';
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

}

?>