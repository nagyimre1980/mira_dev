<?php

if($_POST['tipus1']=='teny'){
	
if(is_array($tomb1)){
foreach($tomb1 as $tagv => $ert1){
$osszeg1ho_tagv=array();
$osszeg1_tagv=0;
$osszeg2ho_tagv=array();
$osszeg2_tagv=0;
$osszeg2ho_terv_tagv=array();
$osszeg2_terv_tagv=0;
foreach($ert1 as $akt_szolg_kod => $ert2){
  $osszeg1ho_akt_szolg_kod=array();
  $osszeg2ho_akt_szolg_kod=array();
  $osszeg1_akt_szolg_kod=0;
  $osszeg2_akt_szolg_kod=0;
  foreach($ert2 as $szerv_id => $ert3){
   $i++;
   
   $adat[$i][]=$tagv;//Társaság kód
   
   //Társaság neve
	   if(isset($tomb_tagv[$tagv]))
	    $adat[$i][]=$tomb_tagv[$tagv];
	   else $adat[$i][]='';
   
   $adat[$i][]=$akt_szolg_kod;//Aktuális tevékenység kód
   
   //Aktuális tevékenység kód neve
	   if(isset($tomb_szolgkod[$akt_szolg_kod]))
	    $adat[$i][]=$tomb_szolgkod[$akt_szolg_kod];
	   else $adat[$i][]='';
   
   $adat[$i][]=$ert3['szerv_nev'];//Szervezet neve
   $adat[$i][]=$ert3['szerv_adkod'];//Költséghely
   $adat[$i][]=$ert3['szerv_sm_kod'];//SAP SM kód
	 
   	    //Hó adat - eleje
	    foreach($tomb_teny_ho1 as $ert_ho){//Adott hó tény összege 
		  if(isset($ert3['egesz_ora_ho'][$ert_ho])){
			if(!isset($osszeg1ho_akt_szolg_kod[$ert_ho]))$osszeg1ho_akt_szolg_kod[$ert_ho]=0;
			if(!isset($osszeg1ho_tagv[$ert_ho]))$osszeg1ho_tagv[$ert_ho]=0;
			$adat[$i][]=$ert3['egesz_ora_ho'][$ert_ho];
			$osszeg1ho_akt_szolg_kod[$ert_ho]+=$ert3['egesz_ora_ho'][$ert_ho];
			$osszeg1_akt_szolg_kod+=$ert3['egesz_ora_ho'][$ert_ho];
			$osszeg1ho_tagv[$ert_ho]+=$ert3['egesz_ora_ho'][$ert_ho];
			$osszeg1_tagv+=$ert3['egesz_ora_ho'][$ert_ho];
		  }else{
			$adat[$i][]='0';
		  }
		}
	   //Hó adat - vége
	 
   $adat[$i][]=$ert3['osszeg']['all'];//összeg
   
   //Ha a jobb oldal is tény2 - eleje
   if($_POST['tipus2']=='teny'){
	//Hó adat - eleje
	foreach($tomb_teny_ho2 as $ert_ho){//Adott hó tény összege 
		  if(isset($tomb2[$tagv][$akt_szolg_kod][$szerv_id]['egesz_ora_ho'][$ert_ho])){
			if(!isset($osszeg2ho_akt_szolg_kod[$ert_ho]))$osszeg2ho_akt_szolg_kod[$ert_ho]=0;
			if(!isset($osszeg2ho_tagv[$ert_ho]))$osszeg2ho_tagv[$ert_ho]=0;
			$adat[$i][]=$tomb2[$tagv][$akt_szolg_kod][$szerv_id]['egesz_ora_ho'][$ert_ho];
			$osszeg2ho_akt_szolg_kod[$ert_ho]+=$tomb2[$tagv][$akt_szolg_kod][$szerv_id]['egesz_ora_ho'][$ert_ho];
			$osszeg2_akt_szolg_kod+=$tomb2[$tagv][$akt_szolg_kod][$szerv_id]['egesz_ora_ho'][$ert_ho];
			$osszeg2ho_tagv[$ert_ho]+=$tomb2[$tagv][$akt_szolg_kod][$szerv_id]['egesz_ora_ho'][$ert_ho];
			$osszeg2_tagv+=$tomb2[$tagv][$akt_szolg_kod][$szerv_id]['egesz_ora_ho'][$ert_ho];
		  }else{
			$adat[$i][]='0';
		  }
	}
	//Hó adat - vége
	$adat[$i][]=$tomb2[$tagv][$akt_szolg_kod][$szerv_id]['osszeg']['all'];//összeg
   }
   //Ha a jobb oldal is tény2 - vége
  }
  
  //Aktuális tevékenység kód összesítés - eleje
  $i++;
  $adat[$i][]='<b>'.$tagv.'</b>';//Társaság kód
  
     //Társaság neve
	   if(isset($tomb_tagv[$tagv]))
	    $adat[$i][]=$tomb_tagv[$tagv];
	   else $adat[$i][]='';
	   
 $adat[$i][]='<b>'.$akt_szolg_kod.' Összeg</b>';
 
 //Aktuális tevékenység kód neve
 	   if(isset($tomb_szolgkod[$akt_szolg_kod]))
	    $adat[$i][]=$tomb_szolgkod[$akt_szolg_kod];
	   else $adat[$i][]='';
  
  $adat[$i][]='';//Szervezet neve
  $adat[$i][]='';//Költséghely
  $adat[$i][]='';//SAP SM kód
  
  //Hó adat - eleje
  foreach($tomb_teny_ho1 as $ert_ho){//Adott hó tény összege
   if(isset($osszeg1ho_akt_szolg_kod[$ert_ho]))
	$adat[$i][]='<b>'.$osszeg1ho_akt_szolg_kod[$ert_ho].'</b>';
  else
	$adat[$i][]='<b>0</b>';
  }
  //Hó adat - vége
  
  //Full összeg
  $adat[$i][]='<b>'.$osszeg1_akt_szolg_kod.'</b>';
  
  if($_POST['tipus2']=='teny'){
   //Hó adat - eleje
   foreach($tomb_teny_ho2 as $ert_ho){//Adott hó tény összege
   if(isset($osszeg2ho_akt_szolg_kod[$ert_ho]))
	$adat[$i][]='<b>'.$osszeg2ho_akt_szolg_kod[$ert_ho].'</b>';
   else
	$adat[$i][]='<b>0</b>';
   }
   //Hó adat - vége
   
   //Full összeg
   $adat[$i][]='<b>'.$osszeg2_akt_szolg_kod.'</b>';
  }elseif($_POST['tipus2']=='terv'){
	  
    //Hó adat - eleje
	foreach($tomb_terv_ho2 as $ert_ho){//Aktuális tevékenység kód havi terv
	 if(!isset($osszeg2ho_terv_tagv[$ert_ho]))$osszeg2ho_terv_tagv[$ert_ho]=0;
	 if(isset($tomb2_terv[$tagv.$akt_szolg_kod][$ert_ho]['osszeg'])){
	    $adat[$i][]=$tomb2_terv[$tagv.$akt_szolg_kod][$ert_ho]['osszeg'];
		$osszeg2ho_terv_tagv[$ert_ho]+=$tomb2_terv[$tagv.$akt_szolg_kod][$ert_ho]['osszeg'];
		$osszeg2_terv_tagv+=$tomb2_terv[$tagv.$akt_szolg_kod][$ert_ho]['osszeg'];
	 }else $adat[$i][]='';
	}
	//Hó adat - vége
	
	if(isset($tomb2_terv[$tagv.$akt_szolg_kod]))
	 $adat[$i][]=$tomb2_terv[$tagv.$akt_szolg_kod]['osszeg'];
  }
  //Aktuális tevékenység kód összesítés - vége
}

//Pótlásos dolgok - eleje
if((isset($tomb1_potlas[$tagv]))and(is_array($tomb1_potlas[$tagv]))){
 foreach($tomb1_potlas[$tagv] as $tenypotlas_szolg_kod => $ert_p){
	$i++;
	$style_e='<style bgcolor="#FFFF00">';
	$style_v='</style>';
	$adat[$i][]=$style_e.'<b>'.$tagv.'</b>'.$style_v;//Társaság kód - összeg 
	
	//Társaság neve
	if(isset($tomb_tagv[$tagv]))
	 $adat[$i][]=$style_e.$tomb_tagv[$tagv];
	else $adat[$i][]=$style_e.$style_v;
	
	$adat[$i][]=$style_e.'<b>'.$tenypotlas_szolg_kod.' Összeg</b>'.$style_v;//Aktuális tevékenység kód - összeg
	
	//Aktuális tevékenység kód neve
	if(isset($tomb_szolgkod[$tenypotlas_szolg_kod]))
	 $adat[$i][]=$style_e.$tomb_szolgkod[$tenypotlas_szolg_kod].$style_v;
	else $adat[$i][]=$style_e.$style_v;
	
	$adat[$i][]=$style_e.$style_v;//Szervezet neve
	$adat[$i][]=$style_e.$style_v;//Költséghely
	$adat[$i][]=$style_e.$style_v;//SAP SM kód
	
	///Hó - eleje
		 foreach($tomb_teny_ho1 as $ert_ho){
		  if(isset($ert_p['ho'][$ert_ho])){
		   $adat[$i][]=$style_e.'<b>'.$ert_p['ho'][$ert_ho].'</b>'.$style_v;
		   $osszeg1ho_tagv[$ert_ho]+=$ert_p['ho'][$ert_ho];
		  }else{
			$adat[$i][]=$style_e.$style_v;
		  }
		 }
	///Hó - vége
	
	//Összesen
	$adat[$i][]=$style_e.'<b>'.$ert_p['all'].'</b>'.$style_v;
	$osszeg1_tagv+=$ert_p['all'];
	
			 //Terv - eleje
		 if($_POST['tipus2']=='terv'){
			if(is_array($tomb_terv_ho2)){
			foreach($tomb_terv_ho2 as $ert_ho){
				 if(isset($tomb2_terv[$tagv.$tenypotlas_szolg_kod][$ert_ho]['osszeg'])){
				  $adat[$i][]=$style_e.$tomb2_terv[$tagv.$tenypotlas_szolg_kod][$ert_ho]['osszeg'].$style_v;
				  $osszeg2ho_terv_tagv[$ert_ho]+=$tomb2_terv[$tagv.$tenypotlas_szolg_kod][$ert_ho]['osszeg'];
				  $osszeg2_terv_tagv+=$tomb2_terv[$tagv.$tenypotlas_szolg_kod][$ert_ho]['osszeg'];
				 }else $adat[$i][]=$style_e.$style_v;
			 
			}
			}
		 
		 $adat[$i][]=$style_e.$tomb2_terv[$tagv.$tenypotlas_szolg_kod]['osszeg'].$style_v;//Összeg
		 }
		 //Terv - vége
	
 }
}
//Pótlásos dolgok - vége

//Tagv összes - eleje
$i++;
$adat[$i][]='<b>'.$tagv.' Összeg</b>';//Társaság kód

     //Társaság neve
	   if(isset($tomb_tagv[$tagv]))
	    $adat[$i][]=$tomb_tagv[$tagv];
	   else $adat[$i][]='';


 $adat[$i][]='';//akt_szolg_kod
 $adat[$i][]='';//Aktuális tevékenység kód neve
 $adat[$i][]='';//Szervezet neve
 $adat[$i][]='';//Költséghely
 $adat[$i][]='';//SAP SM kód
 
 //Hó adat - eleje
  foreach($tomb_teny_ho1 as $ert_ho){//Adott hó tény összege
  if(isset($osszeg1ho_tagv[$ert_ho]))
	 $adat[$i][]='<b>'.$osszeg1ho_tagv[$ert_ho].'</b>';
  else
	$adat[$i][]='<b>0</b>';
  }
 //Hó adat - vége
 
 //Összeg
 $adat[$i][]='<b>'.$osszeg1_tagv.'</b>';

 if($_POST['tipus2']=='teny'){
  
  //Hó adat - eleje
  foreach($tomb_teny_ho2 as $ert_ho){//Adott hó tény összege
  if(isset($osszeg2ho_tagv[$ert_ho]))
	 $adat[$i][]='<b>'.$osszeg2ho_tagv[$ert_ho].'</b>';
  else
	$adat[$i][]='<b>0</b>';
  }
  //Hó adat - vége
  
  //Összeg
  $adat[$i][]='<b>'.$osszeg2_tagv.'</b>';
 }elseif($_POST['tipus2']=='terv'){//Tagv összesítés
	//Hó adat - eleje
	foreach($tomb_terv_ho2 as $ert_ho){//Társasági összeg havi tény
	 if(isset($osszeg2ho_terv_tagv[$ert_ho]))
	  $adat[$i][]=$osszeg2ho_terv_tagv[$ert_ho];
	 else $adat[$i][]='';
	}
    //Hó adat - vége
	
	//TAGV teljes terv összege
	$adat[$i][]=$osszeg2_terv_tagv;
 }
//Tagv összes - vége
}
}

}
?>