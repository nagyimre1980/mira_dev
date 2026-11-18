<?php

function admin_tenypotlas_mod(){
echo 'ok$;$';

admin_tenypotlas_mod_urlap();
admin_tenypotlas_mod_kereses();
echo '<div id="admin_uj_tenypotlas_list_keres_tal" style="overflow-x:auto">';
admin_tenypotlas_mod_list();
echo '</div>';
}

function admin_tenypotlas_mod_urlap(){
echo "<div style='overflow-x:auto'><b>MIRA-n kívüli tényadatok betöltése:</b>";

echo '<table class="table_emre">';

echo '<tr>';
echo '<td><b>Betöltő fájl</b>';

echo '<td>';
//Betöltés - eleje
 echo '<form style="display:block;margin:0px" id="file_upload_tenypotlas_form" action="admin/ajax_ful_admin_tenypotlas_betoltes.php" method="post" enctype="multipart/form-data" target="tenypotlas_upload_target" onsubmit="return startUpload_tenypotlas_file();">';

 echo '<input onchange="tenypotlas_form_file_input_change()" class="tenypotlas_form_fileinput" id="tenypotlas_form_file_input" type="file" name="datafile" s1tyle="width:320px" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">';
 
 echo '<input value="Feltöltés" disabled class="submit2" style="margin-left:5px" id="tenypotlas_file_input_submit" type="submit">';
 echo '</form>';

 echo '<div style="display:none" class="upload_result_tenypotlas_file_div" id="upload_result_tenypotlas_file">';
 echo '<span style="font-size:16px">Feltöltés folyamatban</span>';
 echo '</div>';
 
 echo '<iframe id="tenypotlas_upload_target" name="tenypotlas_upload_target" style="display:none;width:0px; height:0px; border:0px;"></iframe>';
//Betöltés - vége

echo '<div id="file_upload_tenypotlas_form_str">';
echo '<br>Figyelem: Betöltéskor a meglévő adatok nem törlődnek, hanem felülírásra kerülnek!
<br>(Csak az, ami szerepel a betöltő excelben)';
echo '<br>Elsődleges egyedi kulcs: Társaság-Szolgkod-Év-Hó';
echo '<br><br>Tovább betöltéskor nem kerül figyelésre, hogy a társaság és a szolgáltatás kód létezik-e!';
echo '<br><br>Tagv és szolg_kod oszlopok maximális hossza 4-4 karakter!';
echo '<br><br>Hó értékét 1-2-3 formában kell kitölteni!';
echo '<br><br><span onclick="admin_tenypotlas_tenybetoltomintaopen()" class="link">Ténybetöltő minta</span>';
echo '</div>';

echo '</tr>';

echo "</table></div>";
}

function admin_tenypotlaslist_keres(){
if(isset($_POST['tagv']))$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['tagv']=$_POST['tagv'];
if(isset($_POST['szolg_kod']))$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['szolg_kod']=$_POST['szolg_kod'];
if(isset($_POST['ev']))$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['ev']=$_POST['ev'];
if(isset($_POST['ho']))$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['ho']=$_POST['ho'];
echo "ok$;$";
admin_tenypotlas_mod_list();
}

function admin_tenypotlas_mod_kereses(){
echo '<div style="overflow-x:auto">';

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['tagv']))and($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['tagv']!=""))
 $ker_tagv=$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['tagv'];
else $ker_tagv="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['szolg_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['szolg_kod']!=""))
 $ker_szolg_kod=$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['szolg_kod'];
else $ker_szolg_kod="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['ev']))and($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['ev']!=""))
 $ker_ev=$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['ev'];
else $ker_ev="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['ho']))and($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['ho']!=""))
 $ker_ho=$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['ho'];
else $ker_ho="";

echo '<br><b>Keresés</b>';
echo '<table id="admin_tenypotlaslist_table" class="table_emre">';
echo '<tr>';

echo '<td>Társaság SAP kód';
echo '<td>';
echo '<input onkeyup="admin_tenypotlaslist_keres(\'tallep_elso\',\'\')" id="admin_tenypotlaslist_keres_tagv" style="width:50px" maxlength=4 type="text">';
 
echo '<td>Szolgáltatás kód';
echo '<td>';
echo '<input onkeyup="admin_tenypotlaslist_keres(\'tallep_elso\',\'\')" id="admin_tenypotlaslist_keres_szolg_kod" style="width:50px" maxlength=4 type="text">';

echo '<td>Év';
echo '<td>';
echo '<input onkeyup="admin_tenypotlaslist_keres(\'tallep_elso\',\'\')" id="admin_tenypotlaslist_keres_ev" style="width:50px" maxlength=4 type="text">';

echo '<td>Hó';
echo '<td>';
echo '<input onkeyup="admin_tenypotlaslist_keres(\'tallep_elso\',\'\')" id="admin_tenypotlaslist_keres_ho" style="width:50px" maxlength=2 type="text">';

echo '</tr>';
echo '</table></div>';
}

function admin_tenypotlas_mod_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_tenypotlas_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo "<br><b>Meglévő ténybetöltés módosítása</b>";
echo "<table id='admin_tervezeslist_table' class='table_emre'>";
echo "<thead><tr>";

$order_mezo="backup_tenypotlas.backup_tenypotlas_tagv";
echo "<th style='width:20px' class='link' onclick='admin_tenypotlaslist_keres_proc(\"order\",\"".$order_mezo."\")'>SAP kód ";
echo tabl_nyilak('admin_tenypotlaslist_keres_order','admin_tenypotlaslist_keres_order_mod',$order_mezo);

$order_mezo="backup_tenypotlas.backup_tenypotlas_szolg_kod";
echo "<th style='width:20px' class='link' onclick='admin_tenypotlaslist_keres_proc(\"order\",\"".$order_mezo."\")'>Szolgáltatás kód ";
echo tabl_nyilak('admin_tenypotlaslist_keres_order','admin_tenypotlaslist_keres_order_mod',$order_mezo);

$order_mezo="backup_tenypotlas.backup_tenypotlas_ev";
echo "<th style='width:20px' class='link' onclick='admin_tenypotlaslist_keres_proc(\"order\",\"".$order_mezo."\")'>Év ";
echo tabl_nyilak('admin_tenypotlaslist_keres_order','admin_tenypotlaslist_keres_order_mod',$order_mezo);

$order_mezo="backup_tenypotlas.backup_tenypotlas_ho";
echo "<th style='width:20px' class='link' onclick='admin_tenypotlaslist_keres_proc(\"order\",\"".$order_mezo."\")'>Hó ";
echo tabl_nyilak('admin_tenypotlaslist_keres_order','admin_tenypotlaslist_keres_order_mod',$order_mezo);

$order_mezo="backup_tenypotlas.backup_tenypotlas_osszeg";
echo "<th style='width:20px' class='link' onclick='admin_tenypotlaslist_keres_proc(\"order\",\"".$order_mezo."\")'>Érték ";
echo tabl_nyilak('admin_tenypotlaslist_keres_order','admin_tenypotlaslist_keres_order_mod',$order_mezo);

echo "</tr></thead><tbody>";

admin_tenypotlas_list_tal($tomb);

echo "</tbody></table>";

elozo_kovetkezo_gombok("admin_tenypotlaslist_keres_proc",$th,$GLOBALS['mira']['user_jog']['admin_tenypotlaslist_keres_talszam'],$_POST['oldalholvagyok']);

//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['admin_tenypotlaslist_keres_talszam'],"admin_tenypotlaslist_keres_proc","admin_tenypotlaslist_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='admin_tenypotlaslist_keres_tal_oldalholvagyok'>";

if(is_array($tomb)){
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['admin_tenypotlaslist_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='admin_tenypotlaslist_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['admin_tenypotlaslist_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_tenypotlaslist_keres_proc('tallep_elso','');</script>";
  }
 }
excel_export("admin_tenypotlaslist_keres",$th);//Nincs lefejlesztve
}
}

function admin_tenypotlas_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){

echo '<tr>';

echo '<td>';
echo $ert['backup_tenypotlas_tagv'];

echo '<td>';
echo $ert['backup_tenypotlas_szolg_kod'];

echo '<td>';
echo $ert['backup_tenypotlas_ev'];
echo ' <img onclick="admin_tenypotlas_del_ev(\''.$ert['backup_tenypotlas_ev'].'\')" src="image/del.png" class="del_img" title="Törlés">';

echo '<td>';
echo $ert['backup_tenypotlas_ho'];
echo ' <img onclick="admin_tenypotlas_del_ho(\''.$ert['backup_tenypotlas_ev'].'\',\''.$ert['backup_tenypotlas_ho'].'\')" src="image/del.png" class="del_img" title="Törlés">';

echo '<td>';
echo $ert['backup_tenypotlas_osszeg'];

echo '</tr>';
}
}
}
}

function admin_tenypotlas_del_ev_proc(){
if((isset($_POST['ev']))and($_POST['ev']!='')){
 torles('backup_tenypotlas','backup_tenypotlas_ev',$_POST['ev']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_tenypotlas_del_ho_proc(){
if(
(isset($_POST['ev']))and($_POST['ev']!='')
and
(isset($_POST['ho']))and($_POST['ho']!='')
){
 torles2('backup_tenypotlas','backup_tenypotlas_ev',$_POST['ev'],'backup_tenypotlas_ho',$_POST['ho']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}
?>