<?php

ini_set("pcre.jit","0");
ini_set('max_execution_time', '60');
ini_set('memory_limit','3G');
require_once "simplexlsx/xlsx_simplegen.php";

function terv1_letolt_xlsx(){
$tomb=keress_terv1_letolt_xlsx($_POST['backup_ver_id']);

$i=0;
$adat[$i][]='<b>'."Név".'</b>';
$adat[$i][]='<b>'."AD azonosító".'</b>';
$adat[$i][]='<b>'."Összesen egész óra".'</b>';
$adat[$i][]='<b>'."Összesen óra".'</b>';
$adat[$i][]='<b>'."Összesen perc".'</b>';

foreach($tomb as $ert){
 $i++;
 $adat[$i][]=$ert['user_nev'];
 $adat[$i][]=$ert['user_ad'];
 $adat[$i][]=$ert['rogzitett_teny1_ora_egesz'];
 $adat[$i][]=$ert['rogzitett_teny1_ora'];
 $adat[$i][]=$ert['rogzitett_teny1_perc'];
}
unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Teny1 '.$date.'.xlsx';
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Tény1 export');
unset($adat);
$xlsx->downloadAs(rawurlencode($filename));
}

function terv2_letolt_xlsx(){
$tomb=keress_terv2_letolt_xlsx($_POST['backup_ver_id']);

$i=0;
$adat[$i][]='<b>'."Szervezet neve".'</b>';
$adat[$i][]='<b>'."Statisztika költséghely".'</b>';
$adat[$i][]='<b>'."Összesen egész óra".'</b>';
$adat[$i][]='<b>'."Összesen óra".'</b>';
$adat[$i][]='<b>'."Összesen perc".'</b>';

foreach($tomb as $ert){
 $i++;
 $adat[$i][]=$ert['szerv_nev'];
 $adat[$i][]=$ert['szerv_koltsegkod'];
 $adat[$i][]=$ert['rogzitett_teny2_ora_egesz'];
 $adat[$i][]=$ert['rogzitett_teny2_ora'];
 $adat[$i][]=$ert['rogzitett_teny2_perc'];
}
unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Teny2 '.$date.'.xlsx';
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Tény2 export');
unset($adat);
$xlsx->downloadAs(rawurlencode($filename));
}

function terv3_1_letolt_xlsx(){
$tomb=keress_terv3_1_letolt_xlsx($_POST['backup_ver_id']);

$i=0;
$adat[$i][]='<b>'."Felhasználó neve".'</b>';
$adat[$i][]='<b>'."Szervezet neve".'</b>';
$adat[$i][]='<b>'."Törzsszám".'</b>';
$adat[$i][]='<b>'."AD azonosító".'</b>';
$adat[$i][]='<b>'."Tevékenység neve".'</b>';
$adat[$i][]='<b>'."Társaság kód".'</b>';
$adat[$i][]='<b>'."Tevékenység kód".'</b>';
$adat[$i][]='<b>'."Szervezet Tevékenység kód".'</b>';
$adat[$i][]='<b>'."Aktuális tevékenység kód".'</b>';
$adat[$i][]='<b>'."Összesen egész óra".'</b>';
$adat[$i][]='<b>'."Összesen óra".'</b>';
$adat[$i][]='<b>'."Összesen perc".'</b>';

foreach($tomb as $ert){
 $i++;
 $adat[$i][]=$ert['user_nev'];
 $adat[$i][]=$ert['szerv_nev'];
 $adat[$i][]=$ert['user_tsz'];
 $adat[$i][]=$ert['user_ad'];
 $adat[$i][]=$ert['projekt_nev'];
 $adat[$i][]=$ert['projekt_tagv_kod'];
 $adat[$i][]=$ert['projekt_szolg_kod'];
 $adat[$i][]=$ert['szerv_szolg_kod'];
 
 //Aktuális tevékenyésg kód
 if($ert['projekt_szolg_kod']=='')
	 $adat[$i][]=$ert['szerv_szolg_kod'];
 else $adat[$i][]=$ert['projekt_szolg_kod'];
 
 $adat[$i][]=$ert['rogzitett_teny3_ora_egesz'];
 $adat[$i][]=$ert['rogzitett_teny3_ora'];
 $adat[$i][]=$ert['rogzitett_teny3_perc'];
}
unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Teny3_1 '.$date.'.xlsx';
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Tény3.1 export');
unset($adat);
$xlsx->autoFilter('A1:L1');
$xlsx->downloadAs(rawurlencode($filename));
}

function terv3_1_1_letolt_xlsx(){
$tomb=keress_terv3_1_1_letolt_xlsx($_POST['backup_ver_id']);
$tomb_tagv=keress_terv_tagvkod_nev($_POST['backup_ver_id']);
$tomb_szolgkod=keress_terv_szolgkod_nev($_POST['backup_ver_id']);

$i=0;
$adat[$i][]='<b>'."Felhasználó neve".'</b>';
$adat[$i][]='<b>'."Szervezet neve".'</b>';
$adat[$i][]='<b>'."Törzsszám".'</b>';
$adat[$i][]='<b>'."AD azonosító".'</b>';
$adat[$i][]='<b>'."Tevékenység neve".'</b>';
$adat[$i][]='<b>'."Társaság kód".'</b>';
$adat[$i][]='<b>'."Társaság neve".'</b>';
$adat[$i][]='<b>'."Tevékenység kód".'</b>';
$adat[$i][]='<b>'."Szervezet Tevékenység kód".'</b>';
$adat[$i][]='<b>'."Aktuális tevékenység kód".'</b>';
$adat[$i][]='<b>'."Aktuális tevékenység kód neve".'</b>';
$adat[$i][]='<b>'."SAP SM kód".'</b>';
$adat[$i][]='<b>'."Összesen egész óra".'</b>';
$adat[$i][]='<b>'."Összesen óra".'</b>';
$adat[$i][]='<b>'."Összesen perc".'</b>';

foreach($tomb as $ert){
 $i++;
 $adat[$i][]=$ert['user_nev'];
 $adat[$i][]=$ert['szerv_nev'];
 $adat[$i][]=$ert['user_tsz'];
 $adat[$i][]=$ert['user_ad'];
 $adat[$i][]=$ert['projekt_nev'];
 $adat[$i][]=$ert['projekt_tagv_kod'];
 
 if(isset($tomb_tagv[$ert['projekt_tagv_kod']]))
  $adat[$i][]=$tomb_tagv[$ert['projekt_tagv_kod']];//tagv_kod_nev
 else
  $adat[$i][]='';

 $adat[$i][]=$ert['projekt_szolg_kod'];
 $adat[$i][]=$ert['szerv_szolg_kod'];
 
 //Aktuális tevékenyésg kód
 if($ert['projekt_szolg_kod']==''){
	 $adat[$i][]=$ert['szerv_szolg_kod'];
	 
	 if(isset($tomb_szolgkod[$ert['szerv_szolg_kod']]))
	  $adat[$i][]=$tomb_szolgkod[$ert['szerv_szolg_kod']];
	 else
	  $adat[$i][]='';
  
 }else{
	 $adat[$i][]=$ert['projekt_szolg_kod'];
	  
	 if(isset($tomb_szolgkod[$ert['projekt_szolg_kod']]))
	  $adat[$i][]=$tomb_szolgkod[$ert['projekt_szolg_kod']];
	 else
	  $adat[$i][]='';
 }
 
 //SAP SM kód
 $adat[$i][]=$ert['szerv_sm_kod'];
 
 $adat[$i][]=$ert['rogzitett_teny3_ora_egesz'];
 $adat[$i][]=$ert['rogzitett_teny3_ora'];
 $adat[$i][]=$ert['rogzitett_teny3_perc'];
}
unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Teny3_1_1 '.$date.'.xlsx';
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Tény3.1.1 export');
unset($adat);
$xlsx->autoFilter('A1:L1');
$xlsx->downloadAs(rawurlencode($filename));
}

function terv3_3_letolt_xlsx(){
$tomb=keress_terv3_3_letolt_xlsx($_POST['backup_ver_id']);
$tomb_tagv=keress_terv_tagvkod_nev($_POST['backup_ver_id']);
$tomb_szolgkod=keress_terv_szolgkod_nev($_POST['backup_ver_id']);

$i=0;
$adat[$i][]='<b>'."Tevékenység neve".'</b>';
$adat[$i][]='<b>'."Tásaság kód".'</b>';
$adat[$i][]='<b>'."Tásaság neve".'</b>';
$adat[$i][]='<b>'."Tevékenység kód".'</b>';

$adat[$i][]='<b>'."Összesen egész óra".'</b>';
$adat[$i][]='<b>'."Összesen óra".'</b>';
$adat[$i][]='<b>'."Összesen perc".'</b>';

foreach($tomb as $ert){
 $i++;
 $adat[$i][]=$ert['projekt_nev'];
 $adat[$i][]=$ert['projekt_tagv_kod'];
 
 if(isset($tomb_tagv[$ert['projekt_tagv_kod']]))
  $adat[$i][]=$tomb_tagv[$ert['projekt_tagv_kod']];//tagv_kod_nev
 else
  $adat[$i][]='';
 
 $adat[$i][]=$ert['projekt_szolg_kod'];

 
 $adat[$i][]=$ert['rogzitett_teny3_ora_egesz'];
 $adat[$i][]=$ert['rogzitett_teny3_ora'];
 $adat[$i][]=$ert['rogzitett_teny3_perc'];
}
unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Teny3_3 '.$date.'.xlsx';
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Tény3.2 export');
unset($adat);
$xlsx->autoFilter('A1:G1');
$xlsx->downloadAs(rawurlencode($filename));
}

function terv3_2_letolt_xlsx(){
$tomb=keress_terv3_2_letolt_xlsx($_POST['backup_ver_id']);
$tomb_tagv=keress_terv_tagvkod_nev($_POST['backup_ver_id']);
$tomb_szolgkod=keress_terv_szolgkod_nev($_POST['backup_ver_id']);

$i=0;
$adat[$i][]='<b>'."Szervezet neve".'</b>';
$adat[$i][]='<b>'."Tevékenység neve".'</b>';
$adat[$i][]='<b>'."Tásaság kód".'</b>';
$adat[$i][]='<b>'."Tásaság neve".'</b>';
$adat[$i][]='<b>'."Tevékenység kód".'</b>';
$adat[$i][]='<b>'."Szervezet Tevékenység kód".'</b>';
$adat[$i][]='<b>'."Aktuális tevékenység kód".'</b>';
$adat[$i][]='<b>'."Aktuális tevékenység kód neve".'</b>';
$adat[$i][]='<b>'."SAP SM kód".'</b>';
$adat[$i][]='<b>'."Összesen egész óra".'</b>';
$adat[$i][]='<b>'."Összesen óra".'</b>';
$adat[$i][]='<b>'."Összesen perc".'</b>';

foreach($tomb as $ert){
 $i++;
 $adat[$i][]=$ert['szerv_nev'];
 $adat[$i][]=$ert['projekt_nev'];
 $adat[$i][]=$ert['projekt_tagv_kod'];
 
 if(isset($tomb_tagv[$ert['projekt_tagv_kod']]))
  $adat[$i][]=$tomb_tagv[$ert['projekt_tagv_kod']];//tagv_kod_nev
 else
  $adat[$i][]='';
 
 $adat[$i][]=$ert['projekt_szolg_kod'];
 $adat[$i][]=$ert['szerv_szolg_kod'];
 
 //Aktuális tevékenyésg kód
 if($ert['projekt_szolg_kod']==''){
	 $adat[$i][]=$ert['szerv_szolg_kod'];
	 
	 if(isset($tomb_szolgkod[$ert['szerv_szolg_kod']]))
	  $adat[$i][]=$tomb_szolgkod[$ert['szerv_szolg_kod']];
	 else
	  $adat[$i][]='';
  
 }else{
	 $adat[$i][]=$ert['projekt_szolg_kod'];
	 
	 if(isset($tomb_szolgkod[$ert['projekt_szolg_kod']]))
	  $adat[$i][]=$tomb_szolgkod[$ert['projekt_szolg_kod']];
	 else
	  $adat[$i][]='';
 }
 
 //SAP SM kód
 $adat[$i][]=$ert['szerv_sm_kod'];
 
 $adat[$i][]=$ert['rogzitett_teny3_ora_egesz'];
 $adat[$i][]=$ert['rogzitett_teny3_ora'];
 $adat[$i][]=$ert['rogzitett_teny3_perc'];
}
unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Teny3_2 '.$date.'.xlsx';
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Tény3.2 export');
unset($adat);
$xlsx->autoFilter('A1:I1');
$xlsx->downloadAs(rawurlencode($filename));
}

function terv3_letolt_xlsx(){
$tomb=keress_terv3_letolt_xlsx($_POST['backup_ver_id'],$_POST['tipus']);
$tomb_tagv=keress_terv3_tagv_kod_lista($_POST['backup_ver_id']);
$tomb_szolg=keress_terv3_szolg_kod_lista($_POST['backup_ver_id']);

$hatar_also=$_POST['hatar_also'];
$hatar_felso=$_POST['hatar_felso'];

$i=0;
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

foreach($tomb as $ert){
 $i++;
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
unset($tomb);

$date=date("Y_m_d-H_i_s",time());
$filename='Teny3 '.$date.'.xlsx';
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Tény3 export');
unset($adat);
$xlsx->autoFilter('F1:G1');
$xlsx->downloadAs(rawurlencode($filename));
}

function keress_terv1_letolt_xlsx($backup_ver_id){
$eredmeny_keres='';
$ev=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ev');
$backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_ver_id);
$sql="SELECT 

backup_user.user_nev,
backup_user.user_ad,
backup_adat_".$ev."_teny_1.rogzitett_teny1_ora_egesz,
backup_adat_".$ev."_teny_1.rogzitett_teny1_ora,
backup_adat_".$ev."_teny_1.rogzitett_teny1_perc

FROM `backup_adat_".$ev."_teny_1` 
inner join backup_user ON backup_user.backup_user_id = backup_adat_".$ev."_teny_1.backup_user_id
where
backup_adat_".$ev."_teny_1.backup_ver_id='".$backup_ver_id."'
order by backup_user.user_nev asc";

 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }

return $eredmeny_keres;
}

function keress_terv2_letolt_xlsx($backup_ver_id){
$eredmeny_keres='';
$ev=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ev');
$backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_ver_id);
$sql="SELECT 

backup_szerv.szerv_nev,
backup_szerv.szerv_koltsegkod,
backup_adat_".$ev."_teny_2.rogzitett_teny2_ora_egesz,
backup_adat_".$ev."_teny_2.rogzitett_teny2_ora,
backup_adat_".$ev."_teny_2.rogzitett_teny2_perc

FROM `backup_adat_".$ev."_teny_2` 
inner join backup_szerv ON backup_szerv.backup_szerv_id = backup_adat_".$ev."_teny_2.backup_szerv_id
where
backup_adat_".$ev."_teny_2.backup_ver_id='".$backup_ver_id."'
order by backup_szerv.szerv_nev asc";

 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }

return $eredmeny_keres;
}

function keress_terv3_1_letolt_xlsx($backup_ver_id){
$eredmeny_keres='';
$ev=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ev');
$backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_ver_id);

$sql="SELECT 
backup_user.user_nev,
backup_user.user_tsz,
backup_user.user_ad,
backup_szerv.szerv_nev,
backup_adat_".$ev."_teny_3_1.rogzitett_teny3_ora_egesz,
backup_adat_".$ev."_teny_3_1.rogzitett_teny3_ora,
backup_adat_".$ev."_teny_3_1.rogzitett_teny3_perc,
backup_pojekt.projekt_nev,
backup_pojekt.projekt_tagv_kod,
backup_pojekt.projekt_szolg_kod,
backup_szerv.szerv_szolg_kod
FROM `backup_adat_".$ev."_teny_3_1` 
left join backup_user ON backup_user.backup_user_id = backup_adat_".$ev."_teny_3_1.backup_user_id
left join backup_szerv ON backup_szerv.backup_szerv_id  = backup_adat_".$ev."_teny_3_1.backup_szerv_id 
left join backup_pojekt ON backup_pojekt.backup_pojekt_id = backup_adat_".$ev."_teny_3_1.backup_pojekt_id
where
backup_adat_".$ev."_teny_3_1.backup_ver_id='".$backup_ver_id."'
order by backup_user.user_nev asc ";

 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }

return $eredmeny_keres;
}

function keress_terv_tagvkod_nev($backup_ver_id){
$eredmeny_keres='';
$backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_ver_id);
$sql="SELECT 
backup_tagv_kod.tagv_kod,
backup_tagv_kod.tagv_kod_nev
FROM `backup_tagv_kod`
where
backup_tagv_kod.backup_ver_id = '".$backup_ver_id."'
";
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['tagv_kod']]=$adatom['tagv_kod_nev'];
 }
return $eredmeny_keres;
}

function keress_terv_szolgkod_nev($backup_ver_id){
$eredmeny_keres='';
$backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_ver_id);
$sql="SELECT 
backup_szolg_kod.szolg_kod,
backup_szolg_kod.szolg_kod_nev
FROM `backup_szolg_kod`
where
backup_szolg_kod.backup_ver_id = '".$backup_ver_id."'
";
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szolg_kod']]=$adatom['szolg_kod_nev'];
 }
return $eredmeny_keres;
}

function keress_terv3_1_1_letolt_xlsx($backup_ver_id){
$eredmeny_keres='';
$ev=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ev');
$backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_ver_id);

//backup_tagv_kod.tagv_kod_nev,
//left join backup_tagv_kod ON backup_tagv_kod.tagv_kod = backup_pojekt.projekt_tagv_kod and backup_tagv_kod.backup_ver_id = '".$backup_ver_id."' 

//backup_szolg_kod.szolg_kod_nev as projekt_szolg_kod_nev,
//backup_szolg_kod_szerv.szolg_kod_nev as szerv_szolg_kod_nev
//left join backup_szolg_kod ON backup_szolg_kod.szolg_kod = backup_pojekt.projekt_szolg_kod and backup_tagv_kod.backup_ver_id = '".$backup_ver_id."' 
//left join backup_szolg_kod as backup_szolg_kod_szerv ON backup_szolg_kod_szerv.szolg_kod = backup_szerv.szerv_szolg_kod and backup_tagv_kod.backup_ver_id = '".$backup_ver_id."' 


$sql="SELECT 
backup_user.user_nev,
backup_user.user_tsz,
backup_user.user_ad,
backup_szerv.szerv_nev,
backup_adat_".$ev."_teny_3_1_1.rogzitett_teny3_ora_egesz,
backup_adat_".$ev."_teny_3_1_1.rogzitett_teny3_ora,
backup_adat_".$ev."_teny_3_1_1.rogzitett_teny3_perc,
backup_pojekt.projekt_nev,
backup_pojekt.projekt_tagv_kod,
backup_pojekt.projekt_szolg_kod,
backup_szerv.szerv_szolg_kod,
backup_szerv.szerv_sm_kod

FROM `backup_adat_".$ev."_teny_3_1_1` 
left join backup_user ON backup_user.backup_user_id = backup_adat_".$ev."_teny_3_1_1.backup_user_id
left join backup_szerv ON backup_szerv.backup_szerv_id  = backup_adat_".$ev."_teny_3_1_1.backup_szerv_id 
left join backup_pojekt ON backup_pojekt.backup_pojekt_id = backup_adat_".$ev."_teny_3_1_1.backup_pojekt_id


where
backup_adat_".$ev."_teny_3_1_1.backup_ver_id='".$backup_ver_id."'
order by backup_user.user_nev asc ";

 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }

return $eredmeny_keres;
}

function keress_terv3_3_letolt_xlsx($backup_ver_id){
$eredmeny_keres='';
$ev=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ev');
$backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_ver_id);
$sql="SELECT 

backup_pojekt.projekt_nev,
backup_pojekt.projekt_tagv_kod,
backup_pojekt.projekt_szolg_kod,
backup_adat_".$ev."_teny_3_3.rogzitett_teny3_ora_egesz,
backup_adat_".$ev."_teny_3_3.rogzitett_teny3_ora,
backup_adat_".$ev."_teny_3_3.rogzitett_teny3_perc

FROM `backup_adat_".$ev."_teny_3_3` 
left join backup_pojekt ON backup_pojekt.backup_pojekt_id = backup_adat_".$ev."_teny_3_3.backup_pojekt_id
where
backup_adat_".$ev."_teny_3_3.backup_ver_id='".$backup_ver_id."'
order by backup_pojekt.projekt_nev asc ";

 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }

return $eredmeny_keres;
}

function keress_terv3_2_letolt_xlsx($backup_ver_id){
$eredmeny_keres='';
$ev=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ev');
$backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_ver_id);
$sql="SELECT 

backup_szerv.szerv_nev,
backup_pojekt.projekt_nev,
backup_pojekt.projekt_tagv_kod,
backup_pojekt.projekt_szolg_kod,
backup_szerv.szerv_szolg_kod,
backup_szerv.szerv_sm_kod,
backup_adat_".$ev."_teny_3_2.rogzitett_teny3_ora_egesz,
backup_adat_".$ev."_teny_3_2.rogzitett_teny3_ora,
backup_adat_".$ev."_teny_3_2.rogzitett_teny3_perc

FROM `backup_adat_".$ev."_teny_3_2` 
left join backup_szerv ON backup_szerv.backup_szerv_id = backup_adat_".$ev."_teny_3_2.backup_szerv_id
left join backup_pojekt ON backup_pojekt.backup_pojekt_id = backup_adat_".$ev."_teny_3_2.backup_pojekt_id
where
backup_adat_".$ev."_teny_3_2.backup_ver_id='".$backup_ver_id."'
order by backup_szerv.szerv_nev asc ";

 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }

return $eredmeny_keres;
}

function keress_terv3_szolg_kod_lista($backup_ver_id){
$eredmeny_keres='';
$backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_ver_id);
 $sql="SELECT 
 backup_szolg_kod.szolg_kod,
 backup_szolg_kod.szolg_kod_nev
 FROM `backup_szolg_kod` 
 where backup_szolg_kod.backup_ver_id='".$backup_ver_id ."'";

 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szolg_kod']]=$adatom['szolg_kod_nev'];
 }
 return $eredmeny_keres;
}

function keress_terv3_tagv_kod_lista($backup_ver_id){
$eredmeny_keres='';
$backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_ver_id);
 $sql="SELECT 
 backup_tagv_kod.tagv_kod,
 backup_tagv_kod.tagv_kod_nev
 FROM `backup_tagv_kod` 
 where backup_tagv_kod.backup_ver_id='".$backup_ver_id ."'";

 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['tagv_kod']]=$adatom['tagv_kod_nev'];
 }
 return $eredmeny_keres;
}

function keress_terv3_letolt_xlsx($backup_ver_id,$tipus){
$eredmeny_keres='';
$ev=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ev');
$ho=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ho');
$backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_ver_id);
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




function terv_projekt_le(){
//Adott $_POST['backup_ver_id'] -hez tartozó tevékenységeket szedi le
$tomb=keress_terv_projekt_le($_POST['backup_ver_id']);

$i=0;
$adat[$i][]='<b>'."ID".'</b>';
$adat[$i][]='<b>'."Tevékenység neve".'</b>';
$adat[$i][]='<b>'."Társasági SAP kód".'</b>';
$adat[$i][]='<b>'."Tevékenységek szolgáltatás kód".'</b>';
$adat[$i][]='<b>'."Inaktiv".'</b>';

if(is_array($tomb)){
foreach($tomb as $ert){
 $i++;
 $adat[$i][]=$ert['projekt_id'];
 $adat[$i][]=$ert['projekt_nev'];
 $adat[$i][]=$ert['projekt_tagv_kod'];
 $adat[$i][]=$ert['projekt_szolg_kod'];
 $adat[$i][]=igennem_kod_ki($ert['projekt_inaktiv']);
}
}

unset($tomb);

$tomb=keres_mit1('backup_ver','backup_ver_id',$_POST['backup_ver_id']);
$filename='Tevékenység lista '.$tomb[0]['backup_ver_ev_ho'].' ver'.$tomb[0]['backup_ver_ver'].'.xlsx';
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Tevékenység lista '.$tomb[0]['backup_ver_ev_ho']);
unset($adat);
//$xlsx->autoFilter('A1:E1');
$xlsx->downloadAs(rawurlencode($filename));

}

function keress_terv_projekt_le($backup_ver_id){
$eredmeny_keres='';
$backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_ver_id);

$sql="SELECT 
backup_pojekt.projekt_id,
backup_pojekt.projekt_nev,
backup_pojekt.projekt_tagv_kod,
backup_pojekt.projekt_szolg_kod,
backup_pojekt.projekt_inaktiv
FROM `backup_pojekt` 
where
backup_pojekt.backup_ver_id ='".$backup_ver_id."'
order by backup_pojekt.projekt_nev asc
";
 //print $sql."<br>";exit;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }

return $eredmeny_keres;
}



function terv_projektszetbont_le(){
//Adott $_POST['backup_ver_id'] -hez tartozó tevékenység szétbontásokat szedi le
$tomb=keress_terv_projektszetbont_le($_POST['backup_ver_id']);

$i=0;
$adat[$i][]='<b>'."Miről Tevékenység ID".'</b>';
$adat[$i][]='<b>'."Miről Tevékenység Név".'</b>';
$adat[$i][]='<b>'."Mire Tevékenység ID".'</b>';
$adat[$i][]='<b>'."Mire Tevékenység Név".'</b>';
$adat[$i][]='<b>'."Arány".'</b>';

if(is_array($tomb)){
foreach($tomb as $ert){
 $i++;
 $adat[$i][]=$ert['projekt_id'];
 $adat[$i][]=$ert['projekt_nev'];
 $adat[$i][]=$ert['mire_projekt_id'];
 $adat[$i][]=$ert['mire_projekt_nev'];
 $adat[$i][]=$ert['szetbont_arany'];
}
}

unset($tomb);

$tomb=keres_mit1('backup_ver','backup_ver_id',$_POST['backup_ver_id']);
$filename='Tevékenység szétbontás adatok '.$tomb[0]['backup_ver_ev_ho'].' ver'.$tomb[0]['backup_ver_ver'].'.xlsx';
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Tevékenység szétbontás adatok');
unset($adat);
//$xlsx->autoFilter('A1:E1');
$xlsx->downloadAs(rawurlencode($filename));

}

function keress_terv_projektszetbont_le($backup_ver_id){
$eredmeny_keres='';
$backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_ver_id);

$sql="SELECT 
backup_pojekt.projekt_id,
backup_pojekt.projekt_nev,
szetbont_backup_pojekt.projekt_id as mire_projekt_id,
szetbont_backup_pojekt.projekt_nev as mire_projekt_nev,
backup_projekt_szetbontas.szetbont_arany

FROM `backup_projekt_szetbontas` 
inner join backup_pojekt ON backup_pojekt.backup_pojekt_id = backup_projekt_szetbontas.backup_pojekt_id
inner join backup_pojekt AS szetbont_backup_pojekt ON szetbont_backup_pojekt.backup_pojekt_id = backup_projekt_szetbontas.szetbont_backup_pojekt_id 
where
backup_projekt_szetbontas.backup_ver_id ='".$backup_ver_id."'
";
 //print $sql."<br>";exit;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }

return $eredmeny_keres;
}

function terv_betoltominta_szetbontas(){
$i=0;
$adat[$i][]='<b>'."Miről Tevékenység ID".'</b>';
$adat[$i][]='<b>'."Mire Tevékenység ID".'</b>';
$adat[$i][]='<b>'."Arány".'</b>';

 $i=1;
 $adat[$i][]='1';
 $adat[$i][]='2';
 $adat[$i][]='20,0001';
 
 $i=2;
 $adat[$i][]='1';
 $adat[$i][]='3';
 $adat[$i][]='80,0002';
$filename='Tevékenység szétbontás minta betöltő.xlsx';
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Tevékenység szétbontás minta');
unset($adat);
$xlsx->downloadAs(rawurlencode($filename));
}

?>