<?php

function excel_export_akt_user_tomeges($tuser_ad,$ev,$ho){
//Tömeges lekérés, csak jóváhagyással rendelkezőnek.
if(
(!isset($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']))or
 (
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']))
 and
 ($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']!='1')
 )
){
 exit;
}

$tomb_mentve=keres_rogzit_egyho_tomeges($tuser_ad,$ev,$ho);
$tomb_user=keres_rogzit_egyho_tomeges_userhez($tuser_ad);

if($ho>10)
 $ev2=$ev.'_'.$ho;
else
 $ev2=$ev."_0".$ho;

$date=date("Y_m_d-H_i_s",time());
$filename_alap=$GLOBALS['rend_nev']." statisztika tömeges ".$ev2." rögzítések ".$date;
$filename=$filename_alap.".xlsx";

 $adat=array();
  $i=0;
  $adat[$i][]='<b>Név</b>';
  $adat[$i][]='<b>AD azonosító</b>';
  $adat[$i][]='<b>Törzsszám</b>';
  $adat[$i][]='<b>Email cím</b>';
  $adat[$i][]='<b>Szervezet</b>';
  $adat[$i][]='<b>Tevékenység neve</b>';
  $adat[$i][]='<b>Dátum</b>';
  $adat[$i][]='<b>Rögzített munkaidő</b>';
  $adat[$i][]='<b>Rögzített munkaidő - egészszám</b>';
  $adat[$i][]='<b>Rögzített munkaidő - óra</b>';
  $adat[$i][]='<b>Rögzített munkaidő - perc</b>';
  $adat[$i][]='<b>Rögzítés ideje</b>';
  $adat[$i][]='<b>Rögzítő megjegyzése</b>';
  $adat[$i][]='<b>Rögzítő tevékenység megjegyzése</b>';

if(
(is_array($tomb_user))and
(is_array($tomb_mentve))and
(is_array($tomb_mentve['adat']))
){

 foreach($tomb_mentve['adat'] as $user_ad => $tomb_tmp_a){
 foreach($tomb_tmp_a as $nap => $tomb_tmp){
 foreach($tomb_tmp as $projekt_id => $ert){
 if((isset($tomb_user[$user_ad]))and(is_array($tomb_user[$user_ad]))){
  $i++;
  
  $adat[$i][]=$tomb_user[$user_ad]['user_nev'];
  $adat[$i][]=$tomb_user[$user_ad]['user_ad'];
  $adat[$i][]=$tomb_user[$user_ad]['user_tsz'];
  $adat[$i][]=$tomb_user[$user_ad]['user_email'];

  $adat[$i][]=$tomb_mentve['nap_foadat'][$user_ad][$nap]['szerv_nev'];//szervezet nev
  
  $adat[$i][]=$ert['projekt_nev'];
  
  $adat[$i][]=$nap;
  
  if($ert['rogzit_perc']<10)
   $perc='0'.$ert['rogzit_perc'];
  else
   $perc=$ert['rogzit_perc'];
  $adat[$i][]=$ert['rogzit_ora'].':'.$perc;//8:01
  
  //egész óra eleje
   $egeszzam_ora=$ert['rogzit_ora'];
   $egeszzam_ora+=$ert['rogzit_perc']/60;
   $adat[$i][]=round($egeszzam_ora,2);////8,01
  //egész óra vége
 
   $adat[$i][]=$ert['rogzit_ora'];//8,01
  $adat[$i][]=$ert['rogzit_perc'];//8,01
  //$adat[$i][]='<style nf="YYYY-mm-dd hh:mm:ss">'.$ert['rogzit_sor_update_time'].'</style>';
  
  $ert['rogzit_sor_update_time']=str_replace("-",".",$ert['rogzit_sor_update_time']);
  $adat[$i][]="\0".$ert['rogzit_sor_update_time'];
  //$adat[$i][]='<style nf="yyyy.mm.dd hh:mm:ss">'.$ert['rogzit_sor_update_time'].'</style>';
  
  //$adat[$i][]=$ert['rogzit_megj'];
  $adat[$i][]=$tomb_mentve['nap_foadat'][$user_ad][$nap]['rogzit_megj'];
  
  $adat[$i][]=$ert['rogzit_sor_megj_adat'];
 }
 }
 }
 }

}

//exit;
 unset($tomb_mentve);
 unset($tomb_user);
 $xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,$GLOBALS['rend_nev'].' export');
unset($adat);
$xlsx->downloadAs(rawurlencode($filename));	
}



function keres_rogzit_egyho_tomeges_userhez($tuser_ad){
$eredmeny_keres="";

$where_t='';
$tomb_tuser_ad=explode(",",$tuser_ad);
if(is_array($tomb_tuser_ad)){
foreach($tomb_tuser_ad as $ert){
 if($ert!=''){
  if($where_t!='')$where_t.='or';
  $ert=mysqli_real_escape_string($GLOBALS['mysqli'],$ert);
  $where_t.="(mira_user.user_ad='".$ert."')";
 }
}
}
if($where_t!=''){
$where='('.$where_t.')';
}else{
 return '';
}

 $sql="SELECT 
 mira_user.user_nev,
 mira_user.user_ad,
 mira_user.user_tsz,
 mira_user.user_email
 FROM `mira_user` 
 where 
 ".$where."
 ";
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_rogzit_egyho_tomeges($tuser_ad,$ev,$ho){
$eredmeny_keres="";

$ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);
if($ho<10)$ho="0".$ho;
else $ho=$ho;
$ido=$ev."-".$ho;

$where_t='';
$tomb_tuser_ad=explode(",",$tuser_ad);
if(is_array($tomb_tuser_ad)){
foreach($tomb_tuser_ad as $ert){
 if($ert!=''){
  if($where_t!='')$where_t.='or';
  $ert=mysqli_real_escape_string($GLOBALS['mysqli'],$ert);
  $where_t.="(rogzit.user_ad='".$ert."')";
 }
}
}
if($where_t!=''){
$where='('.$where_t.')';
}else{
 return '';
}

 $sql="SELECT 
 rogzit.user_ad,
 rogzit.rogzit_nap,
 rogzit.tavollet,
 rogzit.rogzit_megj,
 
 rogzit_sor.projekt_id,
 rogzit_sor.rogzit_ora,
 rogzit_sor.rogzit_perc,
 
 projekt.projekt_nev,
 projekt.projekt_title,
 IF(rogzit_sor.rogzit_sor_megj is not null,1,0) as rogzit_sor_megj,
 rogzit_sor.rogzit_sor_megj as rogzit_sor_megj_adat,
 rogzit_sor.rogzit_sor_update_time,
 
 mira_szerv.szerv_nev
 FROM `rogzit` 
 left join mira_szerv ON mira_szerv.szerv_id = rogzit.szerv_id
 left join rogzit_sor ON rogzit_sor.rogzit_id = rogzit.rogzit_id
 left join projekt ON projekt.projekt_id = rogzit_sor.projekt_id
 left join mira_user ON mira_user.user_ad = rogzit.user_ad
 where 
 ".$where."
 and 
 rogzit.rogzit_nap like '".$ido."%' 
 order by mira_user.user_nev asc,rogzit.rogzit_nap asc,rogzit_sor.sorsz ASC";
 //order by rogzit.rogzit_nap,projekt.projekt_nev ASC";
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
 if(
  ($adatom['tavollet']==1)
  or
  (
  ($adatom['tavollet']==0)
  //and($adatom['projekt_id']!="")
  )
  ){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres['tavollet'][$adatom['rogzit_nap']]=$adatom['tavollet'];
  
  if($adatom['projekt_id']!=""){
  //$eredmeny_keres['adat'][$adatom['rogzit_nap']][$adatom['projekt_id']]=$adatom;
   $eredmeny_keres['adat'][$adatom['user_ad']][$adatom['rogzit_nap']][$adatom['projekt_id']]['projekt_nev']=$adatom['projekt_nev'];
   $eredmeny_keres['adat'][$adatom['user_ad']][$adatom['rogzit_nap']][$adatom['projekt_id']]['projekt_title']=$adatom['projekt_title'];
   $eredmeny_keres['adat'][$adatom['user_ad']][$adatom['rogzit_nap']][$adatom['projekt_id']]['rogzit_sor_megj']=$adatom['rogzit_sor_megj'];
   $eredmeny_keres['adat'][$adatom['user_ad']][$adatom['rogzit_nap']][$adatom['projekt_id']]['rogzit_sor_megj_adat']=$adatom['rogzit_sor_megj_adat'];
   $eredmeny_keres['adat'][$adatom['user_ad']][$adatom['rogzit_nap']][$adatom['projekt_id']]['rogzit_sor_update_time']=$adatom['rogzit_sor_update_time'];
   $eredmeny_keres['adat'][$adatom['user_ad']][$adatom['rogzit_nap']][$adatom['projekt_id']]['projekt_id']=$adatom['projekt_id'];
   $eredmeny_keres['adat'][$adatom['user_ad']][$adatom['rogzit_nap']][$adatom['projekt_id']]['rogzit_ora']=$adatom['rogzit_ora'];
   $eredmeny_keres['adat'][$adatom['user_ad']][$adatom['rogzit_nap']][$adatom['projekt_id']]['rogzit_perc']=$adatom['rogzit_perc'];
  }
  
  $eredmeny_keres['nap_foadat'][$adatom['user_ad']][$adatom['rogzit_nap']]['szerv_nev']=$adatom['szerv_nev'];
  $eredmeny_keres['nap_foadat'][$adatom['user_ad']][$adatom['rogzit_nap']]['rogzit_megj']=$adatom['rogzit_megj'];
  //$eredmeny_keres['nap_foadat'][$adatom['rogzit_nap']]['rogzit_jovahagyva']=$adatom['rogzit_jovahagyva'];
  //$eredmeny_keres['nap_foadat'][$adatom['rogzit_nap']]['rogzit_jovahagyva_ki']=$adatom['rogzit_jovahagyva_ki'];
  //$eredmeny_keres['nap_foadat'][$adatom['rogzit_nap']]['rogzit_jovahagyva_ki_nev']=$adatom['rogzit_jovahagyva_ki_nev'];
  //$eredmeny_keres['nap_foadat'][$adatom['rogzit_nap']]['rogzit_jovahagyva_mikor']=$adatom['rogzit_jovahagyva_mikor'];
  //$eredmeny_keres['nap_foadat'][$adatom['rogzit_nap']]['rogzit_jovahagyva_megj']=$adatom['rogzit_jovahagyva_megj'];
 
 }
 }
 return $eredmeny_keres;
 
}


?>