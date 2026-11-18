<?php

function admin_szerz_nattipus(){
echo 'ok$;$';
admin_szerz_nattipus_urlap();
admin_szerz_nattipus_kereses();
echo '<div id="admin_uj_nattipus_list_keres_tal" style="overflow-x:auto">';
admin_nattipus_user_list();
echo '</div>';
}


function admin_szerz_nattipus_urlap(){
echo '<div class="div_kereshez">';
echo '<b>Új elszámolás típusa:</b>';

echo '<table class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>Naturália típus *';
echo '<td>';
echo '<input id="admin_ujnattipus_naturalianev" maxlength="100" style="width:300px" type="text">';
echo '</tr>';

echo '<tr><td colspan=2 align=left><input id="admin_ujnattipus_submit" onclick="admin_ujnattipus()" value="Új naturália típus felvitele" class="submit2" type=submit></tr>';
echo '</tbody>';
echo '</table>';
echo '</div>';
}

function admin_nattipuslist_keres(){
if(isset($_POST['naturalia_nev']))$_SESSION[$GLOBALS['sessionname']]['admin_nattipuslist_keres']['naturalia_nev']=$_POST['naturalia_nev'];
echo "ok$;$";
admin_nattipus_user_list();
}

function admin_szerz_nattipus_kereses(){
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_nattipuslist_keres']['naturalia_nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_nattipuslist_keres']['naturalia_nev']!=""))
 $ker_naturalia_nev=$_SESSION[$GLOBALS['sessionname']]['admin_nattipuslist_keres']['naturalia_nev'];
else $ker_naturalia_nev="";

echo '<div class="div_kereshez"><b>Keresés</b>';
echo '<table id="admin_nattipuslist_table" class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>Naturália típusa';
echo '<td>';
echo '<input onkeyup="admin_nattipus_keres_proc(\'tallep_elso\',\'\')" id="admin_nattipuslist_keres_naturalianev" maxlength="100" style="width:300px" type="text">';

echo '</tr>';
echo '</tbody>';
echo '</table></div>';
}

function admin_nattipus_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_nattipus_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Meglévő adatok módosítása</b>';
echo '<table id="admin_nattipuslist_table" class="table_emre_kek">';
echo '<thead><tr>';

$order_mezo="szerz_naturalia.szerz_naturalia_id";
echo "<th style='width:40px' class='link' onclick='admin_nattipus_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
echo tabl_nyilak('admin_nattipuslist_keres_order','admin_nattipuslist_keres_order_mod',$order_mezo);

$order_mezo="szerz_naturalia.szerz_naturalia_nev";
echo "<th style='width:40px' class='link' onclick='admin_nattipus_keres_proc(\"order\",\"".$order_mezo."\")'>Naturália típus ";
echo tabl_nyilak('admin_nattipuslist_keres_order','admin_nattipuslist_keres_order_mod',$order_mezo);

echo '</tr></thead><tbody>';

admin_nattipus_user_list_tal($tomb);

echo '</tbody></table>';
echo '</div>';
table_alja_lepeget('0',$th,'admin_nattipus','admin_nattipuslist_keres_talszam','admin_nattipus_keres_proc');

}

function admin_nattipus_user_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){
 echo '<tr>';
 
 echo '<td>';
 echo $ert['szerz_naturalia_id'];
 
 echo '<td>';
 echo '<input onkeyup="admin_modnattipus_ment(\''.$ert['szerz_naturalia_id'].'\')" id="admin_modnattipus_naturalianev_'.$ert['szerz_naturalia_id'].'" value="'.$ert['szerz_naturalia_nev'].'" maxlength="100" style="width:300px" type="text">';
 
 echo '</tr>';
}
}
}
}

function admin_ujnattipus_ment(){
if((!isset($_POST['naturalianev']))or(
(isset($_POST['naturalianev'])and
($_POST['naturalianev']==""))
)){
 echo "nook$;$"."Naturália típusa megadása kötelező!";
 exit;
}

//2: Van-e ilyen Naturália típusa
$szerz_naturalia_id=keres_mit1_mit1('szerz_naturalia','szerz_naturalia_nev',$_POST['naturalianev'],'szerz_naturalia_id');
if(is_array($szerz_naturalia_id)){
 echo 'nook$;$Hiba! Van már ilyen naturália típus név!';
 exit;
}else{
 $tmp_bk=array();
 $tmp_bk[0]['szerz_naturalia_nev']=$_POST['naturalianev'];
 be_visz_insert('szerz_naturalia',$tmp_bk);

 echo "ok$;$";
}
}

function admin_modnattipus_ment(){
if(
 (isset($_POST['szerz_naturalia_id']))and
 (isset($_POST['naturalianev']))and
 ($_POST['szerz_naturalia_id']!='')and
 ($_POST['naturalianev']!='')
){
 $tmp_mod[0]['szerz_naturalia_nev']=$_POST['naturalianev'];
 mod_egy_fel_tom('szerz_naturalia',$tmp_mod[0],'szerz_naturalia_id',$_POST['szerz_naturalia_id']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}
?>