<?php

function jovahagy_ful_ki(){

if(
(!isset($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']))or
($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']==0)	
){
echo "<b>Nincs jogosultságod jóváhagyásra</b><br>";
exit;
}

//Jóváhagyásra váró szervezetek
$tomb_jovahagyhato_szerv=keres_aktuser_jovahagyhato_szerv_adat();
$tomb_felettes_jovahagyhato_user=keres_aktuser_felettes_jovahagyhato_user_adat();
$tomb_projekt_jovahagyhato_user=keres_aktuser_projekt_jovahagyhato_user_adat();
if(
(!is_array($tomb_jovahagyhato_szerv))
and
(!is_array($tomb_felettes_jovahagyhato_user))
and
(!is_array($tomb_projekt_jovahagyhato_user))
){
 //echo "<b>Egy szervezetre sincs jóváhagyási jogod!</b>";
 echo "<b>Nincs jóváhagyási jogosultságod!</b>";
 exit;
}else{

//Szűrés

echo "<div class='div_jovahagyo_linkek'>";
echo "<span onclick='open_jovah_kezi()' class='span_kitolt_utmutato'>Jóváhagyói kézikönyv</span>";
echo "</div>";

//Végeredmény
echo "<div id='jovahagyas_szurered_div' style='overflow-x:auto;'>";
jovahagy_ful_ki_table_ment();
jovahagy_ful_ki_szures($tomb_jovahagyhato_szerv,$tomb_felettes_jovahagyhato_user,$tomb_projekt_jovahagyhato_user);
echo "</div>";

echo "<div id='jovahagyas_ered_div'>";
echo "</div>";

}

}

function jovahagy_evvalt(){
echo 'ok$;$';

jovahagy_ful_ki_table_ment();
//Szűrés
$tomb_jovahagyhato_szerv=keres_aktuser_jovahagyhato_szerv_adat();
$tomb_felettes_jovahagyhato_user=keres_aktuser_felettes_jovahagyhato_user_adat();
$tomb_projekt_jovahagyhato_user=keres_aktuser_projekt_jovahagyhato_user_adat();
jovahagy_ful_ki_szures($tomb_jovahagyhato_szerv,$tomb_felettes_jovahagyhato_user,$tomb_projekt_jovahagyhato_user);

}

function jovahagy_ful_ki_szures($tomb_jovahagyhato_szerv,$tomb_felettes_jovahagyhato_user,$tomb_projekt_jovahagyhato_user){
echo "<table border=0 class='table_emre_bejovo'>";
echo "<tr>";
echo "<td><span class='jovahagy_szur_str'>Jóváhagyásra jogosult</span><br>";//szervezetek

$all_szerv_id="";

echo "<select onchange='jovahagy_keress()' class='jovahagy_ki_sel' id='jovahagy_melyik_szerv' style='margin-top:5px'>";

if((is_array($tomb_felettes_jovahagyhato_user))or(is_array($tomb_jovahagyhato_szerv))){
echo '<optgroup label="Szervezeti jóváhagyás">';//Szervezeti jóváhagyás
}

if(is_array($tomb_jovahagyhato_szerv)){
foreach($tomb_jovahagyhato_szerv as $szerv_id => $szerv_nev){
$all_szerv_id.=$szerv_id.",";
if((isset($GLOBALS['mira']['user_jog']['jovahagy_szur_szerv_id']))and($GLOBALS['mira']['user_jog']['jovahagy_szur_szerv_id']==$szerv_id))
 $sel=" selected";
else
 $sel="";
 echo "<option akt_szerv_id='".$szerv_id."' class='fo_table_ki_sel_option' value='".$szerv_id."'".$sel.">".$szerv_nev;
}


if(count($tomb_jovahagyhato_szerv)>1){
if((isset($GLOBALS['mira']['user_jog']['jovahagy_szur_szerv_id']))and($GLOBALS['mira']['user_jog']['jovahagy_szur_szerv_id']=="all"))
 $sel=" selected";
else
 $sel="";
echo "<option akt_szerv_id='".$all_szerv_id."' class='fo_table_ki_sel_option' value='all'".$sel.">Összes jogosult szervezet";
}
}

echo '<optgroup label="Felettes jóváhagyás">';//Szervezeti jóváhagyás

if(is_array($tomb_felettes_jovahagyhato_user)){
if((isset($GLOBALS['mira']['user_jog']['jovahagy_szur_szerv_id']))and($GLOBALS['mira']['user_jog']['jovahagy_szur_szerv_id']=="all_f"))
 $sel=" selected";
else
 $sel="";
 echo "<option akt_szerv_id='all_f' class='fo_table_ki_sel_option' value='all_f'".$sel.">Összes jogosult felettes jóváhagyás";
}
echo '</optgroup>';

if(is_array($tomb_projekt_jovahagyhato_user)){
echo '<optgroup label="Projekt jóváhagyás">';//Projekt jóváhagyás
foreach($tomb_projekt_jovahagyhato_user as $j_projekt_id => $j_projekt_nev){
 if((isset($GLOBALS['mira']['user_jog']['jovahagy_szur_szerv_id']))and($GLOBALS['mira']['user_jog']['jovahagy_szur_szerv_id']=='projekt_'.$j_projekt_id))
  $sel=" selected";
 else
  $sel="";
 echo '<option akt_szerv_id="projekt_'.$j_projekt_id.'" class="fo_table_ki_sel_option" value="projekt_'.$j_projekt_id.'"'.$sel.'>'.$j_projekt_nev;
}
echo '</optgroup>';
}
echo "</select>";

$ma_most = date("Ym",time());
$nextev = date('Y', strtotime('+1 month', (strtotime($ma_most))));
$ev_most=date("Y",time());
$homost = date("n",time());
//$nextho = date('m', strtotime('+1 month', (strtotime($ma_most))));
if($homost<10){
	$nextho=$homost+1;
	$nextho="0".$nextho;
}elseif($homost==10) $nextho=11;
elseif($homost==11) $nextho=12;
else $nextho=1;

/*
if(
(!isset($_POST['jovahagy_melyik_ev']))and
(isset($GLOBALS['mira']['user_jog']['jovahagy_szur_ev']))
and($GLOBALS['mira']['user_jog']['jovahagy_szur_ev']!="")
){
 $_POST['jovahagy_melyik_ev']=$GLOBALS['mira']['user_jog']['jovahagy_szur_ev'];
}else{
 $GLOBALS['mira']['user_jog']['jovahagy_szur_ev']=$_POST['jovahagy_melyik_ev']=date("Y",time());//$ev_most
}
*/

/*
if(
(!isset($_POST['jovahagy_szur_ho']))and
(isset($GLOBALS['mira']['user_jog']['jovahagy_szur_ho']))
and($GLOBALS['mira']['user_jog']['jovahagy_szur_ho']!="")
){
 $_POST['jovahagy_melyik_ho']=$GLOBALS['mira']['user_jog']['jovahagy_szur_ho'];
}else{
 $GLOBALS['mira']['user_jog']['jovahagy_szur_ho']=$_POST['jovahagy_melyik_ho']=date("m",time());//$homost
}
*/

//Év - eleje
echo "<td><span class='jovahagy_szur_str'>Év</span><br>";
//echo "<select onchange='jovahagy_keress()' class='jovahagy_ki_sel' id='jovahagy_melyik_ev' style='margin-top:5px'>";
echo "<select onchange='jovahagy_evvalt()' class='jovahagy_ki_sel' id='jovahagy_melyik_ev' style='margin-top:5px'>";
for($ev_ki=$GLOBALS['mira']['ev_kezdo_ev'];$ev_ki<=$nextev;$ev_ki++){
if($ev_ki==$GLOBALS['mira']['user_jog']['jovahagy_szur_ev']) $sel="selected ";
else $sel="";

 echo "<option class='fo_table_ki_sel_option' value='".$ev_ki."'".$sel.">".$ev_ki;
}
echo "</select>";
//Év - vége

//Hó - eleje
echo "<td><span class='jovahagy_szur_str'>Hónap</span><br>";
echo "<select onchange='jovahagy_keress()' class='jovahagy_ki_sel' id='jovahagy_melyik_ho' style='margin-top:5px'>";

//Kezdő hó lerendezése
if($GLOBALS['mira']['user_jog']['jovahagy_szur_ev']==$GLOBALS['mira']['ev_kezdo_ev']){
 $kezd_ho=$GLOBALS['mira']['ev_kezdo_ho'];
}else{
 $kezd_ho=1;	
}

//Vége hó lerendezése
if($GLOBALS['mira']['user_jog']['jovahagy_szur_ev']==$ev_most){
 if($homost==12)
  $vege_ho=12;
 else
  $vege_ho=$nextho;
}elseif(($GLOBALS['mira']['user_jog']['jovahagy_szur_ev']>$ev_most)and($nextho==1)){
 $vege_ho=$nextho;
}else{
 $vege_ho=12;
}

for($ho_ki=$kezd_ho;$ho_ki<=$vege_ho;$ho_ki++){

if($ho_ki==$GLOBALS['mira']['user_jog']['jovahagy_szur_ho']) $sel="selected ";
else $sel="";

 echo "<option class='fo_table_ki_sel_option' value='".$ho_ki."' ".$sel.">".ho_ki($ho_ki);
}
echo "</select>";
//Hó - vége

//Név - eleje
echo "<td><span class='jovahagy_szur_str' style='margin-bottom:4px;margin-top:-6px;display:block'>Felhasználó</span>";
echo "<select onchange='jovahagy_keress()' id='jovahagy_melyik_user' style='width:402px'>";

if(
($GLOBALS['mira']['user_jog']['jovahagy_szur_user_ad']=="all")or
($GLOBALS['mira']['user_jog']['jovahagy_szur_user_ad']=="")
){
 echo "<option value='all'>Összes";
}else{
 //$tomb_userjo_nev=keres_mit1_mit1_csak_ertek("mira_user","user_ad",$GLOBALS['mira']['user_jog']['jovahagy_szur_user_ad'],"user_nev");
 $tomb_userjo=keres_mit1("mira_user","user_ad",$GLOBALS['mira']['user_jog']['jovahagy_szur_user_ad']);
 if($tomb_userjo[0]['user_inaktiv']=="1")$ki_in=" inaktív";
 else $ki_in="";
 $tomb_userjo_nev_ki=$tomb_userjo[0]['user_nev']." (".$tomb_userjo[0]['user_tsz'].", ".$tomb_userjo[0]['user_ad'].$ki_in.")";
 echo "<option value='".$GLOBALS['mira']['user_jog']['jovahagy_szur_user_ad']."'>".$tomb_userjo_nev_ki;
}

echo "</select>";
//Név - vége

echo "</tr>";
echo "</table>";

}

function jovahagy_ful_ki_table_ment(){
$tmp_mod="";

//Ha nincs semmi év - eleje
if(
(!isset($GLOBALS['mira']['user_jog']['jovahagy_szur_ev']))
or($GLOBALS['mira']['user_jog']['jovahagy_szur_ev']=="")
){
 $ev_most=date("Y",time());
 if($ev_most>=$GLOBALS['mira']['ev_kezdo_ev'])
  $_POST['jovahagy_melyik_ev']=$ev_most;//$ev_most
 else
  $_POST['jovahagy_melyik_ev']=$GLOBALS['mira']['ev_kezdo_ev'];
 
 $GLOBALS['mira']['user_jog']['jovahagy_szur_ev']=$_POST['jovahagy_melyik_ev'];
 if(!is_array($tmp_mod))$tmp_mod=array();
 $tmp_mod[0]['jovahagy_szur_ev']=$_POST['jovahagy_melyik_ev'];
 }
//Ha nincs semmi év - vége

//Ha nincs semmi hó - eleje
if(
(!isset($GLOBALS['mira']['user_jog']['jovahagy_szur_ho']))
or($GLOBALS['mira']['user_jog']['jovahagy_szur_ho']=="")
){
 //$_POST['jovahagy_melyik_ho']=date("m",time());//$ho_most
 $ev_most=date("Y",time());
 $ho_most=date("n",time());
 if($ev_most<$GLOBALS['mira']['ev_kezdo_ev']){
  $_POST['jovahagy_melyik_ho']=$GLOBALS['mira']['ev_kezdo_ho'];
 }else{
  if(
  ($ev_most==$GLOBALS['mira']['ev_kezdo_ev'])and
  ($ho_most<$GLOBALS['mira']['ev_kezdo_ho'])
  ){
    $_POST['jovahagy_melyik_ho']=$GLOBALS['mira']['ev_kezdo_ho'];
   }else{
	$_POST['jovahagy_melyik_ho']=$ho_most;   
   }
 }
 $GLOBALS['mira']['user_jog']['jovahagy_szur_ho']=$_POST['jovahagy_melyik_ho'];
 if(!is_array($tmp_mod))$tmp_mod=array();
 $tmp_mod[0]['jovahagy_szur_ho']=$_POST['jovahagy_melyik_ho'];
}
//Ha nincs semmi hó - vége

  //Év váltás esetén legyen mindig január, csak ha nem az első év - eleje
  if(
  (isset($_POST['jovahagy_melyik_ev']))and
  ($_POST['jovahagy_melyik_ev']!=$GLOBALS['mira']['ev_kezdo_ev'])and
  ($_POST['jovahagy_melyik_ev']!=$GLOBALS['mira']['user_jog']['jovahagy_szur_ev'])
  ){
	$_POST['jovahagy_melyik_ho']=1;
  }
  //Év váltás esetén legyen mindig január, csak ha nem az első év - vége

  //Év váltás első év esetén a kezdő hó - eleje
  if(
  (isset($_POST['jovahagy_melyik_ev']))and
  ($_POST['jovahagy_melyik_ev']==$GLOBALS['mira']['ev_kezdo_ev'])and
  ($_POST['jovahagy_melyik_ev']!=$GLOBALS['mira']['user_jog']['jovahagy_szur_ev'])
  ){
	$_POST['jovahagy_melyik_ho']=$GLOBALS['mira']['ev_kezdo_ho'];
  }
  //Év váltás első év esetén a kezdő hó - vége

  //Ha az aktuális év-hó páros kisebb mint a minimum év, akkor hó átállítás
  if(
  ($GLOBALS['mira']['user_jog']['jovahagy_szur_ev']==$GLOBALS['mira']['ev_kezdo_ev'])and
  ($GLOBALS['mira']['user_jog']['jovahagy_szur_ho']<$GLOBALS['mira']['ev_kezdo_ho'])
  ){
	$_POST['jovahagy_melyik_ho']=$GLOBALS['mira']['ev_kezdo_ho'];  
  }

if(isset($_POST['szerv_id'])){
if($_POST['szerv_id']!=$GLOBALS['mira']['user_jog']['jovahagy_szur_szerv_id']){
 if(!is_array($tmp_mod))$tmp_mod=array();
 $tmp_mod[0]['jovahagy_szur_szerv_id']=$_POST['szerv_id'];
 $GLOBALS['mira']['user_jog']['jovahagy_szur_szerv_id']=$_POST['szerv_id'];
}
}

if(isset($_POST['jovahagy_melyik_ev'])){
if($_POST['jovahagy_melyik_ev']!=$GLOBALS['mira']['user_jog']['jovahagy_szur_ev']){
 if(!is_array($tmp_mod))$tmp_mod=array();
 $tmp_mod[0]['jovahagy_szur_ev']=$_POST['jovahagy_melyik_ev'];
 $GLOBALS['mira']['user_jog']['jovahagy_szur_ev']=$_POST['jovahagy_melyik_ev'];
}
}

//Kezdő hó lerendezése
/*
if($GLOBALS['mira']['user_jog']['jovahagy_szur_ev']==$GLOBALS['mira']['ev_kezdo_ev']){
 $_POST['jovahagy_melyik_ho']=$GLOBALS['mira']['ev_kezdo_ho'];
}
*/

if(isset($_POST['jovahagy_melyik_ho'])){
if($_POST['jovahagy_melyik_ho']!=$GLOBALS['mira']['user_jog']['jovahagy_szur_ho']){
  if(!is_array($tmp_mod))$tmp_mod=array();
 $tmp_mod[0]['jovahagy_szur_ho']=$_POST['jovahagy_melyik_ho'];
 $GLOBALS['mira']['user_jog']['jovahagy_szur_ho']=$_POST['jovahagy_melyik_ho'];
}
}

if(isset($_POST['jovahagy_melyik_user'])){
if($_POST['jovahagy_melyik_user']!=$GLOBALS['mira']['user_jog']['jovahagy_szur_user_ad']){
  if(!is_array($tmp_mod))$tmp_mod=array();
 $tmp_mod[0]['jovahagy_szur_user_ad']=$_POST['jovahagy_melyik_user'];
 $GLOBALS['mira']['user_jog']['jovahagy_szur_user_ad']=$_POST['jovahagy_melyik_user'];
}
}

if(is_array($tmp_mod))
 mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
}

function jovahagy_ful_ki_table(){

if(
(isset($_POST['szerv_id']))and
(isset($_POST['szerv_id_all']))and
(isset($_POST['szerv_nev']))and
(isset($_POST['szerv_nev']))and
(isset($_POST['jovahagy_melyik_ev']))and
(isset($_POST['jovahagy_melyik_ho']))and
(isset($_POST['jovahagy_melyik_user']))and
(
 ($_POST['szerv_id']!="")
 or
 ($_POST['szerv_id_all']!="")
)
){

$szerv_id=$_POST['szerv_id'];
$szerv_all=$_POST['szerv_id_all'];
$ev=$_POST['jovahagy_melyik_ev'];
$ho=$_POST['jovahagy_melyik_ho'];
$user_ad=$_POST['jovahagy_melyik_user'];

//Projekt jóváhagyás-e a szerv_id
if(substr($szerv_id,0,8)=='projekt_'){
 $projekt_jovahagyas=1;
 $projekt_jovahagyas_id=substr($szerv_id,8);
}else{
 $projekt_jovahagyas=0;
 $projekt_jovahagyas_id='';
}

if($projekt_jovahagyas==1){
 $tomb_user=keress_jovahagyhoz_projekt_user($ev,$ho,$szerv_id,$user_ad);
}elseif($szerv_id!="all_f")
 $tomb_user=keress_jovahagyhoz_user($ev,$ho,$szerv_id,$user_ad);
else
 $tomb_user=keress_jovahagyhoz_user_felettes($ev,$ho);

//$tomb_rogiztett=keress_jovahagyhoz_rogzitett($szerv_id,$szerv_all,$ev,$ho,$tomb_user);
$tomb_user_ido=keress_jovahagyhoz_rogzitett($projekt_jovahagyas_id,$szerv_id,$szerv_all,$ev,$ho,$tomb_user);

/*
echo "<pre>";
print_r($tomb_user_ido);
echo "</pre>";
*/

/*echo "<pre>";
print_r($tomb_user_idoproj_elutasitva);
echo "</pre>";*/

//$tomb_user_ido=$tomb_rogiztett;
//echo "alma";exit;
//unset($tomb_rogiztett);
//echo "<pre>";
//print_r($tomb_rogiztett);
//echo "</pre>";

/*echo " Szervezet: ".$_POST['szerv_nev'];
echo " Év: ".$ev;
echo " Hó: ".$ho;*/

echo '<div id="scroll1" style="overflow-x:auto">';
echo '<div></div>';
echo '</div>';
echo '<div id="scroll2" style="overflow-x:auto">';

echo '<table cellpadding="1" cellspacing="1" id="table_jovahagyo" style="margin-top:10px" class="table_emre">';

echo '<thead>';
echo '<tr>';
//echo '<th>AD';
echo '<th>Név';
//echo '<th>Szervezet';
if($projekt_jovahagyas==0){
 echo '<th>PDF';
 
 echo '<th onclick="excel_export_jovahagy_user_tomeges(\''.$ev.'\',\''.$ho.'\')" class="link" title="Tömeges excel exportálás">';
 //c1lass="linkm_tooltip"
 echo '<img style="width:54px;vertical-align:bottom" src="image/excel_e1_k20.png">';
 echo '<br>Excel exportálás';
 
 //echo '<th><img style="width:54px" onclick="excel_export_jovahagy_user_tomeges(\''.$ev.'\',\''.$ho.'\')" class="linkm_tooltip" title="Tömeges excel exportálás" src="image/excel_e1_k20.png">';
 
 echo '<th>Lezárás';
}
echo '<th>Visszaküldés/Jóváhagyás';
echo '<th>Tömeges jóváhagyás';
echo ' <input onclick="jovahagy_tomall()" id="jovahagy_tomall" type="checkbox"> ';

if($projekt_jovahagyas==0){
 echo '<img style="width:22px;margin-left:5px;margin-top:-7px" onclick="jovahagy_proc_ok_tom(\''.$ev.'\',\''.$ho.'\',\''.ho_ki($ho).'\')" title="Tömeges jóváhagyás" src="image\jovahagy2_20.png" class="linkm_tooltip">';
}else{
 echo '<img style="width:22px;margin-left:5px;margin-top:-7px" onclick="jovahagy_proc_ok_tom_projvezeto(\''.$ev.'\',\''.$ho.'\',\''.ho_ki($ho).'\',\''.$projekt_jovahagyas_id.'\',\''.$_POST['szerv_nev'].'\')" title="Tömeges jóváhagyás" src="image\jovahagy2_20.png" class="linkm_tooltip">';
}

$naptimes=mktime('0','0','1',$ho,'1',$ev);
$ho_ut_nap=date('t',$naptimes);
$tomb_munkanap=keres_mit_munkanap($ev,$ho);
$tomb_munkanap_user=keres_mit_munkanap_usertomb($ev,$ho,$tomb_user);

$ho_sor_munkanapszam=0;
for($nap_akt=1;$nap_akt<=$ho_ut_nap;$nap_akt++){
 if(isset($tomb_munkanap_user[$nap_akt]))
  $nap_tipus_egyedi=$tomb_munkanap_user[$nap_akt];
 elseif(isset($tomb_munkanap[$nap_akt]))
  $nap_tipus_egyedi=$tomb_munkanap[$nap_akt];
 else
  $nap_tipus_egyedi="";
 
 $naptime=mktime('0','0','1',$ho,$nap_akt,$ev);
 $het_sorszam=date('w',$naptime);
 //$naptipus=naptipus($ev,$ho,$nap_akt);
  
 if($nap_tipus_egyedi=='PN'){
  $nap_dis="1";
 }elseif($nap_tipus_egyedi=='MN'){
  $nap_dis='0';/*
 }elseif(($het_sorszam!="6")and($het_sorszam!="0")and($naptipus=="PN")){
  $nap_dis="1";
 }elseif((($het_sorszam=="6")or($het_sorszam=="0"))and($naptipus!="MN")){
  $nap_dis="1";*/
 }elseif(($het_sorszam=="6")or($het_sorszam=="0")){
  $nap_dis='1';
 }else{
  $nap_dis='0';	
 }
 if($nap_dis==0){
  echo '<th align=center>';
  
  echo $nap_akt;
  echo '<br>'.napkod($het_sorszam);
 }
}

echo '<th align=center>Összesen';
echo '</tr>';
echo '</thead><tbody>';

if(is_array($tomb_user)){
foreach($tomb_user as $ert){

if((isset($ert['user_ad_felettes']))and($ert['user_ad_felettes']!="")){
 $van_felettes_jovahagyo=1;
}else{
 $van_felettes_jovahagyo=0;
}

echo '<tr align=center id="jovahagysor_'.$ert['user_ad'].'" user_ad="'.$ert['user_ad'].'" ev="'.$ev.'" ho="'.$ho.'" projekt_jovahagyas_id="'.$projekt_jovahagyas_id.'">';
//echo "<td>".$ert['user_ad'];
echo '<td align=left id="jovahagysor_user_nev_'.$ert['user_ad'].'">'.$ert['user_nev'];
//echo "<td>".$ert['szerv_nev'];

if($projekt_jovahagyas==0){
 //PDF
 echo '<td>';
 echo '<img style="width:19px" onclick="pdf_export_jovahagy_user(\''.$ert['user_ad'].'\',\''.$ev.'\',\''.$ho.'\')" class="linkm_tooltip" title="PDF exportálás" src="image/pdf2.png">';

 //Excel
 echo '<td>';
 echo '<img style="width:54px" onclick="excel_export_jovahagy_user(\''.$ert['user_ad'].'\',\''.$ev.'\',\''.$ho.'\')" class="linkm_tooltip" title="Excel exportálás" src="image/excel_e1_k20.png">';

//Lezárás - eleje
echo '<td>';
if(
 (isset($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']))and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']=='1')
){

//Jóváhagyó zárta-e le?
if($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva_jovahagyo']=='1'){
 echo 'Jóváhagyó a lezáró: '.$tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva_jovahagyo_ki_nev'];
 echo ' ';
}
 echo $tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva_mikor'];

}elseif($van_felettes_jovahagyo==0){
 //echo '<span onclick="jovahagy_kezi_lezaras(\''.$ert['user_ad'].'\',\''.$ev.'\',\''.$ho.'\',\''.ho_ki($ho).'\')" class="link">Szervezet jóváhagyói lezárás</span>';
}
//Lezárás - vége
}/*elseif($van_felettes_jovahagyo==1){
 echo "<td><td>";
 if(isset($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva_mikor']))
  echo $tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva_mikor'];
}*/

if(isset($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva_hanyadik']))
 $hanyadik_alkalom=$tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva_hanyadik'];
else 
 $hanyadik_alkalom=1;

//Jóváhagyás - eleje
$lehet_jovahagyni=0;
$projektvezetore_var=0;
$nincs_lezarva=0;

if($van_felettes_jovahagyo==1){

  if(
  (!isset($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']))
  ){//És szakterület jóváhagyta{
	echo "<td colspan=2>";
	echo 'Nincs még lezárva a hónap!';
  }elseif(//Projektvezetők vagy szakterületi vezetők vagyunk,és projektvezető által vissza van küldve a hónap
 (isset($tomb_user_ido[$ert['user_ad']]['projekt_jovahagyo_elutasitva']))and
 ($tomb_user_ido[$ert['user_ad']]['projekt_jovahagyo_elutasitva']==1)
 ){
	echo "<td>";
  	$title='<b>Visszaküldve</b>: ';
	$title.=$tomb_user_ido[$ert['user_ad']]['projekt_elutasitva_nev'].': ';
	$title.=$tomb_user_ido[$ert['user_ad']]['projekt_jovahagyo_elutasitva_mikor'];
	$title.='<br><b>Megjegyzés</b>:<br>';
	$title.=str_replace('\n','<br>',$tomb_user_ido[$ert['user_ad']]['projekt_jovahagyo_elutasitva_megj']);
	echo '<span title="'.$title.'" class="link_pir_vas">Visszaküldve</span>';
	echo "<td>";
 }elseif(
 (isset($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']))and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']=="0")and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_visszakuldve']==1)and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_ok']==0)
){//szakterületi vezető által van vissza van küldve. projekt és szakterület esetén is!
  echo "<td>";
  $title='<b>Visszaküldve</b>: ';
  $title.=$tomb_user_ido[$ert['user_ad']]['ellenorzesre_visszakuldve_ki_nev'].': ';
  $title.=$tomb_user_ido[$ert['user_ad']]['ellenorzesre_visszakuldve_mikor'];
  $title.='<br><b>Megjegyzés</b>:<br>';
  $title.=str_replace('\n','<br>',$tomb_user_ido[$ert['user_ad']]['ellenorzesre_visszakuldve_megj']);
  echo '<span title="'.$title.'" class="link_pir_vas">Visszaküldve</span>';
  echo "<td>";
  }else{
  
  if((isset($tomb_user_ido[$ert['user_ad']]['kell_e_meg_projekt_jovahagyas']))and
  ($tomb_user_ido[$ert['user_ad']]['kell_e_meg_projekt_jovahagyas']==1)
  ){
   echo "<td colspan=2>";
   jovahagy_proc_jovahagy_infok($ev,$ho,$ert['user_ad']);
   echo ' Projekt jóváhagyásra vár!';  
  }elseif(
  (isset($tomb_user_ido[$ert['user_ad']]['ellenorzesre_ok']))and
  ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_ok']==1)
  ){//És szakterület jóváhagyta{
   echo "<td>";
   jovahagy_proc_jovahagy_infok($ev,$ho,$ert['user_ad']);
   echo '<span style="margin-left:35px" class="fek_vas">Jóváhagyva</span>';
   echo "<td>";
  }else{
   echo "<td colspan=2>";
   jovahagy_proc_jovahagy_infok($ev,$ho,$ert['user_ad']);
   echo " Felettes szervezeti jóváhagyásra vár";
  }
  
  }
  
}elseif(
 (isset($tomb_user_ido[$ert['user_ad']]['kell_e_meg_projekt_jovahagyas']))and
 ($tomb_user_ido[$ert['user_ad']]['kell_e_meg_projekt_jovahagyas']==1)and
 (isset($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']))and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']=="1")and
 ($projekt_jovahagyas==1)and//Ekkor projekt jóváhagyás kell, és itt is vagyunk!
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_ok']==0)//És szakterületi nem hagyta jóvá
){//echo ' Projektvezetői jóváhagyás itttttttt!';
 
 echo '<td align=center>';
 jovahagy_proc_jovahagy_infok($ev,$ho,$ert['user_ad']);
 jovahagy_proc_visszakuld_projvezeto($ev,$ho,ho_ki($ho),$ert['user_ad'],$ert['user_nev'],$hanyadik_alkalom,$projekt_jovahagyas_id);
 jovahagy_proc_ok_projvezeto($ev,$ho,ho_ki($ho),$ert['user_ad'],$ert['user_nev'],$tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva_hanyadik'],$projekt_jovahagyas_id);
 if($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva_hanyadik']>1)
  echo '<br>alkalom: '.$tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva_hanyadik'];
 $lehet_jovahagyni=1;
 
}elseif(//Projektvezetők vagyunk, és jóvá lett hagyva már!
 (isset($tomb_user_ido[$ert['user_ad']]['kell_e_meg_projekt_jovahagyas']))and
 ($tomb_user_ido[$ert['user_ad']]['kell_e_meg_projekt_jovahagyas']==0)and
 (isset($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']))and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']=="1")and
 ($projekt_jovahagyas==1)//Ekkor projekt jóváhagyás kell, és itt is vagyunk!
){
 echo '<td align=center>';

 jovahagy_proc_jovahagy_infok($ev,$ho,$ert['user_ad']);

 //Jóváhagyás után, de szakterületi vezetői jóváhagyás előtt még el lehet utasítani.
 if($tomb_user_ido[$ert['user_ad']]['ellenorzesre_ok']==0)
  jovahagy_proc_visszakuld($ev,$ho,ho_ki($ho),$ert['user_ad'],$ert['user_nev'],$hanyadik_alkalom);

  echo '<span style="margin-left:10px" class="fek_vas">Jóváhagyva</span>';
}elseif(//Szaterületi vezető jóváhagyta, utóleg lett projektjóváhagyó és ott vagyunk. Legyen infó gomb itt is
 (isset($tomb_user_ido[$ert['user_ad']]['kell_e_meg_projekt_jovahagyas']))and
 ($tomb_user_ido[$ert['user_ad']]['kell_e_meg_projekt_jovahagyas']==1)and
 (isset($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']))and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']=="1")and
 ($projekt_jovahagyas==1)and//Ekkor projekt jóváhagyás kell, és itt is vagyunk!
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_ok']==1)//És szakterület jóváhagyta
){
  echo '<td align=center>';
  jovahagy_proc_jovahagy_infok($ev,$ho,$ert['user_ad']);
  echo '<span style="margin-left:10px" class="fek_vas">Jóváhagyva</span>';
}elseif(//Projektvezetők vagy szakterületi vezetők vagyunk,és projektvezető által vissza van küldve a hónap
 (isset($tomb_user_ido[$ert['user_ad']]['projekt_jovahagyo_elutasitva']))and
 ($tomb_user_ido[$ert['user_ad']]['projekt_jovahagyo_elutasitva']==1)
){
	echo '<td>';
	$title='<b>Visszaküldve</b>: ';
	$title.=$tomb_user_ido[$ert['user_ad']]['projekt_elutasitva_nev'].': ';
	$title.=$tomb_user_ido[$ert['user_ad']]['projekt_jovahagyo_elutasitva_mikor'];
	$title.='<br><b>Megjegyzés</b>:<br>';
	$title.=str_replace('\n','<br>',$tomb_user_ido[$ert['user_ad']]['projekt_jovahagyo_elutasitva_megj']);
	echo '<span title="'.$title.'" class="link_pir_vas">Visszaküldve</span>';

}elseif(
 (isset($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']))and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']=="0")and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_visszakuldve']==1)and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_ok']==0)
){//szakterületi vezető által van vissza van küldve. projekt és szakterület esetén is!
  echo '<td>';
  $title='<b>Visszaküldve</b>: ';
  $title.=$tomb_user_ido[$ert['user_ad']]['ellenorzesre_visszakuldve_ki_nev'].': ';
  $title.=$tomb_user_ido[$ert['user_ad']]['ellenorzesre_visszakuldve_mikor'];
  $title.='<br><b>Megjegyzés</b>:<br>';
  $title.=str_replace('\n','<br>',$tomb_user_ido[$ert['user_ad']]['ellenorzesre_visszakuldve_megj']);
  echo '<span title="'.$title.'" class="link_pir_vas">Visszaküldve</span>';
}elseif(//Projektvezetők vagyunk, de nincs még lezárva a hónap
 (isset($tomb_user_ido[$ert['user_ad']]['kell_e_meg_projekt_jovahagyas']))and
 ($tomb_user_ido[$ert['user_ad']]['kell_e_meg_projekt_jovahagyas']==1)
 and
 (
  (
   (isset($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']))and
   ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']=="0")
  )
  or
  (
   (isset($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']))
   and($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']=="")
  )
 or
   (!isset($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']))  
 )
 and
 ($projekt_jovahagyas==1)//Ekkor projekt jóváhagyás kell, és itt is vagyunk!
){
 echo '<td colspan=2 align=center>';
 echo 'Nincs még lezárva a hónap!';
 $nincs_lezarva=1;
}elseif(
 (isset($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']))and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']=="1")and
 (isset($tomb_user_ido[$ert['user_ad']]['kell_e_meg_projekt_jovahagyas']))and
 ($tomb_user_ido[$ert['user_ad']]['kell_e_meg_projekt_jovahagyas']==1)and
 ($projekt_jovahagyas==0)and//Ekkor projekt jóváhagyás kell, de szervezetnél vagyunk!
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_ok']==0)//És szakterületi nem hagyta jóvá
){
 echo '<td colspan=2 align=center>';
 jovahagy_proc_jovahagy_infok($ev,$ho,$ert['user_ad']);
 jovahagy_proc_visszakuld($ev,$ho,ho_ki($ho),$ert['user_ad'],$ert['user_nev'],$hanyadik_alkalom);
 echo ' Projekt jóváhagyásra vár!';
 $projektvezetore_var=1;
}elseif(
 (isset($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']))and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']=="1")and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva_hanyadik']==1)and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_visszakuldve']==0)and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_ok']==0)and
 ($projekt_jovahagyas==0)
){//Ekkor lehet mindent
 //echo "Visszaküldés vagy elfogadás (első alkalom)";
 echo '<td>';
 jovahagy_proc_jovahagy_infok($ev,$ho,$ert['user_ad']);
 jovahagy_proc_visszakuld($ev,$ho,ho_ki($ho),$ert['user_ad'],$ert['user_nev'],$hanyadik_alkalom);
 jovahagy_proc_ok($ev,$ho,ho_ki($ho),$ert['user_ad'],$ert['user_nev'],$tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva_hanyadik']);
 $lehet_jovahagyni=1;
}elseif(
 (isset($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']))and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva']=="1")and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_visszakuldve']==0)and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_ok']==0)and
 ($projekt_jovahagyas==0)
){//user visszaküldte!
 //echo "User visszaküldte (Alkalom: ".$tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva_hanyadik']."): vagy visszaküldés vagy elfogadás";
 echo '<td>';
 jovahagy_proc_jovahagy_infok($ev,$ho,$ert['user_ad']);
 jovahagy_proc_visszakuld($ev,$ho,ho_ki($ho),$ert['user_ad'],$ert['user_nev'],$tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva_hanyadik']);
 jovahagy_proc_ok($ev,$ho,ho_ki($ho),$ert['user_ad'],$ert['user_nev'],$tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva_hanyadik']);
 echo '<br>alkalom: '.$tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva_hanyadik'];
 $lehet_jovahagyni=1;

}elseif(
 (isset($tomb_user_ido[$ert['user_ad']]['ellenorzesre_ok']))and
 ($tomb_user_ido[$ert['user_ad']]['ellenorzesre_ok']==1)and
 ($projekt_jovahagyas==0)
){//Ez már ok, de vissza lehet ekkor is küldeni!
  //echo "Ez már ok, de vissza lehet ekkor is küldeni!";
   echo '<td align=center>';
   jovahagy_proc_jovahagy_infok($ev,$ho,$ert['user_ad']);
   jovahagy_proc_visszakuld($ev,$ho,ho_ki($ho),$ert['user_ad'],$ert['user_nev'],$tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva_hanyadik']);
	
   echo '<span style="margin-left:10px" class="fek_vas">Jóváhagyva</span>';
}else{//Ez az ág, amikor nincs még jóváhagyva!
 echo '<td>';
}
//Jóváhagyás - vége

//Tömeges jóváhagyás - eleje
if(
($projektvezetore_var==0)and
($nincs_lezarva==0)and
($van_felettes_jovahagyo==0)
){
echo '<td>';
if($lehet_jovahagyni==1)
 echo '<input user_nev="'.$ert['user_nev'].'" adattom_kuld="'.$ert['user_ad'].'$_$'.$tomb_user_ido[$ert['user_ad']]['ellenorzesre_lezarva_hanyadik'].'" onchange="jovahagy_tomegy(\''.$ert['user_ad'].'\')" id="jovahagy_tom_'.$ert['user_ad'].'" type="checkbox">';
}
//Tömeges jóváhagyás - vége

$user_ho_all_ido=array();
$user_ho_all_ido['rogzit_ora']='0';
$user_ho_all_ido['rogzit_perc']='0';
$ho_sor_munkanapszam=0;
for($nap_akt=1;$nap_akt<=$ho_ut_nap;$nap_akt++){
 if(isset($tomb_munkanap_user[$nap_akt]))
  $nap_tipus_egyedi=$tomb_munkanap_user[$nap_akt];
 elseif(isset($tomb_munkanap[$nap_akt]))
  $nap_tipus_egyedi=$tomb_munkanap[$nap_akt];
 else
  $nap_tipus_egyedi='';
 
 $naptime=mktime('0','0','1',$ho,$nap_akt,$ev);
 $het_sorszam=date('w',$naptime);
 //$naptipus=naptipus($ev,$ho,$nap_akt);
  
 if($nap_tipus_egyedi=='PN'){
  $nap_dis="1";
 }elseif($nap_tipus_egyedi=='MN'){
  $nap_dis='0';/*
 }elseif(($het_sorszam!="6")and($het_sorszam!="0")and($naptipus=="PN")){
  $nap_dis="1";
 }elseif((($het_sorszam=="6")or($het_sorszam=="0"))and($naptipus!="MN")){
  $nap_dis="1";*/
 }elseif(($het_sorszam=='6')or($het_sorszam=='0')){
  $nap_dis='1';
 }else{
  $nap_dis='0';	
 }
 if($nap_dis==0){
  $projekt_title_ki='title="<div id=\'ttip_tjovahagyuser_'.$ert['user_ad'].$nap_akt.'\'></div>"';
  
  echo '<td ttip="" id=\'tjovahagyuser_'.$ert['user_ad'].$nap_akt.'\' class="jovahagyo_ered_td" nap="'.$nap_akt.'" '.$projekt_title_ki.'>';

  if(
  (isset($tomb_user_ido[$ert['user_ad']][$nap_akt]))
  and(
   ($tomb_user_ido[$ert['user_ad']][$nap_akt]['tavollet']==1)
   or($tomb_user_ido[$ert['user_ad']][$nap_akt]['rogzit_ora']!='')
   or($tomb_user_ido[$ert['user_ad']][$nap_akt]['rogzit_perc']!='')
   )
  ){
  if($tomb_user_ido[$ert['user_ad']][$nap_akt]['tavollet']=='1'){
   echo '<span class="pir_vas">Távollét</span>';
  }else{
	  
   $tomb_user_ido_ki=ora_perc_osszead($tomb_user_ido[$ert['user_ad']][$nap_akt]['rogzit_ora'],$tomb_user_ido[$ert['user_ad']][$nap_akt]['rogzit_perc']);
   echo $tomb_user_ido_ki['rogzit_ora'];
   echo ':';
   if($tomb_user_ido_ki['rogzit_perc']<10)$tomb_user_ido_ki['rogzit_perc']='0'.$tomb_user_ido_ki['rogzit_perc'];
   echo $tomb_user_ido_ki['rogzit_perc'];

   $user_ho_all_ido['rogzit_ora']+=$tomb_user_ido_ki['rogzit_ora'];
   $user_ho_all_ido['rogzit_perc']+=$tomb_user_ido_ki['rogzit_perc'];

  }
 }elseif(
  (isset($tomb_user_ido[$ert['user_ad']][$nap_akt]))and
  ($tomb_user_ido[$ert['user_ad']][$nap_akt]['rogzit_ora']=='')and
  ($tomb_user_ido[$ert['user_ad']][$nap_akt]['rogzit_perc']=='')and
  ($projekt_jovahagyas==1)
 ){//Projekt jóváhagyás esetén legyen kint a nulla rögzítés is
	 echo "0:00";
 }
 
 }
}

echo '<td>';
$user_ho_all_ido_ki=ora_perc_osszead($user_ho_all_ido['rogzit_ora'],$user_ho_all_ido['rogzit_perc']);
 echo $user_ho_all_ido_ki['rogzit_ora'];
 echo ':';
if($user_ho_all_ido_ki['rogzit_perc']<10)
 $user_ho_all_ido_ki['rogzit_perc']="0".$user_ho_all_ido_ki['rogzit_perc'];
 echo $user_ho_all_ido_ki['rogzit_perc'];

echo '</tr>';


}
}

echo '</tbody>';
echo '</table>';

echo '</div>';

}else{
 echo 'Hiba';
}
}

function jovahagy_ful_ki_tal(){
echo 'ok$;$';

jovahagy_ful_ki_table_ment();

//Szűrés
//$tomb_jovahagyhato_szerv=keres_aktuser_jovahagyhato_szerv_adat();
//$tomb_felettes_jovahagyhato_user=keres_aktuser_felettes_jovahagyhato_user_adat();
//$tomb_projekt_jovahagyhato_user=keres_aktuser_projekt_jovahagyhato_user_adat();
//jovahagy_ful_ki_szures($tomb_jovahagyhato_szerv,$tomb_felettes_jovahagyhato_user,$tomb_projekt_jovahagyhato_user);

jovahagy_ful_ki_table();
}

function jovahagy_infok_leker(){
echo "ok$;$";
$tomb=keress_jovahagy_infok_leker($_POST['user_ad'],$_POST['ev'],$_POST['ho']);
$szakterületi_jovahagyas_megvolt=0;
if(is_array($tomb)){
 
 echo "<b>Jóváhagyott:</b>";
 echo "<ul style='margin:0px'>";
 foreach($tomb as $i => $ert){
	 if(($i==0)and($ert['user_nev']!="")){
		echo "<li><b>Szervezeti jóváhagyás:</b> ".$ert['user_nev']." ".kidate_format($ert['ellenorzesre_ok_mikor']);
		$szakterületi_jovahagyas_megvolt=1;
	 }elseif($i>0){//projekt jóváhagyások
		
		echo "<li><b>".$ert['projekt_nev'].":</b> ".$ert['user_nev']." ".kidate_format($ert['projekt_jovahagyo_jovahagyva_mikor']);
		$van_adat=1;
	 }
 }
 echo "</ul>";
}else{
 //echo "Nem történt még jóváhagyás!";
}

$tomb_var=keress_jovahagy_infok_leker_var($_POST['user_ad'],$_POST['ev'],$_POST['ho']);

if((is_array($tomb_var))and($szakterületi_jovahagyas_megvolt==0)){

if(is_array($tomb)){
	echo "<br>";
}

 echo "<b>Jóváhagyásra vár:</b>";
 echo "<ul style='margin:0px'>";
 
 if(isset($tomb_var[0])){//Van szakterületi jóváhagyásra váró
	 echo "<li><b>";
	 if(sizeof($tomb_var[0])==1)
	  echo "Szervezeti jóváhagyó: ";
	 else
	  echo "Szervezeti jóváhagyók: ";
     echo "</b>";
	 foreach($tomb_var[0] as $i => $ert){
		if($i>0)echo ", ";
		echo $ert;
	 }
 }
 
  if(isset($tomb_var[1])){//Van felettes szakterületi jóváhagyásra váró
	 echo "<li><b>";
	 if(sizeof($tomb_var[1])==1)
	  echo "Felettes szervezeti jóváhagyó: ";
	 else
	  echo "Felettes szervezeti jóváhagyók: ";
     echo "</b>";
	 foreach($tomb_var[1] as $i => $ert){
		if($i>0)echo ", ";
		echo $ert;
	 }
 }
 
  if(isset($tomb_var[2])){//Van projekt jóváhagyásra váró
   
   foreach($tomb_var[2] as $projekt_nev => $ert){
	  echo "<li><b>".$projekt_nev.":</b> ";
	  foreach($ert as $i => $user_nev){
		  if($i>0)echo ", ";
		  echo $user_nev;
	  }
   }
  }
 
 
}
/*
echo "<pre>";
print_r($tomb_var);
echo "</pre>"*/;
}



function jovahagy_proc_visszakuld($ev,$ho,$ho_str,$user_ad,$user_nev,$alkalom){
 echo "<img class='jovavissza_img' onclick='jovahagy_proc_visszakuld(\"".$user_ad."\",\"".$alkalom."\")' title='Visszaküldés javításra ".$alkalom.". alkalommal' src='image\del_behajtani16.png'>";
}

function jovahagy_proc_visszakuld_projvezeto($ev,$ho,$ho_str,$user_ad,$user_nev,$alkalom,$projekt_jovahagyas_id){
 echo "<img class='jovavissza_img' onclick='jovahagy_proc_visszakuld_projvezeto(\"".$user_ad."\",\"".$alkalom."\",\"".$projekt_jovahagyas_id."\")' title='Visszaküldés javításra ".$alkalom.". alkalommal' src='image\del_behajtani16.png'>";
}

function jovahagy_proc_ok($ev,$ho,$ho_str,$user_ad,$user_nev,$alkalom){
 echo "<img class='jovaok_img' onclick='jovahagy_proc_ok(\"".$user_ad."\",\"".$alkalom."\")' title='Elfogadás' src='image\jovahagy2_20.png'>";
}

function jovahagy_proc_ok_projvezeto($ev,$ho,$ho_str,$user_ad,$user_nev,$alkalom,$projekt_jovahagyas_id){
 echo "<img class='jovaok_img' onclick='jovahagy_proc_ok_projvezeto(\"".$user_ad."\",\"".$alkalom."\",\"".$projekt_jovahagyas_id."\")' title='Elfogadás' src='image\jovahagy2_20.png'>";
}

function jovahagy_proc_visszakuld_projvezeto_kerd_utan(){
if(
(isset($_POST['user_ad']))and
(isset($_POST['megj']))and
(isset($_POST['alkalom']))and
(isset($_POST['ev']))and
(isset($_POST['ho']))and
(isset($_POST['projekt_jovahagyas_id']))and
($_POST['user_ad']!="")and
($_POST['megj']!="")and
($_POST['alkalom']!="")and
($_POST['ev']!="")and
($_POST['ho']!="")and
($_POST['projekt_jovahagyas_id']!="")
){
mysqli_autocommit($GLOBALS['mysqli'],FALSE);
$tmp_mod=array();
$tmp_mod[0]['ellenorzesre_lezarva']=0;
$tmp_mod[0]['ellenorzesre_lezarva_mikor']="0000-00-00 00:00:00";

if($_POST['ho']<10)
 $ho="0".$_POST['ho'];
else
 $ho=$_POST['ho'];
$rogzit_ho=$_POST['ev']."-".$ho;

//Stat-hoz adat lekeresése
$tomb=keres_mit2('rogzit_ho','user_ad',$_POST['user_ad'],"rogzit_ho",$rogzit_ho);

mod_egy_fel_tom2('rogzit_ho',$tmp_mod[0],'user_ad',$_POST['user_ad'],"rogzit_ho",$rogzit_ho);

//rogzit_ho_stat
$tmp_mod_stat=array();
$tmp_mod_stat[0]['ellenorzesre_lezarva']=0;
$tmp_mod_stat[0]['ellenorzesre_lezarva_mikor']="0000-00-00 00:00:00";

  $tmp_mod_stat[0]['user_ad']=$_POST['user_ad'];
  $tmp_mod_stat[0]['rogzit_ho']=$rogzit_ho;
  $tmp_mod_stat[0]['ellenorzesre_lezarva_hanyadik']=$_POST['alkalom'];

if(is_array($tomb)){
$tmp_mod_stat[0]['ellenorzesre_ok']=$tomb[0]['ellenorzesre_ok'];
$tmp_mod_stat[0]['ellenorzesre_ok_ki']=$tomb[0]['ellenorzesre_ok_ki'];
$tmp_mod_stat[0]['ellenorzesre_ok_mikor']=$tomb[0]['ellenorzesre_ok_mikor'];
}
  be_visz_replace("rogzit_ho_stat",$tmp_mod_stat);

//Projektvezetői jóváhagyás - eleje

//Többi már jóváhagyottat is nullázni kell - eleje
  torles2('rogzit_ho_projekt','user_ad',$_POST['user_ad'],"rogzit_ho",$rogzit_ho);
//Többi már jóváhagyottat is nullázni kell - vége

//Ha a projektvezető is jóváhagyta, akkor ezt is ki kell törölni!
 $tmp_mod_proj=array();
  $tmp_mod_proj[0]['user_ad']=$_POST['user_ad'];
  $tmp_mod_proj[0]['rogzit_ho']=$rogzit_ho;
  $tmp_mod_proj[0]['projekt_id']=$_POST['projekt_jovahagyas_id'];
 $tmp_mod_proj[0]['projekt_jovahagyo_jovahagyva']=0;
 $tmp_mod_proj[0]['projekt_jovahagyo_jovahagyva_ki']="";
 $tmp_mod_proj[0]['projekt_jovahagyo_jovahagyva_mikor']="0000-00-00 00:00:00";
 $tmp_mod_proj[0]['projekt_jovahagyo_elutasitva']=1;
 $tmp_mod_proj[0]['projekt_jovahagyo_elutasitva_ki']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
 $tmp_mod_proj[0]['projekt_jovahagyo_elutasitva_mikor']=date("Y-m-d H:i:s",time());
 $tmp_mod_proj[0]['projekt_jovahagyo_elutasitva_megj']=$_POST['megj'];
 be_visz_replace("rogzit_ho_projekt",$tmp_mod_proj);
 
 $tmp_mod_proj[0]['projekt_jovahagyo_jovahagyva_hanyadik']=$_POST['alkalom'];
 be_visz_replace("rogzit_ho_projekt_stat",$tmp_mod_proj);

//Projektvezetői jóváhagyás - vége

//Email küld - eleje
$user_adat=keres_mit1("mira_user","user_ad",$_POST['user_ad']);
if(is_array($user_adat)){
 $cimzes[0]['nev']=$user_adat[0]['user_nev'];
 $cimzes[0]['email']=$user_adat[0]['user_email'];

 //Másolatot kap szakterületi vezető
 //Másolatot kap projekt jóváhagyók 
 $tomb_email_jova_masolat=keres_emailerthez_jovahagyok_visszakuld($_POST['user_ad'],$rogzit_ho);
 
 $cimtargy=$_POST['ev'].". ".ho_ki($_POST['ho'])." visszaküldés";
 $level_html="Kedves ".$user_adat[0]['user_nev']."!";
 $level_html.="<br><br>".$_POST['ev'].". ".ho_ki($_POST['ho'])." tevékenység rögzítésed visszaküldésre került!";
 $level_html.="<br><br><b>Visszaküldő</b>: ".$GLOBALS[$GLOBALS['sessionname']]['login_nev'];
 $level_html.="<br><b>Visszaküldés ideje</b>: ".kidate_format($tmp_mod_proj[0]['projekt_jovahagyo_elutasitva_mikor']);
 $level_html.="<br><b>Visszaküldés megjegyzése</b>: ".$tmp_mod_proj[0]['projekt_jovahagyo_elutasitva_megj'];
 //$level_html.="<br><br>Kérem végezd el a javítást!";
mail_passrec_uj2($cimtargy,$cimzes,$tomb_email_jova_masolat,$level_html,"");
}
//Email küld - vége

mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);

echo "ok$;$";
}else{
	echo "Adathiba";
}
}

function jovahagy_proc_visszakuldheto_e(){
if(
(isset($_POST['visszakuld_ho']))and
($_POST['visszakuld_ho']!="")and
(mb_strlen($_POST['visszakuld_ho'])=="7")
){
 //if(!is_array(keres_mit2("mira_tagv_lezart_honap","tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"tagv_lezart_honap",$_POST['visszakuld_ho']))){
 if(!is_array(keres_mit1("mira_tagv_lezart_honap","tagv_lezart_honap",$_POST['visszakuld_ho']))){
	echo "ok$;$"; 
 }else{
	 echo "<span class='pir_vas'>Hiba! Visszaküldés sikertelen!<br><br>Tevékenység rögzítés nem küldhető vissza, mert ez a hónap már véglegesen zárolásra került!</span>";
 }
}else{
 echo "Adathiány!";
}
}

function jovahagy_proc_visszakuld_kerd_utan(){

if(
(isset($_POST['user_ad']))and
(isset($_POST['megj']))and
(isset($_POST['alkalom']))and
(isset($_POST['ev']))and
(isset($_POST['ho']))and
($_POST['user_ad']!="")and
($_POST['megj']!="")and
($_POST['alkalom']!="")and
($_POST['ev']!="")and
($_POST['ho']!="")
){
mysqli_autocommit($GLOBALS['mysqli'],FALSE);
$tmp_mod=array();
$tmp_mod[0]['ellenorzesre_lezarva']=0;
$tmp_mod[0]['ellenorzesre_lezarva_mikor']="0000-00-00 00:00:00";
$tmp_mod[0]['ellenorzesre_visszakuldve']=1;
$tmp_mod[0]['ellenorzesre_visszakuldve_ki']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
$tmp_mod[0]['ellenorzesre_visszakuldve_mikor']=date("Y-m-d H:i:s",time());
$tmp_mod[0]['ellenorzesre_visszakuldve_megj']=$_POST['megj'];

$tmp_mod[0]['ellenorzesre_lezarva_jovahagyo']=0;
$tmp_mod[0]['ellenorzesre_lezarva_jovahagyo_ki']='0';

$tmp_mod[0]['ellenorzesre_ok']=0;
$tmp_mod[0]['ellenorzesre_ok_ki']="";
$tmp_mod[0]['ellenorzesre_ok_mikor']="0000-00-00 00:00:00";

if($_POST['ho']<10)
 $ho="0".$_POST['ho'];
else
 $ho=$_POST['ho'];
$rogzit_ho=$_POST['ev']."-".$ho;

//Stat-hoz adat lekeresése
$tomb=keres_mit2('rogzit_ho','user_ad',$_POST['user_ad'],"rogzit_ho",$rogzit_ho);

mod_egy_fel_tom2('rogzit_ho',$tmp_mod[0],'user_ad',$_POST['user_ad'],"rogzit_ho",$rogzit_ho);

//rogzit_ho_stat
$tmp_mod_stat=array();
$tmp_mod_stat[0]['ellenorzesre_lezarva']=0;
$tmp_mod_stat[0]['ellenorzesre_lezarva_mikor']="0000-00-00 00:00:00";
$tmp_mod_stat[0]['ellenorzesre_visszakuldve']=1;
$tmp_mod_stat[0]['ellenorzesre_visszakuldve_ki']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
$tmp_mod_stat[0]['ellenorzesre_visszakuldve_mikor']=date("Y-m-d H:i:s",time());
$tmp_mod_stat[0]['ellenorzesre_visszakuldve_megj']=$_POST['megj'];
  $tmp_mod_stat[0]['user_ad']=$_POST['user_ad'];
  $tmp_mod_stat[0]['rogzit_ho']=$rogzit_ho;
  $tmp_mod_stat[0]['ellenorzesre_lezarva_hanyadik']=$_POST['alkalom'];

if(is_array($tomb)){
$tmp_mod_stat[0]['ellenorzesre_ok']=$tomb[0]['ellenorzesre_ok'];
$tmp_mod_stat[0]['ellenorzesre_ok_ki']=$tomb[0]['ellenorzesre_ok_ki'];
$tmp_mod_stat[0]['ellenorzesre_ok_mikor']=$tomb[0]['ellenorzesre_ok_mikor'];
}
  be_visz_replace("rogzit_ho_stat",$tmp_mod_stat);

//Projektvezetői jóváhagyás - eleje
//Ha a projektvezető is jóváhagyta, akkor ezt is ki kell törölni!
//Egész táblát
torles2("rogzit_ho_projekt",'user_ad',$_POST['user_ad'],"rogzit_ho",$rogzit_ho);
//Projektvezetői jóváhagyás - vége

//Email küld - eleje
$user_adat=keres_mit1("mira_user","user_ad",$_POST['user_ad']);
if(is_array($user_adat)){
 $cimzes[0]['nev']=$user_adat[0]['user_nev'];
 $cimzes[0]['email']=$user_adat[0]['user_email'];

 //Másolatot kap szakterületi vezető
 //Másolatot kap projekt jóváhagyók 
 $tomb_email_jova_masolat=keres_emailerthez_jovahagyok_visszakuld($_POST['user_ad'],$rogzit_ho);
 $cimtargy=$_POST['ev'].". ".ho_ki($_POST['ho'])." visszaküldés";
 $level_html="Kedves ".$user_adat[0]['user_nev']."!";
 $level_html.="<br><br>".$_POST['ev'].". ".ho_ki($_POST['ho'])." tevékenység rögzítésed visszaküldésre került!";
 $level_html.="<br><br><b>Visszaküldő</b>: ".$GLOBALS[$GLOBALS['sessionname']]['login_nev'];
 $level_html.="<br><b>Visszaküldés ideje</b>: ".kidate_format($tmp_mod_stat[0]['ellenorzesre_visszakuldve_mikor']);
 $level_html.="<br><b>Visszaküldés megjegyzése</b>: ".$tmp_mod_stat[0]['ellenorzesre_visszakuldve_megj'];
 //$level_html.="<br><br>Kérem végezd el a javítást!";
mail_passrec_uj2($cimtargy,$cimzes,$tomb_email_jova_masolat,$level_html,"");
}
//Email küld - vége

mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);

echo "ok$;$";
}else{
	echo "Adathiba";
}
}

function jovahagy_proc_ok_projvezeto_kerd_utan(){
if(
(isset($_POST['user_ad']))and
(isset($_POST['alkalom']))and
(isset($_POST['projekt_jovahagyas_id']))and
(isset($_POST['ev']))and
(isset($_POST['ho']))and
(isset($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']))and
($_POST['user_ad']!="")and
($_POST['alkalom']!="")and
($_POST['projekt_jovahagyas_id']!="")and
($_POST['ev']!="")and
($_POST['ho']!="")and
($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']=="1")
){
mysqli_autocommit($GLOBALS['mysqli'],FALSE);
$tmp_mod=array();

$tmp_mod[0]['projekt_jovahagyo_jovahagyva']=1;
$tmp_mod[0]['projekt_jovahagyo_jovahagyva_ki']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
$tmp_mod[0]['projekt_jovahagyo_jovahagyva_mikor']=date("Y-m-d H:i:s",time());

if($_POST['ho']<10)
 $ho="0".$_POST['ho'];
else
 $ho=$_POST['ho'];
$rogzit_ho=$_POST['ev']."-".$ho;
//mod_egy_fel_tom2('rogzit_ho_projekt',$tmp_mod[0],'user_ad',$_POST['user_ad'],"rogzit_ho",$rogzit_ho);
$tmp_mod[0]['projekt_id']=$_POST['projekt_jovahagyas_id'];
$tmp_mod[0]['user_ad']=$_POST['user_ad'];
$tmp_mod[0]['rogzit_ho']=$rogzit_ho;
be_visz_replace("rogzit_ho_projekt",$tmp_mod);


$tmp_mod[0]['projekt_jovahagyo_jovahagyva_hanyadik']=$_POST['alkalom'];
be_visz_replace("rogzit_ho_projekt_stat",$tmp_mod);

//Email küldés szakterületi vezetőnek - eleje
if(keres_user_rogzites_vane_tovabbi_projet_jovahagyo($_POST['user_ad'],$rogzit_ho)=="0")
{//Ekkor szakterületi jóváhagyás jön, lehet kell email-t küldeni.

//Szakterületi jóváhagyók megállapítása, csak azok akinek kell email küldés
$tomb_cimzett=keres_emailerthez_jovahagyok_csakszervezet($_POST['user_ad'],$_POST['alkalom']);//user,alkalom
if(is_array($tomb_cimzett))
 email_szak_jovahagyas($tomb_cimzett,$_POST['user_ad'],$_POST['ev'],$_POST['ho'],$_POST['alkalom']);
}
//Email küldés szakterületi vezetőnek - vége

mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);
echo "ok$;$";
}else{
 echo "Adathiba";
}
}

function jovahagy_proc_ok_kerd_utan(){

if(
(isset($_POST['user_ad']))and
(isset($_POST['alkalom']))and
(isset($_POST['ev']))and
(isset($_POST['ho']))and
(isset($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']))and
($_POST['user_ad']!="")and
($_POST['alkalom']!="")and
($_POST['ev']!="")and
($_POST['ho']!="")and
($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']=="1")
){
mysqli_autocommit($GLOBALS['mysqli'],FALSE);
$tmp_mod=array();

$tmp_mod[0]['ellenorzesre_ok']=1;
$tmp_mod[0]['ellenorzesre_ok_ki']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
$tmp_mod[0]['ellenorzesre_ok_mikor']=date("Y-m-d H:i:s",time());

if($_POST['ho']<10)
 $ho="0".$_POST['ho'];
else
 $ho=$_POST['ho'];
$rogzit_ho=$_POST['ev']."-".$ho;
mod_egy_fel_tom2('rogzit_ho',$tmp_mod[0],'user_ad',$_POST['user_ad'],"rogzit_ho",$rogzit_ho);


$tmp_mod[0]['ellenorzesre_lezarva_hanyadik']=$_POST['alkalom'];
$tmp_mod[0]['user_ad']=$_POST['user_ad'];
$tmp_mod[0]['rogzit_ho']=$rogzit_ho;
be_visz_replace("rogzit_ho_stat",$tmp_mod);

mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);
echo "ok$;$";
}else{
 echo "Adathiba";
}
}

function jovahagy_proc_ok_tom_kerd_utan(){

if(
(isset($_POST['tuser_ad']))and
(isset($_POST['ev']))and
(isset($_POST['ho']))and
(isset($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']))and
($_POST['tuser_ad']!="")and
($_POST['ev']!="")and
($_POST['ho']!="")and
($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']=="1")
){
mysqli_autocommit($GLOBALS['mysqli'],FALSE);
if($_POST['ho']<10)
 $ho="0".$_POST['ho'];
else
 $ho=$_POST['ho'];
$rogzit_ho=$_POST['ev']."-".$ho;

$tomb_user=explode("-",$_POST['tuser_ad']);

foreach($tomb_user as $tuser_ad){
 $tuser_ad_egy=explode('$_$',$tuser_ad);

 $tmp_mod=array();

$tmp_mod[0]['ellenorzesre_ok']=1;
$tmp_mod[0]['ellenorzesre_ok_ki']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
$tmp_mod[0]['ellenorzesre_ok_mikor']=date("Y-m-d H:i:s",time());

 mod_egy_fel_tom2('rogzit_ho',$tmp_mod[0],'user_ad',$tuser_ad_egy[0],"rogzit_ho",$rogzit_ho);

 $tmp_mod[0]['ellenorzesre_lezarva_hanyadik']=$tuser_ad_egy[1];
 $tmp_mod[0]['user_ad']=$tuser_ad_egy[0];
 $tmp_mod[0]['rogzit_ho']=$rogzit_ho;
 be_visz_replace("rogzit_ho_stat",$tmp_mod);

mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);

echo "ok$;$";
}
	
}else{
 echo "Adathiba";
}
}

function jovahagy_proc_ok_tom_projvezeto_kerd_utan(){
if(
(isset($_POST['tuser_ad']))and
(isset($_POST['ev']))and
(isset($_POST['ho']))and
(isset($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']))and
(isset($_POST['projekt_jovahagyas_id']))and
($_POST['tuser_ad']!="")and
($_POST['ev']!="")and
($_POST['ho']!="")and
($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']=="1")and
($_POST['projekt_jovahagyas_id']!="")
){

mysqli_autocommit($GLOBALS['mysqli'],FALSE);

if($_POST['ho']<10)
 $ho="0".$_POST['ho'];
else
 $ho=$_POST['ho'];
$rogzit_ho=$_POST['ev']."-".$ho;

$tomb_user=explode("-",$_POST['tuser_ad']);

foreach($tomb_user as $tuser_ad){
 $tuser_ad_egy=explode('$_$',$tuser_ad);
 
 $tmp_mod=array();

$tmp_mod[0]['projekt_jovahagyo_jovahagyva']=1;
$tmp_mod[0]['projekt_jovahagyo_jovahagyva_ki']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
$tmp_mod[0]['projekt_jovahagyo_jovahagyva_mikor']=date("Y-m-d H:i:s",time());
$tmp_mod[0]['projekt_id']=$_POST['projekt_jovahagyas_id'];
$tmp_mod[0]['user_ad']=$tuser_ad_egy[0];
$tmp_mod[0]['rogzit_ho']=$rogzit_ho;
be_visz_replace("rogzit_ho_projekt",$tmp_mod);

$tmp_mod[0]['projekt_jovahagyo_jovahagyva_hanyadik']=$tuser_ad_egy[1];
be_visz_replace("rogzit_ho_projekt_stat",$tmp_mod);

//Email küldés szakterületi vezetőnek - eleje
if(keres_user_rogzites_vane_tovabbi_projet_jovahagyo($tuser_ad_egy[0],$rogzit_ho)=="0")
{//Ekkor szakterületi jóváhagyás jön, lehet kell email-t küldeni.

//Szakterületi jóváhagyók megállapítása, csak azok akinek kell email küldés
$tomb_cimzett=keres_emailerthez_jovahagyok_csakszervezet($tuser_ad_egy[0],$tuser_ad_egy[1]);//user,alkalom
if(is_array($tomb_cimzett))
 email_szak_jovahagyas($tomb_cimzett,$tuser_ad_egy[0],$_POST['ev'],$_POST['ho'],$tuser_ad_egy[1]);
}
//Email küldés szakterületi vezetőnek - vége

}

mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);
echo "ok$;$";
	
}else{
 echo "Adathiba";
}
}

function jovahagyuser_sor_mouse(){
if(
 (isset($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']))and
 ($GLOBALS[$GLOBALS['sessionname']]['jog']['ful_jovahagy']=="1")
){
echo "ok$;$";

$ev=$_POST['ev'];
$ho=$_POST['ho'];
$nap_akt=$_POST['nap'];
$user_ad=$_POST['user_ad'];
$user_nev=$_POST['user_nev'];
$projekt_jovahagyas_id=$_POST['projekt_jovahagyas_id'];

 $naptime=mktime("0","0","1",$ho,$nap_akt,$ev);
 $het_sorszam=date('w',$naptime);

$tomb_user_ido=keress_jovahagyhoz_rogzitett_egy($_POST['ev'],$_POST['ho'],$_POST['nap'],$user_ad,$projekt_jovahagyas_id);
/*echo "<pre>";
print_r($tomb_user_ido);
echo "</pre>";*/
  //Tooltip napra - eleje
  //$projekt_nev="";
  $projekt_title="";
  if(
  ( isset($tomb_user_ido[$user_ad][$nap_akt]['projekt_nev']))
    and
   ($tomb_user_ido[$user_ad][$nap_akt]['tavollet']=="0")
  ){
  $projekt_title.="<table border=0 style=\"margin-top:5px\" class=\"table_emre\">";
  foreach($tomb_user_ido[$user_ad][$nap_akt]['projekt_nev'] as $is => $ert_projekt_nev){
  if($tomb_user_ido[$user_ad][$nap_akt]['projekt_nev_ora'][$is]!=""){
	//if($projekt_nev!="")$projekt_nev.="<br>";
	$projekt_title.="<tr>";
	$projekt_title.="<td>";
	$projekt_title.=$ert_projekt_nev;
	
	//$projekt_nev.=" ";
	$projekt_title.="<td>";
	
	$projekt_title.=$tomb_user_ido[$user_ad][$nap_akt]['projekt_nev_ora'][$is];
	
	if($tomb_user_ido[$user_ad][$nap_akt]['projekt_nev_perc'][$is]<10)
	 $tomb_user_ido[$user_ad][$nap_akt]['projekt_nev_perc'][$is]="0".$tomb_user_ido[$user_ad][$nap_akt]['projekt_nev_perc'][$is];
	$projekt_title.=":".$tomb_user_ido[$user_ad][$nap_akt]['projekt_nev_perc'][$is];
	
	$projekt_title.="</tr>";
   }
  }
  $projekt_title.="</table>";  
  }elseif(
  (isset($tomb_user_ido[$user_ad][$nap_akt]['tavollet']))and
  ($tomb_user_ido[$user_ad][$nap_akt]['tavollet']=="1")
  ){
	  $projekt_title.="<div style=\"margin-top:5px\" class='pir_vas'>Távollét</div>";
  }
  
  
  
    //Megjegyzés alulra ha van - eleje
  if(
  (isset(($tomb_user_ido[$user_ad][$nap_akt]['rogzit_megj'])))and
  ($tomb_user_ido[$user_ad][$nap_akt]['rogzit_megj']!="")
  ){
	 $projekt_title.="<div style=\"margin-top:5px\"><b>Megjegyzés</b>:<br>";
	 $projekt_title.=str_replace("\n"," ",$tomb_user_ido[$user_ad][$nap_akt]['rogzit_megj']);
	 $projekt_title.="</div>";
  }
  //Megjegyzés alulra ha van - vége
  
  $projekt_title_ki="<b>".$user_nev." ".$nap_akt.". ".napkod($het_sorszam)."</b><br>".$projekt_title;
  
  echo $projekt_title_ki;
  //Tooltip napra - vége
}else{//Ekkor nincs jóváhagyó joga
 exit;
}
}
?>