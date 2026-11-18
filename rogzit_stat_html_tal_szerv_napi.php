<?php

function html_tal_szervezet_napi($ev,$ho){
if($ho<10)$ho_ki="0".$ho;
else $ho_ki=$ho;

$tomb=keress_stat_rogzitett($ev,$ho,"szervezet_napi","0");

$i=0;
echo '<table cellpadding=1 cellspacing=1 style="margin-top:10px" id="stat_ered_table" class="table_emre">';
echo '<thead>';
echo '<tr onclick="stat_tablesort_katt(event.target)">';
echo "<th id='stat_ered_table_first_th' style='text-decoration:underline'>Szervezet neve";
echo '<th title="Összesen óra egészszám formában">Σ órában';
echo '<th title="Összesen óra:perc">Σ óra:perc';

/*echo "<pre>";
print_r($tomb);
echo "</pre>";*/

$van_nap_tomb=array();

$tomb_munkanap=keres_mit_munkanap($ev,$ho);
if(isset($tomb['user_tomb'])){
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
	 $nap_tipus_egyedi="MN";//Minden nap munkanap
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
  if($ho!="all")
   echo '<th>'.$ev.'.'.$ho_ki.'.'.$nap_akt_ki;
  else
   echo '<th>'.$nap_akt_ki;
  $van_nap_tomb[]=$nap_akt;
 }
 
}




echo '</tr>';
echo '</thead><tbody>';

/*echo "<pre>";
print_r($tomb['sor']);
echo "</pre>";*/

if((isset($tomb['sor']))and(is_array($tomb['sor']))){
foreach($tomb['sor'] as $ert){
 $i++;
 echo '<tr>';
 echo '<td>'.$ert["szerv_nev"];
 
 echo '<td>';//összesen
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
 $egeszzam_ora=$all_ora;
 $egeszzam_ora+=$all_perc/60;
 $all_tortora=str_replace(".",",",round($egeszzam_ora,2));
 echo $all_tortora;
 
 echo '<td>';
 
 echo $tomb_orall_kesz["rogzit_ora"];
 echo ':';
  echo $tomb_orall_kesz["rogzit_perc"];
 
 
 foreach($van_nap_tomb as $nap_akt){

 if(isset($ert['adat'][$nap_akt])){
  //if($ert['adat'][$nap_akt]['rogzit_ora']<10)$ert['adat'][$nap_akt]['rogzit_ora']="0".$ert['adat'][$nap_akt]['rogzit_ora'];
  if($ert['adat'][$nap_akt]['rogzit_ora']=="")$ert['adat'][$nap_akt]['rogzit_ora']="0";
  if($ert['adat'][$nap_akt]['rogzit_perc']=="0")$ert['adat'][$nap_akt]['rogzit_perc']="00";
  $ki_adat=$ert['adat'][$nap_akt]['rogzit_ora'].":".$ert['adat'][$nap_akt]['rogzit_perc'];
 }else{
  //$ki_adat="<right>0:00</right>";
  //$ki_adat="0:00";
  $ki_adat="";
 }
 //$adat[$i][]=$ki_adat.":00";
 echo '<td>'.$ki_adat;
 }
 
 
 
}
}

echo '</tbody></table>';

}

?>