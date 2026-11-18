<?php

function admin_kat_nev_mod(){
echo 'ok$;$';
admin_kat_nev_mod_urlap();
admin_kat_nev_mod_kereses();
echo "<div id='admin_uj_kat_nev_list_keres_tal' style='overflow-x:auto'>";
admin_kat_nev_mod_list();
echo '</div>';
}

function admin_kat_nev_mod_urlap(){
echo "<div style='overflow-x:auto'><b>Új önköltség kategória:</b>";

echo "<table class='table_emre'>";

echo '<tr>';
echo '<td>Önköltség kategória kód *';
echo '<td>';
echo '<input id="admin_ujkatnev_katnev" type=text style="width:200px" maxlength="255">';
echo '</tr>';

echo '<tr>';
echo '<td>Önköltség kategória név *';
echo '<td>';
echo '<input id="admin_ujkatnev_katnev_h" type=text style="width:400px" maxlength="255">';
echo '</tr>';

echo "<tr><td colspan=2 align=left><input id='admin_ujkatnev_submit' onclick='admin_ujkatnev()' type=submit value='Új önköltség kategória felvitele' class='submit2'></tr>";

echo "</table></div>";
}

function admin_katnevlist_keres(){
if(isset($_POST['nev']))$_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['nev']=$_POST['nev'];
if(isset($_POST['nev_h']))$_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['nev_h']=$_POST['nev_h'];
if(isset($_POST['inaktiv']))$_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['inaktiv']=$_POST['inaktiv'];
echo "ok$;$";
admin_kat_nev_mod_list();
}

function admin_kat_nev_mod_kereses(){
echo '<div style="overflow-x:auto">';

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['nev']!=""))
 $ker_nev=$_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['nev'];
else $ker_nev="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['nev_h']))and($_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['nev_h']!=""))
 $ker_nev_h=$_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['nev_h'];
else $ker_nev_h="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['inaktiv']!=""))
 $ker_inaktiv=$_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['inaktiv'];
else $ker_inaktiv="";

echo "<br><b>Keresés</b> (keresés automatikusan *valami*-al történik)";
echo "<table id='admin_katnevlist_keres_table' class='table_emre'>";

echo "<tr>";

echo "<td>Önköltség kategória kód";
echo "<td><input style='width:150px' onkeyup='admin_katnevlist_keres(\"\",\"\")' id='admin_katnevlist_keres_nev' value='".$ker_nev."' type=text>";

echo "<td>Önköltség kategória név";
echo "<td><input style='width:200px' onkeyup='admin_katnevlist_keres(\"\",\"\")' id='admin_katnevlist_keres_nev_h' value='".$ker_nev_h."' type=text>";

echo "<td>Inaktív";
echo "<td><select onchange='admin_katnevlist_keres_proc(\"tallep_elso\",\"\")' id='admin_katnevlist_keres_inaktiv' style='width:150px' class='select3'>
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

function admin_kat_nev_mod_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_katnev_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo "<br><b>Meglévő adatok módosítása</b>";
echo "<table id='admin_katnevlist_table' class='table_emre'>";
echo "<thead><tr>";

$order_mezo="projekt_kat.projekt_kat_id";
echo "<th style='width:30px' class='link' onclick='admin_katnevlist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
echo tabl_nyilak('admin_katnevlist_keres_order','admin_katnevlist_keres_order_mod',$order_mezo);

$order_mezo="projekt_kat.projekt_kat_nev";
echo "<th style='width:200px' class='link' onclick='admin_katnevlist_keres_proc(\"order\",\"".$order_mezo."\")'>Önköltség kategória kód ";
echo tabl_nyilak('admin_katnevlist_keres_order','admin_katnevlist_keres_order_mod',$order_mezo);

$order_mezo="projekt_kat.projekt_kat_nev_h";
echo "<th style='width:200px' class='link' onclick='admin_katnevlist_keres_proc(\"order\",\"".$order_mezo."\")'>Önköltség kategória név ";
echo tabl_nyilak('admin_katnevlist_keres_order','admin_katnevlist_keres_order_mod',$order_mezo);


echo "<th>Inaktív";

echo "</tr></thead><tbody>";

admin_uj_kat_nev_list_tal($tomb);

echo "</tbody></table>";

elozo_kovetkezo_gombok("admin_katnevlist_keres_proc",$th,$GLOBALS['mira']['user_jog']['admin_katnevlist_keres_talszam'],$_POST['oldalholvagyok']);

//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['admin_katnevlist_keres_talszam'],"admin_katnevlist_keres_proc","admin_katnevlist_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='admin_katnevlist_keres_tal_oldalholvagyok'>";

if(is_array($tomb)){
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['admin_katnevlist_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='admin_katnevlist_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['admin_katnevlist_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_katnevlist_keres_proc('tallep_elso','');</script>";
  }
 }
excel_export("admin_katnevlist_keres",$th);
}

}

function admin_uj_kat_nev_list_tal($tomb){

if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){

echo '<tr>';

echo '<td>';
echo $ert['projekt_kat_id'];

echo '<td>';
if($ert['projekt_kat_inaktiv']==0)
 echo "<input type='text' style='width:200px' maxlength='255' onkeyup='admin_modkatnev_ment(\"".$ert['projekt_kat_id']."\")' id='admin_ujkatnevmod_nev_".$ert['projekt_kat_id']."' value='".$ert['projekt_kat_nev']."'>";
else
 echo $ert['projekt_kat_nev'];

echo '<td>';
if($ert['projekt_kat_inaktiv']==0)
 echo "<input type='text' style='width:400px' maxlength='255' onkeyup='admin_modkatnev_ment(\"".$ert['projekt_kat_id']."\")' id='admin_ujkatnevmod_nevh_".$ert['projekt_kat_id']."' value='".$ert['projekt_kat_nev_h']."'>";
else
 echo $ert['projekt_kat_nev_h'];

 //Inaktív
echo "<td align=center>";
if($ert['projekt_kat_inaktiv']==1) $postck="checked";
 else $postck="";
echo "<input ".$postck." onclick='admin_modkatnev_inaktiv(\"".$ert['projekt_kat_id']."\")' class='link' type='checkbox' id='admin_ujkatnevmod_inaktiv_".$ert['projekt_kat_id']."'>";

echo '</tr>';

}
}
}
}

function admin_ujkatnev_ment(){

if(
(isset($_POST['katnev_h']))and
(isset($_POST['katnev']))and
($_POST['katnev']!='')
){

$vane=keres_mit1_mit1("projekt_kat","projekt_kat_nev",$_POST['katnev'],"projekt_kat_nev");
if(is_array($vane)){
	echo "Hiba! Van már ilyen kategória!";
	exit;
}else{
 $tmp_bk=array();
 $tmp_bk[0]['projekt_kat_nev']=$_POST['katnev'];
 $tmp_bk[0]['projekt_kat_nev_h']=$_POST['katnev_h'];
 be_visz_insert("projekt_kat",$tmp_bk);
 echo 'ok$;$';
}

}else{
 echo 'Adathiány';
}
}

function admin_modkatnev_ment(){
if(
(isset($_POST['kat_id']))and
(isset($_POST['nev']))and
(isset($_POST['nev_h']))and
($_POST['kat_id']!="")and
($_POST['nev']!="")
){
 $tmp_mod=array();
 $tmp_mod[0]['projekt_kat_nev']=$_POST['nev'];
 $tmp_mod[0]['projekt_kat_nev_h']=$_POST['nev_h'];
 mod_egy_fel_tom('projekt_kat',$tmp_mod[0],'projekt_kat_id',$_POST['kat_id']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}


function admin_modkatnev_inaktiv(){
if(
(isset($_POST['kat_id']))and
(isset($_POST['inaktiv']))and
($_POST['kat_id']!="")and
 (
  ($_POST['inaktiv']=="0")or
  ($_POST['inaktiv']=="1")
 )
){
 $tmp_mod=array();
 $tmp_mod[0]['projekt_kat_inaktiv']=$_POST['inaktiv'];
 mod_egy_fel_tom('projekt_kat',$tmp_mod[0],'projekt_kat_id',$_POST['kat_id']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}
?>