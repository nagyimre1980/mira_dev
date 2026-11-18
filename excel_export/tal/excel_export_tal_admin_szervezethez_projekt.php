<?php

function excel_export_admin_szervezethez_projekt_rend_keres(){

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

if(!isset($_POST['szerv_nev']))$_POST['szerv_nev']="";

//$tomb_szerv=keres_mit2_order("mira_szerv","szerv_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"szerv_inaktiv","0","szerv_nev","asc");
$tomb_szerv=keres_mit1_order("mira_szerv","szerv_inaktiv","0","szerv_nev","asc");
$tomb_szerv_van=keres_projekt_szerv_hozzarend_adat($_POST['projekt_id']);
$tomb_szerv_katkivetel=keres_projekt_szerv_katkivetel_hozzarend_adat($_POST['projekt_id']);
$tomb_szerv_lat=keres_szerv_akt_nevlike($_POST['szerv_nev']);
excel_export_szervezethez_projekt_katt_list_ki($tomb_szerv,$tomb_szerv_van,$tomb_szerv_lat,$tomb_szerv_katkivetel);

}

function excel_export_szervezethez_projekt_katt_list_ki($tomb_szerv,$tomb_szerv_van,$tomb_szerv_lat,$tomb_szerv_katkivetel){

$i=0;
$adat[$i][]="<b>IT</b>";
$adat[$i][]="<b>Szervezet név</b>";
$adat[$i][]="<b>AD költséghely</b>";
$adat[$i][]="<b>Hozzárendelés</b>";
$adat[$i][]="<b>Önköltség kategória kivételek</b>";

if(is_array($tomb_szerv)){

foreach($tomb_szerv as $isor => $ert){

if(isset($tomb_szerv_van[$ert['szerv_id']])){
 $ck="Igen";
}else{
 $ck="";
}

if(
(
((is_array($tomb_szerv_lat))and(isset($tomb_szerv_lat[$ert['szerv_id']])))
or
(
((!is_array($tomb_szerv_lat))and($tomb_szerv_lat=="all"))
)
)

and
(
($_POST['csakvan']=="0")
or
(
($_POST['csakvan']=="1")and($ck!="")
)
)

and
(
($_POST['katkivetel_csakvan']=="0")
or
(
($_POST['katkivetel_csakvan']=="1")and(isset($tomb_szerv_katkivetel[$ert['szerv_id']]))
)
)


){

 $i++;

$adat[$i][]=$ert['szerv_id'];
$adat[$i][]=$ert['szerv_nev'];
$adat[$i][]=$ert['szerv_adkod'];
$adat[$i][]=$ck;

if(isset($tomb_szerv_katkivetel[$ert['szerv_id']]['nev']))
 $adat[$i][]=$tomb_szerv_katkivetel[$ert['szerv_id']]['nev'].' - '.$tomb_szerv_katkivetel[$ert['szerv_id']]['nev_h'];
else
 $adat[$i][]='';

}


}
	
}

//print_r($adat);exit;
$date=date("Y_m_d-H_i_s",time());
$filename="Tevékenységhez rendelt szervezetek excel export ".$date.".xlsx";
//SimpleXLSXGen::fromArray( $adat )->downloadAs(rawurlencode($filename));
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));


}
?>