<?php

function excel_export_admin_katnevlist_keres(){
$_POST['admin_katnevlist_keres_talszam']="999999";//999.999
$_POST['oldalholvagyok']=0;

//egyeni_id1
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

$tomb=keres_admin_katnev_uj();

$i=0;
$adat[$i][]="<b>ID</b>";
$adat[$i][]="<b>Önköltség kategória kód</b>";
$adat[$i][]="<b>Önköltség kategória név</b>";
$adat[$i][]="<b>Inaktív</b>";

if(is_array($tomb)){
foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 
 $adat[$i][]=$ert['projekt_kat_id'];
 $adat[$i][]=$ert['projekt_kat_nev'];
 $adat[$i][]=$ert['projekt_kat_nev_h'];
 $adat[$i][]=igennem_kod_ki($ert['projekt_kat_inaktiv']);
 
}
}
}

$date=date("Y_m_d-H_i_s",time());
$filename="Önköltség kategória excel export ".$date.".xlsx";
//SimpleXLSXGen::fromArray( $adat )->downloadAs(rawurlencode($filename));
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

}

?>