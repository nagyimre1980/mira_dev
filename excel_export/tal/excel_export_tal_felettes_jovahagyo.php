<?php

function excel_export_felettes_jovahagyo(){

$_POST['user_felettesjovahagyo_keres_talszam']="999999";//999.999
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

if(!isset($_POST['keress_nev']))$_POST['keress_nev']="";
$tomb_jovahagyo=keres_fellettesjovahagyo_user($_POST['user_ad'],$_POST['keress_nev'],$_POST['csakvan']);
$tomb_jovahagyo_van=keres_felettesjovahagyo_hozzarend_adat($_POST['user_ad']);
excel_export_felettes_jovahagyo_katt_list_ki($tomb_jovahagyo,$tomb_jovahagyo_van);
}

function excel_export_felettes_jovahagyo_katt_list_ki($tomb_jovahagyo,$tomb_jovahagyo_van){
	
$i=0;
$adat[$i][]="<b>AD</b>";
$adat[$i][]="<b>Név</b>";
$adat[$i][]="<b>Hozzárendelés</b>";

if(is_array($tomb_jovahagyo)){

foreach($tomb_jovahagyo as $isor => $ert){

if($isor>0){//Első sor a talszám
 $i++;
 
if(isset($tomb_jovahagyo_van[$ert['user_ad']])){
 $ck="Igen";
}else{
 $ck="";
}

$adat[$i][]=$ert['user_ad'];
$adat[$i][]=$ert['user_nev'];
$adat[$i][]=$ck;

}
}
	
}

//print_r($adat);exit;
$date=date("Y_m_d-H_i_s",time());
$filename="Felettes jóváhagyó excel export ".$date.".xlsx";
//SimpleXLSXGen::fromArray( $adat )->downloadAs(rawurlencode($filename));
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));


}

?>