<?php

function max_user_change(){
if(
(isset($_POST['max_user']))
and($_POST['max_user']!="")
){
  $tmp_mod[0]['stat_leker_maxuser']=$_POST['max_user'];
  $GLOBALS['mira']['user_jog']['stat_leker_maxuser']=$_POST['max_user'];
  mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 echo "ok$;$";
}else{
 echo "Adathiány";	
}
}

function stat_leker_ev_change(){
if(
(isset($_POST['idoszak_ev']))
and($_POST['idoszak_ev']!="")
){
 
  //$GLOBALS['mira']['user_jog']['stat_leker_ev']=$_POST['idoszak_ev'];
  
  $_POST['idoszak_ho']=$GLOBALS['mira']['user_jog']['stat_leker_ho'];

  //Év váltás esetén legyen mindig január, csak ha nem az első év - eleje
  if(
  ($_POST['idoszak_ev']!=$GLOBALS['mira']['ev_kezdo_ev'])and
  ($_POST['idoszak_ev']!=$GLOBALS['mira']['user_jog']['stat_leker_ev'])
  ){
	$_POST['idoszak_ho']=1;
  }
  //Év váltás esetén legyen mindig január, csak ha nem az első év - vége

  //Év váltás első év esetén a kezdő hó - eleje
  if(
  ($_POST['idoszak_ev']==$GLOBALS['mira']['ev_kezdo_ev'])and
  ($_POST['idoszak_ev']!=$GLOBALS['mira']['user_jog']['stat_leker_ev'])
  ){
	$_POST['idoszak_ho']=$GLOBALS['mira']['ev_kezdo_ho'];
  }
  //Év váltás első év esetén a kezdő hó - vége
  
  //Ha az aktuális év-hó páros kisebb mint a minimum év, akkor hó átállítás
  if(
  ($GLOBALS['mira']['user_jog']['stat_leker_ev']==$GLOBALS['mira']['ev_kezdo_ev'])and
  ($GLOBALS['mira']['ev_kezdo_ho']<$GLOBALS['mira']['ev_kezdo_ho'])
  ){
	$_POST['idoszak_ho']=$GLOBALS['mira']['ev_kezdo_ho'];  
  }
  
  $tmp_mod=array();
  $GLOBALS['mira']['user_jog']['stat_leker_ev']=$_POST['idoszak_ev'];//Hátha változott
  $tmp_mod[0]['stat_leker_ev']=$_POST['idoszak_ev'];
  if($_POST['idoszak_ho']!=$GLOBALS['mira']['user_jog']['stat_leker_ho'])
   $tmp_mod[0]['stat_leker_ho']=$_POST['idoszak_ho'];

  mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 echo "ok$;$";
}else{
 echo "Adathiány";	
}
}

function stat_ful_ki(){
//echo "<b>Statisztika készítés</b><br>";

if(
(!isset($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_stat']))or
($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_stat']==0)	
){
echo "<b>Nincs jogosultságod statisztika készítésre!</b><br>";
exit;
}

//Régi módszer:
/*
if($_SESSION[$GLOBALS['sessionname']]['jog']['ful_stat_all']==1)
 //$tomb_szerv=keres_mit2_order("mira_szerv","szerv_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"szerv_inaktiv","0","szerv_nev","asc");
 $tomb_szerv=keres_mit1_order("mira_szerv","szerv_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"szerv_nev","asc");
else
 $tomb_szerv=keres_user_stat_szerv_jogok();
if(!is_array($tomb_szerv)){
 echo "<b>Nincs jogosultságod statisztika készítésre!</b><br>";
 exit;
}
*/
//Új módszer select2
if(
($_SESSION[$GLOBALS['sessionname']]['jog']['ful_stat_all']!=1)
and
(keres_user_stat_szerv_jogok_vane()=="")
){
 echo "<b>Nincs jogosultságod statisztika készítésre!</b><br>";
 exit;
}



//Régi módszer:
/*
if($_SESSION[$GLOBALS['sessionname']]['jog']['ful_stat_projekt_all']==1)
 $tomb_projekt=keres_mit1_order("projekt","projekt_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"projekt_nev","asc");
else
 $tomb_projekt=keres_user_stat_projekt_jogok();
if(!is_array($tomb_projekt)){
 echo "<b>Nincs jogosultságod statisztika készítésre!</b><br>";
 exit;
}
*/
//Új módszer select2
if(
($_SESSION[$GLOBALS['sessionname']]['jog']['ful_stat_projekt_all']!=1)
and
(keres_user_stat_projekt_jogok_vane()=="")
){
 echo "<b>Nincs jogosultságod statisztika készítésre!</b><br>";
 exit;
}

//$_POST['stat_melyik_ev']="2021";
//$_POST['stat_melyik_ho']="9";

$ma_most = date("Ym",time());
$nextev = date('Y', strtotime('+1 month', (strtotime($ma_most))));
$ev_most=date("Y",time());
//$homost = date("m",time());
//$nextho = date('m', strtotime('+1 month', (strtotime($ma_most))));
$ho_most=date("n",time());
if($ho_most<10){
	$nextho=$ho_most+1;
	$nextho="0".$nextho;
}elseif($ho_most==10) $nextho=11;
elseif($ho_most==11) $nextho=12;
else $nextho=1;

$ment_alap=0;
$tmp_mod=array();
//Ha nincs semmi év - eleje
if(
(!isset($GLOBALS['mira']['user_jog']['stat_leker_ev']))
or($GLOBALS['mira']['user_jog']['stat_leker_ev']=="")
){
 //$_POST['idoszak_ev']=date("Y",time());//$ev_most
 $ev_most=date("Y",time());
 if($ev_most>=$GLOBALS['mira']['ev_kezdo_ev'])
  $_POST['idoszak_ev']=$ev_most;//$ev_most
 else
  $_POST['idoszak_ev']=$GLOBALS['mira']['ev_kezdo_ev'];
 
 $GLOBALS['mira']['user_jog']['stat_leker_ev']=$_POST['idoszak_ev'];
 $tmp_mod[0]['stat_leker_ev']=$_POST['idoszak_ev'];
 $ment_alap=1;
}
//Ha nincs semmi év - vége

//Ha nincs semmi hó - eleje
if(
(!isset($GLOBALS['mira']['user_jog']['stat_leker_ho']))
or($GLOBALS['mira']['user_jog']['stat_leker_ho']=="")
){
 //$_POST['idoszak_ho']=date("m",time());//$ho_most
 
 $ev_most=date("Y",time());
 $ho_most=date("n",time());
 if($ev_most<$GLOBALS['mira']['ev_kezdo_ev']){
  $_POST['idoszak_ho']=$GLOBALS['mira']['ev_kezdo_ho'];
 }else{
  if(
  ($ev_most==$GLOBALS['mira']['ev_kezdo_ev'])and
  ($ho_most<$GLOBALS['mira']['ev_kezdo_ho'])
  ){
    $_POST['idoszak_ho']=$GLOBALS['mira']['ev_kezdo_ho'];
   }else{
	$_POST['idoszak_ho']=$ho_most;   
   }
 }
 
 $GLOBALS['mira']['user_jog']['stat_leker_ho']=$_POST['idoszak_ho'];
 $tmp_mod[0]['stat_leker_ho']=$_POST['idoszak_ho'];
 $ment_alap=1;
}
//Ha nincs semmi hó - vége

if($ment_alap==1)
  mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);

echo "<div class='stat_divteje'>";
echo "<div class='stat_table_bal'>";

echo "<table cellpadding=1 cellspacing=1 style='margin-top:0px;display:inline-block;float:left' class='table_emre'>";

//Év - eleje
echo "<tr>";
echo "<td style='width:135px'>";
echo "<td style='width:20px'><span class='jovahagy_szur_str'>Év</span>";
echo "<td style='width:20px'>";
echo "<select onchange='stat_leker_ev_change()' class='jovahagy_ki_sel' id='stat_leker_ev' style='margin:0px'>";
for($ev_ki=$GLOBALS['mira']['ev_kezdo_ev'];$ev_ki<=$nextev;$ev_ki++){
if($ev_ki==$GLOBALS['mira']['user_jog']['stat_leker_ev']) $sel=" selected";
else $sel="";

 echo "<option class='fo_table_ki_sel_option' value='".$ev_ki."'".$sel.">".$ev_ki;
}
echo "</select>";
//Év - vége

//Hó - eleje
echo "<td style='width:60px'><span class='jovahagy_szur_str'>Hónap</span>";
echo "<td style='width:90px'>";
echo "<select onchange='stat_leker_ho_change()' class='jovahagy_ki_sel' id='stat_leker_ho' style='margin:0px'>";

//Kezdő hó lerendezése
if($GLOBALS['mira']['user_jog']['stat_leker_ev']==$GLOBALS['mira']['ev_kezdo_ev']){
 $kezd_ho=$GLOBALS['mira']['ev_kezdo_ho'];
}else{
 $kezd_ho=1;	
}
 
//Vége hó lerendezése
if((isset($GLOBALS['mira']['user_jog']['stat_leker_ev']))and($GLOBALS['mira']['user_jog']['stat_leker_ev']==$ev_most)){
 if(date("m",time())==12)
  $vege_ho=12;
 else
  $vege_ho=$nextho;
}elseif(($GLOBALS['mira']['user_jog']['stat_leker_ev']>$ev_most)and($nextho==1)){
 $vege_ho=$nextho;
}else{
 $vege_ho=12;
}

/*if(
($_SESSION[$GLOBALS['sessionname']]['login_ad']=="a2675")or//Nagy Imre
($_SESSION[$GLOBALS['sessionname']]['login_ad']=="f7145")or//Lipták Gábor
($_SESSION[$GLOBALS['sessionname']]['login_ad']=="baknp")or//Bak Norbert
($_SESSION[$GLOBALS['sessionname']]['login_ad']=="e2600")//Gellei Ákos Imre
){*/
if($GLOBALS['mira']['user_jog']['stat_leker_ho']=="all") $sel=" selected ";
else $sel="";
 echo "<option class='fo_table_ki_sel_option' value='all'".$sel.">Egész év";
//}

for($ho_ki=$kezd_ho;$ho_ki<=$vege_ho;$ho_ki++){

if($ho_ki==$GLOBALS['mira']['user_jog']['stat_leker_ho']) $sel=" selected ";
else $sel="";

 echo "<option class='fo_table_ki_sel_option' value='".$ho_ki."'".$sel.">".ho_ki($ho_ki);
}

echo "</select>";
//Hó - vége

//Nap
echo "<td style='width:30px'>";
echo "<span class='jovahagy_szur_str'>Nap</span>";
echo "<td style='width:105px'>";
echo "<select onchange='stat_leker_nap_change()' class='jovahagy_ki_sel' id='stat_leker_nap' style='margin:0px'>";
echo "<option value='all'>Egész hónap";
for($i=1;$i<=31;$i++){
 if($i==$GLOBALS['mira']['user_jog']['stat_leker_nap'])
  $sel=" selected";
 else $sel="";
 echo "<option value='".$i."'".$sel.">".$i;
}
echo "</select>";
echo "</tr>";

//Statisztika típusa - eleje
echo "<tr>";
echo "<td>";
echo "<span class='jovahagy_szur_str'>Statisztika típusa</span>";
echo "<td colspan=6>";
//echo "<select class='stat_select2' onchange='stat_leker_tipus_change()' id='stat_leker_tipus' style='width:406px'>";
echo "<select class='select3' onchange='stat_leker()' id='stat_leker_tipus' style='width:406px'>";//class='stat_select2'
//echo "<option value='keremv'>Kérem válassz";

echo "<option value='user_napi'";
if($GLOBALS['mira']['user_jog']['stat_leker_tipus']=="user_napi")
 echo " selected";
echo ">Felhasználók napi összesítése";

echo "<option value='napi_user'";
if($GLOBALS['mira']['user_jog']['stat_leker_tipus']=="napi_user")
 echo " selected";
echo ">Napi összesítés felhasználók szerint";

echo "<option value='projekt_napi'";
if($GLOBALS['mira']['user_jog']['stat_leker_tipus']=="projekt_napi")
 echo " selected";
echo ">Tevékenység napi összesítése";

echo "<option value='projekt_szerv'";
if($GLOBALS['mira']['user_jog']['stat_leker_tipus']=="projekt_szerv")
 echo " selected";
echo ">Tevékenység-szervezet összesítése";



echo "<option value='szervezet_napi'";
if($GLOBALS['mira']['user_jog']['stat_leker_tipus']=="szervezet_napi")
 echo " selected";
echo ">Szervezet napi összesítése";

echo "<option value='szerv_projekt'";
if($GLOBALS['mira']['user_jog']['stat_leker_tipus']=="szerv_projekt")
 echo " selected";
echo ">Szervezet-tevékenység összesítése";


echo "<option value='reszletes'";
if($GLOBALS['mira']['user_jog']['stat_leker_tipus']=="reszletes")
 echo " selected";
echo ">Részletes excel táblázat";

echo "<option value='reszletes2'";
if($GLOBALS['mira']['user_jog']['stat_leker_tipus']=="reszletes2")
 echo " selected";
echo ">Részletesebb excel táblázat";

echo "</select>";
echo "</tr>";
//Statisztika típusa - vége

//Státuszra szűrés - eleje
echo "<tr>";
echo "<td>";
echo "<span class='jovahagy_szur_str'>Státuszra szűrés</span>";
echo "<td colspan=6>";
echo "<select class='select3' onchange='stat_leker_kiuser_change()' id='stat_leker_kiuser' style='width:406px'>";//c1lass='stat_select2'
echo "<option value='all'>Összes";

echo "<option value='csak_rogzitett'";
if($GLOBALS['mira']['user_jog']['stat_leker_kiuser']=="csak_rogzitett")
 echo " selected";
echo ">Rögzített adattal rendelkező felhasználók";

echo "<option value='nem_rogzitett'";
if($GLOBALS['mira']['user_jog']['stat_leker_kiuser']=="nem_rogzitett")
 echo " selected";
echo ">Rögzített adattal nem rendelkező felhasználók";

echo "<option value='nem_zart_le'";
if($GLOBALS['mira']['user_jog']['stat_leker_kiuser']=="nem_zart_le")
 echo " selected";
echo ">Rögzített, de lezárt hónappal nem rendelkező felhasználók";


echo "<option value='csak_lezart'";
if($GLOBALS['mira']['user_jog']['stat_leker_kiuser']=="csak_lezart")
 echo " selected";
echo ">Lezárt hónappal rendelkező felhasználók";

echo "<option value='le_nem_zart_user'";
if($GLOBALS['mira']['user_jog']['stat_leker_kiuser']=="le_nem_zart_user")
 echo " selected";
echo ">Lezárt hónappal nem rendelkező felhasználók (rögzített és a nem rögzített felhasználók is)";

echo "<option value='jova_nem_hagyott'";
if($GLOBALS['mira']['user_jog']['stat_leker_kiuser']=="jova_nem_hagyott")
 echo " selected";
echo ">Lezárt, de jóváhagyással nem rendelkező felhasználók";

echo "<option value='csak_jovahagyott'";
if($GLOBALS['mira']['user_jog']['stat_leker_kiuser']=="csak_jovahagyott")
 echo " selected";
echo ">Lezárt és jóváhagyott hónappal rendelkező felhasználók";

echo "</select>";
echo "</tr>";
//Státuszra szűrés - vége

//Szűrés tevékenységre - eleje
echo "<tr>";
echo "<td>";
echo "<span class='jovahagy_szur_str'>Tevékenységre szűrés</span>";
echo "<td colspan=6>";
echo "<select class='stat_select2' onchange='stat_leker_projekt_id_change()' id='stat_leker_projekt_id' style='width:406px'>";

//Új módszer select2
if(
($GLOBALS['mira']['user_jog']['stat_leker_projekt_id']!="")and
($GLOBALS['mira']['user_jog']['stat_leker_projekt_id']!="all")
){
 $tomb_projekt_nev=keres_mit1_mit1_csak_ertek("projekt","projekt_id",$GLOBALS['mira']['user_jog']['stat_leker_projekt_id'],"projekt_nev");
  if($tomb_projekt_nev!="")
   echo "<option value='".$GLOBALS['mira']['user_jog']['stat_leker_projekt_id']."'>".$tomb_projekt_nev;
  else
   echo "<option value='all'>Összes";	
}else{
 echo "<option value='all'>Összes";	
}


//Régi fix select-s módszer
/*
if(sizeof($tomb_projekt)>1)
 echo "<option value='all'>Összes";

if(is_array($tomb_projekt)){
foreach($tomb_projekt as $ert_sz){
 if($ert_sz['projekt_id']==$GLOBALS['mira']['user_jog']['stat_leker_projekt_id'])
  $sel=" selected";
 else $sel="";
 
 if($ert_sz['projekt_inaktiv']=="1")
  $tev_in=" (inaktív)";
 else
   $tev_in="";
 echo "<option value='".$ert_sz['projekt_id']."'".$sel.">".$ert_sz['projekt_nev'].$tev_in;
}

}
*/

echo "</select>";
echo "</tr>";
//Szűrés tevékenységre - vége

//Szűrés szervezetre
echo "<tr>";
echo "<td>";
echo "<span class='jovahagy_szur_str'>Szervezetre szűrés</span>";
echo "<td colspan=6>";
echo "<select class='stat_select2' onchange='stat_leker_szerv_id_change()' id='stat_leker_szerv_id' style='width:406px'>";

//Új módszer select2
if(
($GLOBALS['mira']['user_jog']['stat_leker_szerv_id']!="")and
($GLOBALS['mira']['user_jog']['stat_leker_szerv_id']!="all")
){
 $tomb_szerv_nev=keres_mit1_mit1_csak_ertek("mira_szerv","szerv_id",$GLOBALS['mira']['user_jog']['stat_leker_szerv_id'],"szerv_nev");
  if($tomb_szerv_nev!="")
   echo "<option value='".$GLOBALS['mira']['user_jog']['stat_leker_szerv_id']."'>".$tomb_szerv_nev;
  else
   echo "<option value='all'>Összes";	
}else{
 echo "<option value='all'>Összes";	
}
//Régi fix select-s módszer
/*
if(is_array($tomb_szerv)){

if(sizeof($tomb_szerv)>1)
 echo "<option value='all'>Összes";

foreach($tomb_szerv as $ert_sz){
 if($ert_sz['szerv_id']==$GLOBALS['mira']['user_jog']['stat_leker_szerv_id'])
  $sel=" selected";
 else $sel="";
 echo "<option value='".$ert_sz['szerv_id']."'".$sel.">".$ert_sz['szerv_nev'];
 if($ert_sz['szerv_inaktiv']==1) echo " (inaktív)";
}
}
*/

echo "</select>";
echo "</tr>";


echo "<tr>";
echo "<td>";
echo "<span class='jovahagy_szur_str'>Felhasználóra szűrés</span>";
echo "<td colspan=6>";
//echo "<div style='height:3px'></div>";//-3px margin-top miatt
echo "<select class='stat_select2' onchange='stat_leker_user_change()' id='stat_leker_user' style='width:406px'>";
if(
($GLOBALS['mira']['user_jog']['stat_leker_user']!="")and
($GLOBALS['mira']['user_jog']['stat_leker_user']!="all")
){
 //$tomb_userjo_nev=keres_mit1_mit1_csak_ertek("mira_user","user_ad",$GLOBALS['mira']['user_jog']['stat_leker_user'],"user_nev");
  //if($tomb_userjo_nev!="")
  $tomb_userjo=keres_mit1("mira_user","user_ad",$GLOBALS['mira']['user_jog']['stat_leker_user']);
  if(is_array($tomb_userjo)){
   if($tomb_userjo[0]['user_inaktiv']=="1")$ki_in=" inaktív";
   else $ki_in="";
   $tomb_userjo_nev_ki=$tomb_userjo[0]['user_nev']." (".$tomb_userjo[0]['user_tsz'].", ".$tomb_userjo[0]['user_ad'].$ki_in.")";
   echo "<option value='".$GLOBALS['mira']['user_jog']['stat_leker_user']."'>".$tomb_userjo_nev_ki;
  }else
   echo "<option value='all'>Összes";	
}else{
 echo "<option value='all'>Összes";	
}


echo "</select>";
echo "</tr>";

echo "<tr>";
echo "<td align=center>";
//echo "<input onclick='stat_leker()' id='stat_leker_submitsubmit' type='submit' value='Megjelenítés'>";
echo "<td colspan=6 align=center>";

if(
(isset($GLOBALS['mira']['user_jog']['stat_leker_ho']))and
($GLOBALS['mira']['user_jog']['stat_leker_ho']=='all')
){
 $submit_excel_val='Excel csv statisztika letöltése'; 
}else{
 $submit_excel_val='Excel statisztika letöltése'; 
}

echo "<input onclick='stat_xlsx_leker()' id='stat_xlsx_leker_submit' type='submit' value='".$submit_excel_val."' class='submit2'>";
//echo "<img src='image/excel_e1_k20.png' onclick='stat_xlsx_leker();' id='stat_xlsx_leker_submit' title='Excel statisztika letöltése' style='margin-left:10px' class='link'>";

echo "</tr>";


echo "</table>";
echo "</div>";

echo "<div class='stat_divsugo'>";
//echo "<b>Statisztikák</b>";
//echo "<a style='color:blue' target=_blank href='doc/mira_stat.php'><b>".$GLOBALS['rend_nev']." statisztika modul leírása</b></a>";
echo "<span onclick='open_stat_kezi()' class='link_vas'><b>".$GLOBALS['rend_nev']." statisztika modul leírása</b></span>";
echo "<br>";

echo "<ul>";
echo "<li>Tevékenység-szervezet és részletes excel táblázatok esetén a szervezet a rögzítés időpontjában aktuális szervezet";
echo "<li>Részletes excel táblázatok minden esetben csak a rögzített adatokat tartalmazza";

//Távollét oszlop idő elrejtése
if(tavollet_lathato_e($GLOBALS['mira']['user_jog']['stat_leker_ev'],$GLOBALS['mira']['user_jog']['stat_leker_ho'])){
echo "<li>Távollét csak a részletes excel táblázatban, és a következő 2 webes statisztikában jelenik meg";
	echo "<ul>";
	echo "<li>Felhasználók napi összesítése";
	echo "<li>Napi összesítés felhasználók szerint";
	echo "</ul>";
echo "</ul>";
}

echo "</div>";
echo "</div>";

//echo "<br>";

maxuser_szam_select();
echo '<div id="scroll1" style="overflow-x:auto;">';
echo '<div></div>';
echo '</div>';
echo '<div id="scroll2" style="overflow-x:auto;">';

echo "<div id='stat_ered_div' style='margin-top:10px'>";//display:none;
echo "</div>";

echo "</div>";

}

function maxuser_szam_select(){
 echo "<div id='max_user_div'>";
 echo "Max felhasználók száma: ";
 echo '<select onchange="max_user_change()" id="max_user_select" style="margin:0px;" class="jovahagy_ki_sel">';
 
 
 echo "<option value='5'";
 if($GLOBALS['mira']['user_jog']['stat_leker_maxuser']==5)
  echo " selected";
 echo ">5";
 
 echo "<option value='10'";
 if($GLOBALS['mira']['user_jog']['stat_leker_maxuser']==10)
  echo " selected";
 echo ">10";
 
 echo "<option value='20'";
 if($GLOBALS['mira']['user_jog']['stat_leker_maxuser']==20)
  echo " selected";
 echo ">20";
 
 echo "<option value='30'";
 if($GLOBALS['mira']['user_jog']['stat_leker_maxuser']==30)
  echo " selected";
 echo ">30";
 
 echo "<option value='50'";
 if($GLOBALS['mira']['user_jog']['stat_leker_maxuser']==50)
  echo " selected";
 echo ">50"; 

 echo "<option value='100'";
 if($GLOBALS['mira']['user_jog']['stat_leker_maxuser']==100)
  echo " selected";
 echo ">100";
 
 echo "<option value='200'";
 if($GLOBALS['mira']['user_jog']['stat_leker_maxuser']==200)
  echo " selected";
 echo ">200";
 
 echo "<option value='300'";
 if($GLOBALS['mira']['user_jog']['stat_leker_maxuser']==300)
  echo " selected";
 echo ">300"; 
 
 echo "<option value='500'";
 if($GLOBALS['mira']['user_jog']['stat_leker_maxuser']==500)
  echo " selected";
 echo ">500";
 
 echo "<option value='1000'";
 if($GLOBALS['mira']['user_jog']['stat_leker_maxuser']==1000)
  echo " selected";
 echo ">1000";
 
 echo "<option value='2000'";
 if($GLOBALS['mira']['user_jog']['stat_leker_maxuser']==2000)
  echo " selected";
 echo ">2000";
 
 echo "</select>";
 echo "</div>";
}

?>