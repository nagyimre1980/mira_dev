<?php

error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('error_reporting', E_ALL);
include_once('../config_uj.php');
include_once('nincs_kitoltve_func.php');

/*
Ütemezés leírás.
*/


$ev='2024';
$ho='1';
$nap='31';//Nap, amíg számít! Vagyis amelyik nap futtatjuk. Ez a nap már nem számít bele!

$tomb=keres_nincs_kitoltve_alapadat($ev,$ho,$nap);
$tomb2_munkanap_user=keres_nincs_kitoltve_kitoltheto($ev,$ho);//User munkanap áthelyezései
$tomb3_munkanap_global=keres_munkanap_ho_athelyezesek($ev,$ho);//Globális munkanap áthelyezések

$tomb4_jovahagyok_fel=keres_nincs_kitoltve_jovhagyok_fel();
$tomb5_jovahagyok_szerv=keres_nincs_kitoltve_jovhagyok_szerv();

$tomb6_user_max=keres_user_max($ev,$ho,$nap,$tomb,$tomb2_munkanap_user,$tomb3_munkanap_global);

//Hányadik munkanap a hónap végétől. Ha 0, akkor ez az utolsó munkanap. Ha -1, akkor nincs már vissza munkanap
$vissza_munkanap=keres_vissza_munkanap($ev,$ho,$nap,$tomb3_munkanap_global);
//echo 'vissza_munkanap:'.$vissza_munkanap;
//exit;

/*
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<pre>';
print_r($tomb);
echo '</pre>';
exit;
*/
foreach($tomb6_user_max as $user_ad => $ert){
 $kulonbseg_ora=$ert['munkaido']-$ert['ora'];
 $kulonbseg_szazalek=round( (($ert['ora']/$ert['munkaido'])*100),2);
 if($kulonbseg_ora>10){//aki kevesebbet töltött
 //if($kulonbseg_ora<-10){//Aki többet töltőtt
	 echo $user_ad;
	 echo ';';
	 echo $ert['nev'];
	 echo ';';
	 echo $ert['lezarva'];//lezarva
	 echo ';';
	 echo $ert['ora'];//Kitöltott
	 echo ';';
	 echo $ert['munkaido'];//Max
	 echo ';';
	 echo $kulonbseg_szazalek.'%';
	 echo '<br>';
 }
}

?>