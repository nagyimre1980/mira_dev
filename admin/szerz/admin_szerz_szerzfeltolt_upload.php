<?php
session_start();

include_once("../../config_uj.php"); 
include_once("../../function.php");
include_once("../../function_mysql.php");
login();
error_reporting(E_ALL);
ini_set('display_errors',"on");
ini_set('memory_limit','1768M');

/*
echo '<pre>';
print_r($_POST);
print_r($_FILES);
echo '</pre>';
exit;
*/

$max_meret_mb=50;

if(!isset($_FILES['datafile']['size'])){
 $result=2;//Fájl nagy
 return_vissza($result,'',$max_meret_mb);
 exit;
}
$meret_mb=$_FILES['datafile']['size']/1048576;
//Méret ellenörzése - vége



if($meret_mb>$max_meret_mb){
 $result=2;//Fájl nagy
 return_vissza($result,'',$_FILES['datafile']['size']);
 exit;
}

//Van-e ilyen rekord $_POST['szerz_id'] és $_POST['szerz_tetel_modszam_kezi'] alapján
$szerz_file_id=keres_mit2_mit1_csak_ertek('szerz_file','szerz_id',$_POST['szerz_id'],'szerz_tetel_modszam_kezi',$_POST['szerz_tetel_modszam_kezi'],'szerz_file_id');

//Bevitel, ha nincs ilyen! Ha van, akkor módosítani kell
$tmp=array();
$time=time();


$tmp[0]['szerz_id']=$_POST['szerz_id'];
$tmp[0]['szerz_tetel_modszam_kezi']=$_POST['szerz_tetel_modszam_kezi'];

if($_POST['szerzfeltoltes_tipus']=='szerz'){
 $tmp[0]['szerz_file_szerz_vane']='1';
 $tmp[0]['szerz_file_szerz_name']=$_FILES['datafile']['name'];
 $tomb_file_name=explode(".",$_FILES['datafile']['name']);
 $kit=$tmp[0]['szerz_file_szerz_kit']=mb_strtolower(end($tomb_file_name));
 $tmp[0]['szerz_file_szerz_feltolt_ki']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
 $tmp[0]['szerz_file_szerz_feltolt_mikor']=date("Y-m-d H:i:s",$time);
 $utv=$GLOBALS['szerz_szerz'];
}else{

 $tmp[0]['szerz_file_ar_vane']='1';
 $tmp[0]['szerz_file_ar_name']=$_FILES['datafile']['name'];
 $tomb_file_name=explode(".",$_FILES['datafile']['name']);
 $kit=$tmp[0]['szerz_file_ar_kit']=mb_strtolower(end($tomb_file_name));
 $tmp[0]['szerz_file_ar_feltolt_ki']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
 $tmp[0]['szerz_file_ar_feltolt_mikor']=date("Y-m-d H:i:s",$time);
 $utv=$GLOBALS['szerz_ar'];
}

if($szerz_file_id!=''){//Módosítás
 mod_egy_fel_tom('szerz_file',$tmp[0],'szerz_file_id',$szerz_file_id);
}else{//Bevitel
 be_visz_replace('szerz_file',$tmp);
 $szerz_file_id=mysqli_insert_id($GLOBALS['mysqli']);
}
$file_hova=$utv.$szerz_file_id.'.'.$kit;

if(move_uploaded_file($_FILES['datafile']['tmp_name'],$file_hova)){
  $result=0;//ok
}else{
 $result=1;//ok
}
return_vissza($result,$szerz_file_id,'');


function return_vissza($result,$szerz_file_id,$meret_mb){
echo '<!DOCTYPE HTML>';
echo '<script language="javascript" type="text/javascript">';

if($_POST['szerzfeltoltes_tipus']=='szerz'){

 if($result==0){//ok
  echo 'window.top.window.stopok_Upload_szerzfeltoltes_file(\''.$szerz_file_id.'\',\''.$_FILES['datafile']['name'].'\',\''.$_POST['szerz_id'].'\',\''.$_POST['szerz_tetel_modszam_kezi'].'\');';
 }else{
  if (!is_numeric($meret_mb)) {
    $meret_mb = 0;
  }
  echo 'window.top.window.stop_Upload_szerzfeltoltes_file("'.$result.'","'.round($meret_mb,2).'",\''.$_POST['szerz_id'].'\',\''.$_POST['szerz_tetel_modszam_kezi'].'\');';
 }

}else{
 if($result==0){//ok
  echo 'window.top.window.stopok_Upload_szerzfeltoltes_ar_file(\''.$szerz_file_id.'\',\''.$_FILES['datafile']['name'].'\',\''.$_POST['szerz_id'].'\',\''.$_POST['szerz_tetel_modszam_kezi'].'\');';
 }else{
  echo 'window.top.window.stop_Upload_szerzfeltoltes_ar_file("'.$result.'","'.round($meret_mb,2).'",\''.$_POST['szerz_id'].'\',\''.$_POST['szerz_tetel_modszam_kezi'].'\');';
 }
}

echo '</script>';
}
?>