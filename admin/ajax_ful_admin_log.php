<?php

function admin_log(){
echo 'ok$;$';

include_once('function_log.php');
echo '<span style="font-weight:bold">Logolás típusa:</span> ';
if($GLOBALS[$GLOBALS['sessionname']]['log_mod_all']=='1'){
 echo 'Teljes';
}else{
 echo 'Alapértelmezett';
}

echo '<br><input onclick="admin_loglist_archivalas()" id="admin_loglist_archivalas_submit" class="submit2" value="Archiválás indítása" type="submit">';

admin_uj_loglist_keres();
echo "<div id='admin_uj_log_list_keres_tal'>";
admin_uj_log_list();
echo "</div>";
}

function admin_uj_loglist_keres(){
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['user_nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['user_nev']!=""))
 $user_nev=$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['user_nev'];
else $user_nev="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['mikor']))and($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['mikor']!=""))
 $mikor=$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['mikor'];
else $mikor="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['adat_elozmeny']))and($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['adat_elozmeny']!=""))
 $adat_elozmeny=$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['adat_elozmeny'];
else $adat_elozmeny="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['adat']))and($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['adat']!=""))
 $adat=$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['adat'];
else $adat="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['log_mod']))and($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['log_mod']!=""))
 $log_mod=$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['log_mod'];
else $log_mod="all";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['log_muvelet']))and($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['log_muvelet']!=""))
 $log_muvelet=$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['log_muvelet'];
else $log_muvelet="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['hol']))and($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['hol']!=""))
 $hol=$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['hol'];
else $hol="";

echo '<div class="div_kereshez">';
echo '<b>Keresés</b>';

echo "<table class='table_emre'>";
echo "<tbody>";

echo '<tr>';
echo '<td>Típus';
echo '<td><select onchange="admin_loglist_keres_proc(\'\',\'\')" id="admin_kereslog_mod" class="select3" style="width:109px">';
echo '<option value="all"';
if($log_mod=='all')echo ' selected';
echo '>Összes';

echo '<option value="bevitel"';
if($log_mod=='bevitel')echo ' selected';
echo '>'.admin_loglist_tipus_tipus_nevki("bevitel");

echo '<option value="mod"';
if($log_mod=='mod')echo ' selected';
echo '>'.admin_loglist_tipus_tipus_nevki("mod");

echo '<option value="del"';
if($log_mod=='del')echo ' selected';
echo '>'.admin_loglist_tipus_tipus_nevki("del");

echo '</select>';

echo '<td>Tábla';
echo '<td><input onkeyup="admin_loglist_keres(\'\',\'\')" id="admin_kereslog_muvelet" value="'.$log_muvelet.'" type="text" style="width:200px" maxlength="100">';

echo '<td>Hol';
echo '<td colspan=3><input onkeyup="admin_loglist_keres(\'\',\'\')" id="admin_kereslog_hol" value="'.$hol.'" type="text" style="width:200px" maxlength="100">';

echo '</tr>';

echo '<tr>';

echo '<td>Mikor';
echo '<td><input onchange="admin_loglist_keres_proc(\'\',\'\')" id="admin_kereslog_mikor" class="date_tolegy2" value="'.$mikor.'" type="text" style="width:99px" maxlength="10">';

echo '<td>Előzmény';
echo '<td><input onkeyup="admin_loglist_keres(\'\',\'\')" id="admin_kereslog_adat_elozmeny" value="'.$adat_elozmeny.'" type="text" style="width:200px" maxlength="100">';

echo '<td>Adat';
echo '<td><input onkeyup="admin_loglist_keres(\'\',\'\')" id="admin_kereslog_adat" value="'.$adat.'" type="text" style="width:200px" maxlength="100">';

echo '<td>Ki';
echo '<td><input onkeyup="admin_loglist_keres(\'\',\'\')" id="admin_kereslog_user_nev" value="'.$user_nev.'" type="text" style="width:200px" maxlength="100">';


echo '</tr>';

echo '</tbody>';
echo '</table>';
echo '</div>';
}

function admin_loglist_keres(){
if(isset($_POST['user_nev']))$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['user_nev']=$_POST['user_nev'];
if(isset($_POST['mikor']))$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['mikor']=$_POST['mikor'];
if(isset($_POST['adat_elozmeny']))$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['adat_elozmeny']=$_POST['adat_elozmeny'];
if(isset($_POST['adat']))$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['adat']=$_POST['adat'];
if(isset($_POST['log_mod']))$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['log_mod']=$_POST['log_mod'];
if(isset($_POST['log_muvelet']))$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['log_muvelet']=$_POST['log_muvelet'];
if(isset($_POST['hol']))$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['hol']=$_POST['hol'];

echo "ok$;$";
admin_uj_log_list();
}

function admin_uj_log_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_log_uj();
$th=0;

if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Meglévő jogok módosítása</b>';

echo '<table cellpadding="1" cellspacing="1" id="admin_tagvlist_table" class="table_emre">';
echo '<thead><tr>';

$order_mezo="mira_log.log_id";
echo "<th class='link' onclick='admin_loglist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
echo tabl_nyilak('admin_loglist_keres_order','admin_loglist_keres_order_mod',$order_mezo);

$order_mezo="mira_log.log_mod";
echo "<th class='link' onclick='admin_loglist_keres_proc(\"order\",\"".$order_mezo."\")'>Típus ";
echo tabl_nyilak('admin_loglist_keres_order','admin_loglist_keres_order_mod',$order_mezo);

$order_mezo="mira_log.log_muvelet";
echo "<th class='link' onclick='admin_loglist_keres_proc(\"order\",\"".$order_mezo."\")'>Tábla ";
echo tabl_nyilak('admin_loglist_keres_order','admin_loglist_keres_order_mod',$order_mezo);

echo '<th>Hol';
echo '<th>Előzmény';
echo '<th>Adat';
echo '<th>Ki';
echo '<th>Mikor';

echo '</tr></thead><tbody>';

admin_uj_log_list_tal($tomb);

echo '</tbody></table>';

table_alja_lepeget('0',$th,'admin_log','admin_loglist_keres_talszam','admin_loglist_keres_proc');

echo '</div>';
}

function admin_uj_log_list_tal($tomb){
if(is_array($tomb)){
include_once('ajax_ful_admin_log_display.php');
foreach($tomb as $i => $ert){
if($i>0){

 echo '<tr>';
 
 echo '<td>';
 echo $ert['log_id'];

 echo '<td>';
 echo admin_loglist_tipus_tipus_nevki($ert['log_mod']);

 echo '<td>';
 echo $ert['log_muvelet'];

 //HOL - eleje
 echo '<td>';
 echo format_log_conditions($ert);

 echo '<td>';
 echo format_log_json($ert['log_adat_elozmeny']);

 echo '<td>';
 echo format_log_json($ert['log_adat']);
 //echo format_log_json_simple($ert['log_adat']);
 
 echo '<td>';
 echo $ert['user_nev'];

 echo '<td>';
 echo kidate_format($ert['ment_log_mikor']);
 
 echo '</tr>';
}
}
}
}

function admin_loglist_tipus_tipus_nevki($tipus){
switch($tipus){
 case'bevitel':
  $ret='Bevitel';
 break;
 case'mod':
  $ret='Módosítás';
 break;
 case'del':
  $ret='Törlés';
 break;
 default:
  $ret='';
 break;
}
return $ret;
}

function admin_loglist_archivalas(){

shell_exec("cd ".$GLOBALS['log_mentes_mysqldump']." && php ".$GLOBALS['log_mentes_mysqldump'].$GLOBALS['log_mentes_mysqldump_php']);
shell_exec("cd ".$GLOBALS['log_mentes_fionamappa']."excel_export_auto/ && php ".$GLOBALS['log_mentes_fionamappa']."excel_export_auto/excel_admin_log.php");

//Tábla törlése
$sql="TRUNCATE TABLE `mira_log`";
//$sql="delete from `mira_log`";
if(mysqli_query($GLOBALS['mysqli'],$sql)){
 echo 'ok$;$';
}

}
?>