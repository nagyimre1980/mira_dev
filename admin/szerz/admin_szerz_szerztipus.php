<?php

function admin_szerz_szerztipus(){
echo 'ok$;$';

admin_szerz_szerztipus_urlap();
admin_szerz_szerztipus_kereses();
echo "<div id='admin_uj_szerztipus_list_keres_tal' style='overflow-x:auto'>";
admin_szerztipus_user_list();
echo "</div>";
}

function admin_szerz_szerztipus_urlap(){
echo '<div class="div_kereshez">';
echo '<b>Új szerződés típus:</b>';

echo '<table class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>Szerződés típus *';
echo '<td>';
echo '<input id="admin_ujszerztipus_nev" maxlength="255" type=text style="width:400px">';
echo '</tr>';

echo '<tr>';
echo '<td>Keretszerződés *';
echo '<td>';
echo '<input id="admin_ujszerztipus_szerzkeret" type="checkbox">';
echo '</tr>';

echo '<tr>';
echo '<td>Duplikálható szolgáltatás *';
echo '<td>';
echo '<input id="admin_ujszerztipus_dupla" type="checkbox">';
echo '</tr>';

echo '<tr><td colspan=2 align=left><input id="admin_ujszerztipus_submit" onclick="admin_ujszerztipus()" value="Új szerződéses alapadat felvitele" class="submit2" type=submit></tr>';
echo '</tbody>';
echo '</table>';
echo '</div>';
}

function admin_szerztipuslist_keres(){
if(isset($_POST['nev']))$_SESSION[$GLOBALS['sessionname']]['admin_szerztipuslist_keres']['nev']=$_POST['nev'];
echo "ok$;$";
admin_szerztipus_user_list();
}

function admin_szerz_szerztipus_kereses(){
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerztipuslist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerztipuslist_keres']['nev']!=""))
 $ker_nev=$_SESSION[$GLOBALS['sessionname']]['admin_szerztipuslist_keres']['nev'];
else $ker_nev="";

echo '<div class="div_kereshez"><b>Keresés</b> (keresés automatikusan *valami*-al történik)';

echo '<table id="admin_szervlist_table" class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>Szerződés típus';
echo '<td><input style="width:200px" onkeyup="admin_szerztipuslist_keres(\'\',\'\')" id="admin_szerztipuslist_keres_nev" value="'.$ker_nev.'" type=text>';

echo '</tr>';
echo '</tbody>';
echo '</table></div>';
}

function admin_szerztipus_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_szerztipus_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Meglévő adatok módosítása</b>';
echo '<table id="admin_szerztipuslist_table" class="table_emre_kek">';
echo '<thead><tr>';

$order_mezo="szerz_tipus.szerz_tipus_id";
echo "<th style='width:40px' class='link' onclick='admin_szerztipuslist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
echo tabl_nyilak('admin_szerztipuslist_keres_order','admin_szerztipuslist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tipus.szerz_tipus_nev";
echo "<th style='width:200px' class='link' onclick='admin_szerztipuslist_keres_proc(\"order\",\"".$order_mezo."\")'>Szerződés típus ";
echo tabl_nyilak('admin_szerztipuslist_keres_order','admin_szerztipuslist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tipus.szerz_tipus_szerz_keret";
echo "<th style='width:200px' class='link' onclick='admin_szerztipuslist_keres_proc(\"order\",\"".$order_mezo."\")'>Keretszerződés ";
echo tabl_nyilak('admin_szerztipuslist_keres_order','admin_szerztipuslist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tipus.szerz_tipus_dupla";
echo "<th style='width:200px' class='link' onclick='admin_szerztipuslist_keres_proc(\"order\",\"".$order_mezo."\")'>Duplikálható szolgáltatás ";
echo tabl_nyilak('admin_szerztipuslist_keres_order','admin_szerztipuslist_keres_order_mod',$order_mezo);

echo '</tr></thead><tbody>';

admin_szerztipus_user_list_tal($tomb);

echo '</tbody></table>';
echo '</div>';
table_alja_lepeget('0',$th,'admin_szerztipus','admin_szerztipuslist_keres_talszam','admin_szerztipuslist_keres_proc');
}

function admin_szerztipus_user_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){
 echo '<tr>';
 
 echo '<td>';
 echo $ert['szerz_tipus_id'];
 
 echo '<td>';
 echo '<input onkeyup="admin_modszerztipus_ment(\''.$ert['szerz_tipus_id'].'\')" id="admin_modszerztipus_nev_'.$ert['szerz_tipus_id'].'" value="'.$ert['szerz_tipus_nev'].'" maxlength="255" style="width:350px" type="text">';

 echo '<td align=center>';
 if($ert['szerz_tipus_szerz_keret']=='1')$ck_szerzkeret=' checked';
 else $ck_szerzkeret='';
 echo '<input'.$ck_szerzkeret.' onchange="admin_modszerztipus_ment(\''.$ert['szerz_tipus_id'].'\')" id="admin_modszerztipus_szerzkeret_'.$ert['szerz_tipus_id'].'" type="checkbox">';

 echo '<td align=center>';
 if($ert['szerz_tipus_dupla']=='1')$ck_dupla=' checked';
 else $ck_dupla='';
 echo '<input'.$ck_dupla.' onchange="admin_modszerztipus_ment(\''.$ert['szerz_tipus_id'].'\')" id="admin_modszerztipus_dupla_'.$ert['szerz_tipus_id'].'" type="checkbox">';
  
 echo '</tr>';
}
}
}
}

function admin_ujszerztipus_ment(){

//1.1 NÉV:
if((!isset($_POST['nev']))or(
(isset($_POST['nev'])and($_POST['nev']==""))
)){
 echo "nook$;$"."Hiba!<br><br>Szerződés típus kiválasztása kötelező!";
 exit;
}

//2: Van-e Ilyen Szerződés típus
$szervane=keres_mit1_mit1("szerz_tipus","szerz_tipus_nev",$_POST['nev'],"szerz_tipus_id");
if(is_array($szervane)){
 echo 'nook$;$Hiba!<br><br>Van már ilyen szerződés típus!';
 exit;
}else{

 $tmp_bk=array();
 $tmp_bk[0]['szerz_tipus_nev']=$_POST['nev'];
 if(isset($_POST['szerz_keret']))
  $tmp_bk[0]['szerz_tipus_szerz_keret']=$_POST['szerz_keret'];
 if(isset($_POST['dupla']))
  $tmp_bk[0]['szerz_tipus_dupla']=$_POST['dupla'];
 be_visz_insert("szerz_tipus",$tmp_bk);

echo "ok$;$";
}
}

function admin_modszerztipus_ment(){
if(
(isset($_POST['szerz_tipus_id']))and
(isset($_POST['szerz_tipus_nev']))and
(isset($_POST['szerz_keret']))and
(isset($_POST['dupla']))and
($_POST['szerz_tipus_id']!="")and
($_POST['szerz_tipus_nev']!="")and
 (($_POST['szerz_keret']=='0')or($_POST['szerz_keret']=='1'))and
 (($_POST['dupla']=='0')or($_POST['dupla']=='1'))
){
 $tmp_mod=array();
 $tmp_mod[0]['szerz_tipus_nev']=$_POST['szerz_tipus_nev'];
 $tmp_mod[0]['szerz_tipus_szerz_keret']=$_POST['szerz_keret'];
 $tmp_mod[0]['szerz_tipus_dupla']=$_POST['dupla'];
 mod_egy_fel_tom('szerz_tipus',$tmp_mod[0],'szerz_tipus_id',$_POST['szerz_tipus_id']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

?>