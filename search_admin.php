<?php
//session_start();
session_start(['read_and_close' => true]);
include_once("config_uj.php");

//header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: no-cache ");
//header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if(
(!isset($_SESSION[$GLOBALS['sessionname']]['login_ad']))
){
 exit;
}

if(
(!isset($_SESSION[$GLOBALS['sessionname']]['jog']['ful_admin']))
or
($_SESSION[$GLOBALS['sessionname']]['jog']['ful_admin']=='0')
){
 exit;
}


if(
(isset($_POST['mod']))
and($_POST['mod']!="")
){
	
switch($_POST['mod']){

 case'admin_munkanapuser_uj_user':
  admin_munkanapuser_uj_user();
 break;

}

}

function admin_munkanapuser_uj_user(){


//1 Keressük le azokat a projekteket, amire a usernek nincs rögzítve semmi arra a napra
$tomb=keres_user_ki();
echo json_encode($tomb);

}

function keres_user_ki(){
$eredmeny_keres="";
$_POST['q']=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['q']);

$_POST['q']=str_replace("*","%",urldecode($_POST['q']));

if($_POST['q']!=""){
 $where_search=" and (mira_user.user_nev like '".$_POST['q']."%' ";
 $where_search.=" or mira_user.user_ad like '".$_POST['q']."%' ";
 $where_search.=" or mira_user.user_tsz like '".$_POST['q']."%' )";
}else{
 $where_search="";
}

//and mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' 
$sql="SELECT 
mira_user.user_ad,
mira_user.user_nev,
mira_user.user_tsz

FROM `mira_user`
where
mira_user.user_inaktiv='0' and mira_user.ful_rogzit='1' 
".$where_search."
order by mira_user.user_nev
limit 100";
//echo $sql;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 $i=0;
 
 if(
 (isset($_POST['sel']))and($_POST['sel']!="")
 and
 (
 (!isset($_POST['q']))
 or(
 (isset($_POST['q']))
 and($_POST['q']=="")
 )
 )
 ){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[0]['id']="keremv";
  $eredmeny_keres[0]['text']="Kérem válassz";
  $i++;
 }
 
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$i]['id']=$adatom['user_ad'];
  //$eredmeny_keres[$i]['text']=$adatom['user_nev']." <i>(".$adatom['user_tsz'].", ".$adatom['user_ad'].")</i>";
  $eredmeny_keres[$i]['text']=$adatom['user_nev']." (".$adatom['user_tsz'].", ".$adatom['user_ad'].")";
  //$eredmeny_keres[$i]['title']="<b>Azonosító:</b> ".$adatom['user_ad'];
  //$eredmeny_keres[$i]['title'].="<br><b>Név:</b> ".$adatom['user_nev'];
 $i++;
 }
 return $eredmeny_keres;
}

?>