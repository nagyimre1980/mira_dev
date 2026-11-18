<?php

function html_tal_napi_user($ev,$ho){
if($ho<10)$ho_ki="0".$ho;
else $ho_ki=$ho;

$tomb=keress_stat_rogzitett($ev,$ho,"napi_user","0");

//maxuser_szam_select();

$i=0;
echo '<table cellpadding=1 cellspacing=1 style="margin-top:10px" id="stat_ered_table" class="table_emre">';
echo '<thead>';
echo '<tr onclick="stat_tablesort_katt(event.target)">';
echo "<th id='stat_ered_table_first_th'>";//első sor első oslzopba üres
$iuseroszlop=0;
if((isset($tomb['sor']))and(is_array($tomb['sor']))){
foreach($tomb['sor'] as $ert){
 $iuseroszlop++;
 if($iuseroszlop<=$GLOBALS['mira']['user_jog']['stat_leker_maxuser']){
  echo '<th>'.$ert['user_nev'];
 }
}
}

$van_nap_tomb=array();

$tomb_munkanap=keres_mit_munkanap($ev,$ho);
if((isset($tomb['user_tomb']))and(is_array($tomb['user_tomb']))){
 $tomb_munkanap_user=keres_mit_munkanap_usertomb($ev,$ho,$tomb['user_tomb']);
}
mysqli_close($GLOBALS['mysqli']);
if($ho!="all"){
 $naptimes=mktime("0","0","1",$ho,'1',$ev);
 $ho_ut_nap=date('t',$naptimes);
}else{
 $ho_ut_nap="31";
}

if((isset($_POST['idoszak_nap']))
and($_POST['idoszak_nap']!="all")){
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
  $nap_tipus_egyedi="";
 
 if($ho!="all"){
  $naptime=mktime("0","0","1",$ho,$nap_akt,$ev);
  $het_sorszam=date('w',$naptime);
 }else{
  $het_sorszam="";//Minden nap oké
  $nap_tipus_egyedi=="MN";//Minden nap munkanap
 }
 //$naptipus=naptipus($ev,$ho,$nap_akt);
 
 if($nap_tipus_egyedi=="PN"){
  $nap_dis="1";
 }elseif($nap_tipus_egyedi=="MN"){
  $nap_dis="0";/*
 }elseif(($het_sorszam!="6")and($het_sorszam!="0")and($naptipus=="PN")){
  $nap_dis="1";
 }elseif((($het_sorszam=="6")or($het_sorszam=="0"))and($naptipus!="MN")){
  $nap_dis="1";*/
 }elseif(($het_sorszam=="6")or($het_sorszam=="0")){
  $nap_dis="1";
 }else{
  $nap_dis="0";	
 }
 
 if($nap_dis==0){
  if($nap_akt<10)$nap_akt_ki="0".$nap_akt;
  else $nap_akt_ki=$nap_akt;
  //$adat[$i][]="<b>".$ev.".".$ho_ki.".".$nap_akt_ki."</b>";
  $van_nap_tomb[]=$nap_akt;
 }
 
}



echo '</tr>';
echo '</thead><tbody>';

foreach($van_nap_tomb as $nap_akt){
$i++;
  if($nap_akt<10)$nap_akt_ki='0'.$nap_akt;
  else $nap_akt_ki=$nap_akt;
echo '<tr>';
if($ho!="all")
 echo '<td>'.$ev.'.'.$ho_ki.'.'.$nap_akt_ki;
else
 echo '<td>'.$nap_akt_ki;

if((isset($tomb['user_tomb']))and(is_array($tomb['user_tomb']))){
$iuseroszlop=0;
foreach($tomb['user_tomb'] as $user_ad){
$iuseroszlop++;
if($iuseroszlop<=$GLOBALS['mira']['user_jog']['stat_leker_maxuser']){	
if((isset($tomb['sor'][$user_ad['user_ad']]['adat'][$nap_akt]))
 and(isset($tomb['sor'][$user_ad['user_ad']]['adat'][$nap_akt]['tavollet']))
 and($tomb['sor'][$user_ad['user_ad']]['adat'][$nap_akt]['tavollet']==1)
 and($ho!="all")
 ){
  $kiido="Távollét";
}elseif(
(isset($tomb['sor'][$user_ad['user_ad']]['adat'][$nap_akt]))
and(
 ($tomb['sor'][$user_ad['user_ad']]['adat'][$nap_akt]['rogzit_ora']!="")
or($tomb['sor'][$user_ad['user_ad']]['adat'][$nap_akt]['rogzit_perc']!="")
)
){
  $kiido=$tomb['sor'][$user_ad['user_ad']]['adat'][$nap_akt]['rogzit_ora'];
  $kiido.=":";
  $kiido.=$tomb['sor'][$user_ad['user_ad']]['adat'][$nap_akt]['rogzit_perc'];
  
 }else{
	//$kiido="<right>0:00</right>"; 
	$kiido="";
 }
 
 echo '<td>'.$kiido;
}
}
}
 echo '</tr>';
}
echo '</tbody></table>';

}

?>