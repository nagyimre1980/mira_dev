<?php

function admin_szerz_tigadat_vevoazon(){
echo 'ok$;$';
admin_szerz_tigadatvevoazon_kereses();
echo '<div id="admin_uj_tigadatvevoazon_list_keres_tal" style="overflow-x:auto">';
admin_tigadatvevoazon_user_list();
echo '</div>';
}

function admin_tigadatvevoazonlist_keres(){
if(isset($_POST['tagv_kod']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatvevoazonlist_keres']['tagv_kod']=$_POST['tagv_kod'];
echo "ok$;$";
admin_tigadatvevoazon_user_list();
}

function admin_szerz_tigadatvevoazon_kereses(){
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatvevoazonlist_keres']['tagv_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatvevoazonlist_keres']['tagv_kod']!="all"))
 $ker_tagv_kod=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatvevoazonlist_keres']['tagv_kod'];
else $ker_tagv_kod="all";

echo '<div class="div_kereshez"><b>Keresés</b>';
echo '<table id="admin_tigadatvevoazonlist_table" class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>Társaság';
echo '<td>';
echo '<select onchange="admin_tigadatvevoazonlist_keres_proc(\'tallep_elso\',\'\')" id="admin_tigadatvevoazonlist_keres_tagv" class="select2_ajax" csonkolt=1 mod="admin_tagvkod_uj_all" style="width:311px">';
if($ker_tagv_kod!='all'){
 $ker_tagv_kod_nev=keres_mit1_mit1_csak_ertek('mira_tagv_kod','tagv_kod',$ker_tagv_kod,'tagv_kod_nev');
 echo '<option value="'.$ker_tagv_kod.'">'.$ker_tagv_kod.' - '.$ker_tagv_kod_nev;
}else{
 echo '<option value="all">Összes';
}
echo '</select>';

echo '</tr>';
echo '</tbody>';
echo '</table></div>';
}

function admin_tigadatvevoazon_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_tigadatvevoazon_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Meglévő adatok módosítása</b>';
echo '<table id="admin_tigadatvevoazonlist_table" class="table_emre_kek">';
echo '<thead><tr>';

$order_mezo="mira_tagv_kod.tagv_kod";
echo "<th style='width:40px' class='link' onclick='admin_tigadatvevoazonlist_keres_proc(\"order\",\"".$order_mezo."\")'>SAP kód ";
echo tabl_nyilak('admin_tigadatvevoazonlist_keres_order','admin_tigadatvevoazonlist_keres_order_mod',$order_mezo);

$order_mezo="mira_tagv_kod.tagv_kod_nev";
echo "<th style='width:40px' class='link' onclick='admin_tigadatvevoazonlist_keres_proc(\"order\",\"".$order_mezo."\")'>Társaság neve ";
echo tabl_nyilak('admin_tigadatvevoazonlist_keres_order','admin_tigadatvevoazonlist_keres_order_mod',$order_mezo);

$order_mezo="mira_tagv_kod.tagv_kod_vevoazon";
echo "<th style='width:40px' class='link' onclick='admin_tigadatvevoazonlist_keres_proc(\"order\",\"".$order_mezo."\")'>Vevő azonosító ";
echo tabl_nyilak('admin_tigadatvevoazonlist_keres_order','admin_tigadatvevoazonlist_keres_order_mod',$order_mezo);

echo '</tr></thead><tbody>';

admin_tigadatvevoazon_user_list_tal($tomb);

echo '</tbody></table>';
echo '</div>';
table_alja_lepeget('0',$th,'admin_tigadatvevoazon','admin_tigadatvevoazonlist_keres_talszam','admin_tigadatvevoazonlist_keres_proc');

}

function admin_tigadatvevoazon_user_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){
 echo '<tr>';
 
 echo '<td>';
 echo $ert['tagv_kod'];
 
 echo '<td>';
 echo $ert['tagv_kod_nev'];
 
 echo '<td>';
 echo '<input onkeyup="admin_modtigadatvevoazon_ment(\''.$ert['tagv_kod'].'\')" id="admin_modtigadatvevoazon_vevoazon_'.$ert['tagv_kod'].'" value="'.$ert['tagv_kod_vevoazon'].'" style="width:80px" maxlength="8" type="text">';

 echo '</tr>';
}
}
}
}

function admin_modtigadatvevoazon_ment(){
if(
 (isset($_POST['tagv_kod']))and
 (isset($_POST['vevoazon']))and
 ($_POST['tagv_kod']!='')and
 ($_POST['vevoazon']!='')
){
 $tmp_mod=array();
 $tmp_mod[0]['tagv_kod_vevoazon']=$_POST['vevoazon'];
 mod_egy_fel_tom('mira_tagv_kod',$tmp_mod[0],'tagv_kod',$_POST['tagv_kod']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}
?>