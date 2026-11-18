<?php
function excel_export_szerv_projekt($ev,$ho){

$tomb=keress_stat_rogzitett($ev,$ho,"szerv_projekt","1");
mysqli_close($GLOBALS['mysqli']);
if(is_array($tomb))
 ksort($tomb['sor_projekt_nev']);
/*if((isset($tomb['sor_projekt_nev']))and(is_array($tomb['sor_projekt_nev']))){
 asort($tomb['sor_projekt_nev']);
}*/

$i=0;
$adat[$i][]="<b>Szervezet neve</b>";
$adat[$i][]="<b>Statisztika költséghely</b>";
$adat[$i][]="<b>AD költséghely</b>";
$adat[$i][]="<b>Összesen óra</b>";
$adat[$i][]="<b>Összesen óra:perc</b>";

$van_projekt=0;
if((isset($tomb['sor_projekt_nev']))and(is_array($tomb['sor_projekt_nev']))){
foreach($tomb['sor_projekt_nev'] as $projekt_nev => $projekt_id){
if($projekt_nev!=""){
 $van_projekt=1;
 $adat[$i][]="<b>".$projekt_nev."</b>";
}
}
}


if((isset($tomb['sor_szerv_nev']))and(is_array($tomb['sor_szerv_nev']))){
//foreach($tomb['sor_szerv_nev'] as $szerv_nev => $szerv_id){
foreach($tomb['sor_szerv_nev'] as $szerv_id =>  $szerv_ert){
$i++;

$adat[$i][]=$szerv_ert['szerv_nev'];
$adat[$i][]=$szerv_ert['szerv_koltsegkod'];
$adat[$i][]=$szerv_ert['szerv_adkod'];

//Összesen - eleje
$all_ora=0;
$all_perc=0;
 foreach($tomb['sor_projekt_nev'] as $projekt_id){
  if(isset($tomb['sor'][$szerv_id][$projekt_id])){
   $tomb_orall=ora_perc_osszead($tomb['sor'][$szerv_id][$projekt_id]['rogzit_ora'],$tomb['sor'][$szerv_id][$projekt_id]['rogzit_perc']);	 
   $all_ora+=$tomb_orall['rogzit_ora'];
   $all_perc+=$tomb_orall['rogzit_perc'];
  }
 }
 $tomb_orall_kesz=ora_perc_osszead($all_ora,$all_perc);
 if($tomb_orall_kesz['rogzit_perc']<10)$tomb_orall_kesz['rogzit_perc']="0".$tomb_orall_kesz['rogzit_perc'];
 
 //Összesen törtve
 $egeszzam_ora=$tomb_orall_kesz['rogzit_ora'];
 $egeszzam_ora+=$tomb_orall_kesz['rogzit_perc']/60;
 $all_tortora=round($egeszzam_ora,2);
 $adat[$i][]=$all_tortora;
 
 $adat[$i][]=$tomb_orall_kesz['rogzit_ora'].":".$tomb_orall_kesz['rogzit_perc'];
//Összesen - vége

if($van_projekt==1){
foreach($tomb['sor_projekt_nev'] as $projekt_id){

 if(
 (isset($tomb['sor'][$szerv_id][$projekt_id]))
 and
 ($tomb['sor'][$szerv_id][$projekt_id]['rogzit_ora']!="")
 /*
 (
 ($tomb['sor'][$szerv_id][$projekt_id]['rogzit_ora']!="")
 or
 ($tomb['sor'][$szerv_id][$projekt_id]['rogzit_perc']!="")
 )
 and
 (
 ($tomb['sor'][$szerv_id][$projekt_id]['rogzit_ora']!="0")
 or
 ($tomb['sor'][$szerv_id][$projekt_id]['rogzit_perc']!="00")
 )*/
 ){
  $ki_adat=$tomb['sor'][$szerv_id][$projekt_id]['rogzit_ora'].":".$tomb['sor'][$szerv_id][$projekt_id]['rogzit_perc'];
 }else{
  //$ki_adat="<right>0:00</right>";
  $ki_adat="0:00";
  //$ki_adat=""; 
 }
 $adat[$i][]=$ki_adat;
 
}
}

}
}

unset($tomb);
$date=date("Y_m_d-H_i_s",time());
$filename=$GLOBALS['rend_nev']." statisztika szervezet-tevékenység napi összesítése ".$date.".xlsx";
Shuchkin\SimpleXLSXGen::fromArray($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));
//(string)(new SimpleXLSXGen)->addSheet($adat,'MIRA export')->downloadAs(rawurlencode($filename));
}
?>