<?php

function admin_szerv_mod(){
echo "ok$;$";

admin_szerv_mod_urlap();
admin_szerv_mod_kereses();
echo "<div id='admin_uj_szerv_list_keres_tal' style='overflow-x:auto'>";
admin_szerv_user_list();
echo "</div>";

}

function admin_szerv_mod_urlap(){
echo "<div style='overflow-x:auto'>";
echo "<b>Új szervezet:</b>";

echo "<table class='table_emre'>";

echo "<tr>";
echo "<td>Szervezet neve *";
echo "<td>";
echo "<input id='admin_ujszerv_nev' type=text style='width:400px'>";
echo "</tr>";

echo "<tr>";
echo "<td>Statisztika költséghely *";
//echo "<br>(statisztikához)";
echo "<td>";
echo "<input id='admin_uj_szerv_koltsegkod' maxlength=10 style='width:400px' type='text'>";
echo "</tr>";

echo "<tr>";
echo "<td>AD költséghely *";
//echo "<br>(Új userhez)";
echo "<td>";
echo "<input id='admin_uj_szerv_adkod' maxlength=10 style='width:400px' type='text'>";
echo "</tr>";

//Szervezeti szolgáltatás kód
echo '<tr>';
echo '<td>Szervezeti szolgáltatás kód *';
echo '<td>';
//echo '<input id="admin_uj_szerv_szolgkod" maxlength="4" style="width:80px" type="text">';
echo '<select id="admin_uj_szerv_szolgkod" class="select2_ajax" csonkolt=1 mod="admin_szolgkod_uj" style="width:411px">';
echo '<option value="keremv">Kérem válassz';
echo '</select>';
echo '</tr>';

//Csoportosítási név
echo '<tr>';
echo '<td>Szervezet csoportosítási név *';
echo '<td>';
echo '<select id="admin_uj_szerv_csopid" class="select2_ajax" csonkolt=1 mod="admin_csopnev_uj" style="width:411px">';
echo '<option value="keremv">Kérem válassz';
echo '</select>';
echo '</tr>';

//SM SAP kód
echo '<tr>';
echo '<td>SM SAP kód *';
echo '<td>';
echo "<input id='admin_uj_szerv_smkod' maxlength=6 style='width:80px' type='text'>";
echo '</tr>';

echo "<tr>";
echo "<td>Tevékenységek *";
echo "<td>";
echo "<span onclick='admin_uj_szerv_proj_katt()' id='admin_uj_szerv_proj_span' class='link'>Tevékenység hozzáadása</span>";
echo "<input type='hidden' id='admin_uj_szerv_proj_id'>";
echo "</tr>";

echo "<tr>";
echo "<td>Jóváhagyók *";
echo "<td>";
echo "<span onclick='admin_uj_szerv_jovahagyo_katt()' id='admin_uj_szerv_jovahagyo_span' class='link'>Jóváhagyók hozzáadása</span>";
echo "<input type='hidden' id='admin_uj_szerv_jovahagyo_id'>";
echo "</tr>";

echo "<tr><td colspan=2 align=left><input id='admin_ujszerv_submit' onclick='admin_ujszerv()' type=submit value='Új szervezet felvitele' class='submit2'></tr>";

echo "</table>";
echo "</div>";
}

function admin_szervlist_keres(){
if(isset($_POST['nev']))$_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['nev']=$_POST['nev'];
if(isset($_POST['csoport_id']))$_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['csoport_id']=$_POST['csoport_id'];
if(isset($_POST['inaktiv']))$_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['inaktiv']=$_POST['inaktiv'];
echo "ok$;$";
admin_szerv_user_list();
}

function admin_szerv_mod_kereses(){

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['nev']!=""))
 $ker_nev=$_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['nev'];
else $ker_nev="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['csoport_id']))and($_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['csoport_id']!=""))
 $csoport_id=$_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['csoport_id'];
else $csoport_id="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['inaktiv']!=""))
 $ker_inaktiv=$_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['inaktiv'];
else $ker_inaktiv="";

echo "<br><div style='overflow-x:auto'><b>Keresés</b> (keresés automatikusan *valami*-al történik)";

echo "<table id='admin_szervlist_keres_table' class='table_emre'>";

echo "<tr>";
echo "<td>Szervezet neve";
echo "<td><input style='width:200px' onkeyup='admin_szervlist_keres(\"\",\"\")' id='admin_szervlist_keres_nev' value='".$ker_nev."' type=text>";

echo "<td>Csoportosítási név";
echo '<td>';
 echo "<select onchange='admin_szervlist_keres_proc(\"tallep_elso\",\"\")' class='select2_ajax' csonkolt='1' mod='admin_csopnev' id='admin_szervlist_keres_csopnev' style='width:250px'>";
 echo '<option value="all">Összes';
 echo '</select>';


echo "<td>Inaktív";
echo "<td><select onchange='admin_szervlist_keres_proc(\"tallep_elso\",\"\")' id='admin_szervlist_keres_inaktiv' style='width:150px'>
<option value=all>Minden";
if($ker_inaktiv=="0") $sel=" selected";
else $sel="";
echo "<option value=0".$sel.">Érvényes";
if($ker_inaktiv=="1") $sel=" selected";
else $sel="";
echo "<option value=1".$sel.">Inaktív";
echo "</select>";

echo "</tr>";

echo "</table></div>";
}

function admin_szerv_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_szerv_uj();
$th=0;
/*if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i==0){
 $th=$ert['tal'];
}}}*/
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo "<br><b>Meglévő adatok módosítása</b>";

echo '<div id="scroll1" style="overflow-x:auto;">';
echo '<div></div>';
echo '</div>';
echo '<div id="scroll2" style="overflow-x:auto;">';

echo "<table id='admin_szervlist_table' class='table_emre'>";
echo "<thead><tr>";

//$order_mezo="mira_szerv.szerv_id";
//echo "<th style='width:50px' class='link' onclick='admin_szervlist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
//echo tabl_nyilak('szervlist_keres_order','szervlist_keres_order_mod',$order_mezo);

$order_mezo="mira_szerv.szerv_nev";
echo "<th style='width:200px' class='link' onclick='admin_szervlist_keres_proc(\"order\",\"".$order_mezo."\")'>Szervezet neve ";
echo tabl_nyilak('szervlist_keres_order','szervlist_keres_order_mod',$order_mezo);

$order_mezo="mira_szerv.szerv_koltsegkod";
echo "<th style='width:200px' class='link' onclick='admin_szervlist_keres_proc(\"order\",\"".$order_mezo."\")'>Statisztika költséghely ";
echo tabl_nyilak('szervlist_keres_order','szervlist_keres_order_mod',$order_mezo);

$order_mezo="mira_szerv.szerv_adkod";
echo "<th style='width:110px' class='link' onclick='admin_szervlist_keres_proc(\"order\",\"".$order_mezo."\")'>AD költséghely ";
echo tabl_nyilak('szervlist_keres_order','szervlist_keres_order_mod',$order_mezo);

$order_mezo="mira_szerv.szerv_szolg_kod";
echo "<th style='width:110px' class='link' onclick='admin_szervlist_keres_proc(\"order\",\"".$order_mezo."\")'>Szervezeti<br>&nbsp;&nbsp;&nbsp;&nbsp;szolgáltatás kód ";
echo tabl_nyilak('szervlist_keres_order','szervlist_keres_order_mod',$order_mezo);

$order_mezo="mira_szerv_csoport.mira_szerv_csoport_nev";
echo "<th style='width:110px' class='link' onclick='admin_szervlist_keres_proc(\"order\",\"".$order_mezo."\")'>Szervezet<br>&nbsp;&nbsp;&nbsp;&nbsp;csoportosítási név ";
echo tabl_nyilak('szervlist_keres_order','szervlist_keres_order_mod',$order_mezo);

$order_mezo="mira_szerv.szerv_sm_kod";
echo "<th style='width:110px' class='link' onclick='admin_szervlist_keres_proc(\"order\",\"".$order_mezo."\")'>SM SAP kód ";
echo tabl_nyilak('szervlist_keres_order','szervlist_keres_order_mod',$order_mezo);


echo "<th>Szervezet jóváhagyó";//Jóváhagyók
echo "<th>Hozzárendelt<br>tevékenységek";
echo "<th>Hozzárendelt<br>felhasználók";

echo "<th>Inaktív";

echo "</tr></thead><tbody>";

admin_uj_szerv_list_tal($tomb);

echo '</tbody></table>';
echo '</div>';
elozo_kovetkezo_gombok("admin_szervlist_keres_proc",$th,$GLOBALS['mira']['user_jog']['szervlist_keres_talszam'],$_POST['oldalholvagyok']);

//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['szervlist_keres_talszam'],"admin_szervlist_keres_proc","szervlist_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='admin_szervlist_keres_tal_oldalholvagyok'>";

if(is_array($tomb)){
//foreach($tomb as $i => $ert){
//if($i==0){
 //$th=$ert['tal'];
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['szervlist_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='admin_szervlist_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['szervlist_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_szervlist_keres_proc('tallep_elso','');</script>";
  }
 }
//}}
excel_export("admin_szervlist_keres",$th);
}

}

function admin_uj_szerv_list_tal($tomb){

$tomb_user=keres_user_hozzarend_szam($tomb);
$tomb_projekt=keres_projekt_hozzarend_szam($tomb);
$tomb_jovahagyok=keres_szerv_jovahagyok_hozzarend_szam($tomb);
$tomb_szervkod_nev=keres_szervkod_nev_tomb();

if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){

//echo "<tr t1itle='".$ert['szerv_nev']."'>";
echo "<tr title='".$ert['szerv_nev']."' class='ttooltip'>";


//echo "<td>";
//echo $ert['szerv_id'];

echo "<td>";
if($ert['szerv_inaktiv']==0)
 echo "<input type='text' onkeyup='admin_modszerv_ment(\"".$ert['szerv_id']."\")' id='admin_ujszervmod_nev_".$ert['szerv_id']."' value='".$ert['szerv_nev']."' maxlength='100' style='width:350px'>";
else
 echo $ert['szerv_nev'];

//Költséghely kód
echo "<td>";
if($ert['szerv_inaktiv']==0)
 echo "<input type='text' maxlength='10' onkeyup='admin_modszerv_ment(\"".$ert['szerv_id']."\")' id='admin_ujszervmod_koltsegkod_".$ert['szerv_id']."' value='".$ert['szerv_koltsegkod']."' style='width:190px'>";
else
 echo $ert['szerv_koltsegkod'];
 
//AD szervezet kód
echo "<td>";
if($ert['szerv_inaktiv']==0)
 echo "<input type='text' maxlength='10' onkeyup='admin_modszerv_ment(\"".$ert['szerv_id']."\")' id='admin_ujszervmod_adkod_".$ert['szerv_id']."' value='".$ert['szerv_adkod']."' style='width:110px'>";
else
 echo $ert['szerv_adkod'];

//szerv_szolg_kod - eleje
echo '<td align=center>';
if($ert['szerv_inaktiv']==0){
 //echo "<input type='text' maxlength='4' onkeyup='admin_modszerv_ment(\"".$ert['szerv_id']."\")' id='admin_ujszervmod_szolgkod_".$ert['szerv_id']."' value='".$ert['szerv_szolg_kod']."' style='width:50px'>";

 echo '<select onchange="admin_modszerv_ment(\''.$ert['szerv_id'].'\')" class="select2_ajax" csonkolt="1" mod="admin_szolgkod" id="admin_ujszervmod_szolgkod_'.$ert['szerv_id'].'" style="width:250px">';
 echo '<option value="'.$ert['szerv_szolg_kod'].'">'.$ert['szerv_szolg_kod'];
  if(isset($tomb_szervkod_nev[$ert['szerv_szolg_kod']]))
	  echo ' - '.$tomb_szervkod_nev[$ert['szerv_szolg_kod']];
  
 echo '</select>';
}else{
 //echo $ert['szerv_adkod'];
}
//szerv_szolg_kod - vége

//Szervezet csoportosítási név - eleje
echo '<td align=center>';
if($ert['szerv_inaktiv']==0){
 
 echo '<select onchange="admin_modszerv_ment(\''.$ert['szerv_id'].'\')" class="select2_ajax" csonkolt="1" mod="admin_csopnev" id="admin_ujszervmod_csopnev_'.$ert['szerv_id'].'" style="width:250px">';
  if($ert['szerv_csoport_id']==''){
	  echo '<option value="keremv">Kérem válassz';
  }else{
	  echo '<option value="'.$ert['szerv_csoport_id'].'">'.$ert['mira_szerv_csoport_nev'];
  }
 echo '</select>';
 
}else{
 //echo $ert['mira_szerv_csoport_nev'];
}
//Szervezet csoportosítási név - vége

//SM SAP kód - eleje
echo '<td>';
if($ert['szerv_inaktiv']==0){
 echo "<input type='text' onkeyup='admin_modszerv_ment(\"".$ert['szerv_id']."\")' id='admin_ujszervmod_smkod_".$ert['szerv_id']."' value='".$ert['szerv_sm_kod']."' maxlength='6' style='width:80px'>";
}
//SM SAP kód - vége

//Jóváhagyók
echo "<td align=center>";
if($ert['szerv_inaktiv']==0){
if((isset($tomb_jovahagyok[$ert['szerv_id']]))and($tomb_jovahagyok[$ert['szerv_id']]!=""))
 $jovahagyok_szam=$tomb_jovahagyok[$ert['szerv_id']];
else{
 $jovahagyok_szam="0";	
}
 echo "<span onclick='admin_mod_szerv_jovahagyok_katt(\"".$ert['szerv_id']."\",\"".$ert['szerv_nev']."\")' class='link'>".$jovahagyok_szam."</span>";
}

//Projektek
echo "<td align=center>";
if($ert['szerv_inaktiv']==0){
if((isset($tomb_projekt[$ert['szerv_id']]))and($tomb_projekt[$ert['szerv_id']]!=""))
 $proj_szam=$tomb_projekt[$ert['szerv_id']];
else{
 $proj_szam="0";	
}
 echo "<span onclick='admin_mod_szerv_proj_katt(\"".$ert['szerv_id']."\",\"".$ert['szerv_nev']."\")' class='link'>".$proj_szam."</span>";
}

//Felhasználók
echo "<td align=center>";
$user_szam="0";
if($ert['szerv_inaktiv']==0){
if((isset($tomb_user[$ert['szerv_id']]))and($tomb_user[$ert['szerv_id']]!=""))
 $user_szam=$tomb_user[$ert['szerv_id']];
 echo "<span onclick='admin_mod_szerv_user_katt(\"".$ert['szerv_id']."\",\"".$ert['szerv_nev']."\")' class='link'>".$user_szam."</span>";
}

 //Inaktív
echo "<td align=center>";
if($user_szam>0){
 $postck="disabled title='szervezet nem inaktíválható, mert van aktív tagja'";
}else{
if($ert['szerv_inaktiv']==1) $postck="checked";
 else $postck="";
}
echo "<input ".$postck." onclick='admin_modszerv_inaktiv(\"".$ert['szerv_id']."\")' class='link' type='checkbox' id='admin_ujszervmod_inaktiv_".$ert['szerv_id']."'>";


echo "</tr>";
}
}
}
}

function admin_uj_szerv_proj_katt(){
echo "ok$;$";

echo "<b>Szűrés:</b><br>";
echo "<input onkeyup='admin_ujproj_hozz_keress()' id='proj_hozzid_keress' type=text style='width:250px'>";

echo "<div id='proj_hozzid_tal_div'>";
admin_uj_szerv_proj_katt_list_ki("all");
echo "</div>";

}

function admin_ujproj_hozz_keress(){
echo "ok$;$";
$tomb_pro_lat=keres_proj_akt_nevlike($_POST['projekt_nev']);
admin_uj_szerv_proj_katt_list_ki($tomb_pro_lat);
}

function admin_uj_szerv_proj_katt_list_ki($tomb_pro_lat){
//$tomb_proj=keres_mit2_order("projekt","projekt_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"projekt_inaktiv","0","projekt_nev","asc");
$tomb_proj=keres_mit1_order("projekt","projekt_inaktiv","0","projekt_nev","asc");

if((isset($_POST['projekt_id']))and($_POST['projekt_id']!="")){
$tomb_projekt=explode(",",$_POST['projekt_id']);
$tomb_projekt_van=array();
foreach($tomb_projekt as $i => $projekt_id){
 $tomb_projekt_van[$projekt_id]=1;
}
}

if(is_array($tomb_proj)){
echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
//echo '<th>ID';
echo '<th>Tevékenység neve';
echo '<th>Hozzárendelés';

if(
(isset($tomb_projekt_van))and
((sizeof($tomb_proj))==(sizeof($tomb_projekt_van)))
)
 $allprojvan=" checked";
else $allprojvan="";
echo "<input".$allprojvan." onchange='admin_ujproj_hozzall_change()' id='proj_hozzidall' class='link' type='checkbox'>";

//echo '<th>Projekt típus';
echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_proj as $i => $ert){

if(isset($tomb_projekt_van[$ert['projekt_id']])){
 $ck=" checked";
}else{
 $ck="";
}

if(
((is_array($tomb_pro_lat))and(isset($tomb_pro_lat[$ert['projekt_id']])))
or
(
((!is_array($tomb_pro_lat))and($tomb_pro_lat=="all"))
)
){
 $css="";
}else{
 $css=" style='display:none'";
}
echo "<tr".$css.">";
//echo "<td>".$ert['projekt_id'];
echo "<td><label style='cursor:pointer' for='proj_hozzid_".$ert['projekt_id']."'>";
echo $ert['projekt_nev'];

echo "<td align=center>";
echo "<input".$ck.$css." class='link' onchange='admin_ujproj_hozz_change()' projekt_id='".$ert['projekt_id']."' projekt_nev='".$ert['projekt_nev']."' name='proj_hozz' id='proj_hozzid_".$ert['projekt_id']."' type='checkbox'>";
echo "</label>";

/*echo "<td>";
echo projekt_tipus_ki($ert['projekt_tipus']);*/

echo "</tr>";

}
echo "</tbody></table>";
}
}

function admin_uj_szerv_jovahagyo_katt(){
echo "ok$;$";

echo "<b>Szűrés:</b><br>";
echo "<input onkeyup='admin_ujproj_jovahagyo_keress()' id='proj_jovahagyoid_keress' type=text style='width:250px'>";

echo "<div id='proj_jovahagyoid_tal_div'>";
$tomb_jovahagyo_lat=keres_user_ujtevekenyseghez("");
admin_uj_szerv_jovahagyo_katt_list_ki($tomb_jovahagyo_lat);
echo "</div>";
}

function admin_ujproj_jovahagyo_keress(){
echo "ok$;$";
//$tomb_jovahagyo_lat=keres_user_akt_nevlike($_POST['user_nev']);
$tomb_jovahagyo_lat=keres_user_ujtevekenyseghez($_POST['user_nev']);
admin_uj_szerv_jovahagyo_katt_list_ki($tomb_jovahagyo_lat);
}

function admin_uj_szerv_jovahagyo_katt_list_ki($tomb_jovahagyo){
//$tomb_jovahagyo=keres_mit2_order("mira_user","user_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"user_inaktiv","0","user_nev","asc");

if((isset($_POST['user_ad']))and($_POST['user_ad']!="")){
$tomb_jovahagyo_2=explode(",",$_POST['user_ad']);
$tomb_jovahagyo_van=array();
foreach($tomb_jovahagyo_2 as $i => $user_ad){
 $tomb_jovahagyo_van[$user_ad]=1;
}
}

if(is_array($tomb_jovahagyo)){
echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
echo '<th>AD';
echo '<th>Név';
echo '<th>';
echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_jovahagyo as $i => $ert){

if($i==0){
	$th=$ert['tal'];
}else{

if(isset($tomb_jovahagyo_van[$ert['user_ad']])){
 $ck=" checked";
}else{
 $ck="";
}

echo "<tr>";
echo "<td>".$ert['user_ad'];
echo "<td><label style='cursor:pointer' for='projujjovahagyo_hozzid_".$ert['user_ad']."'>";
echo $ert['user_nev'];

echo "<td>";
echo "<input".$ck." class='link' onchange='admin_ujprojujjovahagyo_hozz_change()' user_ad='".$ert['user_ad']."' user_nev='".$ert['user_nev']."' name='projujjovahagyo_hozz' id='projujjovahagyo_hozzid_".$ert['user_ad']."' type='checkbox'>";
echo "</label>";

echo "</tr>";

}
}
echo "</tbody></table>";

elozo_kovetkezo_gombok("admin_ujproj_jovahagyo_keress_proc",$th,$GLOBALS['mira']['user_jog']['user_ujtevekuserhozza_keres_talszam'],$_POST['oldalholvagyok']);
echo "<div style='margin-top:5px'>";
//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['user_ujtevekuserhozza_keres_talszam'],"admin_ujproj_jovahagyo_keress_proc","user_ujtevekuserhozza_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='user_ujtevekuserhozza_keres_tal_oldalholvagyok'>";

if(is_array($tomb_jovahagyo)){
foreach($tomb_jovahagyo as $i => $ert){
if($i==0){
 $th=$ert['tal'];
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['user_ujtevekuserhozza_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='user_ujtevekuserhozza_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['user_ujtevekuserhozza_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_ujproj_jovahagyo_keress_proc('tallep_elso','');</script>";
  }
 }
}}
//excel_export("szerv_jovahagyo",$th);
}

}
}

function admin_ujszerv_ment(){
//1.1 NÉV:
if((!isset($_POST['nev']))or(
(isset($_POST['nev'])and($_POST['nev']==""))
)){
 echo "nook$;$"."NÉV megadása kötelező!";
 exit;
}
//1.2 NÉV:
if((!isset($_POST['projekt_id']))or(
(isset($_POST['projekt_id'])and($_POST['projekt_id']==""))
)){
 echo "nook$;$"."projekt megadása kötelező!";
 exit;
}
//1.3 NÉV:
if((!isset($_POST['jovahagyo_id']))or(
(isset($_POST['jovahagyo_id'])and($_POST['jovahagyo_id']==""))
)){
 echo "nook$;$"."Jóváhagyó megadása kötelező!";
 exit;
}

//1.3 szolgkod:
if((!isset($_POST['szolgkod']))or(
(isset($_POST['szolgkod'])and($_POST['szolgkod']=="keremv"))
)){
 echo "nook$;$"."Szervezeti szolgáltatás kód kiválasztása kötelező!";
 exit;
}

//1.3 csoport_id:
if((!isset($_POST['csoport_id']))or(
(isset($_POST['csoport_id'])and($_POST['csoport_id']=="keremv"))
)){
 echo "nook$;$"."Szervezet csoportosítási név kiválasztása kötelező!";
 exit;
}

//1.3 smkod:
if((!isset($_POST['smkod']))or(
(isset($_POST['smkod'])and($_POST['smkod']==""))
)){
 echo "nook$;$"."SM SAP kód megadása kötelező!";
 exit;
}

//2: Van-e Ilyen user
//$usvane=keres_mit2_mit1("mira_szerv","szerv_nev",$_POST['nev'],"szerv_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"szerv_id");
$usvane=keres_mit1_mit1("mira_szerv","szerv_nev",$_POST['nev'],"szerv_id");
if(is_array($usvane)){
	echo "Hiba! Van már ilyen szervezet!";
	exit;
}else{

mysqli_autocommit($GLOBALS['mysqli'],false);

//2. szerv tábla mentése
$tmp_bk=array();
$tmp_bk[0]['szerv_nev']=$_POST['nev'];
$tmp_bk[0]['szerv_koltsegkod']=$_POST['koltsegkod'];
if(isset($_POST['adkod']))
 $tmp_bk[0]['szerv_adkod']=$_POST['adkod'];
$tmp_bk[0]['szerv_szolg_kod']=$_POST['szolgkod'];
$tmp_bk[0]['szerv_csoport_id']=$_POST['csoport_id'];
$tmp_bk[0]['szerv_sm_kod']=$_POST['smkod'];
$tmp_bk[0]['szerv_tagv']=$GLOBALS[$GLOBALS['sessionname']]['tagv'];
be_visz_insert("mira_szerv",$tmp_bk);
$szerv_id = mysqli_insert_id($GLOBALS['mysqli']);
//2. Projekt-user tábla mentése

$tomb_proj=explode(",",$_POST['projekt_id']);

foreach($tomb_proj as $projekt_id){
 $tmp_bk_p_sz=array();
 $tmp_bk_p_sz[0]['projekt_id']=$projekt_id;
 $tmp_bk_p_sz[0]['szerv_id']=$szerv_id;
 be_visz_insert("projekt_szerv",$tmp_bk_p_sz);
}

//Jóváhagyók lementése - eleje
$tomb_jovahagyok=explode(",",$_POST['jovahagyo_id']);

foreach($tomb_jovahagyok as $jovahagyo_id){
 $tmp_bk_j_sz=array();
 $tmp_bk_j_sz[0]['user_ad']=$jovahagyo_id;
 $tmp_bk_j_sz[0]['szerv_id']=$szerv_id;
 be_visz_insert("mira_szerv_jovahagyo",$tmp_bk_j_sz);
}
//Jóváhagyók lementése - vége

mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);

echo "ok$;$";

}

}

function admin_mod_szerv_jovahagyok_katt(){
echo "ok$;$";

echo "Jóváhagyók hozzárendelése <b>";
echo $_POST['szerv_nev'];
echo "</b> szervezethez<br><br>";

echo "<b>Szűrés:</b><br>";
echo "<input autocomplete='off' szerv_id='".$_POST['szerv_id']."' onkeyup='admin_modszervjovahagyo_hozz_keress(\"\",\"\")' id='szervjovahagyo_hozzid_keress' type=text style='width:250px'>";

echo "<br>Csak hozzárendelt felhasználók: ";
echo "<input onchange='admin_modszervjovahagyo_hozz_keress_proc(\"\",\"\")' id='szervjovahagyo_hozzid_csakhozz_szur' type='checkbox'>";

echo "<div id='szervjovahagyo_hozzid_tal_div'>";
 
 $tomb_jovahagyo=keres_szervjovahagyo_user($_POST['szerv_id'],"","0");
 //$tomb_jovahagyo=keres_mit2_order("mira_user","user_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"user_inaktiv","0","user_nev","asc");
 $tomb_jovahagyo_van=keres_szervjovahagyo_hozzarend_adat($_POST['szerv_id']);
 //admin_mod_szerv_jovahagyo_katt_list_ki($tomb_jovahagyo,$tomb_jovahagyo_van,"all");
 admin_mod_szerv_jovahagyo_katt_list_ki($tomb_jovahagyo,$tomb_jovahagyo_van);
echo "</div>";
}

function admin_modszervjovahagyo_hozz_keress(){
echo "ok$;$";
//$tomb_jovahagyo=keres_mit2_order("mira_user","user_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"user_inaktiv","0","user_nev","asc");
$tomb_jovahagyo=keres_szervjovahagyo_user($_POST['szerv_id'],$_POST['keress_nev'],$_POST['csakvan']);
$tomb_jovahagyo_van=keres_szervjovahagyo_hozzarend_adat($_POST['szerv_id']);
//$tomb_jovahagyo_lat=keres_user_akt_nevlike($_POST['user_nev']);
admin_mod_szerv_jovahagyo_katt_list_ki($tomb_jovahagyo,$tomb_jovahagyo_van);
}

//function admin_mod_szerv_jovahagyo_katt_list_ki($tomb_jovahagyo,$tomb_jovahagyo_van,$tomb_jovahagyo_lat){
function admin_mod_szerv_jovahagyo_katt_list_ki($tomb_jovahagyo,$tomb_jovahagyo_van){

if(is_array($tomb_jovahagyo)){
echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
echo '<th>AD';
echo '<th>Név';
echo '<th>Hozzárendelés';
echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_jovahagyo as $i => $ert){

if($i==0){
	$th=$ert['tal'];
}else{

if(isset($tomb_jovahagyo_van[$ert['user_ad']])){
 $ck=" checked";
}else{
 $ck="";
}

echo "<tr>";
echo "<td>".$ert['user_ad'];
echo "<td><label style='cursor:pointer' for='szervjovahagyo_hozzid_".$ert['user_ad']."'>";
echo $ert['user_nev'];

echo "<td align=center>";
echo "<input".$ck." class='link' onchange='admin_modszervjovahagyo_hozz_change(\"".$ert['user_ad']."\",\"".$_POST['szerv_id']."\")' name='szervjovahagyo_hozz' id='szervjovahagyo_hozzid_".$ert['user_ad']."' type='checkbox'>";
echo "</label>";

echo "</tr>";

}
}
echo "</tbody></table>";

elozo_kovetkezo_gombok("admin_modszervjovahagyo_hozz_keress_proc",$th,$GLOBALS['mira']['user_jog']['user_szervjovahagyo_keres_talszam'],$_POST['oldalholvagyok']);
echo "<div style='margin-top:5px'>";
//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['user_szervjovahagyo_keres_talszam'],"admin_modszervjovahagyo_hozz_keress_proc","user_szervjovahagyo_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='user_szervjovahagyo_keres_tal_oldalholvagyok'>";

if(is_array($tomb_jovahagyo)){
foreach($tomb_jovahagyo as $i => $ert){
if($i==0){
 $th=$ert['tal'];
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['user_szervjovahagyo_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='user_szervjovahagyo_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['user_szervjovahagyo_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_modszervjovahagyo_hozz_keress_proc('tallep_elso','');</script>";
  }
 }
}}
excel_export("szerv_jovahagyo",$th);
}
echo "</div>";

}
}

function admin_modszervjovahagyo_hozz_change(){
if(
(isset($_POST['user_ad']))and
(isset($_POST['szerv_id']))and
(isset($_POST['mit']))and
($_POST['user_ad']!="")and
($_POST['szerv_id']!="")and
($_POST['mit']!="")
){
 if($_POST['mit']==1){//Bevitel
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['szerv_id']=$_POST['szerv_id'];
  be_visz_replace("mira_szerv_jovahagyo",$tmp_bk_ker_def);
 }else{//Ekkor ki kell
 
 $tomb_utolso_e=keres_user_utolso_szerv_jovhagyo_e_egyszervnel($_POST['szerv_id']);
 if(is_array($tomb_utolso_e)){
	echo "okutolso$;$"; 
	echo "<b>Hiba!<br><br>Jogosulság nem törölhető, mert ".$tomb_utolso_e[0]['szerv_nev'];
	echo " szervezetnél ".$tomb_utolso_e[0]['user_nev']." az egyetlen jóváhagyó!</b>";
	exit;
 }
 
  torles2("mira_szerv_jovahagyo",'user_ad',$_POST['user_ad'],'szerv_id',$_POST['szerv_id']);
 }
 echo "ok$;$";
}
}

function admin_mod_szerv_proj_katt(){
echo "ok$;$";

echo "Tevékenység hozzárendelése <b>";
echo $_POST['szerv_nev'];
echo "</b> szervezethez<br><br>";

echo "<b>Szűrés:</b><br>";
echo "<input onkeyup='admin_modproj_hozz_keress(\"".$_POST['szerv_id']."\")' szerv_id='".$_POST['szerv_id']."' id='proj_hozzid_keress' type=text style='width:250px'>";

echo "<br>Csak hozzárendelt tevékenységek: ";
echo "<input onchange='admin_modproj_hozz_keress()' id='proj_hozzid_csakhozz_szur' type='checkbox'>";

echo "<div id='proj_hozzid_tal_div'>";
 //$tomb_proj=keres_mit2_order("projekt","projekt_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"projekt_inaktiv","0","projekt_nev","asc");
 $tomb_proj=keres_mit1_order("projekt","projekt_inaktiv","0","projekt_nev","asc");
 $tomb_projekt_van=keres_projekt_hozzarend_adat($_POST['szerv_id']);
 admin_mod_szerv_proj_katt_list_ki($tomb_proj,$tomb_projekt_van,"all");
echo "</div>";
}

function admin_modproj_hozz_keress(){
echo "ok$;$";
//$tomb_proj=keres_mit2_order("projekt","projekt_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"projekt_inaktiv","0","projekt_nev","asc");
$tomb_proj=keres_mit1_order("projekt","projekt_inaktiv","0","projekt_nev","asc");
$tomb_projekt_van=keres_projekt_hozzarend_adat($_POST['szerv_id']);
$tomb_pro_lat=keres_proj_akt_nevlike($_POST['projekt_nev']);
admin_mod_szerv_proj_katt_list_ki($tomb_proj,$tomb_projekt_van,$tomb_pro_lat);
}

function admin_mod_szerv_proj_katt_list_ki($tomb_proj,$tomb_projekt_van,$tomb_pro_lat){

if(is_array($tomb_proj)){
echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
//echo '<th>ID';
echo '<th>Tevékenység név';
echo '<th>Hozzárendelés';

if((is_array($tomb_projekt_van))and(sizeof($tomb_proj)==sizeof($tomb_projekt_van)))
 $allchecked=" checked";
else $allchecked="";
echo "<input".$allchecked." type=checkbox onchange='admin_modproj_hozzall_change(\"".$_POST['szerv_id']."\")' id='proj_allhozzid' class='link' title='Összes kijelölése vagy megszüntetése'>";

//echo '<th>Tevékenység típus';
echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_proj as $i => $ert){

if(isset($tomb_projekt_van[$ert['projekt_id']])){
 $ck=" checked";
}else{
 $ck="";
}

if(
(
((is_array($tomb_pro_lat))and(isset($tomb_pro_lat[$ert['projekt_id']])))
or
(
((!is_array($tomb_pro_lat))and($tomb_pro_lat=="all"))
)
)

and
(

($_POST['csakvan']=="0")
or
(
($_POST['csakvan']=="1")and($ck!="")
)

)

){
 $css="";
}else{
 $css=" style='display:none'";
}

echo "<tr".$css.">";
//echo "<td>".$ert['projekt_id'];
echo "<td><label style='cursor:pointer' for='proj_hozzid_".$ert['projekt_id']."'>";
echo $ert['projekt_nev'];
echo "</label>";

echo "<td align=center>";
echo "<input".$ck.$css." class='link' onchange='admin_modproj_hozz_change(\"".$ert['projekt_id']."\",\"".$_POST['szerv_id']."\")' name='proj_hozz' id='proj_hozzid_".$ert['projekt_id']."' type='checkbox'>";


/*echo "<td>";
echo projekt_tipus_ki($ert['projekt_tipus']);*/

echo "</tr>";

}
echo "</tbody></table>";
echo "<div style='margin-top:5px'>";
excel_export("admin_szervezethez_projekt_rend",1);
echo "</div>";
}
}

function admin_mod_szerv_user_katt(){
echo "ok$;$";

echo "Felhasználók <b>";
echo $_POST['szerv_nev'];
echo "</b> szervezetben<br>";

echo "<div id='user_hozzid_tal_div'>";
 $tomb_user_van=keres_user_hozzarend_adat($_POST['szerv_id']);
 admin_mod_szerv_user_katt_list_ki($tomb_user_van);
echo "</div>";
}

function admin_mod_szerv_user_katt_list_ki($tomb_user_van){

if(is_array($tomb_user_van)){
echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
echo '<th>AD';
echo '<th>Törzsszám';
echo '<th>Név';
echo '<th>Email cím';
echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_user_van as $i => $ert){

echo "<tr>";
echo "<td>";
echo $ert['user_ad'];

echo "<td>";
echo $ert['user_tsz'];

echo "<td>";
echo $ert['user_nev'];

echo "<td>";
echo $ert['user_email'];

echo "</tr>";
}
echo "</tbody></table>";
echo "<div style='margin-top:5px'>";
echo "<input type='hidden' value='".$_POST['szerv_id']."' id='szervezetben_user_szerv_id'>";
excel_export("admin_szervezetben_user",1);
echo "</div>";
}




}

function admin_modproj_hozz_change(){
if(
(isset($_POST['projekt_id']))and
(isset($_POST['szerv_id']))and
(isset($_POST['mit']))and
($_POST['projekt_id']!="")and
($_POST['szerv_id']!="")and
($_POST['mit']!="")
){
 if($_POST['mit']==1){//Bevitel
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['projekt_id']=$_POST['projekt_id'];
  $tmp_bk_ker_def[0]['szerv_id']=$_POST['szerv_id'];
  be_visz_replace("projekt_szerv",$tmp_bk_ker_def);
 }else{//Ekkor ki kell
  torles2("projekt_szerv",'projekt_id',$_POST['projekt_id'],'szerv_id',$_POST['szerv_id']);
 }
 echo "ok$;$";
}
}

function admin_modszerv_ment(){
if(
(isset($_POST['szerv_nev']))and
(isset($_POST['koltsegkod']))and
(isset($_POST['adkod']))and
(isset($_POST['szolgkod']))and
(isset($_POST['csopid']))and
(isset($_POST['smkod']))and
(isset($_POST['szerv_id']))and
($_POST['szerv_nev']!="")and
($_POST['szerv_id']!="")
){
$tmp_mod=array();
$tmp_mod[0]['szerv_nev']=$_POST['szerv_nev'];
$tmp_mod[0]['szerv_koltsegkod']=$_POST['koltsegkod'];
$tmp_mod[0]['szerv_adkod']=$_POST['adkod'];
if(($_POST['szolgkod']!='')and($_POST['szolgkod']!='keremv'))
 $tmp_mod[0]['szerv_szolg_kod']=$_POST['szolgkod'];
if(($_POST['csopid']!='')and($_POST['csopid']!='keremv'))
 $tmp_mod[0]['szerv_csoport_id']=$_POST['csopid'];

if($_POST['smkod']!='')
 $tmp_mod[0]['szerv_sm_kod']=$_POST['smkod'];
mod_egy_fel_tom('mira_szerv',$tmp_mod[0],'szerv_id',$_POST['szerv_id']);
echo "ok$;$";
}
}



function admin_modszerv_inaktiv(){
if(
(isset($_POST['inaktiv']))and
(isset($_POST['szerv_id']))and
($_POST['inaktiv']!="")and
($_POST['szerv_id']!="")
){


$tmp_mod=array();
if($_POST['inaktiv']==1)
 $tmp_mod[0]['szerv_inaktiv']=1;
else
 $tmp_mod[0]['szerv_inaktiv']=0;

if($tmp_mod[0]['szerv_inaktiv']==1){
 //Nézzük meg, hogy van-e hozzá aktív user rendelve!	
 $tombvane_user=keres_mit2("mira_user","user_inaktiv","0","szerv_id",$_POST['szerv_id']);
if(is_array($tombvane_user)){
 echo "nook_vantagja$;$";
 echo "Szervezet nem inaktíválható, mert van aktív tagja!";
 exit;
}
}

mod_egy_fel_tom('mira_szerv',$tmp_mod[0],'szerv_id',$_POST['szerv_id']);
echo "ok$;$";
}
}

?>