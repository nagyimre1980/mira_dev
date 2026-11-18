<?php

function excel_export_napi_user($ev,$ho){
if($ho<10)$ho_ki="0".$ho;
else $ho_ki=$ho;

$date=date("Y_m_d-H_i_s",time());
$filename_alap=$GLOBALS['rend_nev']." statisztika napi összesítés felhasznlók szerint ".$date;
$filename=$filename_alap.".xlsx";

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


$tomb=keress_stat_rogzitett($ev,$ho,"napi_user","1");

$i=0;
$adat[$i][]="";//első sor első oszlopba üres

if((isset($tomb['sor']))and(is_array($tomb['sor']))){
foreach($tomb['sor'] as $ert){
 if($csv==1)
  $adat[$i][]=$ert['user_nev'];
 else
  $adat[$i][]='<b>'.$ert['user_nev'].'</b>';
}
}


$van_nap_tomb=array();

$tomb_munkanap=keres_mit_munkanap($ev,$ho);
if((isset($tomb['user_tomb']))and(is_array($tomb['user_tomb']))){
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
  $nap_tipus_egyedi=='MN';//Minden nap munkanap
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
  if($nap_akt<10)$nap_akt_ki="0".$nap_akt;
  else $nap_akt_ki=$nap_akt;
  //$adat[$i][]="<b>".$ev.".".$ho_ki.".".$nap_akt_ki."</b>";
  $van_nap_tomb[]=$nap_akt;
 }
 
}


if($csv==1){
 foreach($adat[$i] as $s_adat){
  //$csv_adat.=$s_adat.$elv_oszlop;
  fwrite($f,$s_adat.$elv_oszlop);
 }
 //$csv_adat.=$elv_sor;
 fwrite($f,$elv_sor);
}





foreach($van_nap_tomb as $is => $nap_akt){
$i++;
  if($nap_akt<10)$nap_akt_ki='0'.$nap_akt;
  else $nap_akt_ki=$nap_akt;
if($ho!='all')
 $adat[$i][]=$ev.'.'.$ho_ki.'.'.$nap_akt_ki.'';
else
 $adat[$i][]=$nap_akt_ki.'';

if((isset($tomb['user_tomb']))and(is_array($tomb['user_tomb']))){
foreach($tomb['user_tomb'] as $user_ad){
if(
(isset($tomb['sor'][$user_ad['user_ad']]['adat'][$nap_akt]))
and
(
($tomb['sor'][$user_ad['user_ad']]['adat'][$nap_akt]['rogzit_ora']!='')
or
($tomb['sor'][$user_ad['user_ad']]['adat'][$nap_akt]['rogzit_perc']!='')
)
and
(
($tomb['sor'][$user_ad['user_ad']]['adat'][$nap_akt]['rogzit_ora']!='0')
or
($tomb['sor'][$user_ad['user_ad']]['adat'][$nap_akt]['rogzit_perc']!='0')
)
){
  $kiido=$tomb['sor'][$user_ad['user_ad']]['adat'][$nap_akt]['rogzit_ora'];
  $kiido.=':';
  $kiido.=$tomb['sor'][$user_ad['user_ad']]['adat'][$nap_akt]['rogzit_perc'];
  
 }else{
	//$kiido="<right>0:00</right>";
	$kiido='0:00';
 }
 
 $adat[$i][]=$kiido;
}
}

if($csv==1){
 foreach($adat[$i] as $s_adat){
  //$csv_adat.=$s_adat.$elv_oszlop;
  fwrite($f,$s_adat.$elv_oszlop);
 }
 unset($adat[$i]);
 //$csv_adat.=$elv_sor;
 fwrite($f,$elv_sor);
}
unset($van_nap_tomb[$is]);
}

unset($van_nap_tomb);

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