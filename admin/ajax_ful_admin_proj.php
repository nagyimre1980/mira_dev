<?php

function admin_proj_mod(){
echo "ok$;$";
unset($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['kat_id']);
admin_proj_mod_urlap();
admin_proj_mod_kereses();
echo "<div id='admin_uj_proj_list_keres_tal' style='overflow-x:auto'>";
admin_proj_user_list();
echo "</div>";

}

function admin_proj_mod_urlap(){
echo "<div style='overflow-x:auto'><b>Új tevékenység:</b>";

echo "<table class='table_emre'>";

echo "<tr>";
echo "<td>Tevékenység neve *";
echo "<td>";
echo "<input id='admin_ujprojekt_nev' type=text style='width:400px' maxlength=100>";
echo "</tr>";

echo '<tr>';
echo '<td>Rögzítés kezdete *';
echo '<td>';
echo '<input id="admin_ujprojekt_kezddate" onkeydown="return admin_ujmodproj_date_delete(this.id)" class="date_tol2" data-maxdate="" date_ig_mezo="admin_ujprojekt_vegdate" style="width:75px" type="text">';

echo ' Rögzítés vége ';
echo '<input id="admin_ujprojekt_vegdate" onkeydown="return admin_ujmodproj_date_delete(this.id)" class="date_ig2"  data-mindate="" date_tol_mezo="admin_ujprojekt_kezddate" style="width:75px" type="text">';
echo "</tr>";

echo '<tr>';
echo '<td>Társasági SAP kód *';
echo '<td>';
//echo '<input id="admin_ujprojekt_tagvkod" type=text style="width:80px" maxlength="4">';
 echo '<select id="admin_ujprojekt_tagvkod" class="select2_ajax" csonkolt=1 mod="admin_tagvkod_uj" style="width:411px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<td title="Tevékenységek szolgáltatás kód">Tev. szolgáltatás kód *';//Tevékenységek szolgáltatás kód
echo '<td>';
//echo '<input id="admin_ujprojekt_szolgkod" type=text style="width:80px" maxlength="4">';
 echo '<select id="admin_ujprojekt_szolgkod" class="select2_ajax" csonkolt=1 mod="admin_szolgkod_uj" style="width:411px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<td>Önköltség kategória *';
echo '<td>';
 echo '<select id="admin_ujprojekt_kat_id" class="select2_ajax" csonkolt=1 mod="admin_kat_uj" style="width:411px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';
echo '</tr>';

echo "<tr>";
echo "<td>CO objektum";
echo "<td>";
echo "<input id='admin_ujprojekt_co' type=text style='width:120px' maxlength=12>";
echo "</tr>";

echo "<tr>";
echo "<td>Leírás";
echo "<td>";
echo "<textarea id='admin_uj_projekt_title' style='width:400px' rows='2'>";
echo "</textarea>";
echo "</tr>";

echo "<tr>";
echo "<td>Szervezetek";
echo "<td>";
echo "<span onclick='admin_uj_projekt_szerv_katt()' id='admin_uj_projekt_szerv_span' class='link'>Szervezet hozzáadása</span>";
echo "<input type='hidden' value='' id='admin_uj_projekt_szerv_id'>";
echo "</tr>";

echo "<tr>";
echo "<td>Felhasználók";
echo "<td>";
echo "<span onclick='admin_uj_projekt_user_katt()' id='admin_uj_projekt_user_span' class='link'>Felhasználók hozzáadása</span>";
echo "<input type='hidden' value='' id='admin_uj_projekt_user_id'>";
echo "</tr>";

/*
echo "<tr>";
echo "<td>Tevékenység típus";
echo "<td colspan=3>";
echo "<select id='admin_ujprojekt_tipus'>";
echo "<option value='keremv'>Kérem válassz";
echo "<option value='0'>".projekt_tipus_ki(0);
echo "<option value='1'>".projekt_tipus_ki(1);
echo "</select>";
echo "</tr>";*/

echo "<tr><td colspan=2 align=left><input id='admin_ujprojekt_submit' onclick='admin_ujprojekt()' type=submit value='Új tevékenység felvitele' class='submit2'></tr>";

echo "</table></div>";
}

function admin_projektlist_keres(){
if(isset($_POST['id']))$_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['id']=$_POST['id'];
if(isset($_POST['nev']))$_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['nev']=$_POST['nev'];
//if(isset($_POST['kat_id']))$_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['kat_id']=$_POST['kat_id'];
if(isset($_POST['inaktiv']))$_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['inaktiv']=$_POST['inaktiv'];
if(isset($_POST['tipus']))$_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['tipus']=$_POST['tipus'];
echo "ok$;$";
admin_proj_user_list();
}

function admin_proj_mod_kereses(){
echo '<div style="overflow-x:auto">';
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['id']))and($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['id']!=""))
 $ker_id=$_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['id'];
else $ker_id="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['nev']!=""))
 $ker_nev=$_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['nev'];
else $ker_nev="";

/*if((isset($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['kat_id']))and($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['kat_id']!=""))
 $kat_id=$_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['kat_id'];
else $kat_id="";*/

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['inaktiv']!=""))
 $ker_inaktiv=$_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['inaktiv'];
else $ker_inaktiv="";

echo "<br><b>Keresés</b> (keresés automatikusan *valami*-al történik)";

echo "<table id='admin_projektlist_keres_table' class='table_emre'>";

echo "<tr>";
echo "<td>ID";
echo "<td><input style='width:50px' onkeyup='admin_projektlist_keres(\"\",\"\")' id='admin_projektlist_keres_id' value='".$ker_id."' maxlength=5 type=text>";

echo "<td>Tevékenység neve";
echo "<td><input style='width:250px' onkeyup='admin_projektlist_keres(\"\",\"\")' id='admin_projektlist_keres_nev' value='".$ker_nev."' type=text>";

echo "<td>Önköltség kategória";
echo '<td>';
 echo "<select onchange='admin_projektlist_keres_proc(\"tallep_elso\",\"\")' class='select2_ajax' csonkolt='1' mod='admin_kat' id='admin_projektlist_keres_kat' style='width:250px'>";
 echo '<option value="all">Összes';
 echo '</select>';

echo "<td>Inaktív";
echo "<td><select onchange='admin_projektlist_keres_proc(\"tallep_elso\",\"\")' id='admin_projektlist_keres_inaktiv' class='select3' style='width:90px'>
<option value=all>Minden";

if($ker_inaktiv=="0") $sel=" selected";
else $sel="";
echo "<option value=0".$sel.">Érvényes";

if($ker_inaktiv=="1") $sel=" selected";
else $sel="";
echo "<option value=1".$sel.">Inaktív";

echo "</select>";

echo "</tr>";

/*echo "<tr>";
echo "<td>Tevékenység típus";
echo "<td colspan=3>";
echo "<select onchange='admin_projektlist_keres(\"\",\"\")' id='admin_projektlist_keres_tipus'>";
echo "<option value=all>Minden";
echo "<option value='0'>".projekt_tipus_ki(0);
echo "<option value='1'>".projekt_tipus_ki(1);
echo "</select>";
echo "</tr>";*/

echo "</table></div>";
}

function admin_proj_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_projekt_uj();
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

echo "<table id='admin_projektlist_table' class='table_emre'>";
echo "<thead><tr>";

$order_mezo="projekt.projekt_id";
echo "<th style='width:50px' class='link' onclick='admin_projektlist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
echo tabl_nyilak('projektlist_keres_order','projektlist_keres_order_mod',$order_mezo);

$order_mezo="projekt.projekt_nev";
echo "<th style='width:200px' class='link' onclick='admin_projektlist_keres_proc(\"order\",\"".$order_mezo."\")'>Tevékenység neve ";
echo tabl_nyilak('projektlist_keres_order','projektlist_keres_order_mod',$order_mezo);

$order_mezo="projekt.projekt_kezd_date";
echo "<th style='width:100px' class='link' onclick='admin_projektlist_keres_proc(\"order\",\"".$order_mezo."\")'>Rögzítés kezdete ";
echo tabl_nyilak('projektlist_keres_order','projektlist_keres_order_mod',$order_mezo);

$order_mezo="projekt.projekt_veg_date";
echo "<th style='width:100px' class='link' onclick='admin_projektlist_keres_proc(\"order\",\"".$order_mezo."\")'>Rögzítés vége ";
echo tabl_nyilak('projektlist_keres_order','projektlist_keres_order_mod',$order_mezo);


/*
$order_mezo="projekt.projekt_tipus";
echo "<th style='width:100px' class='link' onclick='admin_projektlist_keres_proc(\"order\",\"".$order_mezo."\")'>Tevékenység típus ";
echo tabl_nyilak('projektlist_keres_order','projektlist_keres_order_mod',$order_mezo);
*/

$order_mezo="projekt.projekt_tagv_kod";
echo "<th style='width:100px' class='link' onclick='admin_projektlist_keres_proc(\"order\",\"".$order_mezo."\")'>Társasági SAP kód ";
echo tabl_nyilak('projektlist_keres_order','projektlist_keres_order_mod',$order_mezo);

$order_mezo="projekt.projekt_szolg_kod";
echo "<th style='width:200px' class='link' onclick='admin_projektlist_keres_proc(\"order\",\"".$order_mezo."\")'>Tevékenységek szolgáltatás kód ";
echo tabl_nyilak('projektlist_keres_order','projektlist_keres_order_mod',$order_mezo);

$order_mezo="projekt_kat.projekt_kat_nev";
echo "<th style='width:100px' class='link' onclick='admin_projektlist_keres_proc(\"order\",\"".$order_mezo."\")'>Önköltség kategória ";
echo tabl_nyilak('projektlist_keres_order','projektlist_keres_order_mod',$order_mezo);

$order_mezo="projekt.projekt_co";
echo "<th style='width:100px' class='link' onclick='admin_projektlist_keres_proc(\"order\",\"".$order_mezo."\")'>CO objektum ";
echo tabl_nyilak('projektlist_keres_order','projektlist_keres_order_mod',$order_mezo);


echo "<th>Leírás";

echo "<th>Szervezetek";
echo "<th>Felhasználók";
echo "<th>Projekt jóváhagyó";
//echo "<th>Havonta rögzíthető max óra";
echo "<th>Havi max rögzíthető";

echo "<th>Inaktív";

echo "</tr></thead><tbody>";

admin_uj_projekt_list_tal($tomb);

echo '</tbody></table>';
echo '</div>';
elozo_kovetkezo_gombok("admin_projektlist_keres_proc",$th,$GLOBALS['mira']['user_jog']['projektlist_keres_talszam'],$_POST['oldalholvagyok']);

//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['projektlist_keres_talszam'],"admin_projektlist_keres_proc","projektlist_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='admin_projektlist_keres_tal_oldalholvagyok'>";

if(is_array($tomb)){
//foreach($tomb as $i => $ert){
//if($i==0){
 //$th=$ert['tal'];
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['projektlist_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='admin_projektlist_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['projektlist_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_projektlist_keres_proc('tallep_elso','');</script>";
  }
 }
//}}
excel_export("admin_projektlist_keres",$th);
}

}

function admin_uj_projekt_list_tal($tomb){

$tomb_szervszam=keres_projekt_hozzarend_szervszam($tomb);
$tomb_userszam=keres_projekt_hozzarend_userszam($tomb);
$tomb_projektjovahagyoszam=keres_projekt_jovahagyo_hozzarend_userszam($tomb);
$tomb_projekt_ido=keres_projekt_ido_vane($tomb);

$tomb_tagvkod_nev=keres_tagvkod_nev_tomb();
$tomb_szervkod_nev=keres_szervkod_nev_tomb();

if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){

echo "<tr title='".$ert['projekt_nev']."' class='ttooltip'>";

echo "<td>";
echo $ert['projekt_id'];

echo "<td>";
if($ert['projekt_inaktiv']==0)
 echo "<input type='text' style='width:400px' maxlength='100' onkeyup='admin_modprojekt_ment(\"".$ert['projekt_id']."\")' id='admin_ujprojktmod_nev_".$ert['projekt_id']."' value='".$ert['projekt_nev']."'>";
else
 echo $ert['projekt_nev'];

//Rögzítés kezdete - eleje
echo "<td align=center>";
if($ert['projekt_inaktiv']==0)
 echo "<input class='date_tol2' data-maxdate='".kidate_format_ev($ert['projekt_veg_date'])."' date_ig_mezo='admin_ujprojktmod_vegdate_".$ert['projekt_id']."' type='text' style='width:75px' maxlength='10' onchange='admin_modprojekt_ment(\"".$ert['projekt_id']."\")' onkeydown='return admin_ujmodproj_date_delete(this.id)' id='admin_ujprojktmod_kezddate_".$ert['projekt_id']."' value='".kidate_format_ev($ert['projekt_kezd_date'])."'>";
else
 echo kidate_format_ev($ert['projekt_kezd_date']);
//Rögzítés kezdete - vége

//Rögzítés vége - eleje
echo "<td align=center>";
if($ert['projekt_inaktiv']==0)
 echo "<input class='date_ig2' data-mindate='".kidate_format_ev($ert['projekt_kezd_date'])."' date_tol_mezo='admin_ujprojktmod_kezddate_".$ert['projekt_id']."' type='text' style='width:75px' maxlength='10' onchange='admin_modprojekt_ment(\"".$ert['projekt_id']."\")' onkeydown='return admin_ujmodproj_date_delete(this.id)' id='admin_ujprojktmod_vegdate_".$ert['projekt_id']."' value='".kidate_format_ev($ert['projekt_veg_date'])."'>";
else
 echo kidate_format_ev($ert['projekt_veg_date']);
//Rögzítés vége - vége

/*
echo "<td>";
echo "<select onchange='admin_modprojekt_ment(\"".$ert['projekt_id']."\")' id='admin_ujprojktmod_tipus_".$ert['projekt_id']."'>";

echo "<option value='0'";
if($ert['projekt_tipus']==0) echo " selected";
echo ">".projekt_tipus_ki(0);

echo "<option value='1'";
if($ert['projekt_tipus']==1) echo " selected";
echo ">".projekt_tipus_ki(1);
echo "</select>";
*/

//Társasági SAP kód - eleje
echo '<td align=center>';
if($ert['projekt_inaktiv']==0){
 //echo "<input type='text' style='width:80px' maxlength='4' onkeyup='admin_modprojekt_ment(\"".$ert['projekt_id']."\")' id='admin_ujprojktmod_tagvkod_".$ert['projekt_id']."' value='".$ert['projekt_tagv_kod']."'>";
 echo '<select onchange="admin_modprojekt_ment_proc(\''.$ert['projekt_id'].'\')" class="select2_ajax" csonkolt="1" mod="admin_tagvkod" id="admin_ujprojktmod_tagvkod_'.$ert['projekt_id'].'" style="width:200px">';
 echo '<option value="'.$ert['projekt_tagv_kod'].'">'.$ert['projekt_tagv_kod'];
 if(isset($tomb_tagvkod_nev[$ert['projekt_tagv_kod']]))
	  echo ' - '.$tomb_tagvkod_nev[$ert['projekt_tagv_kod']];
 
 echo '</select>';
}else{
 //echo $ert['projekt_tagv_kod'];
}
//Társasági SAP kód - vége

//Tevékenységek szolgáltatás kód - eleje
echo '<td align=center>';
if($ert['projekt_inaktiv']==0){
 //echo "<input type='text' style='width:80px' maxlength='4' onkeyup='admin_modprojekt_ment(\"".$ert['projekt_id']."\")' id='admin_ujprojktmod_szolgkod_".$ert['projekt_id']."' value='".$ert['projekt_szolg_kod']."'>";
 echo '<select onchange="admin_modprojekt_ment_proc(\''.$ert['projekt_id'].'\')" class="select2_ajax" csonkolt="1" mod="admin_szolgkod" id="admin_ujprojktmod_szolgkod_'.$ert['projekt_id'].'" style="width:200px">';
 echo '<option value="'.$ert['projekt_szolg_kod'].'">'.$ert['projekt_szolg_kod'];
  if(isset($tomb_szervkod_nev[$ert['projekt_szolg_kod']]))
	  echo ' - '.$tomb_szervkod_nev[$ert['projekt_szolg_kod']];
  
 echo '</select>';
}else{
 //echo $ert['projekt_szolg_kod'];
}
//Tevékenységek szolgáltatás kód - vége

//Önköltség kategória - eleje
echo '<td align=center>';
if($ert['projekt_inaktiv']==0){
 echo '<select onchange="admin_modprojekt_ment_proc(\''.$ert['projekt_id'].'\')" class="select2_ajax" csonkolt="1" mod="admin_kat" id="admin_ujprojktmod_kat_'.$ert['projekt_id'].'" style="width:200px">';
  
  if($ert['projekt_kat_id']==''){
	  echo '<option value="keremv">Kérem válassz';
  }else{
	  echo '<option value="'.$ert['projekt_kat_id'].'">'.$ert['projekt_kat_nev'].' - '.$ert['projekt_kat_nev_h'];
  }
 echo '</select>';
 
}else{
 //echo $ert['projekt_kat_nev'];
}
//Kategória - vége

//projekt_co - eleje
echo "<td>";
if($ert['projekt_inaktiv']==0)
 echo "<input type='text' style='width:120px' maxlength='12' onkeyup='admin_modprojekt_ment(\"".$ert['projekt_id']."\")' id='admin_ujprojktmod_co_".$ert['projekt_id']."' value='".$ert['projekt_co']."'>";
else
 echo $ert['projekt_co'];
//projekt_co - vége

//Leírás - eleje
echo "<td align=center>";

 if($ert['projekt_title']==""){
  $projekt_title="";
 }else{
  $projekt_title="<br>".str_replace("\n","<br>",$ert['projekt_title']);
 }
$title="<b>".$ert['projekt_nev']."</b>".$projekt_title; 

echo "<span id='admin_ujprojktmod_tooltipnyers_".$ert['projekt_id']."' style='display:none'>".$projekt_title."</span>";
echo "<img id='admin_ujprojktmod_tooltip_".$ert['projekt_id']."' onclick='admin_mod_proj_title_katt(\"".$ert['projekt_id']."\")' title='".$title."' class='linkm_tooltip' src='image\info_18.png'>";
//Leírás - vége

//Szervezetek
echo "<td align=center>";
if($ert['projekt_inaktiv']==0){
if((isset($tomb_szervszam[$ert['projekt_id']]))and($tomb_szervszam[$ert['projekt_id']]!=""))
 $szerv_szam=$tomb_szervszam[$ert['projekt_id']];
else{
 $szerv_szam="0";	
}
 echo "<span onclick='admin_mod_proj_szerv_katt(\"".$ert['projekt_id']."\",\"".$ert['projekt_nev']."\")' class='link'>".$szerv_szam."</span>";
}

//Felhasználók
echo "<td align=center>";
if($ert['projekt_inaktiv']==0){
if((isset($tomb_userszam[$ert['projekt_id']]))and($tomb_userszam[$ert['projekt_id']]!=""))
 $szerv_szam=$tomb_userszam[$ert['projekt_id']];
else{
 $szerv_szam="0";	
}
 echo "<span onclick='admin_mod_proj_user_katt(\"".$ert['projekt_id']."\",\"".$ert['projekt_nev']."\")' class='link'>".$szerv_szam."</span>";
}

//Projekt jováhagyó
echo "<td align=center>";
//if($ert['projekt_inaktiv']==0){
if((isset($tomb_projektjovahagyoszam[$ert['projekt_id']]))and($tomb_projektjovahagyoszam[$ert['projekt_id']]!=""))
 $projektjovahagyo_szam=$tomb_projektjovahagyoszam[$ert['projekt_id']];
else{
 $projektjovahagyo_szam="0";	
}
 echo "<span onclick='admin_mod_proj_userjovahagyo_katt(\"".$ert['projekt_id']."\",\"".$ert['projekt_nev']."\")' class='link'>".$projektjovahagyo_szam."</span>";
//}

//Max rögzíthető óra
echo "<td align=center>";
echo "<span onclick='admin_mod_proj_maxido_katt(\"".$ert['projekt_id']."\",\"".$ert['projekt_nev']."\")' class='link'>";
if(isset($tomb_projekt_ido[$ert['projekt_id']])){
 echo "Módosítás";
}else{
 echo "Nincs";	
}
echo "</span>";

 //Inaktív
echo "<td align=center>";
if($ert['projekt_inaktiv']==1) $postck="checked";
 else $postck="";
echo "<input ".$postck." onclick='admin_modprojekt_inaktiv(\"".$ert['projekt_id']."\")' class='link' type='checkbox' id='admin_ujprojektmod_inaktiv_".$ert['projekt_id']."'>";


echo "</tr>";
}
}
}
}

function admin_uj_projekt_szerv_katt(){
echo "ok$;$";

echo "<b>Szűrés:</b><br>";
echo "<input onkeyup='admin_ujszerv_hozz_keress()' id='szerv_hozzid_keress' type=text style='width:250px'>";

echo "<div id='szerv_hozzid_tal_div'>";
admin_uj_proj_szerv_katt_list_ki("all");
echo "</div>";
}

function admin_ujszerv_hozz_keress(){
echo "ok$;$";
$tomb_szerv_lat=keres_szerv_akt_nevlike($_POST['szerv_nev']);
admin_uj_proj_szerv_katt_list_ki($tomb_szerv_lat);
}

function admin_uj_proj_szerv_katt_list_ki($tomb_szerv_lat){
//$tomb_szervall=keres_mit2_order("mira_szerv","szerv_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"szerv_inaktiv","0","szerv_nev","asc");
$tomb_szervall=keres_mit1_order("mira_szerv","szerv_inaktiv","0","szerv_nev","asc");

if((isset($_POST['szerv_id']))and($_POST['szerv_id']!="")){
$tomb_szerv=explode(",",$_POST['szerv_id']);
$tomb_szerv_van=array();
foreach($tomb_szerv as $i => $szerv_id){
 $tomb_szerv_van[$szerv_id]=1;
}
}

if(is_array($tomb_szervall)){
echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
//echo '<th>ID';
echo '<th>Szervezet név';
echo '<th>Hozzárendelés';

if(
(isset($tomb_szerv_van))and
((sizeof($tomb_szervall))==(sizeof($tomb_szerv_van)))
)
 $allszervvan=" checked";
else $allszervvan="";
echo "<input".$allszervvan." onchange='admin_ujszerv_hozzall_change()' id='szerv_hozzidall' class='link' type='checkbox'>";


echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_szervall as $i => $ert){

if(isset($tomb_szerv_van[$ert['szerv_id']])){
 $ck=" checked";
}else{
 $ck="";
}

if(
((is_array($tomb_szerv_lat))and(isset($tomb_szerv_lat[$ert['szerv_id']])))
or
(
((!is_array($tomb_szerv_lat))and($tomb_szerv_lat=="all"))
)
){
 $css="";
}else{
 $css=" style='display:none'";
}
echo "<tr".$css.">";
//echo "<td>".$ert['szerv_id'];
echo "<td><label style='cursor:pointer' for='szerv_hozzid_".$ert['szerv_id']."'>";
echo $ert['szerv_nev'];

echo "<td align=center>";
echo "<input".$ck." class='link' onchange='admin_ujszerv_hozz_change()' szerv_id='".$ert['szerv_id']."' szerv_nev='".$ert['szerv_nev']."' name='szerv_hozz' id='szerv_hozzid_".$ert['szerv_id']."' type='checkbox'>";
echo "</label>";

echo "</tr>";

}
echo "</tbody></table>";
}
}

function admin_uj_projekt_user_katt(){
echo "ok$;$";

echo "<b>Szűrés:</b><br>";
echo "Név: <input onkeyup='admin_ujuser_hozz_keress()' id='user_hozzid_keress' type=text style='width:250px'>";

echo "<div id='user_hozzid_tal_div'>";
$tomb_user_lat=keres_user_ujtevekenyseghez2("");
admin_uj_proj_user_katt_list_ki($tomb_user_lat);
echo "</div>";
}

function admin_ujuser_hozz_keress(){
echo "ok$;$";
//$tomb_user_lat=keres_user_akt_nevlike($_POST['user_nev']);
$tomb_user_lat=keres_user_ujtevekenyseghez2($_POST['user_nev']);
admin_uj_proj_user_katt_list_ki($tomb_user_lat);
}

function admin_uj_proj_user_katt_list_ki($tomb_user){
//$tomb_userall=keres_mit2_order("mira_user","user_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"user_inaktiv","0","user_nev","asc");

if((isset($_POST['user_ad']))and($_POST['user_ad']!="")){
$tomb_user_2=explode(",",$_POST['user_ad']);
$tomb_user_van=array();
foreach($tomb_user_2 as $i => $user_ad){
  $tomb_user_van[$user_ad]=1;
}
}

if(is_array($tomb_user)){
echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
echo '<th>User AD';
echo '<th>Név';
echo '<th>';
echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_user as $i => $ert){

if($i==0){
	$th=$ert['tal'];
}else{

if(isset($tomb_user_van[$ert['user_ad']])){
 $ck=" checked";
}else{
 $ck="";
}

echo "<tr>";
echo "<td>".$ert['user_ad'];
echo "<td><label style='cursor:pointer' for='user_hozzid_".$ert['user_ad']."'>";
echo $ert['user_nev'];

echo "<td>";
echo "<input".$ck." class='link' onchange='admin_ujuser_hozz_change(this.id)' user_ad='".$ert['user_ad']."' user_nev='".$ert['user_nev']."' name='user_hozz' id='user_hozzid_".$ert['user_ad']."' type='checkbox'>";
echo "</label>";

echo "</tr>";
}
}
echo "</tbody></table>";


elozo_kovetkezo_gombok("admin_ujuser_hozz_keress_proc",$th,$GLOBALS['mira']['user_jog']['user_ujtevekenyseguserhozza_keres_talszam'],$_POST['oldalholvagyok']);
echo "<div style='margin-top:5px'>";
//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['user_ujtevekenyseguserhozza_keres_talszam'],"admin_ujuser_hozz_keress_proc","user_ujtevekenyseguserhozza_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='user_ujtevekenyseguserhozza_keres_tal_oldalholvagyok'>";

if(is_array($tomb_user)){
foreach($tomb_user as $i => $ert){
if($i==0){
 $th=$ert['tal'];
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['user_ujtevekenyseguserhozza_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='user_ujtevekenyseguserhozza_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['user_ujtevekenyseguserhozza_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_ujuser_hozz_keress_proc('tallep_elso','');</script>";
  }
 }
}}
//excel_export("szerv_jovahagyo",$th);
}

}
}

function admin_ujprojekt_ment(){
//1.1 NÉV:
if((!isset($_POST['projekt_nev']))or(
(isset($_POST['projekt_nev'])and($_POST['projekt_nev']==""))
)){
 echo "nook$;$"."Tevékenység nevének megadása kötelező!";
 exit;
}

//1.1 NÉV:
if((!isset($_POST['kezd_date']))or(
(isset($_POST['kezd_date'])and($_POST['kezd_date']==""))
)){
 echo "nook$;$"."Rögzítés kezdete megadása kötelező!";
 exit;
}

//1.1 Társasági kód:
if((!isset($_POST['tagvkod']))or(
(isset($_POST['tagvkod'])and($_POST['tagvkod']==""))
)){
 echo "nook$;$"."Társasági SAP kód megadása kötelező!";
 exit;
}

if((!isset($_POST['szolgkod']))or(
(isset($_POST['szolgkod'])and($_POST['szolgkod']==""))
)){
 echo "nook$;$"."Tevékenységek szolgáltatás kód megadása kötelező!";
 exit;
}

if((!isset($_POST['kat_id']))or(
(isset($_POST['kat_id'])and($_POST['kat_id']==""))
)){
 echo "nook$;$"."Kategória megadása kötelező!";
 exit;
}

/*if((!isset($_POST['projekt_tipus']))or(
(isset($_POST['projekt_tipus'])and($_POST['projekt_tipus']=="keremv"))
)){
 echo "nook$;$"."projekt típusának kiválasztása kötelező!";
 exit;
}*/
//2: Van-e Ilyen user
//$usvane=keres_mit2_mit1("projekt","projekt_nev",$_POST['projekt_nev'],"projekt_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"projekt_id");
$usvane=keres_mit1_mit1("projekt","projekt_nev",$_POST['projekt_nev'],"projekt_id");
if(is_array($usvane)){
	echo "Hiba! Van már ilyen tevékenység!";
	exit;
}else{

mysqli_autocommit($GLOBALS['mysqli'],false);

//2. projekt tábla mentése
$tmp_bk=array();
$tmp_bk[0]['projekt_nev']=$_POST['projekt_nev'];
if(isset($_POST['projekt_title']))
 $tmp_bk[0]['projekt_title']=$_POST['projekt_title'];

if($_POST['kezd_date']!='')
 $tmp_bk[0]['projekt_kezd_date']=$_POST['kezd_date'];
if($_POST['veg_date']!='')
 $tmp_bk[0]['projekt_veg_date']=$_POST['veg_date'];

$tmp_bk[0]['projekt_tagv_kod']=$_POST['tagvkod'];

if(isset($_POST['szolgkod']))
 $tmp_bk[0]['projekt_szolg_kod']=$_POST['szolgkod'];

if(isset($_POST['kat_id']))
 $tmp_bk[0]['projekt_kat_id']=$_POST['kat_id'];

if(isset($_POST['co']))
 $tmp_bk[0]['projekt_co']=$_POST['co'];

//$tmp_bk[0]['projekt_tipus']=$_POST['projekt_tipus'];
$tmp_bk[0]['projekt_tagv']=$GLOBALS[$GLOBALS['sessionname']]['tagv'];
be_visz_insert("projekt",$tmp_bk);
$projekt_id = mysqli_insert_id($GLOBALS['mysqli']);
//2. projekt tábla mentése

//3. szerv tábla lementése - eleje
if((isset($_POST['szerv_id']))and($_POST['szerv_id']!="")){
$tomb_szerv=explode(",",$_POST['szerv_id']);

foreach($tomb_szerv as $szerv_id){
 $tmp_bk_p_sz=array();
 $tmp_bk_p_sz[0]['projekt_id']=$projekt_id;
 $tmp_bk_p_sz[0]['szerv_id']=$szerv_id;
 be_visz_insert("projekt_szerv",$tmp_bk_p_sz);
}
}
//3. szerv tábla lementése - vége

//4. szerv tábla lementése - eleje
if((isset($_POST['user_ad']))and($_POST['user_ad']!="")){
$tomb_user=explode(",",$_POST['user_ad']);
foreach($tomb_user as $user_ad){
 $tmp_bk_p_u=array();
 $tmp_bk_p_u[0]['projekt_id']=$projekt_id;
 $tmp_bk_p_u[0]['user_ad']=$user_ad;
 be_visz_insert("projekt_user",$tmp_bk_p_u);
}
}
//4. szerv tábla lementése - vége



mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);

echo "ok$;$";

}

}

function admin_modprojekt_ment(){
if(
(isset($_POST['projekt_nev']))and
(isset($_POST['tagvkod']))and
(isset($_POST['szolgkod']))and
(isset($_POST['kat']))and
(isset($_POST['co']))and
(isset($_POST['kezd_date']))and
(isset($_POST['veg_date']))and
(isset($_POST['projekt_id']))and
($_POST['projekt_nev']!="")and
($_POST['projekt_id']!="")
){
$tmp_mod=array();
$tmp_mod[0]['projekt_nev']=$_POST['projekt_nev'];

if( ($_POST['tagvkod']!='') and ($_POST['tagvkod']!='keremv'))
 $tmp_mod[0]['projekt_tagv_kod']=$_POST['tagvkod'];

if( ($_POST['szolgkod']!='') and ($_POST['szolgkod']!='keremv') )
 $tmp_mod[0]['projekt_szolg_kod']=$_POST['szolgkod'];

if( ($_POST['kat']!='') and ($_POST['kat']!='keremv') )
 $tmp_mod[0]['projekt_kat_id']=$_POST['kat'];

$tmp_mod[0]['projekt_co']=$_POST['co'];

if($_POST['kezd_date']!='')
 $tmp_mod[0]['projekt_kezd_date']=str_replace(".","-",$_POST['kezd_date']);
else $tmp_mod[0]['projekt_kezd_date']=null;
	
if($_POST['veg_date']!='')
 $tmp_mod[0]['projekt_veg_date']=str_replace(".","-",$_POST['veg_date']);
else $tmp_mod[0]['projekt_veg_date']=null;
	
//$tmp_mod[0]['projekt_tipus']=$_POST['projekt_tipus'];
mod_egy_fel_tom('projekt',$tmp_mod[0],'projekt_id',$_POST['projekt_id']);
echo "ok$;$";
}
}

function admin_modprojekt_inaktiv(){
if(
(isset($_POST['inaktiv']))and
(isset($_POST['projekt_id']))and
($_POST['inaktiv']!="")and
($_POST['projekt_id']!="")
){
$tmp_mod=array();
if($_POST['inaktiv']==1)
 $tmp_mod[0]['projekt_inaktiv']=1;
else
 $tmp_mod[0]['projekt_inaktiv']=0;
mod_egy_fel_tom('projekt',$tmp_mod[0],'projekt_id',$_POST['projekt_id']);
echo "ok$;$";
}
}

function admin_mod_proj_szerv_katt(){
echo "ok$;$";

echo "Szervezet hozzárendelése <b>";
echo $_POST['projekt_nev'];
echo "</b> tevékenységhez<br><br>";

echo "<b>Szűrés:</b><br>";
echo "<input onkeyup='admin_modszerv_hozz_keress(\"".$_POST['projekt_id']."\")' projekt_id='".$_POST['projekt_id']."' id='szerv_hozzid_keress' type=text style='width:250px'>";

echo "<br>Csak hozzárendelt szervezetek: ";
echo "<input onchange='admin_modszerv_hozz_keress()' id='szerv_hozzid_csakhozz_szur' type='checkbox'>";

echo "<br>Csak kategória kivételek: ";
echo "<input onchange='admin_modszerv_hozz_keress()' id='szerv_hozzid_csakkatkivetel_szur' type='checkbox'>";


echo "<div id='szerv_hozzid_tal_div'>";
 //$tomb_szerv=keres_mit2_order("mira_szerv","szerv_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"szerv_inaktiv","0","szerv_nev","asc");
 $tomb_szerv=keres_mit1_order("mira_szerv","szerv_inaktiv","0","szerv_nev","asc");
 $tomb_szerv_van=keres_projekt_szerv_hozzarend_adat($_POST['projekt_id']);
 $tomb_szerv_katkivetel=keres_projekt_szerv_katkivetel_hozzarend_adat($_POST['projekt_id']);
 admin_mod_proj_szerv_katt_list_ki($tomb_szerv,$tomb_szerv_van,"all",$tomb_szerv_katkivetel);
echo "</div>";
}

function admin_modszerv_hozz_keress(){
echo "ok$;$";
//$tomb_szerv=keres_mit2_order("mira_szerv","szerv_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"szerv_inaktiv","0","szerv_nev","asc");
$tomb_szerv=keres_mit1_order("mira_szerv","szerv_inaktiv","0","szerv_nev","asc");
$tomb_szerv_van=keres_projekt_szerv_hozzarend_adat($_POST['projekt_id']);
$tomb_szerv_katkivetel=keres_projekt_szerv_katkivetel_hozzarend_adat($_POST['projekt_id']);
$tomb_szerv_lat=keres_szerv_akt_nevlike($_POST['szerv_nev']);
admin_mod_proj_szerv_katt_list_ki($tomb_szerv,$tomb_szerv_van,$tomb_szerv_lat,$tomb_szerv_katkivetel);
}

function admin_mod_proj_szerv_katt_list_ki($tomb_szerv,$tomb_szerv_van,$tomb_szerv_lat,$tomb_szerv_katkivetel){

if(is_array($tomb_szerv)){
echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
//echo '<th>ID';
echo '<th>Szervezet név';
echo '<th>Hozzárendelés';

if((is_array($tomb_szerv_van))and(sizeof($tomb_szerv)==sizeof($tomb_szerv_van)))
 $allchecked=" checked";
else $allchecked="";
echo "<input".$allchecked." type=checkbox onchange='admin_modszerv_hozzall_change(\"".$_POST['projekt_id']."\")' id='szerv_allhozzid' title='Összes kijelölése vagy megszüntetése'>";

echo '<th>Önköltség kategória kivétel';

echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_szerv as $i => $ert){

if(isset($tomb_szerv_van[$ert['szerv_id']])){
 $ck=" checked";
}else{
 $ck="";
}

if(
(
((is_array($tomb_szerv_lat))and(isset($tomb_szerv_lat[$ert['szerv_id']])))
or
(
((!is_array($tomb_szerv_lat))and($tomb_szerv_lat=="all"))
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

and
(
($_POST['katkivetel_csakvan']=="0")
or
(
($_POST['katkivetel_csakvan']=="1")and(isset($tomb_szerv_katkivetel[$ert['szerv_id']]))
)
)

){
 $css=" style='height:27px'";
}else{
 $css=" style='display:none'";
}

echo "<tr".$css.">";
//echo "<td>".$ert['szerv_id'];
echo "<td><label style='cursor:pointer' for='szerv_hozzid_".$ert['szerv_id']."'>";
echo $ert['szerv_nev'];

echo "<td>";
echo "<input".$ck." class='link' onchange='admin_modszerv_hozz_change(\"".$ert['szerv_id']."\",\"".$_POST['projekt_id']."\")' name='szerv_hozz' id='szerv_hozzid_".$ert['szerv_id']."' type='checkbox'>";
echo "</label>";

//Kategória kivétel
echo "<td>";
if($ck!=""){//Bevan pipálva
 echo '<select onchange="admin_modszerv_katkivetel_change(\''.$ert['szerv_id'].'\',\''.$_POST['projekt_id'].'\')" id="szerv_katkivetelid_'.$ert['szerv_id'].'" class="select2_ajax" csonkolt="1" mod="admin_kat" style="width:250px">';
 if(isset($tomb_szerv_katkivetel[$ert['szerv_id']])){
  echo '<option value="'.$tomb_szerv_katkivetel[$ert['szerv_id']]['id'].'">'.$tomb_szerv_katkivetel[$ert['szerv_id']]['nev'].' - '.$tomb_szerv_katkivetel[$ert['szerv_id']]['nev_h'];
 }else{
	 echo '<option value="keremv">Kérem válassz';
 }
echo '</select>';
}

echo "</tr>";

}
echo "</tbody></table>";
echo "<div style='margin-top:5px'>";
excel_export("admin_szervezethez_projekt",1);
echo "</div>";

}
}

function admin_moduser_katkivetel_change(){
if(
(isset($_POST['projekt_id']))and
(isset($_POST['user_ad']))and
(isset($_POST['katkivetel']))and
($_POST['projekt_id']!="")and
($_POST['user_ad']!="")and
($_POST['katkivetel']!="")
){
 if($_POST['katkivetel']!='keremv'){//Bevitel
  $tmp_mod[0]=array();
  $tmp_mod[0]['projekt_id']=$_POST['projekt_id'];
  $tmp_mod[0]['user_ad']=$_POST['user_ad'];
  $tmp_mod[0]['projekt_user_kat_id_kivetel']=$_POST['katkivetel'];
  //mod_egy_fel_tom2('projekt_user_katkivetel',$tmp_mod[0],'projekt_id',$_POST['projekt_id'],'user_ad',$_POST['user_ad']);
  //$tmp_bk[0]['kapcs_tulaj_nev']=$_POST['nev'];
  be_visz_replace("projekt_user_katkivetel",$tmp_mod);
 }else{//Ekkor ki kell
  //$tmp_mod[0]['projekt_user_kat_id_kivetel']=null;
  torles2('projekt_user_katkivetel','projekt_id',$_POST['projekt_id'],'user_ad',$_POST['user_ad']);
 }
 
 echo "ok$;$";
}else{
 echo 'adathiány';
}
}

function admin_modszerv_katkivetel_change(){
if(
(isset($_POST['projekt_id']))and
(isset($_POST['szerv_id']))and
(isset($_POST['katkivetel']))and
($_POST['projekt_id']!="")and
($_POST['szerv_id']!="")and
($_POST['katkivetel']!="")
){
 if($_POST['katkivetel']!='keremv'){//Bevitel
  $tmp_mod[0]=array();
  $tmp_mod[0]['projekt_id']=$_POST['projekt_id'];
  $tmp_mod[0]['szerv_id']=$_POST['szerv_id'];
  $tmp_mod[0]['projekt_kat_id_kivetel']=$_POST['katkivetel'];
  //mod_egy_fel_tom2('projekt_szerv_katkivetel',$tmp_mod[0],'projekt_id',$_POST['projekt_id'],'szerv_id',$_POST['szerv_id']);
  be_visz_replace("projekt_szerv_katkivetel",$tmp_mod);
 }else{//Ekkor ki kell
  //$tmp_mod[0]['projekt_kat_id_kivetel']=null;
  torles2('projekt_szerv_katkivetel','projekt_id',$_POST['projekt_id'],'szerv_id',$_POST['szerv_id']);
 }

 echo "ok$;$";
}else{
 echo 'adathiány';
}
}

function admin_modszerv_hozz_change(){
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

function admin_mod_proj_title_save(){
if(
(isset($_POST['projekt_title']))and
(isset($_POST['projekt_id']))and
//($_POST['projekt_title']!="")and
($_POST['projekt_id']!="")
){
 $tmp_mod[0]=array();
 $tmp_mod[0]['projekt_title']=$_POST['projekt_title'];
 mod_egy_fel_tom('projekt',$tmp_mod[0],'projekt_id',$_POST['projekt_id']);
 echo "ok$;$";
}
}

function admin_mod_proj_title_katt(){
//$tomb=keres_mit2("projekt","projekt_id",$_POST['projekt_id'],"projekt_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv']);
$tomb=keres_mit1("projekt","projekt_id",$_POST['projekt_id']);
if(is_array($tomb)){
echo "ok$;$";
echo "<b>".$tomb[0]['projekt_nev']." leírásának módosítása</b><br><br>";

echo "<textarea maxlength='255' id='admin_mod_projekt_title' style='width:400px' rows='4'>";
echo $tomb[0]['projekt_title'];
echo "</textarea>";
echo "<br>Karakterek száma: <span id='admin_mod_projekt_title_hossz'>".mb_strlen($tomb[0]['projekt_title'])."</span> (Maximum 255)";
echo "<br><br><input value='Projekt leírásának mentése' onclick='admin_mod_proj_title_save(\"".$_POST['projekt_id']."\")' type='submit'>";

}else{
 echo "adathiba";
}

}

function admin_mod_proj_maxido_katt(){
echo "ok$;$";

echo "Havonta rögzíthető max óra hozzárendelése <b>";
echo $_POST['projekt_nev'];
echo "</b> tevékenységhez<br><br>";

$van_e_all_max=keres_mit1_mit1_csak_ertek('projekt','projekt_id',$_POST['projekt_id'],'projekt_id_max_all_igen');
echo '<b>Minden hónapra egységes max óra:</b>';
if($van_e_all_max==1){
	$van_e_all_max_ora=keres_mit1_mit1_csak_ertek('projekt','projekt_id',$_POST['projekt_id'],'projekt_id_max_all_ora');
	$checked=' checked';
	$span_dis=' style="margin-left:5px"';
}else{
	$van_e_all_max_ora='0';
	$checked='';
	$span_dis=' style="display:none"';
}
echo "<input".$checked." onchange='admin_mod_proj_maxido_katt_all_ck(\"".$_POST['projekt_id']."\")' id='admin_mod_proj_maxido_katt_all_ckbox' type='checkbox' style='cursor:pointer'>";
echo '<span'.$span_dis.' id="projekt_max_all_span">';
echo '<input value="'.$van_e_all_max_ora.'" maxlength="5" style="width:60px;height:14px" projekt_id="'.$_POST['projekt_id'].'" id="projekt_max_all" class="projekt_max_ido" type=text>';
echo ' óra</span>';

echo "<div id='proj_maxido_tal_div'>";
if($van_e_all_max!=1){
 proj_maxido_tal_kital();	
}
echo "</div>";
}

function admin_mod_proj_maxido_all_ment(){
if(
 (isset($_POST['projekt_id']))and
 (isset($_POST['maxido']))and
 ($_POST['projekt_id']!="")and
 ($_POST['maxido']!="")
){
  $tmp_mod=array();
  if($_POST['maxido']=="0")
   $tmp_mod[0]['projekt_id_max_all_igen']='0';
  else
   $tmp_mod[0]['projekt_id_max_all_igen']='1';
  $tmp_mod[0]['projekt_id_max_all_ora']=$_POST['maxido'];
  mod_egy_fel_tom('projekt',$tmp_mod[0],'projekt_id',$_POST['projekt_id']);	
 echo "ok$;$";
}else{
	echo "Adathiba";
}
}

function admin_mod_proj_maxido_katt_all_ck(){
if(
 (isset($_POST['projekt_id']))and
 (isset($_POST['max_all_igen']))and
 (isset($_POST['projekt_max_all']))and
 ($_POST['projekt_max_all']!="")and
 ($_POST['projekt_id']!="")and
 (
  ($_POST['max_all_igen']=="0")or
  ($_POST['max_all_igen']=="1")
 )
){
  $tmp_mod=array();
  if($_POST['projekt_max_all']=="0")
   $tmp_mod[0]['projekt_id_max_all_igen']=0;
  else
   $tmp_mod[0]['projekt_id_max_all_igen']=$_POST['max_all_igen'];
  if($_POST['max_all_igen']=="0")
	  $tmp_mod[0]['projekt_id_max_all_ora']=0;
  mod_egy_fel_tom('projekt',$tmp_mod[0],'projekt_id',$_POST['projekt_id']);
  
  if($_POST['max_all_igen']=="1"){//Összes al órát törölni kell
	  torles("projekt_ido","projekt_id",$_POST['projekt_id']);
  }
  
 echo "ok$;$";
 proj_maxido_tal_kital();
}else{
	echo "Adathiba";
}
}

function proj_maxido_tal_kital(){
$projekt_id=$_POST['projekt_id'];
$tomb=keres_projekt_idok($projekt_id);
//$tomb_kezddate=keres_tagv_kezdeti_date($_SESSION[$GLOBALS['sessionname']]['tagv']);
$tomb_kezddate=keres_tagv_kezdeti_date();

//echo "Kezdő év:  ".$tomb_kezddate['ev_kezdo_ev'];
//echo "<br>Kezdő hónap:  ".$tomb_kezddate['ev_kezdo_ho'];
//echo "<br><br>";
$evnext=date('Y', strtotime('+1 year'));
$evmost=date("Y",time());
$homost=date("n",time());

echo "<div class='proj_maxido_tal_kital_uj'>";
echo "<b>Havonta eltérő max óra</b>";
echo "<table cellpadding=0 cellspacing=0 border=1 style='margin:5px 0px 10px 0px' class='table_emre'>";

echo "<tr><td><b>Év</b>";
echo "<td><select onchange='proj_maxido_uj_ev_change(\"".$tomb_kezddate['ev_kezdo_ev']."\",\"".$tomb_kezddate['ev_kezdo_ho']."\",\"".$evnext."\",\"".$homost."\")' id='proj_maxido_uj_ev_sel'>";
for($i=$tomb_kezddate['ev_kezdo_ev'];$i<=$evnext;$i++){
 if($i==$evmost){
	 $sel=" selected";
 }else{
	 $sel="";
 }
 echo "<option value='".$i."'".$sel.">".$i;
}
echo "</select>";
echo "</tr>";

echo "<tr><td><b>Hónap</b>";
echo "<td><select id='proj_maxido_uj_ho_sel'>";
for($i=1;$i<=12;$i++){
 if(($evmost==$tomb_kezddate['ev_kezdo_ev'])and($i==$tomb_kezddate['ev_kezdo_ho'])){
	 $sel=" selected";
 }elseif(($evmost!=$tomb_kezddate['ev_kezdo_ev'])and($i==$homost)){
	 $sel=" selected";
 }else{
	 $sel="";
 }
 
 if(($evmost==$tomb_kezddate['ev_kezdo_ev'])and($i<$tomb_kezddate['ev_kezdo_ho'])){//Kezdő év előtti cuccokat el kell rejteni
	 $css=" style='display:none'";
 }else{
	 $css="";
 }
 echo "<option".$css." value='".$i."'".$sel.">".ho_ki($i);
}
echo "</select>";
echo "</tr>";

echo "<tr><td><b>Max</b>";
echo '<td><input value="0" maxlength="5" style="width:60px;height:14px" projekt_id="'.$_POST['projekt_id'].'" id="projekt_max_uj" class="projekt_max_ido" type=text>';
echo ' óra';

echo "<tr><td align=center colspan=2><input onclick='proj_maxido_uj_ev_ment(\"".$projekt_id."\")' type=submit value='Mentés' class='submit2'>";
echo "</tr>";

echo "</table>";

if(is_array($tomb)){
echo "<b>Beállított értékek</b>";
echo "<table cellpadding=0 cellspacing=0 border=1 class='table_emre' style='margin-top:5px'>";
echo '<thead>';
echo '<tr>';
echo '<th>Év';
echo '<th>Hónap';
echo '<th>Rögzíthető max óra';
echo '<th>Művelet';
echo '</tr>';
echo '<thead><tbody>';
foreach($tomb as $ert){
 //ho_ki($ho)
 $tora=explode("-",$ert['projekt_ho_ido']);
 $ev=$tora[0];
 $ho=$tora[1];
 $ho++;
 $ho--;
 echo '<tr>';
 echo '<td>'.$ev;
 echo '<td>'.ho_ki($ho);
 echo '<td align=center>'.$ert['projekt_id_max_ora'];
 
 //Művelet
 echo '<td align=center>';
	//törlés
	echo '<img onclick="proj_maxido_uj_ev_del(\''.$ev.'\',\''.$ho.'\',\''.$projekt_id.'\')" src="image/del.png" style="width:16px" title="Törlés" class="linkm_tooltip">';
	echo '<img onclick="proj_maxido_uj_ev_mod(\''.$ev.'\',\''.$ho.'\',\''.$ert['projekt_id_max_ora'].'\')" src="image/mod15_2.png" style="width:15px;margin-left:10px" title="Módosítás" class="linkm_tooltip">';
 
 echo '</tr>';
}

echo '</tbody></table>';
}else{
 echo "<b>Nincs elementett adat!</b>";  
}
echo "</div>";
}

function proj_maxido_uj_ev_ment(){
if(
 (isset($_POST['projekt_id']))and
 (isset($_POST['ev']))and
 (isset($_POST['ho']))and
 (isset($_POST['max_ora']))and
 ($_POST['projekt_id']!="")and
 ($_POST['ev']!="")and
 ($_POST['ho']!="")and
 ($_POST['max_ora']!="")
){
	if($_POST['ho']<10)$ho="0".$_POST['ho'];
	else $ho=$_POST['ho'];
  $tmp_mod=array();
  $tmp_mod[0]['projekt_ho_ido']=$_POST['ev']."-".$ho;
  $tmp_mod[0]['projekt_id_max_ora']=$_POST['max_ora'];
  $tmp_mod[0]['projekt_id']=$_POST['projekt_id'];
  //mod_egy_fel_tom('projekt_ido',$tmp_mod[0],'projekt_id',$_POST['projekt_id']);
  be_visz_replace("projekt_ido",$tmp_mod);
 echo "ok$;$";
 proj_maxido_tal_kital();
}else{
	echo "Adathiba";
}
}

function proj_maxido_uj_ev_del(){
if(
 (isset($_POST['projekt_id']))and
 (isset($_POST['ev']))and
 (isset($_POST['ho']))and
 ($_POST['projekt_id']!="")and
 ($_POST['ev']!="")and
 ($_POST['ho']!="")
){
	if($_POST['ho']<10)$ho="0".$_POST['ho'];
	else $ho=$_POST['ho'];
 torles2("projekt_ido","projekt_id",$_POST['projekt_id'],"projekt_ho_ido",$_POST['ev']."-".$ho);
 echo "ok$;$";
 proj_maxido_tal_kital();
}else{
	echo "Adathiba";
}
}

function admin_mod_proj_user_katt(){
echo "ok$;$";

echo "Felhasználók hozzárendelése <b>";
echo $_POST['projekt_nev'];
echo "</b> tevékenységhez<br><br>";

echo "<b>Szűrés:</b><br>";
echo "<input autocomplete='off' projekt_id='".$_POST['projekt_id']."' onkeyup='admin_moduser_hozz_keress(\"".$_POST['projekt_id']."\")' id='user_hozzid_keress' type=text style='width:250px'>";

echo "<br>Csak hozzárendelt felhasználók: ";
echo "<input onchange='admin_moduser_hozz_keress_proc(\"".$_POST['projekt_id']."\")' id='user_hozzid_csakhozz_szur' type='checkbox'>";

echo "<div id='user_hozzid_tal_div'>";
 //$tomb_user=keres_mit2_order("mira_user","user_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"user_inaktiv","0","user_nev","asc");
 $tomb_user=keres_projekt_bellithoz_user($_POST['projekt_id'],"","0");
 $tomb_user_van=keres_projekt_user_hozzarend_adat($_POST['projekt_id']);
 $tomb_user_katkivetel=keres_projekt_user_katkivetel_hozzarend_adat($_POST['projekt_id']);
 admin_mod_proj_user_katt_list_ki($tomb_user,$tomb_user_van,$tomb_user_katkivetel);
echo "</div>";
}

function admin_moduser_hozz_keress(){
echo "ok$;$";
//$tomb_user=keres_mit2_order("mira_user","user_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"user_inaktiv","0","user_nev","asc");
$tomb_user=keres_projekt_bellithoz_user($_POST['projekt_id'],$_POST['keress_nev'],$_POST['csakvan']);
$tomb_user_van=keres_projekt_user_hozzarend_adat($_POST['projekt_id']);
$tomb_user_katkivetel=keres_projekt_user_katkivetel_hozzarend_adat($_POST['projekt_id']);
//$tomb_user_lat=keres_user_akt_nevlike($_POST['user_nev']);
admin_mod_proj_user_katt_list_ki($tomb_user,$tomb_user_van,$tomb_user_katkivetel);
}

function admin_mod_proj_user_katt_list_ki($tomb_user,$tomb_user_van,$tomb_user_katkivetel){

if(is_array($tomb_user)){
echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
echo '<th>AD';
echo '<th>Felhasználó neve';
echo '<th>Felhasználó szervezete';
echo '<th>Hozzárendelés';
echo '<th>Önköltség kategória kivétel';
echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_user as $i => $ert){

if($i==0){
	$th=$ert['tal'];
}else{
	
if(isset($tomb_user_van[$ert['user_ad']])){
 $ck=" checked";
}else{
 $ck="";
}

echo "<tr>";
echo "<td>".$ert['user_ad'];
echo "<td><label style='cursor:pointer' for='user_hozzid_".$ert['user_ad']."'>";
echo $ert['user_nev'];

//Szervezet
echo '<td>';
echo $ert['szerv_nev'];

echo '<td>';
echo "<input".$ck." class='link' onchange='admin_moduser_hozz_change(\"".$ert['user_ad']."\",\"".$_POST['projekt_id']."\")' name='user_hozz' id='user_hozzid_".$ert['user_ad']."' type='checkbox'>";
echo "</label>";

//Önköltség kategória kivétel
echo '<td>';
if($ck!=''){//Csak ha be van pipálva
  echo '<select onchange="admin_moduser_katkivetel_change(\''.$ert['user_ad'].'\',\''.$_POST['projekt_id'].'\')" id="user_katkivetelid_'.$ert['user_ad'].'" class="select2_ajax" csonkolt="1" mod="admin_kat" style="width:250px">';
 if(isset($tomb_user_katkivetel[$ert['user_ad']])){
  echo '<option value="'.$tomb_user_katkivetel[$ert['user_ad']]['id'].'">'.$tomb_user_katkivetel[$ert['user_ad']]['nev'].' - '.$tomb_user_katkivetel[$ert['user_ad']]['nev_h'];
 }else{
	 echo '<option value="keremv">Kérem válassz';
 }
echo '</select>';
}

echo "</tr>";

}
}
echo "</tbody></table>";

elozo_kovetkezo_gombok("admin_moduser_hozz_keress_proc",$th,$GLOBALS['mira']['user_jog']['user_projuserhozza_keres_talszam'],$_POST['oldalholvagyok']);
echo "<div style='margin-top:5px'>";
//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['user_projuserhozza_keres_talszam'],"admin_moduser_hozz_keress_proc","user_projuserhozza_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='user_projuserhozza_keres_tal_oldalholvagyok'>";

if(is_array($tomb_user)){
foreach($tomb_user as $i => $ert){
if($i==0){
 $th=$ert['tal'];
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['user_projuserhozza_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='user_projuserhozza_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['user_projuserhozza_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_moduser_hozz_keress_proc('tallep_elso','');</script>";
  }
 }
}}
excel_export("projekthez_user",$th);
}
echo "</div>";

}
}

function admin_moduser_hozz_change(){
if(
(isset($_POST['projekt_id']))and
(isset($_POST['user_ad']))and
(isset($_POST['mit']))and
($_POST['projekt_id']!="")and
($_POST['user_ad']!="")and
($_POST['mit']!="")
){
 if($_POST['mit']==1){//Bevitel
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['projekt_id']=$_POST['projekt_id'];
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  be_visz_replace("projekt_user",$tmp_bk_ker_def);
 }else{//Ekkor ki kell
  torles2("projekt_user",'projekt_id',$_POST['projekt_id'],'user_ad',$_POST['user_ad']);
 }
 echo "ok$;$";
}
}

function admin_mod_proj_userjovahagyo_katt(){
echo "ok$;$";

echo "Projekt jóváhagyók hozzárendelése <b>";
echo $_POST['projekt_nev'];
echo "</b> tevékenységhez<br><br>";

echo "<b>Szűrés:</b><br>";
echo "<input autocomplete='off' projekt_id='".$_POST['projekt_id']."' onkeyup='admin_moduserjovahagyo_hozz_keress(\"".$_POST['projekt_id']."\")' id='userjovahagyo_hozzid_keress' type=text style='width:250px'>";

echo "<br>Csak hozzárendelt felhasználók: ";
echo "<input onchange='admin_moduserjovahagyo_hozz_keress_proc(\"".$_POST['projekt_id']."\")' id='userjovahagyo_hozzid_csakhozz_szur' type='checkbox'>";

echo "<div id='userjovahagyo_hozzid_tal_div'>";
 $tomb_user=keres_projektjovahagyo_bellithoz_user($_POST['projekt_id'],"","0");
 $tomb_user_van=keres_projekt_userjovahagyo_hozzarend_adat($_POST['projekt_id']);
 admin_mod_proj_userjovahagyo_katt_list_ki($tomb_user,$tomb_user_van);
echo "</div>";
}

function admin_moduserjovahagyo_hozz_keress(){
echo "ok$;$";
$tomb_user=keres_projektjovahagyo_bellithoz_user($_POST['projekt_id'],$_POST['keress_nev'],$_POST['csakvan']);
$tomb_user_van=keres_projekt_userjovahagyo_hozzarend_adat($_POST['projekt_id']);
admin_mod_proj_userjovahagyo_katt_list_ki($tomb_user,$tomb_user_van);
}

function admin_mod_proj_userjovahagyo_katt_list_ki($tomb_user,$tomb_user_van){
if(is_array($tomb_user)){
echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
echo '<th>AD';
echo '<th>Felhasználó neve';
echo '<th>Hozzárendelés';
echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_user as $i => $ert){

if($i==0){
	$th=$ert['tal'];
}else{
	
if(isset($tomb_user_van[$ert['user_ad']])){
 $ck=" checked";
}else{
 $ck="";
}

echo "<tr>";
echo "<td>".$ert['user_ad'];
echo "<td><label style='cursor:pointer' for='userjovahagyo_hozzid_".$ert['user_ad']."'>";
echo $ert['user_nev'];

echo "<td>";
echo "<input".$ck." class='link' onchange='admin_moduserjovahagyo_hozz_change(\"".$ert['user_ad']."\",\"".$_POST['projekt_id']."\")' name='userjovahagyo_hozz' id='userjovahagyo_hozzid_".$ert['user_ad']."' type='checkbox'>";
echo "</label>";

echo "</tr>";

}
}
echo "</tbody></table>";

elozo_kovetkezo_gombok("admin_moduserjovahagyo_hozz_keress_proc",$th,$GLOBALS['mira']['user_jog']['user_projuserjovahagyohozza_keres_talszam'],$_POST['oldalholvagyok']);
echo "<div style='margin-top:5px'>";
//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['user_projuserjovahagyohozza_keres_talszam'],"admin_moduserjovahagyo_hozz_keress_proc","user_projuserjovahagyohozza_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='user_projuserjovahagyohozza_keres_tal_oldalholvagyok'>";

if(is_array($tomb_user)){
foreach($tomb_user as $i => $ert){
if($i==0){
 $th=$ert['tal'];
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['user_projuserjovahagyohozza_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='user_projuserjovahagyohozza_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['user_projuserjovahagyohozza_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_moduserjovahagyo_hozz_keress_proc('tallep_elso','');</script>";
  }
 }
}}
excel_export("projekthez_userjovahagyo",$th);
}
echo "</div>";

}
}

function admin_moduserjovahagyo_hozz_change(){
if(
(isset($_POST['projekt_id']))and
(isset($_POST['user_ad']))and
(isset($_POST['mit']))and
($_POST['projekt_id']!="")and
($_POST['user_ad']!="")and
($_POST['mit']!="")
){
 if($_POST['mit']==1){//Bevitel
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['projekt_id']=$_POST['projekt_id'];
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  be_visz_replace("projekt_jovahagyo",$tmp_bk_ker_def);
 }else{//Ekkor ki kell
  torles2("projekt_jovahagyo",'projekt_id',$_POST['projekt_id'],'user_ad',$_POST['user_ad']);
 }
 echo "ok$;$";
}
}









function admin_modszerv_hozzall_change(){
if(
(isset($_POST['szerv_id_tom']))and
(isset($_POST['projekt_id']))and
(isset($_POST['mit_tom']))and
($_POST['szerv_id_tom']!="")and
($_POST['projekt_id']!="")and
($_POST['mit_tom']!="")
){
 if($_POST['mit_tom']==1){//Bevitel
 $tomb=explode("-",$_POST['szerv_id_tom']);
 if(is_array($tomb)){
 foreach($tomb as $szerv_id){ 
 if($szerv_id!=""){
   $tmp_bk_ker_def[0]=array();
   $tmp_bk_ker_def[0]['szerv_id']=$szerv_id;
   $tmp_bk_ker_def[0]['projekt_id']=$_POST['projekt_id'];
   be_visz_replace("projekt_szerv",$tmp_bk_ker_def);
  }
  }
  }
  
 }else{//Ekkor ki kell
  
 $tomb=explode("-",$_POST['szerv_id_tom']);
 if(is_array($tomb)){
 foreach($tomb as $szerv_id){ 
 if($szerv_id!=""){
  torles2("projekt_szerv",'szerv_id',$szerv_id,'projekt_id',$_POST['projekt_id']);
 }
 }
 } 
  
 }
 echo "ok$;$";
}
}

function admin_modproj_hozz_change_tom(){
if(
(isset($_POST['projekt_id_tom']))and
(isset($_POST['szerv_id']))and
(isset($_POST['mit_tom']))and
($_POST['projekt_id_tom']!="")and
($_POST['szerv_id']!="")and
($_POST['mit_tom']!="")
){
 if($_POST['mit_tom']==1){//Bevitel
 $tomb=explode("-",$_POST['projekt_id_tom']);
 if(is_array($tomb)){
 foreach($tomb as $projekt_id){ 
 if($projekt_id!=""){
   $tmp_bk_ker_def[0]=array();
   $tmp_bk_ker_def[0]['projekt_id']=$projekt_id;
   $tmp_bk_ker_def[0]['szerv_id']=$_POST['szerv_id'];
   be_visz_replace("projekt_szerv",$tmp_bk_ker_def);
  }
  }
  }
  
 }else{//Ekkor ki kell
  
 $tomb=explode("-",$_POST['projekt_id_tom']);
 if(is_array($tomb)){
 foreach($tomb as $projekt_id){ 
 if($projekt_id!=""){
  torles2("projekt_szerv",'projekt_id',$projekt_id,'szerv_id',$_POST['szerv_id']);
 }
 }
 } 
  
 }
 echo "ok$;$";
}
}


?>