<?php
//session_start();
if(!isset($_SESSION))
 session_start(['read_and_close' => true]);
include_once("config_uj.php");

//header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
///////////header("Cache-Control: no-cache ");
//header("Cache-Control: post-check=0, pre-check=0", false);
///////////header("Pragma: no-cache");

if(
(!isset($_SESSION[$GLOBALS['sessionname']]['login_ad']))
){
 exit;
}

if(
(isset($_POST['mod']))
and($_POST['mod']!="")
){
switch($_POST['mod']){
 case'user_projekt':
  search_user_projekt();
 break;
}
}

function search_user_projekt(){
if((!isset($_POST['nap']))or((isset($_POST['nap']))and($_POST['nap']==""))){
	echo 'Hiba';
	exit;
}

//1 Keressük le azokat a projekteket, amire a usernek nincs rögzítve semmi arra a napra
//$tomb=keres_projekt_ki();
echo json_encode(keres_projekt_ki());

}

function keres_projekt_ki(){
$eredmeny_keres="";
//V1.063 kivettem, jóideje már full lista jön le
///////$_POST['q']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['q']);

if((isset($_SESSION[$GLOBALS['sessionname']]['ev_ki']))and($_SESSION[$GLOBALS['sessionname']]['ev_ki']!=''))
 $ev=$_SESSION[$GLOBALS['sessionname']]['ev_ki'];
else $ev='';

if((isset($_SESSION[$GLOBALS['sessionname']]['ho_ki']))and($_SESSION[$GLOBALS['sessionname']]['ho_ki']!='')){
 $ho=$_SESSION[$GLOBALS['sessionname']]['ho_ki'];
 if($ho<10)$ho_ki='0'.$ho;
 else $ho_ki=$ho;
}else{
 $ho_ki='';
}

if((isset($_POST['nap']))and($_POST['nap']!='')){
 $nap=$_POST['nap'];
 if($nap<10)$nap_ki='0'.$nap;
 else $nap_ki=$nap;
}else{
 $nap_ki='';
}
	
if(($ev!='')and($ho_ki!='')and($nap_ki!='')){
 $date_szur=$ev.'-'.$ho_ki.'-'.$nap_ki;
 $sql_nap="
  ( (projekt.projekt_kezd_date is null) or (projekt.projekt_kezd_date<='".$date_szur."') )
  and
  ( (projekt.projekt_veg_date is null) or (projekt.projekt_veg_date>='".$date_szur."') )
  and ";
}else{
 $sql_nap='';
}

if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
else
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']; 

//$_POST['q']=urldecode(str_replace("*","%",$_POST['q']));
//$_POST['q']=str_replace("*","%",urldecode($_POST['q']));

//if($_POST['q']!=""){
 //$where_search=' projekt.projekt_nev like "'.$_POST['q'].'%" and ';
 //2024.01.30 csonkolt keresés a default. Nincs jelentőse mert ez nincs
 //////////$where_search=' projekt.projekt_nev like "%'.$_POST['q'].'%" and ';
//}else{
 /////$where_search='';
//}

//projekt.projekt_tagv="'.$_SESSION[$GLOBALS['sessionname']]['tagv'].'" and 
$sql='SELECT projekt.projekt_id,projekt.projekt_nev,projekt.projekt_title
FROM `projekt`
left join projekt_szerv on projekt_szerv.projekt_id = projekt.projekt_id 
  and projekt_szerv.szerv_id="'.$_SESSION[$GLOBALS['sessionname']]['szerv_id'].'"
left join projekt_user on projekt_user.projekt_id = projekt.projekt_id 
 and projekt_user.user_ad="'.$user_ad.'"
WHERE 
'.$sql_nap.'

projekt.projekt_inaktiv="0"
and
(
 (projekt_szerv.projekt_id is not null)
 or
 (projekt_user.user_ad is not null)
)

order by projekt.projekt_nev asc';// LIMIT 250
//group by projekt.projekt_id 
//LIMIT 100';
//echo $sql;exit;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 $i=0;
 
 $tomb_korabbi1=explode("-",$_POST['korabbi_sel_proj']);
 $tomb_korabbi2=array();
 foreach($tomb_korabbi1 as $tomb_korabbi_proj_id){
	$tomb_korabbi2[$tomb_korabbi_proj_id]="1";
 }
 
 /*if(
 (isset($_POST['sel']))and($_POST['sel']!="")
 and
 (
 (!isset($_POST['q']))
 or(
 (isset($_POST['q']))
 and($_POST['q']=="")
 )
 )
 ){*/
  //if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres=array();
  $eredmeny_keres[0]['id']='keremv';
  $eredmeny_keres[0]['text']='Kérem válassz';
  $eredmeny_keres[0]['sorsz']=0;
  $i++;
 //}

 while($adatom=mysqli_fetch_assoc($adat)){
 if(
 (!isset($tomb_korabbi2[$adatom['projekt_id']]))
 ){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
   
  $eredmeny_keres[$i]['id']=$adatom['projekt_id'];
  $eredmeny_keres[$i]['text']=$adatom['projekt_nev'];
  
  if($adatom['projekt_title']==""){
   $eredmeny_keres[$i]['title']="";
  }else{
   $adatom['projekt_title']=str_replace("\r\n","<br>",$adatom['projekt_title']);
   //$adatom['projekt_title']=str_replace(array("\r\n", "\r", "\n"), "<br>",$adatom['projekt_title']);
   //$adatom['projekt_title']=nl2br(stripcslashes($adatom['projekt_title']));
   //$adatom['projekt_title']=nl2br($adatom['projekt_title']);
   $eredmeny_keres[$i]['title']='<b>'.$adatom["projekt_nev"].'</b><br>'.$adatom["projekt_title"];
  }
  $eredmeny_keres[$i]['sorsz']=$i;
 $i++;
 }
 }
 //mysqli_close($GLOBALS['mysqli']);
 return $eredmeny_keres;
}

?>