<?php

function excel_export_admin_tagvlist_keres(){

$_POST['admin_tagvkodlist_keres_talszam']="999999";//999.999
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

$tomb=keres_admin_tagvkod_uj();

$i=0;
$adat[$i][]="<b>Társasági SAP kód</b>";
$adat[$i][]="<b>Társaság neve</b>";
$adat[$i][]="<b>Inaktív</b>";
$adat[$i][]="<b>Cím</b>";
$adat[$i][]="<b>Adószám</b>";
$adat[$i][]="<b>Tulajdonosi joggyakorló kód</b>";
$adat[$i][]="<b>Tulajdonosi joggyakorló név</b>";
$adat[$i][]="<b>1. számú vezető</b>";
$adat[$i][]="<b>1. számú vezető (Több első számú vezető esetén)</b>";
$adat[$i][]="<b>2. számú vezető/gazdasági vezető</b>";
$adat[$i][]="<b>Kapcsolattartó (gazdasági ügyekben)</b>";

if(is_array($tomb)){
foreach($tomb as $isor => $ert){
if($isor>0){//Első sor a talszám
 $i++;
 
 $adat[$i][]=$ert['tagv_kod'];
 $adat[$i][]=$ert['tagv_kod_nev'];
 $adat[$i][]=igennem_kod_ki($ert['tagv_kod_inaktiv']);
 
 $adat[$i][]=$ert['tagv_kod_cim'];
 $adat[$i][]=$ert['tagv_kod_adoszam'];
 
 $adat[$i][]=$ert['kapcs_tulaj_kod'];
 $adat[$i][]=$ert['kapcs_tulaj_nev'];
 
 $adat[$i][]=$ert['kapcs_torzs_vezeto_1_nev'];
 $adat[$i][]=$ert['kapcs_torzs_vezeto_1_t_nev'];
 $adat[$i][]=$ert['kapcs_torzs_vezeto_2_nev'];
 $adat[$i][]=$ert['kapcs_torzs_kapcst_nev'];
 
}
}
}

$date=date("Y_m_d-H_i_s",time());
$filename="Társasági SAP kód excel export ".$date.".xlsx";
//SimpleXLSXGen::fromArray( $adat )->downloadAs(rawurlencode($filename));

if((isset($GLOBALS['excel_auto_save']))and($GLOBALS['excel_auto_save']=='1')and(isset($GLOBALS['excel_auto_mappa']))){
 (string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->saveAs($GLOBALS['excel_auto_mappa'].$filename);
}else{
(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));
}

}
?>