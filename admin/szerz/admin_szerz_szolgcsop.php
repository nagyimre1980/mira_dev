<?php

function admin_szerz_szolgcsop(){
echo 'ok$;$';
admin_szerz_szolgcsop_urlap();
admin_szerz_szolgcsop_kereses();
echo '<div id="admin_uj_szolgcsop_list_keres_tal" style="overflow-x:auto">';
admin_szolgcsop_user_list();
echo '</div>';
}

function admin_szerz_szolgcsop_urlap(){
echo '<div class="div_kereshez">';
echo '<b>Új szolgáltatás csoport:</b>';

echo '<table class="table_emre_kek">';

echo '<tbody>';
echo '<tr>';
echo '<td>Szolgáltatás csoport név *';
echo '<td>';
echo '<input id="admin_ujszolgcsop_csopnev" maxlength="255" style="width:300px" type="text">';
echo '</tr>';

echo '<tr><td colspan=2 align=left><input id="admin_ujszolgcsop_submit" onclick="admin_ujszolgcsop()" value="Új szolgáltatás csoport felvitele" class="submit2" type=submit></tr>';
echo '</tbody>';
echo '</table>';
echo '</div>';
}

function admin_szolgcsoplist_keres(){
if(isset($_POST['csop_nev']))$_SESSION[$GLOBALS['sessionname']]['admin_szolgcsoplist_keres']['csop_nev']=$_POST['csop_nev'];
echo "ok$;$";
admin_szolgcsop_user_list();
}

function admin_szerz_szolgcsop_kereses(){
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgcsoplist_keres']['csop_nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgcsoplist_keres']['csop_nev']!=""))
 $ker_csop_nev=$_SESSION[$GLOBALS['sessionname']]['admin_szolgcsoplist_keres']['csop_nev'];
else $ker_csop_nev="";

echo '<div class="div_kereshez"><b>Keresés</b>';
echo '<table id="admin_szolgcsoplist_table" class="table_emre_kek">';

echo '<tbody>';
echo '<tr>';
echo '<td>Szolgáltatás csoport név';
echo '<td>';
echo '<input onkeyup="admin_szolgcsoplist_keres(\'tallep_elso\',\'\')" id="admin_szolgcsoplist_keres_csopnev" maxlength="255" style="width:300px" type="text">';

echo '</tr>';
echo '</tbody>';
echo '</table></div>';
}

function admin_szolgcsop_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_szolgcsop_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Meglévő adatok módosítása</b>';
echo '<table id="admin_szolgcsoplist_table" class="table_emre_kek">';
echo '<thead><tr>';

$order_mezo="szerz_csop.szerz_csop_id";
echo "<th style='width:40px' class='link' onclick='admin_szolgcsoplist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
echo tabl_nyilak('admin_szolgcsoplist_keres_order','admin_szolgcsoplist_keres_order_mod',$order_mezo);

$order_mezo="szerz_csop.szerz_csop_nev";
echo "<th style='width:40px' class='link' onclick='admin_szolgcsoplist_keres_proc(\"order\",\"".$order_mezo."\")'>Szolgáltatás csoport név ";
echo tabl_nyilak('admin_szolgcsoplist_keres_order','admin_szolgcsoplist_keres_order_mod',$order_mezo);

//echo '<th>Szolgáltatás kódok';
$order_mezo="szolg_kod_szam";
echo "<th style='width:40px' class='link' onclick='admin_szolgcsoplist_keres_proc(\"order\",\"".$order_mezo."\")'>Szolgáltatás kódok ";
echo tabl_nyilak('admin_szolgcsoplist_keres_order','admin_szolgcsoplist_keres_order_mod',$order_mezo);

$order_mezo="szerz_csop.kpi_szolg_kod";
echo "<th style='width:40px' class='link' onclick='admin_szolgcsoplist_keres_proc(\"order\",\"".$order_mezo."\")'>KPI szolgáltatás kód ";
echo tabl_nyilak('admin_szolgcsoplist_keres_order','admin_szolgcsoplist_keres_order_mod',$order_mezo);

$order_mezo="szerz_csop.kpi_szolg_kod_kozszolg";
echo "<th style='width:40px' class='link' onclick='admin_szolgcsoplist_keres_proc(\"order\",\"".$order_mezo."\")'>Közszolgáltatói KPI szolgáltatás kód ";
echo tabl_nyilak('admin_szolgcsoplist_keres_order','admin_szolgcsoplist_keres_order_mod',$order_mezo);

echo '</tr></thead><tbody>';

admin_szolgcsop_user_list_tal($tomb);

echo '</tbody></table>';
echo '</div>';
table_alja_lepeget('0',$th,'admin_szolgcsop','admin_szolgcsoplist_keres_talszam','admin_szolgcsoplist_keres_proc');

}

function admin_szolgcsop_user_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){
 echo '<tr>';
 
 echo '<td>';
 echo $ert['szerz_csop_id'];
 
 echo '<td>';
 echo '<input onkeyup="admin_modszolgcsop_ment(\''.$ert['szerz_csop_id'].'\')" id="admin_modszolgcsop_csopnev_'.$ert['szerz_csop_id'].'" value="'.$ert['szerz_csop_nev'].'" maxlength="255" style="width:300px" type="text">';
 
 echo '<td align=center>';
 echo '<span onclick="admin_modszolgcsopszolgkod_szolgkod_katt(\''.$ert['szerz_csop_id'].'\',\''.$ert['szerz_csop_nev'].'\')" class="link">'.$ert['szolg_kod_szam'].'</span>';

 //KPI szolgáltatás kód
 echo '<td>';
 echo '<select onchange="admin_modszolgcsop_ment(\''.$ert['szerz_csop_id'].'\')" class="select2_ajax" csonkolt="1" mod="admin_kpi_szolg_kod" id="admin_modszolgcsop_kpiszolgkod_'.$ert['szerz_csop_id'].'" style="width:150px">';
 if($ert['kpi_szolg_kod']==''){
  echo '<option value="keremv" selected>Kérem válassz';
 }else{
  echo '<option value="'.$ert['kpi_szolg_kod'].'" selected>'.$ert['kpi_szolg_kod'];
 }
 echo '</select>';
 
 //KPI szolgáltatás kód
 echo '<td align=center>';
 echo '<select onchange="admin_modszolgcsop_ment(\''.$ert['szerz_csop_id'].'\')" class="select2_ajax" csonkolt="1" mod="admin_kpi_szolg_kod" id="admin_modszolgcsop_kpiszolgkodkozszolg_'.$ert['szerz_csop_id'].'" style="width:150px">';
 if($ert['kpi_szolg_kod_kozszolg']==''){
  echo '<option value="keremv" selected>Kérem válassz';
 }else{
  echo '<option value="'.$ert['kpi_szolg_kod_kozszolg'].'" selected>'.$ert['kpi_szolg_kod_kozszolg'];
 }
 echo '</select>';

 echo '</tr>';
}
}
}
}

function admin_ujszolgcsop_ment(){
if((!isset($_POST['csopnev']))or(
(isset($_POST['csopnev'])and
($_POST['csopnev']==""))
)){
 echo "nook$;$"."Szolgáltatás csoport név megadása kötelező!";
 exit;
}

//2: Van-e Ilyen Szerződés típus
$szerz_csop_id=keres_mit1_mit1('szerz_csop','szerz_csop_nev',$_POST['csopnev'],'szerz_csop_id');
if(is_array($szerz_csop_id)){
 echo 'nook$;$Hiba! Van már ilyen szerződéses alapadat!';
 exit;
}else{
 $tmp_bk=array();
 $tmp_bk[0]['szerz_csop_nev']=$_POST['csopnev'];
 be_visz_insert('szerz_csop',$tmp_bk);

 echo "ok$;$";
}
}

function admin_modszolgcsop_ment(){
if(
 (isset($_POST['szerz_csop_id']))and
 (isset($_POST['csopnev']))and
 (isset($_POST['kpi_szolg_kod']))and
 (isset($_POST['kpi_szolg_kod_kozszolg']))and
 ($_POST['szerz_csop_id']!='')and
 ($_POST['csopnev']!='')
){
 $tmp_mod[0]['szerz_csop_nev']=$_POST['csopnev'];
 
 if(($_POST['kpi_szolg_kod']!='')and($_POST['kpi_szolg_kod']!='keremv')){
  $tmp_mod[0]['kpi_szolg_kod']=$_POST['kpi_szolg_kod'];
 }elseif($_POST['kpi_szolg_kod']=='keremv'){
  $tmp_mod[0]['kpi_szolg_kod']=null;
 }
 
 if(($_POST['kpi_szolg_kod_kozszolg']!='')and($_POST['kpi_szolg_kod_kozszolg']!='keremv')){
  $tmp_mod[0]['kpi_szolg_kod_kozszolg']=$_POST['kpi_szolg_kod_kozszolg'];
 }elseif($_POST['kpi_szolg_kod_kozszolg']=='keremv'){
  $tmp_mod[0]['kpi_szolg_kod_kozszolg']=null;
 }

 mod_egy_fel_tom('szerz_csop',$tmp_mod[0],'szerz_csop_id',$_POST['szerz_csop_id']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_modszolgcsopszolgkod_szolgkod_katt(){
echo "ok$;$";

echo "Szolgáltatás kód hozzárendelése <b>";
echo $_POST['szerz_csop_nev'];
echo "</b> Szolgáltatás csoporthoz<br><br>";

echo "<b>Szűrés:</b><br>";
echo '<table border=0>';
echo '<tr>';
echo "<td>Szolgáltatás kód:<td><input onkeyup='admin_modszolgcsopszolgkod_hozz_keress(\"\",\"\")' szerz_csop_id='".$_POST['szerz_csop_id']."' id='szolgcsopszolgkod_hozzidkod_keress' type=text style='width:250px'>";
echo '</tr>';
echo '<tr>';
echo "<td>Szolgáltatás neve:<td><input onkeyup='admin_modszolgcsopszolgkod_hozz_keress(\"\",\"\")' szerz_csop_id='".$_POST['szerz_csop_id']."' id='szolgcsopszolgkod_hozzid_keress' type=text style='width:250px'>";
echo '</tr>';
echo '</table>';

echo "<br>Csak hozzárendelt szolgáltatás kódok: ";
echo "<input onchange='admin_modszolgcsopszolgkod_hozz_keress_proc(\"\",\"\")' id='szolgcsopszolgkod_hozzid_csakhozz_szur' type='checkbox'>";

echo "<div id='szolgcsopszolgkod_hozzid_tal_div'>";
 $tomb_szerz_csop=keres_admin_szolgcsophoz_szolgkod($_POST['szerz_csop_id'],"","",0);
 $tomb_szerz_csop_van=keres_szolgcsophoz_szolgkod_user_hozzarend_adat($_POST['szerz_csop_id']);
 admin_mod_szolgcsopszolgkod_user_katt_list_ki($tomb_szerz_csop,$tomb_szerz_csop_van);
echo "</div>";
}

function admin_modszolgcsopszolgkod_hozz_keress(){
echo "ok$;$";
$tomb_szerz_csop=keres_admin_szolgcsophoz_szolgkod($_POST['szerz_csop_id'],$_POST['szolg_kod_nev'],$_POST['szolg_kod'],$_POST['csakvan']);
$tomb_szerz_csop_van=keres_szolgcsophoz_szolgkod_user_hozzarend_adat($_POST['szerz_csop_id']);
admin_mod_szolgcsopszolgkod_user_katt_list_ki($tomb_szerz_csop,$tomb_szerz_csop_van);
}

function admin_mod_szolgcsopszolgkod_user_katt_list_ki($tomb_szerz_csop,$tomb_szerz_csop_van){
if(is_array($tomb_szerz_csop)){
echo "<table style='margin-top:10px' class='table_emre_kek'>";

echo '<thead>';
echo '<tr>';
echo '<th>Szolgáltatás kód';
echo '<th>Szolgáltatás neve';
echo '<th>Hozzárendelés';
echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_szerz_csop as $i => $ert){

if($i==0){
	$th=$ert['tal'];
}else{

if(isset($tomb_szerz_csop_van[$ert['szolg_kod']])){
 $ck=" checked";
}else{
 $ck="";
}

echo "<tr>";

echo "<td>";
echo $ert['szolg_kod'];

echo "<td><label style='cursor:pointer' for='szolgcsopszolgkod_hozzid_".$ert['szolg_kod']."'>";
echo $ert['szolg_kod_nev'];

echo "<td align=center>";
//name='szolgcsopszolgkod_hozz'
echo "<input".$ck." class='link' onchange='admin_modszolgcsopszolgkod_hozz_change(\"".$ert['szolg_kod']."\",\"".$_POST['szerz_csop_id']."\")' id='szolgcsopszolgkod_hozzid_".$ert['szolg_kod']."' type='checkbox'>";
echo "</label>";


echo "</tr>";
}
}
echo "</tbody></table>";

table_alja_lepeget('0',$th,'admin_szolgcsophozszolgkod','admin_szolgcsophozszolgkodlist_keres_talszam','admin_modszolgcsopszolgkod_hozz_keress_proc');

}
}

function admin_modszolgcsopszolgkod_hozz_change(){
if(
(isset($_POST['szolg_kod']))and
(isset($_POST['szerz_csop_id']))and
(isset($_POST['mit']))and
($_POST['szolg_kod']!="")and
($_POST['szerz_csop_id']!="")and
($_POST['mit']!="")
){
 if($_POST['mit']==1){//Bevitel
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['szolg_kod']=$_POST['szolg_kod'];
  $tmp_bk_ker_def[0]['szerz_csop_id']=$_POST['szerz_csop_id'];
  be_visz_replace("szerz_csop_szolgkod",$tmp_bk_ker_def);
 }else{//Ekkor ki kell
  torles2("szerz_csop_szolgkod",'szolg_kod',$_POST['szolg_kod'],'szerz_csop_id',$_POST['szerz_csop_id']);
 }
 echo "ok$;$";
}else{
 echo 'adathiány';
}
}
?>