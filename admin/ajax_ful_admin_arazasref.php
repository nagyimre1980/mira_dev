<?php

function admin_arazasref_mod(){
echo "ok$;$";

admin_arazasref_mod_kereses();
echo "<div id='admin_uj_arazasref_list_keres_tal' style='overflow-x:auto'>";
admin_arazasref_user_list();
echo "</div>";

}

function admin_arazasreflist_keres(){
if(isset($_POST['id']))$_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['id']=$_POST['id'];
if(isset($_POST['nev']))$_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['nev']=$_POST['nev'];
if(isset($_POST['inaktiv']))$_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['inaktiv']=$_POST['inaktiv'];
if(isset($_POST['arazasref']))$_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['arazasref']=$_POST['arazasref'];
echo "ok$;$";
admin_arazasref_user_list();
}

function admin_arazasref_mod_kereses(){
echo '<div style="overflow-x:auto">';

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['id']))and($_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['id']!=""))
 $ker_id=$_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['id'];
else $ker_id="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['nev']!=""))
 $ker_nev=$_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['nev'];
else $ker_nev="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['inaktiv']!=""))
 $ker_inaktiv=$_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['inaktiv'];
else $ker_inaktiv="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['arazasref']))and($_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['arazasref']!=""))
 $ker_arazasref=$_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['arazasref'];
else $ker_arazasref="";

//<br>
echo "<b>Keresés</b> (keresés automatikusan *valami*-al történik)";

echo "<table id='admin_arazasreflist_keres_table' class='table_emre'>";

echo "<tr>";
echo "<td>ID";
echo "<td><input style='width:50px' onkeyup='admin_arazasreflist_keres(\"\",\"\")' id='admin_arazasreflist_keres_id' value='".$ker_id."' maxlength=5 type=text>";

echo "<td>Tevékenység neve";
echo "<td><input style='width:250px' onkeyup='admin_arazasreflist_keres(\"\",\"\")' id='admin_arazasreflist_keres_nev' value='".$ker_nev."' type=text>";

echo "<td>Árazási szempontból releváns";
echo "<td><select onchange='admin_arazasreflist_keres_proc(\"tallep_elso\",\"\")' id='admin_arazasreflist_keres_arazasref' class='select3' style='width:120px'>";
echo "<option value=all>Minden";

if($ker_arazasref=="keremv") $sel=" selected";
else $sel="";
echo "<option value='keremv'".$sel.">Kérem válassz";

if($ker_arazasref=="0") $sel=" selected";
else $sel="";
echo "<option value=0".$sel.">Nem";

if($ker_arazasref=="1") $sel=" selected";
else $sel="";
echo "<option value=1".$sel.">Igen";

echo '</select>';

echo "<td>Inaktív";
echo "<td><select onchange='admin_arazasreflist_keres_proc(\"tallep_elso\",\"\")' id='admin_arazasreflist_keres_inaktiv' class='select3' style='width:90px'>
<option value=all>Minden";

if($ker_inaktiv=="0") $sel=" selected";
else $sel="";
echo "<option value=0".$sel.">Érvényes";

if($ker_inaktiv=="1") $sel=" selected";
else $sel="";
echo "<option value=1".$sel.">Inaktív";

echo '</select>';

echo "</tr>";
 
echo "</table></div>";
}

function admin_arazasref_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_arazasref_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo "<br><b>Meglévő adatok módosítása</b>";
echo "<table id='admin_arazasreflist_table' class='table_emre'>";
echo "<thead><tr>";

$order_mezo="projekt.projekt_id";
echo "<th style='width:50px' class='link' onclick='admin_arazasreflist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
echo tabl_nyilak('admin_arazasreflist_keres_order','admin_arazasreflist_keres_order_mod',$order_mezo);

$order_mezo="projekt.projekt_nev";
echo "<th style='width:200px' class='link' onclick='admin_arazasreflist_keres_proc(\"order\",\"".$order_mezo."\")'>Tevékenység neve ";
echo tabl_nyilak('admin_arazasreflist_keres_order','admin_arazasreflist_keres_order_mod',$order_mezo);

$order_mezo="projekt.projekt_arazasref";
echo "<th style='width:200px' class='link' onclick='admin_arazasreflist_keres_proc(\"order\",\"".$order_mezo."\")'>Árazási szempontból releváns ";
echo tabl_nyilak('admin_arazasreflist_keres_order','admin_arazasreflist_keres_order_mod',$order_mezo);

echo "<th>Inaktív";

echo "</tr></thead><tbody>";

admin_uj_arazasref_list_tal($tomb);

echo "</tbody></table>";

elozo_kovetkezo_gombok("admin_arazasreflist_keres_proc",$th,$GLOBALS['mira']['user_jog']['admin_arazasreflist_keres_talszam'],$_POST['oldalholvagyok']);

//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['admin_arazasreflist_keres_talszam'],"admin_arazasreflist_keres_proc","admin_arazasreflist_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='admin_arazasreflist_keres_tal_oldalholvagyok'>";

if(is_array($tomb)){
//foreach($tomb as $i => $ert){
//if($i==0){
 //$th=$ert['tal'];
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['admin_arazasreflist_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='admin_arazasreflist_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['admin_arazasreflist_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_arazasreflist_keres_proc('tallep_elso','');</script>";
  }
 }
//}}
excel_export("admin_arazasreflist_keres",$th);
}

}

function admin_uj_arazasref_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){

echo "<tr title='".$ert['projekt_nev']."' class='ttooltip'>";

echo '<td>';
echo $ert['projekt_id'];

echo '<td>';
echo $ert['projekt_nev'];

echo '<td>';
echo '<select onchange="admin_modarazasref_ment_arazasref(\''.$ert['projekt_id'].'\')" class="select3" id="admin_arazasrefmod_arazasref_'.$ert['projekt_id'].'" style="width:120px">';
echo '<option value="keremv"';
if($ert['projekt_arazasref']=='')echo ' selected';
echo '>Kérem válassz';

echo '<option value="0"';
if($ert['projekt_arazasref']=='0')echo ' selected';
echo '>Nem';

echo '<option value="1"';
if($ert['projekt_arazasref']=='1')echo ' selected';
echo '>Igen';

echo '</select>';

echo '<td>';
echo igennem_kod_ki($ert['projekt_inaktiv']);

echo "</tr>";
}
}
}
}

function admin_modarazasref_ment_arazasref(){
if(
(isset($_POST['projekt_id']))and
(isset($_POST['arazasref']))and
($_POST['projekt_id']!="")and
($_POST['arazasref']!="")
){

$tmp_mod=array();
$tmp_mod[0]['projekt_arazasref']=$_POST['arazasref'];

mod_egy_fel_tom('projekt',$tmp_mod[0],'projekt_id',$_POST['projekt_id']);
echo "ok$;$";
}else{
 echo 'adathiány';
}
}

?>