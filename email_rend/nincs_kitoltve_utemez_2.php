<?php

/* 2. tipus
-	3 munkanappal a hó vége előtt
-	60%-nál kevesebbet töltött
-	Jóváhagyó másolatban: Nem
*/

//error_reporting(0);
//ini_set('display_errors',"0");
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('error_reporting', E_ALL);
include_once('../config_uj.php');
include_once('nincs_kitoltve_func.php');
set_time_limit(120);
ini_set('memory_limit','1024M');
ini_set('max_execution_time', '120');

$munkanap_hovege_elott='3';

$oszegzes_kuld='1';
$cimzes_oszegzes_kuld_kinek=array();
//$cimzes_oszegzes_kuld_kinek[0]['nev']='mira-mvms';
$cimzes_oszegzes_kuld_kinek[0]['nev']=$GLOBALS['rend_email_auto_osszegzes_email'];
//$cimzes_oszegzes_kuld_kinek[0]['email']='mira-mvms@mvm.hu';
$cimzes_oszegzes_kuld_kinek[0]['email']=$GLOBALS['rend_email_auto_osszegzes_email'];

$ev=date("Y",time());//01 hó
$ho=date("n",time());//m 01 hó n 1-12ó
$nap=date("j",time());//d(01) helyett j(1)

//Teszteléshez

$munkanap_hovege_elott='3';
$ev='2024';
$ho='7';
$nap='29';


$tomb=keres_nincs_kitoltve_alapadat($ev,$ho,$nap);
$tomb2_munkanap_user=keres_nincs_kitoltve_kitoltheto($ev,$ho);//User munkanap áthelyezései
$tomb3_munkanap_global=keres_munkanap_ho_athelyezesek($ev,$ho);//Globális munkanap áthelyezések

$tomb6_user_max=keres_user_max($ev,$ho,$nap,$tomb,$tomb2_munkanap_user,$tomb3_munkanap_global);

$vissza_munkanap=keres_vissza_munkanap($ev,$ho,$nap,$tomb3_munkanap_global);

/*
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<pre>';
print_r($tomb6_user_max);
echo '</pre>';
exit;
*/

if(($vissza_munkanap==$munkanap_hovege_elott)and(keres_ma_munkanape($ev,$ho,$nap,$tomb3_munkanap_global))){
//Levél küldés annak, akinek a kitöltése kevesebb mint 60%

$tomb_osszegzes='';
$ik=0;
if(is_array($tomb6_user_max)){
 foreach($tomb6_user_max as $user_ad => $ert){
  $kulonbseg_ora=$ert['munkaido']-$ert['ora'];
  $kulonbseg_szazalek=round((($ert['ora']/$ert['munkaido'])*100),2);
   if(
    ($ert['munkaido']>'0')and
	($kulonbseg_szazalek<60)and
    (isset($ert['nev']))and
    (isset($ert['email']))and
    ($ert['nev']!='')and
    ($ert['email']!='')
   ){//aki kevesebbet töltött mint 60%
     $cimzes=array();
     $cimzes[0]['nev']=$ert['nev'];
     $cimzes[0]['email']=$ert['email'];
	 
	//echo '<pre>';
	//print_r($cimzes);
	//echo '</pre>';
   
   	$cimzes[0]['nev']='Nagy Imre';
    $cimzes[0]['email']='konto.nagy.imre@mvm.hu';
	
	$cimtargy="MIRA ".mb_strtolower(ho_ki($ho))." hónap időadat töltési kötelezettség - figyelemfelhívó üzenet";
	$level_html="Kedves ".$cimzes[0]['nev']."!";
    $level_html.="<br><br>Adatbázisunk alapján ".mb_strtolower(ho_ki($ho))." havi időadatrögzítésed nem éri el a szükséges töltöttség 60%-át a <a href='".$GLOBALS['url']."'>".$GLOBALS['rend_nev'].$GLOBALS['tesztdevmod']."</a> rendszerben.";
    $level_html.="<br><br>Szeretnénk felhívni a figyelmed, hogy a MIRA időadat töltésre vonatkozó belső szabályzatunk alapján törekedni szükséges a rendszeres időadatrögzítésre, mely a hónap lezárásának közeledtével kiemelten fontos.";
	
	mail_passrec_uj_auto($cimtargy,$cimzes,'',$level_html,"",'1');
	exit;
	
	 //Összegzéshez adat.
     $ik++;
     if(!is_array($tomb_osszegzes))$tomb_osszegzes=array();
     $tomb_osszegzes[$ik]['ad']=$user_ad;
     $tomb_osszegzes[$ik]['nev']=$ert['nev'];
     $tomb_osszegzes[$ik]['email']=$ert['email'];
     $tomb_osszegzes[$ik]['kulonbseg_szazalek']=$kulonbseg_szazalek;
   }
 }
}

//Összegzés küldése - eleje
if(is_array($tomb_osszegzes)){
 $level_html='Automata email értesítés (típus 2) kiküldésre került az alábbi felhasználóknak, mert a rögzített munkaidejük kevesebb mint 60%!<br><br>';
 $level_html.='<table border=0 class="table_emre">';
 $level_html.='<thead><tr>';
 $level_html.='<th>Sorszám';
 $level_html.='<th>Név';
 $level_html.='<th>AD azonosító';
 $level_html.='<th>Rögzített óra arány';
 $level_html.='<th>Email cím';
 $level_html.='</tr></thead><tbody>';
foreach($tomb_osszegzes as $szam => $ert){
 $level_html.='<tr>';
 $level_html.='<td>'.$szam;
 $level_html.='<td>'.$ert['nev'];
 $level_html.='<td>'.$ert['ad'];
 $level_html.='<td>'.$ert['kulonbseg_szazalek'].'%';
 $level_html.='<td>'.$ert['email'];
 $level_html.='</tr>';
}
 $level_html.='</table>';
 mail_passrec_uj_auto('Automata email értesítés (típus 2) lefutott',$cimzes_oszegzes_kuld_kinek,'',$level_html,"",'1');
}else{//Nincs mit
 $level_html='Automata email értesítés <b>nem</b> került kiküldésre, mert minden felhasználó rögzített legalább 60%-t!';
 mail_passrec_uj_auto('Automata email értesítés (típus 2) lefutott',$cimzes_oszegzes_kuld_kinek,'',$level_html,"",'1');
}
//Összegzés küldése - vége
}

?>