<?php

function excel_export_admin_ujszolgkapadatprojektlist_keres(){
$_POST['admin_ujszolgkapadatprojektlist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

$tomb_projek_van=array_flip(array_filter(array_map('trim', explode(',',$_POST['projekt_id']))));
$tomb_projek=keres_admin_ujszolgkapadat_projekt('',$_POST['projekt_nev'],$_POST['csakvan'],$tomb_projek_van);

$i=0;
$adat[$i][]="<b>Tevékenység neve</b>";
$adat[$i][]="<b>Hozzárendelés</b>";

if(is_array($tomb_projek)){
foreach($tomb_projek as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['projekt_nev'];
 
 if(isset($tomb_projek_van[$ert['projekt_id']])){
  $adat[$i][]='Igen';
 }
}
}
}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Admin Tevékenységek összes excel export '.$date.'.xlsx';
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));


}

?>