<?php

 if(is_array($tomb1_terv)){

  if($_POST['reszlet1terv']=='egybe'){
	  
  foreach($tomb1_terv as $tervkod => $terv_ert){
	if(isset($terv_ert['ho'])){
	$i++;
	/*echo '<pre>';
	print_r($tomb1_terv);
	echo '</pre>';
	exit;*/
	$adat[$i][]=$_POST['ev1'];
	
	$adat[$i][]=$terv_ert['ho'];
	/*
	if($_POST['ho1']=='all')
	 $adat[$i][]='1,2,3,4,5,6,7,8,9,10,11,12';
	else $adat[$i][]=str_replace("#",",",$_POST['ho1']);
	*/
	
	$adat[$i][]=$tervkod;
	
	$adat[$i][]=$terv_ert['tagv_kod'];//Társaság kód
	$adat[$i][]=$terv_ert['tagv_kod_nev'];//Társaság neve
	$adat[$i][]=$terv_ert['szolg_kod'];//tevékenység kód
	$adat[$i][]=$terv_ert['szolg_kod_nev'];//tevékenység kód neve
	
	$adat[$i][]=$terv_ert['osszeg'];
	
	if(($_POST['tipus2']=='terv')and(isset($tomb2_terv[$tervkod]))){
	 $adat[$i][]=$tomb2_terv[$tervkod];
	}
  }
  }
  
  }else{//Havonta
	  foreach($tomb1_terv as $tervkod => $hotomb){
		  
		  foreach($hotomb as $ho => $terv_ert){
		  	$i++;
			$adat[$i][]=$_POST['ev1'];
			$adat[$i][]=$ho;
			$adat[$i][]=$tervkod;
			
			$adat[$i][]=$terv_ert['tagv_kod'];//Társaság kód
			$adat[$i][]=$terv_ert['tagv_kod_nev'];//Társaság neve
			$adat[$i][]=$terv_ert['szolg_kod'];//tevékenység kód
			$adat[$i][]=$terv_ert['szolg_kod_nev'];//tevékenység kód neve
			
			$adat[$i][]=$terv_ert['osszeg'];
			
			if(($_POST['tipus2']=='terv')and(isset($tomb2_terv[$tervkod]))){
			 $adat[$i][]=$tomb2_terv[$tervkod];
			}
		  }
	  }
  }
  
 }
 
?>