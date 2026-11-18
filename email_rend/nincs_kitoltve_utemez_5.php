<?php

/* 5. tipus
-	2 munkanap
-	Aki nem hagyott jóvá
-	Csak a jóváhagyók kapják meg
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

$munkanap_ho_munkanapjan='2';

$oszegzes_kuld='1';
$cimzes_oszegzes_kuld_kinek=array();
//$cimzes_oszegzes_kuld_kinek[0]['nev']='mira-mvms';
$cimzes_oszegzes_kuld_kinek[0]['nev']=$GLOBALS['rend_email_auto_osszegzes_email'];
//$cimzes_oszegzes_kuld_kinek[0]['email']='mira-mvms@mvm.hu';
$cimzes_oszegzes_kuld_kinek[0]['email']=$GLOBALS['rend_email_auto_osszegzes_email'];

$ev_most=date("Y",time());//01 hó
$ev=date("Y", strtotime("last month"));
$ho_most=date("n",time());//m 01 hó n 1-12
$ho=date("n", strtotime("last month"));
//$nap=date("j",time());//d(01) helyett j(1)
$nap=date('d',mktime(0,0,0,$ho+1,0,$ev));
//Teszteléshez
/*
$munkanap_ho_munkanapjan='2';
$ev_most='2024';
$ev='2024';
$ho_most='6';
$ho='5';
$nap='4';
*/
$tomb=keres_nincs_jovahagyva_alapadat($ev,$ho,'31');//Akinek nincs jóváhagyva
$tomb2_munkanap_user=keres_nincs_kitoltve_kitoltheto($ev,$ho);//User munkanap áthelyezései
$tomb3_munkanap_global=keres_munkanap_ho_athelyezesek($ev_most,$ho_most);//Globális munkanap áthelyezések

$tomb4_jovahagyok_fel=keres_nincs_kitoltve_jovhagyok_fel();
$tomb5_jovahagyok_szerv=keres_nincs_kitoltve_jovhagyok_szerv();

$tomb6_user_max=keres_user_max($ev,$ho,$nap,$tomb,$tomb2_munkanap_user,$tomb3_munkanap_global);

$most_munkanap=keres_most_munkanap($ev_most,$ho_most,$nap,$tomb3_munkanap_global);
/*
echo $nap;
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<pre>';
print_r($tomb6_user_max);
echo '</pre>';
exit;
*/

if(($most_munkanap==$munkanap_ho_munkanapjan)and(keres_ma_munkanape($ev,$ho_most,$nap_ma,$tomb3_munkanap_global))){
//Levél küldés annak, akinek nincs jóváhagyva
$tomb_osszegzes='';
$ik=0;
//if(is_array($tomb)){
// foreach($tomb as $user_ad => $ert){
if(is_array($tomb6_user_max)){
 foreach($tomb6_user_max as $user_ad => $ert){
  
   if(
	($ert['munkaido']>'0')and
	(isset($ert['nev']))and
    ($ert['nev']!='')and
    (
	 (isset($tomb4_jovahagyok_fel[$user_ad]))or
	 (isset($tomb5_jovahagyok_szerv[$user_ad]))
	)
   ){
	
	$cimzes='';
	//Jóváhagyó másolatba - eleje
	 if((isset($tomb4_jovahagyok_fel[$user_ad]))and(is_array($tomb4_jovahagyok_fel[$user_ad]))){
		$cimzes=array();		 
		 $i=0;
		 foreach($tomb4_jovahagyok_fel[$user_ad] as $ert_m){
		  $i++;
		  $cimzes[$i]['nev']=$ert_m['nev'];
		  $cimzes[$i]['email']=$ert_m['email']; 
		 }
	 }elseif((isset($tomb5_jovahagyok_szerv[$user_ad]))and(is_array($tomb5_jovahagyok_szerv[$user_ad]))){
		 $cimzes=array();		 
		 $i=0;
		 foreach($tomb5_jovahagyok_szerv[$user_ad] as $ert_m){
		  $i++;
		  $cimzes[$i]['nev']=$ert_m['nev'];
		  $cimzes[$i]['email']=$ert_m['email']; 
		 } 
	 }
	 //Jóváhagyó másolatba - vége
	
	 //echo '<pre>';
	 //print_r($cimzes);
	 //echo '</pre>';
	 
	 //$cimzes[0]['nev']='Nagy Imre';
     //$cimzes[0]['email']='konto.nagy.imre@mvm.hu';	
	
	if(is_array($cimzes)){
	 //$ert['nev'];
	 //$ert['lezarva'];
	 
	$cimtargy=$GLOBALS['rend_nev'].$GLOBALS['tesztdevmod']." időadat jóváhagyási kötelezettség - figyelemfelhívó üzenet";
	$level_html="Kedves Vezető!";
	$level_html.="<br><br>Szeretnénk felhívni a figyelmed, hogy ".mb_strtolower(ho_ki($ho))." hónap <a href='".$GLOBALS['url']."'>".$GLOBALS['rend_nev'].$GLOBALS['tesztdevmod']."</a> időadatainak jóváhagyására vonatkozó határidő a mai napon jár le.";
	$level_html.="<br><br>Adatbázisunk alapján <b>".$ert['nev']."</b> esetén a jóváhagyás még nem történtek meg. Kérjük, kiemelten figyelj a mai határidő tartására, ezzel is támogatva az MVMS Gazdasági Igazgatóságának munkáját.";
	mail_passrec_uj_auto($cimtargy,$cimzes,'',$level_html,"",'1');
	//exit;
	
	//Összegzéshez adat.
	 $ik++;
     if(!is_array($tomb_osszegzes))$tomb_osszegzes=array();
     $tomb_osszegzes[$ik]['ad']=$user_ad;
     $tomb_osszegzes[$ik]['nev']=$ert['nev'];
     $tomb_osszegzes[$ik]['lezarva']=$ert['lezarva'];
     $tomb_osszegzes[$ik]['jovahagyok']='';
	  foreach($cimzes as $ert_j){
	   if($tomb_osszegzes[$ik]['jovahagyok']!='')$tomb_osszegzes[$ik]['jovahagyok'].=', ';
	   $tomb_osszegzes[$ik]['jovahagyok'].=$ert_j['nev'];
	  }
	}
	 
  }		
 }
}

//Összegzés küldése - eleje
if(is_array($tomb_osszegzes)){
 $level_html='Automata email értesítés (típus 5) kiküldésre került az alábbi jóváhagyókknak, mert nem hagytták jóvá a MIRA-t!<br><br>';
 $level_html.='<table border=0 class="table_emre">';
 $level_html.='<thead><tr>';
 $level_html.='<th>Sorszám';
 $level_html.='<th>Munkavállaló - Név';
 $level_html.='<th>Munkavállaló - AD';
 $level_html.='<th>Lezárva';
 $level_html.='<th>Jóváhagyó(k)';
 $level_html.='</tr></thead><tbody>';
foreach($tomb_osszegzes as $szam => $ert){
 $level_html.='<tr>';
 $level_html.='<td>'.$szam;
 $level_html.='<td>'.$ert['nev'];
 $level_html.='<td>'.$ert['ad'];
 $level_html.='<td>';
 if($ert['lezarva']=='1') $level_html.='Igen';
 $level_html.='<td>'.$ert['jovahagyok'];
 $level_html.='</tr>';
}
 $level_html.='</table>';
 mail_passrec_uj_auto('Automata email értesítés (típus 5) lefutott',$cimzes_oszegzes_kuld_kinek,'',$level_html,"",'1');
}else{//Nincs mit
 $level_html='Automata email értesítés <b>nem</b> került kiküldésre, mert minden jóváhagyó jóváhagyta a MIRA-t!';
 mail_passrec_uj_auto('Automata email értesítés (típus 5) lefutott',$cimzes_oszegzes_kuld_kinek,'',$level_html,"",'1');
}
//Összegzés küldése - vége

}
?>