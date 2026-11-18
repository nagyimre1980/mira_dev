<?php

function riport_teny3_elteres(){

//Hó alapján ki kell találni a backup id értékeket! - eleje
$tomb=array();
if($_POST['date1_ho']=='all'){
 include_once('../riport_func.php');
 $tomb_nonp_ho=keress_riport_ful_ki_evho_teny3($_POST['date1_ev']);
  if(is_array($tomb_nonp_ho)){
  foreach($tomb_nonp_ho as $ert){
	$tomb[$ert['backup_ver_ho']]=keress_terv3_elteres_letolt_xlsx($ert['backup_ver_id'],$_POST['tervalaptipus'],$_POST['date1_ev'],$ert['backup_ver_ho']);
  }
 }
}else{
 $tomb_nonp_ho=explode('#',$_POST['date1_ho']);
 if(is_array($tomb_nonp_ho)){
  foreach($tomb_nonp_ho as $backup_ver_id){
	
	$ho=keres_mit2_mit1_csak_ertek('backup_ver','backup_ver_id',$backup_ver_id,'backup_ver_default','1','backup_ver_ho');
	$tomb[$ho]=keress_terv3_elteres_letolt_xlsx($backup_ver_id,$_POST['tervalaptipus'],$_POST['date1_ev'],$ho);
   }
  }
}

$tomb_tagv=keress_terv3_elteres_tagv_kod_lista();
$tomb_szolg=keress_terv3_elteres_szolg_kod_lista();
mysqli_close($GLOBALS['mysqli']);
riport_teny3_elteres_kirajzol($tomb,$tomb_tagv,$tomb_szolg);
}

function riport_teny3_elteres_kirajzol($tomb_ho,$tomb_tagv,$tomb_szolg){

$hatar_also=$_POST['hatar_also'];
$hatar_felso=$_POST['hatar_felso'];

$i=0;
$adat[$i][]='<b>'."Hónap".'</b>';
$adat[$i][]='<b>'."Tásaság kód".'</b>';
$adat[$i][]='<b>'."Tásaság neve".'</b>';
$adat[$i][]='<b>'."Tevékenység kód".'</b>';
$adat[$i][]='<b>'."Szolgáltatás név".'</b>';

$adat[$i][]='<b>'."Összesen egész óra".'</b>';
//$adat[$i][]='<b>'."Összesen óra".'</b>';
//$adat[$i][]='<b>'."Összesen perc".'</b>';
$adat[$i][]='<b>'."ID".'</b>';
$adat[$i][]='<b>'."Terv".'</b>';
$adat[$i][]='<b>'."Eltérés óra".'</b>';
$adat[$i][]='<b>'."Eltérés %".'</b>';
$adat[$i][]='<b>'."Nagy százalékos eltérés".'</b>';
$adat[$i][]='<b>'."Jelentős eltérés".'</b>';

foreach($tomb_ho as $ho => $tomb){
foreach($tomb as $ert){
 $i++;
 $adat[$i][]=$ho;
 $adat[$i][]=$ert['projekt_tagv_kod'];
 
 //Tásaság neve - eleje
 if(isset($tomb_tagv[$ert['projekt_tagv_kod']])){
	$adat[$i][]=$tomb_tagv[$ert['projekt_tagv_kod']];
 }else{
	 $adat[$i][]="";
 }
 //Tásaság neve - vége
  
 $adat[$i][]=$ert['projekt_szolg_kod'];
 
  //Szolgáltatás név - eleje
  if(isset($tomb_szolg[$ert['projekt_szolg_kod']])){
	$adat[$i][]=$tomb_szolg[$ert['projekt_szolg_kod']];
 }else{
	 $adat[$i][]="";
 }
 //Szolgáltatás név - vége
 
 $adat[$i][]=$ert['rogzitett_teny3_ora_egesz'];
 //$adat[$i][]=$ert['rogzitett_teny3_ora'];
 //$adat[$i][]=$ert['rogzitett_teny3_perc'];
 $adat[$i][]=$ert['projekt_tervkod'];
 
 //Tervadat
 $adat[$i][]=$ert['backup_terv_osszeg'];
 
 //Eltérés % - eleje
 if(($ert['backup_terv_osszeg']!='')and($ert['backup_terv_osszeg']!=0)){
  $elteres_ora=$ert['rogzitett_teny3_ora_egesz']-$ert['backup_terv_osszeg'];
  $elteres=round((($ert['rogzitett_teny3_ora_egesz']/$ert['backup_terv_osszeg'])*100)-100,2);
 }else{
  $elteres_ora='';
  $elteres='';
 }
 //Eltérés % - vége
 
 //Problémás - eleje
 
 if(
  ($elteres!='')and
  ($hatar_felso!='')and
  ($hatar_also!='')and
  (
  ( ($elteres>0)and($elteres>$hatar_felso) )
  or
  ( ($elteres<0)and(abs($elteres)>$hatar_also))
 )
 ){
	 $adat[$i][]=$elteres_ora;
	 $adat[$i][]='<style bgcolor="#FFD800" color="#000000">'.$elteres.'</style>';//piros FF0000 sárga FFD800 fehér ffffff
	 $adat[$i][]='<style bgcolor="#FFD800" color="#000000">probléma</style>';
	 
	 if((isset($_POST['hatar_jelentos']))and($_POST['hatar_jelentos']!='')){
	 $nagyelter_hatar=$_POST['hatar_jelentos'];
	 $nagyelter_hatar_m=$_POST['hatar_jelentos']*-1;
	 
	 if( ($elteres_ora<$nagyelter_hatar_m) or ($elteres_ora>$nagyelter_hatar)){
		 $adat[$i][]='<style bgcolor="#FF0000" color="#ffffff">Nagy mértékű eltérés</style>';
	 }else{
		 $adat[$i][]='';
	 }
	 }else{//Ha véletlen nincs határérték!
		 $adat[$i][]='';
	 }
	 
 }else{
	 //'rendben';
	 $adat[$i][]=$elteres_ora;
	 $adat[$i][]=$elteres;
	 $adat[$i][]='';
 }
 //Problémás - vége
 
}
}
unset($tomb);

$date=date("Y_m_d-H_i_s",time());
//$filename='Teny3 '.$date.'.xlsx';
$filename='Teny3_'.$_POST['date1_ev'].'evi_'.$date.'.xlsx';
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Tény3 export');
unset($adat);
$xlsx->autoFilter('F1:G1');
$xlsx->downloadAs(rawurlencode($filename));
}

function keress_terv3_elteres_letolt_xlsx($backup_ver_id,$tipus,$ev,$ho){
$eredmeny_keres='';

//$ev=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ev');ó
//$ho=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ho');

//$backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_ver_id);
$tipus=mysqli_real_escape_string($GLOBALS['mysqli'],$tipus);

//backup_adat_".$ev."_teny_3.rogzitett_teny3_ora,
//backup_adat_".$ev."_teny_3.rogzitett_teny3_perc,
$sql="SELECT 

backup_adat_".$ev."_teny_3.projekt_tervkod,
backup_adat_".$ev."_teny_3.projekt_tagv_kod,
backup_adat_".$ev."_teny_3.projekt_szolg_kod,
backup_adat_".$ev."_teny_3.rogzitett_teny3_ora_egesz,

backup_terv.backup_terv_osszeg

FROM `backup_adat_".$ev."_teny_3` 

left join backup_terv ON backup_terv.backup_terv_tervkod = backup_adat_".$ev."_teny_3.projekt_tervkod
	and backup_terv.backup_terv_ev = '".$ev."'
	and backup_terv.backup_terv_ho = '".$ho."'
	and backup_terv.backup_terv_tipus_id ='".$tipus."' 

where
backup_adat_".$ev."_teny_3.backup_ver_id='".$backup_ver_id."'
order by backup_adat_".$ev."_teny_3.projekt_tagv_kod asc";

 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }

return $eredmeny_keres;
}

function keress_terv3_elteres_szolg_kod_lista(){
$eredmeny_keres='';
 $sql="SELECT 
 backup_szolg_kod.szolg_kod,
 backup_szolg_kod.szolg_kod_nev
 FROM `backup_szolg_kod` ";
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szolg_kod']]=$adatom['szolg_kod_nev'];
 }
 return $eredmeny_keres;
}

function keress_terv3_elteres_tagv_kod_lista(){
$eredmeny_keres='';
 $sql="SELECT 
 backup_tagv_kod.tagv_kod,
 backup_tagv_kod.tagv_kod_nev
 FROM `backup_tagv_kod` ";

 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['tagv_kod']]=$adatom['tagv_kod_nev'];
 }
 return $eredmeny_keres;
}
?>