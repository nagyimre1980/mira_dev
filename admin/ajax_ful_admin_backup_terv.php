<?php

function admin_backup_terv_adat(){

if(
 (isset($_POST['backup_ver_id']))and
 ($_POST['backup_ver_id']!='')
){

$tomb=keres_mit1('backup_ver','backup_ver_id',$_POST['backup_ver_id']);

if(!is_array($tomb)){
 echo 'Áttöltés nem található!';
 exit;
}

echo "<table border=0 class='table_emre_bejovo'>";

echo '<thead>';
echo '<tr>';
echo '<th>Típus';
echo '<th style="width:230px">Művelet';
echo '<th style="width:300px">Státusz';
echo '<th style="width:440px">Leírás';
echo '</thead>';

echo '<tbody>';

//Tény 1 - eleje
echo '<tr>';
echo '<td>Tény 1';

//Művelet
echo '<td>';
if($tomb[0]['backup_ver_teny1']=='0'){
 echo '<input onclick="admin_backup_terv_1pont(\''.$tomb[0]['backup_ver_ev_ho'].'\',\''.$_POST['backup_ver_id'].'\')" id="admin_backup_terv_1pont_'.$_POST['backup_ver_id'].'" type="submit" class="submit2 terv" value="1. elkészítése">';
}else{
 echo '<span onclick="admin_backup_terv_1pont_letolt(\''.$_POST['backup_ver_id'].'\')" class="link">Letöltés</span>';
}

//Státusz
echo '<td>';
if($tomb[0]['backup_ver_teny1']=='0'){
 echo '';
}else{
 echo ' Kalkuláció elkészítve: '.$tomb[0]['backup_ver_teny1_update_time'];
 echo ' <img onclick="admin_backup_terv_1_del(\''.$tomb[0]['backup_ver_ev_ho'].'\',\''.$_POST['backup_ver_id'].'\')" src="image/del.png" class="linkm_tooltip" title="Kalkuláció törlése">';
}

//Leírás
echo '<td>';
echo 'Felhasználókénti havi összesítés';

echo '</tr>';
//Tény 1 - vége

//Tény 2 - eleje
echo '<tr>';
echo '<td>Tény 2';

//Művelet
echo '<td>';
if($tomb[0]['backup_ver_teny2']=='0'){
 echo '<input onclick="admin_backup_terv_2pont(\''.$tomb[0]['backup_ver_ev_ho'].'\',\''.$_POST['backup_ver_id'].'\')" id="admin_backup_terv_2pont_'.$_POST['backup_ver_id'].'" type="submit" class="submit2 terv" value="2. elkészítése">';
}else{
 echo '<span onclick="admin_backup_terv_2pont_letolt(\''.$_POST['backup_ver_id'].'\')" class="link">Letöltés</span>';
}

//Státusz
echo '<td>';
if($tomb[0]['backup_ver_teny2']=='0'){
 echo '';
}else{
 echo ' Kalkuláció elkészítve: '.$tomb[0]['backup_ver_teny2_update_time'];
 echo ' <img onclick="admin_backup_terv_2_del(\''.$tomb[0]['backup_ver_ev_ho'].'\',\''.$_POST['backup_ver_id'].'\')" src="image/del.png" class="linkm_tooltip" title="Kalkuláció törlése">';
}

//Leírás
echo '<td>';
echo 'Szervezeteként havi összesítés';

echo '</tr>';
//Tény 2 - vége

//Tény 3.1 - eleje
echo '<td>Tény 3.1';

//Művelet
echo '<td>';
if($tomb[0]['backup_ver_teny3_1']=='0'){
 echo '<input onclick="admin_backup_terv_3_1pont(\''.$tomb[0]['backup_ver_ev_ho'].'\',\''.$_POST['backup_ver_id'].'\')" id="admin_backup_terv_3_1pont_'.$_POST['backup_ver_id'].'" type="submit" class="submit2 terv" value="3.1. elkészítése">';
}else{
 echo '<span onclick="admin_backup_terv_3_1pont_letolt(\''.$_POST['backup_ver_id'].'\')" class="link">Letöltés</span>';
}

//Státusz
echo '<td>';
if($tomb[0]['backup_ver_teny3_1']=='0'){
 echo '';
}else{
 echo ' Kalkuláció elkészítve: '.$tomb[0]['backup_ver_teny3_1_update_time'];
 echo ' <img onclick="admin_backup_terv_3_1_del(\''.$tomb[0]['backup_ver_ev_ho'].'\',\''.$_POST['backup_ver_id'].'\')" src="image/del.png" class="linkm_tooltip" title="Kalkuláció törlése">';
}

//Leírás
echo '<td>';
echo 'Felhasználónkénti tevékenység összesítés';

echo '</tr>';
//Tény 3.1 - vége


//Tény 3.1.1 - eleje
echo '<td>Tény 3.1.1';

//Művelet
echo '<td>';
if($tomb[0]['backup_ver_teny3_1']=='0'){
 
}else{
if($tomb[0]['backup_ver_teny3_1_1']=='0'){
 echo '<input onclick="admin_backup_terv_3_1_1pont(\''.$tomb[0]['backup_ver_ev_ho'].'\',\''.$_POST['backup_ver_id'].'\')" id="admin_backup_terv_3_1_1pont_'.$_POST['backup_ver_id'].'" type="submit" class="submit2 terv" value="3.1.1. elkészítése">';
}else{
 echo '<span onclick="admin_backup_terv_3_1_1pont_letolt(\''.$_POST['backup_ver_id'].'\')" class="link">Letöltés</span>';
}
}

//Státusz
echo '<td>';
if($tomb[0]['backup_ver_teny3_1_1']=='0'){
 echo '';
}else{
 echo ' Kalkuláció elkészítve: '.$tomb[0]['backup_ver_teny3_1_1_update_time'];
 echo ' <img onclick="admin_backup_terv_3_1_1_del(\''.$tomb[0]['backup_ver_ev_ho'].'\',\''.$_POST['backup_ver_id'].'\')" src="image/del.png" class="linkm_tooltip" title="Kalkuláció törlése">';
}

//Leírás
echo '<td>';
echo 'Felhasználónkénti tevékenység összesítés -  Összevonással';
echo '</tr>';
//Tény 3.1.1 - vége

//Tény 3.2 - eleje
echo '<tr>';
echo '<td>Tény 3.2';

//Művelet
echo '<td>';
if($tomb[0]['backup_ver_teny3_1_1']=='0'){
 
}else{
if($tomb[0]['backup_ver_teny3_2']=='0'){
 echo '<input onclick="admin_backup_terv_3_2pont(\''.$tomb[0]['backup_ver_ev_ho'].'\',\''.$_POST['backup_ver_id'].'\')" id="admin_backup_terv_3_2pont_'.$_POST['backup_ver_id'].'" type="submit" class="submit2 terv" value="3.2. elkészítése">';
}else{
 echo '<span onclick="admin_backup_terv_3_2pont_letolt(\''.$_POST['backup_ver_id'].'\')" class="link">Letöltés</span>';
}
}

//Státusz
echo '<td>';
if($tomb[0]['backup_ver_teny3_2']=='0'){
 echo '';
}else{
 echo ' Kalkuláció elkészítve: '.$tomb[0]['backup_ver_teny3_2_update_time'];
 echo ' <img onclick="admin_backup_terv_3_2_del(\''.$tomb[0]['backup_ver_ev_ho'].'\',\''.$_POST['backup_ver_id'].'\')" src="image/del.png" class="linkm_tooltip" title="Kalkuláció törlése">';
}

//Leírás
echo '<td>';
echo 'Szervezetenkénti tevékenység összesítés (Összevonás után)';

echo '</tr>';
//Tény 3.2 - vége

//Tény 3.3 - eleje
echo '<tr>';
echo '<td>Tény 3.3';

//Művelet
echo '<td>';
if($tomb[0]['backup_ver_teny3_2']=='0'){

}else{
if($tomb[0]['backup_ver_teny3_3']=='0'){
 echo '<input onclick="admin_backup_terv_3_3pont(\''.$tomb[0]['backup_ver_ev_ho'].'\',\''.$_POST['backup_ver_id'].'\')" id="admin_backup_terv_3_3pont_'.$_POST['backup_ver_id'].'" type="submit" class="submit2 terv" value="3.3. elkészítése">';
}else{
 echo '<span onclick="admin_backup_terv_3_3pont_letolt(\''.$_POST['backup_ver_id'].'\')" class="link">Letöltés</span>';
}
}

//Státusz
echo '<td>';
if($tomb[0]['backup_ver_teny3_3']=='0'){
 echo '';
}else{
 echo ' Kalkuláció elkészítve: '.$tomb[0]['backup_ver_teny3_3_update_time'];
 echo ' <img onclick="admin_backup_terv_3_3_del(\''.$tomb[0]['backup_ver_ev_ho'].'\',\''.$_POST['backup_ver_id'].'\')" src="image/del.png" class="linkm_tooltip" title="Kalkuláció törlése">';
}

//Leírás
echo '<td>';
echo 'Tevékenység összesítés (3.2 alapján)';

echo '</tr>';
//Tény 3.3 - vége

//Tény 3 - eleje
echo '<td>Tény 3';

//Művelet
echo '<td>';
if($tomb[0]['backup_ver_teny3_2']=='0'){
 
}else{
if($tomb[0]['backup_ver_teny3']=='0'){
 echo '<input onclick="admin_backup_terv_3pont(\''.$tomb[0]['backup_ver_ev_ho'].'\',\''.$_POST['backup_ver_id'].'\')" id="admin_backup_terv_3pont_'.$_POST['backup_ver_id'].'" type="submit" class="submit2 terv" value="3. elkészítése">';
}else{
 //echo '<span onclick="admin_backup_terv_3pont_letolt(\''.$_POST['backup_ver_id'].'\')" class="link">Letöltés</span>';
 echo '<table border=0 style="width:260px">';
 echo '</tr>';
 
 echo '<tr><td>Terv típusa: ';
 $tomb_terv_altipusok=admin_backup_terv_teny3_altipusok($tomb[0]['backup_ver_ev']);
 echo '<td><select id="terv3_tipus">';
 //echo '<option value="terv">Terv';
 //echo '<option value="terv2">Terv 2';
 foreach($tomb_terv_altipusok as $ert_altipus_id => $ert_altipus_nev){
  echo '<option value="'.$ert_altipus_id.'">'.$ert_altipus_nev;
 }
 echo '</select>';
 echo '</tr>';
 
 echo '<tr><td>Alsó eltérés:';
 echo '<td>- <input id="terv3_hatar_also" value="15" style="width:50px" maxlength=2 type="number" min=0 max=99> %';
 echo '</tr>';
 
 echo '<tr><td>Felső eltérés:';
 echo '<td>+ <input id="terv3_hatar_felso" value="15" style="width:50px" maxlength=2 type="number" min=0 max=99> %';
 echo '</tr>';
 
 echo '<tr><td>Jelentős eltérés:';
 echo '<td><input id="terv3_hatar_jelentos" value="10" style="width:50px" maxlength=5 type="number" min=0 max=99999> óra';
 
 echo '<tr><td colspan=2><input onclick="admin_backup_terv_3pont_letolt(\''.$_POST['backup_ver_id'].'\',\''.$_POST['backup_ver_id'].'\')" id="admin_backup_terv_3pont_'.$_POST['backup_ver_id'].'" type="submit" class="submit3" value="Terv excel letöltése">';
 echo '</table>';
}
}

//Státusz
echo '<td>';
if($tomb[0]['backup_ver_teny3']=='0'){
 echo '';
}else{
 echo ' Kalkuláció elkészítve: '.$tomb[0]['backup_ver_teny3_update_time'];
 echo ' <img onclick="admin_backup_terv_3_del(\''.$tomb[0]['backup_ver_ev_ho'].'\',\''.$_POST['backup_ver_id'].'\')" src="image/del.png" class="linkm_tooltip" title="Kalkuláció törlése">';
}

//Leírás
echo '<td>';
echo 'Aktuális tevékenység kód - Társaság kód összesítés (Összevonás után)';

echo '</tr>';
//Tény 3 - vége

echo '</tbody>';

echo "</table>";

}
}

function admin_backup_terv_teny3_altipusok($ev){
$eredmeny_keres="";
$sql='SELECT 
backup_terv_tipus.backup_terv_tipus_id,  
backup_terv_tipus.backup_terv_tipus_nev,  
backup_terv_fo_tipus_nev.backup_terv_fo_tipus
FROM `backup_terv_tipus`
inner join backup_terv_fo_tipus_nev ON backup_terv_fo_tipus_nev.backup_terv_fo_tipus_id = backup_terv_tipus.backup_terv_fo_tipus_id
where
backup_terv_tipus.backup_terv_tipus_ev="'.$ev.'" and 
backup_terv_tipus.backup_terv_tipus_riportok="1"
 ';
//echo $sql;exit;
 $i=0;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  $eredmeny_keres[$adatom['backup_terv_tipus_id']]=$adatom['backup_terv_fo_tipus'].' - '.$adatom['backup_terv_tipus_nev'];
 }
 return $eredmeny_keres;
}

function admin_backup_terv(){

if(
 (isset($_POST['backup_ver_id']))and
 ($_POST['backup_ver_id']!='')
){

echo 'ok$;$';

$tomb=keres_mit1('backup_ver','backup_ver_id',$_POST['backup_ver_id']);

if(!is_array($tomb)){
 echo 'Áttöltés nem található!';
 exit;
}

echo '<div style="float:left;display:inline">';
echo '<b>Áttöltés id:</b> '.$_POST['backup_ver_id'];
echo '<b><br>Áttöltés Időszaka:</b> '.$tomb[0]['backup_ver_ev_ho'];
echo '<b><br>Áttöltés verzió:</b> '.$tomb[0]['backup_ver_ver'];
echo '<br><span onclick="admin_backup_terv_projekt_le(\''.$_POST['backup_ver_id'].'\')" class="link">Tevékenység lista</span>';

echo '<br><span onclick="admin_backup_terv_projektszetbont_le(\''.$_POST['backup_ver_id'].'\')" class="link">Tevékenység szétbontás adatok '.$tomb[0]['backup_ver_ev_ho'].' ver: '.$tomb[0]['backup_ver_ver'].'</span>';
$tevszetbont_count=keres_backup_terv_szetbont_count($_POST['backup_ver_id']);
if($tevszetbont_count>0){
 echo ' Betöltött adat: '.$tevszetbont_count;
 echo ' <img onclick="admin_backup_terv_projektszetbont_del(\''.$tomb[0]['backup_ver_ev_ho'].'\',\''.$_POST['backup_ver_id'].'\')" src="image/del.png" class="linkm_tooltip" title="Betöltött tevékenység szétbontása adatok törlése: '.$tomb[0]['backup_ver_ev_ho'].' ver: '.$tomb[0]['backup_ver_ver'].'">';
}

echo '</div>';

echo '<div style="margin-left:10px;padding:10px;border-radius:10px;float:left;display:inline;background-color:#e2e2e2">';
echo '<b>Betöltés</b> (Figyelem: Betöltés minden korábbi meglévő, kapcsolódó adatot töröl!)';
 echo '<form style="display:block;margin:10px" id="file_upload_terv_form" action="admin/ajax_ful_admin_backup_terv_betoltes.php" method="post" enctype="multipart/form-data" target="terv_upload_target" onsubmit="return startUpload_terv_file();">';
	 echo '<input type=hidden name="backup_ver_id" value="'.$_POST['backup_ver_id'].'">'; 
	 echo 'Betöltő fájl típusa: ';
	 echo '<select name="tipus" id="terv_file_input_tipus" class="select3">';
	 //echo '<option value="keremv">Kérem válassz';
	 echo '<option value="projekt_szetbontas">Tevékenység szétbontás törlés és feltöltés ('.$tomb[0]['backup_ver_ev_ho'].' ver: '.$tomb[0]['backup_ver_ver'].')';
	 //echo '<option value="terv_ev">Terv tábla törlés és feltöltés '.$tomb[0]['backup_ver_ev'].' (egész évet törli és tölti be)';
	 //echo '<option value="terv_ev_ho">Terv tábla törlés és feltöltés '.$tomb[0]['backup_ver_ev_ho'].' (csak az adott hónapot törli és tölti be)';
	 echo '</select>';
 echo '<br><input onchange="terv_form_file_input_change()" class="terv_form_fileinput" id="terv_form_file_input" type="file" name="datafile" style="width:320px" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">';
 
 echo '<input value="Feltöltés" disabled class="submit2" style="margin-left:5px" id="terv_file_input_submit" type="submit">';
 echo '</form>';

 echo '<div style="display:none" class="upload_result_terv_file_div" id="upload_result_terv_file">';
 echo '<span style="font-size:16px">Feltöltés folyamatban</span>';
 echo '</div>';

echo '</tr>';

echo '</tbody>';
echo '</table>';

echo '<iframe id="terv_upload_target" name="terv_upload_target" style="display:none;width:0px; height:0px; border:0px;"></iframe>';

//echo '<b>Betöltő minták</b>';//<br>
echo '<span onclick="admin_backup_terv_betoltominta_szetbontas()" class="link">Tevékenység szétbontás betöltő minta</span> (max 4 tizedes lehetséges)';
echo '</div>';

echo '<br>';

echo '<div id="div_admin_backup_terv_adat" style="float:left;display:block;margin-top:10px">';
admin_backup_terv_adat();
echo '</div>';

}else{
 echo 'adathiány';
}
}

function admin_backup_terv_1pont(){

$ev=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ev');
//0. Létezik-e az adatbázis.
include_once('ajax_ful_admin_backup_func_db_ev.php');
include_once('ajax_ful_admin_backup_terv_db_ev.php');
if(!db_table_letezik_e('backup_adat_'.$ev.'_teny_1')){
 if(!admin_backup_terv1_masol_proc_db_letrehoz($ev)){
	 echo 'DB táblák létrehozása sikertelen';
	 exit;
 }
}

include_once('ajax_ful_admin_backup_terv_func.php');
$ment_eredmeny=admin_backup_terv_1pont_proc($ev,$_POST['backup_ver_id']);
 //
if($ment_eredmeny=="ok"){
 echo 'ok$;$';
}else{
 echo 'Hibás kalkuláció';
}

}

function admin_backup_terv_2pont(){

$ev=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ev');
//0. Létezik-e az adatbázis.
include_once('ajax_ful_admin_backup_func_db_ev.php');
include_once('ajax_ful_admin_backup_terv_db_ev.php');
if(!db_table_letezik_e('backup_adat_'.$ev.'_teny_2')){
 if(!admin_backup_terv2_masol_proc_db_letrehoz($ev)){
	 echo 'DB táblák létrehozása sikertelen';
	 exit;
 }
}

include_once('ajax_ful_admin_backup_terv_func.php');
$ment_eredmeny=admin_backup_terv_2pont_proc($ev,$_POST['backup_ver_id']);
 //
if($ment_eredmeny=="ok"){
 echo 'ok$;$';
}else{
 echo 'Hibás kalkuláció';
}

}




function admin_backup_terv_3_1pont(){

$ev=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ev');
//0. Létezik-e az adatbázis.
include_once('ajax_ful_admin_backup_func_db_ev.php');
include_once('ajax_ful_admin_backup_terv_db_ev.php');
if(!db_table_letezik_e('backup_adat_'.$ev.'_teny_3_1')){
 if(!admin_backup_terv3_1_masol_proc_db_letrehoz($ev)){
	 echo 'DB táblák létrehozása sikertelen';
	 exit;
 }
}

include_once('ajax_ful_admin_backup_terv_func.php');
$ment_eredmeny=admin_backup_terv_3_1pont_proc($ev,$_POST['backup_ver_id']);
 //
if($ment_eredmeny=="ok"){
 echo 'ok$;$';
}else{
 echo 'Hibás kalkuláció';
}

}

function admin_backup_terv_3_1_1pont(){
$ev=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ev');
//0. Létezik-e az adatbázis.
include_once('ajax_ful_admin_backup_func_db_ev.php');
include_once('ajax_ful_admin_backup_terv_db_ev.php');
if(!db_table_letezik_e('backup_adat_'.$ev.'_teny_3_1_1')){
 if(!admin_backup_terv3_1_1_masol_proc_db_letrehoz($ev)){
	 echo 'DB táblák létrehozása sikertelen';
	 exit;
 }
}

include_once('ajax_ful_admin_backup_terv_func.php');
$ment_eredmeny=admin_backup_terv_3_1_1pont_proc($ev,$_POST['backup_ver_id']);

if($ment_eredmeny=="ok"){
 echo 'ok$;$';
}else{
 echo 'Hibás kalkuláció';
}
}

function admin_backup_terv_3_3pont(){
$ev=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ev');
//0. Létezik-e az adatbázis.
include_once('ajax_ful_admin_backup_func_db_ev.php');
include_once('ajax_ful_admin_backup_terv_db_ev.php');

if(!db_table_letezik_e('backup_adat_'.$ev.'_teny_3_3')){
 if(!admin_backup_terv3_3_masol_proc_db_letrehoz($ev)){
	 echo 'DB táblák létrehozása sikertelen';
	 exit;
 }
}

include_once('ajax_ful_admin_backup_terv_func.php');
$ment_eredmeny=admin_backup_terv_3_3pont_proc($ev,$_POST['backup_ver_id']);
 //
if($ment_eredmeny=="ok"){
 echo 'ok$;$';
}else{
 echo 'Hibás kalkuláció';
}

}

function admin_backup_terv_3_2pont(){

$ev=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ev');
//0. Létezik-e az adatbázis.
include_once('ajax_ful_admin_backup_func_db_ev.php');
include_once('ajax_ful_admin_backup_terv_db_ev.php');
if(!db_table_letezik_e('backup_adat_'.$ev.'_teny_3_2')){
 if(!admin_backup_terv3_2_masol_proc_db_letrehoz($ev)){
	 echo 'DB táblák létrehozása sikertelen';
	 exit;
 }
}

include_once('ajax_ful_admin_backup_terv_func.php');
$ment_eredmeny=admin_backup_terv_3_2pont_proc($ev,$_POST['backup_ver_id']);
 //
if($ment_eredmeny=="ok"){
 echo 'ok$;$';
}else{
 echo 'Hibás kalkuláció';
}

}




function admin_backup_terv_3pont(){

$ev=keres_mit1_mit1_csak_ertek('backup_ver','backup_ver_id',$_POST['backup_ver_id'],'backup_ver_ev');
//0. Létezik-e az adatbázis.
include_once('ajax_ful_admin_backup_func_db_ev.php');
include_once('ajax_ful_admin_backup_terv_db_ev.php');
if(!db_table_letezik_e('backup_adat_'.$ev.'_teny_3')){
 if(!admin_backup_terv3_masol_proc_db_letrehoz($ev)){
	 echo 'DB táblák létrehozása sikertelen';
	 exit;
 }
}

include_once('ajax_ful_admin_backup_terv_func.php');
$ment_eredmeny=admin_backup_terv_3pont_proc($ev,$_POST['backup_ver_id']);
 //
if($ment_eredmeny=="ok"){
 echo 'ok$;$';
}else{
 echo 'Hibás kalkuláció';
}

}

function keres_backup_terv_szetbont_count($backup_ver_id){
$eredmeny_keres="0";
$backup_ver_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_ver_id);

$sql="select 
count(backup_projekt_szetbontas.szetbontas_id) as tal
FROM backup_projekt_szetbontas
where backup_projekt_szetbontas.backup_ver_id='".$backup_ver_id."'";
//print $sql."<br>";exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres=$adatom['tal'];
 }
 return $eredmeny_keres;
}
?>