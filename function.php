<?php
include_once('function_login.php');


/*function ie_no_support(){
echo "<span class='ie_ne_span'></span>";
}*/

function alairas_ki(){
echo "<div class='statusbar_log'>";
echo $GLOBALS['rend_nev'].$GLOBALS['rend_str']." V".$GLOBALS['prog_ver_fo'].".".$GLOBALS['prog_ver']." Copyright © 2021-2026<br>MVM Services Zrt. Minden jog fenntartva.";
//echo "<br>Rendszer működésével kapcsolatos hibák bejelentése: <a href='mailto:mira-mvms@mvm.hu?subject=MIRA'>mira-mvms@mvm.hu</a>";
echo "<br>Rendszer működésével kapcsolatos hibák bejelentése: <a href='mailto:".$GLOBALS['rend_emailfelado']."?subject=MIRA'>".$GLOBALS['rend_emailfelado']."</a>";
echo "</div>";
}



function email_szak_jovahagyas($cimzes,$user_ad,$ev,$ho,$alkalom){
//Email küld - eleje
$user_adat=keres_mit1_mit1("mira_user","user_ad",$user_ad,"user_nev");
if(is_array($user_adat)){
 //$cimtargy="MIRA - szervezeti jóváhagyásra váró feladat";
 $cimtargy=$GLOBALS['rend_nev']." - szervezeti jóváhagyásra váró feladat";
 $level_html="Kedves Jóváhagyó!";
 
 $level_html.="<br><br>".$user_adat[0]." ".$ev.". ".ho_ki($ho)." havi ";
 //$level_html.="tevékenység rögzítése szervezeti jóváhagyásra vár!";
 
 $level_html.=" tevékenység rögzítése ";
 if($alkalom>1){
  $level_html.=$alkalom.". alkalommal újra";
 }
 $level_html.=" lezárásra került!";
 
 $level_html.=" <br><br>Kérem végezd el a tevékenység rögzítés ellenőrzését, jóváhagyását!";
 //$level_html.="<br><br>Kérem végezd el a jóváhagyást!";
mail_passrec_uj2($cimtargy,$cimzes,"",$level_html,"");
}
//Email küld - vége
}

function email_projekt_jovahagyas($cimzes,$user_ad,$ev,$ho,$alkalom){
//Email küld - eleje
$user_adat=keres_mit1_mit1("mira_user","user_ad",$user_ad,"user_nev");
if(is_array($user_adat)){
 //$cimtargy="MIRA - projekt jóváhagyásra váró feladat";
 $cimtargy=$GLOBALS['rend_nev']." - projekt jóváhagyásra váró feladat";
 $level_html="Kedves Jóváhagyó!";
 
 $level_html.="<br><br>".$user_adat[0]." ".$ev.". ".ho_ki($ho)." havi ";
 //$level_html.="tevékenység rögzítése szervezeti jóváhagyásra vár!";
 
 $level_html.=" tevékenység rögzítése ";
 if($alkalom>1){
  $level_html.=$alkalom.". alkalommal újra";
 }
 $level_html.=" lezárásra került!";
 
 $level_html.=" <br><br>Kérem végezd el a tevékenység rögzítés ellenőrzését, jóváhagyását!";
 //$level_html.="<br><br>Kérem végezd el a jóváhagyást!";
mail_passrec_uj2($cimtargy,$cimzes,"",$level_html,"");
}
//Email küld - vége
}

function ho_fotable_ki(){

echo "<div class='div_rogzites_linkek'>";

echo "<span onclick='open_felh_kezi()' class='span_kitolt_utmutato'>Felhasználói kézikönyv</span>";
// <span onclick='open_felh_kezi()' class='pir_vas'>(Figyelem! Változás történt a kézikönyvben)</span>";
if($GLOBALS['kitoltesi_utm']=='MVM')
 echo "<br><span onclick='open_kitolt_utm()' class='span_kitolt_utmutato'>Kitöltési útmutató</span>";
echo "</div>";

echo "<div style='display:block'>";

//echo '<span style="color:red;font-weight:bold">';
//$_SESSION[$GLOBALS['sessionname']]['szerv_id']
//echo '<a class="link" style="c1olor:red;font-weight:bold" href="image\szmsz_2025.jpg">Itt lenne a szöveg, jó hosszú, még hosszabb...<br>lehet több soros is!</a>';
//echo '</span>';

ho_fotable_helyettes_ki();

echo "<div style='margin-top:5px;display:block'>";
ho_fotable_ev_ki();
ho_fotable_ho_ki();
ho_fotable_nap_ki();

ho_lezaras();
echo "</div>";

echo "</div>";

}

function ho_fotable_helyettes_ki(){
	
$tomb_helyettes=keres_user_login_helyettes();
//$tomb_helyettes="";
echo "<div style='display:block'>";

echo "<b>Bejelentkezve</b>: ";

if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']!="")
 echo "<input id='user_ad_ellhez' value='".$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']."' type='hidden'>"; 
else
 echo "<input id='user_ad_ellhez' value='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."' type='hidden'>"; 

if(!is_array($tomb_helyettes)){//Nincs helyettesítési jog
 echo $GLOBALS[$GLOBALS['sessionname']]['login_nev'];
 if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']!=""){
  $_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']="";
  $GLOBALS[$GLOBALS['sessionname']]['helyettes_login_nev']="";
 }
}else{

 $akt_sel=0;
 foreach($tomb_helyettes as $erth){
  if($erth['user_ad']==$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'])
   $akt_sel=1;
 }
 if($akt_sel==0){//Ekkor az aktuális helyettes jogát elvették.
  $_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']="";
  $GLOBALS[$GLOBALS['sessionname']]['helyettes_login_nev']="";
 }

 if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
  $css="fo_table_ki_sel";
 else
  $css="fo_table_ki_sel_sarga";

 echo "<select style='margin-bottom:5px' onchange='fo_table_helyettes_change()' class='".$css."' id='sel_helyettes_valaszt'>";
 echo "<option class='fo_table_ki_sel_option' value='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."'>".$GLOBALS[$GLOBALS['sessionname']]['login_nev'];
 

 foreach($tomb_helyettes as $erth){
  if($erth['user_ad']==$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'])
   $sel=' selected';
  else
   $sel='';
   
  echo "<option class='fo_table_ki_sel_option_sarga' value='".$erth['user_ad']."'".$sel.">".$erth['user_nev']." - helyettes";
 }
 
 echo "</select>";
 

}//Csak ha van jogom rá.

if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 echo "<input onclick='rogzito_helyettes_beallit()' style='margin-left:10px' value='Helyettes rögzítő beállítása' class='submit2' id='gomb_helyettes_beallit' type='submit'>";
echo "</div>";
}

function ho_lezaras(){
//1 gomb, ha még nincs
//2 Ha vissza lett küldve

$ev=$_SESSION[$GLOBALS['sessionname']]['ev_ki'];
$ho=$_SESSION[$GLOBALS['sessionname']]['ho_ki'];

if($ho<10)$ho_ketto="0".$ho;
else $ho_ketto=$ho;
//$tomb_jovahagyva_ho=keres_mit2("rogzit_ho","user_ad",$_SESSION[$GLOBALS['sessionname']]['login_ad'],"rogzit_ho",$ev."-".$ho_ketto);
if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 $tomb_jovahagyva_ho=keress_jovahagyva_ho($_SESSION[$GLOBALS['sessionname']]['login_ad'],$ev."-".$ho_ketto);
else
  $tomb_jovahagyva_ho=keress_jovahagyva_ho($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'],$ev."-".$ho_ketto);

//Projekt jóváhagyás
 $tomb_projekt_jovahagyva_ho=keress_projekt_jovahagyva_ho($_SESSION[$GLOBALS['sessionname']]['login_ad'],$ev."-".$ho_ketto);

if(
(!is_array($tomb_jovahagyva_ho))
or
(
(is_array($tomb_jovahagyva_ho))and
($tomb_jovahagyva_ho[0]['ellenorzesre_lezarva']=="0")
)
){
 $jovahagyva_ho=0;
}else{
 $jovahagyva_ho=1;
}

if(
(!is_array($tomb_jovahagyva_ho))
or
(
(is_array($tomb_jovahagyva_ho))and
($tomb_jovahagyva_ho[0]['ellenorzesre_ok']=="0")
)
){
 $ellenorzesre_ok_ho=0;
}else{
 $ellenorzesre_ok_ho=1;
}

if($jovahagyva_ho==0){
 if(!isset($tomb_jovahagyva_ho[0]['ellenorzesre_lezarva_hanyadik']))//Első alkalom
  $gomb_str=ho_ki($ho)." hónap lezárása";
 else
  $gomb_str=ho_ki($ho)." hónap lezárása ".($tomb_jovahagyva_ho[0]['ellenorzesre_lezarva_hanyadik']+1).". alkalommal";
 echo "<input onclick='rogzit_elkuld_ell(\"".$ev."\",\"".$ho."\",\"".ho_ki($ho)."\")' value='".$gomb_str."' id='sel_melyik_holezargomb' style='margin-bottom:10px;margin-left:15px' type='submit' class='submit2'>";
}else{
 echo "<div style='margin-top:5px'><b>Lezárásra került</b>: ".kidate_format($tomb_jovahagyva_ho[0]['ellenorzesre_lezarva_mikor'])."</div>";
}

if($jovahagyva_ho==1){
echo "<div style='margin-bottom:5px'>";
if($ellenorzesre_ok_ho=="1"){
 echo "<b>Jóváhagyásra került</b>: ".kidate_format($tomb_jovahagyva_ho[0]['ellenorzesre_ok_mikor'])." ";
}else{
 echo "<b>Jóváhagyásra vár</b> ";

}
if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']!="")
 jovahagy_proc_jovahagy_infok($ev,$ho,$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']);
else
 jovahagy_proc_jovahagy_infok($ev,$ho,$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 echo '</div>';
}

//Visszaküldés elintézése - eleje
if(
(!is_array($tomb_jovahagyva_ho))
or
(
(is_array($tomb_jovahagyva_ho))and
($tomb_jovahagyva_ho[0]['ellenorzesre_visszakuldve']=="0")
)
){
 $visszakuldve_ho=0;
}else{
 $visszakuldve_ho=1;
}

if($visszakuldve_ho==1){
 echo "<br>";
 echo "<div class='visszakuldve_megj_div'>";
 echo "<span style='font-size:20px;font-weight:bold'>Tevékenység rögzítésed visszaküldésre került!</span><br>";
 echo "<b>Visszaküldő:</b> ".$tomb_jovahagyva_ho[0]['ellenorzesre_visszakuldve_ki_nev']."<br>";
 echo "<b>Visszaküldés ideje:</b> ".$tomb_jovahagyva_ho[0]['ellenorzesre_visszakuldve_mikor']."<br>";
 echo "<b>Megjegyzés:</b><br>";
 echo str_replace("\n","<br>",$tomb_jovahagyva_ho[0]['ellenorzesre_visszakuldve_megj']);
 echo "</div>";
}elseif(is_array($tomb_projekt_jovahagyva_ho)){//Projektvezetői visszaaküldés
 echo "<br>";
 echo "<div class='visszakuldve_megj_div'>";
 echo "<span style='font-size:20px;font-weight:bold'>Tevékenység rögzítésed visszaküldésre került!</span><br>";
 echo "<b>Visszaküldő:</b> ".$tomb_projekt_jovahagyva_ho[0]['projekt_jovahagyo_elutasitva_ki_nev']."<br>";
 echo "<b>Visszaküldés ideje:</b> ".kidate_format($tomb_projekt_jovahagyva_ho[0]['projekt_jovahagyo_elutasitva_mikor'])."<br>";
 echo "<b>Megjegyzés:</b><br>";
 echo str_replace("\n","<br>",$tomb_projekt_jovahagyva_ho[0]['projekt_jovahagyo_elutasitva_megj']);
 echo "</div>";
}
//Visszaküldés elintézése - vége

}

function ho_fotable_ev_ki(){

//Ekkor át kell váltani az aktuális hónapra, évre - eleje
 $evmost=date("Y",time());
 $homost=date("n",time());
if(
 ($_SESSION[$GLOBALS['sessionname']]['nap_ki']=="ma")and
 (
  ($_SESSION[$GLOBALS['sessionname']]['ev_ki']!=$evmost)or
  ($_SESSION[$GLOBALS['sessionname']]['ho_ki']!=$homost)
 )
){
 $_SESSION[$GLOBALS['sessionname']]['ev_ki']=$evmost;
 $_SESSION[$GLOBALS['sessionname']]['ho_ki']=$homost;
  include_once("config_uj.php");
  include_once("function_mysql.php");
  $tmp_mod[0]['ev_ki']=$_SESSION[$GLOBALS['sessionname']]['ev_ki'];
  $tmp_mod[0]['ho_ki']=$_SESSION[$GLOBALS['sessionname']]['ho_ki'];
  mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
}
//Ekkor át kell váltani az aktuális hónapra, évre - eleje


//$ma=date("d",time());

$ma_most = date("Ym",time());
//$today = "2021-12";
$nextev = date('Y', strtotime('+1 month', (strtotime($ma_most))));

//Vége rögzítés év lekezelése - eleje
if(
($GLOBALS['mira']['rogzit_ev_veg_ev']!="")and
($GLOBALS['mira']['rogzit_ev_veg_ho']!="")and
($GLOBALS['mira']['rogzit_ev_veg_nap']!="")and
($nextev>$GLOBALS['mira']['rogzit_ev_veg_ev'])
){
 $nextev=$GLOBALS['mira']['rogzit_ev_veg_ev'];
}
//Vége rögzítés év lekezelése - vége

if(isset($_POST['ev']))
 $_SESSION[$GLOBALS['sessionname']]['ev_ki']=$_POST['ev'];
 
if(
(!isset($_SESSION[$GLOBALS['sessionname']]['ev_ki']))
or
(
 (isset($_SESSION[$GLOBALS['sessionname']]['ev_ki']))
 and
 ($_SESSION[$GLOBALS['sessionname']]['ev_ki']=="")
)
){

 $ev_most=date("Y",time());
 if($ev_most>=$GLOBALS['mira']['rogzit_ev_kezdo_ev'])
  $_SESSION[$GLOBALS['sessionname']]['ev_ki']=$ev_most;
 else//Ha a kezdő év később van mint most!
  $_SESSION[$GLOBALS['sessionname']]['ev_ki']=$GLOBALS['mira']['rogzit_ev_kezdo_ev'];
 
 //Lementés első alkalommal - eleje
  include_once("config_uj.php");
  include_once("function_mysql.php");
  $tmp_mod[0]['ev_ki']=$_SESSION[$GLOBALS['sessionname']]['ev_ki'];
  mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 //Lementés első alkalommal - vége
}else{

  if(
  ($_SESSION[$GLOBALS['sessionname']]['ev_ki']<$GLOBALS['mira']['rogzit_ev_kezdo_ev'])
  or
  (
  ($_SESSION[$GLOBALS['sessionname']]['ev_ki']==$GLOBALS['mira']['rogzit_ev_kezdo_ev'])and
  ($_SESSION[$GLOBALS['sessionname']]['ho_ki']<$GLOBALS['mira']['rogzit_ev_kezdo_ho'])
  )
  ){
	
	$_SESSION[$GLOBALS['sessionname']]['ev_ki']=$GLOBALS['mira']['rogzit_ev_kezdo_ev'];
	$_SESSION[$GLOBALS['sessionname']]['ho_ki']=$GLOBALS['mira']['rogzit_ev_kezdo_ho'];
	//Lementés első alkalommal - eleje
	include_once("config_uj.php");
	include_once("function_mysql.php");
	$tmp_mod[0]['ho_ki']=$_SESSION[$GLOBALS['sessionname']]['ho_ki'];
	mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
  }	
}

echo "<b>Év</b>: ";
echo "<select onchange='fo_table_ki()' class='fo_table_ki_sel' id='sel_melyik_ev'>";

for($ev_ki=$GLOBALS['mira']['rogzit_ev_kezdo_ev'];$ev_ki<=$nextev;$ev_ki++){

if($ev_ki==$_SESSION[$GLOBALS['sessionname']]['ev_ki']) $sel="selected ";
else $sel="";

 echo "<option class='fo_table_ki_sel_option' value='".$ev_ki."'".$sel.">".$ev_ki;
}

echo "</select>";
}

function ho_fotable_ho_ki(){

$ev_most=date("Y",time());
$ho_most=date("n",time());
$ma_most = date("Ym",time());
//$nextho = date('m', strtotime('+1 month', (strtotime($ma_most))));
if($ho_most<10){
	$nextho=$ho_most+1;
	$nextho="0".$nextho;
}elseif($ho_most==10) $nextho=11;
elseif($ho_most==11) $nextho=12;
else $nextho=1;

//Kezdő hó lerendezése
if($_SESSION[$GLOBALS['sessionname']]['ev_ki']==$GLOBALS['mira']['rogzit_ev_kezdo_ev']){
 $kezd_ho=$GLOBALS['mira']['rogzit_ev_kezdo_ho'];
}else{
 $kezd_ho=1;	
}

//Vége hó lerendezése
if(($_SESSION[$GLOBALS['sessionname']]['ev_ki']==$ev_most)and($nextho!=1)){
 $vege_ho=$nextho;
 if(intval($vege_ho)<$kezd_ho){//Ha jövőbeli a cucc
	$vege_ho=$kezd_ho; 
 }
}elseif(($_SESSION[$GLOBALS['sessionname']]['ev_ki']>$ev_most)and($nextho==1)){
 $vege_ho=$nextho;
}else{
 $vege_ho=12;
}

//Vége rögzítés hónap lekezelése - eleje
if(
($GLOBALS['mira']['rogzit_ev_veg_ev']!="")and
($GLOBALS['mira']['rogzit_ev_veg_ho']!="")and
($GLOBALS['mira']['rogzit_ev_veg_nap']!="")and
($_SESSION[$GLOBALS['sessionname']]['ev_ki']==$GLOBALS['mira']['rogzit_ev_veg_ev'])and
($vege_ho>$GLOBALS['mira']['rogzit_ev_veg_ho'])
){
 $vege_ho=$GLOBALS['mira']['rogzit_ev_veg_ho'];
}
//Vége rögzítés hónap lekezelése - vége

//Ha a kezdés jövőbeli, akkor a vége hó is jó legyen - eleje
if(
($_SESSION[$GLOBALS['sessionname']]['ev_ki']==$ev_most)//and
//(intval($vege_ho)<$ho_most
){
 //echo $kezd_ho;
 //echo intval($vege_ho);
 //echo intval($vege_ho);
 //echo $ho_most;
}
//Ha a kezdés jövőbeli, akkor a vége hó is jó legyen - vége

 //$ev_most=date("Y",time());
 
if(
(!isset($_SESSION[$GLOBALS['sessionname']]['ho_ki']))
or
(
 (isset($_SESSION[$GLOBALS['sessionname']]['ho_ki']))and
 ($_SESSION[$GLOBALS['sessionname']]['ho_ki']=="")
)
){
 if($ev_most<$GLOBALS['mira']['rogzit_ev_kezdo_ev']){
  $_SESSION[$GLOBALS['sessionname']]['ho_ki']=$GLOBALS['mira']['rogzit_ev_kezdo_ho'];
 }else{
  if(
  ($ev_most==$GLOBALS['mira']['rogzit_ev_kezdo_ev'])and
  ($ho_most<$GLOBALS['mira']['rogzit_ev_kezdo_ho'])
  ){
    $_SESSION[$GLOBALS['sessionname']]['ho_ki']=$GLOBALS['mira']['rogzit_ev_kezdo_ho'];
   }else{
	$_SESSION[$GLOBALS['sessionname']]['ho_ki']=$ho_most;   
   }
 }

 //Lementés első alkalommal - eleje
  include_once("config_uj.php");
  include_once("function_mysql.php");
  $tmp_mod[0]['ho_ki']=$_SESSION[$GLOBALS['sessionname']]['ho_ki'];
  mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 //Lementés első alkalommal - vége
	

}else{
  if(
  //($ev_most==$GLOBALS['mira']['rogzit_ev_kezdo_ev'])and
  ($_SESSION[$GLOBALS['sessionname']]['ev_ki']==$GLOBALS['mira']['rogzit_ev_kezdo_ev'])and
  ($_SESSION[$GLOBALS['sessionname']]['ho_ki']<$GLOBALS['mira']['rogzit_ev_kezdo_ho'])
  ){
	$_SESSION[$GLOBALS['sessionname']]['ho_ki']=$GLOBALS['mira']['rogzit_ev_kezdo_ho'];
	//Lementés első alkalommal - eleje
	include_once("config_uj.php");
	include_once("function_mysql.php");
	$tmp_mod[0]['ho_ki']=$_SESSION[$GLOBALS['sessionname']]['ho_ki'];
	//echo 'alma:'.$_SESSION[$GLOBALS['sessionname']]['ev_ki'];
	//echo 'alma:'.$GLOBALS['mira']['rogzit_ev_kezdo_ev'].'-'.$GLOBALS['mira']['rogzit_ev_kezdo_ho'];
	mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
  }	  
}

echo " <b>Hónap</b>: ";
echo "<select onchange='fo_table_ki()' class='fo_table_ki_sel' id='sel_melyik_ho'>";

for($ho_ki=$kezd_ho;$ho_ki<=$vege_ho;$ho_ki++){

if($ho_ki==$_SESSION[$GLOBALS['sessionname']]['ho_ki']) $sel=" selected ";
else $sel="";

 echo "<option class='fo_table_ki_sel_option' value='".$ho_ki."'".$sel.">".ho_ki($ho_ki);
}
echo "</select>";
}

function ho_fotable_nap_ki(){

$date_ut=$_SESSION[$GLOBALS['sessionname']]['ev_ki'].'-'.$_SESSION[$GLOBALS['sessionname']]['ho_ki'].'-1';
$honap_utolso_napja = date("t", strtotime($date_ut));

//Vége rögzítés nap lekezelése - eleje
if(
($GLOBALS['mira']['rogzit_ev_veg_ev']!="")and
($GLOBALS['mira']['rogzit_ev_veg_ho']!="")and
($GLOBALS['mira']['rogzit_ev_veg_nap']!="")and
($_SESSION[$GLOBALS['sessionname']]['ev_ki']==$GLOBALS['mira']['rogzit_ev_veg_ev'])and
($_SESSION[$GLOBALS['sessionname']]['ho_ki']==$GLOBALS['mira']['rogzit_ev_veg_ho'])
){
 $honap_utolso_napja=$GLOBALS['mira']['rogzit_ev_veg_nap'];
}
//Vége rögzítés nap lekezelése - vége

echo " <b>Nap</b>: ";
echo "<select style='margin-bottom:5px' onchange='fo_table_ki()' class='fo_table_ki_sel' id='sel_melyik_nap'>";

$selnincs=0;

if($_SESSION[$GLOBALS['sessionname']]['nap_ki']=="all"){
  $sel=" selected";
  $selnincs=1;
}else $sel="";

echo "<option class='fo_table_ki_sel_option' value='all' ".$sel.">Minden nap";

$evmost=date("Y",time());
$homost=date("n",time());//n - hónap, számmal, "felesleges" nullák nélkül; pl.: "1" .. "12"
if(
($evmost==$_SESSION[$GLOBALS['sessionname']]['ev_ki'])and
($homost==$_SESSION[$GLOBALS['sessionname']]['ho_ki'])
){
if($_SESSION[$GLOBALS['sessionname']]['nap_ki']=="ma"){
  $sel=" selected";
  $selnincs=1;
}else $sel="";
echo "<option class='fo_table_ki_sel_option' value='ma' ".$sel.">Aktuális nap";
}

//Csak 1 nap lekezelése - eleje
if(
($_SESSION[$GLOBALS['sessionname']]['ev_ki']==$GLOBALS['mira']['rogzit_ev_kezdo_ev'])and
($_SESSION[$GLOBALS['sessionname']]['ho_ki']==$GLOBALS['mira']['rogzit_ev_kezdo_ho'])and
($GLOBALS['mira']['rogzit_ev_kezdo_nap']!="")
){
 $elso_nap=$GLOBALS['mira']['rogzit_ev_kezdo_nap'];
}else{//Máskülönben az egész hónap!
 $elso_nap=1;
}

//for($i=1;$i<=$honap_utolso_napja;$i++){
for($i=$elso_nap;$i<=$honap_utolso_napja;$i++){
 if($i==$_SESSION[$GLOBALS['sessionname']]['nap_ki']){
  $sel=" selected";
  $selnincs=1;
 }else $sel="";
 
 $ev=$_SESSION[$GLOBALS['sessionname']]['ev_ki'];
 $ho=$_SESSION[$GLOBALS['sessionname']]['ho_ki'];
 $naptime=mktime('0','0','1',$ho,$i,$ev);
 $het_sorszam=date('w',$naptime);
 
 //echo "<option value='".$i."'".$sel.">".$i;
 echo "<option value='".$i."'".$sel.">".$i." - ".napkod($het_sorszam);
}
echo "</select>";

//Ha nincs sel, akkor olyan nap van, ami nem jó, akkor legyne ALL és mentés is,.
if($selnincs==0){
  $tmp_mod[0]['nap_ki']=$_SESSION[$GLOBALS['sessionname']]['nap_ki']="all";
  mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']); 
}

}

function ho_aktevforma_ki(){
if($_SESSION[$GLOBALS['sessionname']]['ho_ki']<10)
 $hoki="0".$_SESSION[$GLOBALS['sessionname']]['ho_ki'];
else
 $hoki=$_SESSION[$GLOBALS['sessionname']]['ho_ki'];
$ho=$_SESSION[$GLOBALS['sessionname']]['ev_ki']."-".$hoki;
return $ho;
}

function nap_aktevforma_ki($nap){
if($_SESSION[$GLOBALS['sessionname']]['ho_ki']<10)
 $hoki="0".$_SESSION[$GLOBALS['sessionname']]['ho_ki'];
else
 $hoki=$_SESSION[$GLOBALS['sessionname']]['ho_ki'];

if($nap<10)
 $napki="0".$nap;
else
 $napki=$nap;
 
$nap=$_SESSION[$GLOBALS['sessionname']]['ev_ki']."-".$hoki."-".$napki;
return $nap;
}

function napkod($het_sorszam){
$ret='hiba';
switch($het_sorszam)
{
 case'0':$ret='Vasárnap';break;
 case'1':$ret='Hétfő';break;
 case'2':$ret='Kedd';break;
 case'3':$ret='Szerda';break;
 case'4':$ret='Csütörtök';break;
 case'5':$ret='Péntek';break;
 case'6':$ret='Szombat';break;
}
return $ret;
}

function napkod1($het_sorszam){
$ret='hiba';
switch($het_sorszam)
{
 case'0':$ret='Vas';break;
 case'1':$ret='Hét';break;
 case'2':$ret='Kedd';break;
 case'3':$ret='Sze';break;
 case'4':$ret='Csü';break;
 case'5':$ret='Pén';break;
 case'6':$ret='Szo';break;
}
return $ret;
}

function ho_ki($ho){
$ret='';
switch($ho)
{
 case'1':$ret='Január';break;
 case'2':$ret='Február';break;
 case'3':$ret='Március';break;
 case'4':$ret='Április';break;
 case'5':$ret='Május';break;
 case'6':$ret='Június';break;
 case'7':$ret='Július';break;
 case'8':$ret='Augusztus';break;
 case'9':$ret='Szeptember';break;
 case'10':$ret='Október';break;
 case'11':$ret='November';break;
 case'12':$ret='December';break;
}
return $ret;
}

/*function naptipus($ev,$ho,$nap){
$ret="";
//$ret="PN";//Pihnőnap
//$ret="MN";//Munkanap

return $ret;
}*/

function refresh($mit){
return "<img title='frissítés' id='refresimg_".$mit."' src='image/refresh2.png' onclick='ful_betolt(akt_ful)' class='refresh2'>";
}

function table_alja_lepeget($ketsoros,$th,$holvagyunk,$talszam,$change_func_orig){
elozo_kovetkezo_gombok($change_func_orig,$th,$GLOBALS['mira']['user_jog'][$talszam],$_POST['oldalholvagyok']);

if($ketsoros=='1')echo '<div style="margin-top:5px">';

//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog'][$talszam],$change_func_orig,$talszam);
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='".$holvagyunk."list_keres_tal_oldalholvagyok'>";

//if(is_array($tomb)){
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog'][$talszam]);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='".$holvagyunk."list_keres_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog'][$talszam]))+1;
 //echo "Találatok száma: ".$th." db";
 echo "Találatok száma: ".number_format($th,0,""," ")." db";
 if($th>0){
  //echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  echo ", ".number_format($oldalszam,0,""," ")."/ ".number_format($oldal_max,0,""," ").". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>".$change_func_orig."('tallep_elso','');</script>";
  }
 }
excel_export($holvagyunk."list_keres",$th);
//}
if($ketsoros=='1')echo '</div>';
}

function elozo_kovetkezo_gombok($keres_fug,$th,$oldalszam,$oldalholvagyok){
	
//$js_this_disabled='$(".lepget_gomb_'.$keres_fug.'").prop("disabled",true);';

//echo "<div style='margin-top:5px;display:inline-block'>";
echo "<div class='div_elozo_kov_submit'>";
if($oldalholvagyok<=0)$disabled="disabled";else $disabled="";
echo "<input class='submit2' ".$disabled." id='".$keres_fug."_tallep_elso' onclick='".$keres_fug."(\"tallep_elso\",\"\")' type='submit' value='Első oldal'> ";

if($oldalholvagyok<=0)$disabled="disabled";else $disabled="";
echo "<input class='submit2' ".$disabled." id='".$keres_fug."_tallep_elozo' onclick='".$keres_fug."(\"tallep_elozo\",\"\")' type='submit' value='Előző oldal'> ";

if(($oldalszam+$oldalholvagyok)>=$th)$disabled="disabled";else $disabled="";
echo "<input class='submit2' ".$disabled." id='".$keres_fug."_tallep_kov' onclick='".$keres_fug."(\"tallep_kov\",\"\")' type='submit' value='Következő oldal'> ";

if(($oldalszam+$oldalholvagyok)>=$th)$disabled="disabled";else $disabled="";
echo "<input class='submit2' ".$disabled." id='".$keres_fug."_tallep_ut' onclick='".$keres_fug."(\"tallep_ut\",\"\")' type='submit' value='Utolsó oldal'>";

echo "</div>&nbsp;&nbsp;";
}

function excel_export($fajta,$th){
echo "<img src='image/excel_e1_k20.png' onclick='excel_export(this.id,\"".$th."\")' id='excel_export_img_".$fajta."' title='Excel export' fajta='".$fajta."' style='margin-left:10px' class='link'>";
}

function talalatok_szama($talszam,$change_func_orig,$select_id){
//$change_func='$(".lepget_gomb_'.$change_func_orig.'").prop("disabled",true);$(this).prop("disabled",true);'.$change_func_orig.'("","")';
$change_func=$change_func_orig.'("","")';
echo " Találatok: ";
//echo "<select onchange='".$change_func."' id='".$select_id."' class='talalatok_szama_sel_".$change_func_orig."' style='width:130px;margin-top:3px'>";
echo "<select onchange='".$change_func."' id='".$select_id."' class='select3 talszam_sel3'>";

echo "<option value='2'";
if($talszam==2) echo " selected";
echo ">2 db/oldal";

echo "<option value='5'";
if($talszam==5) echo " selected";
echo ">5 db/oldal";

echo "<option value='15'";
if($talszam==15) echo " selected";
echo ">15 db/oldal";

echo "<option value='50'";
if($talszam==50) echo " selected";
echo ">50 db/oldal";

echo "<option value='100'";
if($talszam==100) echo " selected";
echo ">100 db/oldal";

echo "<option value='500'";
if($talszam==500) echo " selected";
echo ">500 db/oldal";

echo "<option value='1000'";
if($talszam==1000) echo " selected";
echo ">1000 db/oldal";

echo "<option value='2000'";
if($talszam==2000) echo " selected";
echo ">2000 db/oldal";

echo "</select> ";
}

function tabl_nyilak($order,$order_mod,$order_mezo){
if($GLOBALS['mira']['user_jog'][$order_mod]=="desc"){
 $nyil="image/arrow_le_kek_k1_14.png";
}else{
 $nyil="image/arrow_fel_kek_k1_14.png";
}

if($GLOBALS['mira']['user_jog'][$order]==$order_mezo)//Csak akkor van látható nyíl, ha épp erre van rendezve
 $lat="class='link'";//"" üres volt
else
 $lat="class='tabordh'";

//echo "<img ".$lat." class='link' src='".$nyil."'>";	
return "<img style='width:14px' ".$lat." src='".$nyil."'>";	
}

function igennem_kod_ki_0nalis($kod){
$ret="Ismeretlen érték: (".$kod.")";
switch($kod){
	case'':$ret="";break;
	case'0':$ret="Nem";break;
	case'1':$ret="Igen";break;
}
return $ret;
}

function igennem_kod_ki($kod){
$ret="Ismeretlen érték: (".$kod.")";
switch($kod){
	case'':$ret="";break;
	case'0':$ret="";break;
	case'1':$ret="Igen";break;
}
return $ret;
}

function projekt_tipus_ki($kod){
$ret="Ismeretlen érték: (".$kod.")";
switch($kod){
	case'0':$ret="SLA";break;
	case'1':$ret="Projekt";break;
}
return $ret;
}

function munkanap_tipus_ki($kod){
$ret="Ismeretlen érték: (".$kod.")";
switch($kod){
	case'PN':$ret="Pihenőnap";break;
	case'MN':$ret="Munkanap";break;
}
return $ret;
}

function ora_perc_osszead($ora,$perc){
//$ora+=bcdiv($perc,60,0);
$ora+=intval($perc/60);
$perc=$perc % 60;
$tomb=array();
$tomb['rogzit_ora']=$ora;
$tomb['rogzit_perc']=$perc;
return $tomb;
}

function mail_passrec_uj($targy,$cimzes,$level_html,$file){
if((isset($GLOBALS['mail_tilt']))and($GLOBALS['mail_tilt']=="1")) return true;
/* használat:
$level_html="Alma<b>Vastag</b> Árvíztűrő tükörfúrógép";
$targy="Árvíztűrő tükörfúrógép";

$cimzes[0]['nev']="Nagy Imre";
$cimzes[0]['email']="nagy.imre@nusz-zrt.hu";
$cimzes[1]['nev']="KONTO-IT";
$cimzes[1]['email']="konto-it@mvm.hu";

$file[0]['nev']="Árvíztűrő tükörfúrógép_átnevezve.txt";
$file[0]['utv']="file/Árvíztűrő tükörfúrógép.txt";


mail_passrec_uj($targy,$cimzes,$level_html,$file);
*/

//$level_html.="<br><br>Ez egy automatikusan generált e-mail, kérjük ne válaszoljon rá.";
$level_html.="<br><br>Ez egy automatikusan generált e-mail, kérlek, ne válaszolj rá.";
//$level_html.="<br><br>Üdvözlettel,<br>MVM Services Zrt.<br>
$level_html.="<br><br>Üdvözlettel,<br>".$GLOBALS['rend_emailfelado_udv_str']."<br>
<a href='".$GLOBALS['url']."'>".$GLOBALS['rend_nev']." ".$GLOBALS['rend_str']."</a>
<br><img src='cid:logoimg'>";

$level_sima=strip_tags($level_html);
//include_once("ajax_mail_uj.php");
//$mail = new PHPMailer();//régi 5.x

//include_once("a11jax_mail_uj606.php");
//include_once("a111jax_mail_uj616.php");
include_once($GLOBALS['phpmailer_akt']);
$mail = new PHPMailer\PHPMailer\PHPMailer;  //új 6.x

//include_once("plugin/phpmailer/class.phpmailer.php");

 //$mail->From     = "nuszwebir@nusz-zrt.hu";                // Feladó e-mail címe  
 $mail->From     = $GLOBALS['rend_emailfelado'];                // Feladó e-mail címe  
 //$mail->FromName = "NUSZWEBIR ".$GLOBALS['tesztdevmod']."";		// Feladó neve  
 $mail->FromName = $GLOBALS['rend_nev'].$GLOBALS['tesztdevmod']."";		// Feladó neve  
foreach($cimzes as $ert){
 $mail->AddAddress($ert['email'],$ert['nev']);   // Címzett és neve 
}
//$mail->AddAddress("schubert.endre@nusz-zrt.hu");               // Még egy címzett  
//$mail->AddAddress("nagy.imre@nusz-zrt.hu");               // Még egy címzett  
//$mail->AddAddress("rippert.gabor@nusz-zrt.hu");               // Még egy címzett  
//$mail->AddAddress("nagy.imre@tolna.net","nAGY iMRE");               // Még egy címzett  

//$mail->AddReplyTo("nuszwebir@nusz-zrt.hu");  // Válaszlevél ide  
$mail->AddReplyTo($GLOBALS['rend_emailfelado']);  // Válaszlevél ide  
//$mail->Sender="nuszwebir@nusz-zrt.hu"; 
$mail->Sender=$GLOBALS['rend_emailfelado']; 

$mail->CharSet="UTF-8";
//$mail->Priority = 1; 

$mail->WordWrap = 50;                              // Sortörés állítása  

if(is_array($file)){
foreach($file as $ert){
 if((!isset($ert['nev']))or($ert['nev']==""))
	$ert['nev']=basename($ert['utv']); 
 $mail->AddAttachment($ert['utv'],$ert['nev']); // Csatolás más néven  
}
}

$mail->IsHTML(true);                            // Küldés HTML-ként
//$mail->AddEmbeddedImage('image/logok2.png', 'logoimg', 'logok2.png');
// $mail->AddEmbeddedImage('image/logok2016_f_nusz.png', 'logoimg', 'logok2016_f_nusz.png');
$mail->AddEmbeddedImage('image/logok2022_nkmh.png', 'logoimg', 'logok2022_nkmh.png');

//$mail->Subject = "WFJOG - Igény érkezett";            // A levél tárgya  
$mail->Subject = $targy;            // A levél tárgya  
$mail->Body    = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html><head><TITLE>'.$GLOBALS['rend_nev'].'</TITLE><META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
</head>
<body>'.$level_html.'</body></html>';   // A levél html tartalma  

//$mail->AltBody = $level_sima;     // A levél szöveges tartalma  

if(!$mail->Send()){
 echo "A levél nem került elküldésre";
 echo "A felmerült hiba: " . $mail->ErrorInfo;
 exit;
}
}

function mail_passrec_uj2($targy,$cimzes,$masolat,$level_html,$file){
if((isset($GLOBALS['mail_tilt']))and($GLOBALS['mail_tilt']=="1")) return true;
//$level_html.="<br><br>Ez egy automatikusan generált e-mail, kérjük ne válaszoljon rá.";
$level_html.="<br><br>Ez egy automatikusan generált e-mail, kérlek, ne válaszolj rá.";
//$level_html.="<br><br>Üdvözlettel,<br>MVM Services Zrt.<br>
$level_html.="<br><br>Üdvözlettel,<br>".$GLOBALS['rend_emailfelado_udv_str']."<br>
<a href='".$GLOBALS['url']."'>".$GLOBALS['rend_nev']." ".$GLOBALS['rend_str']."</a>
<br><img src='cid:logoimg'>";
$level_sima=strip_tags($level_html);
include_once($GLOBALS['phpmailer_akt']);
$mail = new PHPMailer\PHPMailer\PHPMailer;  //új 6.x

$mail->From     = $GLOBALS['rend_emailfelado'];                // Feladó e-mail címe  
$mail->FromName = $GLOBALS['rend_nev'].$GLOBALS['tesztdevmod']."";		// Feladó neve  

foreach($cimzes as $ert){
if(($ert['email']!="")and($ert['nev']!=""))
 $mail->AddAddress($ert['email'],$ert['nev']);   // Címzett és neve 
}

if(is_array($masolat)){
 foreach($masolat as $ert){
  if(($ert['email']!="")and($ert['nev']!=""))
   $mail->AddCC($ert['email'],$ert['nev']);// Címzett és neve
 }
}

$mail->AddReplyTo($GLOBALS['rend_emailfelado']);  // Válaszlevél ide  
$mail->Sender=$GLOBALS['rend_emailfelado']; 

// EZT A SORT ADD HOZZÁ KÖZVETLENÜL ALÁ:

// Az elméleti visszapattanó cím explicit megadása a fejlécekben
//$mail->addCustomHeader('Errors-To', $GLOBALS['rend_emailfelado']);
//$mail->addCustomHeader('Return-Path', $GLOBALS['rend_emailfelado']);

$mail->CharSet="UTF-8";
//$mail->Priority = 1; 

$mail->WordWrap = 50;                              // Sortörés állítása  

if(is_array($file)){
foreach($file as $ert){
 if((!isset($ert['nev']))or($ert['nev']==""))
	$ert['nev']=basename($ert['utv']); 
 $mail->AddAttachment($ert['utv'],$ert['nev']); // Csatolás más néven  
}
}

$mail->IsHTML(true);                            // Küldés HTML-ként
$mail->AddEmbeddedImage('image/logok2022_nkmh.png', 'logoimg', 'logok2022_nkmh.png');

$mail->Subject = $targy;            // A levél tárgya  
$mail->Body    = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html><head><TITLE>'.$GLOBALS['rend_nev'].'</TITLE><META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
</head>
<body>'.$level_html.'</body></html>';   // A levél html tartalma  

//$mail->AltBody = $level_sima;     // A levél szöveges tartalma  

if(!$mail->Send()){
 echo "A levél nem került elküldésre";
 echo "A felmerült hiba: " . $mail->ErrorInfo;
 exit;
}
}

function mira_byte_convert($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

function jovahagy_proc_jovahagy_infok($ev,$ho,$user_ad){
 echo "<img style='width:18px' title='<div id=\"jovahagy_infok_".$user_ad."\"></div>' onmouseover='jovahagy_infok_leker(\"".$user_ad."\",\"".$ev."\",\"".$ho."\")' onmouseout='jovahagy_infok_leker_kuka(\"".$user_ad."\")' src='image\info_18.png' class='linkm_tooltip'>";
}

function tavollet_lathato_e($ev,$ho){

//Távollét oszlop idő elrejtése
if(
($GLOBALS['tavollet_nemlat']['ev']=="")
or
($GLOBALS['tavollet_nemlat']['ho']=="")
or
($ev<$GLOBALS['tavollet_nemlat']['ev'])
or
(
 ($ev<=$GLOBALS['tavollet_nemlat']['ev'])
 and
 (
  ($ho=="all")//Statisztikánál
  or
  ($ho<$GLOBALS['tavollet_nemlat']['ho'])
 )
)
){
 return true;
}else{
 return false;
}
}

function kiert_szerz_tagvkat_kat($kat){
$ret=$kat;
switch($kat){
 case'0';
  $ret='Nincs KPI';
 break;
 case'1';
  $ret='1-es szintű';
 break;
 case'2';
  $ret='2-es szintű';
 break;
 case'3';
  $ret='3-es szintű';
 break;
}
return $ret;
}

function kidate_format($date){
if(($date=='0000-00-00 00:00:00')or($date=='')){
 $date='';
}else{
 $date=str_replace('-','.',$date);
 $date=str_replace(' ','. ',$date);
}

if(strlen($date)==10){
 $date.='.';
}
return $date;
}

function kidate_format_ev($date){
if(($date=='0000-00-00')or($date=='')){
 $date='';
}else{
 $date=str_replace('-','.',$date);
 $date=str_replace(' ','. ',$date);
}

return $date;
}

function kiosszeg_format($osszeg){
$osszeg_ret=$osszeg;
if($osszeg!=''){
 $osszeg_ret=number_format($osszeg,0,",",".");
}
return $osszeg_ret;
}

function kiosszeg_format_eur($osszeg){
$osszeg_ret=$osszeg;
if($osszeg!=''){
 $osszeg_ret=number_format($osszeg,2,",",".");
}
return $osszeg_ret;
}

function kiosszeg_format_huf($osszeg){
$osszeg_ret=$osszeg;
if($osszeg!=''){
  $osszeg_ret=number_format($osszeg,2,","," ");
}
return $osszeg_ret;
}

function convert_dateszam($date){
return str_replace('.','',str_replace('-','',$date));
}

function checkmydate($date){

  if(mb_strstr($date,'.')){
   $tempDate = explode('.', $date);
   if(sizeof($tempDate)!=3)return false;
  }else{
   $tempDate=array();
   $tempDate[0]=substr($date,0,4);
   if(mb_strlen($date)>4)
    $tempDate[1]=substr($date,4,2);
   else $tempDate[1]='00';
   if(mb_strlen($date)>6)
    $tempDate[2]=substr($date,6,2);
   else $tempDate[2]='00';
  }

  return checkdate($tempDate[1],$tempDate[2],$tempDate[0]);//checkdate(int $month, int $day, int $year): bool
}

function szerz_statusz($szerz_tetel_modszam,$szerz_tetel_szolg_kezd_date_folyamatban,$szerz_tetel_akt,$szerz_tetel_akt_folyamatban,$szerz_tetel_vege=0){
$ret="";

 
 if(($szerz_tetel_szolg_kezd_date_folyamatban=='1')and($szerz_tetel_vege=='0')){
  $ret.='-1';
  $ret.=' (folyamatban)';
 }elseif(($szerz_tetel_akt=='1')and($szerz_tetel_akt_folyamatban=='0')and($szerz_tetel_vege=='0')){
  $ret.=$szerz_tetel_modszam;
  $ret.=' (aktuális)';
 }elseif(($szerz_tetel_akt_folyamatban=='1')and($szerz_tetel_vege=='0')){
  $ret.=$szerz_tetel_modszam;
  $ret.=' (folyamatban)';
 }elseif($szerz_tetel_vege=='1'){
	 $ret.=$szerz_tetel_modszam;
	 $ret.=' (megszüntetve)';
 }else{
  $ret.=$szerz_tetel_modszam;
 }
 
return $ret;
}
?>