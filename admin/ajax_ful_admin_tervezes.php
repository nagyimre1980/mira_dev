<?php

function admin_tervezes_mod(){
echo 'ok$;$';

admin_tervezes_mod_urlap();
admin_tervezes_mod_kereses();
echo '<div id="admin_uj_tervezes_list_keres_tal" style="overflow-x:auto">';
admin_tervezes_mod_list();
echo '</div>';
}

function admin_tervezes_mod_urlap(){
echo "<div style='overflow-x:auto'><b>Új terv típus:</b>";

echo '<table class="table_emre">';

echo '<tr>';
echo '<td>Terv típus *';
echo '<td>';
echo '<select id="admin_ujtervezes_tipus" class="select3" style="width:150px">';
echo '<option value="keremv">Kérem válassz';
$tomb_tipus=keres_all_order('backup_terv_fo_tipus_nev','backup_terv_fo_tipus','ASC');
 foreach($tomb_tipus as $ert){
  echo '<option value="'.$ert['backup_terv_fo_tipus_id'].'">'.$ert['backup_terv_fo_tipus'];
 }
echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<td>Év *';
echo '<td>';
echo '<select id="admin_ujtervezes_ev" class="select3" style="width:150px">';
$tomb_alap=keres_mit1("mira_tagv","tagv",$GLOBALS[$GLOBALS['sessionname']]['tagv']);
$ev_most=date("Y",time());
$ev_most_1=date("Y",time())+1;
 for($ki_ev=$ev_most_1;$ki_ev>=$tomb_alap[0]['ev_kezdo_ev'];$ki_ev--){
  echo '<option value="'.$ki_ev.'"';
  if($ki_ev==$ev_most) echo ' selected';
  echo '>'.$ki_ev;
 }
echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<td>Típus neve *';
echo '<td>';
echo '<input id="admin_ujtervezes_nev" type=text style="width:250px" maxlength="30"> max 30 karakter';
echo '</tr>';

echo '<tr>';
echo '<td>Megjegyzés *';
echo '<td>';
echo '<input id="admin_ujtervezes_megj" type=text style="width:450px" maxlength="255"> max 255 karakter';
echo '</tr>';

echo "<tr><td colspan=2 align=left><input id='admin_ujtervezes_submit' onclick='admin_ujtervezes()' type=submit value='Új terv típus felvitele' class='submit2'></tr>";

echo "</table></div>";
}

function admin_tervezeslist_keres(){
if(isset($_POST['tipus']))$_SESSION[$GLOBALS['sessionname']]['admin_tervezeslist_keres']['tipus']=$_POST['tipus'];
if(isset($_POST['ev']))$_SESSION[$GLOBALS['sessionname']]['admin_tervezeslist_keres']['ev']=$_POST['ev'];
echo "ok$;$";
admin_tervezes_mod_list();
}

function admin_tervezes_mod_kereses(){
echo '<div style="overflow-x:auto">';

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tervezeslist_keres']['tipus']))and($_SESSION[$GLOBALS['sessionname']]['admin_tervezeslist_keres']['tipus']!=""))
 $ker_tipus=$_SESSION[$GLOBALS['sessionname']]['admin_tervezeslist_keres']['tipus'];
else $ker_tipus="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tervezeslist_keres']['ev']))and($_SESSION[$GLOBALS['sessionname']]['admin_tervezeslist_keres']['ev']!=""))
 $ker_ev=$_SESSION[$GLOBALS['sessionname']]['admin_tervezeslist_keres']['ev'];
else $ker_ev="";

echo "<br><b>Keresés</b>";
echo "<table id='admin_tervezeslist_table' class='table_emre'>";

echo '<tr>';

echo '<td>Típus';
 echo '<td><select onchange="admin_tervezeslist_keres_proc(\'tallep_elso\',\'\')" id="admin_tervezeslist_keres_tipus" class="select3" style="width:150px">';
 echo '<option value="all">Összes';
 $tomb_tipus=keres_all_order('backup_terv_fo_tipus_nev','backup_terv_fo_tipus','ASC');
 foreach($tomb_tipus as $ert){
  echo '<option value="'.$ert['backup_terv_fo_tipus_id'].'"';
  if($ert['backup_terv_fo_tipus_id']==$ker_tipus) echo ' selected';
  echo '>'.$ert['backup_terv_fo_tipus'];
 }
 echo '</select>';

echo '<td>Év';
 echo '<td><select onchange="admin_tervezeslist_keres_proc(\'tallep_elso\',\'\')" id="admin_tervezeslist_keres_ev" class="select3" style="width:150px">';
 $tomb_alap=keres_mit1("mira_tagv","tagv",$GLOBALS[$GLOBALS['sessionname']]['tagv']);
 $ev_most=date("Y",time());
 $ev_most_1=date("Y",time())+1;
 for($ki_ev=$ev_most_1;$ki_ev>=$tomb_alap[0]['ev_kezdo_ev'];$ki_ev--){
  echo '<option value="'.$ki_ev.'"';
  if($ki_ev==$ker_ev) echo ' selected';
  echo '>'.$ki_ev;
 }
 echo '</select>';

echo '</tr>';
echo '</table></div>';
}

function admin_tervezes_mod_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_tervezes_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo "<br><b>Meglévő típusok módosítása</b>";
echo ' <span onclick="admin_tervezes_tervbetoltomintaopen()" class="link">Terv betöltő minta</span>';
echo "<table id='admin_tervezeslist_table' class='table_emre'>";
echo "<thead><tr>";

$order_mezo="backup_terv_tipus.backup_terv_tipus_id";
echo "<th style='width:20px' class='link' onclick='admin_tervezeslist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
echo tabl_nyilak('admin_tervezeslist_keres_order','admin_tervezeslist_keres_order_mod',$order_mezo);

$order_mezo="backup_terv_tipus.backup_terv_tipus_ev";
echo "<th style='width:20px' class='link' onclick='admin_tervezeslist_keres_proc(\"order\",\"".$order_mezo."\")'>Év ";
echo tabl_nyilak('admin_tervezeslist_keres_order','admin_tervezeslist_keres_order_mod',$order_mezo);

$order_mezo="backup_terv_fo_tipus_nev.backup_terv_fo_tipus";
echo "<th style='width:20px' class='link' onclick='admin_tervezeslist_keres_proc(\"order\",\"".$order_mezo."\")'>Terv típus ";
echo tabl_nyilak('admin_tervezeslist_keres_order','admin_tervezeslist_keres_order_mod',$order_mezo);

$order_mezo="backup_terv_tipus.backup_terv_tipus_nev";
echo "<th style='width:20px' class='link' onclick='admin_tervezeslist_keres_proc(\"order\",\"".$order_mezo."\")'>Típus neve ";
echo tabl_nyilak('admin_tervezeslist_keres_order','admin_tervezeslist_keres_order_mod',$order_mezo);

echo "<th>Megjegyzés";
echo "<th>Riportfül megjelenítés";
echo "<th>Terv betöltése";
echo "<th>Terv exportálása";
echo "<th>Terv típus törlése";

echo "</tr></thead><tbody>";

admin_tervezes_list_tal($tomb);

echo "</tbody></table>";

echo '<iframe id="tervezes_upload_target" name="tervezes_upload_target" style="display:none;width:0px;height:0px;border:0px;"></iframe>';

elozo_kovetkezo_gombok("admin_tervezeslist_keres_proc",$th,$GLOBALS['mira']['user_jog']['admin_tervezeslist_keres_talszam'],$_POST['oldalholvagyok']);

//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['admin_tervezeslist_keres_talszam'],"admin_tervezeslist_keres_proc","admin_tervezeslist_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='admin_tervezeslist_keres_tal_oldalholvagyok'>";

if(is_array($tomb)){
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['admin_tervezeslist_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='admin_tervezeslist_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['admin_tervezeslist_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_tervezeslist_keres_proc('tallep_elso','');</script>";
  }
 }
////excel_export("admin_tervezeslist_keres",$th);//Nincs lefejlesztve
}

}

function admin_tervezes_list_tal($tomb){

if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){

//echo '<tr title="'.$ert['backup_terv_tipus_ev'].' - '.$ert['backup_terv_fo_tipus']." - ".$ert['backup_terv_tipus_nev'].'" class="ttooltip">';
echo '<tr style="height:33px">';

echo '<td>';
echo $ert['backup_terv_tipus_id'];

echo '<td>';
echo $ert['backup_terv_tipus_ev'];

echo '<td>';
echo $ert['backup_terv_fo_tipus'];

echo '<td>';
echo '<input onkeyup="admin_tervezes_modment(\''.$ert['backup_terv_tipus_id'].'\')" id="admin_modtervezes_nev_'.$ert['backup_terv_tipus_id'].'" value="'.$ert['backup_terv_tipus_nev'].'" style="width:150px" maxlength="30" type="text">';

//Megjegyzés
echo '<td>';
echo '<input onkeyup="admin_tervezes_modment(\''.$ert['backup_terv_tipus_id'].'\')" id="admin_modtervezes_megj_'.$ert['backup_terv_tipus_id'].'" value="'.$ert['backup_terv_tipus_megj'].'" style="width:200px" maxlength="255" type="text">';

//Riportfül megjelenítés
echo '<td align=center>';
if($ert['backup_terv_tipus_riportok']=='1'){
 $ck_ok=' checked';
}else{
 $ck_ok='';
}
if($ert['backup_terv_id']!=''){
 echo '<input'.$ck_ok.' onclick="admin_tervezes_riportok(\''.$ert['backup_terv_tipus_id'].'\')" id="admin_modtervezes_riportok_'.$ert['backup_terv_tipus_id'].'" type="checkbox">';
}

//Terv betöltés
echo '<td>';
 echo '<form style="display:block;margin:0px" id="file_upload_tervezes_form_'.$ert['backup_terv_tipus_id'].'" action="admin/ajax_ful_admin_tervezes_betoltes.php" method="post" enctype="multipart/form-data" target="tervezes_upload_target" onsubmit="return startUpload_tervezes_file(\''.$ert['backup_terv_tipus_id'].'\');">';
	 echo '<input type=hidden name="backup_terv_tipus_id" value="'.$ert['backup_terv_tipus_id'].'">'; 
	 //echo '</select>';
 echo '<input onchange="tervezes_form_file_input_change(\''.$ert['backup_terv_tipus_id'].'\')" class="tervezes_form_fileinput" id="tervezes_form_file_input_'.$ert['backup_terv_tipus_id'].'" type="file" name="datafile" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">';//s1tyle="width:320px"
 
 echo '<input value="Feltöltés" disabled class="submit2" style="margin-left:5px" id="tervezes_file_input_submit_'.$ert['backup_terv_tipus_id'].'" type="submit">';
 echo '</form>';

 echo '<div style="display:none" class="upload_result_tervezes_file_div" id="upload_result_tervezes_file_'.$ert['backup_terv_tipus_id'].'">';
 echo '<span style="font-size:16px">Feltöltés folyamatban</span>';
 echo '</div>';

//Terv exportálás
echo '<td>';
if($ert['backup_terv_id']!=''){
 echo '<span onclick="admin_tervezes_export(\''.$ert['backup_terv_tipus_id'].'\')" class="link">Exportálás</span>';
 echo ' <img onclick="admin_tervezes_tervdel(\''.$ert['backup_terv_tipus_id'].'\')" title="Betöltött terv törlése" class="linkm_tooltip" src="image/del.png">';
}

//Terv típus törlése
echo '<td align=center>';
echo ' <img onclick="admin_tervezes_sordel(\''.$ert['backup_terv_tipus_id'].'\',\''.$ert['backup_terv_fo_tipus'].'\',\''.$ert['backup_terv_tipus_nev'].'\',\''.$ert['backup_terv_tipus_ev'].'\')" title="Terv sor törlése" class="linkm_tooltip" src="image/del.png">';

echo '</tr>';
}
}
}
}

function admin_tervezes_tervdel(){
if(
 (isset($_POST['backup_terv_tipus_id']))and
 ($_POST['backup_terv_tipus_id']!='')
){
 torles('backup_terv','backup_terv_tipus_id',$_POST['backup_terv_tipus_id']);
 echo 'ok$;$';
}else{
 echo 'Adathiány';
}
}

function admin_tervezes_sordel_proc(){
if(
 (isset($_POST['backup_terv_tipus_id']))and
 ($_POST['backup_terv_tipus_id']!='')
){
 torles('backup_terv_tipus','backup_terv_tipus_id',$_POST['backup_terv_tipus_id']);
 echo 'ok$;$';
}else{
 echo 'Adathiány';
}
}

function admin_ujtervezes_ment(){
if(
 (isset($_POST['tipus']))and
 (isset($_POST['ev']))and
 (isset($_POST['nev']))and
 (isset($_POST['megj']))and
 ($_POST['tipus']!='')and
 ($_POST['tipus']!='keremv')and
 ($_POST['ev']!='')and
 ($_POST['nev']!='')and
 ($_POST['megj']!='')
){
 $tmp_bk=array();
 $tmp_bk[0]['backup_terv_fo_tipus_id']=$_POST['tipus'];
 $tmp_bk[0]['backup_terv_tipus_ev']=$_POST['ev'];
 $tmp_bk[0]['backup_terv_tipus_nev']=$_POST['nev'];
 $tmp_bk[0]['backup_terv_tipus_megj']=$_POST['megj'];
 be_visz_insert("backup_terv_tipus",$tmp_bk);
 echo 'ok$;$';

}else{
 echo 'Adathiány';
}
}

function admin_tervezes_riportok(){
if(
 (isset($_POST['backup_terv_tipus_id']))and
 (isset($_POST['riportok']))and
 ($_POST['backup_terv_tipus_id']!='')and
 (
  ($_POST['riportok']=='0')or
  ($_POST['riportok']=='1')
 )
){
 $tmp_mod=array();
 $tmp_mod[0]['backup_terv_tipus_riportok']=$_POST['riportok'];
 mod_egy_fel_tom('backup_terv_tipus',$tmp_mod[0],'backup_terv_tipus_id',$_POST['backup_terv_tipus_id']);
 echo 'ok$;$';
}else{
 echo 'Adathiány';
}
}

function admin_tervezes_modment_proc(){
if(
 (isset($_POST['backup_terv_tipus_id']))and
 (isset($_POST['nev']))and
 (isset($_POST['megj']))and
 ($_POST['backup_terv_tipus_id']!='')
){
 $tmp_mod=array();
 $tmp_mod[0]['backup_terv_tipus_nev']=$_POST['nev'];
 $tmp_mod[0]['backup_terv_tipus_megj']=$_POST['megj'];
 mod_egy_fel_tom('backup_terv_tipus',$tmp_mod[0],'backup_terv_tipus_id',$_POST['backup_terv_tipus_id']);
 echo 'ok$;$';
}else{
 echo 'Adathiány';
}
}
?>