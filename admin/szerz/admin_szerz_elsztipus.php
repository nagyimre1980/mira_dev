<?php

function admin_szerz_elsztipus(){
echo 'ok$;$';
admin_szerz_elsztipus_urlap();
admin_szerz_elsztipus_kereses();
echo '<div id="admin_uj_elsztipus_list_keres_tal" style="overflow-x:auto">';
admin_elsztipus_user_list();
echo '</div>';
}

function admin_szerz_elsztipus_urlap(){
echo '<div class="div_kereshez">';
echo '<b>Új elszámolás típusa:</b>';

echo '<table class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>Elszámolás típusa *';
echo '<td>';
echo '<input id="admin_ujelsztipus_tipusnev" maxlength="50" style="width:300px" type="text">';
echo '</tr>';

echo '<tr><td colspan=2 align=left><input id="admin_ujelsztipus_submit" onclick="admin_ujelsztipus()" value="Új elszámolás típus felvitele" class="submit2" type=submit></tr>';
echo '</tbody>';
echo '</table>';
echo '</div>';
}

function admin_elsztipuslist_keres(){
if(isset($_POST['tipus_nev']))$_SESSION[$GLOBALS['sessionname']]['admin_elsztipuslist_keres']['tipus_nev']=$_POST['tipus_nev'];
echo "ok$;$";
admin_elsztipus_user_list();
}

function admin_szerz_elsztipus_kereses(){
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_elsztipuslist_keres']['tipus_nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_elsztipuslist_keres']['tipus_nev']!=""))
 $ker_tipus_nev=$_SESSION[$GLOBALS['sessionname']]['admin_elsztipuslist_keres']['tipus_nev'];
else $ker_tipus_nev="";

echo '<div class="div_kereshez"><b>Keresés</b>';
echo '<table id="admin_elsztipuslist_table" class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>Elszámolás típusa';
echo '<td>';
echo '<input onkeyup="admin_elsztipuslist_keres(\'tallep_elso\',\'\')" id="admin_elsztipuslist_keres_tipusnev" maxlength="50" style="width:300px" type="text">';

echo '</tr>';
echo '</tbody>';
echo '</table></div>';
}

function admin_elsztipus_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_elsztipus_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Meglévő adatok módosítása</b>';
echo '<table id="admin_elsztipuslist_table" class="table_emre_kek">';
echo '<thead><tr>';

$order_mezo="szerz_elsz_tipus.szerz_elsz_tipus_id";
echo "<th style='width:40px' class='link' onclick='admin_elsz_tipuslist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
echo tabl_nyilak('admin_elsztipuslist_keres_order','admin_elsztipuslist_keres_order_mod',$order_mezo);

$order_mezo="szerz_elsz_tipus.szerz_elsz_tipus_nev";
echo "<th style='width:40px' class='link' onclick='admin_elsz_tipuslist_keres_proc(\"order\",\"".$order_mezo."\")'>Elszámolás típus ";
echo tabl_nyilak('admin_elsztipuslist_keres_order','admin_elsztipuslist_keres_order_mod',$order_mezo);

echo '</tr></thead><tbody>';

admin_elsztipus_user_list_tal($tomb);

echo '</tbody></table>';

echo '</div>';
table_alja_lepeget('0',$th,'admin_elsztipus','admin_elsztipuslist_keres_talszam','admin_elsztipuslist_keres');

}

function admin_elsztipus_user_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){
 echo '<tr>';
 
 echo '<td>';
 echo $ert['szerz_elsz_tipus_id'];

 echo '<td>';
 echo '<input onkeyup="admin_modelsztipus_ment(\''.$ert['szerz_elsz_tipus_id'].'\')" id="admin_modelsztipus_tipusnev_'.$ert['szerz_elsz_tipus_id'].'" value="'.$ert['szerz_elsz_tipus_nev'].'" maxlength="50" style="width:300px" type="text">';
 
 echo '</tr>';
}
}
}
}

function admin_ujelsztipus_ment(){
if((!isset($_POST['tipusnev']))or(
(isset($_POST['tipusnev'])and
($_POST['tipusnev']==""))
)){
 echo "nook$;$"."Elszámolás típusa megadása kötelező!";
 exit;
}

//2: Van-e Ilyen Elszámolás típusa
$szerz_elsz_tipus_id=keres_mit1_mit1('szerz_elsz_tipus','szerz_elsz_tipus_nev',$_POST['tipusnev'],'szerz_elsz_tipus_id');
if(is_array($szerz_elsz_tipus_id)){
 echo 'nook$;$Hiba! Van már ilyen elszámolás típus név!';
 exit;
}else{
 $tmp_bk=array();
 $tmp_bk[0]['szerz_elsz_tipus_nev']=$_POST['tipusnev'];
 be_visz_insert('szerz_elsz_tipus',$tmp_bk);

 echo "ok$;$";
}

}

function admin_modelsztipus_ment(){
if(
 (isset($_POST['szerz_elsz_tipus_id']))and
 (isset($_POST['tipusnev']))and
 ($_POST['szerz_elsz_tipus_id']!='')and
 ($_POST['tipusnev']!='')
){
 $tmp_mod=array();
 $tmp_mod[0]['szerz_elsz_tipus_nev']=$_POST['tipusnev'];
 mod_egy_fel_tom('szerz_elsz_tipus',$tmp_mod[0],'szerz_elsz_tipus_id',$_POST['szerz_elsz_tipus_id']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

?>