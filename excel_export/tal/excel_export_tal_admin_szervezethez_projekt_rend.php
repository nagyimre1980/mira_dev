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

if(!isset($_POST['projekt_nev']))$_POST['projekt_nev']="";

//$tomb_proj=keres_mit2_order("projekt","projekt_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"projekt_inaktiv","0","projekt_nev","asc");
$tomb_proj=keres_mit1_order("projekt","projekt_inaktiv","0","projekt_nev","asc");
$tomb_projekt_van=keres_projekt_hozzarend_adat($_POST['szerv_id']);
$tomb_pro_lat=keres_proj_akt_nevlike($_POST['projekt_nev']);
excel_export_szervezethez_projekt_rend_katt_list_ki($tomb_proj,$tomb_projekt_van,$tomb_pro_lat);


}

function excel_export_szervezethez_projekt_rend_katt_list_ki($tomb_proj,$tomb_projekt_van,$tomb_pro_lat){

$i=0;
$adat[$i][]="<b>ID</b>";
$adat[$i][]="<b>Tevékenység név</b>";
$adat[$i][]="<b>Hozzárendelés</b>";	

if(is_array($tomb_proj)){

foreach($tomb_proj as $isor => $ert){


if(isset($tomb_projekt_van[$ert['projekt_id']])){
 $ck="Igen";
}else{
 $ck="";
}

if(
(
((is_array($tomb_pro_lat))and(isset($tomb_pro_lat[$ert['projekt_id']])))
or
(
((!is_array($tomb_pro_lat))and($tomb_pro_lat=="all"))
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

){

 $i++;


$adat[$i][]=$ert['projekt_id'];
$adat[$i][]=$ert['projekt_nev'];
$adat[$i][]=$ck;

}


}
	
}

//print_r($adat);exit;
$date=date("Y_m_d-H_i_s",time());
$filename="Szervezethez rendelt tevékenységek excel export ".$date.".xlsx";
//SimpleXLSXGen::fromArray( $adat )->downloadAs(rawurlencode($filename));
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));


}
?>