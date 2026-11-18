<?php

function admin_szolg_kod_mod(){
echo 'ok$;$';
admin_szolg_kod_mod_urlap();
admin_szolg_kod_mod_kereses();
echo "<div id='admin_uj_szolg_kod_list_keres_tal' style='overflow-x:auto'>";
admin_szolg_kod_mod_list();
echo "</div>";
}

function admin_szolg_kod_mod_urlap(){
echo "<div style='overflow-x:auto'><b>Új szolgáltatás kód:</b>";

echo "<table class='table_emre'>";

echo '<tr>';
echo '<td>Szolgáltatás kód *';
echo '<td>';
echo '<input id="admin_ujszolgkod_szolgkod" type=text style="width:80px" maxlength="4">';
echo '</tr>';

echo "<tr>";
echo "<td>Szolgáltatás neve *";
echo "<td>";
echo "<input id='admin_ujszolgkod_nev' type=text style='width:400px' maxlength=100>";
echo "</tr>";

echo "<tr><td colspan=2 align=left><input id='admin_ujszolgkod_submit' onclick='admin_ujszolgkod()' type=submit value='Új szolgáltatás kód felvitele' class='submit2'></tr>";

echo "</table></div>";
}

function admin_szolgkodlist_keres(){
if(isset($_POST['szolg_kod']))$_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['szolg_kod']=$_POST['szolg_kod'];
if(isset($_POST['nev']))$_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['nev']=$_POST['nev'];
if(isset($_POST['inaktiv']))$_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['inaktiv']=$_POST['inaktiv'];
echo "ok$;$";
admin_szolg_kod_mod_list();
}

function admin_szolg_kod_mod_kereses(){
echo '<div style="overflow-x:auto">';

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['szolg_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['szolg_kod']!=""))
 $ker_kod=$_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['szolg_kod'];
else $ker_kod="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['nev']!=""))
 $ker_nev=$_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['nev'];
else $ker_nev="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['inaktiv']!=""))
 $ker_inaktiv=$_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['inaktiv'];
else $ker_inaktiv="";

echo "<br><b>Keresés</b> (keresés automatikusan *valami*-al történik)";
echo "<table id='admin_szolgkodlist_keres_table' class='table_emre'>";

echo "<tr>";
echo "<td>Szolgáltatás kód";
echo "<td><input style='width:80px' onkeyup='admin_szolgkodlist_keres(\"\",\"\")' id='admin_szolgkodlist_keres_szolg_kod' value='".$ker_kod."' type=text>";

echo "<td>Szolgáltatás neve";
echo "<td><input style='width:200px' onkeyup='admin_szolgkodlist_keres(\"\",\"\")' id='admin_szolgkodlist_keres_nev' value='".$ker_nev."' type=text>";

echo "<td>Inaktív";
echo "<td><select onchange='admin_szolgkodlist_keres_proc(\"tallep_elso\",\"\")' id='admin_szolgkodlist_keres_inaktiv' class='select3' style='width:150px'>
<option value=all>Minden";
if($ker_inaktiv=="0") $sel=" selected";
else $sel="";
echo "<option value=0".$sel.">Érvényes";
if($ker_inaktiv=="1") $sel=" selected";
else $sel="";
echo "<option value=1".$sel.">Inaktív";
echo '</select>';
echo '</tr>';

echo '</table></div>';
}

function admin_szolg_kod_mod_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_szolgkod_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo "<br><b>Meglévő jogok módosítása</b>";
echo "<table id='admin_szolgkodlist_table' class='table_emre'>";
echo "<thead><tr>";

$order_mezo="mira_szolg_kod.szolg_kod";
echo "<th style='width:150px' class='link' onclick='admin_szolgkodlist_keres(\"order\",\"".$order_mezo."\")'>Szolgáltatás kód ";
echo tabl_nyilak('admin_szolgkodlist_keres_order','admin_szolgkodlist_keres_order_mod',$order_mezo);

$order_mezo="mira_szolg_kod.szolg_kod_nev";
echo "<th style='width:200px' class='link' onclick='admin_szolgkodlist_keres(\"order\",\"".$order_mezo."\")'>Szolgáltatás neve ";
echo tabl_nyilak('admin_szolgkodlist_keres_order','admin_szolgkodlist_keres_order_mod',$order_mezo);

echo "<th>Inaktív";

echo "</tr></thead><tbody>";

admin_uj_szolg_kod_list_tal($tomb);

echo "</tbody></table>";

elozo_kovetkezo_gombok("admin_szolgkodlist_keres_proc",$th,$GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_talszam'],$_POST['oldalholvagyok']);

//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_talszam'],"admin_szolgkodlist_keres_proc","admin_szolgkodlist_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='admin_szolgkodlist_keres_tal_oldalholvagyok'>";

if(is_array($tomb)){
//foreach($tomb as $i => $ert){
//if($i==0){
 //$th=$ert['tal'];
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='admin_szolgkodlist_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_szolgkodlist_keres_proc('tallep_elso','');</script>";
  }
 }
//}}
excel_export("admin_szolgkodlist_keres",$th);
}
}

function admin_uj_szolg_kod_list_tal($tomb){

if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){

echo '<tr>';

echo '<td>';
echo $ert['szolg_kod'];
 
echo '<td>';
if($ert['szolg_kod_inaktiv']==0)
 echo "<input type='text' style='width:400px' maxlength='100' onkeyup='admin_modszolgkod_ment(\"".$ert['szolg_kod']."\")' id='admin_ujszolgkodmod_nev_".$ert['szolg_kod']."' value='".$ert['szolg_kod_nev']."'>";
else
 echo $ert['szolg_kod_nev'];

 //Inaktív
echo "<td align=center>";
if($ert['szolg_kod_inaktiv']==1) $postck="checked";
 else $postck="";
echo "<input ".$postck." onclick='admin_modszolgkod_inaktiv(\"".$ert['szolg_kod']."\")' class='link' type='checkbox' id='admin_ujszolgkodmod_inaktiv_".$ert['szolg_kod']."'>";

echo '</tr>';

}
}
}
}

function admin_modszolgkod_inaktiv(){
if(
(isset($_POST['szolg_kod']))and
(isset($_POST['inaktiv']))and
($_POST['szolg_kod']!="")and
 (
  ($_POST['inaktiv']=="0")or
  ($_POST['inaktiv']=="1")
 )
){
 $tmp_mod=array();
 $tmp_mod[0]['szolg_kod_inaktiv']=$_POST['inaktiv'];
 mod_egy_fel_tom('mira_szolg_kod',$tmp_mod[0],'szolg_kod',$_POST['szolg_kod']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_modszolgkod_ment(){
if(
(isset($_POST['szolg_kod']))and
(isset($_POST['nev']))and
($_POST['szolg_kod']!="")and
($_POST['nev']!="")
){
 $tmp_mod=array();
 $tmp_mod[0]['szolg_kod_nev']=$_POST['nev'];
 mod_egy_fel_tom('mira_szolg_kod',$tmp_mod[0],'szolg_kod',$_POST['szolg_kod']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_ujszolgkod_ment(){

if((!isset($_POST['szolgkod']))or(
(isset($_POST['szolgkod'])and($_POST['szolgkod']==""))
)){
 echo "nook$;$"."Szolgáltatás kód kitöltése kötelező!";
 exit;
}

if((!isset($_POST['nev']))or(
(isset($_POST['nev'])and($_POST['nev']==""))
)){
 echo "nook$;$"."Szolgáltatás nevének kitöltése kötelező!";
 exit;
}

$vane=keres_mit1_mit1("mira_szolg_kod","szolg_kod",$_POST['szolgkod'],"szolg_kod");
if(is_array($vane)){
	echo "Hiba! Van már ilyen Szolgáltatás kód!";
	exit;
}else{
 $tmp_bk=array();
 $tmp_bk[0]['szolg_kod']=$_POST['szolgkod'];
 $tmp_bk[0]['szolg_kod_nev']=$_POST['nev'];
 be_visz_insert("mira_szolg_kod",$tmp_bk);
 echo 'ok$;$';
}

}

?>