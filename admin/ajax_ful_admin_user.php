<?php

function admin_user_mod(){
echo "ok$;$";

admin_uj_user_urlap();

admin_uj_user_list_keres();
echo "<div id='admin_uj_user_list_keres_tal'>";
admin_uj_user_list();
echo "</div>";

}

function admin_uj_user_urlap(){
echo '<div style="overflow-x:auto">';
echo "<b>Új jogosultság:</b>";

echo "<table class='table_emre'>";
echo "<tr><td id='admin_uj_ad_td'>AD azonosító:<td>
<input onkeydown='ad_leker_enter(event)' id='admin_ujuser_ad' type=text maxlength=17 style='width:150px'>
 <span onclick='ad_leker()' class='link'>AD adatok lekérése  (Klikk vagy enter)</span>
</tr>";

echo "<tr><td>Név:<td><input id='admin_ujuser_nev' type=text style='width:280px' maxlength='255'>";
echo " <img class='ad_info_img' title='<div id=\"ad_info_div\"></div>' onmouseover='ad_info_leker(\"admin_ujuser_ad\")' onmouseout='ad_info_leker_kuka(\"admin_ujuser_ad\")' id='admin_ujuser_ad_info' src='image/info_18.png'>";
echo '<span class="pir_vas" id="admin_ujuser_nev_tiltott"></span>';
echo "</tr>";

//class='disabled_auto_fill'
echo "<tr><td>Email:<td><input class='disabled_auto_fill' id='admin_ujuser_email' type='text' style='width:280px' maxlength='255'></tr>";

echo "<tr>";
echo "<td>Törzsszám";
echo "<td>";
echo "<input id='admin_ujuser_tsz' type=text style='width:100px' maxlength='8'>";
echo "</tr>";

//$tomb_szerv=keres_mit2_order("mira_szerv","szerv_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"szerv_inaktiv","0","szerv_nev","ASC");
$tomb_szerv=keres_mit1_order("mira_szerv","szerv_inaktiv","0","szerv_nev","ASC");
echo "<tr>";
echo "<td>Szervezet";
echo "<td>";
echo "<select id='admin_ujuser_szerv' class='select2_sima' style='width:400px'>";
echo "<option value='keremv'>Kérem válassz";
if(is_array($tomb_szerv)){
foreach($tomb_szerv as $ert){
 echo "<option szerv_adkod='".$ert['szerv_adkod']."' value='".$ert['szerv_id']."'>".$ert['szerv_nev'];
}
}
echo "</select";
echo "</tr>";

echo "<tr>";
echo "<td>Rögzítés kezdete";
echo "<td>";
echo '<input class="date_tol" type="text" style="width:75px" onkeydown="return admin_ujuser_kezd_date_delete()" id="admin_ujuser_kezd_date" value="">';
echo "</tr>";

echo "<tr>";
echo "<td>Max rögzíthető";
echo "<td>";
echo "Óra: <select onchange='admin_ujuser_maxrogiztheto_ora_change()' id='admin_ujuser_maxido' class='select3' style='width:130px'>";
echo "<option value='global'>Globális (".$GLOBALS['mira']['globalis_napi_ido_max_ora'].":00)";
//for($maxido=$GLOBALS['mira']['napi_osszes_ido_min_ora'];$maxido<=24;$maxido++){
for($maxido=$GLOBALS['mira']['napi_osszes_ido_min_ora'];$maxido<=$GLOBALS['tagv_alap_napi_napi_ido_max_ora'];$maxido++){
 //echo "<option value='".$maxido."'>".$maxido.":00";
 echo "<option value='".$maxido."'>".$maxido."";
}
echo "</select>";

echo " Perc: ";
echo "<select disabled onchange='admin_ujuser_maxrogiztheto_ora_change()' id='admin_ujuser_maxido_perc' class='select2_sima' style='width:50px'>";
 for($iperc=0;$iperc<=60;$iperc++){
  echo "<option value='".$iperc."'>".$iperc."";
 }
echo "</select>";

echo "</tr>";

echo "<tr><td colspan=2 align=left><input id='admin_ujuser_submit' onclick='admin_ujuser()' type=submit value='Új user felvitele' class='submit2'></tr>";

echo "</table>";
echo "</div>";
}


function admin_userlist_keres(){
if(isset($_POST['ad']))$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['ad']=$_POST['ad'];
if(isset($_POST['nev']))$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['nev']=$_POST['nev'];
if(isset($_POST['tsz']))$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['tsz']=$_POST['tsz'];
if(isset($_POST['inaktiv']))$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['inaktiv']=$_POST['inaktiv'];
if(isset($_POST['szerv_id']))$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['szerv_id']=$_POST['szerv_id'];
if(isset($_POST['maxido']))$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['maxido']=$_POST['maxido'];
if(isset($_POST['jog']))$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=$_POST['jog'];
if(isset($_POST['kezd_date']))$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['kezd_date']=$_POST['kezd_date'];
if(isset($_POST['kezd_date_mod']))$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['kezd_date_mod']=$_POST['kezd_date_mod'];
if(isset($_POST['veg_date']))$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['veg_date']=$_POST['veg_date'];
if(isset($_POST['veg_date_mod']))$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['veg_date_mod']=$_POST['veg_date_mod'];
echo "ok$;$";
admin_uj_user_list();
}


function admin_uj_user_list_keres(){
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['ad']))and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['ad']!=""))
 $ker_ad=$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['ad'];
else $ker_ad="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['nev']!=""))
 $ker_nev=$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['nev'];
else $ker_nev="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['tsz']))and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['tsz']!=""))
 $ker_tsz=$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['tsz'];
else $ker_tsz="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['inaktiv']!=""))
 $ker_inaktiv=$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['inaktiv'];
else $ker_inaktiv="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['kezd_date']))and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['kezd_date']!=""))
 $kezd_date=$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['kezd_date'];
else $kezd_date="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['kezd_date_mod']))and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['kezd_date_mod']!=""))
 $kezd_date_mod=$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['kezd_date_mod'];
else $kezd_date_mod="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['veg_date']))and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['veg_date']!=""))
 $veg_date=$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['veg_date'];
else $veg_date="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['veg_date_mod']))and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['veg_date_mod']!=""))
 $veg_date_mod=$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['veg_date_mod'];
else $veg_date_mod="";

echo "<br><div style='overflow-x:auto'><b>Keresés</b> (Név keresés automatikusan *valami*-al történik)";

echo "<table id='admin_userlist_keres_table' class='table_emre'>";

echo "<tr>";
echo "<td>Név";
echo "<td colspan=3><input style='width:210px' onkeyup='admin_userlist_keres(\"tallep_elso\",\"\")' id='admin_userlist_keres_nev' value='".$ker_nev."' type='text' maxlength='255'>";
//echo "</tr>";

//echo "<tr>";
echo "<td>AD";
echo "<td><input onkeyup='admin_userlist_keres(\"tallep_elso\",\"\")' id='admin_userlist_keres_ad' value='".$ker_ad."' type=text style='width:100px'>";

echo "<td>Max rögzíthető óra";
echo "<td>";
echo "<select onchange='admin_userlist_keres_proc(\"tallep_elso\",\"\")' class='select3' id='admin_userlist_keres_maxido'>";
echo "<option value='all'>Összes";
echo "<option value='global'>Globális (".$GLOBALS['mira']['globalis_napi_ido_max_ora'].":00)";
for($maxido=$GLOBALS['mira']['napi_osszes_ido_min_ora'];$maxido<=$GLOBALS['tagv_alap_napi_napi_ido_max_ora'];$maxido++){
 //echo "<option value='".$maxido."'>".$maxido.":00";
 echo "<option value='".$maxido."'>".$maxido."";
}
echo "</select>";

//Rögzítés kezdete min
echo "<td>Rögzítés kezdete ";
echo "<td><input value='".$kezd_date."' onchange='admin_userlist_keres_proc(\"tallep_elso\",\"\")' id='admin_userlist_keres_kezd_date' class='date_tol' style='width:75px' type='text'>";
echo " <select onchange='admin_userlist_keres_proc(\"tallep_elso\",\"\")' id='admin_userlist_keres_kezd_date_mod' class='select3' style='width:85px'>";

echo "<option value='k'";
if($kezd_date_mod=='k') echo " selected";
echo ">Kisebb";

echo "<option value='n'";
if(($kezd_date_mod=='n')or($kezd_date_mod=='')) echo " selected";
echo ">Nagyobb";
echo "</select>";

echo "</tr>";

echo "<tr>";
echo "<td>Törzsszám";
echo "<td>";
echo "<input onkeyup='admin_userlist_keres(\"\",\"\")' id='admin_userlist_keres_tsz' value='".$ker_tsz."' style='width:67px' type='text' maxlength='8'>";

echo "<td>Inaktív";
echo "<td><select onchange='admin_userlist_keres_proc(\"tallep_elso\",\"\")' id='admin_userlist_keres_inaktiv' class='select3' style='width:80px'>
<option value=all>Minden";
if($ker_inaktiv=="0") $sel=" selected";
else $sel="";
echo "<option value=0".$sel.">Érvényes";
if($ker_inaktiv=="1") $sel=" selected";
else $sel="";
echo "<option value=1".$sel.">Inaktív";
echo "</select>";

echo "<td>Szervezet";
echo "<td>";
echo "<select onchange='admin_userlist_keres_proc(\"tallep_elso\",\"\")' id='admin_userlist_keres_szerv' class='select2_sima' style='width:200px'>
<option value=all>Összes";

//Minden esetben az összes jogosult szervezet.
$tomb_szervh=keres_akt_szerv_abc_uj_userhez();	

if((isset($tomb_szervh))and(is_array($tomb_szervh))){
 foreach($tomb_szervh as $ert){
	 if(
	 (isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['szerv_id']))
	 and
	 ($ert['szerv_id']==$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['szerv_id'])
	 ) $sel=" selected";
	 else $sel="";
	 echo "<option value='".$ert['szerv_id']."'".$sel.">".$ert['szerv_nev'];
 }
 }


echo "</select>";

echo "<td>Jogosultság";
echo "<td>";
echo "<select onchange='admin_userlist_keres_proc(\"tallep_elso\",\"\")' id='admin_userlist_keres_jog' class='select3' style='width:240px'>";

echo "<option value='all'";
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']))and
($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="all")
) echo " selected";
echo ">Összes";

echo "<option value='rogzites_igen'";
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']))and
($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="rogzites_igen")
) echo " selected";
echo ">Rögzítés jog - Igen";

echo "<option value='rogzites_nem'";
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']))and
($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="rogzites_nem")
) echo " selected";
echo ">Rögzítés jog - Nem";

echo "<option value='felettes_jo_van'";
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']))and
($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="felettes_jo_van")
) echo " selected";
echo ">Van felettes jóváhagyója";

echo "<option value='szerv_jovahagyo'";
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']))and
($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="szerv_jovahagyo")
) echo " selected";
echo ">Szervezeti jóváhagyó";

echo "<option value='felettes_jovahagyo'";
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']))and
($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="felettes_jovahagyo")
) echo " selected";
echo ">Felettes jóváhagyó";

echo "<option value='szerv_vagy_felettes_jovahagyo'";
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']))and
($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="szerv_vagy_felettes_jovahagyo")
) echo " selected";
echo ">Szervezeti vagy felettes jóváhagyó";

echo "<option value='jovahagy'";
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']))and
($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="jovahagy")
) echo " selected";
echo ">Jóváhagyó fül jogosultság - Igen";

echo "<option value='stat'";
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']))and
($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="stat")
) echo " selected";
echo ">Statisztika fül jogosultság - Igen";

echo "<option value='riport'";
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']))and
($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="riport")
) echo " selected";
echo ">Riport fül jogosultság - Igen";

echo "<option value='admin'";
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']))and
($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="admin")
) echo " selected";
echo ">Admin jogosultság - Igen";

echo "</select>";

//Rögzítés vége min
echo "<td>Rögzítés vége ";
echo "<td><input value='".$veg_date."' onchange='admin_userlist_keres(\"\",\"\")' id='admin_userlist_keres_veg_date' class='date_tol' style='width:75px' type='text'>";
echo " <select onchange='admin_userlist_keres_proc(\"tallep_elso\",\"\")' id='admin_userlist_keres_veg_date_mod' class='select3' style='width:85px'>";
echo "<option value='k'";
if(($veg_date_mod=='k')or($veg_date_mod=='')) echo " selected";
echo ">Kisebb";

echo "<option value='n'";
if($veg_date_mod=='n') echo " selected";
echo ">Nagyobb";
echo "</select>";

echo "</tr>";

echo "</table></div>";
}

function admin_uj_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_user_uj();
$th=0;

/*
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i==0){
 $th=$ert['tal'];
}}}
*/

if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo "<br><b>Meglévő jogok módosítása</b>";

echo '<div id="scroll1" style="overflow-x:auto;">';
echo '<div></div>';
echo '</div>';
echo '<div id="scroll2" style="overflow-x:auto;">';
echo '<table cellpadding="1" cellspacing="1" id="admin_userlist_table" class="table_emre">';
echo "<thead><tr>";

$order_mezo="mira_user.user_nev";
echo "<th style='width:200px' class='link' onclick='admin_userlist_keres_proc(\"order\",\"".$order_mezo."\")'>Név ";
echo tabl_nyilak('user_userlist_keres_order','user_userlist_keres_order_mod',$order_mezo);

$order_mezo="mira_user.user_ad";
echo "<th class='link' onclick='admin_userlist_keres_proc(\"order\",\"".$order_mezo."\")'>AD ";
echo tabl_nyilak('user_userlist_keres_order','user_userlist_keres_order_mod',$order_mezo);

$order_mezo="mira_user.user_email";
echo "<th class='link' onclick='admin_userlist_keres_proc(\"order\",\"".$order_mezo."\")'>Email ";
echo tabl_nyilak('user_userlist_keres_order','user_userlist_keres_order_mod',$order_mezo);

$order_mezo="mira_user.user_tsz";
echo "<th class='link' onclick='admin_userlist_keres_proc(\"order\",\"".$order_mezo."\")'>Törzsszám ";
echo tabl_nyilak('user_userlist_keres_order','user_userlist_keres_order_mod',$order_mezo);

$order_mezo="mira_user.ful_rogzit";
echo "<th nowrap align=center class='link' onclick='admin_userlist_keres_proc(\"order\",\"".$order_mezo."\")'>Rögzítési jog";
echo tabl_nyilak('user_userlist_keres_order','user_userlist_keres_order_mod',$order_mezo);

$order_mezo="mira_user.user_kezd_date";
echo "<th nowrap align=center class='link' onclick='admin_userlist_keres_proc(\"order\",\"".$order_mezo."\")'>Rögzítés kezdete";
echo tabl_nyilak('user_userlist_keres_order','user_userlist_keres_order_mod',$order_mezo);

$order_mezo="mira_user.user_veg_date";
echo "<th nowrap align=center class='link' onclick='admin_userlist_keres_proc(\"order\",\"".$order_mezo."\")'>Rögzítés vége";
echo tabl_nyilak('user_userlist_keres_order','user_userlist_keres_order_mod',$order_mezo);

$order_mezo="mira_szerv.szerv_nev";
echo "<th class='link' onclick='admin_userlist_keres_proc(\"order\",\"".$order_mezo."\")'>Szervezet ";
echo tabl_nyilak('user_userlist_keres_order','user_userlist_keres_order_mod',$order_mezo);

//echo "<th>Saját tevékenységek";
echo "<th>Tevékenységek";
//echo "<th>Összes tevékenység";

//echo "<th>Max rögzíthető";
$order_mezo="mira_user_ker_jog.user_napi_ido_max_ora";
echo "<th class='link' onclick='admin_userlist_keres_proc(\"order\",\"".$order_mezo."\")'>Max rögzíthető ";
echo tabl_nyilak('user_userlist_keres_order','user_userlist_keres_order_mod',$order_mezo);

echo "<th>Rögzítő helyettes";

echo "<th>Felettes jóváhagyója";

$order_mezo="mira_user.ful_jovahagy";
echo "<th class='link' onclick='admin_userlist_keres_proc(\"order\",\"".$order_mezo."\")'>Jóváhagyó fül ";
echo tabl_nyilak('user_userlist_keres_order','user_userlist_keres_order_mod',$order_mezo);

echo "<th>Szervezet jóváhagyó";//Jóváhagyás

echo "<th>Projekt jóváhagyó";

echo "<th>Jóváhagyó email értesítések";


$order_mezo="mira_user.ful_stat";
echo "<th style='text-align:left' class='link' onclick='admin_userlist_keres_proc(\"order\",\"".$order_mezo."\")'>Statisztika fül ";
echo tabl_nyilak('user_userlist_keres_order','user_userlist_keres_order_mod',$order_mezo);

$order_mezo="mira_user.ful_riport";
echo "<th style='text-align:left' class='link' onclick='admin_userlist_keres_proc(\"order\",\"".$order_mezo."\")'>Riport fül ";
echo tabl_nyilak('user_userlist_keres_order','user_userlist_keres_order_mod',$order_mezo);

$order_mezo="mira_user.ful_admin";
echo "<th class='link' onclick='admin_userlist_keres_proc(\"order\",\"".$order_mezo."\")'>Admin ";
echo tabl_nyilak('user_userlist_keres_order','user_userlist_keres_order_mod',$order_mezo);

echo "<th>Inaktív";

echo "</tr></thead><tbody>";

admin_uj_user_list_tal($tomb);

echo '</tbody></table>';
echo '</div>';
elozo_kovetkezo_gombok("admin_userlist_keres_proc",$th,$GLOBALS['mira']['user_jog']['user_userlist_keres_talszam'],$_POST['oldalholvagyok']);

//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['user_userlist_keres_talszam'],"admin_userlist_keres_proc","user_userlist_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='admin_userlist_keres_tal_oldalholvagyok'>";

if(is_array($tomb)){
//foreach($tomb as $i => $ert){
//if($i==0){
 //$th=$ert['tal'];
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['user_userlist_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='admin_userlist_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['user_userlist_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_userlist_keres_proc('tallep_elso','');</script>";
  }
 }
//}}
excel_export("admin_userlist_keres",$th);
}

}

function admin_uj_user_list_tal($tomb){

$tomb_user_projektszam=keres_user_hozzarend_projektszam($tomb);
$tomb_user_projektjovahagyoszam=keres_user_hozzarend_projektjovahagyoszam($tomb);
$tomb_user_jovahagyoszam=keres_user_hozzarend_jovahagyoszam($tomb);
$tomb_user_felettes_jovahagyoszam=keres_user_hozzarend_felettes_jovahagyoszam($tomb);
$tomb_user_helyettesszam=keres_user_hozzarend_helyettesszam($tomb);
$tomb_user_statszervszam=keres_user_hozzarend_statszervszam($tomb);
$tomb_user_statprojektszam=keres_user_hozzarend_statprojektszam($tomb);

$tomb_user_statriportszam=keres_user_hozzarend_statriportszam($tomb);
$tomb_szam_adminjog=keres_admin_user_szam_adminjog($tomb);

if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){

 echo "<tr title='".$ert['user_nev']."' class='ttooltip'>";
 echo "<td>";
 if($ert['user_inaktiv']==0)
  echo "<input type='text' style='width:200px' onkeyup='admin_moduser_ment(\"".$ert['user_ad']."\")' id='admin_ujmod_nev_".$ert['user_ad']."' value='".$ert['user_nev']."'>";
 else
  echo $ert['user_nev'];

 echo "<td align=center>";
 if($ert['user_inaktiv']==0)
  echo "<img style='width:16px;' onclick='admin_moduser_adupdate(\"".$ert['user_ad']."\")' id='admin_ujmod_ad_update_".$ert['user_ad']."_img' src='image/refresh.png' class='linknotip' title='Név és email cím aktuálizálása az AD-ból'>";
 
 echo " ";
 //AD módosítás egyenlőre volt: csak nekem //and($_SESSION[$GLOBALS['sessionname']]['login_ad']=="a2675")
 if($ert['user_inaktiv']==0){
  echo "<span onclick='admin_moduser_admod(\"".$ert['user_ad']."\")' class='link' title='AD azonosító módosítása'>".$ert['user_ad']."</span>";
 }else{//inaktív esetén nem módostuk semmit!
  echo $ert['user_ad'];
 }

 echo "<input value='".$ert['user_ad']."' id='admin_ujmod_ad_rejtett_".$ert['user_ad']."' type='hidden'>";
 if($ert['user_inaktiv']==0)
  echo " <img style='width:16px;' class='ad_info_img' title='<div id=\"ad_info_div\"></div>' onmouseover='ad_info_leker(\"admin_ujmod_ad_rejtett_".$ert['user_ad']."\")' onmouseout='ad_info_leker_kuka(\"admin_ujmod_ad_rejtett_".$ert['user_ad']."\")' id='admin_ujmod_ad_rejtett_".$ert['user_ad']."_info' src='image/info_18.png'>";

 echo "<td>";//class='disabled_auto_fill'
 if($ert['user_inaktiv']==0)
  echo "<input type='text' style='width:200px' onkeyup='admin_moduser_ment(\"".$ert['user_ad']."\")' id='admin_ujmod_email_".$ert['user_ad']."' value='".$ert['user_email']."'>";
 else
  echo $ert['user_email'];

 echo "<td>";
 if($ert['user_inaktiv']==0)
  echo "<input class='number' type='text' style='width:90px' onkeyup='admin_moduser_ment(\"".$ert['user_ad']."\")' id='admin_ujmod_tsz_".$ert['user_ad']."' maxlength='8' value='".$ert['user_tsz']."'>";
 else
  echo $ert['user_tsz'];

 //Rögzítés jog
 echo "<td align=center>";
 if($ert['ful_rogzit']==1)
  $rogzitjog_ck="checked";
 else
  $rogzitjog_ck="";
 echo "<input ".$rogzitjog_ck." onclick='admin_moduser_rogzitjog(\"".$ert['user_ad']."\")' class='link' type='checkbox' ".$ert['ful_rogzit']." id='admin_ujmod_rogzitjog_".$ert['user_ad']."'>";
 
 //Rögzítés kezdete
 if($ert['user_kezd_date']=="0000-00-00")$ert['user_kezd_date']="";
 echo "<td>";
 if(($ert['user_inaktiv']==0)and($ert['rogziztett']==0)and($ert['ful_rogzit']==1))
   echo '<input class="date_tol" type="text" style="width:75px" onkeydown="return admin_moduser_kezd_date_delete(\''.$ert["user_ad"].'\')" onchange="admin_moduser_ment(\''.$ert["user_ad"].'\')" id="admin_ujmod_kezd_date_'.$ert["user_ad"].'" value="'.$ert["user_kezd_date"].'">';
 elseif($ert['ful_rogzit']==1)//Ha nincs rögzítési jog, akkor ne legyen itt semmi
  echo kidate_format_ev($ert['user_kezd_date']);
 
 //Rögzítés vége
 if($ert['user_veg_date']=="0000-00-00")$ert['user_veg_date']="";
 echo "<td>";
 if(($ert['user_inaktiv']==0)and($ert['ful_rogzit']==1)){
 echo '<input class="date_tol" type="text" style="width:75px" onkeydown="return admin_moduser_veg_date_delete(\''.$ert["user_ad"].'\')" onchange="admin_moduser_ment(\''.$ert["user_ad"].'\');admin_moduser_veg_date_chenge_update_list(\''.$ert["user_ad"].'\')" id="admin_ujmod_veg_date_'.$ert["user_ad"].'" value="'.$ert["user_veg_date"].'">';
 if($ert['user_veg_date']!="") 
  echo ' <img style="width:16px" onclick="admin_moduser_veg_date_delete_rogzitett(\''.$ert["user_ad"].'\')" title="Rögzítés vége után rögzített adatok törlése" id="admin_ujmod_veg_date_img_'.$ert["user_ad"].'" src="image/del.png" class="link">';
 }elseif($ert['ful_rogzit']==1){
	echo kidate_format_ev($ert['user_veg_date']); 
 }
 
 //Szervezetek
 echo "<td>";
 if($ert['szerv_inaktiv']==1){
  $user_szerv_str="Inaktív szervezet: ";
  $user_szerv_class="link_pir_vas";
 }else{
  $user_szerv_str="";
  $user_szerv_class="link";
 }
 echo "<span class='".$user_szerv_class."' onclick='admin_mod_user_szerv_katt(\"".$ert['user_ad']."\",\"".$ert['user_nev']."\")'>".$user_szerv_str.$ert['szerv_nev']."</span>";
 
 //Felhasználóhoz rendelt pojktek
 echo "<td align=center>";
 if($ert['user_inaktiv']==0){
  if((isset($tomb_user_projektszam[$ert['user_ad']]))and($tomb_user_projektszam[$ert['user_ad']]!=""))
   $user_projektszam=$tomb_user_projektszam[$ert['user_ad']];
  else{
   $user_projektszam="0";	
  }
  echo "<span onclick='admin_mod_userprojekt_proj_katt(\"".$ert['user_ad']."\",\"".$ert['user_nev']."\")' class='link'>".$user_projektszam."</span>";
 }

//Max rögzíthető 
 echo "<td>";
 if($ert['user_inaktiv']==1){
	  $maxido_dis=" disabled";
 }else{
	 $maxido_dis="";
 }
echo "Óra:<select".$maxido_dis." id='admin_moduser_maxido_".$ert['user_ad']."' onchange='admin_mod_user_maxido_change(\"".$ert['user_ad']."\")' class='select3' style='width:130px'>";

echo "<option value='global'";
if(($ert['user_napi_ido_max_ora']=='0')and($ert['user_napi_ido_max_perc']=='0')){
 echo ' selected';
}
echo ">Globális (".$GLOBALS['mira']['globalis_napi_ido_max_ora'].":00)";

//for($maxido=$GLOBALS['mira']['napi_osszes_ido_min_ora'];$maxido<=24;$maxido++){
for($maxido=$GLOBALS['mira']['napi_osszes_ido_min_ora'];$maxido<=$GLOBALS['tagv_alap_napi_napi_ido_max_ora'];$maxido++){
 if(
  (($maxido==$ert['user_napi_ido_max_ora'])and($maxido!='0'))
  or
  (
   ($maxido=='0')and($ert['user_napi_ido_max_perc']!='0')
  )
  )
  $maxidosel=" selected";
 else
  $maxidosel="";
 //echo "<option value='".$maxido."'".$maxidosel.">".$maxido.":00";
 echo "<option value='".$maxido."'".$maxidosel.">".$maxido."";
}
echo "</select>";
echo " Perc:";
echo "<select".$maxido_dis;
if(($ert['user_napi_ido_max_ora']=='0')and($ert['user_napi_ido_max_perc']=='0')){
	 echo " disabled";
}
echo " id='admin_moduser_maxidoperc_".$ert['user_ad']."' onchange='admin_mod_user_maxido_change(\"".$ert['user_ad']."\")' class='select2_sima' style='width:50px'>";
 for($iperc=0;$iperc<=60;$iperc++){
  echo "<option value='".$iperc."'";
  if($iperc==$ert['user_napi_ido_max_perc'])
	   echo ' selected';
  echo ">".$iperc."";
 }
echo "</select>";

//Helyettes - eleje
echo "<td align=center>";
 if($ert['user_inaktiv']==0){
  if((isset($tomb_user_helyettesszam[$ert['user_ad']]))and($tomb_user_helyettesszam[$ert['user_ad']]!=""))
   $user_helyettesszam=$tomb_user_helyettesszam[$ert['user_ad']];
  else{
   $user_helyettesszam="0";	
  }
  echo "<span onclick='admin_rogzito_helyettes_beallit(\"".$ert['user_ad']."\")' class='link'>".$user_helyettesszam."</span>";
 }
//Helyettes - vége

//Felettes jóváhagyója - eleje
 echo "<td align=center>";
  if($ert['user_inaktiv']==0){
  if((isset($tomb_user_felettes_jovahagyoszam[$ert['user_ad']]))and($tomb_user_felettes_jovahagyoszam[$ert['user_ad']]!=""))
   $user_felettes_jovahagyoszam=$tomb_user_felettes_jovahagyoszam[$ert['user_ad']];
  else{
   $user_felettes_jovahagyoszam="0";	
  }
  echo "<span onclick='admin_mod_userfelettesjovahagyas_proj_katt(\"".$ert['user_ad']."\",\"".$ert['user_nev']."\")' class='link'>".$user_felettes_jovahagyoszam."</span>";
 }
//Felettes jóváhagyója - vége

 //Jóváhagyó fül
 echo "<td align=center>";
   if($ert['user_inaktiv']==1){
	$jovaful_span_hidden=" style='display:none'";
  }else{
	$jovaful_span_hidden="";
  }
 echo "<span".$jovaful_span_hidden.">";
 if($ert['ful_jovahagy']==1){
  $postck="checked";
  $jovahagy_span=" style='display:inline'";
 }else{
  $postck="";
  $jovahagy_span=" style='display:none'";
 }
 echo "<input ".$postck." onclick='admin_moduser_jovahagy(\"".$ert['user_ad']."\")' class='link' type='checkbox' id='admin_ujmod_jovahagy_".$ert['user_ad']."'>";
echo "</span>";

//Szervezet jóváhagyó - eleje
 echo "<td align=center>";
 if($ert['user_inaktiv']==0){
  if((isset($tomb_user_jovahagyoszam[$ert['user_ad']]))and($tomb_user_jovahagyoszam[$ert['user_ad']]!=""))
   $user_jovahagyoszam=$tomb_user_jovahagyoszam[$ert['user_ad']];
  else{
   $user_jovahagyoszam="0";	
  }
  echo "<span".$jovahagy_span." onclick='admin_mod_userjovahagyas_proj_katt(\"".$ert['user_ad']."\",\"".$ert['user_nev']."\")' id='admin_mod_userjovahagyas_proj_katt_span_".$ert['user_ad']."' class='link'>".$user_jovahagyoszam."</span>";
 }
//Szervezet jóváhagyó - vége


 //Projekt jóváhagyó - eleje
  echo "<td align=center>";
  if($ert['user_inaktiv']==0){
  if((isset($tomb_user_projektjovahagyoszam[$ert['user_ad']]))and($tomb_user_projektjovahagyoszam[$ert['user_ad']]!=""))
   $user_projektjovahagyoszam=$tomb_user_projektjovahagyoszam[$ert['user_ad']];
  else{
   $user_projektjovahagyoszam="0";	
  }
  echo "<span".$jovahagy_span." onclick='admin_mod_userprojektjovahagyo_proj_katt(\"".$ert['user_ad']."\",\"".$ert['user_nev']."\")' id='admin_mod_userprojektjovahagyo_proj_katt_span_".$ert['user_ad']."' class='link'>".$user_projektjovahagyoszam."</span>";
 }
 //Projekt jóváhagyó - eleje
 
 //Jóváhagyó email értesítések - eleje
 echo "<td align=center>";
 if($ert['ful_jovahagy']==1){
  echo "<span".$jovahagy_span." onclick='admin_mod_useremailbe_katt(\"".$ert['user_ad']."\",\"".$ert['user_nev']."\")' id='admin_mod_useremailbe_katt_span_".$ert['user_ad']."' class='link'>Email beállítások<span>";
 }
 //Jóváhagyó email értesítések - vége
 
 //Statisztika  fül - eleje
 echo "<td>";//align=center
  if($ert['user_inaktiv']==1){
	$stat_span_hidden=" style='display:none'";
  }else{
	$stat_span_hidden="";
  }
 echo "<span".$stat_span_hidden.">";
 if($ert['ful_stat']==1) $postck="checked";
  else $postck="";
 echo "<input ".$postck." onclick='admin_moduser_stat(\"".$ert['user_ad']."\")' class='link' type='checkbox' id='admin_ujmod_stat_".$ert['user_ad']."'>";
 
 if($ert['ful_stat']==1) $statjoglat="";
 else $statjoglat=" style='display:none'";
 
 if(($ert['ful_stat_all']==0)and(!isset($tomb_user_statszervszam[$ert['user_ad']])))
  $stat_css='link_pir_vas';
 elseif(($ert['ful_stat_projekt_all']==0)and(!isset($tomb_user_statprojektszam[$ert['user_ad']])))
  $stat_css='link_pir_vas';
 else $stat_css='link';
 echo "<span onclick='admin_moduser_stat_szervjogspan(\"".$ert['user_ad']."\",\"".$ert['user_nev']."\")' id='admin_ujmod_stat_szervjogspan_".$ert['user_ad']."' class='".$stat_css."'".$statjoglat.">";
 if(($ert['ful_stat_all']==1)or($ert['ful_stat_projekt_all']==1))
  echo " Jog: ";
 
 if(($ert['ful_stat_all']==1)and($ert['ful_stat_projekt_all']==1)){
  echo "teljes";
 }elseif(($ert['ful_stat_all']==0)and($ert['ful_stat_projekt_all']==1)){
  if(isset($tomb_user_statszervszam[$ert['user_ad']]))
   echo $tomb_user_statszervszam[$ert['user_ad']];
  else echo "0";
  echo " szervezet";
 }elseif(($ert['ful_stat_projekt_all']==0)and($ert['ful_stat_all']==1)){
  if(isset($tomb_user_statprojektszam[$ert['user_ad']]))
   echo $tomb_user_statprojektszam[$ert['user_ad']];
  else echo "0";
  echo " tevékenység";	 
 }
 echo "</span>";
 echo "</span>";
 //Statisztika aljog - vége
 
 //Statisztika  fül - vége
 
 //Riport fül - eleje
 echo "<td>";
 if($ert['user_inaktiv']==0){
	  if($ert['ful_riport']==1){
		  $riportck=' checked';
	  }else{
		  $riportck='';
	  }
  echo "<input ".$riportck." onclick='admin_moduser_riport(\"".$ert['user_ad']."\")' class='link' type='checkbox' id='admin_ujmod_tervstat_".$ert['user_ad']."'>";
  
  if($ert['ful_riport']==1) $riportjoglat="";
  else $riportjoglat=" style='display:none'";
  
  if(($ert['ful_riport_all']==0)and(!isset($tomb_user_statriportszam[$ert['user_ad']])))
   $stat_css='link_pir_vas';
  else $stat_css='link';
  
  echo "<span onclick='admin_moduser_riport_tipusjogspan(\"".$ert['user_ad']."\",\"".$ert['user_nev']."\")' id='admin_ujmod_riport_tipusjogspan_' class='".$stat_css."'".$riportjoglat.">";
   echo ' Jog: ';
   if($ert['ful_riport_all']==1){
	echo 'teljes';
   }else{
	    
		if(isset($tomb_user_statriportszam[$ert['user_ad']]))
		 echo $tomb_user_statriportszam[$ert['user_ad']];
		else echo "0";
		 echo " típus";
   }
   
  echo '</span>';
 }
 //Riport  fül - vége
 
 //admin  fül
 echo "<td>";
 if($ert['user_inaktiv']==0){
  //echo igennem_kod_ki($ert['ful_admin']);
 if($ert['ful_admin_all']=='1'){//Teljes admin jog, tud változtatni
  echo 'Rendszer admin';
 }else{

  if($GLOBALS[$GLOBALS['sessionname']]['ful_admin_all']==0){//Ekkor csak a számot látja.
   if($ert['ful_admin']=='1'){
	  if(isset($tomb_szam_adminjog[$ert['user_ad']]))
		$admin_jogszam=$tomb_szam_adminjog[$ert['user_ad']];
	  else $admin_jogszam=0;
	  
	  echo $admin_jogszam.' jog';
   } 
  }else{//Ha tud rajta módosítani is...
  if($ert['ful_admin']=='1') $ck=' checked';
   else $ck='';
   echo '<input'.$ck.' title="'.$ert['user_nev'].'" class="linkm_tooltip" onchange="admin_moduser_adminjog_ment(\''.$ert["user_ad"].'\')" id="admin_user_jogadmin_jog_ck_'.$ert["user_ad"].'" type="checkbox">';
  
   if($ert['ful_admin']=='1'){
    if(isset($tomb_szam_adminjog[$ert['user_ad']]))
     $admin_jogszam=$tomb_szam_adminjog[$ert['user_ad']];
    else $admin_jogszam=0;
    if($admin_jogszam==0)$css_admin='link_pir';
    else $css_admin='link';
    echo '<span title="'.$ert['user_nev'].'" onclick="admin_moduser_adminjog_fuljog_ment(\''.$ert["user_ad"].'\')" class="'.$css_admin.'">'.$admin_jogszam.' jog</span>';
   }  
  }

 }
 }

 //Inaktív
 echo "<td align=center>";
 if($ert['user_inaktiv']==1){
	$postck="checked";
	$in_nev=$ert['user_nev'];
 }else{
	  $postck="";
	  $in_nev="";
 }
 echo "<input ".$postck." onclick='admin_moduser_inaktiv(\"".$ert['user_ad']."\",\"".$in_nev."\")' class='link' type='checkbox' id='admin_ujmod_inaktiv_".$ert['user_ad']."'>";


echo "</tr>";
}
}
}
}

function admin_uj_user_ment(){
if((!isset($_POST['ad']))or((isset($_POST['ad']))and(($_POST['ad']=="")or(strlen($_POST['ad'])<4)))){
 echo "nook$;$"."AD azonosító megadása kötelező!";
 //Hossz ha nem jó, más kiírás kellene... Feladat
 exit;
}
//1.1 NÉV:
if((!isset($_POST['nev']))or(
(isset($_POST['nev'])and($_POST['nev']==""))
)){
 echo "nook$;$"."NÉV megadása kötelező!";
 exit;
}
//1.2 Email
if((!isset($_POST['email']))or(
(isset($_POST['email'])and($_POST['email']==""))
)){
 echo "nook$;$"."Email cím megadása kötelező!";
 exit;
}
//1.3 TSZ
if((!isset($_POST['tsz']))or(
(isset($_POST['tsz'])and($_POST['tsz']==""))
)){
 echo "nook$;$"."Törzsszám megadása kötelező!";
 exit;
}
//1.4 TSZ
if((!isset($_POST['szerv_id']))or(
(isset($_POST['szerv_id'])and($_POST['szerv_id']=="keremv"))
)){
 echo "nook$;$"."Szervezet kiválasztása kötelező!";
 exit;
}

//1.5 AD azonosító SPACE nem tartalmazhat
if((isset($_POST['ad']))and(strstr($_POST['ad']," "))){
 echo "nook$;$"."AD azonosító szóközt nem tartalmazhat!";
 exit;
}

//2: Van-e Ilyen user
$usvane=keres_mit1_mit1("mira_user","user_ad",$_POST['ad'],"user_ad");
if(is_array($usvane)){
	echo "Hiba! Van már ilyen felhasználó!";
	exit;
}

$kezd_ho_menthez=substr($_POST['kezd_date'],0,7);
//$tomb_lezart_e=keres_mit2_mit1_csak_ertek("mira_tagv_lezart_honap","tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"tagv_lezart_honap",$kezd_ho_menthez,"tagv_lezart_honap_id");
$tomb_lezart_e=keres_mit1_mit1_csak_ertek("mira_tagv_lezart_honap","tagv_lezart_honap",$kezd_ho_menthez,"tagv_lezart_honap_id");

if($tomb_lezart_e!=""){
	echo "nook$;$";
	echo "Hiba! ".str_replace("-",".",$kezd_ho_menthez)." hónap már lezárásra került!";
	exit;
}else{//Nincs, bevitel mehet!
mysqli_autocommit($GLOBALS['mysqli'],false);

$tmp_bk[0]=array();
$tmp_bk[0]['user_ad']=mb_strtolower($_POST['ad']);
$tmp_bk[0]['user_tagv']=$GLOBALS[$GLOBALS['sessionname']]['tagv'];
$tmp_bk[0]['user_nev']=trim($_POST['nev']);
$tmp_bk[0]['user_tsz']=$_POST['tsz'];
$tmp_bk[0]['user_email']=$_POST['email'];
$tmp_bk[0]['szerv_id']=$_POST['szerv_id'];

if($_POST['kezd_date']!="")
 $tmp_bk[0]['user_kezd_date']=$_POST['kezd_date'];
be_visz_insert("mira_user",$tmp_bk);

 //Új tábla bevitele
 $tmp_bk_ker_def[0]=array();
 $tmp_bk_ker_def[0]['user_ad']=mb_strtolower($_POST['ad']);
 //Max idő lementése
 if(
 (isset($_POST['maxido']))and
 ($_POST['maxido']!="")
 ){
  if($_POST['maxido']=='global'){
	  $_POST['maxido']='0';
	  $tmp_bk_ker_def[0]['user_napi_ido_max_perc']='0';
  }elseif(isset($_POST['maxperc'])){
	  $tmp_bk_ker_def[0]['user_napi_ido_max_perc']=$_POST['maxperc'];
  }
  $tmp_bk_ker_def[0]['user_napi_ido_max_ora']=$_POST['maxido'];
  
 }
 be_visz_insert("mira_user_ker_jog",$tmp_bk_ker_def);


echo "ok$;$";
mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);
}

}

function admin_moduser_admod_proc_kuld(){
if(
(isset($_POST['ad']))and
(isset($_POST['ujad']))and
($_POST['ujad']!="")and
($_POST['ad']!="")
){

//Új ad ne legyen még senkinek se
$ujad_van_nev=keres_mit1_mit1_csak_ertek("mira_user",'user_ad',$_POST['ujad'],'user_nev');
if($ujad_van_nev!=""){
 echo "ujadvan$;$".$ujad_van_nev;
 exit;
}

mysqli_autocommit($GLOBALS['mysqli'],false);
$_POST['ujad']=mb_strtolower($_POST['ujad']);
//1 mira_user és kapcsolód táblák
	$tmp_mod=array();
	$tmp_mod[0]['user_ad']=$_POST['ujad'];
	mod_egy_fel_tom('mira_user',$tmp_mod[0],'user_ad',$_POST['ad']);	

//2 rogzit_ho - ellenorzesre_lezarva_jovahagyo_ki
	$tmp_mod=array();
	$tmp_mod[0]['ellenorzesre_lezarva_jovahagyo_ki']=$_POST['ujad'];
	mod_egy_fel_tom('rogzit_ho',$tmp_mod[0],'ellenorzesre_lezarva_jovahagyo_ki',$_POST['ad']);	

//3 rogzit_ho - ellenorzesre_visszakuldve_ki 
	$tmp_mod=array();
	$tmp_mod[0]['ellenorzesre_visszakuldve_ki']=$_POST['ujad'];
	mod_egy_fel_tom('rogzit_ho',$tmp_mod[0],'ellenorzesre_visszakuldve_ki',$_POST['ad']);	

//4 rogzit_ho - ellenorzesre_ok_ki
	$tmp_mod=array();
	$tmp_mod[0]['ellenorzesre_ok_ki']=$_POST['ujad'];
	mod_egy_fel_tom('rogzit_ho',$tmp_mod[0],'ellenorzesre_ok_ki',$_POST['ad']);	

//5 rogzit_ho_projekt - projekt_jovahagyo_jovahagyva_ki
	$tmp_mod=array();
	$tmp_mod[0]['projekt_jovahagyo_jovahagyva_ki']=$_POST['ujad'];
	mod_egy_fel_tom('rogzit_ho_projekt',$tmp_mod[0],'projekt_jovahagyo_jovahagyva_ki',$_POST['ad']);	

//6 rogzit_ho_projekt - projekt_jovahagyo_elutasitva_ki 
	$tmp_mod=array();
	$tmp_mod[0]['projekt_jovahagyo_elutasitva_ki']=$_POST['ujad'];
	mod_egy_fel_tom('rogzit_ho_projekt',$tmp_mod[0],'projekt_jovahagyo_elutasitva_ki',$_POST['ad']);	

//7 rogzit_ho_stat - ellenorzesre_lezarva_jovahagyo_ki
	$tmp_mod=array();
	$tmp_mod[0]['ellenorzesre_lezarva_jovahagyo_ki']=$_POST['ujad'];
	mod_egy_fel_tom('rogzit_ho_stat',$tmp_mod[0],'ellenorzesre_lezarva_jovahagyo_ki',$_POST['ad']);	

//8 rogzit_ho_stat - ellenorzesre_visszakuldve_ki
	$tmp_mod=array();
	$tmp_mod[0]['ellenorzesre_visszakuldve_ki']=$_POST['ujad'];
	mod_egy_fel_tom('rogzit_ho_stat',$tmp_mod[0],'ellenorzesre_visszakuldve_ki',$_POST['ad']);	

//8 rogzit_ho_stat - ellenorzesre_ok_ki
	$tmp_mod=array();
	$tmp_mod[0]['ellenorzesre_ok_ki']=$_POST['ujad'];
	mod_egy_fel_tom('rogzit_ho_stat',$tmp_mod[0],'ellenorzesre_ok_ki',$_POST['ad']);	

//9 rogzit_sor - helyettes_rogzito_ki
	$tmp_mod=array();
	$tmp_mod[0]['helyettes_rogzito_ki']=$_POST['ujad'];
	mod_egy_fel_tom('rogzit_sor',$tmp_mod[0],'helyettes_rogzito_ki',$_POST['ad']);	

mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);
echo "ok$;$";	
}else{
 echo "Adathiány";
}
}

function admin_moduser_veg_date_delete_rogzitett_proc(){
//Rögzítése vége dátum miatti rögzített tevékenység törlése
if(
(isset($_POST['ad']))and
(isset($_POST['user_veg_date']))and
($_POST['ad']!="")and
($_POST['user_veg_date']!="")and
(mb_strlen($_POST['user_veg_date'])==10)
){
 //1: Megnézzük, hogy az adott hónapnál vagy későbbieknél van-e lezárt hónapja, ha igen, akkor nem engedjük meg! 
 $ho=substr($_POST['user_veg_date'],0,7);
 $tomb_lezart=keres_admin_veghoutan_vane_lezathonap($_POST['ad'],$ho);
 if(!is_array($tomb_lezart)){//Ekkor ok, mehet a törlés
	 torles_admin_user_veg_date_utanni_all($_POST['ad'],$_POST['user_veg_date']);
	 echo "ok$;$";
 }else{//Ekkor egyszer már legalább lezárt egy ezt vagy ennél nagyobb hónapot, állj!
	//Vége hónap törlése
	$tmp_mod[0]['user_veg_date']="0000-00-00";
	mod_egy_fel_tom('mira_user',$tmp_mod[0],'user_ad',$_POST['ad']);	
	echo "vanlezarthonap$;$";
 }
}else{
 echo "Hiányzó adatok!";
}
}

function admin_mod_user_ment(){
$tmp_mod[0]['user_nev']=$_POST['nev'];
$tmp_mod[0]['user_email']=$_POST['email'];
$tmp_mod[0]['user_tsz']=$_POST['tsz'];

//Kezdeti dátum ellenőrzése, hogy le van-e zárva ez a hónap.

if(($_POST['user_kezd_date']!='')and($_POST['user_kezd_date']!=keres_mit1_mit1_csak_ertek("mira_user","user_ad",$_POST['ad'],"user_kezd_date"))){
$kezd_ho_menthez=substr($_POST['user_kezd_date'],0,7);
//$tomb_lezart_e=keres_mit2_mit1_csak_ertek("mira_tagv_lezart_honap","tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"tagv_lezart_honap",$kezd_ho_menthez,"tagv_lezart_honap_id");
$tomb_lezart_e=keres_mit1_mit1_csak_ertek("mira_tagv_lezart_honap","tagv_lezart_honap",$kezd_ho_menthez,"tagv_lezart_honap_id");

if($tomb_lezart_e!=""){
	echo "nook$;$";
	echo "Hiba! ".str_replace("-",".",$kezd_ho_menthez)." hónap már lezárásra került!";
	exit;
}

}

//Csak akkor legyen módosítva a kezdeti dátum, ha ennek a usernek nincs semmi se rögzítve!
//Ha van, akkor figyelmen kívül lesz hagyva
if(keres_user_vane_rogzitve($_POST['ad'])=='0'){
 if($_POST['user_kezd_date']!="")
  $tmp_mod[0]['user_kezd_date']=str_replace(".","-",$_POST['user_kezd_date']);
 else
  $tmp_mod[0]['user_kezd_date']="0000-00-00";
}

if($_POST['user_veg_date']!="")
 $tmp_mod[0]['user_veg_date']=str_replace(".","-",$_POST['user_veg_date']);
else
 $tmp_mod[0]['user_veg_date']="0000-00-00";

/*
echo '<pre>';
print_r($tmp_mod);
echo '</pre>';
*/

mod_egy_fel_tom('mira_user',$tmp_mod[0],'user_ad',$_POST['ad']);	
echo "ok$;$";
}

function admin_moduser_inaktiv(){
if((isset($_POST['user_inaktiv']))and(
($_POST['user_inaktiv']==0)or
($_POST['user_inaktiv']==1)
)){

 if($_POST['user_inaktiv']==1){//Csak inaktíválás esetén!
 $tomb_utolso_e=keres_user_utolso_szerv_jovhagyo_e($_POST['ad']);
 $tomb_projekt_vane=keres_user_projekt_jovhagyo_e($_POST['ad']);
 if((is_array($tomb_utolso_e))or(is_array($tomb_projekt_vane))){
	$user_nev=keres_mit1_mit1_csak_ertek("mira_user","user_ad",$_POST['ad'],"user_nev");
	echo "okutolso$;$"; 
	echo "<b>Hiba!</b><br><br>";
	if(is_array($tomb_utolso_e)){
	 echo "<b>".$user_nev." nem inaktiválható, mert az alábbi ";
	 if(sizeof($tomb_utolso_e)=='1')
	  echo "szervezetnél ";
	 else
	  echo "szervezeteknél ";
	 echo "Ő az egyetlen jóváhagyó!</b>";
	 echo '<ul>';
	 foreach($tomb_utolso_e as $szerv_nev){
	  echo '<li>'.$szerv_nev;
	 }
	 echo '</ul>';
	}
	
	if(is_array($tomb_projekt_vane)){
	 echo "<b>".$user_nev." nem inaktiválható, mert az alábbi ";
	 if(sizeof($tomb_projekt_vane)=='1')
	  echo "tevékenységnél ";
	 else
	  echo "tevékenységeknél ";
	 echo "Ő projekt jóváhagyó!</b>";
	 echo '<ul>';
	 foreach($tomb_projekt_vane as $projekt_nev){
	  echo '<li>'.$projekt_nev;
	 }
	 echo '</ul>';
	}
	
	
	exit;
 }
 
 $szerv_mod_lehete=keres_user_van_nyitott_ho($_POST['ad']);
	if(is_array($szerv_mod_lehete)){
	 echo "noinaktiv_vanrog$;$";
	 echo "<b>Inaktiválás nem lehetséges!</b>";
	 echo "<br><br>";
	 
	 echo "Felhasználónak van már megkezdett tevékenység rögzítése az alábbi ";
	 if(sizeof($szerv_mod_lehete)==1)
	  echo "hónapra:";
	 else
	  echo "hónapokra:";
	 echo "<ul>";
	 foreach($szerv_mod_lehete as $ert){
		 echo "<li><b>".$ert['rogzit_ho']."</b> ";
		 if($ert['ellenorzesre_lezarva']==0) echo "Nincs lezárva";
		 elseif($ert['ellenorzesre_ok']==0) echo "Nincs jóváhagyva";
	 }
	 echo "</ul>";
	 exit;
	}
 }

 $tmp_mod[0]['user_inaktiv']=$_POST['user_inaktiv'];
 if(
 (isset($_POST['uj_rog_nap']))and($_POST['uj_rog_nap']!="")
 ){
  $tmp_mod[0]['user_kezd_date']=$_POST['uj_rog_nap'];
  $tmp_mod[0]['user_veg_date']="0000-00-00";
 }
 mod_egy_fel_tom('mira_user',$tmp_mod[0],'user_ad',$_POST['ad']);
 
 //mira_user_ker_jog nullázása...
 if($_POST['user_inaktiv']==0){
  $tmp_user_def=array();
  $tmp_user_def[0]['user_ad']=$_POST['ad'];
  $maxora=keres_mit1_mit1_csak_ertek('mira_user_ker_jog','user_ad',$_POST['ad'],"user_napi_ido_max_ora");
  if($maxora!="")
   $tmp_user_def[0]['user_napi_ido_max_ora']=$maxora;
  be_visz_replace("mira_user_ker_jog",$tmp_user_def);	 
 }
 
 //if($_POST['user_inaktiv']==0){
 //Felhasználó inaktiválásakor minden felettes jóváhagyója törlésre kerül.
 torles("mira_user_felettes_jovahagyo","user_ad",$_POST['ad']);
 torles("mira_user_felettes_jovahagyo","user_ad_felettes_jovahagyo",$_POST['ad']);
 //}
 
 echo "ok$;$";	
}
}

function admin_moduser_rogzitjog(){
if(
(isset($_POST['ad']))and
($_POST['ad']!="")and
(isset($_POST['ful_rogzit']))and
(
($_POST['ful_rogzit']==0)or
($_POST['ful_rogzit']==1)
)){
 
 //Van-e rögzített hónap, ha el akarjuk venni a rögzítési jogot
 if($_POST['ful_rogzit']==0){
 if(keres_user_vane_rogzitve($_POST['ad'])!=0){
  echo "nook$;$";
  echo "Hiba!<br><br>Rögzítési jog törlése nem lehetséges, mert van már rögzített adata a felhasználónak!";
  exit;
 }
 }
 
 //User minden rögzítő helyettesítése törlésre kerül
 torles("mira_user_helyettes","user_ad_helyettes",$_POST['ad']);
 
 $tmp_mod[0]['ful_rogzit']=$_POST['ful_rogzit'];
 mod_egy_fel_tom('mira_user',$tmp_mod[0],'user_ad',$_POST['ad']);	
 echo "ok$;$";	
}
}

function admin_moduser_jovahagy(){
if(
(isset($_POST['ad']))and
($_POST['ad']!="")and
(isset($_POST['user_jovahagy']))and(
($_POST['user_jovahagy']==0)or
($_POST['user_jovahagy']==1)
)){
 $tmp_mod[0]['ful_jovahagy']=$_POST['user_jovahagy'];
 mod_egy_fel_tom('mira_user',$tmp_mod[0],'user_ad',$_POST['ad']);	
 echo "ok$;$";	
}
}

function admin_moduser_riport(){
if(
(isset($_POST['ad']))and($_POST['ad']!="")and
(isset($_POST['user_riport']))and(
($_POST['user_riport']==0)or
($_POST['user_riport']==1)
)){
 $tmp_mod[0]['ful_riport']=$_POST['user_riport'];
 //$tmp_mod[0]['ful_riport_all']=$_POST['user_riport'];
 $tmp_mod[0]['ful_riport_all']=0;
 mod_egy_fel_tom('mira_user',$tmp_mod[0],'user_ad',$_POST['ad']);
 echo "ok$;$";	
}
}

function admin_moduser_riport_tipusjogspan_szerzjog_katt_all(){
if(
(isset($_POST['user_ad']))and($_POST['user_ad']!="")and
(isset($_POST['mit']))and(
($_POST['mit']=='0')or
($_POST['mit']=='1')
)){
 $tmp_mod[0]['ful_riport_szerz_csop_all']=$_POST['mit'];
 mod_egy_fel_tom('mira_user',$tmp_mod[0],'user_ad',$_POST['user_ad']);
 
 if($_POST['mit']=='1'){
  torles("mira_user_riport_szerz",'user_ad',$_POST['user_ad']);
 }
 
 echo "ok$;$";
}else{
 echo 'adathiány';
}
}

function admin_moduser_riport_tipusjogspan_teny3_1_1_szervcsopjog_katt(){
if(
(isset($_POST['user_ad']))and($_POST['user_ad']!="")and
(isset($_POST['mira_szerv_csoport_id']))and($_POST['mira_szerv_csoport_id']!="")and
(isset($_POST['mit']))and(
($_POST['mit']=='0')or
($_POST['mit']=='1')
)){

if($_POST['mit']=='1'){//bepipálás
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['mira_szerv_csoport_id']=$_POST['mira_szerv_csoport_id'];
  be_visz_replace("mira_user_riport_311_szervcsop",$tmp_bk_ker_def);
}else{//Kipipálás
 torles2("mira_user_riport_311_szervcsop",'user_ad',$_POST['user_ad'],'mira_szerv_csoport_id',$_POST['mira_szerv_csoport_id']);
}

 echo 'ok$;$';
}else{
 echo 'adathiány';
}

}

function admin_moduser_riport_tipusjogspan_szerzjog_katt(){
if(
(isset($_POST['user_ad']))and($_POST['user_ad']!="")and
(isset($_POST['szerz_csop_id']))and($_POST['szerz_csop_id']!="")and
(isset($_POST['mit']))and(
($_POST['mit']=='0')or
($_POST['mit']=='1')
)){

if($_POST['mit']=='1'){//bepipálás
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['szerz_csop_id']=$_POST['szerz_csop_id'];
  be_visz_replace("mira_user_riport_szerz",$tmp_bk_ker_def);
}else{//Kipipálás
 torles2("mira_user_riport_szerz",'user_ad',$_POST['user_ad'],'szerz_csop_id',$_POST['szerz_csop_id']);
}
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_moduser_riport_tipusjogspan(){
echo 'ok$;$';
echo 'Riport jogosultság <b>'.$_POST['user_nev'].'</b> felhasználóhoz<br>';//<br>

echo '<table cellpadding=1 cellspacing=1 style="margin-top:10px" class="table_emre">';//;display:block

echo '<tr>';
echo '<td>';
echo '<label class="link_fek_vas" for="riport_aljog_all">Teljes jogsoultság minden jelenlegi és jövőbeli riporthoz';
echo '</label>';

$ful_riport_all=keres_mit1_mit1_csak_ertek("mira_user","user_ad",$_POST['user_ad'],"ful_riport_all");
$tomb_riport_aljog=keres_riport_tipusjogspan_aljog($_POST['user_ad']);

if($ful_riport_all=='1'){
 $ck_all=' checked';
 $ck_al_style=' style="visibility:hidden"';
}else{
 $ck_all='';
 $ck_al_style=' style="visibility:visible"';
}

echo '<td>';
echo '<input'.$ck_all.' id="riport_aljog_all" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';

echo '</tr>';

echo '<tr'.$ck_al_style.' class="riport_all_sor">';
echo '<td>';

echo '<label style="cursor:pointer" for="riport_aljog_nonp">Nonproduktív riport';//nonp
echo '</label>';
echo '<td>';
if(isset($tomb_riport_aljog['nonp']))$ck=' checked';
else $ck='';
echo '<input'.$ck.' id="riport_aljog_nonp" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';
echo '</tr>';

echo '<tr'.$ck_al_style.' class="riport_all_sor">';
echo '<td>';
echo '<label style="cursor:pointer" for="riport_aljog_tervteny">Terv-tény';//tervteny
echo '</label>';
echo '<td>';
if(isset($tomb_riport_aljog['tervteny']))$ck=' checked';
else $ck='';
echo '<input'.$ck.' id="riport_aljog_tervteny" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';
echo '</tr>';

echo '<tr'.$ck_al_style.' class="riport_all_sor">';
echo '<td>';
echo '<label style="cursor:pointer" for="riport_aljog_teny3_1_1">Felhasználónkénti tevékenység összesítés - 3.1.1';//teny3_1_1
echo '</label>';
echo '<td>';
if(isset($tomb_riport_aljog['teny3_1_1']))$ck=' checked';
else $ck='';
echo '<input'.$ck.' id="riport_aljog_teny3_1_1" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';
echo '</tr>';

echo '<tr'.$ck_al_style.' class="riport_all_sor">';
echo '<td>';
echo '<label style="cursor:pointer" for="riport_aljog_teny3_1_1_szervcsop">Felhasználónkénti tevékenység összesítés - 3.1.1 Szervezet csoportosítás';//teny3_1_1
echo '</label>';
echo '<td>';
if(isset($tomb_riport_aljog['teny3_1_1_szervcsop']))$ck_teny3_1_1_szervcsop_telj=' checked';
else $ck_teny3_1_1_szervcsop_telj='';
echo '<input'.$ck_teny3_1_1_szervcsop_telj.' id="riport_aljog_teny3_1_1_szervcsop" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';
echo '</tr>';

echo '<tr'.$ck_al_style.' class="riport_all_sor">';
echo '<td>';
echo '<label style="cursor:pointer" for="riport_aljog_teny3_2">Szervezetenkénti tevékenység összesítés - 3.2';//teny3_2
echo '</label>';
echo '<td>';
if(isset($tomb_riport_aljog['teny3_2']))$ck=' checked';
else $ck='';
echo '<input'.$ck.' id="riport_aljog_teny3_2" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';
echo '</tr>';

echo '<tr'.$ck_al_style.' class="riport_all_sor">';
echo '<td>';
echo '<label style="cursor:pointer" for="riport_aljog_teny3_3">Tevékenység összesítés - 3.3';//teny3_2
echo '</label>';
echo '<td>';
if(isset($tomb_riport_aljog['teny3_3']))$ck=' checked';
else $ck='';
echo '<input'.$ck.' id="riport_aljog_teny3_3" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';
echo '</tr>';

echo '<tr'.$ck_al_style.' class="riport_all_sor">';
echo '<td>';
echo '<label style="cursor:pointer" for="riport_aljog_teny3">Aktuális tevékenység kód - Társaság kód összesítés - 3';//teny3
echo '</label>';
echo '<td>';
if(isset($tomb_riport_aljog['teny3']))$ck=' checked';
else $ck='';
echo '<input'.$ck.' id="riport_aljog_teny3" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';
echo '</tr>';

echo '<tr'.$ck_al_style.' class="riport_all_sor">';
echo '<td>';
echo '<label style="cursor:pointer" for="riport_aljog_teny3_elteres">Tény-terv eltérés - 3';//teny3_elteres
echo '</label>';
echo '<td>';
if(isset($tomb_riport_aljog['teny3_elteres']))$ck=' checked';
else $ck='';
echo '<input'.$ck.' id="riport_aljog_teny3_elteres" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';
echo '</tr>';

echo '<tr'.$ck_al_style.' class="riport_all_sor">';
echo '<td>';
echo '<label style="cursor:pointer" for="riport_aljog_kapcs_ossze">Kapcsolattartó adatok';//Kapcsolattartók
echo '</label>';
echo '<td>';
if(isset($tomb_riport_aljog['kapcs_ossze']))$ck=' checked';
else $ck='';
echo '<input'.$ck.' id="riport_aljog_kapcs_ossze" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';
echo '</tr>';

//echo '<tr><td colspan=2 style="font-weight:bold" align=center>Szerződésnyilvántartó';

echo '<tr'.$ck_al_style.' class="riport_all_sor">';
echo '<td>';
echo '<label style="cursor:pointer" for="riport_aljog_szerznyilv">Szerződésnyilvántartó - teljes';
echo '</label>';
echo '<td>';
if(isset($tomb_riport_aljog['szerznyilv']))$ck_szerz_telj=' checked';
else $ck_szerz_telj='';
echo '<input'.$ck_szerz_telj.' id="riport_aljog_szerznyilv" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';
echo '</tr>';

echo '<tr'.$ck_al_style.' class="riport_all_sor">';
echo '<td>';
echo '<label style="cursor:pointer" for="riport_aljog_szerznyilv_elo">Szerződésnyilvántartó - élő szerződések';
echo '</label>';
echo '<td>';
if(isset($tomb_riport_aljog['szerznyilv_elo']))$ck_szerz_elo=' checked';
else $ck_szerz_elo='';
echo '<input'.$ck_szerz_elo.' id="riport_aljog_szerznyilv_elo" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';
echo '</tr>';

echo '<tr'.$ck_al_style.' class="riport_all_sor">';
echo '<td>';
echo '<label style="cursor:pointer" for="riport_aljog_proj_k99">KK99 tevékenységek';
echo '</label>';
echo '<td>';
if(isset($tomb_riport_aljog['proj_k99']))$ck_proj_k99=' checked';
else $ck_proj_k99='';
echo '<input'.$ck_proj_k99.' id="riport_aljog_proj_k99" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';
echo '</tr>';

echo '<tr'.$ck_al_style.' class="riport_all_sor">';
echo '<td>';
echo '<label style="cursor:pointer" for="riport_aljog_proj_beszkoz">Beszerzési és közbeszerzési tevékenységek';
echo '</label>';
echo '<td>';
if(isset($tomb_riport_aljog['proj_beszkoz']))$ck_proj_beszkoz=' checked';
else $ck_proj_beszkoz='';
echo '<input'.$ck_proj_beszkoz.' id="riport_aljog_proj_beszkoz" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';
echo '</tr>';

echo '<tr'.$ck_al_style.' class="riport_all_sor">';
echo '<td>';
echo '<label style="cursor:pointer" for="riport_aljog_proj_kpiriport">KPI riport';
echo '</label>';
echo '<td>';
if(isset($tomb_riport_aljog['kpi_riport']))$ck_proj_kpiriport=' checked';
else $ck_proj_kpiriport='';
echo '<input'.$ck_proj_kpiriport.' id="riport_aljog_proj_kpiriport" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';
echo '</tr>';

echo '<tr'.$ck_al_style.' class="riport_all_sor">';
echo '<td>';
echo '<label style="cursor:pointer" for="riport_aljog_proj_tigtabla">TIG tábla';
echo '</label>';
echo '<td>';
if(isset($tomb_riport_aljog['tig_tabla']))$ck_proj_tigtabla=' checked';
else $ck_proj_tigtabla='';
echo '<input'.$ck_proj_tigtabla.' id="riport_aljog_proj_tigtabla" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';
echo '</tr>';

echo '<tr'.$ck_al_style.' class="riport_all_sor"><td colspan=2 style="font-weight:bold" align=center>Admin riportok';

echo '<tr'.$ck_al_style.' class="riport_all_sor">';
echo '<td>';
echo '<label style="cursor:pointer" for="riport_aljog_proj_adminuser">Jogosultság';
echo '</label>';
echo '<td>';
if(isset($tomb_riport_aljog['admin_user']))$ck_proj_adminuser=' checked';
else $ck_proj_adminuser='';
echo '<input'.$ck_proj_adminuser.' id="riport_aljog_proj_adminuser" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';
echo '</tr>';

echo '<tr'.$ck_al_style.' class="riport_all_sor">';
echo '<td>';
echo '<label style="cursor:pointer" for="riport_aljog_proj_adminszerv">Szervezet';
echo '</label>';
echo '<td>';
if(isset($tomb_riport_aljog['admin_user']))$ck_proj_adminszerv=' checked';
else $ck_proj_adminszerv='';
echo '<input'.$ck_proj_adminszerv.' id="riport_aljog_proj_adminszerv" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';
echo '</tr>';

echo '<tr'.$ck_al_style.' class="riport_all_sor">';
echo '<td>';
echo '<label style="cursor:pointer" for="riport_aljog_proj_adminproj">Tevékenység';
echo '</label>';
echo '<td>';
if(isset($tomb_riport_aljog['admin_user']))$ck_proj_adminproj=' checked';
else $ck_proj_adminproj='';
echo '<input'.$ck_proj_adminproj.' id="riport_aljog_proj_adminproj" onchange="admin_moduser_riport_tipusjogspan_katt(\''.$_POST['user_ad'].'\')" type="checkbox">';
echo '</tr>';

echo '</table>';

admin_moduser_riport_tipusjogspan_szerzjogok($ck_szerz_telj,$ck_szerz_elo,$ck_teny3_1_1_szervcsop_telj);
}

function admin_moduser_riport_tipusjogspan_szerzjogok($ck_szerz_telj,$ck_szerz_elo,$ck_teny3_1_1_szervcsop_telj){

if($ck_teny3_1_1_szervcsop_telj!=""){
 $style311_disp=";display:block";
}else{
 $style311_disp=";display:none";
}

//3.1.1 szerv csop - eleje
echo '<div id="riportjog_teny3_1_1_szervcsop_div" style="margin-top:15px'.$style311_disp.'">';
echo '<span style="font-weight:bold">Felhasználónkénti tevékenység összesítés - 3.1.1 Szervezet csoportosítás jogosultságok</span>';
 
$tomb=keres_all_order('mira_szerv_csoport','mira_szerv_csoport_nev','asc');
$tomb_user=keres_mit1_mit1_kulcs('mira_user_riport_311_szervcsop','user_ad',$_POST['user_ad'],'mira_szerv_csoport_id');

if(is_array($tomb_user)){
 echo '<br><span style="color:#000" id="riport_szervcsop_szam_fo">Jogosult szervezet csoportosítások száma: <span id="riport_szervcsop_szam_ert">'.sizeof($tomb_user).'</span></span>';
}else{
 echo '<br><span style="color:red" id="riport_szervcsop_szam_fo">Jogosult szervezet csoportosítások száma: <span id="riport_szervcsop_szam_ert">0</span></span>';
}

if(is_array($tomb)){
 echo '<table cellpadding=1 cellspacing=1 style="margin-top:1px" class="table_emre">';
 if(is_array($tomb)){
 foreach($tomb as $ert){
	 echo '<trclass="riport_szerz_tr">';
	 echo '<td>';
	 echo '<label style="cursor:pointer" for="riportjog_teny3_1_1_szervcsop_inpt_'.$ert['mira_szerv_csoport_id'].'">'.$ert['mira_szerv_csoport_nev'];
	 if($ert['mira_szerv_csoport_inaktiv']=='1') echo ' (inaktív)';
	 echo '<td>';
	 if(isset($tomb_user[$ert['mira_szerv_csoport_id']]))$ck=' checked';
	 else $ck='';
	 echo '<input'.$ck.' id="riportjog_teny3_1_1_szervcsop_inpt_'.$ert['mira_szerv_csoport_id'].'" onchange="admin_moduser_riport_tipusjogspan_teny3_1_1_szervcsopjog_katt(\''.$_POST['user_ad'].'\',\''.$ert['mira_szerv_csoport_id'].'\')" type="checkbox">';
	 echo '</label>';
	 echo '</tr>';
 }
 }
 echo '</table>';
}
echo '</div>';
//3.1.1 szerv csop - vége

if(($ck_szerz_telj!="")or($ck_szerz_elo!="")){
 $style_disp=";display:block";
}else{
 $style_disp=";display:none";
}

//Szerződésnyilvántartó - eleje
echo '<div id="riportjog_szerz_div" style="margin-top:15px'.$style_disp.'">';
echo 'Szerződésnyilvántartó szolgáltatás csoport jogosultságok';

$tomb=keres_all_order('szerz_csop','szerz_csop_nev','asc');
$tomb_user=keres_mit1_mit1_kulcs('mira_user_riport_szerz','user_ad',$_POST['user_ad'],'szerz_csop_id');
$tomb_user_szerz_csop_all=keres_mit1_mit1_csak_ertek('mira_user','user_ad',$_POST['user_ad'],'ful_riport_szerz_csop_all');
if(is_array($tomb)){
 
 echo '<table cellpadding=1 cellspacing=1 style="margin-top:1px" class="table_emre">';
 echo '<tr>';
 echo '<td>';
 echo '<label style="cursor:pointer" for="riportjog_szerz_inptall">Összes jogosultság';
 if($tomb_user_szerz_csop_all=='1'){
	 $ck_all=' checked';
	 $style_sor=' style="display:none"';
 }else{
	 $style_sor=$ck_all='';
 }
 echo '<td><input'.$ck_all.' onchange="admin_moduser_riport_tipusjogspan_szerzjog_katt_all(\''.$_POST['user_ad'].'\')" id="riportjog_szerz_inptall" type="checkbox">';
 echo '</label>';
 echo '</tr>';
 if(is_array($tomb)){
 foreach($tomb as $ert){
	 echo '<tr'.$style_sor.' class="riport_szerz_tr">';
	 echo '<td>';
	 echo '<label style="cursor:pointer" for="riportjog_szerz_inpt_'.$ert['szerz_csop_id'].'">'.$ert['szerz_csop_nev'];
	 echo '<td>';
	 if(isset($tomb_user[$ert['szerz_csop_id']]))$ck=' checked';
	 else $ck='';
	 echo '<input'.$ck.' id="riportjog_szerz_inpt_'.$ert['szerz_csop_id'].'" onchange="admin_moduser_riport_tipusjogspan_szerzjog_katt(\''.$_POST['user_ad'].'\',\''.$ert['szerz_csop_id'].'\')" type="checkbox">';
	 echo '</label>';
	 echo '</tr>';
 }
 }
 echo '</table>';
}
echo '</div>';
//Szerződésnyilvántartó - vége

}

function admin_moduser_riport_tipusjogspan_katt(){
if(
 (isset($_POST['user_ad']))and
 (isset($_POST['jog_all']))and
 (isset($_POST['jog_nonp']))and
 (isset($_POST['jog_tervteny']))and
 (isset($_POST['jog_teny311']))and
 (isset($_POST['jog_teny32']))and
 (isset($_POST['jog_teny33']))and
 (isset($_POST['jog_teny3']))and
 (isset($_POST['jog_teny3_elteres']))and
 (isset($_POST['jog_kapcs_ossze']))and
 (isset($_POST['jog_szerznyilv']))and
 (isset($_POST['jog_szerznyilv_elo']))and
 (isset($_POST['jog_proj_k99']))and
 (isset($_POST['jog_proj_beszkoz']))and
 (isset($_POST['jog_proj_kpiriport']))and
 (isset($_POST['jog_proj_adminuser']))and
 (isset($_POST['jog_proj_adminszerv']))and
 (isset($_POST['jog_proj_adminproj']))and
 (isset($_POST['jog_teny311_szervcsop']))and
 (isset($_POST['jog_proj_tigtabla']))and
 ($_POST['user_ad']!='')
){

if(($_POST['jog_all']=='0')or($_POST['jog_all']=='1')){
 $tmp_mod=array();
 $tmp_mod[0]['ful_riport_all']=$_POST['jog_all'];
 mod_egy_fel_tom('mira_user',$tmp_mod[0],'user_ad',$_POST['user_ad']);	
}

if($_POST['jog_nonp']==1){
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['riport_tipus']='nonp';
  be_visz_replace("mira_user_riport",$tmp_bk_ker_def);
}else{
 torles2('mira_user_riport','user_ad',$_POST['user_ad'],'riport_tipus','nonp');
}

if($_POST['jog_tervteny']==1){
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['riport_tipus']='tervteny';
  be_visz_replace("mira_user_riport",$tmp_bk_ker_def);
}else{
 torles2('mira_user_riport','user_ad',$_POST['user_ad'],'riport_tipus','tervteny');
}

if($_POST['jog_teny311_szervcsop']==1){
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['riport_tipus']='teny3_1_1_szervcsop';
  be_visz_replace("mira_user_riport",$tmp_bk_ker_def);
}else{
 torles2('mira_user_riport','user_ad',$_POST['user_ad'],'riport_tipus','teny3_1_1_szervcsop');
}

if($_POST['jog_teny311']==1){
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['riport_tipus']='teny3_1_1';
  be_visz_replace("mira_user_riport",$tmp_bk_ker_def);
}else{
 torles2('mira_user_riport','user_ad',$_POST['user_ad'],'riport_tipus','teny3_1_1');
}

if($_POST['jog_teny32']==1){
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['riport_tipus']='teny3_2';
  be_visz_replace("mira_user_riport",$tmp_bk_ker_def);
}else{
 torles2('mira_user_riport','user_ad',$_POST['user_ad'],'riport_tipus','teny3_2');
}

if($_POST['jog_teny33']==1){
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['riport_tipus']='teny3_3';
  be_visz_replace("mira_user_riport",$tmp_bk_ker_def);
}else{
 torles2('mira_user_riport','user_ad',$_POST['user_ad'],'riport_tipus','teny3_3');
}

if($_POST['jog_teny3']==1){
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['riport_tipus']='teny3';
  be_visz_replace("mira_user_riport",$tmp_bk_ker_def);
}else{
 torles2('mira_user_riport','user_ad',$_POST['user_ad'],'riport_tipus','teny3');
}

if($_POST['jog_teny3_elteres']==1){
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['riport_tipus']='teny3_elteres';
  be_visz_replace("mira_user_riport",$tmp_bk_ker_def);
}else{
 torles2('mira_user_riport','user_ad',$_POST['user_ad'],'riport_tipus','teny3_elteres');
}

if($_POST['jog_kapcs_ossze']==1){
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['riport_tipus']='kapcs_ossze';
  be_visz_replace("mira_user_riport",$tmp_bk_ker_def);
}else{
 torles2('mira_user_riport','user_ad',$_POST['user_ad'],'riport_tipus','kapcs_ossze');
}

if($_POST['jog_szerznyilv']==1){
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['riport_tipus']='szerznyilv';
  be_visz_replace("mira_user_riport",$tmp_bk_ker_def);
}else{
 torles2('mira_user_riport','user_ad',$_POST['user_ad'],'riport_tipus','szerznyilv');
}

if($_POST['jog_szerznyilv_elo']==1){
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['riport_tipus']='szerznyilv_elo';
  be_visz_replace("mira_user_riport",$tmp_bk_ker_def);
}else{
 torles2('mira_user_riport','user_ad',$_POST['user_ad'],'riport_tipus','szerznyilv_elo');
}

if($_POST['jog_proj_k99']==1){
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['riport_tipus']='proj_k99';
  be_visz_replace("mira_user_riport",$tmp_bk_ker_def);
}else{
 torles2('mira_user_riport','user_ad',$_POST['user_ad'],'riport_tipus','proj_k99');
}

if($_POST['jog_proj_beszkoz']==1){
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['riport_tipus']='proj_beszkoz';
  be_visz_replace("mira_user_riport",$tmp_bk_ker_def);
}else{
 torles2('mira_user_riport','user_ad',$_POST['user_ad'],'riport_tipus','proj_beszkoz');
}

if($_POST['jog_proj_kpiriport']==1){
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['riport_tipus']='kpi_riport';
  be_visz_replace("mira_user_riport",$tmp_bk_ker_def);
}else{
 torles2('mira_user_riport','user_ad',$_POST['user_ad'],'riport_tipus','kpi_riport');
}

if($_POST['jog_proj_tigtabla']==1){
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['riport_tipus']='tig_tabla';
  be_visz_replace("mira_user_riport",$tmp_bk_ker_def);
}else{
 torles2('mira_user_riport','user_ad',$_POST['user_ad'],'riport_tipus','tig_tabla');
}

if($_POST['jog_proj_adminuser']==1){
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['riport_tipus']='admin_user';
  be_visz_replace("mira_user_riport",$tmp_bk_ker_def);
}else{
 torles2('mira_user_riport','user_ad',$_POST['user_ad'],'riport_tipus','admin_user');
}

if($_POST['jog_proj_adminszerv']==1){
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['riport_tipus']='admin_szerv';
  be_visz_replace("mira_user_riport",$tmp_bk_ker_def);
}else{
 torles2('mira_user_riport','user_ad',$_POST['user_ad'],'riport_tipus','admin_szerv');
}

if($_POST['jog_proj_adminproj']==1){
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['riport_tipus']='admin_proj';
  be_visz_replace("mira_user_riport",$tmp_bk_ker_def);
}else{
 torles2('mira_user_riport','user_ad',$_POST['user_ad'],'riport_tipus','admin_proj');
}

if(
($_POST['jog_all']=='1')and($_POST['jog_teny311_szervcsop']==0)
){
 torles('mira_user_riport_311_szervcsop','user_ad',$_POST['user_ad']);
}


if(
($_POST['jog_all']=='1')
or
(($_POST['jog_szerznyilv']==0)and($_POST['jog_szerznyilv_elo']==0))
){
 torles('mira_user_riport_szerz','user_ad',$_POST['user_ad']);
}

echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_moduser_stat(){
if(
(isset($_POST['ad']))and($_POST['ad']!="")and
(isset($_POST['user_stat']))and(
($_POST['user_stat']==0)or
($_POST['user_stat']==1)
)){
 $tmp_mod[0]['ful_stat']=$_POST['user_stat'];
 $tmp_mod[0]['ful_stat_all']=$_POST['user_stat'];
 $tmp_mod[0]['ful_stat_projekt_all']=$_POST['user_stat'];
 mod_egy_fel_tom('mira_user',$tmp_mod[0],'user_ad',$_POST['ad']);	
 
 if($_POST['user_stat']==0){//Ha nincs stat fül joga, akkor törölni kell az aljogokat is és az utolsót is.
	//Alszervezet jogokat töröljük ki
	torles("mira_user_stat","user_ad",$_POST['ad']);
	//Utolsót is szedjük ki, biztos, ami biztos
	$tmp_mod_ut[0]['stat_leker_szerv_id']="";
	mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod_ut[0],'user_ad',$_POST['ad']);
 }
 
 echo "ok$;$";	
}
}

function admin_moduser_adminjog_ment(){
if(
($GLOBALS[$GLOBALS['sessionname']]['ful_admin_all']==1)and
(isset($_POST['user_ad']))and
(isset($_POST['jog_admin']))and
($_POST['user_ad']!='')and
(
 ($_POST['jog_admin']=='0')or
 ($_POST['jog_admin']=='1')
)
){
	$tmp_mod=array();
	$tmp_mod[0]['ful_admin']=$_POST['jog_admin'];
	mod_egy_fel_tom('mira_user',$tmp_mod[0],'user_ad',$_POST['user_ad']);
	
	//fuljogok törlése
	if($_POST['jog_admin']=='0')
	 torles('mira_user_admin_jog','admin_jog_user_ad',$_POST['user_ad']);
	
	echo 'ok$;$';
}else{
 echo 'Adathiány';
}
}

function admin_moduser_adminjog_fuljog_ment(){
if(
($GLOBALS[$GLOBALS['sessionname']]['ful_admin_all']==1)and
(isset($_POST['user_ad']))and
($_POST['user_ad']!='')
){
$user_nev=keres_mit1_mit1_csak_ertek("mira_user",'user_ad',$_POST['user_ad'],'user_nev');
echo 'ok$;$';
echo 'Admin művelet jogosultság hozzárendelése <b>'.$user_nev.'</b> felhasználóhoz';

//Admin fülek
$tomb_jogok=keres_mit1('mira_user_admin_jog','admin_jog_user_ad',$_POST['user_ad']);

echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
echo '<th>Jogosultság';
echo '<th>Admin művelet';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

echo '<tr><td colspan=2 align=center style="font-weight:bold">MIRA</tr>';
admin_moduser_adminjog_ful_mezo('admin_user_mod','Jogosultság',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_szerv_mod','Szervezet',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_csop_nev_mod','Szervezet csoportosítás',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_proj_mod','Tevékenység',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_arazasref_mod','Árazási relevancia mező',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_kat_nev_mod','Önköltség kategória',$tomb_jogok);//Tevékenység kategória

admin_moduser_adminjog_ful_mezo('admin_szolg_kod_mod','Szolgáltatás kód',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_munkanapglobal_mod','Munkanap áthelyezés globálisan',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_munkanapuser_mod','Munkanap áthelyezés felhasználóra',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_honapzaras_mod','Hónap végleges lezárása',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_hibajavitas_mod','Hibajavítás',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_log','Log',$tomb_jogok);

echo '<tr><td colspan=2 align=center style="font-weight:bold">Tervezés</tr>';
admin_moduser_adminjog_ful_mezo('admin_tervezes_mod','Terv betöltés',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_tenypotlas_mod','Ténybetöltő - MIRA-n kívüli adatok',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_tenypotlastig_mod','Ténybetöltő - MIRA-n kívüli adatok TIG táblához',$tomb_jogok);

echo '<tr><td colspan=2 align=center style="font-weight:bold">Kapcsolódó adatok</tr>';
admin_moduser_adminjog_ful_mezo('admin_tagv_kod_mod','Társasági adatok',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_kapcstulaj_mod','Tulajdonosi joggyakorló lista',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_kapcstorzs_mod','Kapcsolattartó törzsadatok',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_kapcsossze_mod','Társasági szolgáltatási kapcsolattartók',$tomb_jogok);

echo '<tr><td colspan=2 align=center style="font-weight:bold">Szerződésnyilvántartó</tr>';
admin_moduser_adminjog_ful_mezo('admin_szerz_szerztipus','Szerződés típus',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_szerz_szolgcsop','Szolgáltatás csoport',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_szerz_elsztipus','Elszámolás típusa',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_szerz_nattipus','Naturália típus',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_szerz_tarskat','Társaság kategória',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_szerz_szerzalapadat','Szerződés alapadatok',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_szerz_szerzfeltolt','Szerződés feltöltése',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_szerz_szolgkapadat','Szolgáltatáshoz kapcsolódó adatok',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_szerz_szolgmodadat','Szolgáltatás módosításhoz kapcsolódó adatok',$tomb_jogok);

admin_moduser_adminjog_ful_mezo('admin_szerz_integadat','Integrációs adatok',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_szerz_szerzusergazda','Szerződésgazda',$tomb_jogok);

echo '<tr><td colspan=2 align=center style="font-weight:bold">Szerződéskatalógus – TIGeléshez kapcsolódó adatok</tr>';
admin_moduser_adminjog_ful_mezo('admin_szerz_tigadat_penznem','Devizanem és árfolyam',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_szerz_tigadat_co','CO objektum',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_szerz_tigadat_sapszam','SAP szerződésszám',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_szerz_tigadat_vevoazon','Vevő azonosító',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_szerz_tigadat_nemszerz','Nem szerződés alapján TIG-elendő tételek',$tomb_jogok);

echo '<tr><td colspan=2 align=center style="font-weight:bold">KPI</tr>';
admin_moduser_adminjog_ful_mezo('admin_kpi_szolgkod','KPI szolgáltatás kód',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_kpi_tipus','KPI típusok',$tomb_jogok);
admin_moduser_adminjog_ful_mezo('admin_kpi_osszekap','KPI típus - szerződés összerendelés',$tomb_jogok);

echo '</tbody>';
echo '</table>';
}else{
 echo 'Adathiány';
}
}

function admin_moduser_adminjog_ful_mezo($muv_kod,$muv_nev,$tomb_jogok){
 
 
 if(
 (isset($tomb_jogok[0]['admin_jog_'.$muv_kod]))and
 ($tomb_jogok[0]['admin_jog_'.$muv_kod]==1)
 ){
	 $ck=' checked';
 }else $ck='';
 
 echo '<tr>';
 echo '<td>';
 echo '<input'.$ck.' onchange="admin_moduser_adminjog_fuljog_ment_ful(\''.$muv_kod.'\',\''.$_POST['user_ad'].'\')" id="'.$muv_kod.'_'.$_POST['user_ad'].'" type="checkbox">';
 echo '<td>';
 echo '<label for="'.$muv_kod.'_'.$_POST['user_ad'].'" style="cursor:pointer">'.$muv_nev.'</label>';
 echo '</tr>';
}

function admin_moduser_adminjog_fuljog_ment_ful(){
if(
(isset($_POST['user_ad']))and
(isset($_POST['muv_kod']))and
(isset($_POST['mit']))and
($_POST['user_ad']!='')and
($_POST['muv_kod']!='')and
(
 ($_POST['mit']=='0')or
 ($_POST['mit']=='1')
)
){
//Van-e már rekordja, ha igen módosítás, ha nem bevitel

if(keres_mit1_mit1_csak_ertek('mira_user_admin_jog','admin_jog_user_ad',$_POST['user_ad'],'admin_jog_user_ad')==''){
 $tmp_bk[0]=array();
 $tmp_bk[0]['admin_jog_user_ad']=$_POST['user_ad'];
 $tmp_bk[0]['admin_jog_'.$_POST['muv_kod']]=$_POST['mit'];
 be_visz_insert("mira_user_admin_jog",$tmp_bk);
}else{
 $tmp_mod=array();
 $tmp_mod[0]['admin_jog_'.$_POST['muv_kod']]=$_POST['mit'];
 mod_egy_fel_tom('mira_user_admin_jog',$tmp_mod[0],'admin_jog_user_ad',$_POST['user_ad']);
}

echo 'ok$;$';
}else{
 echo 'Adathiány';
}
}


function admin_mod_userfelettesjovahagyas_proj_katt(){
echo "ok$;$";

echo "Felettes jóváhagyó hozzárendelése <b>";
echo $_POST['user_nev'];
echo "</b> felhasználóhoz<br><br>";

echo "<b>Szűrés:</b><br>";
echo "<input user_ad='".$_POST['user_ad']."' onkeyup='admin_moduserfelettesjovahagyas_hozz_keress(\"\",\"\")' id='userfelettesjovahagyas_hozzid_keress' type=text style='width:250px'>";

echo "<br>Csak hozzárendelt felhasználók: ";
echo "<input onchange='admin_moduserfelettesjovahagyas_hozz_keress_proc(\"\",\"\")' id='userfelettesjovahagyas_hozzid_csakhozz_szur' type='checkbox'>";

echo "<div id='userfelettesjovahagyas_hozzid_tal_div'>";
 //$tomb_szerv=keres_mit2_order("mira_szerv","szerv_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"szerv_inaktiv","0","szerv_nev","asc");
 //$tomb_szerv_van=keres_userjovahagyas_user_hozzarend_adat($_POST['user_ad']);
 
 $tomb_jovahagyo=keres_fellettesjovahagyo_user($_POST['user_ad'],"","0");
 $tomb_jovahagyo_van=keres_felettesjovahagyo_hozzarend_adat($_POST['user_ad']);
 admin_mod_userfelettesjovahagyas_user_katt_list_ki($tomb_jovahagyo,$tomb_jovahagyo_van);
echo "</div>";
}

function admin_moduserfelettesjovahagyas_hozz_keress(){
echo "ok$;$";
$tomb_jovahagyo=keres_fellettesjovahagyo_user($_POST['user_ad'],$_POST['keress_nev'],$_POST['csakvan']);
$tomb_jovahagyo_van=keres_felettesjovahagyo_hozzarend_adat($_POST['user_ad']);
admin_mod_userfelettesjovahagyas_user_katt_list_ki($tomb_jovahagyo,$tomb_jovahagyo_van);
}


function admin_mod_userfelettesjovahagyas_user_katt_list_ki($tomb_jovahagyo,$tomb_jovahagyo_van){

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
echo "<td><label style='cursor:pointer' for='felettesjovahagyo_hozzid_".$ert['user_ad']."'>";
echo $ert['user_nev'];

echo "<td align=center>";
echo "<input".$ck." class='link' onchange='admin_modfelettesjovahagyo_hozz_change(\"".$ert['user_ad']."\",\"".$_POST['user_ad']."\")' name='felettesjovahagyo_hozz' id='felettesjovahagyo_hozzid_".$ert['user_ad']."' type='checkbox'>";
echo "</label>";

echo "</tr>";

}
}
echo "</tbody></table>";

elozo_kovetkezo_gombok("admin_moduserfelettesjovahagyas_hozz_keress_proc",$th,$GLOBALS['mira']['user_jog']['user_felettesjovahagyo_keres_talszam'],$_POST['oldalholvagyok']);
echo "<div style='margin-top:5px'>";
//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['user_felettesjovahagyo_keres_talszam'],"admin_moduserfelettesjovahagyas_hozz_keress_proc","user_felettesjovahagyo_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='user_felettesjovahagyo_keres_tal_oldalholvagyok'>";

if(is_array($tomb_jovahagyo)){
foreach($tomb_jovahagyo as $i => $ert){
if($i==0){
 $th=$ert['tal'];
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['user_felettesjovahagyo_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='user_felettesjovahagyo_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['user_felettesjovahagyo_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_moduserfelettesjovahagyas_hozz_keress_proc('tallep_elso','');</script>";
  }
 }
}}
excel_export("felettes_jovahagyo",$th);
}
echo "</div>";

}
}

function admin_moduser_stat_szervjogspan(){
echo "ok$;$";

echo "Statisztika jogosultság hozzárendelés <b>";//szervezet
echo $_POST['user_nev'];
echo "</b> felhasználóhoz<br><br>";

$tomb_alljog=keres_mit1_mit1_csak_ertek("mira_user","user_ad",$_POST['user_ad'],"ful_stat_all");
$tomb_alljog_proj=keres_mit1_mit1_csak_ertek("mira_user","user_ad",$_POST['user_ad'],"ful_stat_projekt_all");
if($tomb_alljog==1){
	$check=" checked";
	$proj_dis="";
}else{
	$check="";
	$proj_dis=" disabled";
}

if($tomb_alljog_proj==1){
	$proj_ck=" checked";
	$szerv_dis="";
}else{
	$proj_ck="";
	$szerv_dis=" disabled";
}

echo "Teljes jogosultság minden jelenlegi és jövőbeli tevékenységhez: ";
echo "<input".$proj_dis.$proj_ck." onchange='admin_moduser_stat_szervjogspan_all(\"".$_POST['user_ad']."\")' id='admin_moduser_stat_projektjogspan_all' type='checkbox'>";

echo "<br>Teljes jogosultság minden jelenlegi és jövőbeli szervezethez: ";
echo "<input".$szerv_dis.$check." onchange='admin_moduser_stat_szervjogspan_all(\"".$_POST['user_ad']."\")' id='admin_moduser_stat_szervjogspan_all' type='checkbox'>";

echo "<div id='admin_moduser_stat_szervjogspan_szerv_aljog_tal_div'>";
if($tomb_alljog==0)
 admin_moduser_stat_szervjogspan_szerv_aljog();
elseif($tomb_alljog_proj==0)
 admin_moduser_stat_projektjogspan_szerv_aljog();
echo "</div>";
}

function admin_moduser_stat_projektjogspan_szerv_aljog(){
echo "<br><b>Szűrés:</b><br>";
echo "<input onkeyup='admin_moduser_stat_projekt_hozz_keress(\"\",\"\")' user_ad='".$_POST['user_ad']."' id='user_stat_projekt_hozzid_keress' type=text style='width:250px'>";

echo "<br>Csak hozzárendelt tevékenységek: ";
echo "<input onchange='admin_moduser_stat_projekt_hozz_keress_proc(\"\",\"\")' id='user_stat_projekt_hozzid_csakhozz_szur' type='checkbox'>";

echo "<div id='user_stat_projekt_hozzid_tal_div'>";
 $tomb_user=keres_admin_userhez_stat_projekt($_POST['user_ad'],"",0);
 $tomb_user_van=keres_user_stat_projekt_user_hozzarend_adat($_POST['user_ad']);
 admin_mod_user_stat_projekt_user_katt_list_ki($tomb_user,$tomb_user_van);
echo "</div>";
}

function admin_moduser_stat_projekt_hozz_keress(){
echo "ok$;$";
$tomb_user=keres_admin_userhez_stat_projekt($_POST['user_ad'],$_POST['projekt_nev'],$_POST['csakvan']);
$tomb_user_van=keres_user_stat_projekt_user_hozzarend_adat($_POST['user_ad']);
admin_mod_user_stat_projekt_user_katt_list_ki($tomb_user,$tomb_user_van);
}

function admin_mod_user_stat_projekt_user_katt_list_ki($tomb_user,$tomb_user_van){
if(is_array($tomb_user)){
echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
//echo '<th>ID';
echo '<th>Tevékenység neve';
echo '<th>Hozzárendelés';
//echo '<th>Tevékenység típus';
echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_user as $i => $ert){

if($i==0){
	$th=$ert['tal'];
}else{

if(isset($tomb_user_van[$ert['projekt_id']])){
 $ck=" checked";
}else{
 $ck="";
}

//echo "<tr".$css.">";
echo "<tr>";
//echo "<td>".$ert['projekt_id'];
echo "<td><label style='cursor:pointer' for='user_stat_projekt_hozzid_".$ert['projekt_id']."'>";
echo $ert['projekt_nev'];
if($ert['projekt_inaktiv']==1)
	 echo " (inaktív)";

echo "<td align=center>";
echo "<input".$ck." class='link' onchange='admin_moduser_stat_projekt_hozz_change(\"".$ert['projekt_id']."\",\"".$_POST['user_ad']."\")' name='user_stat_projekt_hozz' id='user_stat_projekt_hozzid_".$ert['projekt_id']."' type='checkbox'>";
echo "</label>";

/*echo "<td>";
echo projekt_tipus_ki($ert['projekt_tipus']);*/

echo "</tr>";

}
}
echo "</tbody></table>";

elozo_kovetkezo_gombok("admin_moduser_stat_projekt_hozz_keress_proc",$th,$GLOBALS['mira']['user_jog']['user_stat_projekthozza_keres_talszam'],$_POST['oldalholvagyok']);
echo "<div style='margin-top:5px'>";
//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['user_stat_projekthozza_keres_talszam'],"admin_moduser_stat_projekt_hozz_keress_proc","user_stat_projekthozza_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='user_stat_projekthozza_keres_tal_oldalholvagyok'>";

if(is_array($tomb_user)){
foreach($tomb_user as $i => $ert){
if($i==0){
 $th=$ert['tal'];
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['user_stat_projekthozza_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='user_stat_projekthozza_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['user_stat_projekthozza_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_moduser_stat_projekt_hozz_keress_proc('tallep_elso','');</script>";
  }
 }
}}
excel_export("userhez_stat_projekt",$th);
}
echo "</div>";
}
}

function admin_moduser_stat_projekt_hozz_change(){
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
  be_visz_replace("mira_user_stat_proj",$tmp_bk_ker_def);
 }else{//Ekkor ki kell
  torles2("mira_user_stat_proj",'projekt_id',$_POST['projekt_id'],'user_ad',$_POST['user_ad']);
 }
 echo "ok$;$";
}
}

function admin_moduser_stat_szervjogspan_szerv_aljog(){
echo "<br><b>Szűrés:</b><br>";

echo "<input onkeyup='admin_moduser_stat_szerv_hozz_keress(\"\",\"\")' user_ad='".$_POST['user_ad']."' id='user_stat_szerv_hozzid_keress' type=text style='width:250px'>";
echo "<br>Csak hozzárendelt szervezetek: ";

echo "<input onchange='admin_moduser_stat_szerv_hozz_keress_proc(\"\",\"\")' id='user_stat_szerv_hozzid_csakhozz_szur' type='checkbox'>";

echo "<div id='user_stat_szerv_hozzid_tal_div'>";
 $tomb_szerv=keres_admin_userhez_stat_szerv($_POST['user_ad'],"",0);
 $tomb_szerv_van=keres_userstat_szervjogspan_user_hozzarend_adat($_POST['user_ad']);
 admin_mod_user_stat_szerv_user_katt_list_ki($tomb_szerv,$tomb_szerv_van);
echo '</div>';
}

function admin_moduser_stat_szerv_hozz_keress(){
echo "ok$;$";
$tomb_szerv=keres_admin_userhez_stat_szerv($_POST['user_ad'],$_POST['szerv_nev'],$_POST['csakvan']);
$tomb_szerv_van=keres_userstat_szervjogspan_user_hozzarend_adat($_POST['user_ad']);
admin_mod_user_stat_szerv_user_katt_list_ki($tomb_szerv,$tomb_szerv_van);
}

function admin_mod_user_stat_szerv_user_katt_list_ki($tomb_szerv,$tomb_szerv_van){
if(is_array($tomb_szerv)){
echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
echo '<th>ID';
echo '<th>Szervezet neve';
echo '<th>Hozzárendelés';
echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_szerv as $i => $ert){

if(isset($tomb_szerv_van[$ert['szerv_id']])){
 $ck=" checked";
}else{
 $ck="";
}

echo "<tr>";
echo "<td>".$ert['szerv_id'];
echo "<td><label style='cursor:pointer' for='userstat_szervjogspan_hozzid_".$ert['szerv_id']."'>";
echo $ert['szerv_nev'];
if($ert['szerv_inaktiv']==1)
 echo " (inaktív)";

echo "<td align=center>";
echo "<input".$ck." class='link' onchange='admin_moduser_stat_szervjogspan_change(\"".$ert['szerv_id']."\",\"".$_POST['user_ad']."\")' name='userstat_szervjogspan_hozzid_' id='userstat_szervjogspan_hozzid_".$ert['szerv_id']."' type='checkbox'>";
echo "</label>";
echo "</tr>";

}

echo "</tbody></table>";
}
}

function admin_moduser_stat_szervjogspan_szerv_aljog_old(){
//$tomb_szerv=keres_mit2_order("mira_szerv","szerv_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"szerv_inaktiv","0","szerv_nev","asc");
//$tomb_szerv=keres_mit1_order("mira_szerv","szerv_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"szerv_nev","asc");
$tomb_szerv=keres_all_order("mira_szerv","szerv_nev","asc");
$tomb_szerv_van=keres_userstat_szervjogspan_user_hozzarend_adat($_POST['user_ad']);

if(is_array($tomb_szerv)){
echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
echo '<th>ID';
echo '<th>Szervezet neve';
echo '<th>Hozzárendelés';
echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_szerv as $i => $ert){

if(isset($tomb_szerv_van[$ert['szerv_id']])){
 $ck=" checked";
}else{
 $ck="";
}

echo "<tr>";
echo "<td>".$ert['szerv_id'];
echo "<td><label style='cursor:pointer' for='userstat_szervjogspan_hozzid_".$ert['szerv_id']."'>";
echo $ert['szerv_nev'];
if($ert['szerv_inaktiv']==1)
 echo " (inaktív)";

echo "<td align=center>";
echo "<input".$ck." class='link' onchange='admin_moduser_stat_szervjogspan_change(\"".$ert['szerv_id']."\",\"".$_POST['user_ad']."\")' name='userstat_szervjogspan_hozzid_' id='userstat_szervjogspan_hozzid_".$ert['szerv_id']."' type='checkbox'>";
echo "</label>";
echo "</tr>";

}

echo "</tbody></table>";
}
}

function admin_moduser_stat_szervjogspan_all(){
if(
(isset($_POST['user_ad']))and($_POST['user_ad']!="")and
 (isset($_POST['ful_stat_all']))and
 (
  ($_POST['ful_stat_all']==0)or
  ($_POST['ful_stat_all']==1)
 )and
 (isset($_POST['ful_stat_projekt_all']))and
 (
  ($_POST['ful_stat_projekt_all']==0)or
  ($_POST['ful_stat_projekt_all']==1)
 )
){
 $tmp_mod[0]['ful_stat_all']=$_POST['ful_stat_all'];
 
 $tmp_mod[0]['ful_stat_projekt_all']=$_POST['ful_stat_projekt_all'];;
 mod_egy_fel_tom('mira_user',$tmp_mod[0],'user_ad',$_POST['user_ad']);	
 
 if($_POST['ful_stat_all']==1)//Alszervezet jogokat töröljük ki
  torles("mira_user_stat","user_ad",$_POST['user_ad']);
  
 if($_POST['ful_stat_projekt_all']==1)//Alszervezet jogokat töröljük ki
  torles("mira_user_stat_proj","user_ad",$_POST['user_ad']);
 else{//Ekkor nincs teljes joga, utolsót töröljük ki.
	$tmp_mod_ut[0]['stat_leker_szerv_id']="";
	mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod_ut[0],'user_ad',$_POST['user_ad']);
 }
 echo "ok$;$";	
}
}

function admin_moduser_stat_szervjogspan_change(){
if(
(isset($_POST['user_ad']))and($_POST['user_ad']!="")and
(isset($_POST['szerv_id']))and($_POST['szerv_id']!="")and
(isset($_POST['mit']))and(
($_POST['mit']==0)or
($_POST['mit']==1)
)){

 if($_POST['mit']==1){
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  $tmp_bk_ker_def[0]['szerv_id']=$_POST['szerv_id'];
  be_visz_replace("mira_user_stat",$tmp_bk_ker_def);
 }else{
	torles2("mira_user_stat","user_ad",$_POST['user_ad'],"szerv_id",$_POST['szerv_id']);
	
	//utolsót töröljük ki.
	 $tmp_mod[0]['stat_leker_szerv_id']="";
	 mod_egy_fel_tom2('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_POST['user_ad'],"stat_leker_szerv_id",$_POST['szerv_id']);
 }

}
echo "ok$;$";
}

function admin_mod_userjovahagyas_proj_katt(){
echo "ok$;$";

echo "Szervezet jóváhagyó jogosultság hozzárendelés <b>";
echo $_POST['user_nev'];
echo "</b> felhasználóhoz<br><br>";

echo "<b>Szűrés:</b><br>";
echo "<input onkeyup='admin_moduserjovahagyas_hozz_keress(\"".$_POST['user_ad']."\")' id='userjovahagyas_hozzid_keress' type=text style='width:250px'>";

echo "<br>Csak hozzárendelt szervezetek: ";
echo "<input onchange='admin_moduserjovahagyas_hozz_keress(\"".$_POST['user_ad']."\")' id='userjovahagyas_hozzid_csakhozz_szur' type='checkbox'>";

echo "<div id='userjovahagyas_hozzid_tal_div'>";
 //$tomb_szerv=keres_mit2_order("mira_szerv","szerv_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"szerv_inaktiv","0","szerv_nev","asc");
 $tomb_szerv=keres_mit1_order("mira_szerv","szerv_inaktiv","0","szerv_nev","asc");
 $tomb_szerv_van=keres_userjovahagyas_user_hozzarend_adat($_POST['user_ad']);
 admin_mod_userjovahagyas_user_katt_list_ki($tomb_szerv,$tomb_szerv_van,"all");
echo "</div>";
}

function admin_moduserjovahagyas_hozz_keress(){
echo "ok$;$";
//$tomb_szerv=keres_mit2_order("mira_szerv","szerv_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"szerv_inaktiv","0","szerv_nev","asc");
$tomb_szerv=keres_mit1_order("mira_szerv","szerv_inaktiv","0","szerv_nev","asc");
$tomb_szerv_van=keres_userjovahagyas_user_hozzarend_adat($_POST['user_ad']);
$tomb_szerv_van_lat=keres_szerv_akt_nevlike($_POST['szerv_nev']);
admin_mod_userjovahagyas_user_katt_list_ki($tomb_szerv,$tomb_szerv_van,$tomb_szerv_van_lat);

}

function admin_mod_userjovahagyas_user_katt_list_ki($tomb_szerv,$tomb_szerv_van,$tomb_szerv_van_lat){
if(is_array($tomb_szerv)){
echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
echo '<th>ID';
echo '<th>Szervezet neve';
echo '<th>Hozzárendelés';
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
((is_array($tomb_szerv_van_lat))and(isset($tomb_szerv_van_lat[$ert['szerv_id']])))
or
(
((!is_array($tomb_szerv_van_lat))and($tomb_szerv_van_lat=="all"))
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
echo "<td>".$ert['szerv_id'];
echo "<td><label style='cursor:pointer' for='userjovahagy_hozzid_".$ert['szerv_id']."'>";
echo $ert['szerv_nev'];

echo "<td align=center>";
echo "<input".$ck." class='link' onchange='admin_moduserjovahagy_hozz_change(\"".$ert['szerv_id']."\",\"".$_POST['user_ad']."\")' name='userjovahagy_hozz' id='userjovahagy_hozzid_".$ert['szerv_id']."' type='checkbox'>";
echo "</label>";
echo "</tr>";

}

echo "</tbody></table>";

}
}

function admin_moduserjovahagy_hozz_change(){
if(
(isset($_POST['szerv_id']))and
(isset($_POST['user_ad']))and
(isset($_POST['mit']))and
($_POST['szerv_id']!="")and
($_POST['user_ad']!="")and
($_POST['mit']!="")
){
 if($_POST['mit']==1){//Bevitel
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['szerv_id']=$_POST['szerv_id'];
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  be_visz_replace("mira_szerv_jovahagyo",$tmp_bk_ker_def);
 }else{//Ekkor ki kell
 
  
 $tomb_utolso_e=keres_user_utolso_szerv_jovhagyo_e_egyszervnel($_POST['szerv_id']);
 if(is_array($tomb_utolso_e)){
	echo "okutolso$;$"; 
	echo "<b>Hiba!<br><br>Jogosulság nem törölhető, mert ".$tomb_utolso_e[0]['szerv_nev'];
	echo " szervezetnél ".$tomb_utolso_e[0]['user_nev']." az egyetlen jóváhagyó!</b>";
	exit;
 }
 
  torles2("mira_szerv_jovahagyo",'szerv_id',$_POST['szerv_id'],'user_ad',$_POST['user_ad']);
 }
 echo "ok$;$";
}
}

function admin_modfelettesjovahagyo_hozz_change(){
if(
(isset($_POST['user_ad_felettes_jovahagyo']))and
(isset($_POST['user_ad']))and
(isset($_POST['mit']))and
($_POST['user_ad_felettes_jovahagyo']!="")and
($_POST['user_ad']!="")and
($_POST['mit']!="")
){
 if($_POST['mit']==1){//Bevitel
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad_felettes_jovahagyo']=$_POST['user_ad_felettes_jovahagyo'];
  $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
  be_visz_replace("mira_user_felettes_jovahagyo",$tmp_bk_ker_def);
 }else{//Ekkor ki kell
  torles2("mira_user_felettes_jovahagyo",'user_ad_felettes_jovahagyo',$_POST['user_ad_felettes_jovahagyo'],'user_ad',$_POST['user_ad']);
 }
 echo "ok$;$";
}
}

function admin_mod_userprojekt_proj_katt(){
echo "ok$;$";

echo "Tevékenység hozzárendelése <b>";
echo $_POST['user_nev'];
echo "</b> felhasználóhoz<br><br>";

echo "<b>Szűrés:</b><br>";
echo "<input onkeyup='admin_moduserprojekt_hozz_keress(\"\",\"\")' user_ad='".$_POST['user_ad']."' id='userprojekt_hozzid_keress' type=text style='width:250px'>";

echo "<br>Csak hozzárendelt tevékenységek: ";
echo "<input onchange='admin_moduserprojekt_hozz_keress_proc(\"\",\"\")' id='userprojekt_hozzid_csakhozz_szur' type='checkbox'>";

echo "<div id='userprojekt_hozzid_tal_div'>";
 //$tomb_user=keres_mit2_order("projekt","projekt_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"projekt_inaktiv","0","projekt_nev","asc");
 $tomb_user=keres_admin_userhezprojekt($_POST['user_ad'],"",0);
 $tomb_user_van=keres_userprojekt_user_hozzarend_adat($_POST['user_ad']);
 $tomb_user_katkivetel=keres_user_projekt_katkivetel_hozzarend_adat($_POST['user_ad']);
 //admin_mod_userprojekt_user_katt_list_ki($tomb_user,$tomb_user_van,"all");
 admin_mod_userprojekt_user_katt_list_ki($tomb_user,$tomb_user_van,$tomb_user_katkivetel);
echo "</div>";
}

function admin_moduserprojekt_hozz_keress(){
echo "ok$;$";
//$tomb_user=keres_mit2_order("projekt","projekt_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"projekt_inaktiv","0","projekt_nev","asc");
$tomb_user=keres_admin_userhezprojekt($_POST['user_ad'],$_POST['projekt_nev'],$_POST['csakvan']);
$tomb_user_van=keres_userprojekt_user_hozzarend_adat($_POST['user_ad']);
$tomb_user_katkivetel=keres_user_projekt_katkivetel_hozzarend_adat($_POST['user_ad']);
//$tomb_user_lat=keres_proj_akt_nevlike($_POST['projekt_nev']);
//admin_mod_userprojekt_user_katt_list_ki($tomb_user,$tomb_user_van,$tomb_user_lat);
admin_mod_userprojekt_user_katt_list_ki($tomb_user,$tomb_user_van,$tomb_user_katkivetel);

}

function admin_mod_userprojekt_user_katt_list_ki($tomb_user,$tomb_user_van,$tomb_user_katkivetel){
if(is_array($tomb_user)){
echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
//echo '<th>ID';
echo '<th>Tevékenység neve';
echo '<th>Hozzárendelés';
echo '<th>Önköltség kategória kivétel';
//echo '<th>Tevékenység típus';
echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_user as $i => $ert){

if($i==0){
	$th=$ert['tal'];
}else{

if(isset($tomb_user_van[$ert['projekt_id']])){
 $ck=" checked";
}else{
 $ck="";
}
/*
if(
(
((is_array($tomb_user_lat))and(isset($tomb_user_lat[$ert['projekt_id']])))
or
(
((!is_array($tomb_user_lat))and($tomb_user_lat=="all"))
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
}*/

//echo "<tr".$css.">";
echo "<tr>";
//echo "<td>".$ert['projekt_id'];
echo "<td><label style='cursor:pointer' for='userprojekt_hozzid_".$ert['projekt_id']."'>";
echo $ert['projekt_nev'];

echo "<td align=center>";
echo "<input".$ck." class='link' onchange='admin_moduserprojekt_hozz_change(\"".$ert['projekt_id']."\",\"".$_POST['user_ad']."\")' name='userprojekt_hozz' id='userprojekt_hozzid_".$ert['projekt_id']."' type='checkbox'>";
echo "</label>";

//Önköltség kategória kivétel
echo '<td>';
if($ck!=''){//Csak ha be van pipálva
  echo '<select onchange="admin_moduserprojekt_katkivetel_change(\''.$_POST['user_ad'].'\',\''.$ert['projekt_id'].'\')" id="userprojekt_katkivetelid_'.$ert['projekt_id'].'" class="select2_ajax" csonkolt="1" mod="admin_kat" style="width:250px">';
 if(isset($tomb_user_katkivetel[$ert['projekt_id']])){
  echo '<option value="'.$tomb_user_katkivetel[$ert['projekt_id']]['id'].'">'.$tomb_user_katkivetel[$ert['projekt_id']]['nev'].' - '.$tomb_user_katkivetel[$ert['projekt_id']]['nev_h'];
 }else{
	 echo '<option value="keremv">Kérem válassz';
 }
echo '</select>';
}

/*echo "<td>";
echo projekt_tipus_ki($ert['projekt_tipus']);*/

echo "</tr>";

}
}
echo "</tbody></table>";

elozo_kovetkezo_gombok("admin_moduserprojekt_hozz_keress_proc",$th,$GLOBALS['mira']['user_jog']['user_projekthozza_keres_talszam'],$_POST['oldalholvagyok']);
echo "<div style='margin-top:5px'>";
//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['user_projekthozza_keres_talszam'],"admin_moduserprojekt_hozz_keress_proc","user_projekthozza_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='user_projekthozza_keres_tal_oldalholvagyok'>";

if(is_array($tomb_user)){
foreach($tomb_user as $i => $ert){
if($i==0){
 $th=$ert['tal'];
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['user_projekthozza_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='user_projekthozza_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['user_projekthozza_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_moduserprojekt_hozz_keress_proc('tallep_elso','');</script>";
  }
 }
}}
excel_export("userhez_projekt",$th);
}
echo "</div>";
}
}

function admin_moduserprojekt_hozz_change(){
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

function admin_mod_useremailbe_katt(){
echo "ok$;$";

echo "Jóváhagyói email értesítési beállítások <b>";
echo $_POST['user_nev'];
echo "</b> felhasználóhoz<br>";

$tomb=keres_mit1("mira_user","user_ad",$_POST['user_ad']);

$email_jova_elso_szak_ck="";
$email_vissza_szak_ck="";
$email_vissza_proj_ck="";
if(is_array($tomb)){

if((isset($tomb[0]['email_jova_elso_szak']))and($tomb[0]['email_jova_elso_szak']=="1"))
 $email_jova_elso_szak_ck=" checked";
if((isset($tomb[0]['email_vissza_szak']))and($tomb[0]['email_vissza_szak']=="1"))
 $email_vissza_szak_ck=" checked";
if((isset($tomb[0]['email_vissza_proj']))and($tomb[0]['email_vissza_proj']=="1"))
 $email_vissza_proj_ck=" checked";
}

echo "<table style='margin-top:20px' class='table_emre'>";
echo "<tbody>";

echo "<tr>";
echo "<td><label style='cursor:pointer' for='email_jova_elso_szak'>";
echo "<b>Szervezeti jóváhagyókénti értesítés első lezárás alkalmával</b>";
echo "<td align=center>";
echo "<input".$email_jova_elso_szak_ck." class='link' onchange='admin_mod_useremailbe_change(\"".$_POST['user_ad']."\")' name='email_jova_elso_szak' id='email_jova_elso_szak' type='checkbox'>";
echo "</label>";
echo "</tr>";

echo "<tr>";
echo "<td><label style='cursor:pointer' for='email_vissza_szak'>";
echo "<b>Szervezeti jóváhagyókénti értesítés (másolatban) visszaküldéskor</b>";
echo "<td align=center>";
echo "<input".$email_vissza_szak_ck." class='link' onchange='admin_mod_useremailbe_change(\"".$_POST['user_ad']."\")' name='email_vissza_szak' id='email_vissza_szak' type='checkbox'>";
echo "</label>";
echo "</tr>";

echo "<tr>";
echo "<td><label style='cursor:pointer' for='email_vissza_proj'>";
echo "<b>Projekt jóváhagyókénti értesítés (másolatban) visszaküldéskor</b>";
echo "<td align=center>";
echo "<input".$email_vissza_proj_ck." class='link' onchange='admin_mod_useremailbe_change(\"".$_POST['user_ad']."\")' name='email_vissza_proj' id='email_vissza_proj' type='checkbox'>";
echo "</label>";
echo "</tr>";

echo "</tbody>";
echo "</table>";
}

function admin_mod_useremailbe_change(){
if(
(isset($_POST['user_ad']))and
(isset($_POST['email_jova_elso_szak']))and
(isset($_POST['email_vissza_szak']))and
(isset($_POST['email_vissza_proj']))and
($_POST['user_ad']!="")and
(
 (
  ($_POST['email_jova_elso_szak']=="0")or
  ($_POST['email_jova_elso_szak']=="1")
 )
 and
 (
 ($_POST['email_vissza_szak']=="0")or
 ($_POST['email_vissza_szak']=="1")
 )
 and
 (
 ($_POST['email_vissza_proj']=="0")or
 ($_POST['email_vissza_proj']=="1")
 )
)
){
 $tmp_mod[0]=array();
 $tmp_mod[0]['email_jova_elso_szak']=$_POST['email_jova_elso_szak'];
 $tmp_mod[0]['email_vissza_szak']=$_POST['email_vissza_szak'];
 $tmp_mod[0]['email_vissza_proj']=$_POST['email_vissza_proj'];
 mod_egy_fel_tom('mira_user',$tmp_mod[0],'user_ad',$_POST['user_ad']);
 echo "ok$;$";
}
}

function admin_mod_userprojektjovahagyo_proj_katt(){
echo "ok$;$";

echo "Projekt jóváhagyás hozzárendelése <b>";
echo $_POST['user_nev'];
echo "</b> felhasználóhoz<br><br>";

echo "<b>Szűrés:</b><br>";
echo "<input onkeyup='admin_moduserprojektjovahagyo_hozz_keress(\"\",\"\")' user_ad='".$_POST['user_ad']."' id='userprojektjovahagyo_hozzid_keress' type=text style='width:250px'>";

echo "<br>Csak hozzárendelt tevékenységek: ";
echo "<input onchange='admin_moduserprojektjovahagyo_hozz_keress_proc(\"\",\"\")' id='userprojektjovahagyo_hozzid_csakhozz_szur' type='checkbox'>";

echo "<div id='userprojekt_hozzid_tal_div'>";
 $tomb_user=keres_admin_userhezprojektjovahagyo($_POST['user_ad'],"",0);
 $tomb_user_van=keres_userprojektjovahagyo_user_hozzarend_adat($_POST['user_ad']);
 admin_mod_userprojektjovahagyo_user_katt_list_ki($tomb_user,$tomb_user_van);
echo "</div>";

}

function admin_moduserprojektjovahagyo_hozz_keress(){
echo "ok$;$";
$tomb_user=keres_admin_userhezprojektjovahagyo($_POST['user_ad'],$_POST['projekt_nev'],$_POST['csakvan']);
$tomb_user_van=keres_userprojektjovahagyo_user_hozzarend_adat($_POST['user_ad']);
admin_mod_userprojektjovahagyo_user_katt_list_ki($tomb_user,$tomb_user_van);
}

function admin_mod_userprojektjovahagyo_user_katt_list_ki($tomb_user,$tomb_user_van){
if(is_array($tomb_user)){
echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
//echo '<th>ID';
echo '<th>Tevékenység neve';
echo '<th>Hozzárendelés';
//echo '<th>Tevékenység típus';
echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_user as $i => $ert){

if($i==0){
	$th=$ert['tal'];
}else{

if(isset($tomb_user_van[$ert['projekt_id']])){
 $ck=" checked";
}else{
 $ck="";
}

//echo "<tr".$css.">";
echo "<tr>";
//echo "<td>".$ert['projekt_id'];
echo "<td><label style='cursor:pointer' for='userprojektjovahagyo_hozzid_".$ert['projekt_id']."'>";
echo $ert['projekt_nev'];
if($ert['projekt_inaktiv']=='1')
	echo " (inaktív)";

echo "<td align=center>";
echo "<input".$ck." class='link' onchange='admin_moduserprojektjovahagyo_hozz_change(\"".$ert['projekt_id']."\",\"".$_POST['user_ad']."\")' name='userprojektjovahagyo_hozz' id='userprojektjovahagyo_hozzid_".$ert['projekt_id']."' type='checkbox'>";
echo "</label>";

/*echo "<td>";
echo projekt_tipus_ki($ert['projekt_tipus']);*/

echo "</tr>";

}
}
echo "</tbody></table>";

elozo_kovetkezo_gombok("admin_moduserprojektjovahagyo_hozz_keress_proc",$th,$GLOBALS['mira']['user_jog']['user_projektjovahagyohozza_keres_talszam'],$_POST['oldalholvagyok']);
echo "<div style='margin-top:5px'>";
//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['user_projektjovahagyohozza_keres_talszam'],"admin_moduserprojektjovahagyo_hozz_keress_proc","user_projektjovahagyohozza_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='user_projektjovahagyohozza_keres_tal_oldalholvagyok'>";

if(is_array($tomb_user)){
foreach($tomb_user as $i => $ert){
if($i==0){
 $th=$ert['tal'];
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['user_projektjovahagyohozza_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='user_projektjovahagyohozza_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['user_projektjovahagyohozza_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>admin_moduserprojektjovahagyo_hozz_keress_proc('tallep_elso','');</script>";
  }
 }
}}
excel_export("userhez_projektjovahagyo",$th);
}
echo "</div>";
}
}

function admin_moduserprojektjovahagyo_hozz_change(){
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

function admin_mod_user_szerv_katt(){
$szerv_mod_lehete=keres_user_van_nyitott_ho($_POST['user_ad']);

 echo "ok$;$";


echo "Szervezet módosítása a <b>";
echo $_POST['user_nev'];
echo "</b> felhasználnál<br><br>";


if(is_array($szerv_mod_lehete)){
 echo "<b>Figyelem! Felhasználónak van már megkezdett tevékenység rögzítése az alábbi ";
 if(sizeof($szerv_mod_lehete)==1){
  echo "hónapra:";
  $mod_ho='hónapot';
 }else{
  echo "hónapokra:";
  $mod_ho='hónapokat';
 }
 echo "</b><ul>";
 foreach($szerv_mod_lehete as $ert){
	 echo "<li><b>".$ert['rogzit_ho']."</b> ";
	 if($ert['ellenorzesre_lezarva']==0) echo "Nincs lezárva";
	 elseif($ert['ellenorzesre_ok']==0) echo "Nincs jóváhagyva";
 }
 echo "</ul>";
echo 'Szervezet módosítása érinti ezt a '.$mod_ho.'!<br><br>';
}

echo "<b>Szűrés:</b><br>";
echo "<input onkeyup='admin_moduser_szerv_hozz_keress(\"".$_POST['user_ad']."\")' id='user_szerv_hozzid_keress' type=text style='width:250px'>";

echo "<div id='user_szerv_hozzid_tal_div'>";
 //$tomb_szerv=keres_mit1_order("mira_szerv","szerv_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"szerv_nev","asc");
 $tomb_szerv=keres_all_order("mira_szerv","szerv_nev","asc");
 $tomb_szerv_van=keres_mit1_mit1_csak_ertek("mira_user","user_ad",$_POST['user_ad'],"szerv_id");
 admin_mod_user_szerv_katt_list_ki($tomb_szerv,$tomb_szerv_van,"all");
echo "</div>";
}

function admin_moduser_szerv_hozz_keress(){
echo "ok$;$";
//$tomb_szerv=keres_mit1_order("mira_szerv","szerv_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"szerv_nev","asc");
$tomb_szerv=keres_all_order("mira_szerv","szerv_nev","asc");
$tomb_szerv_van=keres_mit1_mit1_csak_ertek("mira_user","user_ad",$_POST['user_ad'],"szerv_id");
$tomb_szerv_lat=keres_szerv_akt_nevlike_inaktivis($_POST['szerv_nev']);
admin_mod_user_szerv_katt_list_ki($tomb_szerv,$tomb_szerv_van,$tomb_szerv_lat);

}

function admin_mod_user_szerv_katt_list_ki($tomb_szerv,$tomb_szerv_van,$tomb_szerv_lat){
if(is_array($tomb_szerv)){
echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
echo '<th>ID';
echo '<th>Szervezet neve';
echo '<th>Hozzárendelés';
echo '<th>Inaktív';
echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_szerv as $i => $ert){

if($tomb_szerv_van==$ert['szerv_id']){
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

){
 $css="";
}else{
 $css=" style='display:none'";
}

echo "<tr".$css.">";
echo "<td>".$ert['szerv_id'];
echo "<td><label style='cursor:pointer' for='user_szerv_hozzid_".$ert['szerv_id']."'>";
echo $ert['szerv_nev'];

echo "<td>";
if($ert['szerv_inaktiv']==1)
 $dis=" disabled";
else $dis="";
echo "<input".$ck.$dis." class='link' onchange='admin_moduser_szerv_hozz_change(\"".$ert['szerv_id']."\",\"".$_POST['user_ad']."\")' name='user_szerv_hozz' id='user_szerv_hozzid_".$ert['szerv_id']."' type='radio'>";
echo "</label>";

//Inaktív
echo "<td>";
echo igennem_kod_ki($ert['szerv_inaktiv']);

echo "</tr>";

}
echo "</tbody></table>";
}
}

function admin_moduser_szerv_hozz_change(){
if(
(isset($_POST['szerv_id']))and
(isset($_POST['user_ad']))and
($_POST['szerv_id']!="")and
($_POST['user_ad']!="")
){

mysqli_autocommit($GLOBALS['mysqli'],false);
 
$szerv_mod_lehete=keres_user_van_nyitott_ho($_POST['user_ad']);
if(is_array($szerv_mod_lehete)){
foreach($szerv_mod_lehete as $ert){
 
 $tmp_mod=array();
 $tmp_mod[0]['szerv_id']=$_POST['szerv_id'];
 mod_egy_fel_tom2('rogzit',$tmp_mod[0],'user_ad',$_POST['user_ad'],"rogzit_ho",$ert['rogzit_ho']);
 
}
}

 $tmp_mod[0]=array();
 $tmp_mod[0]['szerv_id']=$_POST['szerv_id'];
 mod_egy_fel_tom('mira_user',$tmp_mod[0],'user_ad',$_POST['user_ad']);
 
 mysqli_commit($GLOBALS['mysqli']);
 mysqli_autocommit($GLOBALS['mysqli'],true);
 
 echo "ok$;$";
}
}



function admin_mod_user_maxido_change(){
if(
(isset($_POST['maxido']))and($_POST['maxido']!="")
and(isset($_POST['maxidoperc']))and($_POST['maxidoperc']!="")
){

if($_POST['maxido']=='global'){
 $tmp_mod[0]['user_napi_ido_max_ora']=0;
 $tmp_mod[0]['user_napi_ido_max_perc']=0;
}else{
 $tmp_mod[0]['user_napi_ido_max_ora']=$_POST['maxido'];
 $tmp_mod[0]['user_napi_ido_max_perc']=$_POST['maxidoperc'];
}

mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_POST['user_ad']);	
echo "ok$;$";
}else{
	
}
}

function admin_moduserprojekt_katkivetel_change(){
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
  //mod_egy_fel_tom2('projekt_user',$tmp_mod[0],'projekt_id',$_POST['projekt_id'],'user_ad',$_POST['user_ad']);
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


?>