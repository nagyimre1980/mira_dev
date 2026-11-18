<?php
ini_set('memory_limit','2G');

function admin_backup_terv_delete_proc(){
if(
 (isset($_POST['backup_ver_id']))and
 ($_POST['backup_ver_id']!='')
){
 torles('backup_ver','backup_ver_id',$_POST['backup_ver_id']);
 echo 'ok$;$'; 
}else{
 echo 'adathiány';
}
}

function admin_backup_masol_verle($ki_ev,$ho_ki){

  if($ho_ki<10)$ho_ki0="0".$ho_ki;
  else $ho_ki0=$ho_ki;

//Verziók lekérése
$ver_regi=keres_mit1_mit1_csak_ertek("backup_ver",'backup_ver_ev_ho',$ki_ev.'-'.$ho_ki0,'backup_ver_ver');

if($ver_regi==''){
 $ver_uj='1';
}else{
 $ver_uj=$ver_regi+1;
}
return $ver_uj;
}

function admin_backup_default_db($ki_ev,$ho_ki0){
$idoszak=$ki_ev.'-'.$ho_ki0;
$tomb_ver=keres_mit1('backup_ver','backup_ver_ev_ho',$idoszak);

echo '<select onchange="admin_backup_default_change(\''.$idoszak.'\')" id="admin_backup_terv_default_'.$idoszak.'" style="margin-left:10px" class="select3">';
echo '<option value="0">Kikapcsolva';
if(is_array($tomb_ver)){
foreach($tomb_ver as $ert){
 echo '<option value="'.$ert['backup_ver_id'].'"';
 if($ert['backup_ver_default']=='1') echo ' selected';
 echo '>Verzió: '.$ert['backup_ver_ver'].' ('.$ert['backup_ver_update_time'].')';
}
}
echo '</select>';
}

function admin_backup_masol($ki_ev,$ho_ki,$ho_ki0,$mas_lat){
echo '<span'.$mas_lat.' id="terv_lat_'.$ki_ev.'-'.$ho_ki0.'">';

$ver_uj=admin_backup_masol_verle($ki_ev,$ho_ki);

echo '<input onclick="admin_backup_masol_proc(\''.$ki_ev.'\',\''.$ho_ki.'\')" id="backup_atmasol_'.$ki_ev.$ho_ki.'" type="submit" class="submit2" value="Áttöltés, Verzió: '.$ver_uj.'">';


if($ver_uj=='1'){
 //echo ' <span class="pir_vas">Még nem készült áttöltés</span>';
}else{//Ekkor van mentés.
 admin_backup_terv_megnyit($ki_ev,$ho_ki,$ho_ki0);
}
echo '</span>';
}

function admin_backup_terv_megnyit($ki_ev,$ho_ki,$ho_ki0){
$idoszak=$ki_ev.'-'.$ho_ki0;
$tomb_ver=keres_mit1('backup_ver','backup_ver_ev_ho',$idoszak);
echo ' <select id="admin_backup_terv_megnyit_'.$idoszak.'" style="margin-left:10px" class="select3">';
foreach($tomb_ver as $ert){
 echo '<option value="'.$ert['backup_ver_id'].'"';
 if(end($tomb_ver)==$ert)
	 echo ' selected';
 echo '>Verzió: '.$ert['backup_ver_ver'].' ('.$ert['backup_ver_update_time'].')';
}
echo '</select>';
echo '<span onclick="admin_backup_terv(\''.$idoszak.'\')" class="link" style="margin-left:5px">Tervezés megnyitása</span>';

if($GLOBALS['rend_str']!='')
 echo '<img onclick="admin_backup_terv_delete(\''.$idoszak.'\')" class="linkm_tooltip" title="Biztonsági mentés törlése: '.$idoszak.' ver: '.$ert['backup_ver_ver'].'" style="margin-left:10px" src="image/del.png">';

}

function admin_backup_default_change(){
if(
 (isset($_POST['idoszak']))and
 (isset($_POST['mit']))and
 ($_POST['idoszak']!='')and
 ($_POST['mit']!='')
 ){
	
	mysqli_autocommit($GLOBALS['mysqli'],false);
	//törlés mindig kell!
 	$tmp_mod=array();
	$tmp_mod[0]['backup_ver_default']='0';
	mod_egy_fel_tom('backup_ver',$tmp_mod[0],'backup_ver_ev_ho',$_POST['idoszak']);
 if(!$_POST['mit']=='0'){//És amit kell az default-á tesszük
	$tmp_mod=array();
	$tmp_mod[0]['backup_ver_default']='1';
	mod_egy_fel_tom2('backup_ver',$tmp_mod[0],'backup_ver_ev_ho',$_POST['idoszak'],'backup_ver_id',$_POST['mit']);
 }

mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);
echo 'ok$;$';
}else{
 echo 'adathiány';	 
}
}

function admin_backup_masol_proc(){
if(
 (isset($_POST['ev']))and
 (isset($_POST['ho']))and
 ($_POST['ev']!='')and
 ($_POST['ho']!='')
){

mysqli_autocommit($GLOBALS['mysqli'],false);

//0. Létezik-e az adatbázis.
include_once('ajax_ful_admin_backup_func_db_ev.php');
if(!db_table_letezik_e('backup_adat_'.$_POST['ev'])){
 if(!admin_backup_masol_proc_db_letrehoz($_POST['ev'])){
	 echo 'DB táblák létrehozása sikertelen';
	 exit;
 }
}

//Verziók lekérése
$ver_uj=admin_backup_masol_verle($_POST['ev'],$_POST['ho']);

//1: backup_ver - eleje
  if($_POST['ho']<10)$ho_ki0="0".$_POST['ho'];
  else $ho_ki0=$_POST['ho'];
$tmp_adat_ver=array();
$tmp_adat_ver[0]['backup_ver_ev_ho']=$_POST['ev'].'-'.$ho_ki0;
$tmp_adat_ver[0]['backup_ver_ev']=$_POST['ev'];
$tmp_adat_ver[0]['backup_ver_ho']=$_POST['ho'];
$tmp_adat_ver[0]['backup_ver_ver']=$ver_uj;
$tmp_adat_ver[0]['backup_ver_keszito_ad']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
be_visz_insert_simabackup("backup_ver",$tmp_adat_ver);
unset($tmp_adat_ver);
$backup_ver_id=mysqli_insert_id($GLOBALS['mysqli']);

//1: backup_ver - vége

//2: mira_szerv_csoport másolása - eleje
$tomb_szerv_csoport=keres_all('mira_szerv_csoport');
$tmp_adat_szerv_csoport=array();
if(is_array($tomb_szerv_csoport)){
 foreach($tomb_szerv_csoport as $is => $ert){
  $tmp_adat_szerv[$is]['backup_ver_id']=$backup_ver_id;
  $tmp_adat_szerv[$is]['mira_szerv_csoport_id']=$ert['mira_szerv_csoport_id'];
  $tmp_adat_szerv[$is]['mira_szerv_csoport_nev']=$ert['mira_szerv_csoport_nev'];
  $tmp_adat_szerv[$is]['mira_szerv_csoport_inaktiv']=$ert['mira_szerv_csoport_inaktiv'];
 }
}
be_visz_insert_simabackup("backup_szerv_csoport",$tmp_adat_szerv);
unset($tomb_szerv_csoport);
unset($tmp_adat_szerv_csoport);
//2: mira_szerv_csoport másolása - vége

//2: szerv másolása - eleje
$tomb_szerv=keres_all('mira_szerv');
$tmp_adat_szerv=array();
if(is_array($tomb_szerv)){
 foreach($tomb_szerv as $is => $ert){
   $tmp_adat_szerv[$is]['backup_ver_id']=$backup_ver_id;
   $tmp_adat_szerv[$is]['szerv_id']=$ert['szerv_id'];
   $tmp_adat_szerv[$is]['szerv_tagv']=$ert['szerv_tagv'];
   $tmp_adat_szerv[$is]['szerv_nev']=$ert['szerv_nev'];
   $tmp_adat_szerv[$is]['szerv_koltsegkod']=$ert['szerv_koltsegkod'];
   $tmp_adat_szerv[$is]['szerv_adkod']=$ert['szerv_adkod'];
   
   if($ert['szerv_szolg_kod']=='') $ert['szerv_szolg_kod']=null;
    $tmp_adat_szerv[$is]['szerv_szolg_kod']=$ert['szerv_szolg_kod'];

   if($ert['szerv_csoport_id']=='') $ert['szerv_csoport_id']=null;
    $tmp_adat_szerv[$is]['szerv_csoport_id']=$ert['szerv_csoport_id'];
   
   if($ert['szerv_sm_kod']=='') $ert['szerv_sm_kod']=null;
    $tmp_adat_szerv[$is]['szerv_sm_kod']=$ert['szerv_sm_kod'];
   
   $tmp_adat_szerv[$is]['szerv_inaktiv']=$ert['szerv_inaktiv'];
 }
}
be_visz_insert_simabackup("backup_szerv",$tmp_adat_szerv);
unset($tomb_szerv);
unset($tmp_adat_szerv);
//2: szerv másolása - vége

//2:  projekt_kat másolása - eleje
$tomb_projekt_kat=keres_all('projekt_kat');
$tmp_adat_projekt_kat=array();
if(is_array($tomb_projekt_kat)){
 foreach($tomb_projekt_kat as $is => $ert){
  $tmp_adat_projekt_kat[$is]['backup_ver_id']=$backup_ver_id;
  $tmp_adat_projekt_kat[$is]['projekt_kat_id']=$ert['projekt_kat_id'];
  $tmp_adat_projekt_kat[$is]['projekt_kat_nev']=$ert['projekt_kat_nev'];
  $tmp_adat_projekt_kat[$is]['projekt_kat_inaktiv']=$ert['projekt_kat_inaktiv'];
 }
}
be_visz_insert_simabackup("backup_projekt_kat",$tmp_adat_projekt_kat);
unset($tomb_projekt_kat);
unset($tmp_adat_projekt_kat);
//2:  projekt_kat másolása - vége

//3: projekt másolása - eleje
$tomb_projekt=keres_all('projekt');
$tmp_adat_projekt=array();
if(is_array($tomb_projekt)){
 foreach($tomb_projekt as $is => $ert){
   $tmp_adat_projekt[$is]['backup_ver_id']=$backup_ver_id;
   $tmp_adat_projekt[$is]['projekt_id']=$ert['projekt_id'];
   $tmp_adat_projekt[$is]['projekt_nev']=$ert['projekt_nev'];
   $tmp_adat_projekt[$is]['projekt_tagv']=$ert['projekt_tagv'];
   $tmp_adat_projekt[$is]['projekt_title']=$ert['projekt_title'];

   if($ert['projekt_tagv_kod']=='') $ert['projekt_tagv_kod']=null;
    $tmp_adat_projekt[$is]['projekt_tagv_kod']=$ert['projekt_tagv_kod'];
   
   if($ert['projekt_szolg_kod']=='') $ert['projekt_szolg_kod']=null;
    $tmp_adat_projekt[$is]['projekt_szolg_kod']=$ert['projekt_szolg_kod'];
   
   /*
   if($ert['projekt_sm_kod']=='') $ert['projekt_sm_kod']=null;
    $tmp_adat_projekt[$is]['projekt_sm_kod']=$ert['projekt_sm_kod'];
	*/
   
   if($ert['projekt_kat_id']=='') $ert['projekt_kat_id']=null;
    $tmp_adat_projekt[$is]['projekt_kat_id']=$ert['projekt_kat_id'];
   
   
   $tmp_adat_projekt[$is]['projekt_id_max_all_igen']=$ert['projekt_id_max_all_igen'];
   $tmp_adat_projekt[$is]['projekt_id_max_all_ora']=$ert['projekt_id_max_all_ora'];
   $tmp_adat_projekt[$is]['projekt_inaktiv']=$ert['projekt_inaktiv'];
 }
}
be_visz_insert_simabackup("backup_pojekt",$tmp_adat_projekt);
unset($tomb_projekt);
unset($tmp_adat_projekt);
//3: projekt másolása - vége

//3: projekt_szerv másolása - eleje
$tomb_projekt_szerv=keres_all('projekt_szerv');
$tmp_adat_projekt_szerv=array();
if(is_array($tomb_projekt_szerv)){
 foreach($tomb_projekt_szerv as $is => $ert){
   $tmp_adat_projekt_szerv[$is]['backup_ver_id']=$backup_ver_id;
   $tmp_adat_projekt_szerv[$is]['projekt_id']=$ert['projekt_id'];
   $tmp_adat_projekt_szerv[$is]['szerv_id']=$ert['szerv_id'];
   if((!isset($ert['projekt_kat_id_kivetel']))or($ert['projekt_kat_id_kivetel']==''))$ert['projekt_kat_id_kivetel']=null;
   $tmp_adat_projekt_szerv[$is]['projekt_kat_id_kivetel']=$ert['projekt_kat_id_kivetel'];
   $tmp_adat_projekt_szerv[$is]['projekt_szerv_update_time']=$ert['projekt_szerv_update_time'];

 }
}

be_visz_insert_simabackup("backup_projekt_szerv",$tmp_adat_projekt_szerv);
unset($tomb_projekt_szerv);
unset($tmp_adat_projekt_szerv);
//3: projekt_szerv másolása - vége

//4: user másolása - eleje
$tomb_user=keres_all('mira_user');
$tmp_adat_user=array();
if(is_array($tomb_user)){
 foreach($tomb_user as $is => $ert){
   $tmp_adat_user[$is]['backup_ver_id']=$backup_ver_id;
   $tmp_adat_user[$is]['user_ad']=$ert['user_ad'];
   $tmp_adat_user[$is]['user_nev']=$ert['user_nev'];
   $tmp_adat_user[$is]['user_email']=$ert['user_nev'];
   $tmp_adat_user[$is]['user_tsz']=$ert['user_tsz'];
   $tmp_adat_user[$is]['ful_rogzit']=$ert['ful_rogzit'];
   $tmp_adat_user[$is]['user_kezd_date']=$ert['user_kezd_date'];
   $tmp_adat_user[$is]['user_veg_date']=$ert['user_veg_date'];
   $tmp_adat_user[$is]['szerv_id']=$ert['szerv_id'];
   $tmp_adat_user[$is]['ful_jovahagy']=$ert['ful_jovahagy'];
   $tmp_adat_user[$is]['ful_stat']=$ert['ful_stat'];
   $tmp_adat_user[$is]['ful_stat_all']=$ert['ful_stat_all'];
   $tmp_adat_user[$is]['ful_stat_projekt_all']=$ert['ful_stat_projekt_all'];
   $tmp_adat_user[$is]['ful_riport']=$ert['ful_riport'];
   $tmp_adat_user[$is]['user_inaktiv']=$ert['user_inaktiv'];
 }
}
be_visz_insert_simabackup("backup_user",$tmp_adat_user);
unset($tomb_user);
unset($tmp_adat_user);
//4: user másolása - vége

//5: mira_tagv_kod másolása - eleje
$tomb_mira_tagv_kod=keres_all('mira_tagv_kod');
$tmp_adat_tomb_mira_tagv_kod=array();
if(is_array($tomb_mira_tagv_kod)){
 foreach($tomb_mira_tagv_kod as $is => $ert){
   $tmp_adat_tomb_mira_tagv_kod[$is]['backup_ver_id']=$backup_ver_id;
   $tmp_adat_tomb_mira_tagv_kod[$is]['tagv_kod']=$ert['tagv_kod'];
   $tmp_adat_tomb_mira_tagv_kod[$is]['tagv_kod_nev']=$ert['tagv_kod_nev'];
   $tmp_adat_tomb_mira_tagv_kod[$is]['tagv_kod_inaktiv']=$ert['tagv_kod_inaktiv'];
 }
}
be_visz_insert_simabackup("backup_tagv_kod",$tmp_adat_tomb_mira_tagv_kod);
unset($tomb_mira_tagv_kod);
unset($tmp_adat_tomb_mira_tagv_kod);
//5: mira_tagv_kod másolása - vége

//5: backup_szolg_kod másolása - eleje
$tomb_mira_szolg_kod=keres_all('mira_szolg_kod');
$tmp_adat_tomb_mira_szolg_kod=array();
if(is_array($tomb_mira_szolg_kod)){
 foreach($tomb_mira_szolg_kod as $is => $ert){
   $tmp_adat_tomb_mira_szolg_kod[$is]['backup_ver_id']=$backup_ver_id;
   $tmp_adat_tomb_mira_szolg_kod[$is]['szolg_kod']=$ert['szolg_kod'];
   $tmp_adat_tomb_mira_szolg_kod[$is]['szolg_kod_nev']=$ert['szolg_kod_nev'];
   $tmp_adat_tomb_mira_szolg_kod[$is]['szolg_kod_inaktiv']=$ert['szolg_kod_inaktiv'];
 }
}
be_visz_insert_simabackup("backup_szolg_kod",$tmp_adat_tomb_mira_szolg_kod);
unset($tomb_mira_szolg_kod);
unset($tmp_adat_tomb_mira_szolg_kod);
//5: backup_szolg_kod másolása - vége

//szerv lekeresése, hogy mi lett az ID; eredmény $tomb[szerv_id]=[backup_szerv_id]
$tomb_backup_szerv_id=keres_backup_szerv_hozza($backup_ver_id);
$tomb_backup_pojekt_id=keres_backup_pojekt_hozza($backup_ver_id);
$tomb_backup_user_ad=keres_backup_userad_hozza($backup_ver_id);
//print_r($tomb_backup_pojekt_id);exit;
//3: Stat másolása

$_POST['idoszak_nap']='all';
$_POST['szerv_id']='all';
$_POST['projekt_id']='all';
$_POST['kiuser']='all';
$_POST['user']='all';

//Lekeresés
$tomb=keress_stat_rogzitett($_POST['ev'],$_POST['ho'],"reszletes3","1");

if(is_array($tomb)){

$ev=$_POST['ev'];

//foreach($tomb as $is => $ert){
foreach($tomb as $ert){
 $tmp_adat=array();
  
 $tmp_adat[0]['backup_ver_id']=$backup_ver_id;
 
 if(isset($tomb_backup_user_ad[$ert['user_ad']]))
  $tmp_adat[0]['backup_user_id']=$tomb_backup_user_ad[$ert['user_ad']];
 
 if(isset($tomb_backup_szerv_id[$ert['szerv_id']]))
  $tmp_adat[0]['backup_szerv_id']=$tomb_backup_szerv_id[$ert['szerv_id']];

 if(isset($tomb_backup_pojekt_id[$ert['projekt_id']]))
  $tmp_adat[0]['backup_pojekt_id']=$tomb_backup_pojekt_id[$ert['projekt_id']];
 
 if($ert['tavollet']==1)
  $tmp_adat[0]['backup_tavollet']=$ert['tavollet'];

  
 
 //Rögzített nap - eleje
 if($ert['rogzit_nap']<10)$nap_ki='0'.$ert['rogzit_nap'];
 else $nap_ki=$ert['rogzit_nap'];
 //$rog_ido_ki=$ev.".".$ho_ki.".".$nap_ki;
 
 if($ho_ki0=='all')
  $rog_ido_ki=$ev.'-'.$ert['rogzit_ho'].'-'.$nap_ki;
 else
  $rog_ido_ki=$ev.'-'.$ho_ki0.'-'.$nap_ki;
 
 $tmp_adat[0]['backup_rogzit_nap']=$rog_ido_ki;
 //Rögzített nap - vége
  
 //backup_rogzit_ora
 if($ert['rogzit_ora']=='') $ert['rogzit_ora']=0;
 $tmp_adat[0]['backup_rogzit_ora']=$ert['rogzit_ora'];
 
 //backup_rogzit_perc
 if($ert['rogzit_perc']=='') $ert['rogzit_perc']=0;
 $tmp_adat[0]['backup_rogzit_perc']=$ert['rogzit_perc'];
 
 be_visz_insert_simabackup("backup_adat_".$_POST['ev'],$tmp_adat);
 unset($tmp_adat);
 $backup_adat_id=mysqli_insert_id($GLOBALS['mysqli']);
 
 $tmp_adat_reszletek=array();
 $tmp_adat_reszletek[0]['backup_ver_id']=$backup_ver_id;
 $tmp_adat_reszletek[0]['backup_adat_id']=$backup_adat_id;
 $tmp_adat_reszletek[0]['backup_adat_user_ad']=$ert['user_ad'];
 $tmp_adat_reszletek[0]['backup_adat_user_nev']=$ert['user_nev'];
 
 
 $tmp_adat_reszletek[0]['backup_rogzit_sor_update_time']=$ert['rogzit_sor_update_time'];
 
 if($ert['rogzit_megj']!='')
  $tmp_adat_reszletek[0]['backup_rogzit_megj']=$ert['rogzit_megj'];
 
 if($ert['rogzit_sor_megj']!='')
  $tmp_adat_reszletek[0]['backup_rogzit_sor_megj']=$ert['rogzit_sor_megj'];
 
 if($ert['helyettes_rogzito']=='') $ert['helyettes_rogzito']=0;
 $tmp_adat_reszletek[0]['backup_helyettes_rogzito']=$ert['helyettes_rogzito'];
 
 if($ert['helyettes_rogzito_ki_nev']!='')
  $tmp_adat_reszletek[0]['backup_helyettes_rogzito_nev']=$ert['helyettes_rogzito_ki_nev'];
 
 if($ert['ellenorzesre_lezarva']=='')$ert['ellenorzesre_lezarva']=0;
 $tmp_adat_reszletek[0]['backup_ellenorzesre_lezarva']=$ert['ellenorzesre_lezarva'];
 
 if($ert['ellenorzesre_lezarva_mikor']!='0000-00-00 00:00:00')
  $tmp_adat_reszletek[0]['backup_ellenorzesre_lezarva_mikor']=$ert['ellenorzesre_lezarva_mikor'];
 
 if($ert['ellenorzesre_lezarva_jovahagyo']=='')$ert['ellenorzesre_lezarva_jovahagyo']=0;
 $tmp_adat_reszletek[0]['backup_ellenorzesre_lezarva_jovahagyo']=$ert['ellenorzesre_lezarva_jovahagyo'];
 
 $tmp_adat_reszletek[0]['backup_ellenorzesre_lezarva_jovahagyo_ki_nev']=$ert['ellenorzesre_lezarva_jovahagyo_ki_nev'];
 
 if($ert['ellenorzesre_visszakuldve']=='') $ert['ellenorzesre_visszakuldve']=0;
 $tmp_adat_reszletek[0]['backup_projekt_jovahagyo_elutasitva']=$ert['ellenorzesre_visszakuldve'];
 
 if($ert['projekt_jovahagyo_elutasitva_nev']!='')
  $tmp_adat_reszletek[0]['backup_projekt_jovahagyo_elutasitva_nev']=$ert['projekt_jovahagyo_elutasitva_nev'];
 
 if($ert['projekt_jovahagyo_elutasitva_mikor']!='0000-00-00 00:00:00')
  $tmp_adat_reszletek[0]['backup_projekt_jovahagyo_elutasitva_mikor']=$ert['projekt_jovahagyo_elutasitva_mikor'];
 
 if($ert['projekt_jovahagyo_jovahagyva']=='')$ert['projekt_jovahagyo_jovahagyva']=0;
 $tmp_adat_reszletek[0]['backup_projekt_jovahagyo_jovahagyva']=$ert['projekt_jovahagyo_jovahagyva'];
 
 if($ert['projekt_jovahagyo_jovahagyva_nev']!='')
  $tmp_adat_reszletek[0]['backup_projekt_jovahagyo_jovahagyva_nev']=$ert['projekt_jovahagyo_jovahagyva_nev'];
 
 if($ert['projekt_jovahagyo_jovahagyva_mikor']!='0000-00-00 00:00:00')
  $tmp_adat_reszletek[0]['backup_projekt_jovahagyo_jovahagyva_mikor']=$ert['projekt_jovahagyo_jovahagyva_mikor'];

 if($ert['ellenorzesre_visszakuldve']=='') $ert['ellenorzesre_visszakuldve']=0;
 $tmp_adat_reszletek[0]['backup_ellenorzesre_visszakuldve']=$ert['ellenorzesre_visszakuldve'];
 
 $tmp_adat_reszletek[0]['backup_ellenorzesre_visszakuldve_ki_nev']=$ert['ellenorzesre_visszakuldve_ki_nev'];
 
 if($ert['ellenorzesre_visszakuldve_ki_nev']!='')
  $tmp_adat_reszletek[0]['backup_ellenorzesre_visszakuldve_ki_nev']=$ert['ellenorzesre_visszakuldve_ki_nev'];
 
 if($ert['ellenorzesre_visszakuldve_mikor']!='0000-00-00 00:00:00')
  $tmp_adat_reszletek[0]['backup_ellenorzesre_visszakuldve_mikor']=$ert['ellenorzesre_visszakuldve_mikor'];
 
 if($ert['ellenorzesre_ok']=='') $ert['ellenorzesre_ok']=0;
 $tmp_adat_reszletek[0]['backup_ellenorzesre_ok']=$ert['ellenorzesre_ok'];
 
 if($ert['ellenorzesre_ok_ki_nev']!='')
  $tmp_adat_reszletek[0]['backup_ellenorzesre_ok_ki_nev']=$ert['ellenorzesre_ok_ki_nev'];
 
 if($ert['ellenorzesre_ok_mikor']!='0000-00-00 00:00:00')
  $tmp_adat_reszletek[0]['backup_ellenorzesre_ok_mikor']=$ert['ellenorzesre_ok_mikor'];
 
 be_visz_insert_simabackup("backup_adat_reszletek_".$_POST['ev'],$tmp_adat_reszletek);
 unset($tmp_adat_reszletek);
 
}
}

unset($tomb);

mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);
//exit;

 echo 'ok$;$';
 echo '<b>Áttöltés sikeres!</b>';
 $tomb_ver_le=keres_mit1('backup_ver','backup_ver_id',$backup_ver_id);
 echo '<br>Év: '.$tomb_ver_le[0]['backup_ver_ev'];
 echo '<br>Hó: '.$tomb_ver_le[0]['backup_ver_ho'];
 echo '<br>Ver: '.$tomb_ver_le[0]['backup_ver_ver'];
 //echo '<br>Terv ID: '.$backup_ver_id;
}else{
echo 'Áttöltés sikertelen';
	
}
}

function keres_backup_szerv_hozza($backup_ver_id){
 $eredmeny_keres="";
 $sql="SELECT backup_szerv_id,szerv_id  FROM `backup_szerv` where `backup_ver_id`='$backup_ver_id'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szerv_id']]=$adatom['backup_szerv_id'];
 }
 return $eredmeny_keres;
}

function keres_backup_pojekt_hozza($backup_ver_id){
 $eredmeny_keres="";
 $sql="SELECT backup_pojekt_id ,projekt_id  FROM `backup_pojekt` where `backup_ver_id`='$backup_ver_id'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['projekt_id']]=$adatom['backup_pojekt_id'];
 }
 return $eredmeny_keres;
}

function keres_backup_userad_hozza($backup_ver_id){
 $eredmeny_keres="";
 $sql="SELECT backup_user_id  ,user_ad  FROM `backup_user` where `backup_ver_id`='$backup_ver_id'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=$adatom['backup_user_id'];
 }
 return $eredmeny_keres;
}
?>