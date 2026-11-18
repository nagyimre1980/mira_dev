<?php
session_start();

include_once("../config_uj.php"); 
include_once("../function.php");
include_once("../function_mysql.php");
login();

ini_set('memory_limit','1768M');
ini_set("pcre.jit","0");

if(
 (isset($_POST['admin_tenypotlas_tenybetoltomintaopen']))
){
require_once "../simplexlsx/xlsx_simplegen.php";

$i=0;
$adat=array();
$adat[$i][]='<b>'."Tagv".'</b>';
$adat[$i][]='<b>'."Szolgkod".'</b>';
$adat[$i][]='<b>'."Év".'</b>';
$adat[$i][]='<b>'."Hó".'</b>';
$adat[$i][]='<b>'."Érték".'</b>';

 $i=1;
 $adat[$i][]='ATMX';
 $adat[$i][]='SLMI';
 $adat[$i][]='2024';
 $adat[$i][]='1';
 $adat[$i][]='135.10';
 
 $i=2;
 $adat[$i][]='ATMX';
 $adat[$i][]='SLMI';
 $adat[$i][]='2024';
 $adat[$i][]='2';
 $adat[$i][]='235.20'; 

 $i=3;
 $adat[$i][]='ATMX';
 $adat[$i][]='SLIR';
 $adat[$i][]='2024';
 $adat[$i][]='1';
 $adat[$i][]='135.11'; 
 
 $filename='Ténybetöltő minta.xlsx';
 $xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Ténybetöltő minta');
 unset($adat);
 $xlsx->downloadAs(rawurlencode($filename));
}
?>