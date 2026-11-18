<?php
ini_set('memory_limit','2G');

include_once('ajax_ful_admin_backup_func_db_ev.php');

function admin_backup_terv_1_del(){

$tomb=keres_mit1('backup_ver','backup_ver_id',$_POST['backup_ver_id']);

if(!is_array($tomb)){
 echo 'Mentés nem található!';
 exit;
}
if(db_table_letezik_e('backup_adat_'.$tomb[0]['backup_ver_ev'].'_teny_1')){
torles('backup_adat_'.$tomb[0]['backup_ver_ev'].'_teny_1','backup_ver_id',$_POST['backup_ver_id']);

$tmp_mod=array();
$tmp_mod[0]['backup_ver_teny1']=0;
$tmp_mod[0]['backup_ver_teny1_keszito_ad']=null;
$tmp_mod[0]['backup_ver_teny1_update_time']=null;
mod_egy_fel_tom('backup_ver',$tmp_mod[0],'backup_ver_id',$_POST['backup_ver_id']);
}
echo 'ok$;$';
}

function admin_backup_terv_2_del(){

$tomb=keres_mit1('backup_ver','backup_ver_id',$_POST['backup_ver_id']);

if(!is_array($tomb)){
 echo 'Mentés nem található!';
 exit;
}
if(db_table_letezik_e('backup_adat_'.$tomb[0]['backup_ver_ev'].'_teny_2')){
torles('backup_adat_'.$tomb[0]['backup_ver_ev'].'_teny_2','backup_ver_id',$_POST['backup_ver_id']);

$tmp_mod=array();
$tmp_mod[0]['backup_ver_teny2']=0;
$tmp_mod[0]['backup_ver_teny2_keszito_ad']=null;
$tmp_mod[0]['backup_ver_teny2_update_time']=null;
mod_egy_fel_tom('backup_ver',$tmp_mod[0],'backup_ver_id',$_POST['backup_ver_id']);
}
echo 'ok$;$';
}

function admin_backup_terv_3_1_del(){

$tomb=keres_mit1('backup_ver','backup_ver_id',$_POST['backup_ver_id']);

if(!is_array($tomb)){
 echo 'Mentés nem található!';
 exit;
}

if(db_table_letezik_e('backup_adat_'.$tomb[0]['backup_ver_ev'].'_teny_3_1')){
torles('backup_adat_'.$tomb[0]['backup_ver_ev'].'_teny_3_1','backup_ver_id',$_POST['backup_ver_id']);

$tmp_mod=array();
$tmp_mod[0]['backup_ver_teny3_1']=0;
$tmp_mod[0]['backup_ver_teny3_1_keszito_ad']=null;
$tmp_mod[0]['backup_ver_teny3_1_update_time']=null;
mod_egy_fel_tom('backup_ver',$tmp_mod[0],'backup_ver_id',$_POST['backup_ver_id']);
}
admin_backup_terv_3_1_1_del();

echo 'ok$;$';
}

function admin_backup_terv_3_1_1_del(){

$tomb=keres_mit1('backup_ver','backup_ver_id',$_POST['backup_ver_id']);

if(!is_array($tomb)){
 echo 'Mentés nem található!';
 exit;
}

if(db_table_letezik_e('backup_adat_'.$tomb[0]['backup_ver_ev'].'_teny_3_1_1')){
torles('backup_adat_'.$tomb[0]['backup_ver_ev'].'_teny_3_1_1','backup_ver_id',$_POST['backup_ver_id']);

$tmp_mod=array();
$tmp_mod[0]['backup_ver_teny3_1_1']=0;
$tmp_mod[0]['backup_ver_teny3_1_1_keszito_ad']=null;
$tmp_mod[0]['backup_ver_teny3_1_1_update_time']=null;
mod_egy_fel_tom('backup_ver',$tmp_mod[0],'backup_ver_id',$_POST['backup_ver_id']);

}

admin_backup_terv_3_2_del();
admin_backup_terv_3_del();



echo 'ok$;$';
}

function admin_backup_terv_3_3_del(){
$tomb=keres_mit1('backup_ver','backup_ver_id',$_POST['backup_ver_id']);

if(!is_array($tomb)){
 echo 'Mentés nem található!';
 exit;
}

if(db_table_letezik_e('backup_adat_'.$tomb[0]['backup_ver_ev'].'_teny_3_3')){
torles('backup_adat_'.$tomb[0]['backup_ver_ev'].'_teny_3_3','backup_ver_id',$_POST['backup_ver_id']);

$tmp_mod=array();
$tmp_mod[0]['backup_ver_teny3_3']=0;
$tmp_mod[0]['backup_ver_teny3_3_keszito_ad']=null;
$tmp_mod[0]['backup_ver_teny3_3_update_time']=null;
mod_egy_fel_tom('backup_ver',$tmp_mod[0],'backup_ver_id',$_POST['backup_ver_id']);
}

//admin_backup_terv_3_del();

echo 'ok$;$';
}

function admin_backup_terv_3_2_del(){
$tomb=keres_mit1('backup_ver','backup_ver_id',$_POST['backup_ver_id']);

if(!is_array($tomb)){
 echo 'Mentés nem található!';
 exit;
}

if(db_table_letezik_e('backup_adat_'.$tomb[0]['backup_ver_ev'].'_teny_3_2')){
torles('backup_adat_'.$tomb[0]['backup_ver_ev'].'_teny_3_2','backup_ver_id',$_POST['backup_ver_id']);

$tmp_mod=array();
$tmp_mod[0]['backup_ver_teny3_2']=0;
$tmp_mod[0]['backup_ver_teny3_2_keszito_ad']=null;
$tmp_mod[0]['backup_ver_teny3_2_update_time']=null;
mod_egy_fel_tom('backup_ver',$tmp_mod[0],'backup_ver_id',$_POST['backup_ver_id']);
}

admin_backup_terv_3_del();
admin_backup_terv_3_3_del();
echo 'ok$;$';
}


function admin_backup_terv_3_del(){

$tomb=keres_mit1('backup_ver','backup_ver_id',$_POST['backup_ver_id']);

if(!is_array($tomb)){
 echo 'Mentés nem található!';
 exit;
}

if(db_table_letezik_e('backup_adat_'.$tomb[0]['backup_ver_ev'].'_teny_3')){
torles('backup_adat_'.$tomb[0]['backup_ver_ev'].'_teny_3','backup_ver_id',$_POST['backup_ver_id']);

$tmp_mod=array();
$tmp_mod[0]['backup_ver_teny3']=0;
$tmp_mod[0]['backup_ver_teny3_keszito_ad']=null;
$tmp_mod[0]['backup_ver_teny3_update_time']=null;
mod_egy_fel_tom('backup_ver',$tmp_mod[0],'backup_ver_id',$_POST['backup_ver_id']);
}
echo 'ok$;$';
}





function admin_backup_terv_1pont_proc($ev,$backup_ver_id){
//mit csinál: 1. Felhasználókénti havi összesítés

//1.Korábbi számításokat töröljük
torles('backup_adat_'.$ev.'_teny_1','backup_ver_id',$backup_ver_id);

//2. Kalkuláció.
//2.1 .Adatok lekérése
$tomb=keress_terv_1pont($ev,$backup_ver_id);

//2.1.1 Óra-perc átalakítás
$tomb_ered='';
if(is_array($tomb)){
	//$tomb_ered=array();
 foreach($tomb as $backup_user_id => $ert){
		
		$tmp_adat=array();
		$tmp_adat[0]['backup_ver_id']=$backup_ver_id;
		$tmp_adat[0]['backup_user_id']=$backup_user_id;
		$tmp_adat[0]['rogzitett_teny1_ora_egesz']=round( ( $ert['ora'] + ($ert['perc']/60) ),2);
		$tmp_adat[0]['rogzitett_teny1_ora']=$ert['ora'];
		$tmp_adat[0]['rogzitett_teny1_perc']=$ert['perc'];
 
		be_visz_insert_simabackup("backup_adat_".$ev."_teny_1",$tmp_adat);
		
 }
unset($tomb);
}

$tmp_mod=array();
$tmp_mod[0]['backup_ver_teny1']=1;
$tmp_mod[0]['backup_ver_teny1_keszito_ad']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
$tmp_mod[0]['backup_ver_teny1_update_time']=date("Y-m-d H:i:s",time());
mod_egy_fel_tom('backup_ver',$tmp_mod[0],'backup_ver_id',$_POST['backup_ver_id']);

 return 'ok';
}

function keress_terv_1pont($ev,$backup_ver_id){
 $eredmeny_keres='';
  
 //backup_pojekt.projekt_szolg_kod,
 //backup_szerv.szerv_szolg_kod
  //if(backup_pojekt.projekt_szolg_kod !='', backup_pojekt.projekt_szolg_kod,backup_szerv.szerv_szolg_kod) as projekt_szolg_kod
 
 
 
 $sql="SELECT 
 backup_adat_".$ev.".backup_rogzit_ora,
 backup_adat_".$ev.".backup_rogzit_perc,
 backup_adat_".$ev.".backup_user_id

 FROM `backup_adat_".$ev."` 

 where 
 backup_adat_".$ev.".backup_ver_id='".$backup_ver_id."'
 ";
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  

  if(!isset($eredmeny_keres[$adatom['backup_user_id']])){
	 $eredmeny_keres[$adatom['backup_user_id']]=array();
	 $eredmeny_keres[$adatom['backup_user_id']]['ora']=0;
	 $eredmeny_keres[$adatom['backup_user_id']]['perc']=0;
  }
  
  $eredmeny_keres[$adatom['backup_user_id']]['ora']+=$adatom['backup_rogzit_ora'];
  $eredmeny_keres[$adatom['backup_user_id']]['perc']+=$adatom['backup_rogzit_perc'];

 }

 return $eredmeny_keres;
}



function admin_backup_terv_2pont_proc($ev,$backup_ver_id){
//mit csinál: 2. Szervezeteként havi összesítés

//1.Korábbi számításokat töröljük
torles('backup_adat_'.$ev.'_teny_2','backup_ver_id',$backup_ver_id);

//2. Kalkuláció.
//2.1 .Adatok lekérése
$tomb=keress_terv_2pont($ev,$backup_ver_id);

//2.1.1 Óra-perc átalakítás
$tomb_ered='';
if(is_array($tomb)){
	//$tomb_ered=array();
 foreach($tomb as $backup_szerv_id => $ert){
		
		$tmp_adat=array();
		$tmp_adat[0]['backup_ver_id']=$backup_ver_id;
		$tmp_adat[0]['backup_szerv_id']=$backup_szerv_id;
		$tmp_adat[0]['rogzitett_teny2_ora_egesz']=round( ( $ert['ora'] + ($ert['perc']/60) ),2);
		$tmp_adat[0]['rogzitett_teny2_ora']=$ert['ora'];
		$tmp_adat[0]['rogzitett_teny2_perc']=$ert['perc'];
 
		be_visz_insert_simabackup("backup_adat_".$ev."_teny_2",$tmp_adat);
		
 }
unset($tomb);
}

$tmp_mod=array();
$tmp_mod[0]['backup_ver_teny2']=1;
$tmp_mod[0]['backup_ver_teny2_keszito_ad']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
$tmp_mod[0]['backup_ver_teny2_update_time']=date("Y-m-d H:i:s",time());
mod_egy_fel_tom('backup_ver',$tmp_mod[0],'backup_ver_id',$_POST['backup_ver_id']);

 return 'ok';
}

function keress_terv_2pont($ev,$backup_ver_id){
 $eredmeny_keres='';
  
 //backup_pojekt.projekt_szolg_kod,
 //backup_szerv.szerv_szolg_kod
  //if(backup_pojekt.projekt_szolg_kod !='', backup_pojekt.projekt_szolg_kod,backup_szerv.szerv_szolg_kod) as projekt_szolg_kod
 
 
 
 $sql="SELECT 
 backup_adat_".$ev.".backup_rogzit_ora,
 backup_adat_".$ev.".backup_rogzit_perc,
 backup_adat_".$ev.".backup_szerv_id

 FROM `backup_adat_".$ev."` 

 where 
 backup_adat_".$ev.".backup_ver_id='".$backup_ver_id."'
 ";
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  

  if(!isset($eredmeny_keres[$adatom['backup_szerv_id']])){
	 $eredmeny_keres[$adatom['backup_szerv_id']]=array();
	 $eredmeny_keres[$adatom['backup_szerv_id']]['ora']=0;
	 $eredmeny_keres[$adatom['backup_szerv_id']]['perc']=0;
  }
  
  $eredmeny_keres[$adatom['backup_szerv_id']]['ora']+=$adatom['backup_rogzit_ora'];
  $eredmeny_keres[$adatom['backup_szerv_id']]['perc']+=$adatom['backup_rogzit_perc'];

 }

 return $eredmeny_keres;
}






function admin_backup_terv_3_1pont_proc($ev,$backup_ver_id){
//mit csinál: 3.1 felhasználónként Tevékenység kód(SPLU kód) és cég alapján összesítés - ez alapján lesz a terv

//1.Korábbi számításokat töröljük
torles('backup_adat_'.$ev.'_teny_3_1','backup_ver_id',$backup_ver_id);

//2. Kalkuláció.
//2.1 .Adatok lekérése
$tomb=keress_terv_3_1pont($ev,$backup_ver_id);

//2.1.1 Óra-perc átalakítás
$tomb_ered='';
if(is_array($tomb)){
	//$tomb_ered=array();
 foreach($tomb as $user_id => $tomb1){
	 foreach($tomb1 as $backup_pojekt_id => $ert){
		
		$tmp_adat=array();
		$tmp_adat[0]['backup_ver_id']=$backup_ver_id;
		$tmp_adat[0]['backup_user_id']=$user_id;
		$tmp_adat[0]['backup_szerv_id']=$ert['backup_szerv_id'];
		$tmp_adat[0]['backup_pojekt_id']=$backup_pojekt_id;
		$tmp_adat[0]['rogzitett_teny3_ora_egesz']=round( ( $ert['ora'] + ($ert['perc']/60) ),2);
		$tmp_adat[0]['rogzitett_teny3_ora']=$ert['ora'];
		$tmp_adat[0]['rogzitett_teny3_perc']=$ert['perc'];
 
		be_visz_insert_simabackup("backup_adat_".$ev."_teny_3_1",$tmp_adat);

	 }
  }
unset($tomb);
}

$tmp_mod=array();
$tmp_mod[0]['backup_ver_teny3_1']=1;
$tmp_mod[0]['backup_ver_teny3_1_keszito_ad']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
$tmp_mod[0]['backup_ver_teny3_1_update_time']=date("Y-m-d H:i:s",time());
mod_egy_fel_tom('backup_ver',$tmp_mod[0],'backup_ver_id',$_POST['backup_ver_id']);

 return 'ok';
}

function keress_terv_3_1pont($ev,$backup_ver_id){
 $eredmeny_keres='';
 
 $sql="SELECT 
 backup_adat_".$ev.".backup_user_id,
 backup_adat_".$ev.".backup_szerv_id,
 backup_adat_".$ev.".backup_pojekt_id,
 backup_adat_".$ev.".backup_rogzit_ora,
 backup_adat_".$ev.".backup_rogzit_perc
 FROM `backup_adat_".$ev."` 
 left join backup_szerv ON backup_szerv.backup_szerv_id = backup_adat_".$ev.".backup_szerv_id
 left join backup_user ON backup_user.backup_user_id = backup_adat_".$ev.".backup_user_id
 where 
 backup_adat_".$ev.".backup_ver_id='".$backup_ver_id."'
 and backup_adat_".$ev.".backup_pojekt_id is not null
 ";
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  
  if(!isset($eredmeny_keres[$adatom['backup_user_id']]))
	 $eredmeny_keres[$adatom['backup_user_id']]=array();
 
  if(!isset($eredmeny_keres[$adatom['backup_user_id']][$adatom['backup_pojekt_id']])){
	 $eredmeny_keres[$adatom['backup_user_id']][$adatom['backup_pojekt_id']]=array();
	 $eredmeny_keres[$adatom['backup_user_id']][$adatom['backup_pojekt_id']]['ora']=0;
	 $eredmeny_keres[$adatom['backup_user_id']][$adatom['backup_pojekt_id']]['perc']=0;
	 $eredmeny_keres[$adatom['backup_user_id']][$adatom['backup_pojekt_id']]['backup_szerv_id']=$adatom['backup_szerv_id'];
 }
  
  $eredmeny_keres[$adatom['backup_user_id']][$adatom['backup_pojekt_id']]['ora']+=$adatom['backup_rogzit_ora'];
  $eredmeny_keres[$adatom['backup_user_id']][$adatom['backup_pojekt_id']]['perc']+=$adatom['backup_rogzit_perc'];
  
/*
  echo '<br><br><pre>';
  print_r($eredmeny_keres);
  echo '</pre>';
  
  echo '<br><br><pre>';
  print_r($adatom);
  echo '</pre>';
  exit;
*/

 }
 

 return $eredmeny_keres;
}


function admin_backup_terv_3_1_1pont_proc($ev,$backup_ver_id){
//mit csinál: 3.1 táblát szétbontja a backup_projekt_szetbontas tábla alapján

//1.Korábbi számításokat töröljük
torles('backup_adat_'.$ev.'_teny_3_1_1','backup_ver_id',$backup_ver_id);

//2. Kalkuláció.
//2.1 .Adatok lekérése szétontáshoz
$tomb_szetbont=keress_terv_3_1_1pont_szetbont($backup_ver_id);

//2.2 szétbontott korábbi adatok lekérése és arányosítá
$tomb=keress_terv_3_1_1pont($ev,$backup_ver_id,$tomb_szetbont);
unset($tomb_szetbont);
 /*echo '<pre>';
 print_r($tomb);
 echo '</pre>';*/
 ment_terv_3_1_1($ev,$backup_ver_id,$tomb);
 
$tmp_mod=array();
$tmp_mod[0]['backup_ver_teny3_1_1']=1;
$tmp_mod[0]['backup_ver_teny3_1_1_keszito_ad']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
$tmp_mod[0]['backup_ver_teny3_1_1_update_time']=date("Y-m-d H:i:s",time());
mod_egy_fel_tom('backup_ver',$tmp_mod[0],'backup_ver_id',$_POST['backup_ver_id']);

 return 'ok';
  
}

function ment_terv_3_1_1($ev,$backup_ver_id,$tomb){

		$tmp_adat=array();
		
		/*
		$tmp_adat[0]['backup_pojekt_id']=$backup_pojekt_id;
		$tmp_adat[0]['rogzitett_teny3_ora_egesz']=round( ( $ert['ora'] + ($ert['perc']/60) ),2);
		$tmp_adat[0]['rogzitett_teny3_ora']=$ert['ora'];
		$tmp_adat[0]['rogzitett_teny3_perc']=$ert['perc'];
 
		be_visz_insert_simabackup("backup_adat_".$ev."_teny_3_1",$tmp_adat)
		*/
 $i=0;
 if(is_array($tomb)){
 foreach($tomb as $user_id => $ert2){
  foreach($ert2 as $pojekt_id => $ert ){
  $i++;
  $tmp_adat[$i]['backup_ver_id']=$backup_ver_id;
  $tmp_adat[$i]['backup_user_id']=$user_id;
  $tmp_adat[$i]['backup_szerv_id']=$ert['backup_szerv_id'];
  $tmp_adat[$i]['backup_pojekt_id']=$pojekt_id;
  $tmp_adat[$i]['rogzitett_teny3_ora_egesz']=$ert['ora_egesz'];
  $tmp_adat[$i]['rogzitett_teny3_ora']=$ert['ora'];
  $tmp_adat[$i]['rogzitett_teny3_perc']=$ert['perc'];
 }
 }
 }
 unset($tomb);
 be_visz_insert_simabackup("backup_adat_".$ev."_teny_3_1_1",$tmp_adat);
}

function keress_terv_3_1_1pont($ev,$backup_ver_id,$tomb_szetbont){
 $eredmeny_keres='';
 $backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_ver_id);
 $sql="SELECT 
  backup_adat_".$ev."_teny_3_1.backup_user_id,
  backup_adat_".$ev."_teny_3_1.backup_szerv_id,
  backup_adat_".$ev."_teny_3_1.backup_pojekt_id,
  backup_adat_".$ev."_teny_3_1.rogzitett_teny3_ora_egesz,
  backup_adat_".$ev."_teny_3_1.rogzitett_teny3_ora,
  backup_adat_".$ev."_teny_3_1.rogzitett_teny3_perc
  FROM `backup_adat_".$ev."_teny_3_1` 
  where 
  backup_adat_".$ev."_teny_3_1.backup_ver_id = '".$backup_ver_id."'
 ";
 
 //csak fejlesztéshez
 /*
 $sql.="
 and backup_adat_".$ev."_teny_3_1.backup_pojekt_id ='10683'
 ";
 */
 
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
 if(!is_array($eredmeny_keres))$eredmeny_keres=array();;

 if(!isset($eredmeny_keres[$adatom['backup_user_id']]))
  $eredmeny_keres[$adatom['backup_user_id']]=array();

 //Ha a  szétbontás-ban létezik a projekt_id, akkor ezt szét kell bontani! létezik
 if(isset($tomb_szetbont[$adatom['backup_pojekt_id']])){
	foreach($tomb_szetbont[$adatom['backup_pojekt_id']] as $uj_pojekt_id => $arany){
		//echo 'óra: '.$adatom['rogzitett_teny3_ora'];
		//echo '<br>perc: '.$adatom['rogzitett_teny3_perc'];
		$all_perc=$adatom['rogzitett_teny3_ora']*60+$adatom['rogzitett_teny3_perc'];
		//echo '<br>össz perc: '.$all_perc;
		
		//echo '<br>arány: '.$arany;
		//echo '<br>arány érték: '.($arany/100);
		$ered_perc=($adatom['rogzitett_teny3_ora']*60+$adatom['rogzitett_teny3_perc'])*($arany/100);
		//echo '<br>Eredmeny: '.$ered_perc;
		
		$ered_v_ora=intval($ered_perc/60);
		 $ered_v_perc=round($ered_perc-($ered_v_ora*60),4);
		//$ered_v_perc=$ered_perc%60;
		
		//echo '<br>Eredmeny óra: '.$ered_v_ora;
		//echo '<br>Eredmeny perc: '.$ered_v_perc;
		  $egeszzam_ora=$ered_v_ora;
		  $egeszzam_ora+=$ered_v_perc/60;
		//echo '<br>Eredmeny egész óra: '.round($egeszzam_ora,2);
		//echo '<br><br>';
		
	if(!isset($eredmeny_keres[$adatom['backup_user_id']][$uj_pojekt_id])){
	 $eredmeny_keres[$adatom['backup_user_id']][$uj_pojekt_id]=array();
	 $eredmeny_keres[$adatom['backup_user_id']][$uj_pojekt_id]['ora_egesz']=0;
	 $eredmeny_keres[$adatom['backup_user_id']][$uj_pojekt_id]['ora']=0;
	 $eredmeny_keres[$adatom['backup_user_id']][$uj_pojekt_id]['perc']=0;
	 $eredmeny_keres[$adatom['backup_user_id']][$uj_pojekt_id]['backup_szerv_id']=$adatom['backup_szerv_id'];
	}
	
	 $eredmeny_keres[$adatom['backup_user_id']][$uj_pojekt_id]['ora_egesz']+=$egeszzam_ora;
	 $eredmeny_keres[$adatom['backup_user_id']][$uj_pojekt_id]['ora']+=$ered_v_ora;
	 $eredmeny_keres[$adatom['backup_user_id']][$uj_pojekt_id]['perc']+=$ered_v_perc;
		
	}	
 }else{//Ha nincs szétbontás
	if(!isset($eredmeny_keres[$adatom['backup_user_id']][$adatom['backup_pojekt_id']])){
	 $eredmeny_keres[$adatom['backup_user_id']][$adatom['backup_pojekt_id']]=array();
	 $eredmeny_keres[$adatom['backup_user_id']][$adatom['backup_pojekt_id']]['ora_egesz']=0;
	 $eredmeny_keres[$adatom['backup_user_id']][$adatom['backup_pojekt_id']]['ora']=0;
	 $eredmeny_keres[$adatom['backup_user_id']][$adatom['backup_pojekt_id']]['perc']=0;
	 $eredmeny_keres[$adatom['backup_user_id']][$adatom['backup_pojekt_id']]['backup_szerv_id']=$adatom['backup_szerv_id'];
	}
	
	 $eredmeny_keres[$adatom['backup_user_id']][$adatom['backup_pojekt_id']]['ora_egesz']+=$adatom['rogzitett_teny3_ora_egesz'];
	 $eredmeny_keres[$adatom['backup_user_id']][$adatom['backup_pojekt_id']]['ora']+=$adatom['rogzitett_teny3_ora'];
	 $eredmeny_keres[$adatom['backup_user_id']][$adatom['backup_pojekt_id']]['perc']+=$adatom['rogzitett_teny3_perc'];
 }
   
 }

 return $eredmeny_keres;
 
}

function keress_terv_3_1_1pont_szetbont($backup_ver_id){
 $eredmeny_keres='';
 $backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_ver_id);
 $sql="SELECT 
  backup_projekt_szetbontas.backup_pojekt_id,
  backup_projekt_szetbontas.szetbont_backup_pojekt_id,
  backup_projekt_szetbontas.szetbont_arany
  FROM `backup_projekt_szetbontas` 
  where 
  backup_projekt_szetbontas.backup_ver_id = '".$backup_ver_id."'
 ";
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();;
  $eredmeny_keres[$adatom['backup_pojekt_id']][$adatom['szetbont_backup_pojekt_id']]=$adatom['szetbont_arany'];
 }
 return $eredmeny_keres;
}

function admin_backup_terv_3_3pont_proc($ev,$backup_ver_id){
//mit csinál: 3.2 alapján tevékenység alapján összevon

//1.Korábbi számításokat töröljük
torles('backup_adat_'.$ev.'_teny_3_3','backup_ver_id',$backup_ver_id);

//2. Kalkuláció.
//2.1 .Adatok lekérése
$tomb=keress_terv_3_3pont($ev,$backup_ver_id);

//2.1.1 Óra-perc átalakítás
$tomb_ered='';
if(is_array($tomb)){
	//$tomb_ered=array();
	 foreach($tomb as $backup_pojekt_id => $ert){
		
		$tmp_adat=array();
		$tmp_adat[0]['backup_ver_id']=$backup_ver_id;
		$tmp_adat[0]['backup_pojekt_id']=$backup_pojekt_id;
		$tmp_adat[0]['rogzitett_teny3_ora_egesz']=round( ( $ert['ora'] + ($ert['perc']/60) ),2);
		$tmp_adat[0]['rogzitett_teny3_ora']=$ert['ora'];
		$tmp_adat[0]['rogzitett_teny3_perc']=$ert['perc'];
 
		be_visz_insert_simabackup("backup_adat_".$ev."_teny_3_3",$tmp_adat);
	 }
unset($tomb);
}

$tmp_mod=array();
$tmp_mod[0]['backup_ver_teny3_3']=1;
$tmp_mod[0]['backup_ver_teny3_3_keszito_ad']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
$tmp_mod[0]['backup_ver_teny3_3_update_time']=date("Y-m-d H:i:s",time());
mod_egy_fel_tom('backup_ver',$tmp_mod[0],'backup_ver_id',$_POST['backup_ver_id']);

 return 'ok';
}

function admin_backup_terv_3_2pont_proc($ev,$backup_ver_id){
//mit csinál: 3.1 Szervezetenként Tevékenység kód(SPLU kód) és cég alapján összesítés - ez alapján lesz a terv

//1.Korábbi számításokat töröljük
torles('backup_adat_'.$ev.'_teny_3_2','backup_ver_id',$backup_ver_id);

//2. Kalkuláció.
//2.1 .Adatok lekérése
$tomb=keress_terv_3_2pont($ev,$backup_ver_id);

//2.1.1 Óra-perc átalakítás
$tomb_ered='';
if(is_array($tomb)){
	//$tomb_ered=array();
 foreach($tomb as $szerv_id => $tomb1){
	 foreach($tomb1 as $backup_pojekt_id => $ert){
		
		$tmp_adat=array();
		$tmp_adat[0]['backup_ver_id']=$backup_ver_id;
		$tmp_adat[0]['backup_szerv_id']=$szerv_id;
		$tmp_adat[0]['backup_pojekt_id']=$backup_pojekt_id;
		$tmp_adat[0]['rogzitett_teny3_ora_egesz']=round( ( $ert['ora'] + ($ert['perc']/60) ),2);
		$tmp_adat[0]['rogzitett_teny3_ora']=$ert['ora'];
		$tmp_adat[0]['rogzitett_teny3_perc']=$ert['perc'];
 
		be_visz_insert_simabackup("backup_adat_".$ev."_teny_3_2",$tmp_adat);
	 }
  }
unset($tomb);
}

$tmp_mod=array();
$tmp_mod[0]['backup_ver_teny3_2']=1;
$tmp_mod[0]['backup_ver_teny3_2_keszito_ad']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
$tmp_mod[0]['backup_ver_teny3_2_update_time']=date("Y-m-d H:i:s",time());
mod_egy_fel_tom('backup_ver',$tmp_mod[0],'backup_ver_id',$_POST['backup_ver_id']);

 return 'ok';
}

function keress_terv_3_3pont($ev,$backup_ver_id){
 $eredmeny_keres='';
 
 $sql="SELECT 
 backup_adat_".$ev."_teny_3_2.backup_pojekt_id,
 backup_adat_".$ev."_teny_3_2.rogzitett_teny3_ora,
 backup_adat_".$ev."_teny_3_2.rogzitett_teny3_perc
 FROM `backup_adat_".$ev."_teny_3_2` 

 where 
 backup_adat_".$ev."_teny_3_2.backup_ver_id='".$backup_ver_id."'
 ";
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
 
  if(!isset($eredmeny_keres[$adatom['backup_pojekt_id']])){
	 $eredmeny_keres[$adatom['backup_pojekt_id']]=array();
	 $eredmeny_keres[$adatom['backup_pojekt_id']]['ora']=0;
	 $eredmeny_keres[$adatom['backup_pojekt_id']]['perc']=0;
  }
  
  $eredmeny_keres[$adatom['backup_pojekt_id']]['ora']+=$adatom['rogzitett_teny3_ora'];
  $eredmeny_keres[$adatom['backup_pojekt_id']]['perc']+=$adatom['rogzitett_teny3_perc'];
  
/*
  echo '<br><br><pre>';
  print_r($eredmeny_keres);
  echo '</pre>';
  
  echo '<br><br><pre>';
  print_r($adatom);
  echo '</pre>';
  exit;
*/

 }
 

 return $eredmeny_keres;
}

function keress_terv_3_2pont($ev,$backup_ver_id){
 $eredmeny_keres='';
 
 $sql="SELECT 
 backup_adat_".$ev."_teny_3_1_1.backup_szerv_id,
 backup_adat_".$ev."_teny_3_1_1.backup_pojekt_id,
 backup_adat_".$ev."_teny_3_1_1.rogzitett_teny3_ora,
 backup_adat_".$ev."_teny_3_1_1.rogzitett_teny3_perc
 FROM `backup_adat_".$ev."_teny_3_1_1` 
 left join backup_szerv ON backup_szerv.backup_szerv_id = backup_adat_".$ev."_teny_3_1_1.backup_szerv_id

 where 
 backup_adat_".$ev."_teny_3_1_1.backup_ver_id='".$backup_ver_id."'
 ";
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  
  if(!isset($eredmeny_keres[$adatom['backup_szerv_id']]))
	 $eredmeny_keres[$adatom['backup_szerv_id']]=array();
 
  if(!isset($eredmeny_keres[$adatom['backup_szerv_id']][$adatom['backup_pojekt_id']])){
	 $eredmeny_keres[$adatom['backup_szerv_id']][$adatom['backup_pojekt_id']]=array();
	 $eredmeny_keres[$adatom['backup_szerv_id']][$adatom['backup_pojekt_id']]['ora']=0;
	 $eredmeny_keres[$adatom['backup_szerv_id']][$adatom['backup_pojekt_id']]['perc']=0;
  }
  
  $eredmeny_keres[$adatom['backup_szerv_id']][$adatom['backup_pojekt_id']]['ora']+=$adatom['rogzitett_teny3_ora'];
  $eredmeny_keres[$adatom['backup_szerv_id']][$adatom['backup_pojekt_id']]['perc']+=$adatom['rogzitett_teny3_perc'];
  
/*
  echo '<br><br><pre>';
  print_r($eredmeny_keres);
  echo '</pre>';
  
  echo '<br><br><pre>';
  print_r($adatom);
  echo '</pre>';
  exit;
*/

 }
 

 return $eredmeny_keres;
}

/*
function keress_terv_3_2pont($ev,$backup_ver_id){
 $eredmeny_keres='';
 
 $sql="SELECT 
 backup_adat_".$ev.".backup_szerv_id,
 backup_adat_".$ev.".backup_pojekt_id,
 backup_adat_".$ev.".backup_rogzit_ora,
 backup_adat_".$ev.".backup_rogzit_perc
 FROM `backup_adat_".$ev."` 
 left join backup_szerv ON backup_szerv.backup_szerv_id = backup_adat_".$ev.".backup_szerv_id

 where 
 backup_adat_".$ev.".backup_ver_id='".$backup_ver_id."'
 ";
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  
  if(!isset($eredmeny_keres[$adatom['backup_szerv_id']]))
	 $eredmeny_keres[$adatom['backup_szerv_id']]=array();
 
  if(!isset($eredmeny_keres[$adatom['backup_szerv_id']][$adatom['backup_pojekt_id']])){
	 $eredmeny_keres[$adatom['backup_szerv_id']][$adatom['backup_pojekt_id']]=array();
	 $eredmeny_keres[$adatom['backup_szerv_id']][$adatom['backup_pojekt_id']]['ora']=0;
	 $eredmeny_keres[$adatom['backup_szerv_id']][$adatom['backup_pojekt_id']]['perc']=0;
  }  
  $eredmeny_keres[$adatom['backup_szerv_id']][$adatom['backup_pojekt_id']]['ora']+=$adatom['backup_rogzit_ora'];
  $eredmeny_keres[$adatom['backup_szerv_id']][$adatom['backup_pojekt_id']]['perc']+=$adatom['backup_rogzit_perc'];
 }
 return $eredmeny_keres;
}
*/






function admin_backup_terv_3pont_proc($ev,$backup_ver_id){
//mit csinál: 3. Tevékenység kód(SPLU kód) és cég alapján összesítés - ez alapján lesz a terv

//1.Korábbi számításokat töröljük
torles('backup_adat_'.$ev.'_teny_3','backup_ver_id',$backup_ver_id);

//2. Kalkuláció.
//2.1 .Adatok lekérése
$tomb=keress_terv_3pont($ev,$backup_ver_id);

//2.1.1 Óra-perc átalakítás
$tomb_ered='';
if(is_array($tomb)){
	//$tomb_ered=array();
 foreach($tomb as $szolg_kod => $tomb2){
	 foreach($tomb2 as $tagv_kod => $ert){
		
		$tmp_adat=array();
		$tmp_adat[0]['backup_ver_id']=$backup_ver_id;
		$tmp_adat[0]['projekt_tervkod']=$tagv_kod.$szolg_kod;
		$tmp_adat[0]['projekt_tagv_kod']=$tagv_kod;
		$tmp_adat[0]['projekt_szolg_kod']=$szolg_kod;
		$tmp_adat[0]['rogzitett_teny3_ora_egesz']=round( ( $ert['ora'] + ($ert['perc']/60) ),2);
		$tmp_adat[0]['rogzitett_teny3_ora']=$ert['ora'];
		$tmp_adat[0]['rogzitett_teny3_perc']=$ert['perc'];
 
		be_visz_insert_simabackup("backup_adat_".$ev."_teny_3",$tmp_adat);
		
	 }
 }
unset($tomb);
}

$tmp_mod=array();
$tmp_mod[0]['backup_ver_teny3']=1;
$tmp_mod[0]['backup_ver_teny3_keszito_ad']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
$tmp_mod[0]['backup_ver_teny3_update_time']=date("Y-m-d H:i:s",time());
mod_egy_fel_tom('backup_ver',$tmp_mod[0],'backup_ver_id',$_POST['backup_ver_id']);

 return 'ok';
}

function keress_terv_3pont($ev,$backup_ver_id){
 $eredmeny_keres='';

 $sql="SELECT 
 backup_adat_".$ev."_teny_3_2.rogzitett_teny3_ora,
 backup_adat_".$ev."_teny_3_2.rogzitett_teny3_perc,
 backup_pojekt.projekt_tagv_kod,
 if(backup_pojekt.projekt_szolg_kod !='', backup_pojekt.projekt_szolg_kod,backup_szerv.szerv_szolg_kod) as projekt_szolg_kod

 FROM `backup_adat_".$ev."_teny_3_2` 
 inner join backup_pojekt ON backup_pojekt.backup_pojekt_id  = backup_adat_".$ev."_teny_3_2.backup_pojekt_id 
 left join backup_szerv ON backup_szerv.backup_szerv_id = backup_adat_".$ev."_teny_3_2.backup_szerv_id
 
 where 
 backup_adat_".$ev."_teny_3_2.backup_ver_id='".$backup_ver_id."'
 and backup_pojekt.projekt_tagv_kod!=''
 ";
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  
  if(!isset($eredmeny_keres[$adatom['projekt_szolg_kod']]))
	 $eredmeny_keres[$adatom['projekt_szolg_kod']]=array();
  if(!isset($eredmeny_keres[$adatom['projekt_szolg_kod']][$adatom['projekt_tagv_kod']])){
	 $eredmeny_keres[$adatom['projekt_szolg_kod']][$adatom['projekt_tagv_kod']]=array();
	 $eredmeny_keres[$adatom['projekt_szolg_kod']][$adatom['projekt_tagv_kod']]['ora']=0;
	 $eredmeny_keres[$adatom['projekt_szolg_kod']][$adatom['projekt_tagv_kod']]['perc']=0;
  }
  
  $eredmeny_keres[$adatom['projekt_szolg_kod']][$adatom['projekt_tagv_kod']]['ora']+=$adatom['rogzitett_teny3_ora'];
  $eredmeny_keres[$adatom['projekt_szolg_kod']][$adatom['projekt_tagv_kod']]['perc']+=$adatom['rogzitett_teny3_perc'];
 
 }
 

 return $eredmeny_keres;
}

/*
function keress_terv_3pont($ev,$backup_ver_id){
 $eredmeny_keres='';
  
 //backup_pojekt.projekt_szolg_kod,
 //backup_szerv.szerv_szolg_kod
  //if(backup_pojekt.projekt_szolg_kod !='', backup_pojekt.projekt_szolg_kod,backup_szerv.szerv_szolg_kod) as projekt_szolg_kod
 
 
 
 $sql="SELECT 
 backup_adat_".$ev.".backup_rogzit_ora,
 backup_adat_".$ev.".backup_rogzit_perc,
 backup_pojekt.projekt_tagv_kod,
 if(backup_pojekt.projekt_szolg_kod !='', backup_pojekt.projekt_szolg_kod,backup_szerv.szerv_szolg_kod) as projekt_szolg_kod

 FROM `backup_adat_".$ev."` 
 inner join backup_pojekt ON backup_pojekt.backup_pojekt_id  = backup_adat_".$ev.".backup_pojekt_id 
 left join backup_szerv ON backup_szerv.backup_szerv_id = backup_adat_".$ev.".backup_szerv_id
 
 where 
 backup_adat_".$ev.".backup_ver_id='".$backup_ver_id."'
 and backup_pojekt.projekt_tagv_kod!=''
 ";
 //print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
  
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  
  if(!isset($eredmeny_keres[$adatom['projekt_szolg_kod']]))
	 $eredmeny_keres[$adatom['projekt_szolg_kod']]=array();
  if(!isset($eredmeny_keres[$adatom['projekt_szolg_kod']][$adatom['projekt_tagv_kod']])){
	 $eredmeny_keres[$adatom['projekt_szolg_kod']][$adatom['projekt_tagv_kod']]=array();
	 $eredmeny_keres[$adatom['projekt_szolg_kod']][$adatom['projekt_tagv_kod']]['ora']=0;
	 $eredmeny_keres[$adatom['projekt_szolg_kod']][$adatom['projekt_tagv_kod']]['perc']=0;
  }
  
  $eredmeny_keres[$adatom['projekt_szolg_kod']][$adatom['projekt_tagv_kod']]['ora']+=$adatom['backup_rogzit_ora'];
  $eredmeny_keres[$adatom['projekt_szolg_kod']][$adatom['projekt_tagv_kod']]['perc']+=$adatom['backup_rogzit_perc'];
 
 }
 

 return $eredmeny_keres;
}
*/


function admin_backup_terv_projektszetbont_del(){
if(
 (isset($_POST['backup_ver_id']))and
 ($_POST['backup_ver_id']!='')
){
 torles('backup_projekt_szetbontas','backup_ver_id',$_POST['backup_ver_id']);
 admin_backup_terv_3_1_1_del();
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

?>