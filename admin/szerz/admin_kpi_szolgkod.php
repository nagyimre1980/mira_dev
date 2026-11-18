<?php

function admin_kpi_szolgkod(){
echo 'ok$;$';
admin_kpi_szolgkod_urlap();
admin_kpi_szolgkod_kereses();
echo '<div id="admin_uj_kpiszolgkod_list_keres_tal" style="overflow-x:auto">';
admin_kpiszolgkod_user_list();
echo '</div>';
}

function admin_kpi_szolgkod_urlap(){
echo '<div class="div_kereshez">';
echo '<b>Új KPI szolgáltatás kód:</b>';

echo '<table class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>KPI szolgáltatás kód *';
echo '<td>';
echo '<input id="admin_ujkpiszolgkod_szolgkod" maxlength="8" style="width:100px" type="text">';
echo '</tr>';

echo '<tr><td colspan=2 align=left><input id="admin_ujkpiszolgkod_submit" onclick="admin_ujkpiszolgkod()" value="Új KPI szolgáltatás kód felvitele" class="submit2" type=submit></tr>';
echo '</tbody>';
echo '</table>';

echo '</div>';
}

function admin_kpiszolgkodlist_keres(){
if(isset($_POST['kpi_szolg_kod']))$_SESSION[$GLOBALS['sessionname']]['admin_kpiszolgkodlist_keres']['kpi_szolg_kod']=$_POST['kpi_szolg_kod'];
echo "ok$;$";
admin_kpiszolgkod_user_list();
}

function admin_kpi_szolgkod_kereses(){
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiszolgkodlist_keres']['kpi_szolg_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiszolgkodlist_keres']['kpi_szolg_kod']!=""))
 $ker_kpi_szolg_kod=$_SESSION[$GLOBALS['sessionname']]['admin_kpiszolgkodlist_keres']['kpi_szolg_kod'];
else $ker_kpi_szolg_kod="";

echo '<div class="div_kereshez"><b>Keresés</b>';
echo '<table id="admin_kpiszolgkodlist_table" class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>KPI szolgáltatás kód';
echo '<td>';
echo '<input value="'.$ker_kpi_szolg_kod.'" onkeyup="admin_kpiszolgkodlist_keres(\'tallep_elso\',\'\')" id="admin_kpiszolgkodlist_keres_kpiszolgkod" maxlength="8" style="width:100px" type="text">';

echo '</tr>';
echo '</tbody>';
echo '</table></div>';
}

function admin_kpiszolgkod_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_kpiszolgkod_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Meglévő adatok módosítása</b>';
echo '<table id="admin_kpiszolgkodlist_table" class="table_emre_kek">';
echo '<thead><tr>';

$order_mezo="kpi_szolg_kod.kpi_szolg_kod";
echo "<th style='width:40px' class='link' onclick='admin_kpiszolgkodlist_keres_proc(\"order\",\"".$order_mezo."\")'>KPI szolgáltatás kód ";
echo tabl_nyilak('admin_kpiszolgkodlist_keres_order','admin_kpiszolgkodlist_keres_order_mod',$order_mezo);

echo '</tr></thead><tbody>';

admin_kpiszolgkod_user_list_tal($tomb);

echo '</tbody></table>';
echo '</div>';
table_alja_lepeget('0',$th,'admin_kpiszolgkod','admin_kpiszolgkodlist_keres_talszam','admin_kpiszolgkodlist_keres_proc');

}

function admin_kpiszolgkod_user_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){
 echo '<tr>';
 
 echo '<td>';
 echo $ert['kpi_szolg_kod'];
 //echo '<input onkeyup="admin_modnattipus_ment(\''.$ert['szerz_naturalia_id'].'\')" id="admin_modnattipus_naturalianev_'.$ert['szerz_naturalia_id'].'" value="'.$ert['szerz_naturalia_nev'].'" maxlength="100" style="width:300px" type="text">';
 
 echo '</tr>';
}
}
}
}

function admin_ujkpiszolgkod_ment(){

if((!isset($_POST['szolgkod']))or(
(isset($_POST['szolgkod'])and
($_POST['szolgkod']==""))
)){
 echo "nook$;$"."KPI szolgáltatás kód megadása kötelező!";
 exit;
}

//2: Van-e ilyen KPI szolgáltatás kód
$szolgkod=keres_mit1_mit1('kpi_szolg_kod','kpi_szolg_kod',$_POST['szolgkod'],'kpi_szolg_kod');
if(is_array($szolgkod)){
 echo 'nook$;$Hiba! Van már ilyen KPI szolgáltatás kód!';
 exit;
}else{
 $tmp_bk=array();
 $tmp_bk[0]['kpi_szolg_kod']=$_POST['szolgkod'];
 be_visz_insert('kpi_szolg_kod',$tmp_bk);

 echo "ok$;$";
}
}


?>