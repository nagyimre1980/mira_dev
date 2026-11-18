<?php

function excel_export_admin_userhez_stat_projekt_keres(){
$_POST['user_stat_projekthozza_keres_talszam']="999999";//999.999
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

if(!isset($_POST['projekt_nev']))$_POST['projekt_nev']="";

$tomb_user=keres_admin_userhez_stat_projekt($_POST['user_ad'],$_POST['projekt_nev'],$_POST['csakvan']);
$tomb_user_van=keres_user_stat_projekt_user_hozzarend_adat($_POST['user_ad']);

excel_export_userhez_projekt_keres_katt_list_ki($tomb_user,$tomb_user_van);

}

function excel_export_userhez_projekt_keres_katt_list_ki($tomb_user,$tomb_user_van){

$i=0;
//$adat[$i][]="<b>ID</b>";
$adat[$i][]="<b>Tevékenység neve</b>";
$adat[$i][]="<b>Hozzárendelés</b>";

if(is_array($tomb_user)){

foreach($tomb_user as $isor => $ert){

if($isor>0){//Első sor a talszám
 $i++;
 
if(isset($tomb_user_van[$ert['projekt_id']])){
 $ck="Igen";
}else{
 $ck="";
}

//$adat[$i][]=$ert['projekt_id'];
$adat[$i][]=$ert['projekt_nev'];
$adat[$i][]=$ck;

}
}
	
}


//print_r($adat);exit;
$date=date("Y_m_d-H_i_s",time());
$filename="Felhasználóhoz statisztikai projekt jogosultságai excel export ".$date.".xlsx";
//SimpleXLSXGen::fromArray( $adat )->downloadAs(rawurlencode($filename));


//(string)(new SimpleXLSXGen)->addSheet($adat,'MIRA export - Saját tevékenységek')->downloadAs(rawurlencode($filename));
$xlsx = new Shuchkin\SimpleXLSXGen();
$xlsx->addSheet($adat,'Statisztikai projekt jogosultság');


$xlsx->downloadAs(rawurlencode($filename));
exit;
}

?>