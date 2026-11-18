<?php

function ful_letolt(){
if(isset($_POST['ful'])){
switch($_POST['ful']){

 case'ful_rogzit':
  
  include_once("config_uj.php");
 include_once("function.php");
 include_once("function_mysql.php");
 include_once("ajax_func.php");
 include_once("rogzit_table.php");
 
 if(!isset($_SESSION[$GLOBALS['sessionname']])){//inaktív user esetén ez nincs
  echo "nologin$;$";
 }else{
  echo "ok$;$";//Fül első betöltése
  //ho_fotable_ki();
  
  echo "<div id='fo_table_evho' class='idoszak_div'>";
  ho_fotable_ki();
  echo "</div>";
  
  echo "<div id='fodiv'>";
  fo_bevitel_honap_kirajzol($_SESSION[$GLOBALS['sessionname']]['ev_ki'],$_SESSION[$GLOBALS['sessionname']]['ho_ki']);
  echo "</div>";
 }
 break;
 
 case'ful_rogzit_jovahagy':
  echo "ok$;$";
  include_once("rogzit_jovahagy.php");
  jovahagy_ful_ki();
 break;
 
 case'ful_stat':
  echo "ok$;$";
  include_once("rogzit_stat.php");
  stat_ful_ki();
 break;
 
  case'ful_riport':
  echo "ok$;$";
  include_once("riport.php");
  riport_ful_ki();
 break;
 
 case'ful_admin':
  if(
  (isset($_SESSION[$GLOBALS['sessionname']]['jog']['ful_admin']))and
  ($_SESSION[$GLOBALS['sessionname']]['jog']['ful_admin']==1)
  ){
  echo "ok$;$";
  //echo '<div class="div_fiz_jovahagy">';
  ful_admin_fulek();
  //echo '</div>';
  }else{
	  echo "ok$;$"."<b>Nincs jogosultságod</b>";
  }
 break;

}

}

}

function ful_fiz_admim_muv($muv_kod,$muv_nev){
if(
($GLOBALS[$GLOBALS['sessionname']]['ful_admin_all']==1)or
(
 ($GLOBALS[$GLOBALS['sessionname']]['ful_admin']==1)and
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful'][$muv_kod]))and
 ($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful'][$muv_kod]=='1')
)
){
 echo '<option value="'.$muv_kod.'"';
 if($GLOBALS[$GLOBALS['sessionname']]['user_admin_muvelet']==$muv_kod)echo " selected";
 echo '>'.$muv_nev;
}
}

function ful_admin_fulek(){
echo '<div style="height:25px;overflow-x:auto">';
echo "Művelet: ";

echo "<select style='width:410px' onchange='admin_muv_sel()' id='admin_muvelet' class='select3'>";

echo "<option value='keremv'>Kérem válassz";

if(ful_admin_fulek_igaze_mira()){
 echo '<optgroup label="MIRA">';
}

ful_fiz_admim_muv('admin_user_mod','Jogosultság');
ful_fiz_admim_muv('admin_szerv_mod','Szervezet');
ful_fiz_admim_muv('admin_csop_nev_mod','Szervezet csoportosítás');
ful_fiz_admim_muv('admin_proj_mod','Tevékenység');
ful_fiz_admim_muv('admin_arazasref_mod','Árazási relevancia mező');
ful_fiz_admim_muv('admin_kat_nev_mod','Önköltség kategória');//Tevékenység kategória

ful_fiz_admim_muv('admin_szolg_kod_mod','Szolgáltatás kód');
ful_fiz_admim_muv('admin_munkanapglobal_mod','Munkanap áthelyezés globálisan');
ful_fiz_admim_muv('admin_munkanapuser_mod','Munkanap áthelyezés felhasználóra');
ful_fiz_admim_muv('admin_honapzaras_mod','Hónap végleges lezárása');
ful_fiz_admim_muv('admin_hibajavitas_mod','Hibajavítás');
ful_fiz_admim_muv('admin_log','Log');

if(ful_admin_fulek_igaze_terv())
 echo '<optgroup label="Tervezés">';
 ful_fiz_admim_muv('admin_tervezes_mod','Terv betöltés');
 ful_fiz_admim_muv('admin_tenypotlas_mod','Ténybetöltő - MIRA-n kívüli adatok');
 ful_fiz_admim_muv('admin_tenypotlastig_mod','Ténybetöltő - MIRA-n kívüli adatok TIG táblához');
if(ful_admin_fulek_igaze_terv())
 echo '</optgroup>';

if(ful_admin_fulek_igaze_mira()){
 echo '</optgroup>';
}

if(ful_admin_fulek_igaze_kapcs()){
 echo '<optgroup label="Kapcsolódó adatok">';
}

ful_fiz_admim_muv('admin_tagv_kod_mod','Társasági adatok');
ful_fiz_admim_muv('admin_kapcstulaj_mod','Tulajdonosi joggyakorló lista');
ful_fiz_admim_muv('admin_kapcstorzs_mod','Kapcsolattartó törzsadatok');
ful_fiz_admim_muv('admin_kapcsossze_mod','Társasági szolgáltatási kapcsolattartók');

if(ful_admin_fulek_igaze_kapcs()){
 echo '</optgroup>';
}

if(ful_admin_fulek_igaze_szerz()){
 echo '<optgroup label="Szerződésnyilvántartó">';
}
//echo '<optgroup label="Szerződésnyilvántartó alapadatok">';
 ful_fiz_admim_muv('admin_szerz_szerztipus','Szerződés típus');
 ful_fiz_admim_muv('admin_szerz_szolgcsop','Szolgáltatás csoport');
 ful_fiz_admim_muv('admin_szerz_elsztipus','Elszámolás típusa');
 ful_fiz_admim_muv('admin_szerz_nattipus','Naturália típus');
 
 ful_fiz_admim_muv('admin_szerz_szerzusergazda','Szerződésgazda');
  //echo '</optgroup>';
 
 //echo '<optgroup label="Szerződésnyilvántartó szerződések">';
 ful_fiz_admim_muv('admin_szerz_tarskat','Társaság kategória');
 ful_fiz_admim_muv('admin_szerz_szerzalapadat','Szerződés alapadatok');
 ful_fiz_admim_muv('admin_szerz_szerzfeltolt','Szerződés feltöltése');
 ful_fiz_admim_muv('admin_szerz_szolgkapadat','Szolgáltatáshoz kapcsolódó adatok');
 ful_fiz_admim_muv('admin_szerz_szolgmodadat','Szolgáltatás módosításhoz kapcsolódó adatok');
 //ful_fiz_admim_muv('admin_szerz_szolgmegszun','Szolgáltatás megszüntetése');
 ful_fiz_admim_muv('admin_szerz_integadat','Integrációs adatok');
 //echo '</optgroup>';

if(ful_admin_fulek_igaze_szerz()){
 echo '</optgroup>';
}

if(ful_admin_fulek_igaze_szerz_kieg()){
 echo '<optgroup label="Szerződéskatalógus – TIGeléshez kapcsolódó adatok">';
}	
 ful_fiz_admim_muv('admin_szerz_tigadat_penznem','Devizanem és árfolyam');
 ful_fiz_admim_muv('admin_szerz_tigadat_co','CO objektum');
 ful_fiz_admim_muv('admin_szerz_tigadat_sapszam','SAP szerződésszám');
 ful_fiz_admim_muv('admin_szerz_tigadat_vevoazon','Vevő azonosító');
 ful_fiz_admim_muv('admin_szerz_tigadat_nemszerz','Nem szerződés alapján TIG-elendő tételek');
if(ful_admin_fulek_igaze_kpi()){
 echo '</optgroup>';
}

if(ful_admin_fulek_igaze_kpi()){
 echo '<optgroup label="KPI">';
}
 ful_fiz_admim_muv('admin_kpi_szolgkod','KPI szolgáltatás kód');
 ful_fiz_admim_muv('admin_kpi_tipus','KPI típusok');
 ful_fiz_admim_muv('admin_kpi_osszekap','KPI típus - szerződés összerendelés');
if(ful_admin_fulek_igaze_kpi()){
 echo '</optgroup>';
}


echo "</select>";
echo '</div>';
echo "<div style='margin-top:10px' id='admin_tal'></div>";

}

function ful_admin_fulek_igaze_mira(){
if(
($GLOBALS[$GLOBALS['sessionname']]['ful_admin_all']==1)or
(
 ($GLOBALS[$GLOBALS['sessionname']]['ful_admin']==1)and
 (
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_user_mod']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_user_mod']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerv_mod']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerv_mod']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_csop_nev_mod']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_csop_nev_mod']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_proj_mod']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_proj_mod']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_arazasref_mod']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_arazasref_mod']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_kat_nev_mod']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_kat_nev_mod']=='1')or

 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szolg_kod_mod']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szolg_kod_mod']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_munkanapglobal_mod']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_munkanapglobal_mod']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_munkanapuser_mod']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_munkanapuser_mod']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_honapzaras_mod']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_honapzaras_mod']=='1')
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_log']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_log']=='1')
 )
)
){
 return true;
}else{
 return false;
}
}

function ful_admin_fulek_igaze_terv(){
if(
($GLOBALS[$GLOBALS['sessionname']]['ful_admin_all']==1)or
(
 ($GLOBALS[$GLOBALS['sessionname']]['ful_admin']==1)and
 (
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_tervezes_mod']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_tervezes_mod']=='1')
 //or
 )
)
){
 return true;
}else{
 return false;
}
}

function ful_admin_fulek_igaze_szerz(){
if(
($GLOBALS[$GLOBALS['sessionname']]['ful_admin_all']==1)or
(
 ($GLOBALS[$GLOBALS['sessionname']]['ful_admin']==1)and
 (
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_szerzalapadat']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_szerzalapadat']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_szerzfeltolt']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_szerzfeltolt']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_tarskat']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_tarskat']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_szolgkapadat']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_szolgkapadat']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_szolgmodadat']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_szolgmodadat']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_szolgmegszun']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_szolgmegszun']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_integadat']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_integadat']=='1')
 )
)
){
 return true;
}else{
 return false;
}
}

function ful_admin_fulek_igaze_szerz_kieg(){
if(
($GLOBALS[$GLOBALS['sessionname']]['ful_admin_all']==1)or
(
 ($GLOBALS[$GLOBALS['sessionname']]['ful_admin']==1)and
 (
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_tigada']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_tigada']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_tigadat_sapszam']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_szerz_tigadat_sapszam']=='1')
 )
)
){
 return true;
}else{
 return false;
}
}

function ful_admin_fulek_igaze_kpi(){
if(
($GLOBALS[$GLOBALS['sessionname']]['ful_admin_all']==1)or
(
 ($GLOBALS[$GLOBALS['sessionname']]['ful_admin']==1)and
 (
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_jog_admin_kpi_szolgkod']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_jog_admin_kpi_szolgkod']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_jog_admin_kpi_tipus']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_jog_admin_kpi_tipus']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_jog_admin_kpi_osszekap']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_jog_admin_kpi_osszekap']=='1')
 )
)
){
 return true;
}else{
 return false;
}
}

function ful_admin_fulek_igaze_kapcs(){
if(
($GLOBALS[$GLOBALS['sessionname']]['ful_admin_all']==1)or
(
 ($GLOBALS[$GLOBALS['sessionname']]['ful_admin']==1)and
 (
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_tagv_kod_mod']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_tagv_kod_mod']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_kapcstulaj_mod']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_kapcstulaj_mod']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_kapcstorzs_mod']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_kapcstorzs_mod']=='1')or
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_kapcsossze_mod']))and($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']['admin_kapcsossze_mod']=='1')
 )
)
){
 return true;
}else{
 return false;
}
}

function proj_kov_sor(){

echo 'ok$;$';

$ev=$_POST['ev'];
$nap_akt=$_POST['nap_akt'];
$sorsz=$_POST['sorsz_uj'];

echo '<span class="proj_span" id="span_proj_'.$nap_akt.'_'.$sorsz.'">';
echo '<div class="proj_span_b">';
 raford_time_ki($nap_akt,$sorsz,"");

//Projekt neve
echo ' - ';
echo '</div>';
echo '<div class="proj_span_b">';
 raford_projekt_ki($ev,$nap_akt,$sorsz,"");

//echo '<br>';
echo '</div>';
echo '</span>';

}


function raford_projekt_ki($ev,$nap_akt,$sorsz,$tomb_mentve_ido){

//last_sel_id lementésére gondolj!!!!!

if(is_array($tomb_mentve_ido)){
	$sel_id=$tomb_mentve_ido['projekt_id'];
}else{
	$sel_id='';
}

echo '<select last_sel_id="'.$sel_id.'" class="sel_proj" onchange="raford_projekt_select(\''.$ev.'\',\''.$nap_akt.'\',\''.$sorsz.'\')" sorsz="'.$sorsz.'" nap="'.$nap_akt.'" id="proj_'.$nap_akt.'_'.$sorsz.'">';
//echo "<option value='1'>Müködés támogatás";

if(is_array($tomb_mentve_ido)){
 if($tomb_mentve_ido['projekt_title']==""){
  //$title="<b>".$tomb_mentve_ido['projekt_nev']."</b>";
  $title='';
 }else{
  $title='title="<b>'.$tomb_mentve_ido['projekt_nev'].'</b><br>'.str_replace("\r\n",'<br>',$tomb_mentve_ido['projekt_title']).'"';
  //$title='title="<b>'.$tomb_mentve_ido['projekt_nev'].'</b><br>'.str_replace(array("\r\n", "\r", "\n"), "<br>",$tomb_mentve_ido['projekt_title']).'"';
  //$title='title="<b>'.$tomb_mentve_ido['projekt_nev'].'</b><br>'.nl2br($tomb_mentve_ido['projekt_title']).'"';
 } 
 echo '<option style="display:none" '.$title.' value="'.$tomb_mentve_ido['projekt_id'].'">'.$tomb_mentve_ido['projekt_nev'];
}else{
	echo '<option style="display:none" value="keremv">Kérem válassz';
}

//echo "<option value=''>Kérem válassz";
/*
echo "<option value=''>Kérem válassz";
echo "<option value='1'>Projekt1";
echo "<option value='2'>Projekt2";
echo "<option value='2'>Projekt2";
echo "<option value='3'>Projekt33333333333333333333333333333333333";
*/

echo '</select>';
if(is_array($tomb_mentve_ido)){
 $megj_img_style='';
}else{
  $megj_img_style=' style="display:none"';
}

if
(
(!isset($tomb_mentve_ido['rogzit_sor_megj']))or
($tomb_mentve_ido['rogzit_sor_megj']=="0")
)
 $meg_img='comment_2.png';
else
 $meg_img='comment_2_pir.png';

echo '<img title="Megjegyzés rögzítése" onclick="raford_projekt_meg_katt(\''.$nap_akt.'\',\''.$sorsz.'\')" src="image\\'.$meg_img.'" class="select2_proj_megj_img"'.$megj_img_style.' id="projmegjimg_'.$nap_akt.'_'.$sorsz.'">';
}

function raford_time_ki($nap_akt,$sorsz,$tomb_mentve_ido){

$maxlength=4;
if(is_array($tomb_mentve_ido)){
 if($tomb_mentve_ido['rogzit_perc']<10)$tomb_mentve_ido['rogzit_perc']="0".$tomb_mentve_ido['rogzit_perc'];
 $val=$tomb_mentve_ido['rogzit_ora'].':'.$tomb_mentve_ido['rogzit_perc'];
 $kitoltheto='1';
 if($tomb_mentve_ido['rogzit_ora']>9)
  $maxlength=5;
 $dis='';
 $class_inp='input_time';
}else{
 $val='0:00';
 $kitoltheto='0';
 $dis='disabled ';
 $class_inp='input_time_dis';
}	

echo '<input '.$dis.'kitoltheto="'.$kitoltheto.'" max_ora="'.$GLOBALS['mira']['napi_ido_max_ora'].'" max_perc="'.$GLOBALS['mira']['napi_ido_max_perc'].'" max="'.$GLOBALS['mira']['napi_ido_max'].'" min="0:00" type=text class="'.$class_inp.'" value="'.$val.'" id="input_proj_'.$nap_akt.'_'.$sorsz.'" maxlength='.$maxlength.'>';
}

function rogzito_helyettes_beallit(){
echo "ok$;$";

$user_ad=$_SESSION[$GLOBALS['sessionname']]['helyettes_beallit_ad'];

$user_nev=keres_mit1_mit1_csak_ertek("mira_user","user_ad",$user_ad,"user_nev");
echo "Rögzítő helyettes beállítása <b>".$user_nev."</b> felhasználóhoz<br><br>";
 
echo "<b>Szűrés:</b><br>";
echo "<input autocomplete='off' onkeyup='user_modhelyettes_hozz_keress(\"\",\"\")' id='modhelyettes_hozzid_keress' type=text style='width:250px'>";

echo "<br>Csak helyettesek: ";
echo "<input onchange='user_modhelyettes_hozz_keress_proc(\"\",\"\")' id='modhelyettes_hozzid_csakhozz_szur' type='checkbox'>";

echo "<div id='userhelyettes_hozzid_tal_div'>";
 $tomb_helyettes=keres_helyettes_bellithoz_user($user_ad,"","0");
 $tomb_helyettes_van=keres_userhelyettes_hozzarend_adat($user_ad);
 admin_mod_user_helyettes_katt_list_ki($tomb_helyettes,$tomb_helyettes_van,$user_ad);
echo "</div>";

}

function user_modhelyettes_hozz_keress(){
echo "ok$;$";
$user_ad=$_SESSION[$GLOBALS['sessionname']]['helyettes_beallit_ad'];
$tomb_helyettes=keres_helyettes_bellithoz_user($user_ad,$_POST['keress_nev'],$_POST['csakvan']);
$tomb_helyettes_van=keres_userhelyettes_hozzarend_adat($user_ad);
admin_mod_user_helyettes_katt_list_ki($tomb_helyettes,$tomb_helyettes_van,$user_ad);
}

function admin_mod_user_helyettes_katt_list_ki($tomb_helyettes,$tomb_helyettes_van,$user_ad_kire){

if(is_array($tomb_helyettes)){
echo "<table style='margin-top:10px' class='table_emre'>";

echo '<thead>';
echo '<tr>';
echo '<th>AD';
echo '<th>Név';
echo '<th>Hozzárendelés';
echo '</tr>';
echo '</thead><tbody>';

foreach($tomb_helyettes as $i => $ert){

if($i==0){
	$th=$ert['tal'];
}else{

if(isset($tomb_helyettes_van[$ert['user_ad']])){
 $ck=" checked";
}else{
 $ck="";
}

//echo "<tr".$css.">";
echo "<tr>";
echo "<td>".$ert['user_ad'];
echo "<td><label style='cursor:pointer' for='userhelyettes_hozzid_".$ert['user_ad']."'>";
echo $ert['user_nev'];

echo "<td align=center>";
echo "<input".$ck." class='link' onchange='user_modhelyettes_hozz_change(\"".$ert['user_ad']."\")' name='userhelyettes_hozzid_' id='userhelyettes_hozzid_".$ert['user_ad']."' type='checkbox'>";
echo "</label>";

echo "</tr>";

}
}
echo "</tbody></table>";

elozo_kovetkezo_gombok("user_modhelyettes_hozz_keress_proc",$th,$GLOBALS['mira']['user_jog']['user_modhelyettes_keres_talszam'],$_POST['oldalholvagyok']);
echo "<div style='margin-top:5px'>";
//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['user_modhelyettes_keres_talszam'],"user_modhelyettes_hozz_keress_proc","user_modhelyettes_keres_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='user_modhelyettes_keres_tal_oldalholvagyok'>";

if(is_array($tomb_helyettes)){
foreach($tomb_helyettes as $i => $ert){
if($i==0){
 $th=$ert['tal'];
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['user_modhelyettes_keres_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='user_modhelyettes_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['user_modhelyettes_keres_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>user_modhelyettes_hozz_keress_proc('tallep_elso','');</script>";
  }
 }
}}
excel_export("user_helyettes",$th);
}
echo "</div>";
}
}

function user_modhelyettes_hozz_change(){

if(
(isset($_SESSION[$GLOBALS['sessionname']]['helyettes_beallit_ad']))and
($_SESSION[$GLOBALS['sessionname']]['helyettes_beallit_ad']!="")and
(isset($_POST['user_ad']))and
(isset($_POST['mit']))and
($_POST['user_ad']!="")and
($_POST['mit']!="")
){

if($_POST['mit']==0){//törlés
 torles2("mira_user_helyettes","user_ad",$_SESSION[$GLOBALS['sessionname']]['helyettes_beallit_ad'],"user_ad_helyettes",$_POST['user_ad']);
 echo "ok$;$";
}else{//Felvisszük
  $tmp_bk_ker_def[0]=array();
  $tmp_bk_ker_def[0]['user_ad']=$_SESSION[$GLOBALS['sessionname']]['helyettes_beallit_ad'];
  $tmp_bk_ker_def[0]['user_ad_helyettes']=$_POST['user_ad'];
  be_visz_replace("mira_user_helyettes",$tmp_bk_ker_def);
  echo "ok$;$";
}
	
}

}

function raford_projekt_meg_katt(){

rogzitheto_ho_e_hanem_reload();

if(
 (isset($_POST['nap_akt']))and
 (isset($_POST['projekt_id']))and
 ($_POST['nap_akt']!='')and
 ($_POST['projekt_id']!='')
){

echo 'ok$;$';

/*
echo 'Év: '.$_SESSION[$GLOBALS['sessionname']]['ev_ki'];
echo ' Hó: '.$_SESSION[$GLOBALS['sessionname']]['ho_ki'];
echo ' Nap: '.$_POST['nap_akt'];
echo ' Sorsz: '.$_POST['sorsz'];
*/

if($_SESSION[$GLOBALS['sessionname']]['ho_ki']<10)
 $ho='0'.$_SESSION[$GLOBALS['sessionname']]['ho_ki'];
else $ho=$_SESSION[$GLOBALS['sessionname']]['ho_ki'];

if($_POST['nap_akt']<10)
 $nap='0'.$_POST['nap_akt'];
else $nap=$_POST['nap_akt'];

//echo 'Megjegyzés rögzítése a '.$_SESSION[$GLOBALS['sessionname']]['ev_ki'].'.'.$ho.'.'.$nap.'. napra rögzített <b>'.keress_rogzitett_egynaphoz_proj_nev_aktuser($_SESSION[$GLOBALS['sessionname']]['ev_ki'],$_SESSION[$GLOBALS['sessionname']]['ho_ki'],$_POST['nap_akt'],$_POST['sorsz']).'</b> tevékenységhez';
echo 'Megjegyzés rögzítése: <b>';

//$tev_nev=keress_rogzitett_egynaphoz_proj_nev_aktuser($_SESSION[$GLOBALS['sessionname']]['ev_ki'],$_SESSION[$GLOBALS['sessionname']]['ho_ki'],$_POST['nap_akt'],$_POST['sorsz']);

$tev_nev=keres_mit1_mit1_csak_ertek('projekt','projekt_id',$_POST['projekt_id'],'projekt_nev');
echo $tev_nev;

echo '</b> tevékenységhez, '.$_SESSION[$GLOBALS['sessionname']]['ev_ki'].'.'.$ho.'.'.$nap.'. napra';
//echo ''.$_SESSION[$GLOBALS['sessionname']]['ev_ki'].'.'.$ho.'.'.$nap.'.  rögzített <b>'.keress_rogzitett_egynaphoz_proj_nev_aktuser($_SESSION[$GLOBALS['sessionname']]['ev_ki'],$_SESSION[$GLOBALS['sessionname']]['ho_ki'],$_POST['nap_akt'],$_POST['sorsz']).'</b> tevékenységhez megjegyzés rögzítése:';

echo '<textarea id="proj_egysor_megj" class="proj_egysor_megj">';
echo keress_rogzitett_egynaphoz_rogzit_sor_megj_aktuser($_SESSION[$GLOBALS['sessionname']]['ev_ki'],$_SESSION[$GLOBALS['sessionname']]['ho_ki'],$_POST['nap_akt'],$_POST['projekt_id']);
echo '</textarea>';
}else{
 echo 'adathiány';
}
}

function raford_projekt_meg_katt_dialog_mentes(){

if(
 (isset($_POST['nap_akt']))and
 (isset($_POST['sorsz']))and
 (isset($_POST['projekt_id']))and
 (isset($_POST['rogzit_sor_megj']))and
 ($_POST['nap_akt']!='')and
 ($_POST['sorsz']!='')and
 ($_POST['projekt_id']!='')
){

//rogzit_id kitalálása
$rogzit_id=keress_rogzitett_egynaphoz_rogzit_id_aktuser($_SESSION[$GLOBALS['sessionname']]['ev_ki'],$_SESSION[$GLOBALS['sessionname']]['ho_ki'],$_POST['nap_akt']);

if($rogzit_id!=''){
 $tmp_mod=array();
 if($_POST['rogzit_sor_megj']!='')
  $tmp_mod[0]['rogzit_sor_megj']=$_POST['rogzit_sor_megj'];
 else
  $tmp_mod[0]['rogzit_sor_megj']=null;
 //mod_egy_fel_tom2('rogzit_sor',$tmp_mod[0],'rogzit_id',$rogzit_id,"sorsz",$_POST['sorsz']);
 mod_egy_fel_tom2('rogzit_sor',$tmp_mod[0],'rogzit_id',$rogzit_id,"projekt_id",$_POST['projekt_id']);
 echo 'ok$;$';
}else{
 echo 'Adathiány2';
}

}else{
 echo 'Adathiány1';
}
}
?>