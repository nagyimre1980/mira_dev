<?php

function html_tal_projekt_szerv($ev,$ho){

$tomb=keress_stat_rogzitett($ev,$ho,"projekt_szerv","0");
mysqli_close($GLOBALS['mysqli']);
if(is_array($tomb))
 ksort($tomb['sor_szerv_nev']);
/*if((isset($tomb['sor_szerv_nev']))and(is_array($tomb['sor_szerv_nev']))){
 //asort($tomb['sor_szerv_nev']);
}*/

/*echo "<pre>";
print_r($tomb);
echo "</pre>";*/

$i=0;
echo '<table cellpadding=1 cellspacing=1 style="margin-top:10px" id="stat_ered_table" class="table_emre">';
echo '<thead>';
echo '<tr onclick="stat_tablesort_katt(event.target)">';
echo "<th id='stat_ered_table_first_th' style='text-decoration:underline'>Tevékenység neve";
echo '<th title="Havonta rögzíthető max óra">Max óra';
//echo "<th>Összesen";
echo '<th title="Összesen óra egészszám formában">Σ órában';
echo '<th title="Összesen óra:perc">Σ óra:perc';

if((isset($tomb['sor_szerv_nev']))and(is_array($tomb['sor_szerv_nev']))){
foreach($tomb['sor_szerv_nev'] as $szerv_nev => $szerv_id){
 echo "<th>";
 echo $szerv_nev;
}
}

echo '</tr>';
echo '</thead><tbody>';

if((isset($tomb['sor_projekt_nev']))and(is_array($tomb['sor_projekt_nev']))){
//foreach($tomb['sor_projekt_nev'] as $projekt_nev => $projekt_id){
foreach($tomb['sor_projekt_nev'] as $projekt_id => $projekt_nevtomb){
echo '<tr>';

echo '<td>';
echo $projekt_nevtomb['projekt_nev'];

$all_ora=0;
$all_perc=0;
 foreach($tomb['sor_szerv_nev'] as $szerv_id){
  if(isset($tomb['sor'][$projekt_id][$szerv_id])){
   $tomb_orall=ora_perc_osszead($tomb['sor'][$projekt_id][$szerv_id]['rogzit_ora'],$tomb['sor'][$projekt_id][$szerv_id]['rogzit_perc']);	 
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
 
 //Max óra
 if(($projekt_nevtomb['projekt_id_max_ora']!="")and($projekt_nevtomb['projekt_id_max_ora']<$all_tortora)){
	 $css_max=" class='pir_vas'";
 }else{
	 $css_max="";
 }
 echo '<td'.$css_max.'>'.$projekt_nevtomb['projekt_id_max_ora'];

 echo '<td>';//összesen
 echo $all_tortora;

 echo '<td>';//összesen 
 echo $tomb_orall_kesz['rogzit_ora'];
 echo ':';
 echo $tomb_orall_kesz['rogzit_perc'];

foreach($tomb['sor_szerv_nev'] as $szerv_id){
 echo '<td>';

 if(isset($tomb['sor'][$projekt_id][$szerv_id])){
  $ki_adat=$tomb['sor'][$projekt_id][$szerv_id]['rogzit_ora'].":".$tomb['sor'][$projekt_id][$szerv_id]['rogzit_perc'];
 }else{
  //$ki_adat="<right>0:00</right>";
  $ki_adat=""; 
 }
 echo $ki_adat;
 
}

echo '</tr>';
}
}

echo '</tbody></table>';
}

?>