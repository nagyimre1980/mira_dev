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

if(
 (isset($_POST['backup_terv_tipus_id']))and
 ($_POST['backup_terv_tipus_id']!='')
){
 terv_terv_betolt();
}else{
 //hiba
}

function terv_terv_betolt(){
$tomb=xlsx_read($_FILES['datafile']['tmp_name']);

if(
 (isset($tomb['fejlec']))and
 (isset($tomb['adat']))and
 (isset($tomb['fejlec'][0]))and
 (isset($tomb['fejlec'][1]))and
 (isset($tomb['fejlec'][2]))and
 (isset($tomb['fejlec'][3]))and
 (isset($tomb['fejlec'][4]))and
 ($tomb['fejlec'][0]=='Év')and
 ($tomb['fejlec'][1]=='Hó')and
 ($tomb['fejlec'][2]=='Tagv')and
 ($tomb['fejlec'][3]=='Szolgkod')and
 ($tomb['fejlec'][4]=='Érték')
){

 $tomb_tervtipus=keres_mit1('backup_terv_tipus','backup_terv_tipus_id',$_POST['backup_terv_tipus_id']);
 if(!is_array($tomb_tervtipus)){
  return_vissza(1,"backup_terv_tipus tömb nem található!");
  exit;  
 }

//törüljük ami van, lehet nincs ám!! :)
torles('backup_terv','backup_terv_tipus_id',$_POST['backup_terv_tipus_id']);

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
	 ($ert[0]==$tomb_tervtipus[0]['backup_terv_tipus_ev'])and
	 ($ert[1]!='')and
	 ($ert[2]!='')and
	 ($ert[3]!='')and
	 ($ert[4]!='')
	 ){//Ekkor van minden adat
			
			$oksor++;
			if(!isset($tmp_adat_ver))$tmp_adat_ver=array();
			$tmp_adat_ver[$oksor]['backup_terv_tipus_id']=$_POST['backup_terv_tipus_id'];
			$tmp_adat_ver[$oksor]['backup_terv_ev']=$tomb_tervtipus[0]['backup_terv_tipus_ev'];
			$tmp_adat_ver[$oksor]['backup_terv_ho']=$ert[1];
			$tmp_adat_ver[$oksor]['backup_terv_tervkod']=$ert[2].$ert[3];
			$tmp_adat_ver[$oksor]['backup_terv_tagv_kod']=$ert[2];
			$tmp_adat_ver[$oksor]['backup_terv_szolg_kod']=$ert[3];
			$tmp_adat_ver[$oksor]['backup_terv_osszeg']=$ert[4];
			
			
	 }else{
		 $hiba_kiahgyva++;
	 }	
 }
 
 if($oksor>0){
  be_visz_replace("backup_terv",$tmp_adat_ver);
 }
 
 if($hiba_kiahgyva>0)
  return_vissza(1,$hiba_kiahgyva." sor kihagyva!<br>Beszúrt sok száma: ".$oksor);
 else
  return_vissza(0,"<br><br>Beszúrt sok száma: ".$oksor);
 
}else{
 return_vissza(1,"Hibás az excel felépítése!");
}

}

function return_vissza($result,$hiba){
echo '<!DOCTYPE HTML>';
echo '<script language="javascript" type="text/javascript">';
if($result==0){//ok
 //$tomb_evho=keres_mit1('backup_ver','backup_ver_id',$_POST['backup_ver_id']);
  echo 'window.top.window.stopok_Upload_tervezes_file(\''.$hiba.'\',\''.$_POST['backup_terv_tipus_id'].'\');';
}else{
  echo 'window.top.window.stop_Upload_tervezes_file("'.$result.'","'.$hiba.'","'.$_POST['backup_terv_tipus_id'].'");';
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