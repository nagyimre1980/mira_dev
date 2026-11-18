<?php

function admin_hibajavitas_mod(){
echo 'ok$;$';
admin_hibajavitas_mod_urlap();
echo "<div id='admin_uj_hibajavitas_list_keres_tal' style='overflow-x:auto'>";
echo '</div>';
}

function admin_hibajavitas_mod_urlap(){
echo "<div style='overflow-x:auto'><b>Hibajavítás éles és korábbi backup adatokon:</b>";

echo "<table class='table_emre'>";

//év - eleje
echo '<tr>';
echo '<td>Év *';
echo '<td>';
echo '<select onchange="select2_torles_def(\'admin_ujhibajavitas_ho\',\'keremv\');select2_torles_def(\'admin_ujhibajavitas_nap\',\'all\');select2_torles_def(\'admin_ujhibajavitas_backup_ver_id\',\'keremv\');select2_torles_def(\'admin_ujhibajavitas_user_ad\',\'keremv\')" id="admin_ujhibajavitas_ev" class="select3" style="width:131px">';
 echo '<option value="keremv">Kérem válassz';
 $tomb_ev=keres_backup_csakev();
 if(is_array($tomb_ev)){
 foreach($tomb_ev as $ev){
  echo '<option value="'.$ev.'">'.$ev;
 }
 }
echo '</select>';
echo '</tr>';
//év - vége


//ho - eleje
echo '<tr>';
echo '<td>Hó *';
echo '<td>';
echo '<select onchange="select2_torles_def(\'admin_ujhibajavitas_nap\',\'all\');select2_torles_def(\'admin_ujhibajavitas_backup_ver_id\',\'keremv\');select2_torles_def(\'admin_ujhibajavitas_user_ad\',\'keremv\')" id="admin_ujhibajavitas_ho" class="select2_ajax" csonkolt=0 mod="admin_ujhibajavitas_ho" mit_id="admin_ujhibajavitas_ev" style="width:131px">';
echo '<option value="keremv">Kérem válassz';
echo '</select>';
echo '</tr>';
//ho - vége

//nap - eleje
echo '<tr>';
echo '<td>Nap';
echo '<td>';
echo '<select id="admin_ujhibajavitas_nap" class="select2_ajax" csonkolt=0 mod="admin_ujhibajavitas_nap" mit_id="admin_ujhibajavitas_ev" mit2_id="admin_ujhibajavitas_ho" style="width:131px">';
echo '<option value="all">Összes';
echo '</select>';
echo '</tr>';
//nap - vége

//Backup ver - eleje
echo '<tr>';
echo '<td>Backup DB áttöltés verzió *';
echo '<td>';
echo '<select onchange="select2_torles_def(\'admin_ujhibajavitas_user_ad\',\'keremv\')" id="admin_ujhibajavitas_backup_ver_id" class="select2_ajax" csonkolt=0 mod="admin_ujhibajavitas_backup_ver_id" mit_id="admin_ujhibajavitas_ev" mit2_id="admin_ujhibajavitas_ho" style="width:231px">';
echo '<option value="keremv">Kérem válassz';
echo '</select>';

echo '</tr>';
//Backup ver - vége

echo '<tr>';
echo '<td>Felhasználó *';
echo '<td>';
 echo '<select id="admin_ujhibajavitas_user_ad" class="select2_ajax" csonkolt=1 mod="admin_ujhibajavitas_user_ad" mit_id="admin_ujhibajavitas_backup_ver_id" style="width:411px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';
echo '</tr>';

echo "<tr><td colspan=2 align=left><input id='admin_ujhibajavitas_submit' onclick='admin_ujhibajavitas()' value='Éles és backup rögzítés hibajavítása' class='submit2' type=submit></tr>";

echo '</table>';

echo '</div>';
}

function admin_ujhibajavitas_egy(){
echo 'ok$;$';
if(
 (isset($_POST['backup_ver_id']))and
 (isset($_POST['user_ad']))and
 (isset($_POST['ev']))and
 (isset($_POST['ho']))and
 (isset($_POST['nap']))and
 ($_POST['backup_ver_id']!='')and
 ($_POST['user_ad']!='')and
 ($_POST['ev']!='')and
 ($_POST['ho']!='')and
 ($_POST['nap']!='')
){
$user_nev=keres_mit2_mit1_csak_ertek('backup_user','backup_ver_id',$_POST['backup_ver_id'],'user_ad',$_POST['user_ad'],'user_nev');
$backup_ver_ev=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ev');
$backup_ver_ev_ho=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ev_ho');
$backup_ver_ver=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ver');
$backup_time=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_update_time');

if(
 ($user_nev!='')and
 ($backup_ver_ev_ho!='')and
 ($backup_ver_ver!='')and
 ($backup_time!='')
){
 echo '<br><b>Éles és backup DB módosítása:</b> '.$user_nev.', '.str_replace('-','.',$backup_ver_ev_ho).', Verzió: '.$backup_ver_ver.' ('.$backup_time.')';
 
 if($_POST['nap']!='all'){
  if($_POST['ho']<10)$_POST['ho']='0'.$_POST['ho'];
  if($_POST['nap']<10)$_POST['nap']='0'.$_POST['nap'];
  $szur_date=$_POST['ev'].'-'.$_POST['ho'].'-'.$_POST['nap'];
 }else{
	 $szur_date='';
 }
 
 $tomb=keress_admin_ujhibajavitas_adat($_POST['backup_ver_id'],$_POST['user_ad'],$szur_date);
 echo '<br>';
 if(is_array($tomb)){
  echo '<input id="admin_modhibajavitas_submit" onclick="admin_modhibajavitas(\''.$_POST['user_ad'].'\',\''.$backup_ver_ev.'\')" value="Módosítás mentése" class="submit2" style="margin-right:10px" type="submit">';
 }
 
 echo ' <input id="admin_modhibajavitas_megse" onclick="admin_modhibajavitas_megse()" value="Mégse" class="submit2" type="submit">';
 if(!is_array($tomb)){
  echo '<br>Nem található rögzített adat!';
 }
 
 echo '<br>';

 admin_ujhibajavitas_egy_ki($tomb,$_POST['backup_ver_id']);
}else{
 echo 'adathiány';
}

}else{
 echo 'adathiány';
}
}

function admin_ujhibajavitas_egy_ki($tomb,$backup_ver_id){

//$tomb_projektek=keress_admin_ujhibajavitas_projektek($backup_ver_id);

/*
echo '<pre>';
print_r($tomb);
echo '</pre>';
*/

if(is_array($tomb)){

echo '<input value="'.$backup_ver_id.'" id="backup_ver_id_hidden" type="hidden">';
echo "<table id='admin_katnevlist_table' class='table_emre'>";
echo "<thead><tr>";

echo "<th colspan=2>Dátum";
echo "<th>Rögzített idő";
echo "<th>Tevékenység";

echo '</tr></thead><tbody>';

$sorsz=0;
foreach($tomb as $date => $tomb1){
foreach($tomb1 as $i => $ert){
$sorsz++;
echo '<tr>';

//Dátum
if(
($i==0)
or
(
 ($i==0)and(sizeof($tomb1)>1)
)
){
 echo '<td rowspan='.sizeof($tomb1).'>';
 echo str_replace('-','.',$ert['backup_rogzit_nap']);


echo '<td rowspan='.sizeof($tomb1).'>';
$datum_sima=str_replace('-','',$ert['backup_rogzit_nap']);
$ev=substr($datum_sima,0,4);//2023
$ho=substr($datum_sima,4,2);//01
$nap_akt=$nap=substr($datum_sima,6,2);//02
$naptime=mktime("0","0","1",$ho,$nap,$ev);
$het_sorszam=date('w',$naptime);
echo napkod($het_sorszam);

}

//Rögzített idő
echo '<td>';
//echo $ert['backup_rogzit_ora'];
//echo $ert['backup_rogzit_perc'];

$class_inp='input_time';
if($ert['backup_rogzit_perc']<10)$ert['backup_rogzit_perc']='0'.$ert['backup_rogzit_perc'];
$val=$ert['backup_rogzit_ora'].":".$ert['backup_rogzit_perc'];
$maxlength=5;
echo '<input rogzit_nap="'.str_replace('-','.',$ert['backup_rogzit_nap']).'" origbackup_pojekt_id="'.$ert['backup_pojekt_id'].'" backup_adat_id="'.$ert['backup_adat_id'].'" kitoltheto="1" max_ora="'.$GLOBALS['mira']['napi_ido_max_ora'].'" max="'.$GLOBALS['mira']['napi_ido_max'].'" min="0:00" type=text class="'.$class_inp.'" value="'.$val.'" id="input_proj_'.$nap_akt.'_'.$sorsz.'" maxlength='.$maxlength.'>';

//Tevékenység
echo '<td>';
/*
//echo $ert['projekt_nev'];
echo '<select id="projektlist_input_proj_'.$nap_akt.'_'.$sorsz.'" class="select2_csonkolt">';
foreach($tomb_projektek as $projlist_ert){
 echo '<option uj_pojekt_id="'.$projlist_ert['projekt_id'].'" value="'.$projlist_ert['backup_pojekt_id'].'"';
 if($ert['backup_pojekt_id']==$projlist_ert['backup_pojekt_id'])
	 echo ' selected';
 echo '>'.$projlist_ert['projekt_nev'];
}
echo '</select>';
*/

//Új ajax-s

echo '<select id="projektlist_input_proj_'.$nap_akt.'_'.$sorsz.'" class="select2_ajax" mod="projekt_backup_ver_id" mit_id="backup_ver_id_hidden" csonkolt="1" style="width:652px">';
 echo '<option uj_pojekt_id="'.$ert['projekt_id'].'" value="'.$ert['backup_pojekt_id'].'">'.$ert['projekt_nev'];
echo '</select>';


echo '</tr>';
}
}

echo "</tbody></table>";

}
}

function admin_modhibajavitas(){
if(
 (isset($_POST['user_ad']))and($_POST['user_ad']!='')and
 (isset($_POST['ev']))and($_POST['ev']!='')and
 (isset($_POST['adat']))and($_POST['adat']!='')
){

$adat_tomb=explode('#',$_POST['adat']);

if(is_array($adat_tomb)){

mysqli_autocommit($GLOBALS['mysqli'],false);

foreach($adat_tomb as $adat_tomb1){
  
  if($adat_tomb1!=''){
  $adat_egy_tomb=explode('-',$adat_tomb1);
   
  if(
  (is_array($adat_egy_tomb))and
  (isset($adat_egy_tomb[0]))and
  (isset($adat_egy_tomb[1]))and
  (isset($adat_egy_tomb[2]))and
  (isset($adat_egy_tomb[3]))and
  (isset($adat_egy_tomb[4]))and
  (isset($adat_egy_tomb[5]))and
  ($adat_egy_tomb[0]!='')and//backup_adat_id
  ($adat_egy_tomb[1]!='')and//ora:ido
  ($adat_egy_tomb[2]!='')and//ujbackup_pojekt_id
  ($adat_egy_tomb[3]!='')and//origbackup_pojekt_id
  ($adat_egy_tomb[4]!='')and//rogzit_nap
  ($adat_egy_tomb[5]!='')//uj_pojekt_id
  ){
  $adat_ora=explode(':',$adat_egy_tomb[1]);
  $rogzit_nap=str_replace('.','-',$adat_egy_tomb[4]);
  $origbackup_pojekt_id=$adat_egy_tomb[3];
  $uj_pojekt_id=$adat_egy_tomb[5];

 if(
 (is_array($adat_ora))and
 (isset($adat_ora[0]))and
 (isset($adat_ora[1]))and
 ($adat_ora[0]!='')and
 ($adat_ora[1]!='')
 ){
	 
  $ora=$adat_ora[0];
  $perc=$adat_ora[1];
  $perc++;
  $perc--;
  $backup_pojekt_id=$adat_egy_tomb[2];

//Backup módosítása - eleje
 $tmp_mod=array();
 $tmp_mod[0]['backup_rogzit_ora']=$ora;
 $tmp_mod[0]['backup_rogzit_perc']=$perc;
 $tmp_mod[0]['backup_pojekt_id']=$backup_pojekt_id;
 mod_egy_fel_tom("backup_adat_".$_POST['ev'],$tmp_mod[0],'backup_adat_id',$adat_egy_tomb[0]);
//Backup módosítása - vége

//Éles módosítása - eleje
//1. orig_projekt_id meghatározása
$orig_projekt_id=keres_mit1_mit1_csak_ertek('backup_pojekt','backup_pojekt_id',$origbackup_pojekt_id,'projekt_id');

//2. rogzit_id meghatározása élesben
$rogzit_id=keres_mit2_mit1_csak_ertek('rogzit','user_ad',$_POST['user_ad'],'rogzit_nap',$rogzit_nap,'rogzit_id');

//3. rogzit_sor tábla módosítása
if(
($orig_projekt_id!='')and($rogzit_id!='')
){
 $tmp_mod=array();
 $tmp_mod[0]['rogzit_ora']=$ora;
 $tmp_mod[0]['rogzit_perc']=$perc;
 if($uj_pojekt_id!=$orig_projekt_id)
  $tmp_mod[0]['projekt_id']=$uj_pojekt_id;
 mod_egy_fel_tom2("rogzit_sor",$tmp_mod[0],'rogzit_id',$rogzit_id,'projekt_id',$orig_projekt_id);
}else{
 echo 'Éles DB nem található! Megáll a hibajavítás!';
 exit;
}
//Éles módosítása - vége
 }
 }
 }
}

echo 'ok$;$';
mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);

}

}else{
 echo 'adathiány';
}
}

function keress_admin_ujhibajavitas_adat($backup_ver_id,$user_ad,$szur_date){
 $eredmeny_keres="";
 $ev=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ev');
 $sql="SELECT 
 backup_adat_".$ev.".backup_adat_id,
 backup_adat_".$ev.".backup_rogzit_nap,
 backup_adat_".$ev.".backup_rogzit_ora,
 backup_adat_".$ev.".backup_rogzit_perc,
 backup_adat_".$ev.".backup_pojekt_id,
 backup_pojekt.projekt_id,
 backup_pojekt.projekt_nev
 FROM `backup_adat_".$ev."` 
 left join backup_pojekt ON backup_pojekt.backup_pojekt_id = backup_adat_".$ev.".backup_pojekt_id
 inner join backup_user ON backup_user.backup_user_id = backup_adat_".$ev.".backup_user_id
	and backup_user.backup_ver_id ='".$backup_ver_id."' 
	and backup_user.user_ad = '".$user_ad."'
 where
 backup_adat_".$ev.".backup_ver_id='".$backup_ver_id."' ";
 
 if($szur_date!=''){
  $sql.="and backup_adat_".$ev.".backup_rogzit_nap='".$szur_date."' ";
 }
 
 $sql.="order by backup_adat_".$ev.".backup_rogzit_nap asc";
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['backup_rogzit_nap']][]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_backup_csakev(){
 $eredmeny_keres="";
 $sql="SELECT backup_ver.backup_ver_ev FROM `backup_ver` 
 group by backup_ver.backup_ver_ev
 order by backup_ver.backup_ver_ev desc";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom['backup_ver_ev'];
 }
 return $eredmeny_keres;
}

function keress_admin_ujhibajavitas_projektek($backup_ver_id){
 $eredmeny_keres="";
 $backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_ver_id);
 $sql="SELECT 
 backup_pojekt.backup_pojekt_id,
 backup_pojekt.projekt_id,
 backup_pojekt.projekt_nev
 FROM `backup_pojekt` 
 where 
 backup_pojekt.backup_ver_id='".$backup_ver_id."' and 
 backup_pojekt.projekt_inaktiv='0'
 order by backup_pojekt.projekt_nev asc";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}
?>