<?php

function excel_export_admin_szervezetben_user_rend_keres(){

$_POST['szerv_id']=$_POST['egyeni_id1'];

$tomb_user_van=keres_user_hozzarend_adat($_POST['szerv_id']);

$i=0;
$adat[$i][]="<b>AD</b>";
$adat[$i][]="<b>Törzsszám</b>";
$adat[$i][]="<b>Név</b>";
$adat[$i][]="<b>Email cím</b>";

if(is_array($tomb_user_van)){
foreach($tomb_user_van as $i => $ert){
$i++;

$adat[$i][]=$ert['user_ad'];
$adat[$i][]=$ert['user_tsz'];
$adat[$i][]=$ert['user_nev'];
$adat[$i][]=$ert['user_email'];

}
}

//print_r($adat);exit;
$date=date("Y_m_d-H_i_s",time());
$filename="Tevékenységhez rendelt felhasználók excel export ".$date.".xlsx";
//SimpleXLSXGen::fromArray( $adat )->downloadAs(rawurlencode($filename));
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

}

?>