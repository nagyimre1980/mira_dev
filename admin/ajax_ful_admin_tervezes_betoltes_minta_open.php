<?php
session_start();

include_once("../config_uj.php"); 
include_once("../function.php");
include_once("../function_mysql.php");
login();

ini_set('memory_limit','1768M');
ini_set("pcre.jit","0");

if(
 (isset($_POST['admin_tervezes_tervbetoltomintaopen']))
){
require_once "../simplexlsx/xlsx_simplegen.php";

$i=0;
$adat=array();
$adat[$i][]='<b>'."Év".'</b>';
$adat[$i][]='<b>'."Hó".'</b>';
$adat[$i][]='<b>'."Tagv".'</b>';
$adat[$i][]='<b>'."Szolgkod".'</b>';
$adat[$i][]='<b>'."Érték".'</b>';

 $i=1;
 $adat[$i][]='2024';
 $adat[$i][]='1';
 $adat[$i][]='ATMX';
 $adat[$i][]='SLKP';
 $adat[$i][]='35.00';
 
 $i=2;
 $adat[$i][]='2024';
 $adat[$i][]='1';
 $adat[$i][]='BSZK';
 $adat[$i][]='SLBE';
 $adat[$i][]='96.00';
 
 $i=3;
 $adat[$i][]='2024';
 $adat[$i][]='2';
 $adat[$i][]='ATMX';
 $adat[$i][]='SLKP';
 $adat[$i][]='36.00';

$filename='Tervezés tábla betöltő minta.xlsx';
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Tervezés tábla betöltő minta');
unset($adat);
$xlsx->downloadAs(rawurlencode($filename));
}
?>