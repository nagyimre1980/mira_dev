<?php
session_start();

include_once("../config_uj.php"); 
include_once("../function.php");
include_once("../function_mysql.php");
login();

ini_set('memory_limit','1768M');
ini_set("pcre.jit","0");
require_once "../simplexlsx/xlsx_simple.php";
use Shuchkin\SimpleXLSX;

tenypotlas_betolt();

function tenypotlas_betolt(){
$tomb=xlsx_read($_FILES['datafile']['tmp_name']);

if(
 (isset($tomb['fejlec']))and
 (isset($tomb['adat']))and
 (isset($tomb['fejlec'][0]))and
 (isset($tomb['fejlec'][1]))and
 (isset($tomb['fejlec'][2]))and
 (isset($tomb['fejlec'][3]))and
 (isset($tomb['fejlec'][4]))and
 ($tomb['fejlec'][0]=='Tagv')and
 ($tomb['fejlec'][1]=='Szolgkod')and
 ($tomb['fejlec'][2]=='Év')and
 ($tomb['fejlec'][3]=='Hó')and
 ($tomb['fejlec'][4]=='Érték')
){//Ekkor ok az excel

 $hiba_kiahgyva=0;
 $oksor=0;
 foreach($tomb['adat'] as $ert){
  if(
  (isset($ert[0]))and
  (isset($ert[1]))and
  (isset($ert[2]))and
  (isset($ert[3]))and
  (isset($ert[4]))and
  ($ert[0]!='')and
  ($ert[1]!='')and
  ($ert[2]!='')and
  ($ert[3]!='')and
  ($ert[4]!='')
  ){//Ekkor van minden adat
	$oksor++;
	if(!isset($tmp_adat_ver))$tmp_adat_ver=array();
	$tmp_adat_ver[$oksor]['backup_tenypotlas_tagv']=$ert[0];
	$tmp_adat_ver[$oksor]['backup_tenypotlas_szolg_kod']=$ert[1];
	$tmp_adat_ver[$oksor]['backup_tenypotlas_ev']=$ert[2];
	$tmp_adat_ver[$oksor]['backup_tenypotlas_ho']=$ert[3];
	$tmp_adat_ver[$oksor]['backup_tenypotlas_osszeg']=$ert[4];
  }else{
		 $hiba_kiahgyva++;
  }
 }

 if($oksor>0){
  be_visz_replace("backup_tenypotlas",$tmp_adat_ver);
 }

 if($hiba_kiahgyva>0)
  return_vissza(1,$hiba_kiahgyva." sor kihagyva!<br>Beszúrt sok száma: ".$oksor);
 else
  return_vissza(0,"<br><br>Beszúrt sorok száma: ".$oksor);

}else{
 return_vissza(1,"Hibás az excel felépítése!");
}
}

function return_vissza($result,$hiba){
echo '<!DOCTYPE HTML>';
echo '<script language="javascript" type="text/javascript">';
if($result==0){//ok
  echo 'window.top.window.stopok_Upload_tenypotlas_file(\''.$hiba.'\');';
}else{
  echo 'window.top.window.stop_Upload_tenypotlas_file("'.$result.'","'.$hiba.'");';
}
echo '</script>';
}

function xlsx_read($file){
$adat=array();
if ( $xlsx = SimpleXLSX::parse($file)) {
$xlsx->setDateTimeFormat('Ymd');
//echo $xlsx->getCell(0,"D4");
$oszlopok=array();
//$sorokszam_max=0;
	$fejlec=$header_values = $rows = [];

	
	foreach ( $xlsx->rows() as $sorszam => $r ) {
	
	if ( $sorszam === 0 ) {
	 //$header_values = $r;

	 foreach($r as $olszlopszam => $value){
	  //$fej_str=func_trim_kisbetu($value);
	  $fej_str=trim($value);

	  //$fejlec[$fej_str]=$olszlopszam;
	  $fejlec[$olszlopszam]=$fej_str;
	  //$fejlec_orig[$value]=$olszlopszam;
	  //$header_values[]=$fej_str;
	  $header_values[]=$olszlopszam;
	 }
	 
	 continue;	 
	}else{
		//print_r($r);
		//$rows[] = array_combine( $header_values, $r );
		$rows[] = array_combine( $header_values,array_map('trim',$r));
	}
	
	}

}

$adat=array();
if(isset($fejlec)){
 $adat['fejlec']=$fejlec;
 //$adat['fejlec_orig']=$fejlec_orig;
}
if(isset($rows)){
 $adat['adat']=$rows;
}
return $adat;
}

?>