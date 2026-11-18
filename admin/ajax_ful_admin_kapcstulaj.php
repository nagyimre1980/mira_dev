<?php
//Tulajdonosi joggyakorló lista

function admin_kapcstulaj_mod(){
echo "ok$;$";
admin_kapcstulaj_mod_urlap();
admin_kapcstulaj_mod_kereses();
echo "<div id='admin_uj_kapcstulaj_list_keres_tal' style='overflow-x:auto'>";
admin_kapcstulaj_mod_list();
echo "</div>";
}

function admin_kapcstulaj_mod_urlap(){
echo "<div style='overflow-x:auto'><b>Új tulajdonosi joggyakorló:</b>";

echo "<table class='table_emre'>";

echo '<tr>';
echo '<td>Tulajdonosi joggyakorló kód *';
echo '<td>';
echo '<input id="admin_ujkapcstulaj_kod" type=text style="width:100px" maxlength="10">';
echo '</tr>';

echo "<tr>";
echo "<td>Tulajdonosi joggyakorló neve *";
echo "<td>";
echo "<input id='admin_ujkapcstulaj_nev' type=text style='width:400px' maxlength=255>";
echo "</tr>";

echo "<tr><td colspan=2 align=left><input id='admin_ujkapcstulaj_submit' onclick='admin_ujkapcstulaj()' type=submit value='Új tulajdonosi joggyakorló felvitele' class='submit2'></tr>";

echo "</table></div>";
}

function admin_kapcstulajlist_keres(){
if(isset($_POST['kod']))$_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['kod']=$_POST['kod'];
if(isset($_POST['nev']))$_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['nev']=$_POST['nev'];
if(isset($_POST['inaktiv']))$_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['inaktiv']=$_POST['inaktiv'];
echo "ok$;$";
admin_kapcstulaj_mod_list();
}

function admin_kapcstulaj_mod_kereses(){
echo '<div style="overflow-x:auto">';

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['kod']!=""))
 $ker_kod=$_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['kod'];
else $ker_kod="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['nev']!=""))
 $ker_nev=$_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['nev'];
else $ker_nev="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['inaktiv']!=""))
 $ker_inaktiv=$_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['inaktiv'];
else $ker_inaktiv="";

echo "<br><b>Keresés</b> (keresés automatikusan *valami*-al történik)";
echo "<table id='admin_kapcstulajlist_keres_table' class='table_emre'>";

echo "<tr>";
echo "<td>Kód";
echo "<td><input style='width:100px' maxlength='10' onkeyup='admin_kapcstulajlist_keres(\"tallep_elso\",\"\")' id='admin_kapcstulajlist_keres_kod' value='".$ker_kod."' type=text>";

echo "<td>Név";
echo "<td><input style='width:200px' maxlength='255' onkeyup='admin_kapcstulajlist_keres(\"tallep_elso\",\"\")' id='admin_kapcstulajlist_keres_nev' value='".$ker_nev."' type=text>";

echo "<td>Inaktív";
echo "<td><select onchange='admin_kapcstulajlist_keres_proc(\"tallep_elso\",\"\")' id='admin_kapcstulajlist_keres_inaktiv' style='width:150px'>
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

function admin_kapcstulaj_mod_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_kapcstulaj_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo "<br><b>Meglévő adatok módosítása</b>";
echo "<table id='admin_kapcstulajlist_table' class='table_emre'>";
echo "<thead><tr>";

$order_mezo="kapcs_tulaj.kapcs_tulaj_kod";
echo "<th style='width:150px' class='link' onclick='admin_kapcstulajlist_keres_proc(\"order\",\"".$order_mezo."\")'>Kód ";
echo tabl_nyilak('admin_kapcstulajlist_keres_order','admin_kapcstulajlist_keres_order_mod',$order_mezo);

$order_mezo="kapcs_tulaj.kapcs_tulaj_nev";
echo "<th style='width:200px' class='link' onclick='admin_kapcstulajlist_keres_proc(\"order\",\"".$order_mezo."\")'>Név ";
echo tabl_nyilak('admin_kapcstulajlist_keres_order','admin_kapcstulajlist_keres_order_mod',$order_mezo);

echo "<th>Inaktív";

echo "</tr></thead><tbody>";

admin_kapcstulaj_list_tal($tomb);

echo "</tbody></table>";

elozo_kovetkezo_gombok("admin_kapcstulajlist_keres_proc",$th,$GLOBALS['mira']['user_jog']['admin_kapcstulajlist_keres_talszam'],$_POST['oldalholvagyok']);

//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['admin_kapcstulajlist_keres_talszam'],"admin_kapcstulajlist_keres_proc","admin_kapcstulajlist_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='admin_kapcstulajlist_keres_tal_oldalholvagyok'>";

if(is_array($tomb)){
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['admin_kapcstulajlist_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='admin_kapcstulajlist_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['admin_kapcstulajlist_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_kapcstulajlist_keres_proc('tallep_elso','');</script>";
  }
 }
excel_export("admin_kapcstulajlist_keres",$th);
}
}

function admin_kapcstulaj_list_tal($tomb){

if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){

echo '<tr>';

echo '<td>';
echo $ert['kapcs_tulaj_kod'];

echo '<td>';
if($ert['kapcs_tulaj_inaktiv']==0)
 echo "<input type='text' style='width:400px' maxlength='100' onkeyup='admin_modkapcstulaj_ment(\"".$ert['kapcs_tulaj_kod']."\")' id='admin_ujkapcstulaj_nev_".$ert['kapcs_tulaj_kod']."' value='".$ert['kapcs_tulaj_nev']."'>";
else
 echo $ert['kapcs_tulaj_nev'];

//Inaktív
echo "<td align=center>";
if($ert['kapcs_tulaj_inaktiv']==1) $postck="checked";
 else $postck="";
echo "<input ".$postck." onclick='admin_modkapcstulaj_inaktiv(\"".$ert['kapcs_tulaj_kod']."\")' class='link' type='checkbox' id='admin_ujkapcstulajmod_inaktiv_".$ert['kapcs_tulaj_kod']."'>";

echo '</tr>';

}
}
}
}


function admin_ujkapcstulaj_ment(){

if((!isset($_POST['kod']))or(
(isset($_POST['kod'])and($_POST['kod']==""))
)){
 echo "nook$;$"."Tulajdonosi joggyakorló kód kitöltése kötelező";
 exit;
}

if((!isset($_POST['nev']))or(
(isset($_POST['nev'])and($_POST['nev']==""))
)){
 echo "nook$;$"."Tulajdonosi joggyakorló nevének kitöltése kötelező!";
 exit;
}

$vane=keres_mit1_mit1("kapcs_tulaj","kapcs_tulaj_kod",$_POST['kod'],"kapcs_tulaj_kod");
if(is_array($vane)){
	echo "Hiba! Van már ilyen Tulajdonosi joggyakorló kód!";
	exit;
}else{
 $tmp_bk=array();
 $tmp_bk[0]['kapcs_tulaj_kod']=$_POST['kod'];
 $tmp_bk[0]['kapcs_tulaj_nev']=$_POST['nev'];
 be_visz_insert("kapcs_tulaj",$tmp_bk);
 echo 'ok$;$';
}

}

function admin_modkapcstulaj_ment(){
if(
(isset($_POST['kod']))and
(isset($_POST['nev']))and
($_POST['kod']!="")and
($_POST['nev']!="")
){
 $tmp_mod=array();
 $tmp_mod[0]['kapcs_tulaj_nev']=$_POST['nev'];
 mod_egy_fel_tom('kapcs_tulaj',$tmp_mod[0],'kapcs_tulaj_kod',$_POST['kod']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_modkapcstulaj_inaktiv(){
if(
(isset($_POST['kod']))and
(isset($_POST['inaktiv']))and
($_POST['kod']!="")and
 (
  ($_POST['inaktiv']=="0")or
  ($_POST['inaktiv']=="1")
 )
){

mysqli_autocommit($GLOBALS['mysqli'],false);
 
 $tmp_mod_t=array();
 $tmp_mod_t[0]['kapcs_tulaj_kod']=null;
 mod_egy_fel_tom('mira_tagv_kod',$tmp_mod_t[0],'kapcs_tulaj_kod',$_POST['kod']);
  
 $tmp_mod=array();
 $tmp_mod[0]['kapcs_tulaj_inaktiv']=$_POST['inaktiv'];
 mod_egy_fel_tom('kapcs_tulaj',$tmp_mod[0],'kapcs_tulaj_kod',$_POST['kod']);

mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);

 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

?>