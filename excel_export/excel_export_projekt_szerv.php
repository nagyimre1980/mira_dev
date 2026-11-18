<?php
function excel_export_projekt_szerv($ev,$ho){

$date=date("Y_m_d-H_i_s",time());
$filename_alap=$GLOBALS['rend_nev'].' statisztika tevékenység-szervezet összesítése '.$date;
$filename=$filename_alap.'.xlsx';

$csv_uft8="\xEF\xBB\xBF";
$elv_oszlop=';';
$elv_sor=PHP_EOL;
$csv_adat=$csv_uft8;
if($ho=='all'){
 $csv=1;
}else{
 $csv=0;
}

if($csv==1){	
	$filename_csv=$filename_alap.".csv";
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=\"".$filename_csv."\";" );
	header("Content-Transfer-Encoding: binary");
	$f = fopen('php://output', 'w');
	fwrite($f,$csv_uft8);
}

$tomb=keress_stat_rogzitett($ev,$ho,"projekt_szerv","1");
mysqli_close($GLOBALS['mysqli']);
if(is_array($tomb))
 ksort($tomb['sor_szerv_nev']);
/*if((isset($tomb['sor_szerv_nev']))and(is_array($tomb['sor_szerv_nev']))){
 asort($tomb['sor_szerv_nev']);
}*/

$i=0;

if($csv==1)
 $adat[$i][]='Tevékenység neve';
else
 $adat[$i][]='<b>Tevékenység neve</b>';

if($csv==1)
 $adat[$i][]='Max óra';
else
 $adat[$i][]='<b>Max óra</b>';

if($csv==1)
 $adat[$i][]='Összesen óra';
else
 $adat[$i][]='<b>Összesen óra</b>';

if($csv==1)
 $adat[$i][]='Összesen óra:perc';
else
 $adat[$i][]='<b>Összesen óra:perc</b>';

if((isset($tomb['sor_szerv_nev']))and(is_array($tomb['sor_szerv_nev']))){
foreach($tomb['sor_szerv_nev'] as $szerv_nev => $szerv_id){
 if($csv==1)
  $adat[$i][]=$szerv_nev;
 else
  $adat[$i][]='<b>'.$szerv_nev.'</b>';
}
}

if($csv==1){
 foreach($adat[$i] as $s_adat){
  fwrite($f,$s_adat.$elv_oszlop);
 }
 fwrite($f,$elv_sor);
 unset($adat[$i]);
}

if((isset($tomb['sor_projekt_nev']))and(is_array($tomb['sor_projekt_nev']))){
//foreach($tomb['sor_projekt_nev'] as $projekt_nev => $projekt_id){
foreach($tomb['sor_projekt_nev'] as $projekt_id => $projekt_nevtomb){
$i++;

$adat[$i][]=$projekt_nevtomb['projekt_nev'];

//Összesen - eleje
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
 if($tomb_orall_kesz['rogzit_perc']<10)$tomb_orall_kesz['rogzit_perc']='0'.$tomb_orall_kesz['rogzit_perc'];
 
 //Összesen törtve
 $egeszzam_ora=$tomb_orall_kesz['rogzit_ora'];
 $egeszzam_ora+=$tomb_orall_kesz['rogzit_perc']/60;
 $all_tortora=round($egeszzam_ora,2);
 
 //Max óra
 $adat[$i][]=$projekt_nevtomb['projekt_id_max_ora'];
 
 if($csv==1){
  $adat[$i][]=str_replace('.',',',$all_tortora);
 }else{
  $adat[$i][]=$all_tortora;
 }
 
 $adat[$i][]=$tomb_orall_kesz['rogzit_ora'].':'.$tomb_orall_kesz['rogzit_perc'];
//Összesen - vége

foreach($tomb['sor_szerv_nev'] as $szerv_id){

 if(
 (isset($tomb['sor'][$projekt_id][$szerv_id]))
 and
 (
 ($tomb['sor'][$projekt_id][$szerv_id]['rogzit_ora']!='')
 or
 ($tomb['sor'][$projekt_id][$szerv_id]['rogzit_perc']!='')
 )
 and
 (
 ($tomb['sor'][$projekt_id][$szerv_id]['rogzit_ora']!='0')
 or
 ($tomb['sor'][$projekt_id][$szerv_id]['rogzit_perc']!='00')
 )
 ){
  $ki_adat=$tomb['sor'][$projekt_id][$szerv_id]['rogzit_ora'].':'.$tomb['sor'][$projekt_id][$szerv_id]['rogzit_perc'];
 }else{
  //$ki_adat="<right>0:00</right>";
  $ki_adat='0:00';
  //$ki_adat=""; 
 }
 $adat[$i][]=$ki_adat;

}

unset($tomb['sor_projekt_nev'][$projekt_id]);
if($csv==1){
 foreach($adat[$i] as $s_adat){
  //$csv_adat.=$s_adat.$elv_oszlop;
  fwrite($f,$s_adat.$elv_oszlop);
 }
 unset($adat[$i]);
 //$csv_adat.=$elv_sor;
 fwrite($f,$elv_sor);
}

}
}

unset($tomb);

if($csv==1){
	unset($adat);
	fclose($f);
	exit;
}

//Shuchkin\SimpleXLSXGen::fromArray($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,$GLOBALS['rend_nev'].' export');
unset($adat);
$xlsx->downloadAs(rawurlencode($filename));
//(string)(new SimpleXLSXGen)->addSheet($adat,'MIRA export')->downloadAs(rawurlencode($filename));
}
?>