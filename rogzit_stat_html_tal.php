<?php
//echo "ok$;$";

function stat_leker_ment(){
$tmp_mod='';

//Kezdeti érték lekezelése.

if($_POST['idoszak_ev']!=$GLOBALS['mira']['user_jog']['stat_leker_ev']){
 if(!is_array($tmp_mod))$tmp_mod=array();
 $tmp_mod[0]['stat_leker_ev']=$_POST['idoszak_ev'];
 $GLOBALS['mira']['user_jog']['stat_leker_ev']=$_POST['idoszak_ev'];
}

if($_POST['idoszak_ho']!=$GLOBALS['mira']['user_jog']['stat_leker_ho']){
 if(!is_array($tmp_mod))$tmp_mod=array();
 $tmp_mod[0]['stat_leker_ho']=$_POST['idoszak_ho'];
 $GLOBALS['mira']['user_jog']['stat_leker_ho']=$_POST['idoszak_ho'];
}

if($_POST['idoszak_nap']!=$GLOBALS['mira']['user_jog']['stat_leker_nap']){
 if(!is_array($tmp_mod))$tmp_mod=array();
 $tmp_mod[0]['stat_leker_nap']=$_POST['idoszak_nap'];
 $GLOBALS['mira']['user_jog']['stat_leker_nap']=$_POST['idoszak_nap'];
}

if($_POST['szerv_id']!=$GLOBALS['mira']['user_jog']['stat_leker_szerv_id']){
 if(!is_array($tmp_mod))$tmp_mod=array();
 $tmp_mod[0]['stat_leker_szerv_id']=$_POST['szerv_id'];
 $GLOBALS['mira']['user_jog']['stat_leker_szerv_id']=$_POST['szerv_id'];
}

if($_POST['projekt_id']!=$GLOBALS['mira']['user_jog']['stat_leker_projekt_id']){
 if(!is_array($tmp_mod))$tmp_mod=array();
 $tmp_mod[0]['stat_leker_projekt_id']=$_POST['projekt_id'];
 $GLOBALS['mira']['user_jog']['stat_leker_projekt_id']=$_POST['projekt_id'];
}

if($_POST['kiuser']!=$GLOBALS['mira']['user_jog']['stat_leker_kiuser']){
 if(!is_array($tmp_mod))$tmp_mod=array();
 $tmp_mod[0]['stat_leker_kiuser']=$_POST['kiuser'];
 $GLOBALS['mira']['user_jog']['stat_leker_kiuser']=$_POST['kiuser'];
}

if($_POST['user']!=$GLOBALS['mira']['user_jog']['stat_leker_user']){
 if(!is_array($tmp_mod))$tmp_mod=array();
 $tmp_mod[0]['stat_leker_user']=$_POST['user'];
 $GLOBALS['mira']['user_jog']['stat_leker_user']=$_POST['user'];
}

if($_POST['idoszak_tipus']!=$GLOBALS['mira']['user_jog']['stat_leker_tipus']){
 if(!is_array($tmp_mod))$tmp_mod=array();
 $tmp_mod[0]['stat_leker_tipus']=$_POST['idoszak_tipus'];
 $GLOBALS['mira']['user_jog']['stat_leker_tipus']=$_POST['idoszak_tipus'];
}

if(is_array($tmp_mod))
 mod_egy_fel_tom('mira_user_ker_jog',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
}

function stat_leker(){
/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/
ini_set('memory_limit','3768M');
stat_leker_ment();

if(
(isset($_POST['idoszak_tipus']))and
($_POST['idoszak_tipus']!="reszletes")and
($_POST['idoszak_tipus']!="reszletes2")
){

$ev=$_POST['idoszak_ev'];
$ho=$_POST['idoszak_ho'];
$tipus=$_POST['idoszak_tipus'];

//stat_leker_lapteteje();

switch($tipus){
case'user_napi':
 include_once("rogzit_stat_html_tal_user_napi.php");
 html_tal_user_napi($ev,$ho);
break;
case'napi_user':
 include_once("rogzit_stat_html_tal_napi_user.php");
 html_tal_napi_user($ev,$ho);
break;
case'projekt_napi':
 include_once("rogzit_stat_html_tal_projekt_napi.php");
 html_tal_projekt_napi($ev,$ho);
break;
case'projekt_szerv':
 include_once("rogzit_stat_html_tal_projekt_szerv.php");
 html_tal_projekt_szerv($ev,$ho);
break;

case'szervezet_napi':
 include_once("rogzit_stat_html_tal_szerv_napi.php");
 html_tal_szervezet_napi($ev,$ho);
break;
case'szerv_projekt':
 include_once("rogzit_stat_html_tal_szerv_projekt.php");
 html_tal_szerv_projekt($ev,$ho);
break;

case'reszletes':case'reszletes2':
 //Itt ilyen nincs!
break;
default:
 echo "Típushiba";
 exit;
break;

}

}

}


function stat_leker_lapteteje(){
echo '<span style="font-weight: bold">';
echo 'Keresés: ';

//Felhasználók köre
switch($_POST['idoszak_tipus']){
 case'csak_rogzitett':
  echo 'Csak adott hónapra rögzített felhasználók';
 break;
}

echo '</span>';
}

/*
function stat_leker_lapalja($th){
elozo_kovetkezo_gombok("stat_leker",$th,$GLOBALS['mira']['user_jog']['stat_leker_talszam'],$_POST['oldalholvagyok']);

//Találatok száma - eleje
talalatok_szama($GLOBALS['mira']['user_jog']['stat_leker_talszam'],"stat_leker","select_stat_leker_talszam");
//Találatok száma - vége

if(isset($_POST['oldalholvagyok'])){
 $oldalholvagyok=$_POST['oldalholvagyok'];
}else{
 $oldalholvagyok=0;//Hányadik találatnál kell kezdeni a Selectet 0,15
}

echo "<input type='hidden' value='".$oldalholvagyok."' id='stat_leker_tal_oldalholvagyok'>";

if($th>0){
 $oldal_max=ceil($th/$GLOBALS['mira']['user_jog']['stat_leker_talszam']);//Oldalszám kitalálása 
 echo "<input type='hidden' value='".$oldal_max."' id='stat_leker_tal_oldalmax'>";
 $oldalszam=(floor($oldalholvagyok/$GLOBALS['mira']['user_jog']['stat_leker_talszam']))+1;
 echo "Találatok száma: ".$th." db";
 if($th>0){
  echo ", ".$oldalszam."/ ".$oldal_max.". oldal";
  if($oldalszam>$oldal_max){
  echo "<script>stat_leker('tallep_elso','');</script>";
  }
 }
//excel_export("admin_szervlist_keres",$th);
}

}
*/
?>