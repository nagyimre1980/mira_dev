<?php

function admin_szerz_szerzusergazda(){
echo 'ok$;$';
admin_szerz_szerzusergazda_urlap();
admin_szerz_szerzusergazda_kereses();
echo '<div id="admin_uj_szerzusergazda_list_keres_tal" style="overflow-x:auto">';
admin_szerzusergazda_user_list();
echo '</div>';
}

function admin_szerz_szerzusergazda_urlap(){
echo '<div class="div_kereshez">';
echo '<b>Új szerződésgazda:</b>';

echo '<table class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>AD azonosító *';
echo '<td>';
echo '<input onkeydown="ad_leker_usergazda_enter(event)" id="admin_ujszerzusergazda_ad" type=text maxlength=17 style="width:150px">';
echo ' <span onclick="ad_leker()" class="link">AD adatok lekérése (Klikk vagy enter)</span>';
echo '</tr>';

echo '<tr>';
echo '<td>Név *';
echo '<td>';
echo '<input id="admin_ujszerzusergazda_nev" type=text style="width:280px" maxlength="255">';
echo " <img class='ad_info_img' title='<div id=\"ad_info_div\"></div>' onmouseover='ad_info_leker(\"admin_ujszerzusergazda_ad\")' onmouseout='ad_info_leker_kuka(\"admin_ujuser_ad\")' id='admin_ujuser_ad_info' src='image/info_18.png'>";
echo '</tr>';

echo '<tr>';
echo '<td>Email *';
echo '<td>';
echo '<input id="admin_ujszerzusergazda_email" type=text style="width:280px" maxlength="255">';
echo '</tr>';

echo '<tr>';
echo '<td>Törzsszám';
echo '<td>';
echo '<input id="admin_ujszerzusergazda_tsz" type=text style="width:100px" maxlength="20">';
echo '</tr>';

echo '<tr><td colspan=2 align=left><input id="admin_ujszerzusergazda_submit" onclick="admin_ujszerzusergazda()" value="Új szerződésgazda felvitele" class="submit2" type=submit></tr>';
echo '</tbody>';
echo '</table>';
echo '</div>';
}

function admin_szerzusergazdalist_keres(){
if(isset($_POST['nev']))$_SESSION[$GLOBALS['sessionname']]['admin_szerzusergazdalist_keres']['nev']=$_POST['nev'];
if(isset($_POST['ad']))$_SESSION[$GLOBALS['sessionname']]['admin_szerzusergazdalist_keres']['ad']=$_POST['ad'];
echo "ok$;$";
admin_szerzusergazda_user_list();
}

function admin_szerz_szerzusergazda_kereses(){
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzusergazdalist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzusergazdalist_keres']['nev']!=""))
 $ker_nev=$_SESSION[$GLOBALS['sessionname']]['admin_szerzusergazdalist_keres']['nev'];
else $ker_nev="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzusergazdalist_keres']['ad']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzusergazdalist_keres']['ad']!=""))
 $ker_ad=$_SESSION[$GLOBALS['sessionname']]['admin_szerzusergazdalist_keres']['ad'];
else $ker_ad="";

echo '<div class="div_kereshez"><b>Keresés</b> (Név keresés automatikusan *valami*-al történik)';
echo '<table id="admin_szerzusergazdalist_table" class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>Név';
echo '<td>';
echo '<input onkeyup="admin_szerzusergazdalist_keres(\'tallep_elso\',\'\')" id="admin_szerzusergazdalist_keres_nev" maxlength="255" style="width:300px" type="text">';

echo '<td>AD';
echo '<td>';
echo '<input onkeyup="admin_szerzusergazdalist_keres(\'tallep_elso\',\'\')" id="admin_szerzusergazdalist_keres_ad" maxlength="17" style="width:150px" type="text">';

echo '</tr>';
echo '</tbody>';
echo '</table></div>';
}


function admin_szerzusergazda_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_szerzusergazda_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Meglévő adatok módosítása</b>';
echo '<table id="admin_szerzusergazdalist_table" class="table_emre_kek">';
echo '<thead><tr>';

$order_mezo="szerz_usergazda.szerz_usergazda_nev";
echo "<th style='width:40px' class='link' onclick='admin_szerzusergazdalist_keres_proc(\"order\",\"".$order_mezo."\")'>Név ";
echo tabl_nyilak('admin_szerzusergazdalist_keres_order','admin_szerzusergazdalist_keres_order_mod',$order_mezo);

$order_mezo="szerz_usergazda.szerz_usergazda_ad";
echo "<th style='width:40px' class='link' onclick='admin_szerzusergazdalist_keres_proc(\"order\",\"".$order_mezo."\")'>AD ";
echo tabl_nyilak('admin_szerzusergazdalist_keres_order','admin_szerzusergazdalist_keres_order_mod',$order_mezo);

$order_mezo="szerz_usergazda.szerz_usergazda_email";
echo "<th style='width:40px' class='link' onclick='admin_szerzusergazdalist_keres_proc(\"order\",\"".$order_mezo."\")'>Email ";
echo tabl_nyilak('admin_szerzusergazdalist_keres_order','admin_szerzusergazdalist_keres_order_mod',$order_mezo);

$order_mezo="szerz_usergazda.szerz_usergazda_tsz";
echo "<th style='width:40px' class='link' onclick='admin_szerzusergazdalist_keres_proc(\"order\",\"".$order_mezo."\")'>Törzsszám ";
echo tabl_nyilak('admin_szerzusergazdalist_keres_order','admin_szerzusergazdalist_keres_order_mod',$order_mezo);

echo '<th>Inaktív';

echo '</tr></thead><tbody>';

admin_szerzusergazda_user_list_tal($tomb);

echo '</tbody></table>';
echo '</div>';
table_alja_lepeget('0',$th,'admin_szerzusergazda','admin_szerzusergazdalist_keres_talszam','admin_szerzusergazdalist_keres');

}

function admin_szerzusergazda_user_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){
 echo '<tr>';
 
 if($ert['szerz_usergazda_inaktiv']==1)$dis=' disabled';
 else $dis='';
 //Név
 echo '<td>';
 echo '<input'.$dis.' onkeyup="admin_modszerzusergazda_ment(\''.$ert['szerz_usergazda_ad'].'\')" id="admin_modszerzusergazda_nev_'.$ert['szerz_usergazda_ad'].'" value="'.$ert['szerz_usergazda_nev'].'" maxlength="255" style="width:300px" type="text">';
 
 //AD
 echo '<td>';
 echo "<input value='".$ert['szerz_usergazda_ad']."' id='admin_ujmod_szerzusergazda_rejtett_".$ert['szerz_usergazda_ad']."' type='hidden'>";
 echo $ert['szerz_usergazda_ad'];
   echo " <img style='width:16px;' class='ad_info_img' title='<div id=\"ad_info_div\"></div>' onmouseover='ad_info_leker(\"admin_ujmod_szerzusergazda_rejtett_".$ert['szerz_usergazda_ad']."\")' onmouseout='ad_info_leker_kuka(\"admin_ujmod_szerzusergazda_rejtett_".$ert['szerz_usergazda_ad']."\")' id='admin_ujmod_szerzusergazda_rejtett_".$ert['szerz_usergazda_ad']."_info' src='image/info_18.png'>";

 //Email
 echo '<td>';
 echo '<input'.$dis.' onkeyup="admin_modszerzusergazda_ment(\''.$ert['szerz_usergazda_ad'].'\')" id="admin_modszerzusergazda_email_'.$ert['szerz_usergazda_ad'].'" value="'.$ert['szerz_usergazda_email'].'" maxlength="255" style="width:300px" type="text">';
 
 //Törzsszám
 echo '<td>';
 echo '<input'.$dis.' onkeyup="admin_modszerzusergazda_ment(\''.$ert['szerz_usergazda_ad'].'\')" id="admin_modszerzusergazda_tsz_'.$ert['szerz_usergazda_ad'].'" value="'.$ert['szerz_usergazda_tsz'].'" maxlength="255" style="width:150px" type="text">';

 //Inaktív
 echo '<td>';
 if($ert['szerz_usergazda_inaktiv']==1)$ck_inaktiv=' checked';
 else $ck_inaktiv='';
 echo '<input'.$ck_inaktiv.' class="link" title="'.$ert['szerz_usergazda_nev'].'" onchange="admin_modszerzusergazda_inaktiv(\''.$ert['szerz_usergazda_ad'].'\')" id="admin_modszerzusergazda_inaktiv_ck_'.$ert["szerz_usergazda_ad"].'" type="checkbox">';

 echo '</tr>';
}
}
}	
}

function admin_ujszerzusergazda_ment(){
if((!isset($_POST['nev']))or(
(isset($_POST['nev'])and
($_POST['nev']==""))
)){
 echo "nook$;$"."Név kitöltése kötelező!";
 exit;
}

if((!isset($_POST['ad']))or(
(isset($_POST['ad'])and
($_POST['ad']==""))
)){
 echo "nook$;$"."AD kitöltése kötelező!";
 exit;
}

if((!isset($_POST['email']))or(
(isset($_POST['email'])and
($_POST['email']==""))
)){
 echo "nook$;$"."Email kitöltése kötelező!";
 exit;
}

//2: Van-e Ilyen Elszámolás típusa
$szerz_usergazda_ad=keres_mit1_mit1('szerz_usergazda','szerz_usergazda_ad',$_POST['ad'],'szerz_usergazda_ad');
if(is_array($szerz_usergazda_ad)){
 echo 'nook$;$Hiba! Van már ilyen elszámolás típus név!';
 exit;
}else{
 $tmp_bk=array();
 $tmp_bk[0]['szerz_usergazda_ad']=strtolower($_POST['ad']);
 $tmp_bk[0]['szerz_usergazda_nev']=$_POST['nev'];
 $tmp_bk[0]['szerz_usergazda_email']=$_POST['email'];
 if($_POST['tsz']!='')
  $tmp_bk[0]['szerz_usergazda_tsz']=$_POST['tsz'];
 be_visz_insert('szerz_usergazda',$tmp_bk);

 echo "ok$;$";
}

}

function admin_modszerzusergazda_ment(){
if(
 (isset($_POST['ad']))and
 (isset($_POST['nev']))and
 (isset($_POST['email']))and
 (isset($_POST['tsz']))and
 ($_POST['ad']!='')
){
 $tmp_mod[0]['szerz_usergazda_nev']=$_POST['nev'];
 
 if($_POST['email']!='')
  $tmp_mod[0]['szerz_usergazda_email']=$_POST['email'];
 else $tmp_mod[0]['szerz_usergazda_email']=null;
	 
 if($_POST['tsz']!='')
  $tmp_mod[0]['szerz_usergazda_tsz']=$_POST['tsz'];
 else $tmp_mod[0]['szerz_usergazda_tsz']=null;
 mod_egy_fel_tom('szerz_usergazda',$tmp_mod[0],'szerz_usergazda_ad',$_POST['ad']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_modszerzusergazda_inaktiv(){
if(
 (isset($_POST['ad']))and
 (isset($_POST['usergazda_inaktiv']))and
 ($_POST['ad']!='')and
 (
  ($_POST['usergazda_inaktiv']==0)or
  ($_POST['usergazda_inaktiv']==1)
 )
){
	$tmp_mod=array();
	$tmp_mod[0]['szerz_usergazda_inaktiv']=$_POST['usergazda_inaktiv'];
	mod_egy_fel_tom('szerz_usergazda',$tmp_mod[0],'szerz_usergazda_ad',$_POST['ad']);
	echo 'ok$;$';
}else{
 echo 'adathiány';
}
}
?>