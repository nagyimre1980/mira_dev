<?php
session_start();

include_once("../config_uj.php"); 
include_once("../function.php");
include_once("../function_mysql.php");
login();

ini_set('memory_limit','1768M');
ini_set("pcre.jit","0");

if(
 (isset($_POST['admin_tervezes_tervbetoltomintaexport']))and
 ($_POST['admin_tervezes_tervbetoltomintaexport']!='')
){
require_once "../simplexlsx/xlsx_simplegen.php";

$tomb=keres_mit_tervezes($_POST['admin_tervezes_tervbetoltomintaexport']);

/*
echo '<pre>';
print_r($tomb);
echo '</pre>';
*/

$i=0;
$adat=array();
$adat[$i][]='<b>'."Terv típus".'</b>';
$adat[$i][]='<b>'."Terv típus név".'</b>';
$adat[$i][]='<b>'."Terv típus megjegyzes".'</b>';
$adat[$i][]='<b>'."Év".'</b>';
$adat[$i][]='<b>'."Hó".'</b>';
$adat[$i][]='<b>'."Tagv".'</b>';
$adat[$i][]='<b>'."Szolgkod".'</b>';
$adat[$i][]='<b>'."Érték".'</b>';

if(is_array($tomb)){
 foreach($tomb as $ert){
  $i++;
  $adat[$i][]=$ert['backup_terv_fo_tipus'];
  $adat[$i][]=$ert['backup_terv_tipus_nev'];
  $adat[$i][]=$ert['backup_terv_tipus_megj'];
  $adat[$i][]=$ert['backup_terv_ev'];
  $adat[$i][]=$ert['backup_terv_ho'];
  $adat[$i][]=$ert['backup_terv_tagv_kod'];
  $adat[$i][]=$ert['backup_terv_szolg_kod'];
  $adat[$i][]=$ert['backup_terv_osszeg'];
 }
 
}

$date=date("Y_m_d-H_i_s",time());
$filename='Tervezés tábla '.$_POST['admin_tervezes_tervbetoltomintaexport'].' export '.$date.'.xlsx';
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Tervezés tábla export');
unset($adat);
$xlsx->downloadAs(rawurlencode($filename));

}

function keres_mit_tervezes($backup_terv_tipus_id){
 $eredmeny_keres="";
 $backup_terv_tipus_id=mysqli_real_escape_string($GLOBALS['mysqli'],$backup_terv_tipus_id);
 $sql="SELECT 
 backup_terv_fo_tipus_nev.backup_terv_fo_tipus,
 backup_terv_tipus.backup_terv_tipus_nev,
 backup_terv_tipus.backup_terv_tipus_megj,
 backup_terv.backup_terv_ev,
 backup_terv.backup_terv_ho,
 backup_terv.backup_terv_tagv_kod,
 backup_terv.backup_terv_szolg_kod,
 backup_terv.backup_terv_osszeg
 FROM `backup_terv` 
 left join backup_terv_tipus ON backup_terv_tipus.backup_terv_tipus_id = backup_terv.backup_terv_tipus_id
 left join backup_terv_fo_tipus_nev ON backup_terv_fo_tipus_nev.backup_terv_fo_tipus_id = backup_terv_tipus.backup_terv_fo_tipus_id 
 where 
 backup_terv.backup_terv_tipus_id='".$backup_terv_tipus_id."'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}
?>