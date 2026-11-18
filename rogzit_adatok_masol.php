<?php

function rogzit_adatok_masol(){
echo 'ok$;$';

echo $_POST['ev'].'. '.ho_ki($_POST['ho']);
echo ' nap másolása';
echo '$;$';


if($_POST['ho']<10)$ho_ki='0'.$_POST['ho'];
else $ho_ki=$_POST['ho'];

//Nézzük meg, hogy ez a hónap le van-e zárva.
if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 $lezarvae=keres_mit2_mit1_csak_ertek('rogzit_ho','user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad'],'rogzit_ho',$_POST['ev'].'-'.$ho_ki,'ellenorzesre_lezarva');
else
 $lezarvae=keres_mit2_mit1_csak_ertek('rogzit_ho','user_ad',$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'],'rogzit_ho',$_POST['ev'].'-'.$ho_ki,'ellenorzesre_lezarva');

if($lezarvae=='1'){
 echo 'Másolás nem lehetséges, mert a hónap már lezárásra került!';
 exit;
}

/*
echo $_POST['ev'].'. '.ho_ki($_POST['ho']);
echo ' nap másolása<br>';
*/

echo '<b>Figyelem</b>:<ul style="margin:0px"><li>Másolni csak olyan napokra van lehetőség, amire nincs még semmilyen rögzítés, vagy tevékenység kiválasztva!';
echo '<br>Megjegyzés rögzítése is kizáró tényező!';
echo '<li>Másoláskor csak azok a tevékenységek kerülnek másolásra, amire jelenleg is rendelkezel jogosultsággal!';
echo '</ul>';

//Nézzük meg, hogy melyik napra van rögzítés.
if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 $tomb_rogzit_e=keres_rogzit_adatok_masol_nap_rogzit_e($_SESSION[$GLOBALS['sessionname']]['login_ad'],$_POST['ev'].'-'.$ho_ki);
else
 $tomb_rogzit_e=keres_rogzit_adatok_masol_nap_rogzit_e($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'],$_POST['ev'].'-'.$ho_ki);

$tomb_munkanap=keres_mit_munkanap($_POST['ev'],$_POST['ho']);

if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 $tomb_munkanap_user=keres_mit_munkanap_user($_POST['ev'],$_POST['ho'],$_SESSION[$GLOBALS['sessionname']]['login_ad']);
else
 $tomb_munkanap_user=keres_mit_munkanap_user($_POST['ev'],$_POST['ho'],$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']);

echo "<div align=center>";
echo "<table cellpadding='0' cellspacing='0' class='table_emre_bejovo masol'>";

/*
echo 'akt év:'.$_POST['ev'].'-';
echo '<br>akt hó'.$_POST['ho'].'-';
echo '<br>Vége ev:'.$GLOBALS['mira']['rogzit_ev_veg_ev'].'-';
echo '<br>Vége ho:'.$GLOBALS['mira']['rogzit_ev_veg_ho'].'-';
echo '<br>Vége nap :'.$GLOBALS['mira']['rogzit_ev_veg_nap'].'-';
*/

if(
(isset($GLOBALS['mira']['rogzit_ev_veg_ev']))and
(isset($GLOBALS['mira']['rogzit_ev_veg_ho']))and
($_POST['ho']==$GLOBALS['mira']['rogzit_ev_veg_ho'])and
(isset($GLOBALS['mira']['rogzit_ev_veg_nap']))and($GLOBALS['mira']['rogzit_ev_veg_nap']!='')
){
 $last_nap=$GLOBALS['mira']['rogzit_ev_veg_nap'];
}else{
 $last_nap=date("t", strtotime($_POST['ev'].'-'.$ho_ki));
}

echo '<thead>';
echo '<tr>';
echo '<th>Év';
echo '<th>hónap';
echo '<th colspan=2>Nap';
echo '<th>Másolás';

echo '<th>Beillesztés';
echo '<input onclick="rogzit_adatok_masol_beilleszt_ckall()" id="beillesztckall" type="checkbox" style="vertical-align:bottom">';

echo '</tr>';
echo '</thead>';
echo '<tbody>';
for($nap=1;$nap<=$last_nap;$nap++){

if($nap<10)$nap_akt='0'.$nap;
else $nap_akt=$nap;

$date_akt=$_POST['ev'].'-'.$ho_ki.'-'.$nap_akt;

$naptime=mktime("0","0","1",$_POST['ho'],$nap,$_POST['ev']);
$het_sorszam=date('w',$naptime);

 if(isset($tomb_munkanap_user[$nap]))
  $nap_tipus_egyedi=$tomb_munkanap_user[$nap];
 elseif(isset($tomb_munkanap[$nap]))
  $nap_tipus_egyedi=$tomb_munkanap[$nap];
 else
  $nap_tipus_egyedi="";
if($nap_tipus_egyedi=="PN"){
 $nap_dis="1";
}elseif($nap_tipus_egyedi=="MN"){
 $nap_dis="0";/*
}elseif(($het_sorszam!="6")and($het_sorszam!="0")and($naptipus=="PN")){
 $nap_dis="1";
}elseif((($het_sorszam=="6")or($het_sorszam=="0"))and($naptipus!="MN")){
 $nap_dis="1";*/
}elseif(($het_sorszam=="6")or($het_sorszam=="0")){
 $nap_dis="1";
}else{
 $nap_dis="0";	
}
if($nap_dis=='0'){



echo '<tr>';

echo '<td>';
echo $_POST['ev'];
echo '<td>';
echo ho_ki($_POST['ho']);

echo '<td>';
echo $nap;
echo '<td>';
echo napkod($het_sorszam);

//Másolás
echo '<td align=center>';
if(isset($tomb_rogzit_e[$date_akt])){
 //echo 'Másolunk';
 echo '<input id="masolasradio_'.$nap.'" name="masolas" type="radio" style="cursor:pointer">';
}

//Beillesztés
echo '<td align=center>';
if(!isset($tomb_rogzit_e[$date_akt])){
 //echo 'Beillesztés';
 echo '<input onclick="rogzit_adatok_masol_beilleszt_ckegy()" id="beillesztck_'.$nap.'" type="checkbox">';
}

echo '</tr>';
}
}
echo '</tbody>';
echo '</table>';
echo "</div>";
}

function keres_rogzit_adatok_masol_nap_rogzit_e($user_ad,$rogzit_ho){
 $eredmeny_keres="";
 $rogzit_ho=mysqli_real_escape_string($GLOBALS['mysqli'],$rogzit_ho);
 $sql="SELECT rogzit.rogzit_nap 
 
 FROM `rogzit` 
 where 
 `user_ad`='$user_ad' and 
 `rogzit_ho`='$rogzit_ho'
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['rogzit_nap']]='1';
 }
 return $eredmeny_keres;
}

function rogzit_adatok_masol_proc_ment_proc(){
echo 'ok$;$';

/*
echo '<pre>';
print_r($_POST);
echo '</pre>';
*/

$tomb_napra=explode(";",$_POST['beilleszt_nap']);
$tomb=keress_rogzitett_rogzit_adatok_masol($_POST['ev'],$_POST['ho'],$_POST['masol_nap']);
$tomb_sor=keress_rogzitett_rogzit_adatok_masol_sor($tomb['0']['rogzit_id']);

/*
echo '<pre>';
print_r($tomb_sor);
echo '</pre>';
exit;
*/

include_once("ajax_func.php");
include_once("rogzit_table.php");
include_once("search.php");


$_POST['q']='';
$_POST['korabbi_sel_proj']='';

foreach($tomb_napra as $napra){
 if($napra!=''){
 
	$_POST['nap']=$napra;
	$tomb_proj_van=keres_projekt_ki();
	$tomb_proj='';
	if(is_array($tomb_proj_van)){
	foreach($tomb_proj_van as $ert){
	 if(!is_array($tomb_proj))$tomb_proj=array();
	 $tomb_proj[$ert['id']]='1';
	}
	}
 
 foreach($tomb_sor as $ert){

//Vizsgálni, hogy van-e joga erre a tevékenységre.
 if(isset($tomb_proj[$ert['projekt_id']])){
  $_POST['nap']=$napra;

  $_POST['projekt_id']=$ert['projekt_id'];
  $_POST['sorsz']=$ert['sorsz'];
  $_POST['ido']=$ert['rogzit_ora'].':'.$ert['rogzit_perc'];
  $_POST['projekt_id_last']='keremv';
  rogzit_ment('');
  
  $_POST['megj']=''.$tomb['0']['rogzit_megj'];
  rogzit_megj_ment();

 $_POST['nap_akt']=$napra;
 $_POST['rogzit_sor_megj']=''.$ert['rogzit_sor_megj'];
 raford_projekt_meg_katt_dialog_mentes(); 
  
 }
 
 }
 }
}
//

}

function keress_rogzitett_rogzit_adatok_masol_sor($rogzit_id){
$eredmeny_keres="";
$rogzit_id=mysqli_real_escape_string($GLOBALS['mysqli'],$rogzit_id);

$sql="SELECT 
rogzit_sor.projekt_id,
rogzit_sor.rogzit_ora,
rogzit_sor.rogzit_perc,
rogzit_sor.sorsz,
rogzit_sor.rogzit_sor_megj
FROM `rogzit_sor`
where 
rogzit_sor.rogzit_id = '".$rogzit_id."' ";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;

}

function keress_rogzitett_rogzit_adatok_masol($ev,$ho,$nap){
$eredmeny_keres="";
$ev=mysqli_real_escape_string($GLOBALS['mysqli'],$ev);
$ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);
$nap=mysqli_real_escape_string($GLOBALS['mysqli'],$nap);

if($ho<10)$ho_akt="0".$ho;
else $ho_akt=$ho;

if($nap<10)$nap_akt="0".$nap;
else $nap_akt=$nap;

$rogzit_nap=$ev."-".$ho_akt."-".$nap_akt;

if(
(isset($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']))and
($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']!="")
)
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'];
else
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['login_ad'];

$sql="SELECT 
rogzit.rogzit_id,
rogzit.rogzit_megj
FROM `rogzit`
where 
rogzit.user_ad = '".$user_ad."' and 
rogzit.rogzit_nap='".$rogzit_nap."'";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}	
?>