<?php

function riport_tervteny(){
include_once('../function.php');
/*
echo'<pre>';
print_r($_POST);
echo'</pre>';
exit;
*/

if($_POST['tipus1']=='teny'){
 
 $_POST['reszlet1terv']='egybe';
 
 $tomb1=keres_riport_tervteny_teny($_POST['ev1'],$_POST['ho1'],$_POST['szerv1'],$_POST['proj1'],$_POST['szolgkod1'],$_POST['tagv1'],$_POST['user1']);
 
 $tomb1_potlas=keres_riport_tervteny_teny_potlas($_POST['ev1'],$_POST['ho1'],$_POST['szolgkod1'],$_POST['tagv1']);
 
}elseif($_POST['tipus1']=='terv'){
 $tomb1_terv=keres_riport_tervteny_terv($_POST['ev1'],$_POST['ho1'],$_POST['szolgkod1'],$_POST['tagv1'],$_POST['altipus1'],$_POST['reszlet1terv']);
}

if($_POST['tipus2']=='teny'){
 $tomb2=keres_riport_tervteny_teny($_POST['ev2'],$_POST['ho2'],$_POST['szerv2'],$_POST['proj2'],$_POST['szolgkod2'],$_POST['tagv2'],$_POST['user2']);
}elseif($_POST['tipus2']=='terv'){
 $tomb2_terv=keres_riport_tervteny_terv($_POST['ev2'],$_POST['ho2'],$_POST['szolgkod2'],$_POST['tagv2'],$_POST['altipus2'],$_POST['reszlet1terv']);
}

$i=0;
if($_POST['tipus1']=='teny'){

$tomb_tagv=keress_riport_teny3_tagvkod_nev($_POST['ev1'],$_POST['ho1']);

if($_POST['reszlet1']!='tagv'){
 $tomb_szolgkod=keress_riport_teny3_szolgkod_nev($_POST['ev1'],$_POST['ho1']);
}

 $adat[$i][]='<b>'."Társaság kód".'</b>';
 $adat[$i][]='<b>'."Társaság neve".'</b>';

if($_POST['reszlet1']!='tagv'){
 $adat[$i][]='<b>'."Aktuális tevékenység kód".'</b>';
 $adat[$i][]='<b>'."Aktuális tevékenység kód neve".'</b>';
}

if($_POST['reszlet1']=='szerv'){
 $adat[$i][]='<b>'."Szervezet neve".'</b>';
 $adat[$i][]='<b>'."Költséghely".'</b>';
 $adat[$i][]='<b>'."SAP SM kód".'</b>';
}elseif($_POST['reszlet1']=='all'){
 $adat[$i][]='<b>'."Szervezet neve".'</b>';
 $adat[$i][]='<b>'."Költséghely".'</b>';
 $adat[$i][]='<b>'."SAP SM kód".'</b>';
 $adat[$i][]='<b>'."Felhasználó neve".'</b>';
}

}elseif($_POST['tipus1']=='terv'){
 
 $adat[$i][]='<b>'."Év".'</b>';
 //if($_POST['reszlet1terv']!='egybe'){
  $adat[$i][]='<b>'."Hó".'</b>';
 //}
 
 $adat[$i][]='<b>'."Tervkód".'</b>';
 $adat[$i][]='<b>'."Társaság kód".'</b>';
 $adat[$i][]='<b>'."Társaság neve".'</b>';
 $adat[$i][]='<b>'."Tevékenység kód".'</b>';
 $adat[$i][]='<b>'."Tevékenység kód neve".'</b>';
}

if($_POST['tipus1']=='teny'){
 
 //Hó fejléc - eleje 
 if($_POST['ho1']=='all'){
  //Lekeressük az érvényes hó értékeket
  $tomb_teny_ho1=keress_riport_ful_ki_evho_hoki($_POST['ev1']);
 }else{
  //$tomb_backup_ver_id=explode("#",$ho);
  $tomb_teny_ho1=explode('#',$_POST['ho1']);
 }
 //Hó fejléc - vége
 
 //Tény1 hók - eleje
 foreach($tomb_teny_ho1 as $ert_ho){
  $adat[$i][]='<b>'."Tény1 ".mb_strtolower(ho_ki($ert_ho)).'</b>';
 }
 //Tény1 hók - vége
 
 $adat[$i][]='<b>'."Tény1 Összeg".'</b>';
}elseif($_POST['tipus1']=='terv'){
 $adat[$i][]='<b>'."Terv1 Összeg".'</b>';
}

if($_POST['tipus2']=='teny'){

 //Hó fejléc - eleje
 if($_POST['ho2']=='all'){
  //Lekeressük az érvényes hó értékeket
  $tomb_teny_ho2=keress_riport_ful_ki_evho_hoki($_POST['ev2']);
 }else{
  //$tomb_backup_ver_id=explode("#",$ho);
  $tomb_teny_ho2=explode('#',$_POST['ho2']);
 }
 //Hó fejléc - vége
 
 //Tény2 hók - eleje
 foreach($tomb_teny_ho2 as $ert_ho){
  $adat[$i][]='<b>'."Tény2 ".mb_strtolower(ho_ki($ert_ho)).'</b>';
 }
 //Tény2 hók - vége

 $adat[$i][]='<b>'."Tény2 Összeg".'</b>';
}elseif($_POST['tipus2']=='terv'){
 
 //Hó fejléc - eleje
 if($_POST['ho2']=='all'){
  $tomb_terv_ho2=keress_riport_ful_ki_evho_hoki_terv($_POST['ev2']);
 }else{
  //$tomb_backup_ver_id=explode("#",$ho);
  $tomb_terv_ho2=explode('#',$_POST['ho2']);
 }
 //Hó fejléc - vége
 
  //Terv2 hók - eleje
 foreach($tomb_terv_ho2 as $ert_ho){
  $adat[$i][]='<b>'."Terv2 ".mb_strtolower(ho_ki($ert_ho)).'</b>';
 }
 //Terv2 hók - vége
 $adat[$i][]='<b>'."Terv2 Összeg".'</b>';
}

mysqli_close($GLOBALS['mysqli']);

//2. sor kezdődik...
if($_POST['reszlet1']=='szerv'){//Szervezeti összesítés külön fájlban
 include_once('riport_tervteny_leker_szerv.php');
}elseif($_POST['tipus1']=='teny'){

if(is_array($tomb1)){
foreach($tomb1 as $tagv => $ert1){
$osszeg1ho_tagv=array();
$osszeg2ho_tagv=array();
$osszeg1_tagv=0;
$osszeg2_tagv=0;
$osszeg2ho_terv_tagv=array();
$osszeg2_terv_tagv=0;

 foreach($ert1 as $akt_szolg_kod => $ert2){
  $osszeg1ho_akt_szolg_kod=array();
  $osszeg2ho_akt_szolg_kod=array();
  $osszeg1_akt_szolg_kod=0;
  $osszeg2_akt_szolg_kod=0;
  
  foreach($ert2 as $szerv_id => $ert3){
	 foreach($ert3['user'] as $user_ad => $ert4){
	 
	 //if($_POST['reszlet1']!='tagv'){
	  foreach($tomb_teny_ho1 as $ert_ho){
		if(!isset($osszeg1ho_tagv[$ert_ho]))$osszeg1ho_tagv[$ert_ho]=0;
		if(!isset($osszeg1ho_akt_szolg_kod[$ert_ho]))$osszeg1ho_akt_szolg_kod[$ert_ho]=0;
		if(isset($ert4['egesz_ora_ho'][$ert_ho])){
			$osszeg1ho_tagv[$ert_ho]+=$ert4['egesz_ora_ho'][$ert_ho];
			$osszeg1ho_akt_szolg_kod[$ert_ho]+=$ert4['egesz_ora_ho'][$ert_ho];
		}
	  }
	 //}
	 
	 if($_POST['reszlet1']=='all'){
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
	   $adat[$i][]=$ert4['nev'];//Felhasználó neve
	   
	    //Hó adat - eleje
	    foreach($tomb_teny_ho1 as $ert_ho){//Adott hó tény összege 
		  if(isset($ert4['egesz_ora_ho'][$ert_ho])){
			$adat[$i][]=$ert4['egesz_ora_ho'][$ert_ho];
		  }else{
			$adat[$i][]='0';
		  }
		}
	   //Hó adat - vége
	   
	   $adat[$i][]=$ert4['egesz_ora'];//összeg1
	   
	 }
	   
	   $osszeg1_akt_szolg_kod+=$ert4['egesz_ora'];
	   $osszeg1_tagv+=$ert4['egesz_ora'];
	   
	   if($_POST['tipus2']=='teny'){
	    if(isset($tomb2[$tagv][$akt_szolg_kod][$szerv_id]['user'][$user_ad]['egesz_ora'])){

			//Hó adat - eleje
			foreach($tomb_teny_ho2 as $ert_ho){//Adott hó tény összege
			 if(!isset($osszeg2ho_tagv[$ert_ho]))$osszeg2ho_tagv[$ert_ho]=0;
			 if(!isset($osszeg2ho_akt_szolg_kod[$ert_ho]))$osszeg2ho_akt_szolg_kod[$ert_ho]=0;
			 if(isset($ert4['egesz_ora_ho'][$ert_ho])){
			  $osszeg2ho_tagv[$ert_ho]+=$ert4['egesz_ora_ho'][$ert_ho];
			  $osszeg2ho_akt_szolg_kod[$ert_ho]+=$ert4['egesz_ora_ho'][$ert_ho];
			 }
			}
			//Hó adat - vége
			
			if($_POST['reszlet1']=='all'){
			 
			//Hó adat - eleje
			foreach($tomb_teny_ho2 as $ert_ho){//Adott hó tény összege
			 
			 if(isset($ert4['egesz_ora_ho'][$ert_ho])){
			  $adat[$i][]=$ert4['egesz_ora_ho'][$ert_ho];
			 }else{
			   $adat[$i][]='0';
			 }
			}
			//Hó adat - vége
			 
			 $adat[$i][]=$tomb2[$tagv][$akt_szolg_kod][$szerv_id]['user'][$user_ad]['egesz_ora'];//összeg2
			}
				
				$osszeg2_akt_szolg_kod+=$ert4['egesz_ora'];
				$osszeg2_tagv+=$ert4['egesz_ora'];
		}
	   }
	   
	 }
  }
   
 
  $i++;
 if($_POST['reszlet1']!='tagv'){
 
   $adat[$i][]='<b>'.$tagv.'</b>';//Társaság kód
   
   	   //Társaság neve
	   if(isset($tomb_tagv[$tagv]))
	    $adat[$i][]=$tomb_tagv[$tagv];
	   else $adat[$i][]='';
 }
 
 if($_POST['reszlet1']!='tagv'){
   $adat[$i][]='<b>'.$akt_szolg_kod.' Összeg</b>';//Aktuális tevékenység kód - összeg
   
   	   //Aktuális tevékenység kód neve
	   if(isset($tomb_szolgkod[$akt_szolg_kod]))
	    $adat[$i][]=$tomb_szolgkod[$akt_szolg_kod];
	   else $adat[$i][]='';
 }
 
  if($_POST['reszlet1']=='all'){
   $adat[$i][]='';//Szervezet neve
   $adat[$i][]='';//Költséghely
   $adat[$i][]='';//SAP SM kód
   $adat[$i][]='';//Felhasználó neve
  }

 if($_POST['reszlet1']!='tagv'){
   
 //Hó adat - eleje
 foreach($tomb_teny_ho1 as $ert_ho){//Aktuális tevékenység kód havi tény
  $adat[$i][]='<b>'.$osszeg1ho_akt_szolg_kod[$ert_ho].'</b>';
 }
 //Hó adat - vége
 
   $adat[$i][]='<b>'.$osszeg1_akt_szolg_kod.'</b>';////összeg számolandó - Aktuális tevékenység kód
 }
 
 if($_POST['reszlet1']!='tagv'){
   if($_POST['tipus2']=='teny'){
	
	 //Hó adat - eleje
	 foreach($tomb_teny_ho2 as $ert_ho){//Aktuális tevékenység kód havi tény
	  $adat[$i][]='<b>'.$osszeg2ho_akt_szolg_kod[$ert_ho].'</b>';
	 }
	 //Hó adat - vége
	
	$adat[$i][]='<b>'.$osszeg2_akt_szolg_kod.'</b>';////összeg számolandó - Aktuális tevékenység kód
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
 }
 
 }
 
 //Pótlásos dolgok - eleje
 if($_POST['reszlet1']=='tagv'){//Pótlás esetén csak hozzá kell adni.
  if((isset($tomb1_potlas[$tagv]))and(is_array($tomb1_potlas[$tagv]))){
  foreach($tomb1_potlas[$tagv] as $tenypotlas_szolg_kod => $ert_p){
	  	 
		 ///Hó - eleje
		 foreach($tomb_teny_ho1 as $ert_ho){
		  if(isset($ert_p['ho'][$ert_ho])){
		   $osszeg1ho_tagv[$ert_ho]+=$ert_p['ho'][$ert_ho];
		  }
		 }
		 ///Hó - vége
		 $osszeg1_tagv+=$ert_p['all'];
  }
  }
 }elseif((isset($tomb1_potlas[$tagv]))and(is_array($tomb1_potlas[$tagv]))){
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
		 
		 if($_POST['reszlet1']=='all'){
				 $adat[$i][]=$style_e.$style_v;//Szervezet neve
				 $adat[$i][]=$style_e.$style_v;//Költséghely
				 $adat[$i][]=$style_e.$style_v;//SAP SM kód
				 $adat[$i][]=$style_e.$style_v;//Felhasználó neve
				}
		 
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
		 
		 if(isset($tomb2_terv[$tagv.$tenypotlas_szolg_kod]['osszeg'])){
		  $adat[$i][]=$style_e.$tomb2_terv[$tagv.$tenypotlas_szolg_kod]['osszeg'].$style_v;//Összeg
		 }else{//Ha nincs terv.
			 $adat[$i][]=$style_e.'0'.$style_v;//Összeg
		 }
		 /*if(!isset($tomb2_terv[$tagv.$tenypotlas_szolg_kod]['osszeg'])){
		  echo '<pre>';
		  print_r($tomb2_terv);
		  echo '</pre>';
		  echo $tomb2_terv[$tagv.$tenypotlas_szolg_kod]['osszeg'];
		  exit;
		 }
		 */
		 }
		 //Terv - vége
		 
	 }
 }
 //Pótlásos dolgok - vége
 
 //Terv sorok, ha ezek nem szerepeltek a tényben - eleje
 //Egyenlőre csak Teljes esetén
 if(($_POST['tipus1']=='teny')and($_POST['tipus2']=='terv')){//and($_POST['reszlet1']=='all')
  if((isset($tomb2_terv[$tagv]))and(is_array($tomb2_terv[$tagv]))){
	  foreach($tomb2_terv[$tagv] as $tplusz_akt_szolg_kod => $ert_t2){
		  
			  if(
			  (!isset($ert1[$tplusz_akt_szolg_kod]))and
			  (!isset($tomb1_potlas[$tagv][$tplusz_akt_szolg_kod]))
			  ){//Ekkor ez plusz sor, ki kell írni!
				$i++;
				$adat[$i][]='<b>'.$tagv.'</b>';//Társaság kód - összeg	

				//Társaság neve
				if(isset($tomb_tagv[$tagv]))
				 $adat[$i][]=$tomb_tagv[$tagv];
				else $adat[$i][]='';
				
				$adat[$i][]='<b>'.$tplusz_akt_szolg_kod.' Összeg</b>';//Aktuális tevékenység kód - összeg
				
				//Aktuális tevékenység kód neve
			    if(isset($tomb_szolgkod[$tplusz_akt_szolg_kod]))
			 	 $adat[$i][]=$tomb_szolgkod[$tplusz_akt_szolg_kod];
			    else $adat[$i][]='';
				
				if($_POST['reszlet1']=='all'){
				 $adat[$i][]='';//Szervezet neve
				 $adat[$i][]='';//Költséghely
				 $adat[$i][]='';//SAP SM kód
				 $adat[$i][]='';//Felhasználó neve
				}
				 //Tény Hó adat - eleje
				 foreach($tomb_teny_ho1 as $ert_ho){
					$adat[$i][]='0';
				 }
				 //Tény Hó adat - vége
				 
				 $adat[$i][]='0';//Tény összeg
				 
				 //Terv Hó adat - eleje
				 if(is_array($tomb_terv_ho2)){
				 foreach($tomb_terv_ho2 as $ert_ho){
				 if(isset($tomb2_terv[$tagv.$tplusz_akt_szolg_kod][$ert_ho]['osszeg'])){
				  $adat[$i][]=$tomb2_terv[$tagv.$tplusz_akt_szolg_kod][$ert_ho]['osszeg'];
				  $osszeg2ho_terv_tagv[$ert_ho]+=$tomb2_terv[$tagv.$tplusz_akt_szolg_kod][$ert_ho]['osszeg'];
				  $osszeg2_terv_tagv+=$tomb2_terv[$tagv.$tplusz_akt_szolg_kod][$ert_ho]['osszeg'];
				 }else $adat[$i][]='';
			 
				 }
				 }
				 
				 //Terv Hó adat - vége
				 
				 $adat[$i][]=$ert_t2['osszeg'];//Összeg
			  }
		  
	  }
	  //exit;
  }
 }
//Terv sorok, ha ezek nem szerepeltek a tényben - vége

 $i++;
 $adat[$i][]='<b>'.$tagv.' Összeg</b>';//Társaság kód - összeg
 
    	   //Társaság neve
	   if(isset($tomb_tagv[$tagv]))
	    $adat[$i][]=$tomb_tagv[$tagv];
	   else $adat[$i][]='';
 
if($_POST['reszlet1']!='tagv'){
 $adat[$i][]='';//Aktuális tevékenység kód - összeg
 
 //Aktuális tevékenység kód neve	  
 $adat[$i][]='';
}

if($_POST['reszlet1']=='all'){
 $adat[$i][]='';//Szervezet neve
 $adat[$i][]='';//Költséghely
 $adat[$i][]='';//SAP SM kód
 $adat[$i][]='';//Felhasználó neve
}

 //Hó adat - eleje
 foreach($tomb_teny_ho1 as $ert_ho){//Társasági összeg havi tény
  if(isset($osszeg1ho_tagv[$ert_ho]))
   $adat[$i][]='<b>'.$osszeg1ho_tagv[$ert_ho].'</b>';
  else $adat[$i][]='<b>0</b>';
 }
 //Hó adat - vége

 $adat[$i][]='<b>'.$osszeg1_tagv.'</b>';////összeg számolandó Társasági összeg
 
 if($_POST['tipus2']=='teny'){
  
  //Hó adat - eleje
  foreach($tomb_teny_ho1 as $ert_ho){//Társasági összeg havi tény
   if(isset($osszeg2ho_tagv[$ert_ho]))
    $adat[$i][]='<b>'.$osszeg2ho_tagv[$ert_ho].'</b>';
   else $adat[$i][]='<b>0</b>';
  }
  //Hó adat - vége

  $adat[$i][]='<b>'.$osszeg2_tagv.'</b>';////összeg számolandó Társasági összeg
 }elseif($_POST['tipus2']=='terv'){//TAGV terv2 összesítése
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
 
 
}
}
}elseif($_POST['tipus1']=='terv'){
 include_once('riport_tervteny_leker_terv.php');
}

/*echo '<pre>';
print_r($tomb1);
echo '</pre>';
exit;*/

unset($tomb1);
unset($tomb1_terv);
unset($tomb2);
unset($tomb2_terv);
unset($tomb_tagv);
unset($tomb_szolgkod);
unset($tomb1_potlas);

$date=date("Y_m_d-H_i_s",time());
$filename='Tervteny '.$date.'.xlsx';
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Tervtény export');

$xlsx->autoFilter('A1:'.excel_oszlop_betu(sizeof($adat[0])).'1');
unset($adat);

$xlsx->downloadAs(rawurlencode($filename));

}

function keres_riport_tervteny_terv($ev,$ho,$szolgkod,$tagv,$altipus,$reszlet){
$eredmeny_keres='';

$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);

$where='';
$where_h='';

if(($altipus!='')and($altipus!='keremv')){//Ez így van, de biztos ami biztos.
 $where.=' and backup_terv.backup_terv_tipus_id="'.$altipus.'" ';
}


if($ho=='all'){

}else{
 $tomb_ho=explode("#",$ho);
 
 if(is_array($tomb_ho)){
 foreach($tomb_ho as $ho_r){
  if($where_h!='')$where_h.='or';
  $where_h.="(backup_terv.backup_terv_ho='".$ho_r."')";
 }
  $where.=' and ('.$where_h.')';
 }
 
}

/*
if(($szolgkod!='all')and($tagv!='all')){
 $where.=' and backup_terv.backup_terv_tervkod="'.$tagv.$szolgkod.'" ';
}
*/

if($tagv!='all'){
 $where.=' and backup_terv.backup_terv_tagv_kod="'.$tagv.'" ';
}

if($szolgkod!='all'){
 $where.=' and backup_terv.backup_terv_szolg_kod="'.$szolgkod.'" ';
}

$sql="SELECT 
backup_terv.backup_terv_ho,
backup_terv.backup_terv_tervkod,
backup_terv.backup_terv_tagv_kod,
mira_tagv_kod.tagv_kod_nev,
backup_terv.backup_terv_szolg_kod,
mira_szolg_kod.szolg_kod_nev,
backup_terv.backup_terv_osszeg
FROM `backup_terv`
left join mira_tagv_kod ON mira_tagv_kod.tagv_kod = backup_terv.backup_terv_tagv_kod 
left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = backup_terv.backup_terv_szolg_kod 
where
backup_terv.backup_terv_ev='".$ev."'".$where;
$sql.=" order by 
backup_terv.backup_terv_tagv_kod ASC,
backup_terv.backup_terv_szolg_kod ASC,
backup_terv.backup_terv_ho ASC ";
//print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  
  if($reszlet=='egybe'){
  
  if(!isset($eredmeny_keres[$adatom['backup_terv_tervkod']])){
   
   //V1.061, hogy a tény nélküli is szerepeljen tény-terv esetén
   $eredmeny_keres[$adatom['backup_terv_tagv_kod']][$adatom['backup_terv_szolg_kod']]['osszeg']=$adatom['backup_terv_osszeg'];

   $eredmeny_keres[$adatom['backup_terv_tervkod']]['osszeg']=$adatom['backup_terv_osszeg'];
   $eredmeny_keres[$adatom['backup_terv_tervkod']]['tagv_kod']=$adatom['backup_terv_tagv_kod'];
   $eredmeny_keres[$adatom['backup_terv_tervkod']]['tagv_kod_nev']=$adatom['tagv_kod_nev'];
   $eredmeny_keres[$adatom['backup_terv_tervkod']]['szolg_kod']=$adatom['backup_terv_szolg_kod'];
   $eredmeny_keres[$adatom['backup_terv_tervkod']]['szolg_kod_nev']=$adatom['szolg_kod_nev'];
   $eredmeny_keres[$adatom['backup_terv_tervkod']]['ho']=$adatom['backup_terv_ho'];
  }else{
   
   //V1.061, hogy a tény nélküli is szerepeljen tény-terv esetén
   $eredmeny_keres[$adatom['backup_terv_tagv_kod']][$adatom['backup_terv_szolg_kod']]['osszeg']+=$adatom['backup_terv_osszeg'];
   
   $eredmeny_keres[$adatom['backup_terv_tervkod']]['osszeg']+=$adatom['backup_terv_osszeg'];
   $eredmeny_keres[$adatom['backup_terv_tervkod']]['ho']=$eredmeny_keres[$adatom['backup_terv_tervkod']]['ho'].','.$adatom['backup_terv_ho'];
   
  }
	//Hós cucc is kell
	$eredmeny_keres[$adatom['backup_terv_tervkod']][$adatom['backup_terv_ho']]['osszeg']=$adatom['backup_terv_osszeg'];

  }else{//Minden hó külön
	$eredmeny_keres[$adatom['backup_terv_tervkod']][$adatom['backup_terv_ho']]['osszeg']=$adatom['backup_terv_osszeg'];
	$eredmeny_keres[$adatom['backup_terv_tervkod']][$adatom['backup_terv_ho']]['tagv_kod']=$adatom['backup_terv_tagv_kod'];
	$eredmeny_keres[$adatom['backup_terv_tervkod']][$adatom['backup_terv_ho']]['tagv_kod_nev']=$adatom['tagv_kod_nev'];
	$eredmeny_keres[$adatom['backup_terv_tervkod']][$adatom['backup_terv_ho']]['szolg_kod']=$adatom['backup_terv_szolg_kod'];
	$eredmeny_keres[$adatom['backup_terv_tervkod']][$adatom['backup_terv_ho']]['szolg_kod_nev']=$adatom['szolg_kod_nev'];
  }
  
 }
 return $eredmeny_keres;
}

function keres_riport_tervteny_teny_potlas($ev,$ho,$szolgkod,$tagv){
$eredmeny_keres='';

$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);

$where='';

//ev - eleje
$where=' backup_tenypotlas.backup_tenypotlas_ev="'.$ev.'" ';
//ev - vége

//ho - eleje
if($ho!='all'){
 $tomb_ho=explode("#",$ho);

 if(is_array($tomb_ho)){
 $where_h='';
 foreach($tomb_ho as $ho_t){
  if($where_h!='')$where_h.='or';
  $where_h.="(backup_tenypotlas.backup_tenypotlas_ho='".$ho_t."')";
 }
 $where.='('.$where_h.')';
 }
}
//ho - vége

//szolgkod - eleje
$where_h='';
if($szolgkod!='all'){
 $tomb_szolgkod=explode("#",$szolgkod);
 if(is_array($tomb_szolgkod)){
	foreach($tomb_szolgkod as $szolg_kod){
	 if($where_h!='')$where_h.='or';
	 $where_h.="(backup_tenypotlas.backup_tenypotlas_szolg_kod ='".$szolg_kod."')";
	}
   if($where!='')$where.='and';
   $where.='('.$where_h.')';
 }
}
//szolgkod - vége

//tagv - eleje
$where_h='';
if($tagv!='all'){
 $tomb_tagv=explode("#",$tagv);
 if(is_array($tomb_tagv)){
	foreach($tomb_tagv as $tagv_kod){
	 if($where_h!='')$where_h.='or';
	 $where_h.="(backup_tenypotlas.backup_tenypotlas_tagv='".$tagv_kod."')";
	}
   if($where!='')$where.='and';
   $where.='('.$where_h.')';
 }
}
//tagv - vége

$sql="SELECT 
backup_tenypotlas.backup_tenypotlas_tagv,
backup_tenypotlas.backup_tenypotlas_szolg_kod,
backup_tenypotlas.backup_tenypotlas_ho,
backup_tenypotlas.backup_tenypotlas_osszeg
FROM `backup_tenypotlas`";

//print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  if(!isset($eredmeny_keres[$adatom['backup_tenypotlas_tagv']][$adatom['backup_tenypotlas_szolg_kod']]['all'])){
	$eredmeny_keres[$adatom['backup_tenypotlas_tagv']][$adatom['backup_tenypotlas_szolg_kod']]['all']=$adatom['backup_tenypotlas_osszeg'];  
  }else{
	$eredmeny_keres[$adatom['backup_tenypotlas_tagv']][$adatom['backup_tenypotlas_szolg_kod']]['all']+=$adatom['backup_tenypotlas_osszeg'];  
  }
  
  if(!isset($eredmeny_keres[$adatom['backup_tenypotlas_tagv']][$adatom['backup_tenypotlas_szolg_kod']]['ho'][$adatom['backup_tenypotlas_ho']])){
	  $eredmeny_keres[$adatom['backup_tenypotlas_tagv']][$adatom['backup_tenypotlas_szolg_kod']]['ho'][$adatom['backup_tenypotlas_ho']]=$adatom['backup_tenypotlas_osszeg'];
  }else{
	  $eredmeny_keres[$adatom['backup_tenypotlas_tagv']][$adatom['backup_tenypotlas_szolg_kod']]['ho'][$adatom['backup_tenypotlas_ho']]+=$adatom['backup_tenypotlas_osszeg'];
  }
 }
return $eredmeny_keres;
}

function keres_riport_tervteny_teny($ev,$ho,$szerv,$proj,$szolgkod,$tagv,$user){
$eredmeny_keres='';

$where='';
$where_h='';


if($ho=='all'){
 //Lekeressük az érvényes backup_ver_id értékeket
 $tomb_backup_ver_id=keress_riport_ful_ki_evho_teny311_excelhez($ev);
}else{
 //$tomb_backup_ver_id=explode("#",$ho);
 $tomb_backup_ver_id=keress_riport_ful_ki_evho_teny311_excelhez_hobol($ev,$ho);
}

  if(is_array($tomb_backup_ver_id)){
  foreach($tomb_backup_ver_id as $backup_ver_id){
	 if($where_h!='')$where_h.='or';
	 $where_h.="(backup_adat_".$ev."_teny_3_1_1.backup_ver_id='".$backup_ver_id."')";
  }
  $where=' where ('.$where_h.')';
  //$where=' where backup_adat_2024_teny_3_2.backup_szerv_id= "219" and ('.$where_h.')';
 }else{
	 echo 'adathiányho:';exit;
 }

//szerv - eleje
$where_h='';
if($szerv!='all'){
 $tomb_szerv=explode("#",$szerv);
 if(is_array($tomb_szerv)){
  foreach($tomb_szerv as $szerv_id){
   if($where_h!='')$where_h.='or';
   $where_h.="(backup_szerv.szerv_id='".$szerv_id."')";
  }	  
  if($where!='')$where.='and';
  $where.='('.$where_h.')';	
 }
}
//szerv - vége

//proj - eleje
$where_h='';
if($proj!='all'){
 $tomb_proj=explode("#",$proj);
 if(is_array($tomb_proj)){
  foreach($tomb_proj as $projekt_id){
   if($where_h!='')$where_h.='or';
   $where_h.="(backup_pojekt.projekt_id='".$projekt_id."')";
  }
  if($where!='')$where.='and';
  $where.='('.$where_h.')';	
 }
}
//proj - vége

//szolgkod - eleje
$where_h='';
if($szolgkod!='all'){
 $tomb_szolgkod=explode("#",$szolgkod);
 if(is_array($tomb_szolgkod)){
	foreach($tomb_szolgkod as $szolg_kod){
	 if($where_h!='')$where_h.='or';
	 $where_h.="
	 (
	  ((backup_pojekt.projekt_szolg_kod IS NULL)and(backup_szerv.szerv_szolg_kod='".$szolg_kod."'))
	  or
	  ((backup_pojekt.projekt_szolg_kod IS NOT NULL)and(backup_pojekt.projekt_szolg_kod='".$szolg_kod."'))
	 )
	 ";
	}
   if($where!='')$where.='and';
   $where.='('.$where_h.')';
 }
}
//szolgkod - vége

//tagv - eleje
$where_h='';
if($tagv!='all'){
 $tomb_tagv=explode("#",$tagv);
 if(is_array($tomb_tagv)){
	foreach($tomb_tagv as $tagv_kod){
	 if($where_h!='')$where_h.='or';
	 $where_h.="(backup_pojekt.projekt_tagv_kod='".$tagv_kod."')";
	}
   if($where!='')$where.='and';
   $where.='('.$where_h.')';
 }
}
//tagv - vége

//user - eleje
$where_h='';
if($user!='all'){
 $tomb_user=explode("#",$user);
 if(is_array($tomb_user)){
  foreach($tomb_user as $user_ad){
   if($where_h!='')$where_h.='or';
   $where_h.="(backup_user.user_ad='".$user_ad."')";
  }
   if($where!='')$where.='and';
   $where.='('.$where_h.')';
 }
}
//user - vége

//backup_pojekt.projekt_szolg_kod,
//backup_szerv.szerv_szolg_kod,
//backup_adat_".$ev."_teny_3_1_1.rogzitett_teny3_ora,
//backup_adat_".$ev."_teny_3_1_1.rogzitett_teny3_perc,
$sql="SELECT 
backup_user.user_ad,
backup_user.user_nev,
backup_szerv.szerv_id,
backup_szerv.szerv_nev,
backup_szerv.szerv_adkod,
backup_szerv.szerv_sm_kod,
backup_adat_".$ev."_teny_3_1_1.rogzitett_teny3_ora_egesz,

backup_pojekt.projekt_tagv_kod,

IF(backup_pojekt.projekt_szolg_kod IS NULL,backup_szerv.szerv_szolg_kod,backup_pojekt.projekt_szolg_kod) AS akt_szolg_kod,

backup_ver.backup_ver_ho 
FROM `backup_adat_".$ev."_teny_3_1_1`
left join backup_user ON backup_user.backup_user_id = backup_adat_".$ev."_teny_3_1_1.backup_user_id
left join backup_szerv ON backup_szerv.backup_szerv_id  = backup_adat_".$ev."_teny_3_1_1.backup_szerv_id 
left join backup_pojekt ON backup_pojekt.backup_pojekt_id = backup_adat_".$ev."_teny_3_1_1.backup_pojekt_id
left join backup_ver ON backup_ver.backup_ver_id = backup_adat_".$ev."_teny_3_1_1.backup_ver_id
".$where."
order by backup_pojekt.projekt_tagv_kod asc, 
backup_szerv.szerv_nev asc,
backup_user.user_nev asc
";

//print $sql."<br>";exit;
 
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  
  if(!isset($eredmeny_keres[$adatom['projekt_tagv_kod']][$adatom['akt_szolg_kod']][$adatom['szerv_id']])){
   $eredmeny_keres[$adatom['projekt_tagv_kod']][$adatom['akt_szolg_kod']][$adatom['szerv_id']]=array();
   $eredmeny_keres[$adatom['projekt_tagv_kod']][$adatom['akt_szolg_kod']][$adatom['szerv_id']]['szerv_nev']=$adatom['szerv_nev'];
   $eredmeny_keres[$adatom['projekt_tagv_kod']][$adatom['akt_szolg_kod']][$adatom['szerv_id']]['szerv_adkod']=$adatom['szerv_adkod'];
   $eredmeny_keres[$adatom['projekt_tagv_kod']][$adatom['akt_szolg_kod']][$adatom['szerv_id']]['szerv_sm_kod']=$adatom['szerv_sm_kod'];
   
   if($_POST['reszlet1']=='szerv'){
    $eredmeny_keres[$adatom['projekt_tagv_kod']][$adatom['akt_szolg_kod']][$adatom['szerv_id']]['osszeg']['all']=0;
   }
  }
  
  if($_POST['reszlet1']=='szerv'){
   if(!isset($eredmeny_keres[$adatom['projekt_tagv_kod']][$adatom['akt_szolg_kod']][$adatom['szerv_id']]['egesz_ora_ho'][$adatom['backup_ver_ho']]))
	   $eredmeny_keres[$adatom['projekt_tagv_kod']][$adatom['akt_szolg_kod']][$adatom['szerv_id']]['egesz_ora_ho'][$adatom['backup_ver_ho']]=0;
   $eredmeny_keres[$adatom['projekt_tagv_kod']][$adatom['akt_szolg_kod']][$adatom['szerv_id']]['egesz_ora_ho'][$adatom['backup_ver_ho']]+=$adatom['rogzitett_teny3_ora_egesz'];
   $eredmeny_keres[$adatom['projekt_tagv_kod']][$adatom['akt_szolg_kod']][$adatom['szerv_id']]['osszeg']['all']+=$adatom['rogzitett_teny3_ora_egesz'];
  }
  
  $eredmeny_keres[$adatom['projekt_tagv_kod']][$adatom['akt_szolg_kod']][$adatom['szerv_id']]['user'][$adatom['user_ad']]['nev']=$adatom['user_nev'];
  
  if(!isset($eredmeny_keres[$adatom['projekt_tagv_kod']][$adatom['akt_szolg_kod']][$adatom['szerv_id']]['user'][$adatom['user_ad']]['egesz_ora'])){
   $eredmeny_keres[$adatom['projekt_tagv_kod']][$adatom['akt_szolg_kod']][$adatom['szerv_id']]['user'][$adatom['user_ad']]['egesz_ora']=0;
  }
  $eredmeny_keres[$adatom['projekt_tagv_kod']][$adatom['akt_szolg_kod']][$adatom['szerv_id']]['user'][$adatom['user_ad']]['egesz_ora']+=$adatom['rogzitett_teny3_ora_egesz'];
 
  //Hós hülyeség - eleje
  if(!isset($eredmeny_keres[$adatom['projekt_tagv_kod']][$adatom['akt_szolg_kod']][$adatom['szerv_id']]['user'][$adatom['user_ad']]['egesz_ora_ho'][$adatom['backup_ver_ho']])){
   $eredmeny_keres[$adatom['projekt_tagv_kod']][$adatom['akt_szolg_kod']][$adatom['szerv_id']]['user'][$adatom['user_ad']]['egesz_ora_ho'][$adatom['backup_ver_ho']]=0;
  }
  $eredmeny_keres[$adatom['projekt_tagv_kod']][$adatom['akt_szolg_kod']][$adatom['szerv_id']]['user'][$adatom['user_ad']]['egesz_ora_ho'][$adatom['backup_ver_ho']]+=$adatom['rogzitett_teny3_ora_egesz'];
  //Hós hülyeség - vége
 
 }

return $eredmeny_keres;

}

function keress_riport_ful_ki_evho_hoki_terv($ev){
 $eredmeny_keres="";
 
 $sql="SELECT 
 backup_terv.backup_terv_ho 
 FROM `backup_terv`
 where 
 backup_terv.backup_terv_ev ='".$ev."' 
 group by backup_terv.backup_terv_ho 
 order by backup_terv.backup_terv_ho asc
 ";
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom['backup_terv_ho'];
 }
 return $eredmeny_keres;
}

function keress_riport_ful_ki_evho_hoki($ev){
 $eredmeny_keres="";
 
 $sql="SELECT 
 backup_ver.backup_ver_ho 
 FROM `backup_ver`
 where 
 backup_ver.backup_ver_ev='".$ev."' and 
 backup_ver.backup_ver_default='1' and 
 backup_ver.backup_ver_teny3_1_1 = '1' 
 group by backup_ver.backup_ver_ho 
 order by backup_ver.backup_ver_ho asc
 ";
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom['backup_ver_ho'];
 }
 return $eredmeny_keres;
}

function keress_riport_ful_ki_evho_teny311_excelhez($ev){
 $eredmeny_keres="";
 
 $sql="SELECT 
 backup_ver.backup_ver_id
 FROM `backup_ver`
 where 
 backup_ver.backup_ver_ev='".$ev."' and 
 backup_ver.backup_ver_default='1' and 
 backup_ver.backup_ver_teny3_1_1 = '1' 
 order by backup_ver.backup_ver_ev asc, backup_ver.backup_ver_ho asc
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom['backup_ver_id'];
 }
 return $eredmeny_keres;
}

function keress_riport_ful_ki_evho_teny311_excelhez_hobol($ev,$ho){
 $eredmeny_keres="";
$tomb_ho=explode("#",$ho);

$where="";
$where_h="";
if(is_array($tomb_ho)){
foreach($tomb_ho as $ho){
 if($where_h!='')$where_h.='or';
 $where_h.="(backup_ver.backup_ver_ho='".$ho."')";
}
$where='('.$where_h.')';
}
	 
 $sql="SELECT 
 backup_ver.backup_ver_id
 FROM `backup_ver`
 where 
 backup_ver.backup_ver_ev='".$ev."' and 
 backup_ver.backup_ver_default='1' and 
 backup_ver.backup_ver_teny3_1_1 = '1' 
 and ".$where."
 order by backup_ver.backup_ver_ev asc, backup_ver.backup_ver_ho asc
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom['backup_ver_id'];
 }
 return $eredmeny_keres;
}

function keress_riport_teny3_szolgkod_nev($ev,$ho){
$eredmeny_keres='';

$where='';
$where_h='';

if($ho=='all'){
 //Lekeressük az érvényes backup_ver_id értékeket
 $tomb_backup_ver_id=keress_riport_ful_ki_evho_teny311_excelhez($ev);
}else{
 $tomb_backup_ver_id=explode("#",$ho);
}

  if(is_array($tomb_backup_ver_id)){
  foreach($tomb_backup_ver_id as $backup_ver_id){
	 if($where_h!='')$where_h.='or';
	 $where_h.="(backup_szolg_kod.backup_ver_id='".$backup_ver_id."')";
  }
  $where=' where ('.$where_h.')';
  //$where=' where backup_adat_2024_teny_3_2.backup_szerv_id= "219" and ('.$where_h.')';
 }else{
	 echo 'adathiányho';
 }
 
$sql="SELECT 
backup_szolg_kod.szolg_kod,
backup_szolg_kod.szolg_kod_nev
FROM `backup_szolg_kod`
".$where;
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szolg_kod']]=$adatom['szolg_kod_nev'];
 }
return $eredmeny_keres;
}

function keress_riport_teny3_tagvkod_nev($ev,$ho){
$eredmeny_keres='';

$where='';
$where_h='';

if($ho=='all'){
 //Lekeressük az érvényes backup_ver_id értékeket
 $tomb_backup_ver_id=keress_riport_ful_ki_evho_teny311_excelhez($ev);
}else{
 $tomb_backup_ver_id=explode("#",$ho);
}

  if(is_array($tomb_backup_ver_id)){
  foreach($tomb_backup_ver_id as $backup_ver_id){
	 if($where_h!='')$where_h.='or';
	 $where_h.="(backup_tagv_kod.backup_ver_id='".$backup_ver_id."')";
  }
  $where=' where ('.$where_h.')';
  //$where=' where backup_adat_2024_teny_3_2.backup_szerv_id= "219" and ('.$where_h.')';
 }else{
	 echo 'adathiányho';
 }
 
$sql="SELECT 
backup_tagv_kod.tagv_kod,
backup_tagv_kod.tagv_kod_nev
FROM `backup_tagv_kod`

".$where;
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['tagv_kod']]=$adatom['tagv_kod_nev'];
 }
return $eredmeny_keres;
}

function excel_oszlop_betu($oszlop) {
    if ($oszlop <= 0) {
        return '';
    }
    $mod = ($oszlop - 1) % 26;
    return excel_oszlop_betu((int)(($oszlop - 1) / 26)) . chr(65 + $mod);
}
?>