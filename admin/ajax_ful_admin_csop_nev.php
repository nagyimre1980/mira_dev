<?php

//Szervezet csoportosítás - eleje
function admin_csop_nev_mod(){
echo 'ok$;$';
admin_csop_nev_mod_urlap();
admin_csop_nev_mod_kereses();
echo "<div id='admin_uj_csop_nev_list_keres_tal' style='overflow-x:auto'>";
admin_csop_nev_mod_list();
echo "</div>";
}

function admin_csop_nev_mod_urlap(){
echo "<div style='overflow-x:auto'><b>Új csoportosítás:</b>";

echo "<table class='table_emre'>";

echo '<tr>';
echo '<td>Csoportosítási név *';
echo '<td>';
echo '<input id="admin_ujcsopnev_csopnev" type=text style="width:400px" maxlength="255">';
echo '</tr>';

echo "<tr><td colspan=2 align=left><input id='admin_ujcsopnev_submit' onclick='admin_ujcsopnev()' type=submit value='Új csoportosítási név felvitele' class='submit2'></tr>";

echo "</table></div>";
}

function admin_csopnevlist_keres(){
if(isset($_POST['nev']))$_SESSION[$GLOBALS['sessionname']]['admin_csopnevlist_keres']['nev']=$_POST['nev'];
if(isset($_POST['inaktiv']))$_SESSION[$GLOBALS['sessionname']]['admin_csopnevlist_keres']['inaktiv']=$_POST['inaktiv'];
echo "ok$;$";
admin_csop_nev_mod_list();
}

function admin_csop_nev_mod_kereses(){
echo '<div style="overflow-x:auto">';

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_csopnevlist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_csopnevlist_keres']['nev']!=""))
 $ker_nev=$_SESSION[$GLOBALS['sessionname']]['admin_csopnevlist_keres']['nev'];
else $ker_nev="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_csopnevlist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_csopnevlist_keres']['inaktiv']!=""))
 $ker_inaktiv=$_SESSION[$GLOBALS['sessionname']]['admin_csopnevlist_keres']['inaktiv'];
else $ker_inaktiv="";

echo "<br><b>Keresés</b> (keresés automatikusan *valami*-al történik)";
echo "<table id='admin_csopnevlist_keres_table' class='table_emre'>";

echo "<tr>";

echo "<td>Csoportosítási név";
echo "<td><input style='width:200px' onkeyup='admin_csopnevlist_keres(\"\",\"\")' id='admin_csopnevlist_keres_nev' value='".$ker_nev."' type=text>";

echo "<td>Inaktív";
echo "<td><select onchange='admin_csopnevlist_keres_proc(\"tallep_elso\",\"\")' id='admin_csopnevlist_keres_inaktiv' style='width:150px' class='select3'>
<option value=all>Minden";
if($ker_inaktiv=="0") $sel=" selected";
else $sel="";
echo "<option value=0".$sel.">Érvényes";
if($ker_inaktiv=="1") $sel=" selected";
else $sel="";
echo "<option value=1".$sel.">Inaktív";
echo "</select>";

echo '</table></div>';
}

function admin_csop_nev_mod_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_csopnev_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo "<br><b>Meglévő jogok módosítása</b>";
echo "<table id='admin_csopnevlist_table' class='table_emre'>";
echo "<thead><tr>";

$order_mezo="mira_szerv_csoport.mira_szerv_csoport_id";
echo "<th style='width:30px' class='link' onclick='admin_csopnevlist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
echo tabl_nyilak('admin_csopnevlist_keres_order','admin_csopnevlist_keres_order_mod',$order_mezo);

$order_mezo="mira_szerv_csoport.mira_szerv_csoport_nev";
echo "<th style='width:200px' class='link' onclick='admin_csopnevlist_keres_proc(\"order\",\"".$order_mezo."\")'>Csoportosítási név ";
echo tabl_nyilak('admin_csopnevlist_keres_order','admin_csopnevlist_keres_order_mod',$order_mezo);

echo "<th>Inaktív";

echo "</tr></thead><tbody>";

admin_uj_csop_nev_list_tal($tomb);

echo "</tbody></table>";

elozo_kovetkezo_gombok("admin_csopnevlist_keres_proc",$th,$GLOBALS['mira']['user_jog']['admin_csopnevlist_keres_talszam'],$_POST['oldalholvagyok']);

//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['admin_csopnevlist_keres_talszam'],"admin_csopnevlist_keres_proc","admin_csopnevlist_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='admin_csopnevlist_keres_tal_oldalholvagyok'>";

if(is_array($tomb)){
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['admin_csopnevlist_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='admin_csopnevlist_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['admin_csopnevlist_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_csopnevlist_keres_proc('tallep_elso','');</script>";
  }
 }
excel_export("admin_csopnevlist_keres",$th);
}

}

function admin_uj_csop_nev_list_tal($tomb){

if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){

echo '<tr>';

echo '<td>';
echo $ert['mira_szerv_csoport_id'];

echo '<td>';
if($ert['mira_szerv_csoport_inaktiv']==0)
 echo "<input type='text' style='width:400px' maxlength='255' onkeyup='admin_modcsopnev_ment(\"".$ert['mira_szerv_csoport_id']."\")' id='admin_ujcsopnevmod_nev_".$ert['mira_szerv_csoport_id']."' value='".$ert['mira_szerv_csoport_nev']."'>";
else
 echo $ert['mira_szerv_csoport_nev'];

 //Inaktív
echo "<td align=center>";
if($ert['mira_szerv_csoport_inaktiv']==1) $postck="checked";
 else $postck="";
echo "<input ".$postck." onclick='admin_modcsopnev_inaktiv(\"".$ert['mira_szerv_csoport_id']."\")' class='link' type='checkbox' id='admin_ujcsopnevmod_inaktiv_".$ert['mira_szerv_csoport_id']."'>";

echo '</tr>';

}
}
}
}

function admin_ujcsopnev_ment(){

if(
(isset($_POST['csopnev']))and
($_POST['csopnev']!='')
){

$vane=keres_mit1_mit1("mira_szerv_csoport","mira_szerv_csoport_nev",$_POST['csopnev'],"mira_szerv_csoport_nev");
if(is_array($vane)){
	echo "Hiba! Van már ilyen csoportosítási név!";
	exit;
}else{
 $tmp_bk=array();
 $tmp_bk[0]['mira_szerv_csoport_nev']=$_POST['csopnev'];
 be_visz_insert("mira_szerv_csoport",$tmp_bk);
 echo 'ok$;$';
}

}else{
 echo 'Adathiány';
}
}

function admin_modcsopnev_ment(){
if(
(isset($_POST['csoport_id']))and
(isset($_POST['nev']))and
($_POST['csoport_id']!="")and
($_POST['nev']!="")
){
 $tmp_mod=array();
 $tmp_mod[0]['mira_szerv_csoport_nev']=$_POST['nev'];
 mod_egy_fel_tom('mira_szerv_csoport',$tmp_mod[0],'mira_szerv_csoport_id',$_POST['csoport_id']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}


function admin_modcsopnev_inaktiv(){
if(
(isset($_POST['csoport_id']))and
(isset($_POST['inaktiv']))and
($_POST['csoport_id']!="")and
 (
  ($_POST['inaktiv']=="0")or
  ($_POST['inaktiv']=="1")
 )
){
 $tmp_mod=array();
 $tmp_mod[0]['mira_szerv_csoport_inaktiv']=$_POST['inaktiv'];
 mod_egy_fel_tom('mira_szerv_csoport',$tmp_mod[0],'mira_szerv_csoport_id',$_POST['csoport_id']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

//Szervezet csoportosítás - vége

?>