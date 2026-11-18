<?php

include_once('riport_func.php');
include_once('riport_tervteny.php');

function riport_tipus_change(){
if(
 (isset($_POST['tipus']))and($_POST['tipus']!='')
){
 $_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=$_POST['tipus'];
 echo 'ok$;$';
 
 if($_POST['tipus']=='kapcs_ossze'){
  include_once('riport_kapcsossze.php');
  riport_ful_ki_kapcs_ossze_html();
 }elseif($_POST['tipus']=='szerznyilv'){
  include_once('riport_szerznyilv.php');
  riport_ful_ki_szerznyilv_html();	 
 }elseif($_POST['tipus']=='szerznyilv_elo'){
  include_once('riport_szerznyilv_elo.php');
  riport_ful_ki_szerznyilv_elo_html();	 
 }
 
}else{
 echo 'adathiány';
}
}

function riport_teny3_1_1_ev1_change(){
if(
 (isset($_POST['ev1']))and($_POST['ev1']!='')
){
 $_SESSION[$GLOBALS['sessionname']]['riport']['teny3_1_1']['ev1']=$_POST['ev1'];
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function riport_teny3_3_ev1_change(){
if(
 (isset($_POST['ev1']))and($_POST['ev1']!='')
){
 $_SESSION[$GLOBALS['sessionname']]['riport']['teny3_3']['ev1']=$_POST['ev1'];
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function riport_teny3_2_ev1_change(){
if(
 (isset($_POST['ev1']))and($_POST['ev1']!='')
){
 $_SESSION[$GLOBALS['sessionname']]['riport']['teny3_2']['ev1']=$_POST['ev1'];
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function riport_teny3_ev1_change(){
if(
 (isset($_POST['ev1']))and($_POST['ev1']!='')
){
 $_SESSION[$GLOBALS['sessionname']]['riport']['teny3']['ev1']=$_POST['ev1'];
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function riport_teny3_elteres_ev1_change(){
if(
 (isset($_POST['ev1']))and($_POST['ev1']!='')
){
 $_SESSION[$GLOBALS['sessionname']]['riport']['teny3_elteres']['ev1']=$_POST['ev1'];
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function riport_nonp_ev1_change(){
if(
 (isset($_POST['ev1']))and($_POST['ev1']!='')
){
 $_SESSION[$GLOBALS['sessionname']]['riport']['nonp']['ev1']=$_POST['ev1'];
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function riport_ful_ki(){

$tomb_riport_aljog=keres_riport_tipusjogspan_aljog($_SESSION[$GLOBALS['sessionname']]['login_ad']);

 if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')){//Ha áll jog van, akkor ez a default
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='nonp';
 }elseif(isset($tomb_riport_aljog['nonp'])){
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='nonp';
 }elseif(isset($tomb_riport_aljog['tervteny'])){
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='tervteny';
 }elseif(isset($tomb_riport_aljog['teny3_1_1_szervcsop'])){
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='teny3_1_1_szervcsop';
 }elseif(isset($tomb_riport_aljog['teny3_1_1'])){
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='teny3_1_1';
 }elseif(isset($tomb_riport_aljog['teny3_2'])){
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='teny3_2';
 }elseif(isset($tomb_riport_aljog['teny3_3'])){
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='teny3_3';
 }elseif(isset($tomb_riport_aljog['teny3'])){
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='teny3';
 }elseif(isset($tomb_riport_aljog['teny3_elteres'])){
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='teny3_elteres';
 }elseif(isset($tomb_riport_aljog['kapcs_ossze'])){
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='kapcs_ossze';
 }elseif(isset($tomb_riport_aljog['szerznyilv'])){
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='szerznyilv';
 }elseif(isset($tomb_riport_aljog['szerznyilv_elo'])){
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='szerznyilv_elo';
 }elseif(isset($tomb_riport_aljog['proj_k99'])){
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='proj_k99';
 }elseif(isset($tomb_riport_aljog['proj_beszkoz'])){
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='proj_beszkoz';
 }elseif(isset($tomb_riport_aljog['kpi_riport'])){
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='kpi_riport';
 }elseif(isset($tomb_riport_aljog['tig_tabla'])){
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='tig_tabla';
 }elseif(isset($tomb_riport_aljog['admin_user'])){
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='admin_user';
 }elseif(isset($tomb_riport_aljog['admin_szerv'])){
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='admin_szerv';
 }elseif(isset($tomb_riport_aljog['admin_proj'])){
  $_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val']='admin_proj';
 }else{
	echo '<b>Jogosultság hiba!</b>';
	exit;
 }

if(!isset($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val'])){
 $_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=$_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val'];
}elseif(
($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='0')and
(!isset($tomb_riport_aljog[$_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']]))
){//Megjegyzet értékre van-e joga?
 $_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=$_SESSION[$GLOBALS['sessionname']]['riport_t']['tipus_val'];
}
 

// Rövid referencia a hosszú session úthoz (sokkal olvashatóbb)
$riport_rov = &$_SESSION[$GLOBALS['sessionname']]['riport'];
$tipus_rov  = $riport_rov['tipus_val'] ?? '';   // ha esetleg nincs, ne legyen warning

// Minden lehetséges riporttípus listája (itt bővíthető egy helyen!)
$tipusok = [
    'nonp',
    'tervteny',
    'teny3_1_1_szervcsop',
    'teny3_1_1',
    'teny3_2',
    'teny3_3',
    'teny3',
    'teny3_elteres',
    'kapcs_ossze',
    'szerznyilv',
    'szerznyilv_elo',
    'proj_k99',
    'proj_beszkoz',
    'kpi_riport',
    'tig_tabla',
    'admin_user',
    'admin_szerv',
    'admin_proj'
];

// Egyetlen ciklusban állítunk be mindent
foreach ($tipusok as $t) {
    $riport_rov[$t]['keres_lathato'] = ($t === $tipus_rov) ? 1 : 0;
}

echo '<div class="rip_divteje">';

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='0')and(!is_array($tomb_riport_aljog))){
 echo '<b>Jogosultság hiba!</b>';
 exit;
}

echo '<span class="jovahagy_szur_str">Riport típusa</span> ';
echo '<select onchange="riport_tipus_change()" class="select3" id="riport_tipus" style="width:540px">';//330

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['nonp']))){
 echo '<option value="nonp"';
 if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='nonp') echo ' selected';
 echo '>Nonproduktív riport';
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['tervteny']))){
 echo '<option value="tervteny"';
 if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='tervteny') echo ' selected';
 echo '>Terv-tény';
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['teny3_1_1']))){
 echo '<option value="teny3_1_1"';
 if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='teny3_1_1') echo ' selected';
 echo '>Felhasználónkénti tevékenység összesítés - 3.1.1';
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['teny3_1_1_szervcsop']))){
 echo '<option value="teny3_1_1_szervcsop"';
 if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='teny3_1_1_szervcsop') echo ' selected';
 echo '>Felhasználónkénti tevékenység összesítés - 3.1.1 Szervezet csoportosítás';
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['teny3_2']))){
 echo '<option value="teny3_2"';
 if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='teny3_2') echo ' selected';
 echo '>Szervezetenkénti tevékenység összesítés - 3.2';
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['teny3_3']))){
 echo '<option value="teny3_3"';
 if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='teny3_3') echo ' selected';
 echo '>Tevékenység összesítés - 3.3';
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['teny3']))){
 echo '<option value="teny3"';
 if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='teny3') echo ' selected';
 echo '>Aktuális tevékenység kód - Társaság kód összesítés - 3';
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['teny3_elteres']))){
 echo '<option value="teny3_elteres"';
 if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='teny3_elteres') echo ' selected';
 echo '>Tény-terv eltérés - 3';
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['kapcs_ossze']))){
 echo '<option value="kapcs_ossze"';
 if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='kapcs_ossze') echo ' selected';
 echo '>Kapcsolattartó adatok';
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['szerznyilv']))){
 echo '<option value="szerznyilv"';
 if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='szerznyilv') echo ' selected';
 echo '>Szerződésnyilvántartó - teljes';
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['szerznyilv_elo']))){
 echo '<option value="szerznyilv_elo"';
 if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='szerznyilv_elo') echo ' selected';
 echo '>Szerződésnyilvántartó - élő szerződések';
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['proj_k99']))){
 echo '<option value="proj_k99"';
 if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='proj_k99') echo ' selected';
 echo '>KK99 tevékenységek';
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['proj_beszkoz']))){
 echo '<option value="proj_beszkoz"';
 if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='proj_beszkoz') echo ' selected';
 echo '>Beszerzési és közbeszerzési tevékenységek';
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['kpi_riport']))){
 echo '<option value="kpi_riport"';
 if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='kpi_riport') echo ' selected';
 echo '>KPI riport';
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['kpi_riport']))){
 echo '<option value="tig_tabla"';
 if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='tig_tabla') echo ' selected';
 echo '>TIG tábla';
}

if(
 ($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')
 or
 (
 (isset($tomb_riport_aljog['admin_user']))and
 (isset($tomb_riport_aljog['admin_szerv']))and
 (isset($tomb_riport_aljog['admin_proj']))
 )
){
 echo '<optgroup label="Admin riportok">';
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['admin_user']))){
 echo '<option value="admin_user"';
 if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='admin_user') echo ' selected';
 echo '>Jogosultság';
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['admin_szerv']))){
 echo '<option value="admin_szerv"';
 if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='admin_szerv') echo ' selected';
 echo '>Szervezet';
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['admin_proj']))){
 echo '<option value="admin_proj"';
 if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='admin_proj') echo ' selected';
 echo '>Tevékenység';
}

if(
 ($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')
 or
 (
 (isset($tomb_riport_aljog['admin_user']))and
 (isset($tomb_riport_aljog['admin_szerv']))and
 (isset($tomb_riport_aljog['admin_proj']))
 )
){
 echo '</optgroup>';
}

echo '</select>';

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['nonp']))){
 riport_ful_ki_nonp();
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['tervteny']))){
 riport_ful_ki_tervteny();
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['teny3_1_1']))){
 riport_ful_ki_teny3_1_1();
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['teny3_1_1_szervcsop']))){
 riport_ful_ki_teny3_1_1_szervcsop();
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['teny3_2']))){
 riport_ful_ki_teny3_2();
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['teny3_3']))){
 riport_ful_ki_teny3_3();
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['teny3']))){
 riport_ful_ki_teny3();
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['teny3_elteres']))){
 riport_ful_ki_teny3_elteres();
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['kapcs_ossze']))){
 include_once('riport_kapcsossze.php');
 riport_ful_ki_kapcs_ossze();
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['szerznyilv']))){
 include_once('riport_szerznyilv.php');
 riport_ful_ki_szerznyilv();
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['szerznyilv_elo']))){
 include_once('riport_szerznyilv_elo.php');
 riport_ful_ki_szerznyilv_elo();
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['proj_k99']))){
 include_once('riport_proj_k99.php');
 riport_ful_ki_proj_k99();
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['proj_beszkoz']))){
 include_once('riport_proj_beszkoz.php');
 riport_ful_ki_proj_beszkoz();
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['kpi_riport']))){
 include_once('riport_kpi_riport.php');
 riport_ful_ki_kpi_riport();
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['tig_tabla']))){
 include_once('riport_tig_tabla.php');
 riport_ful_ki_tig_tabla();
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['admin_user']))){
 include_once('riport_admin_user.php');
 riport_ful_ki_admin_user();
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['admin_szerv']))){
 include_once('riport_admin_szerv.php');
 riport_ful_ki_admin_szerv();
}

if(($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='1')or(isset($tomb_riport_aljog['admin_proj']))){
 include_once('riport_admin_proj.php');
 riport_ful_ki_admin_proj();
}

echo '</div>';

echo '<div id="riport_tal">';
	if($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='kapcs_ossze'){
	  include_once('riport_kapcsossze.php');
	 riport_ful_ki_kapcs_ossze_html();
	}elseif($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='szerznyilv'){
	 include_once('riport_szerznyilv.php');
	 riport_ful_ki_szerznyilv_html();
	}elseif($_SESSION[$GLOBALS['sessionname']]['riport']['tipus_val']=='szerznyilv_elo'){
	 include_once('riport_szerznyilv_elo.php');
	 riport_ful_ki_szerznyilv_elo_html();
	}
echo '</div>';

}


function riport_ful_ki_nonp(){

echo '<div id="riport_div_nonp"';
if($_SESSION[$GLOBALS['sessionname']]['riport']['nonp']['keres_lathato']==0){
	echo ' style="display:none"';
}else{
	echo ' style="display:flex"';
}
echo '>';

$tombev=keress_riport_ful_ki_evlist_nonp();
if(!is_array($tombev)){
 //echo 'Hiba';//Ez hiba, nem lehet ilyen
 exit;
}

$ev_elso=$tombev[0];
$ev_utolso=end($tombev);

if(!isset($_SESSION[$GLOBALS['sessionname']]['riport']['nonp']['ev1'])){
 $_SESSION[$GLOBALS['sessionname']]['riport']['nonp']['ev1']=$ev_utolso;
}

echo "<table id='riport_table_nonp' cellpadding=1 cellspacing=1 style='margin-top:10px;display:block' class='table_emre'>";

echo '<tr>';
echo '<td>';
echo '<span class="jovahagy_szur_str">Időszak</span>';

echo '<td>';
echo '<span class="jovahagy_szur_str">Év</span>';
echo '<td>';
echo '<select onchange="riport_nonp_ev1_change()" class="select3" id="riport_ev1" style="width:60px">';
for($i=$ev_elso;$i<=$ev_utolso;$i++){
 echo '<option value="'.$i.'"';
 if($i==$_SESSION[$GLOBALS['sessionname']]['riport']['nonp']['ev1']) echo ' selected';
 echo '>'.$i;
}
echo '</select>';


$tomb_nonp_ho=keress_riport_ful_ki_evho_nonp($_SESSION[$GLOBALS['sessionname']]['riport']['nonp']['ev1']);

echo '<td>';
echo '<span class="jovahagy_szur_str">Hó</span>';
echo '<td>';
echo '<select id="riport_ho1" name="riport_ho1" style="width:200px;cursor:pointer" multiple class="select4_multiajax">';
 echo '<option only_radio_delete_fo="fo" value="all" selected>Összes';
 if(is_array($tomb_nonp_ho)){
  foreach($tomb_nonp_ho as $ert){
	 echo '<option only_radio_delete_fo="al" value="'.$ert['backup_ver_id'].'">'.ho_ki($ert['backup_ver_ho']);
  }
 }
echo '</select>';
echo '</tr>';

/*
echo '<tr>';
echo '<td colspan=5>';

echo '</tr>';
*/

echo '</table>';

echo '</div>';

echo '<div id="riport_div_nonp_gomb" style="margin-top:5px';
if($_SESSION[$GLOBALS['sessionname']]['riport']['nonp']['keres_lathato']==0){
	echo ';display:none"';
}
echo '">';
echo '<input onclick="riport_leker()" id="riport_leker_submit" value="Nonproduktív riport excel lekérdezése" class="submit2" type="submit" >';
echo '</div>';

}

function riport_ful_ki_teny3_1_1_szervcsop(){
echo '<div id="riport_div_teny3_1_1_szervcsop"';
if($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_1_1_szervcsop']['keres_lathato']==0){
	echo ' style="display:none"';
}else{
	echo ' style="display:flex"';
}
echo '>';

if($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_riport_all']=='0'){
 $tomb_szerv_csop_jogok=keress_riport_ful_ki_evho_teny3_1_1_szervcsop();

if(!is_array($tomb_szerv_csop_jogok)){
echo '<br><span class="pir_vas" style="margin-top:10px">Hiba! Nem rendelkezel jogosultsaággal egy szerverezet csoportosításra se!</span>';
exit;
}
}else{
 $tomb_szerv_csop_jogok=keress_riport_ful_ki_evho_teny3_1_1_szervcsop_all();	
}

$tombev=keress_riport_ful_ki_evlist_teny3_1_1();

$ev_elso=$tombev[0];
$ev_utolso=end($tombev);

if(!isset($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_1_1_szervcsop']['ev1'])){
 $_SESSION[$GLOBALS['sessionname']]['riport']['teny3_1_1_szervcsop']['ev1']=$ev_utolso;
}

echo "<table id='riport_table_nonp' cellpadding=1 cellspacing=1 style='margin-top:10px;display:block' class='table_emre'>";

echo '<tr>';
echo '<td>';
echo '<span class="jovahagy_szur_str">Időszak</span>';

echo '<td>';
echo '<span class="jovahagy_szur_str">Év</span>';
echo '<td>';
echo '<select onchange="riport_teny3_1_1_szervcsop_ev1_change()" class="select3" id="riport_teny3_1_1_szervcsop_ev1" style="width:60px">';
for($i=$ev_elso;$i<=$ev_utolso;$i++){
 echo '<option value="'.$i.'"';
 if($i==$_SESSION[$GLOBALS['sessionname']]['riport']['teny3_1_1_szervcsop']['ev1']) echo ' selected';
 echo '>'.$i;
}
echo '</select>';

$tomb_nonp_ho=keress_riport_ful_ki_evho_teny3_1_1($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_1_1_szervcsop']['ev1']);

echo '<td>';
echo '<span class="jovahagy_szur_str">Hó</span>';
echo '<td>';
echo '<select id="riport_teny3_1_1_szervcsop_ho1" name="riport_teny3_1_1_szervcsop_ho1" style="width:200px;cursor:pointer" multiple class="select4_multiajax">';
 echo '<option only_radio_delete_fo="fo" value="all" selected>Összes';
 if(is_array($tomb_nonp_ho)){
  foreach($tomb_nonp_ho as $ert){
	 echo '<option only_radio_delete_fo="al" value="'.$ert['backup_ver_id'].'">'.ho_ki($ert['backup_ver_ho']);
  }
 }
echo '</select>';

echo '<td>';
echo '<span class="jovahagy_szur_str">Szervezet csoportosítás</span>';
echo '<td>';
echo '<select id="riport_teny3_1_1_szervcsop_szervcsop_szervcsopid" name="riport_teny3_1_1_szervcsop_szervcsop_szervcsopid" style="width:200px;cursor:pointer" multiple class="select4_multiajax">';
 if(sizeof($tomb_szerv_csop_jogok)>1){
  echo '<option only_radio_delete_fo="fo" value="all" selected>Összes';
  $szervcsop_tobb='';
 }else{
  $szervcsop_tobb=' selected';
 }
 if(is_array($tomb_szerv_csop_jogok)){
  foreach($tomb_szerv_csop_jogok as $ert){
	echo '<option only_radio_delete_fo="al" value="'.$ert['mira_szerv_csoport_id'].'"'.$szervcsop_tobb.'>'.$ert['mira_szerv_csoport_nev'];  
  }
 }
echo '</select>';
echo '</tr>';

echo '</table>';
echo '</div>';

echo '<div id="riport_div_teny3_1_1_szervcsop_gomb" style="margin-top:5px';
if($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_1_1_szervcsop']['keres_lathato']==0){
	echo ';display:none"';
}
echo '">';
echo '<input onclick="riport_teny3_1_1_szervcsop_leker()" id="riport_teny3_1_1_szervcsop_leker_submit" value="Felhasználónkénti tevékenység összesítés excel lekérdezése" class="submit2" type="submit" >';
echo '</div>';
}

function riport_ful_ki_teny3_1_1(){

echo '<div id="riport_div_teny3_1_1"';
if($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_1_1']['keres_lathato']==0){
	echo ' style="display:none"';
}else{
	echo ' style="display:flex"';
}
echo '>';

$tombev=keress_riport_ful_ki_evlist_teny3_1_1();

$ev_elso=$tombev[0];
$ev_utolso=end($tombev);

if(!isset($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_1_1']['ev1'])){
 $_SESSION[$GLOBALS['sessionname']]['riport']['teny3_1_1']['ev1']=$ev_utolso;
}

echo "<table id='riport_table_nonp' cellpadding=1 cellspacing=1 style='margin-top:10px;display:block' class='table_emre'>";

echo '<tr>';
echo '<td>';
echo '<span class="jovahagy_szur_str">Időszak</span>';

echo '<td>';
echo '<span class="jovahagy_szur_str">Év</span>';
echo '<td>';
echo '<select onchange="riport_teny3_1_1_ev1_change()" class="select3" id="riport_teny3_1_1_ev1" style="width:60px">';
for($i=$ev_elso;$i<=$ev_utolso;$i++){
 echo '<option value="'.$i.'"';
 if($i==$_SESSION[$GLOBALS['sessionname']]['riport']['teny3_1_1']['ev1']) echo ' selected';
 echo '>'.$i;
}
echo '</select>';

$tomb_nonp_ho=keress_riport_ful_ki_evho_teny3_1_1($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_1_1']['ev1']);

echo '<td>';
echo '<span class="jovahagy_szur_str">Hó</span>';
echo '<td>';
echo '<select id="riport_teny3_1_1_ho1" name="riport_teny3_1_1_ho1" style="width:200px;cursor:pointer" multiple class="select4_multiajax">';
 echo '<option only_radio_delete_fo="fo" value="all" selected>Összes';
 if(is_array($tomb_nonp_ho)){
  foreach($tomb_nonp_ho as $ert){
	 echo '<option only_radio_delete_fo="al" value="'.$ert['backup_ver_id'].'">'.ho_ki($ert['backup_ver_ho']);
  }
 }
echo '</select>';
echo '</tr>';

echo '</table>';

echo '</div>';

echo '<div id="riport_div_teny3_1_1_gomb" style="margin-top:5px';
if($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_1_1']['keres_lathato']==0){
	echo ';display:none"';
}
echo '">';
echo '<input onclick="riport_teny3_1_1_leker()" id="riport_teny3_1_1_leker_submit" value="Felhasználónkénti tevékenység összesítés excel lekérdezése" class="submit2" type="submit" >';
echo '</div>';

}

function riport_ful_ki_teny3_3(){

echo '<div id="riport_div_teny3_3"';
if($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_3']['keres_lathato']==0){
	echo ' style="display:none"';
}else{
	echo ' style="display:flex"';
}
echo '>';

$tombev=keress_riport_ful_ki_evlist_teny3_3();

//if(!is_array($tombev))exit;

if(is_array($tombev)){
 $ev_elso=$tombev[0];
 $ev_utolso=end($tombev);


if(!isset($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_3']['ev1'])){
 $_SESSION[$GLOBALS['sessionname']]['riport']['teny3_3']['ev1']=$ev_utolso;
}

}

echo "<table id='riport_table_teny3_3' cellpadding=1 cellspacing=1 style='margin-top:10px;display:block' class='table_emre'>";

echo '<tr>';
echo '<td>';
echo '<span class="jovahagy_szur_str">Időszak</span>';

echo '<td>';
echo '<span class="jovahagy_szur_str">Év</span>';
echo '<td>';
if(is_array($tombev)){
echo '<select onchange="riport_teny3_3_ev1_change()" class="select3" id="riport_teny3_3_ev1" style="width:60px">';
for($i=$ev_elso;$i<=$ev_utolso;$i++){
 echo '<option value="'.$i.'"';
 if($i==$_SESSION[$GLOBALS['sessionname']]['riport']['teny3_3']['ev1']) echo ' selected';
 echo '>'.$i;
}
echo '</select>';
}

if(is_array($tombev)){
$tomb_nonp_ho=keress_riport_ful_ki_evho_teny3_3($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_3']['ev1']);
}

echo '<td>';
echo '<span class="jovahagy_szur_str">Hó</span>';
echo '<td>';
if(is_array($tombev)){
echo '<select id="riport_teny3_3_ho1" name="riport_teny3_3_ho1" style="width:200px;cursor:pointer" multiple class="select4_multiajax">';
 echo '<option only_radio_delete_fo="fo" value="all" selected>Összes';
 if(is_array($tomb_nonp_ho)){
  foreach($tomb_nonp_ho as $ert){
	 echo '<option only_radio_delete_fo="al" value="'.$ert['backup_ver_id'].'">'.ho_ki($ert['backup_ver_ho']);
  }
 }
echo '</select>';
}
echo '</tr>';

/*
echo '<tr>';
echo '<td colspan=5>';
echo '</tr>';
*/

echo '</table>';

echo '</div>';

echo '<div id="riport_div_teny3_3_gomb" style="margin-top:5px';
if($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_3']['keres_lathato']==0){
	echo ';display:none"';
}
echo '">';

if(!is_array($tombev)){
 $dis=' disabled';
}else $dis='';

echo '<input'.$dis.' onclick="riport_teny3_3_leker()" id="riport_teny3_3_leker_submit" value="Tevékenység összesítés excel lekérdezése" class="submit2" type="submit" >';
echo '</div>';

}

function riport_ful_ki_teny3_2(){
echo '<div id="riport_div_teny3_2"';
if($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_2']['keres_lathato']==0){
	echo ' style="display:none"';
}else{
	echo ' style="display:flex"';
}
echo '>';

$tombev=keress_riport_ful_ki_evlist_teny3_2();

$ev_elso=$tombev[0];
$ev_utolso=end($tombev);

if(!isset($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_2']['ev1'])){
 $_SESSION[$GLOBALS['sessionname']]['riport']['teny3_2']['ev1']=$ev_utolso;
}

echo "<table id='riport_table_teny3_2' cellpadding=1 cellspacing=1 style='margin-top:10px;display:block' class='table_emre'>";

echo '<tr>';
echo '<td>';
echo '<span class="jovahagy_szur_str">Időszak</span>';

echo '<td>';
echo '<span class="jovahagy_szur_str">Év</span>';
echo '<td>';
echo '<select onchange="riport_teny3_2_ev1_change()" class="select3" id="riport_teny3_2_ev1" style="width:60px">';
for($i=$ev_elso;$i<=$ev_utolso;$i++){
 echo '<option value="'.$i.'"';
 if($i==$_SESSION[$GLOBALS['sessionname']]['riport']['teny3_2']['ev1']) echo ' selected';
 echo '>'.$i;
}
echo '</select>';

$tomb_nonp_ho=keress_riport_ful_ki_evho_teny3_2($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_2']['ev1']);

echo '<td>';
echo '<span class="jovahagy_szur_str">Hó</span>';
echo '<td>';
echo '<select id="riport_teny3_2_ho1" name="riport_teny3_2_ho1" style="width:200px;cursor:pointer" multiple class="select4_multiajax">';
 echo '<option only_radio_delete_fo="fo" value="all" selected>Összes';
 if(is_array($tomb_nonp_ho)){
  foreach($tomb_nonp_ho as $ert){
	 echo '<option only_radio_delete_fo="al" value="'.$ert['backup_ver_id'].'">'.ho_ki($ert['backup_ver_ho']);
  }
 }
echo '</select>';
echo '</tr>';

/*
echo '<tr>';
echo '<td colspan=5>';
echo '</tr>';
*/

echo '</table>';

echo '</div>';

echo '<div id="riport_div_teny3_2_gomb" style="margin-top:5px';
if($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_2']['keres_lathato']==0){
	echo ';display:none"';
}
echo '">';
echo '<input onclick="riport_teny3_2_leker()" id="riport_teny3_2_leker_submit" value="Szervezetenkénti tevékenység összesítés excel lekérdezése" class="submit2" type="submit" >';
echo '</div>';

}


function riport_ful_ki_teny3(){

echo '<div id="riport_div_teny3"';
if($_SESSION[$GLOBALS['sessionname']]['riport']['teny3']['keres_lathato']==0){
	echo ' style="display:none"';
}else{
	echo ' style="display:flex"';
}
echo '>';

$tombev=keress_riport_ful_ki_evlist_teny3();

$ev_elso=$tombev[0];
$ev_utolso=end($tombev);

if(!isset($_SESSION[$GLOBALS['sessionname']]['riport']['teny3']['ev1'])){
 $_SESSION[$GLOBALS['sessionname']]['riport']['teny3']['ev1']=$ev_utolso;
}

echo "<table id='riport_table_teny3' cellpadding=1 cellspacing=1 style='margin-top:10px;display:block' class='table_emre'>";

echo '<tr>';
echo '<td>';
echo '<span class="jovahagy_szur_str">Időszak</span>';

echo '<td>';
echo '<span class="jovahagy_szur_str">Év</span>';
echo '<td>';
echo '<select onchange="riport_teny3_ev1_change()" class="select3" id="riport_teny3_ev1" style="width:60px">';
for($i=$ev_elso;$i<=$ev_utolso;$i++){
 echo '<option value="'.$i.'"';
 if($i==$_SESSION[$GLOBALS['sessionname']]['riport']['teny3']['ev1']) echo ' selected';
 echo '>'.$i;
}
echo '</select>';

$tomb_nonp_ho=keress_riport_ful_ki_evho_teny3($_SESSION[$GLOBALS['sessionname']]['riport']['teny3']['ev1']);

echo '<td>';
echo '<span class="jovahagy_szur_str">Hó</span>';
echo '<td>';
echo '<select id="riport_teny3_ho1" name="riport_teny3_ho1" style="width:200px;cursor:pointer" multiple class="select4_multiajax">';
 echo '<option only_radio_delete_fo="fo" value="all" selected>Összes';
 if(is_array($tomb_nonp_ho)){
  foreach($tomb_nonp_ho as $ert){
	 echo '<option only_radio_delete_fo="al" value="'.$ert['backup_ver_id'].'">'.ho_ki($ert['backup_ver_ho']);
  }
 }
echo '</select>';
echo '</tr>';

echo '</table>';

echo '</div>';

echo '<div id="riport_div_teny3_gomb" style="margin-top:5px';
if($_SESSION[$GLOBALS['sessionname']]['riport']['teny3']['keres_lathato']==0){
	echo ';display:none"';
}
echo '">';
echo '<input onclick="riport_teny3_leker()" id="riport_teny3_leker_submit" value="Aktuális tevékenység kód - Társaság kód összesítés excel lekérdezése" class="submit2" type="submit" >';
echo '</div>';

}

function riport_ful_ki_teny3_elteres(){
echo '<div id="riport_div_teny3_elteres"';
if($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_elteres']['keres_lathato']==0){
	echo ' style="display:none"';
}else{
	echo ' style="display:flex"';
}
echo '>';

$tombev=keress_riport_ful_ki_evlist_teny3();

$ev_elso=$tombev[0];
$ev_utolso=end($tombev);

if(!isset($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_elteres']['ev1'])){
 $_SESSION[$GLOBALS['sessionname']]['riport']['teny3_elteres']['ev1']=$ev_utolso;
}

echo "<table id='riport_table_teny3_elteres' cellpadding=1 cellspacing=1 style='margin-top:10px;display:block' class='table_emre'>";

echo '<tr>';
echo '<td>';
echo '<span class="jovahagy_szur_str">Időszak</span>';

echo '<td>';
echo '<span class="jovahagy_szur_str">Év</span>';
echo '<td>';
echo '<select onchange="riport_teny3_elteres_ev1_change()" class="select3" id="riport_teny3_elteres_ev1" style="width:60px">';
for($i=$ev_elso;$i<=$ev_utolso;$i++){
 echo '<option value="'.$i.'"';
 if($i==$_SESSION[$GLOBALS['sessionname']]['riport']['teny3_elteres']['ev1']) echo ' selected';
 echo '>'.$i;
}
echo '</select>';

$tomb_nonp_ho=keress_riport_ful_ki_evho_teny3($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_elteres']['ev1']);

echo '<td>';
echo '<span class="jovahagy_szur_str">Hó</span>';
echo '<td>';
echo '<select id="riport_teny3_elteres_ho1" name="riport_teny3_elteres_ho1" style="width:200px;cursor:pointer" multiple class="select4_multiajax">';
 echo '<option only_radio_delete_fo="fo" value="all" selected>Összes';
 if(is_array($tomb_nonp_ho)){
  foreach($tomb_nonp_ho as $ert){
	 echo '<option only_radio_delete_fo="al" value="'.$ert['backup_ver_id'].'">'.ho_ki($ert['backup_ver_ho']);
  }
 }
echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<td>';
echo '<span class="jovahagy_szur_str">Terv típusa</span>';

echo '<td colspan=4>';
echo '<select id="riport_teny3_elteres_also_tervalaptipus" mod="riport_tervteny_sel_tervalaptipus1" mit_id="riport_teny3_elteres_ev1" class="select2_ajax" style="width:211px">';
echo '<option value="keremv">Kérem válassz';

echo '</tr>';

echo '<tr>';
echo '<td>';
echo '<span class="jovahagy_szur_str">Alsó eltérés</span>';
echo '<td colspan=4>';
echo '<span style="width:10px;display:inline-block">-</span>';
echo '<input id="riport_teny3_elteres_also" value="15" min="0" max="99" maxlength=2 style="width:60px" type="number">';
echo ' %';
echo '</tr>';

echo '<tr>';
echo '<td>';
echo '<span class="jovahagy_szur_str">Felső eltérés</span>';
echo '<td colspan=4>';
echo '<span style="width:10px;display:inline-block">+</span>';
echo '<input id="riport_teny3_elteres_felso" value="15" min="0" max="99" maxlength=2 style="width:60px" type="number">';
echo ' %';
echo '</tr>';

echo '<tr>';
echo '<td>';
echo '<span class="jovahagy_szur_str">Jelentős eltérés</span>';
echo '<td colspan=4>';
echo '<span style="width:10px;display:inline-block"></span>';
echo '<input id="riport_teny3_elteres_jelentos" value="10" min="0" max="99999" maxlength="5" style="width:60px" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">';
echo ' óra';
echo '</tr>';

echo '</table>';

echo '</div>';

echo '<div id="riport_div_teny3_elteres_gomb" style="margin-top:5px';
if($_SESSION[$GLOBALS['sessionname']]['riport']['teny3_elteres']['keres_lathato']==0){
	echo ';display:none"';
}
echo '">';
echo '<input onclick="riport_teny3_elteres_leker()" id="riport_teny3_elteres_leker_submit" value="Tény-terv eltérés lekérdezése" class="submit2" type="submit" >';
echo '</div>';

}

?>