<?php
session_start();

include_once("../config_uj.php"); 
include_once("../function.php");
include_once("../function_mysql.php");
login();

ini_set('memory_limit','1768M');
ini_set("pcre.jit","0");

if(
 (isset($_POST['admin_tenypotlastig_tenybetoltomintaopen']))
){
require_once "../simplexlsx/xlsx_simplegen.php";

$i=0;
$adat=array();
$adat[$i][]='<b>'."Szolgáltatás ID".'</b>';
$adat[$i][]='<b>'."Év".'</b>';
$adat[$i][]='<b>'."Hó".'</b>';
$adat[$i][]='<b>'."Egyéb naturália".'</b>';

 $i=1;
 $adat[$i][]='1';
 $adat[$i][]='2024';
 $adat[$i][]='1';
 $adat[$i][]='135';

 $filename='Ténybetöltő TIG minta.xlsx';
 $xlsx = Shuchkin\SimpleXLSXGen::fromArray($adat,'Ténybetöltő TIG minta');
 unset($adat);
 $xlsx->downloadAs(rawurlencode($filename));
}
?>