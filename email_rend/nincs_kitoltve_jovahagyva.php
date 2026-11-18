<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('error_reporting', E_ALL);
include_once('../config_uj.php');
include_once('nincs_kitoltve_func.php');

$ev='2024';
$ho='2';

$tomb=keres_nincs_jovahagyva_alapadat($ev,$ho,'31');//Akinek nincs jóváhagyva

$tomb4_jovahagyok_fel=keres_nincs_kitoltve_jovhagyok_fel();
$tomb5_jovahagyok_szerv=keres_nincs_kitoltve_jovhagyok_szerv();

/*
echo '<br>';
echo '<pre>';
print_r($tomb4_jovahagyok_fel);
echo '</pre>';
exit;
*/

if(is_array($tomb)){
foreach($tomb as $user_ad => $ert){

	 echo $user_ad;
	 echo ';';
	 echo $ert['nev'];
	 echo ';';
	 echo $ert['lezarva'];//lezarva
	 echo ';';
	 
	 if(
	 (isset($tomb4_jovahagyok_fel[$user_ad]))and
	 (is_array($tomb4_jovahagyok_fel[$user_ad]))
	 ){
		$tomb_jova=$tomb4_jovahagyok_fel[$user_ad];
	 }elseif(
	 (isset($tomb5_jovahagyok_szerv[$user_ad]))and
	 (is_array($tomb5_jovahagyok_szerv[$user_ad]))
	 ){
		$tomb_jova=$tomb5_jovahagyok_szerv[$user_ad];
	 }
	 
	 print_r($tomb_jova);
	 echo '<br>';
	 
}
}

?>