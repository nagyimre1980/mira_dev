<?php

function excel_export_projekt_napi($ev,$ho){
if($ho<10)$ho_ki="0".$ho;
else $ho_ki=$ho;

$date=date("Y_m_d-H_i_s",time());
$filename_alap=$GLOBALS['rend_nev']." statisztika tevékenység napi összesítése ".$date;
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

$tomb=keress_stat_rogzitett($ev,$ho,"projekt_napi","1");

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


$van_nap_tomb=array();

$tomb_munkanap=keres_mit_munkanap($ev,$ho);
if(isset($tomb['user_tomb'])){
 $tomb_munkanap_user=keres_mit_munkanap_usertomb($ev,$ho,$tomb['user_tomb']);
}
mysqli_close($GLOBALS['mysqli']);
if($ho!='all'){
 $naptimes=mktime('0','0','1',$ho,'1',$ev);
 $ho_ut_nap=date('t',$naptimes);
}else{
 $ho_ut_nap='31';
}

if((isset($_POST['idoszak_nap']))
and($_POST['idoszak_nap']!='all')){
 $ho_elso_nap=$ho_ut_nap=$_POST['idoszak_nap'];
}else{
 $ho_elso_nap=1;	
}

$ho_sor_munkanapszam=0;
for($nap_akt=$ho_elso_nap;$nap_akt<=$ho_ut_nap;$nap_akt++){
 if(isset($tomb_munkanap_user[$nap_akt]))
  $nap_tipus_egyedi=$tomb_munkanap_user[$nap_akt];
 elseif(isset($tomb_munkanap[$nap_akt]))
  $nap_tipus_egyedi=$tomb_munkanap[$nap_akt];
 else
  $nap_tipus_egyedi='';
 
 if($ho!='all'){
  $naptime=mktime('0','0','1',$ho,$nap_akt,$ev);
  $het_sorszam=date('w',$naptime);
 }else{
	 $het_sorszam='';//Minden nap oké
	 $nap_tipus_egyedi='MN';//Minden nap munkanap
 }
 //$naptipus=naptipus($ev,$ho,$nap_akt);
  
 if($nap_tipus_egyedi=='PN'){
  $nap_dis='1';
 }elseif($nap_tipus_egyedi=='MN'){
  $nap_dis='0';/*
 }elseif(($het_sorszam!="6")and($het_sorszam!="0")and($naptipus=="PN")){
  $nap_dis="1";
 }elseif((($het_sorszam=="6")or($het_sorszam=="0"))and($naptipus!="MN")){
  $nap_dis="1";*/
 }elseif(($het_sorszam=='6')or($het_sorszam=='0')){
  $nap_dis='1';
 }else{
  $nap_dis='0';	
 }
 
 if($nap_dis==0){
  if($nap_akt<10)$nap_akt_ki='0'.$nap_akt;
  else $nap_akt_ki=$nap_akt;
  if($ho!='all'){
   if($csv==1)
    $adat[$i][]=$ev.'.'.$ho_ki.'.'.$nap_akt_ki;
   else
    $adat[$i][]='<b>'.$ev.'.'.$ho_ki.'.'.$nap_akt_ki.'</b>';
  }else{
   if($csv==1)
    $adat[$i][]=$nap_akt_ki;
   else
    $adat[$i][]='<b>'.$nap_akt_ki.'</b>';
  }
  $van_nap_tomb[]=$nap_akt;
 }
 
}

if($csv==1){
 foreach($adat[$i] as $s_adat){
  fwrite($f,$s_adat.$elv_oszlop);
 }
 fwrite($f,$elv_sor);
}



if((isset($tomb['sor']))and(is_array($tomb['sor']))){
foreach($tomb['sor'] as $is_fo => $ert){
 $i++;
 $adat[$i][]=$ert['projekt_nev'];
 
 //Összesen - eleje
 $all_ora=0;
 $all_perc=0;
 foreach($van_nap_tomb as $nap_akt){
  if(isset($ert['adat'][$nap_akt]['rogzit_ora'])){
   $tomb_orall=ora_perc_osszead($ert['adat'][$nap_akt]['rogzit_ora'],$ert['adat'][$nap_akt]['rogzit_perc']);	 
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
 
 //Max óra
 $adat[$i][]=$ert['projekt_id_max_ora'];
 
 //Áll óra CSV esetén vesszővel kell
 if($csv==1){
  $adat[$i][]=str_replace('.',',',$all_tortora);
 }else{
  $adat[$i][]=$all_tortora;
 }

 $adat[$i][]=$tomb_orall_kesz['rogzit_ora'].':'.$tomb_orall_kesz['rogzit_perc'];
 //Összesen - vége
 
 foreach($van_nap_tomb as $nap_akt){

 if(
 (isset($ert['adat'][$nap_akt]))
 and
 (
 ($ert['adat'][$nap_akt]['rogzit_ora']!='')
 or
 ($ert['adat'][$nap_akt]['rogzit_perc']!='')
 )
 and
 (
 ($ert['adat'][$nap_akt]['rogzit_ora']!='0')
 or
 ($ert['adat'][$nap_akt]['rogzit_perc']!='00')
 )
 ){
  //if($ert['adat'][$nap_akt]['rogzit_ora']<10)$ert['adat'][$nap_akt]['rogzit_ora']="0".$ert['adat'][$nap_akt]['rogzit_ora'];
  $ki_adat=$ert['adat'][$nap_akt]['rogzit_ora'].':'.$ert['adat'][$nap_akt]['rogzit_perc'];
 }else{
  //$ki_adat="<right>0:00</right>";
  $ki_adat='0:00';
  //$ki_adat="";
 }
 //$adat[$i][]=$ki_adat.":00";
 $adat[$i][]=$ki_adat.'';
 }
 

unset($tomb['sor'][$is_fo]);
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