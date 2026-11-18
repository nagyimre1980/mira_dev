<?php

function html_tal_szerv_projekt($ev,$ho){

$tomb=keress_stat_rogzitett($ev,$ho,"szerv_projekt","0");
mysqli_close($GLOBALS['mysqli']);
if(is_array($tomb))
 ksort($tomb['sor_projekt_nev']);

/*if((isset($tomb['sor_projekt_nev']))and(is_array($tomb['sor_projekt_nev']))){
 asort($tomb['sor_projekt_nev']);
}*/

/*echo "<pre>";
print_r($tomb);
echo "</pre>";*/

$i=0;
echo '<table cellpadding=1 cellspacing=1 style="margin-top:10px" id="stat_ered_table" class="table_emre">';
echo '<thead>';
echo '<tr onclick="stat_tablesort_katt(event.target)">';
echo "<th id='stat_ered_table_first_th' style='text-decoration:underline'>Szervezet neve";//2
echo '<th title="Összesen óra egészszám formában">Σ órában';//2
echo '<th title="Összesen óra:perc">Σ óra:perc';//3

$van_projekt=0;
if((isset($tomb['sor_projekt_nev']))and(is_array($tomb['sor_projekt_nev']))){
foreach($tomb['sor_projekt_nev'] as $projekt_nev => $projekt_id){
if($projekt_nev!=""){
 $van_projekt=1;
 echo '<th>';
 echo $projekt_nev;
}
}
}

echo '</tr>';
echo '</thead><tbody>';

if((isset($tomb['sor_szerv_nev']))and(is_array($tomb['sor_szerv_nev']))){
//foreach($tomb['sor_szerv_nev'] as $szerv_nev => $szerv_id){
foreach($tomb['sor_szerv_nev'] as $szerv_id =>  $szerv_ert){
echo '<tr>';

echo '<td>';//1
echo $szerv_ert["szerv_nev"];

echo '<td>';//2 összesen
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
 $all_tortora=str_replace(".",",",round($egeszzam_ora,2));
 echo $all_tortora;
 
 echo '<td>';//3
  
 echo $tomb_orall_kesz["rogzit_ora"];
 echo ':';
 echo $tomb_orall_kesz["rogzit_perc"];

if($van_projekt==1){
foreach($tomb['sor_projekt_nev'] as $projekt_id){
 echo "<td>";

 if(
 (isset($tomb['sor'][$szerv_id][$projekt_id]))and
 ($tomb['sor'][$szerv_id][$projekt_id]['rogzit_ora']!="")
 ){
  $ki_adat=$tomb['sor'][$szerv_id][$projekt_id]['rogzit_ora'].":".$tomb['sor'][$szerv_id][$projekt_id]['rogzit_perc'];
 }else{
  //$ki_adat="<right>0:00</right>";
  $ki_adat=""; 
 }
 echo $ki_adat;
 
}
}

echo '</tr>';
}
}

echo '</tbody></table>';
}

?>