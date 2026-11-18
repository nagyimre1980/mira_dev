<?php

function excel_export_admin_tenypotlaslist_keres(){
$_POST['userlist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

//egyeni_id1
/*
if(
(isset($_POST['egyeni_id1']))and
($_POST['egyeni_id1']!="")
){
 //$tomb_p=explode("&",urldecode($_POST['egyeni_id1']));
 $tomb_p=explode("&",$_POST['egyeni_id1']);
 if(is_array($tomb_p)){
 foreach($tomb_p as $ert){
  $tomb_pegy=explode("=",$ert);
  if(
  (isset($tomb_pegy[0]))and(isset($tomb_pegy[1]))and($tomb_pegy[0]!="")and($tomb_pegy[1]!="")
  ){
	  //$_POST[$tomb_pegy[0]]=$tomb_pegy[1];
	  //$_POST[$tomb_pegy[0]]=urldecode($tomb_pegy[1]);
	  $_POST[urldecode($tomb_pegy[0])]=urldecode($tomb_pegy[1]);
	  
  }
 }
 }
}
*/

$tomb=keres_admin_tenypotlas_uj();

$i=0;
$adat[$i][]="<b>Tagv</b>";
$adat[$i][]="<b>Szolgkod</b>";
$adat[$i][]="<b>Év</b>";
$adat[$i][]="<b>Hó</b>";
$adat[$i][]="<b>Érték</b>";

foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 $adat[$i][]=$ert['backup_tenypotlas_tagv'];
 $adat[$i][]=$ert['backup_tenypotlas_szolg_kod'];
 $adat[$i][]=$ert['backup_tenypotlas_ev'];
 $adat[$i][]=$ert['backup_tenypotlas_ho'];
 $adat[$i][]=$ert['backup_tenypotlas_osszeg'];
}
}

unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename="Ténybetöltés excel export ".$date.".xlsx";
//SimpleXLSXGen::fromArray( $adat )->downloadAs(rawurlencode($filename));
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));


}

?>